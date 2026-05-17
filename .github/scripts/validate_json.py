#!/usr/bin/env python3
"""
Validates all JSON files in the RogueTech mod pack.

Checks:
  1. Every .json file is syntactically valid
  2. No duplicate keys within a single JSON object
  3. Known BattleTech def types have their required top-level fields
  4. Description blocks (where present) contain Id and Name
  5. Description.Id is unique across files of the same def type
     (excludes advancedjsonmerge/ patches, which intentionally share IDs)

Exit code 0 = clean, non-zero = failures found.
"""

import json
import sys
from collections import defaultdict
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


def _make_dup_key_hook(dup_collector: list[str]):
    """Returns an object_pairs_hook that appends any duplicate keys to dup_collector."""
    def hook(pairs: list[tuple[str, object]]) -> dict:
        seen: set[str] = set()
        result: dict = {}
        for key, value in pairs:
            if key in seen:
                dup_collector.append(key)
            seen.add(key)
            result[key] = value
        return result
    return hook


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


def validate_file(
    path: Path,
    errors: list[str],
    id_registry: dict[str, dict[str, list[str]]],
) -> bool:
    try:
        # utf-8-sig strips BOM if present, falls back cleanly for regular utf-8
        text = path.read_text(encoding="utf-8-sig")
    except OSError as e:
        errors.append(f"{path}: cannot read: {e}")
        return False

    dup_keys: list[str] = []
    try:
        data = json.loads(text, object_pairs_hook=_make_dup_key_hook(dup_keys))
    except json.JSONDecodeError as e:
        errors.append(f"{path}: invalid JSON: {e}")
        return False

    if dup_keys:
        errors.append(f"{path}: duplicate JSON keys: {sorted(set(dup_keys))}")

    if not isinstance(data, dict):
        return True  # arrays/scalars at root are valid for some config files

    name = path.name.lower()
    parts_lower = [p.lower() for p in path.parts]

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
    in_tags_dir = "tags" in parts_lower
    required = None if in_tags_dir else REQUIRED_FIELDS.get(prefix)
    if required:
        for field in required:
            if field not in data:
                errors.append(f"{path}: missing required field '{field}'")
        check_description(data, str(path), errors)

        # Register Description.Id for cross-file duplicate check.
        # Skip advancedjsonmerge/ patches — they intentionally share IDs with the defs they patch.
        if "advancedjsonmerge" not in parts_lower:
            desc = data.get("Description")
            if isinstance(desc, dict):
                id_val = desc.get("Id")
                if isinstance(id_val, str) and id_val:
                    id_registry[prefix][id_val].append(str(path))

    return True


def main() -> int:
    root = Path(__file__).parent.parent.parent
    errors: list[str] = []
    total = 0
    id_registry: dict[str, dict[str, list[str]]] = defaultdict(lambda: defaultdict(list))

    for json_file in sorted(root.rglob("*.json")):
        # Skip hidden dirs (e.g. .git)
        if any(part.startswith(".") for part in json_file.parts):
            continue
        total += 1
        validate_file(json_file, errors, id_registry)

    # Cross-file duplicate Description.Id check
    for prefix in sorted(id_registry):
        for id_val, paths in sorted(id_registry[prefix].items()):
            if len(paths) > 1:
                filenames = [Path(p).name for p in paths]
                errors.append(
                    f"Duplicate Description.Id '{id_val}' ({prefix}) in {len(paths)} files: {filenames}"
                )

    if errors:
        print(f"FAILED — {len(errors)} error(s) across {total} files:\n")
        for err in errors:
            print(f"  {err}")
        return 1

    print(f"OK — {total} JSON files passed validation")
    return 0


if __name__ == "__main__":
    sys.exit(main())
