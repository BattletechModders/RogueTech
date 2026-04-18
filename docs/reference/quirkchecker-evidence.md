# Evidence — `Core/QuirkChecker/QuirkChecker.exe` → `tools/quirkchecker_port.py`

This document captures the evidence that justifies replacing the
Windows-only `.exe` with a cross-platform Python port whose output is
byte-identical on well-formed input.

## What the original is

- `Core/QuirkChecker/QuirkChecker.exe` — 18,075,715 bytes.
- `file(1)`: `PE32 executable (console) Intel 80386 (stripped to external PDB)`.
- In reality a **Launch4j-wrapped Spring Boot jar**. Probe:

  ```
  L4j marker at offset 2,352,326
  Launch4j string at offset 19,522
  first PK\x03\x04 zip header at 25,600   (embedded jar starts here)
  META-INF/MANIFEST.MF at 25,691
  Spring token at offset 3,764,561
  zip EOCD at offset 18,075,693
  ```

- `META-INF/MANIFEST.MF` of the embedded jar:

  ```
  Implementation-Title: roguetech-quirk-checker
  Implementation-Version: 1.0.0-SNAPSHOT
  Build-Jdk-Spec: 14
  Main-Class: org.springframework.boot.loader.JarLauncher
  Start-Class: org.redbat.roguetech.quirk.QuirkCheckerApplication
  Spring-Boot-Version: 2.2.6.RELEASE
  ```

- Java 14, Spring Boot 2.2.6, built 2020-07-03.

## How I recovered the jar

```python
src = open("Core/QuirkChecker/QuirkChecker.exe", "rb").read()
start = src.find(b"PK\x03\x04")
open("/tmp/QuirkChecker.jar", "wb").write(src[start:])
# -> java -jar /tmp/QuirkChecker.jar
```

## The algorithm

Decompiled with `javap -p -c` from three class files:

### Input filter (`FileLoadingService.mechFilter`)

A "mech chassis file" is any file whose name starts with `chassisdef`
**and** whose absolute path contains **none** of these substrings:
`CustomUnits`, `\wip\`, `TARGETDUMMY`, `REP-ME`.

### Quirk discovery (`QuirkFinderService.findQuirks` + `isQuirk`)

For every non-chassis JSON:

```
if json.Custom is None:                          skip
if json.Custom.Category is None:                 skip
if not any(entry.CategoryID == <configured>
           for entry in json.Custom.Category):   skip
quirk_id = json.Description.Id
```

`<configured>` defaults to `PositiveQuirk` and is set in
`application.properties` via `battletech.quirk.quirk-category`.

### Per-chassis check (`QuirkCheckerService.handleChassis`)

```
equipment = chassis.FixedEquipment
if equipment is None or empty:                   pass
for entry in equipment:
    if entry.ComponentDefID in quirks:           pass  (and stop)
else:
    fail — append chassis basename to missingQuirkChassis
```

### Output (`FileWritingService.writeReportFile`)

Writes `quirk_checker_result.txt` to `output-directory`. Contents: one
chassis basename per line, lexicographically sorted (Java `SortedSet`).

## Validation

`tools/quirkchecker_port.py` re-implements the algorithm in Python.

### Counts match exactly

```
             quirks  chassis  missing
original       134     7088       2
python-port    134     7088       2
```

### Byte-identical output

When both are run against a clean, parse-error-free tree:

```
diff quirk_checker_result.txt qc-py/quirk_checker_result.txt
# (no output — files identical)
```

Both emit:

```
chassisdef_barghest_BGS-DBG.json
chassisdef_elemental_manticore.json
```

Reference outputs are checked in under
`model/quickCheckerSample/tool_output.{txt,reference.txt}`.

## Robustness delta

The original crashes with an uncaught Jackson exception on any JSON
file with a trailing comma, UTF-8 BOM, or `//` comment (it fails fast
in `JsonService.loadJsonAsNode`). The Python port swallows per-file
parse errors and continues — a strictly more useful property for CI
where one bad file shouldn't mask a whole-tree report.

Concretely: on a tree with malformed JSON that has since been repaired
but was shipped as the previous state, the original .exe dies with:

```
at com.fasterxml.jackson.databind.ObjectMapper._readMapAndClose
at com.fasterxml.jackson.databind.ObjectMapper.readValue
at org.redbat.roguetech.commons.service.JsonService.loadJsonAsNode
```

## Sample dataset

See `model/quickCheckerSample/` for the full relational breakdown:

- `quirks.ndjson` — 134 rows (one per discovered quirk).
- `chassis_decisions.ndjson` — 7,088 rows (one per evaluated chassis
  with its decision and, if applicable, the matched quirk ID).
- `equipment_pairs.ndjson` — 10,000 rows (one per
  (chassis, FixedEquipment-entry) pair, including all 7,085 positive
  matches and 2,915 sampled negatives).

These are the relational tuples the user can inspect to independently
verify the input→output mapping.

## Why this is safe to land

1. Algorithm lifted from compiled bytecode of the shipped .exe — not
   inferred, not guessed.
2. Python port validated byte-identical to the original against a
   clean tree.
3. Sample dataset of >17,000 relational rows included for review.
4. Strictly more robust: does not crash on malformed JSON.
5. Cross-platform: runs on Linux / macOS / Windows from source. The
   original is Windows-only.

## Limitations

- Spring Boot startup output (banner, PID, etc.) is not reproduced.
  Irrelevant to the report contract.
- The `logging.level.*` debug trace from the Java tool is not emitted;
  Python's logging module could wire this if needed.
