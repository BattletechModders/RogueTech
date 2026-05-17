#!/usr/bin/env python3
"""
Validates itemCollection CSV files in the RogueTech mod pack.

itemCollection CSVs use a 4-column format:
  item_id, Type, Count, Weight

Every non-empty row must have exactly 4 fields.
Also catches CSV parse errors (unclosed quotes, etc.).

Exit code 0 = clean, non-zero = failures found.
"""

import csv
import sys
from pathlib import Path

EXPECTED_COLUMNS = 4


def validate_csv(path: Path, errors: list[str]) -> None:
    try:
        text = path.read_text(encoding="utf-8-sig")
    except OSError as e:
        errors.append(f"{path}: cannot read: {e}")
        return

    try:
        reader = csv.reader(text.splitlines())
        rows = list(reader)
    except csv.Error as e:
        errors.append(f"{path}: CSV parse error: {e}")
        return

    # Some files open with a collection-definition header row whose first field
    # is the collection ID (matching the filename stem). That row uses a different
    # column layout from data rows, so we skip it.
    stem = path.stem.lower()
    start = 0
    if rows and rows[0] and rows[0][0].lower() == stem:
        start = 1

    for lineno, row in enumerate(rows[start:], start + 1):
        # Skip truly empty lines
        if not any(field.strip() for field in row):
            continue
        if len(row) != EXPECTED_COLUMNS:
            errors.append(
                f"{path}:{lineno}: expected {EXPECTED_COLUMNS} columns, got {len(row)}"
            )


def main() -> int:
    root = Path(__file__).parent.parent.parent
    errors: list[str] = []
    total = 0

    for csv_file in sorted(root.rglob("*.csv")):
        # Skip hidden dirs (e.g. .git)
        if any(part.startswith(".") for part in csv_file.parts):
            continue
        # Only validate itemCollection CSVs — VersionManifest.csv and similar
        # auto-generated game files use a completely different schema.
        name_lower = csv_file.name.lower()
        if not name_lower.startswith("itemcollection") and not name_lower.startswith("rt_"):
            continue
        total += 1
        validate_csv(csv_file, errors)

    if errors:
        print(f"FAILED — {len(errors)} error(s) across {total} CSV files:\n")
        for err in errors:
            print(f"  {err}")
        return 1

    print(f"OK — {total} itemCollection CSV files passed validation")
    return 0


if __name__ == "__main__":
    sys.exit(main())
