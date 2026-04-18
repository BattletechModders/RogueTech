"""Alias — run the full QuirkChecker port.

`tools/quirkchecker_port.py` is the implementation; this file is the
short memorable name some scripts / documentation already reference.
"""
from __future__ import annotations

import sys
from pathlib import Path

sys.path.insert(0, str(Path(__file__).resolve().parent.parent))

from tools.quirkchecker_port import main  # noqa: E402

if __name__ == "__main__":
    sys.exit(main())
