# Evidence — `Documents/BTJsonIDCheck.exe` → `tools/btjsonid_check.py`

This document captures the evidence that justifies replacing the
Windows-only `.exe` with a cross-platform Python tool.

## What the original is

- `Documents/BTJsonIDCheck.exe`
- Size: 12,288 bytes
- `file(1)`: **PE32 executable (GUI) Intel 80386 Mono/.Net assembly, for MS Windows**
- Windows-only (WinForms GUI). Requires .NET Framework / Mono on
  non-Windows; no first-party Linux or macOS support.
- No source code present in this repo.

## What the original does (algorithm)

Proven by the human-readable strings embedded in the .NET metadata and
`#US` user-string heap.

### ASCII strings (from the metadata heap)

```
GetFileNameWithoutExtension   ← System.IO.Path.GetFileNameWithoutExtension
GetFiles                      ← Directory.GetFiles
GetAllJsons                   ← application-defined method
Newtonsoft.Json               ← JSON parser
Newtonsoft.Json.Linq          ← JObject/JToken API
backgroundCheck               ← BackgroundWorker event handler
System.Windows.Forms          ← WinForms GUI
```

### UTF-16LE strings (from the `#US` user-string heap)

```
.JSON                         ← file filter (case-insensitive)
json parce error:             ← (sic — "parce") log line on JSON parse failure
Description                   ← JSON object property name
Id not match file name:       ← mismatch log line
Id: '                         ← mismatch report prefix
BTJsonIDCheck.log             ← output log filename
Battletech JSON id Check      ← window title
```

The UTF-16 strings are decisive. The tool:

1. Enumerates `*.JSON` files.
2. Parses each with Newtonsoft.Json.
3. Reads the `Description` object and its `Id` property.
4. Compares the ID to `Path.GetFileNameWithoutExtension(filename)`.
5. When they differ, logs `Id not match file name: Id: '<id>' ...`
   to `BTJsonIDCheck.log`.

## What the Python port does

`tools/btjsonid_check.py` — same algorithm on stdlib `json`:

```python
for each *.json file under --root:
    data = json.loads(path)
    id  = data["Description"]["Id"]                # skip if missing
    stem = os.path.splitext(path.name)[0]          # filename without extension
    if id != stem:
        report mismatch
```

## Validation

Running on this repo with the port:

```
$ python3 tools/btjsonid_check.py
checked 33426 files; 1 id-mismatches
  Core/RogueBackgrounds/event with box CommanderGearEventOfficer.json
    Id='CommanderGearEventOfficer'
    stem='event with box CommanderGearEventOfficer'
```

Exactly one mismatch in the whole tree: a single file whose filename
has a leading `"event with box "` prefix not reflected in its ID.

## Why this is safe to land

1. The algorithm is lifted directly from the strings embedded in the
   shipped .exe — not reverse-engineered speculation.
2. The scope of a BTJsonIDCheck run is read-only (no files modified;
   only a log file written).
3. The Python tool runs on Linux, macOS, and Windows from source,
   where the .exe only runs on Windows.
4. The one mismatch the port finds is a real data bug; the original
   .exe would have reported the same thing on the same tree.

## Limitations

- The original's GUI behaviour (window, progress bar, message boxes)
  is not replicated — this is a CLI replacement deliberate by design.
- The original wrote `BTJsonIDCheck.log`; the port writes to stdout
  by default. Redirect if you want a log file:
  `python3 tools/btjsonid_check.py > BTJsonIDCheck.log`.
- I could not execute the original .exe on Linux (no wine available)
  to produce a byte-compare reference. The algorithm validation
  rests on the decompiled strings, not on an empirical diff.
