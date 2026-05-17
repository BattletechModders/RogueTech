#!/usr/bin/env python3
"""
Validates all JSON files in the RogueTech mod pack.

Checks:
  1. Every .json file is syntactically valid
  2. Known BattleTech def types have their required top-level fields
  3. Description blocks (where present) contain Id and Name

Exit code 0 = clean, non-zero = failures found.
"""

import json
import os
import sys
from pathlib import Path

# Required top-level fields keyed by filename prefix.
# Derived from observed BattleTech / ModTek schema conventions.
REQUIRED_FIELDS: dict[str, list[str]] = {
    "mechdef":            ["Description", "ChassisID", "Locations", "inventory"],
    "chassisdef":         ["Description", "Tonnage", "Locations"],
    "vehicledef":         ["Description", "ChassisID", "Locations"],
    "vehiclechassisdef":  ["Description", "Tonnage", "Locations"],
    "starsystemdef":      ["Description", "Position"],
    "lancedef":           ["Description", "LanceUnits"],
    "pilot":              ["Description", "BaseGunnery", "BasePiloting", "BaseGuts", "BaseTactics"],
    "event":              ["Description", "Options"],
    "turretdef":          ["Description", "ChassisID"],
    "turretchassisdef":   ["Description", "Tonnage"],
}

MOD_JSON_REQUIRED = ["Name"]  # Enabled/Active varies by ModTek version; Version often omitted in bundled mods


def file_prefix(name: str) -> str:
    """Return the lowercase prefix before the first underscore."""
    return name.split("_")[0].lower()


def check_description(data: dict, path: str, errors: list[str]) -> None:
    desc = data.get("Description")
    if not isinstance(desc, dict):
        return
    for field in ("Id", "Name"):
        if field not in desc:
            errors.append(f"{path}: Description missing '{field}'")


def validate_file(path: Path, errors: list[str]) -> bool:
    try:
        # utf-8-sig strips BOM if present, falls back cleanly for regular utf-8
        text = path.read_text(encoding="utf-8-sig")
    except OSError as e:
        errors.append(f"{path}: cannot read: {e}")
        return False

    try:
        data = json.loads(text)
    except json.JSONDecodeError as e:
        errors.append(f"{path}: invalid JSON: {e}")
        return False

    if not isinstance(data, dict):
        return True  # arrays/scalars at root are valid for some config files

    name = path.name.lower()

    if name == "mod.json":
        # Settings-only fragments (no manifest keys) are install-option overrides, not full mods
        manifest_keys = {"Name", "Enabled", "Active", "DLL", "Manifest", "DependsOn"}
        if data.keys() & manifest_keys:
            for field in MOD_JSON_REQUIRED:
                if field not in data:
                    errors.append(f"{path}: mod.json missing required field '{field}'")
        return True

    prefix = file_prefix(name)
    # Files in tags/ directories are tag definitions, not game object defs —
    # they share naming prefixes (e.g. pilot_*) but have a different flat schema.
    in_tags_dir = "tags" in [p.lower() for p in path.parts]
    required = None if in_tags_dir else REQUIRED_FIELDS.get(prefix)
    if required:
        for field in required:
            if field not in data:
                errors.append(f"{path}: missing required field '{field}'")
        check_description(data, str(path), errors)

    return True


def main() -> int:
    root = Path(__file__).parent.parent.parent
    errors: list[str] = []
    total = 0

    for json_file in sorted(root.rglob("*.json")):
        # Skip hidden dirs (e.g. .git)
        if any(part.startswith(".") for part in json_file.parts):
            continue
        total += 1
        validate_file(json_file, errors)

    if errors:
        print(f"FAILED — {len(errors)} error(s) across {total} files:\n")
        for err in errors:
            print(f"  {err}")
        return 1

    print(f"OK — {total} JSON files passed validation")
    return 0


if __name__ == "__main__":
    sys.exit(main())
