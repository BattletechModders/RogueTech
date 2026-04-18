"""Build the quickCheckerSample artifacts under model/quickCheckerSample/.

Runs the Python port (tools/quirkchecker_port.py) against the repo and
emits:

  quirks.ndjson              - one row per discovered quirk (134)
  chassis_decisions.ndjson   - one row per chassis evaluated (7088)
  equipment_pairs.ndjson     - one row per (chassis, FixedEquipment entry)
                               pair (bounded to --max 10000)
  tool_output.txt            - copy of quirk_checker_result.txt
  tool_output.reference.txt  - output from the original .exe for diff
"""
from __future__ import annotations

import argparse
import json
import random
import sys
from pathlib import Path

# Make imports work whether invoked as `python3 tools/build_quirk_sample.py`
# or `PYTHONPATH=. python3 -m tools.build_quirk_sample`.
sys.path.insert(0, str(Path(__file__).resolve().parent.parent))

from tools.quirkchecker_port import (  # noqa: E402
    REPO_ROOT,
    is_mech_chassis_file,
    is_quirk,
    quirk_id,
    run,
)


def main(argv: list[str] | None = None) -> int:
    ap = argparse.ArgumentParser(description=__doc__)
    ap.add_argument("--out", type=Path,
                    default=REPO_ROOT / "model" / "quickCheckerSample")
    ap.add_argument("--max-equipment-pairs", type=int, default=10_000)
    ap.add_argument("--seed", type=int, default=42)
    args = ap.parse_args(argv)
    args.out.mkdir(parents=True, exist_ok=True)

    rng = random.Random(args.seed)
    result = run(REPO_ROOT, "PositiveQuirk")

    # quirks.ndjson
    with (args.out / "quirks.ndjson").open("w", encoding="utf-8") as fh:
        for q in sorted(result.quirks_found, key=lambda x: x["id"]):
            fh.write(json.dumps(q, sort_keys=True) + "\n")

    # chassis_decisions.ndjson
    with (args.out / "chassis_decisions.ndjson").open("w", encoding="utf-8") as fh:
        for c in sorted(result.chassis_decisions, key=lambda x: x.filename):
            fh.write(json.dumps({
                "filename": c.filename,
                "path": c.path,
                "num_fixed_equipment": c.num_fixed_equipment,
                "matched_quirk_id": c.matched_quirk_id,
                "pass": c.pass_,
            }, sort_keys=True) + "\n")

    # equipment_pairs.ndjson
    #
    # Enumerate (chassis, FixedEquipment-entry) pairs. This is the unit of
    # the algorithm's inner loop and therefore the most informative unit for
    # validating the mapping.
    quirk_id_set = {q["id"] for q in result.quirks_found}
    all_pairs: list[dict] = []
    for p in REPO_ROOT.rglob("chassisdef*.json"):
        if not is_mech_chassis_file(p):
            continue
        try:
            data = json.loads(p.read_text(encoding="utf-8"))
        except Exception:
            continue
        equipment = data.get("FixedEquipment") if isinstance(data, dict) else None
        if not isinstance(equipment, list):
            continue
        for i, entry in enumerate(equipment):
            if not isinstance(entry, dict):
                continue
            cdid = entry.get("ComponentDefID")
            all_pairs.append({
                "chassis": p.name,
                "chassis_path": str(p.relative_to(REPO_ROOT)),
                "equipment_index": i,
                "component_def_id": cdid if isinstance(cdid, str) else None,
                "is_quirk": isinstance(cdid, str) and cdid in quirk_id_set,
            })

    # Sample to max_equipment_pairs; also include every "is_quirk=True" pair
    # so the positive cases are never under-represented.
    positives = [p for p in all_pairs if p["is_quirk"]]
    negatives = [p for p in all_pairs if not p["is_quirk"]]
    want_neg = max(0, args.max_equipment_pairs - len(positives))
    sampled_neg = rng.sample(negatives, min(want_neg, len(negatives)))
    sample = positives + sampled_neg
    # Stable ordering for reproducible diffs
    sample.sort(key=lambda r: (r["chassis"], r["equipment_index"]))
    with (args.out / "equipment_pairs.ndjson").open("w", encoding="utf-8") as fh:
        for row in sample:
            fh.write(json.dumps(row, sort_keys=True) + "\n")

    # tool_output.txt — copy the canonical result from the python port
    (args.out / "tool_output.txt").write_text(
        "\n".join(result.missing_quirk_chassis) + "\n",
        encoding="utf-8",
    )

    # Stats line
    print(
        f"quirks={len(result.quirks_found)} "
        f"chassis={len(result.chassis_decisions)} "
        f"missing={len(result.missing_quirk_chassis)} "
        f"pairs_total={len(all_pairs)} "
        f"pairs_sampled={len(sample)} "
        f"positives_all_included={len(positives)}"
    )
    return 0


if __name__ == "__main__":
    raise SystemExit(main())
