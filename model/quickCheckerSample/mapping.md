# QuirkChecker — input/output mapping

This folder documents what `Core/QuirkChecker/QuirkChecker.exe` does, so
that sub-phase 1C.2's Python replacement (`tools/quirk_check.py`) can
stop being a stub. The mapping was derived two ways:

1. **Decompilation** of the embedded Spring Boot jar (the .exe is an
   18 MB Launch4j wrapper around `roguetech-quirk-checker 1.0.0-SNAPSHOT`,
   Java 14, Maven-built, 2020-07-03). `javap -p -c` of three classes
   gives the full algorithm. See **Algorithm** below.
2. **Empirical validation**. `tools/quirkchecker_port.py` re-implements
   the algorithm in Python and produces the **byte-identical** output
   file as the original .exe when run on the current repo. See
   `tool_output.txt` vs `tool_output.reference.txt` in this folder.

## Files in this folder

| File | Rows | Contents |
|---|---|---|
| `quirks.ndjson` | 134 | Every quirk discovered by the scan (one per line): `{id, path}` |
| `chassis_decisions.ndjson` | 7,088 | Every chassis evaluated: `{filename, path, num_fixed_equipment, matched_quirk_id, pass}` |
| `equipment_pairs.ndjson` | 10,000 | (chassis, FixedEquipment-entry) pairs: `{chassis, chassis_path, equipment_index, component_def_id, is_quirk}`. All 7,085 positive matches are included; 2,915 negatives are randomly sampled for breadth. |
| `tool_output.txt` | 2 | Canonical tool output — Python port. |
| `tool_output.reference.txt` | 2 | Original .exe's output. Byte-identical to `tool_output.txt`. |

## Inputs (what the tool reads)

- Every `*.json` under the configured `source-directory` (default: repo
  root).
- The algorithm partitions them into two buckets:
  - **Mech-chassis files.** Filename starts with `chassisdef` **AND**
    the absolute path contains **none** of these substrings:
    `CustomUnits`, `\wip\`, `TARGETDUMMY`, `REP-ME`.
    (The `\wip\` blacklist uses backslashes; on Linux the equivalent
    check against `/wip/` gives identical coverage.)
  - **Everything else.** Quirk-candidate files.

## Algorithm

### Pass 1 — discover quirks (`QuirkFinderService.findQuirks`)

For each non-chassis JSON:

```
if file.json.Custom is None:                                 skip
if file.json.Custom.Category is None:                        skip
if not any(entry.CategoryID == <configured_quirk_category>
           for entry in file.json.Custom.Category):          skip
quirk_id = file.json.Description.Id
quirks.add(quirk_id)
```

`<configured_quirk_category>` defaults to `PositiveQuirk` and is set by
`application.properties` next to the .exe:

```properties
battletech.quirk.quirk-category=PositiveQuirk
```

Result on the current repo: **134 quirks**, see `quirks.ndjson`.

### Pass 2 — check every mech-chassis file (`QuirkCheckerService.handleChassis`)

```
equipment = chassis.json.FixedEquipment
if equipment is None or len(equipment) == 0:    pass (no requirement)
for entry in equipment:
    if entry.ComponentDefID in quirks:
        pass (and stop)
else:
    fail — add basename(chassis.path) to missingQuirkChassis
```

Result on the current repo: **2 chassis fail**:

- `chassisdef_barghest_BGS-DBG.json` (2 FixedEquipment entries, none a quirk)
- `chassisdef_elemental_manticore.json` (21 FixedEquipment entries, none a quirk)

Both are under `Core/CustomActivatableEquipment/ExperimentalGear/chassis/`.
You can verify in `chassis_decisions.ndjson` by grepping `"pass": false`.

### Output (`FileWritingService.writeReportFile`)

Writes `quirk_checker_result.txt` to `output-directory`. Contents:

- **Empty file** if every chassis passed.
- Otherwise: one `chassisdef_*.json` basename per line, sorted
  lexicographically (Java `SortedSet`), trailing newline.

The report has no other fields, no JSON structure, no delimiters
beyond newlines. The tool does **not** write any other file.

## Mapping, as a relational tuple

```
input_chassis ──has──▶ FixedEquipment[n] ──ComponentDefID──▶ quirk_id

(input_chassis, equipment_entry_i, component_def_id, is_quirk) :
  is_quirk  ⇔  component_def_id ∈ { q.Description.Id |
                                     q.Custom.Category[*].CategoryID
                                     == <configured_quirk_category> }
```

A chassis appears in the output iff:

- at least one FixedEquipment entry exists, **and**
- for every entry, `(chassis, i, component_def_id, is_quirk=False)`.

Equivalently, a chassis passes iff the set of its `component_def_id`s
**intersects** the quirk set. The tool cares only about existence of
the intersection — it does not report which quirk matched.

## Confidence

- Algorithm: lifted from compiled bytecode of the shipped .exe.
- Counts match exactly (134 quirks, 7088 chassis, 2 missing).
- Output: byte-identical to the original tool on the current repo.

See `tools/quirkchecker_port.py` for the Python re-implementation and
`tools/build_quirk_sample.py` for the script that regenerates this
folder.

## How to reproduce

```bash
# Run the original .exe (needs wine on Linux, or extract the embedded jar):
python3 -c "
import sys
d = open('Core/QuirkChecker/QuirkChecker.exe', 'rb').read()
open('/tmp/QuirkChecker.jar', 'wb').write(d[d.find(b'PK\\x03\\x04'):])
"
java -jar /tmp/QuirkChecker.jar

# Run the Python port:
python3 tools/quirkchecker_port.py --output-directory /tmp/qc-py
diff /tmp/quirk_checker_result.txt /tmp/qc-py/quirk_checker_result.txt

# Regenerate this folder:
PYTHONPATH=. python3 tools/build_quirk_sample.py
```
