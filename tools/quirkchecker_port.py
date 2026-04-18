"""Python port of `Core/QuirkChecker/QuirkChecker.exe`.

The original is an 18 MB Launch4j-wrapped Spring Boot jar (Java 14,
`org.redbat.roguetech.quirk`). The algorithm was lifted from the
compiled bytecode (see `model/quickCheckerSample/mapping.md`).

This Python port produces the same output and emits per-file sample
records for empirical validation of the input→output mapping.

Config (matches the original's `application.properties`):

    --source-directory      default: repo root
    --output-directory      default: current working directory
    --quirk-category        default: PositiveQuirk

Outputs (in output-directory):

    quirk_checker_result.txt    newline-separated chassisdef_*.json basenames
                                that did not reference any known quirk in
                                FixedEquipment[].ComponentDefID
"""
from __future__ import annotations

import argparse
import json
import sys
from dataclasses import dataclass, field
from pathlib import Path

REPO_ROOT = Path(__file__).resolve().parent.parent


# -- file filters (ported from FileLoadingService.mechFilter) --------------

def is_mech_chassis_file(path: Path) -> bool:
    """True iff `chassisdef*` filename AND path excludes the four blacklists."""
    name = path.name
    if not name.startswith("chassisdef"):
        return False
    abspath = str(path.resolve())
    # Original uses backslashes `\\wip\\` — i.e. Windows path convention. On
    # Linux we check forward-slash `/wip/`; behavior is equivalent.
    blacklist = ("CustomUnits", "/wip/", "\\wip\\", "TARGETDUMMY", "REP-ME")
    return not any(b in abspath for b in blacklist)


# -- quirk detection (ported from QuirkFinderService) ----------------------

def is_quirk(data: dict, quirk_category: str) -> bool:
    """True iff Custom.Category has an entry with CategoryID == quirk_category."""
    if not isinstance(data, dict):
        return False
    custom = data.get("Custom")
    if not isinstance(custom, dict):
        return False
    categories = custom.get("Category")
    if not isinstance(categories, list):
        return False
    for entry in categories:
        if not isinstance(entry, dict):
            continue
        cid = entry.get("CategoryID")
        if isinstance(cid, str) and cid == quirk_category:
            return True
    return False


def quirk_id(data: dict) -> str | None:
    """Description.Id of a quirk file, or None."""
    desc = data.get("Description") if isinstance(data, dict) else None
    if not isinstance(desc, dict):
        return None
    ident = desc.get("Id")
    return ident if isinstance(ident, str) else None


# -- main algorithm --------------------------------------------------------

@dataclass
class ChassisDecision:
    filename: str
    path: str
    num_fixed_equipment: int
    matched_quirk_id: str | None  # first quirk ID found; None if missing
    pass_: bool


@dataclass
class QuirkCheckerResult:
    quirks_found: list[dict] = field(default_factory=list)  # {id, path}
    chassis_decisions: list[ChassisDecision] = field(default_factory=list)
    missing_quirk_chassis: list[str] = field(default_factory=list)


def run(
    source_directory: Path,
    quirk_category: str = "PositiveQuirk",
) -> QuirkCheckerResult:
    """Produce a QuirkCheckerResult mirroring the original tool."""
    result = QuirkCheckerResult()
    quirk_ids: set[str] = set()

    # Pass 1 — discover quirks
    # The original's JsonLoadService loads *all* JSON under source; we do the
    # same. (22,304 files in the real repo.)
    for p in source_directory.rglob("*.json"):
        if ".git" in p.parts or "tests" in p.parts:
            continue
        if is_mech_chassis_file(p):
            continue  # chassis files are not candidates (they're loaded in a
                     # separate pass by the original; see loadMechChassisFiles)
        try:
            data = json.loads(p.read_text(encoding="utf-8"))
        except Exception:
            continue
        if not is_quirk(data, quirk_category):
            continue
        qid = quirk_id(data)
        if qid is None:
            continue
        quirk_ids.add(qid)
        result.quirks_found.append({"id": qid, "path": str(p.relative_to(source_directory))})

    # Pass 2 — check every chassis
    for p in source_directory.rglob("chassisdef*.json"):
        if not is_mech_chassis_file(p):
            continue
        try:
            data = json.loads(p.read_text(encoding="utf-8"))
        except Exception:
            continue
        equipment = data.get("FixedEquipment") if isinstance(data, dict) else None
        matched: str | None = None
        num_eq = 0
        if isinstance(equipment, list) and equipment:
            num_eq = len(equipment)
            for entry in equipment:
                if not isinstance(entry, dict):
                    continue
                cdid = entry.get("ComponentDefID")
                if isinstance(cdid, str) and cdid in quirk_ids:
                    matched = cdid
                    break
        # The original: if equipment is null/empty -> pass (no requirement).
        passed = (num_eq == 0) or (matched is not None)
        result.chassis_decisions.append(ChassisDecision(
            filename=p.name,
            path=str(p.relative_to(source_directory)),
            num_fixed_equipment=num_eq,
            matched_quirk_id=matched,
            pass_=passed,
        ))
        if not passed:
            result.missing_quirk_chassis.append(p.name)

    result.missing_quirk_chassis.sort()  # SortedSet in Java
    return result


def write_output(result: QuirkCheckerResult, output_directory: Path) -> None:
    output_directory.mkdir(parents=True, exist_ok=True)
    (output_directory / "quirk_checker_result.txt").write_text(
        "\n".join(result.missing_quirk_chassis) + ("\n" if result.missing_quirk_chassis else ""),
        encoding="utf-8",
    )


def main(argv: list[str] | None = None) -> int:
    ap = argparse.ArgumentParser(description=__doc__)
    ap.add_argument("--source-directory", type=Path, default=REPO_ROOT)
    ap.add_argument("--output-directory", type=Path, default=Path.cwd())
    ap.add_argument("--quirk-category", type=str, default="PositiveQuirk")
    args = ap.parse_args(argv)
    result = run(args.source_directory, args.quirk_category)
    print(f"chassis: {len(result.chassis_decisions)}", file=sys.stderr)
    print(f"quirks: {len(result.quirks_found)}", file=sys.stderr)
    print(f"missing: {len(result.missing_quirk_chassis)}", file=sys.stderr)
    write_output(result, args.output_directory)
    return 0


if __name__ == "__main__":
    sys.exit(main())
