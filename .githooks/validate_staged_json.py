#!/usr/bin/env python3
"""Called by the pre-commit hook. Receives staged JSON file paths as arguments."""

import json
import sys
from pathlib import Path

files = sys.argv[1:]
errors = []
for f in files:
    p = Path(f)
    if not p.exists():
        continue
    try:
        json.loads(p.read_text(encoding="utf-8-sig"))
    except json.JSONDecodeError as e:
        errors.append(f"{f}: {e}")

if errors:
    print(f"pre-commit: {len(errors)} invalid JSON file(s):")
    for e in errors:
        print(f"  {e}")
    sys.exit(1)

print(f"pre-commit: {len(files)} staged JSON file(s) valid")
