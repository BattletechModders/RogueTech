# `quickCheckerSample/`

Samples captured from `Core/QuirkChecker/QuirkChecker.exe` to validate
the input→output mapping for sub-phase 1C.2.

Read [`mapping.md`](mapping.md) for the derived algorithm and the
proof that a Python re-implementation produces byte-identical output.

## Headline

```
input  : every *.json under the repo root
output : newline-separated list of chassisdef_*.json basenames that
         have a non-empty FixedEquipment[] but none of whose
         ComponentDefIDs appear in the set of <configured_category>
         quirk IDs.
```

On the current repo, the tool outputs exactly two names
(`chassisdef_barghest_BGS-DBG.json`, `chassisdef_elemental_manticore.json`).

## Files

- `mapping.md` — the algorithm, derived from bytecode + validated.
- `quirks.ndjson` — 134 discovered quirks.
- `chassis_decisions.ndjson` — 7,088 per-chassis decisions.
- `equipment_pairs.ndjson` — 10,000 (chassis, FixedEquipment entry)
  pairs with `is_quirk` flag; all 7,085 positive matches included.
- `tool_output.txt` — canonical output (Python port).
- `tool_output.reference.txt` — original .exe output (byte-identical).
