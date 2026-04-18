"""Portable Python replacement for `Documents/BTJsonIDCheck.exe`.

Replicates the check performed by the original .NET WinForms tool:

    for every *.json file below the source directory:
        id = json["Description"]["Id"]
        if id is present and id != filename_without_extension:
            report as mismatch

The original was a 12 KB .NET/Mono WinForms assembly, compiled from
`C:\\Games\\steamapps\\common\\BATTLETECH\\BTJsonIDCheck\\...` (source
path is embedded in the PDB reference). No matching source is in-tree
on this repo. See `docs/reference/btjsonidcheck-evidence.md` for the
string-literal evidence lifted out of the .exe that confirms the
algorithm above.

Runs on Linux + macOS + Windows from source.

Usage:
    python3 tools/btjsonid_check.py           # walk repo, print report
    python3 tools/btjsonid_check.py --count   # emit integer count only
"""
from __future__ import annotations

import argparse
import json
from dataclasses import dataclass, field
from pathlib import Path

REPO_ROOT = Path(__file__).resolve().parent.parent
SKIP_DIRS = {".git", "node_modules", ".pytest_cache", "__pycache__", "tests"}


@dataclass
class IDMismatch:
    path: Path
    declared_id: str
    filename_stem: str


@dataclass
class IDReport:
    mismatches: list[IDMismatch] = field(default_factory=list)
    files_checked: int = 0


def _iter_json(root: Path):
    for p in root.rglob("*.json"):
        if any(part in SKIP_DIRS for part in p.parts):
            continue
        # Only files that look like typed game data (have Description.Id).
        yield p


def check(root: Path = REPO_ROOT) -> IDReport:
    rpt = IDReport()
    for p in _iter_json(root):
        try:
            data = json.loads(p.read_text(encoding="utf-8"))
        except Exception:
            continue  # parse failures are a separate concern
        if not isinstance(data, dict):
            continue
        desc = data.get("Description")
        if not isinstance(desc, dict):
            continue
        ident = desc.get("Id")
        if not isinstance(ident, str) or not ident:
            continue
        rpt.files_checked += 1
        stem = p.stem
        if ident != stem:
            rpt.mismatches.append(IDMismatch(p, ident, stem))
    return rpt


def main(argv: list[str] | None = None) -> int:
    ap = argparse.ArgumentParser(description=__doc__)
    ap.add_argument("--root", type=Path, default=REPO_ROOT)
    ap.add_argument("--count", action="store_true")
    args = ap.parse_args(argv)
    rpt = check(args.root)
    if args.count:
        print(len(rpt.mismatches))
        return 0
    print(f"checked {rpt.files_checked} files; {len(rpt.mismatches)} id-mismatches")
    for m in rpt.mismatches[:25]:
        print(f"  {m.path.relative_to(args.root)}  Id={m.declared_id!r}  stem={m.filename_stem!r}")
    return 0


if __name__ == "__main__":
    raise SystemExit(main())
