#!/usr/bin/env python3
"""
One-time repair script: fixes all JSON errors found by validate_json.py.

Handles:
  - JSONC comment stripping (// and /* */ style)
  - Trailing commas before } or ]
  - UTF-8 BOM (reads with utf-8-sig, writes plain utf-8)

Verifies each file parses correctly after fixing, then writes it back.
"""

import json
import re
import sys
from pathlib import Path


def strip_comments(text: str) -> str:
    """Strip // and /* */ comments, respecting string literal boundaries."""
    result = []
    i = 0
    n = len(text)

    while i < n:
        c = text[i]

        if c == '"':
            # consume string literal verbatim, including escape sequences
            result.append(c)
            i += 1
            while i < n:
                c = text[i]
                result.append(c)
                i += 1
                if c == '\\' and i < n:
                    result.append(text[i])
                    i += 1
                elif c == '"':
                    break

        elif c == '/' and i + 1 < n and text[i + 1] == '/':
            # line comment: skip to end of line
            while i < n and text[i] != '\n':
                i += 1

        elif c == '/' and i + 1 < n and text[i + 1] == '*':
            # block comment: skip to */
            i += 2
            while i + 1 < n and not (text[i] == '*' and text[i + 1] == '/'):
                i += 1
            i += 2  # skip the closing */

        else:
            result.append(c)
            i += 1

    return ''.join(result)


def fix_trailing_commas(text: str) -> str:
    """Remove trailing commas immediately before } or ]."""
    # Loop until no more trailing commas remain (handles nested cases)
    pattern = re.compile(r',(\s*[}\]])')
    prev = None
    while prev != text:
        prev = text
        text = pattern.sub(r'\1', text)
    return text


def fix_file(path: Path) -> tuple[bool, str]:
    """
    Fix a single file. Returns (changed, message).
    """
    raw = path.read_text(encoding='utf-8-sig')

    fixed = raw
    if '//' in fixed or '/*' in fixed:
        fixed = strip_comments(fixed)
    fixed = fix_trailing_commas(fixed)

    try:
        json.loads(fixed)
    except json.JSONDecodeError as e:
        return False, f"still invalid after fix: {e}"

    if fixed != raw:
        path.write_text(fixed, encoding='utf-8')
        return True, "fixed"

    return False, "no change needed"


FILES = [
    "Core/CustomAmmoCategories/AIM_settings.json",
    "Core/MonsterMashup/mod_localized_text.json",
    "Core/PanicSystem/mod.json",
    "Core/RolePlayer/Behaviours/role_vtol_backstabber.json",
    "Core/RolePlayer/Old/global.json",
    "Core/RolePlayer/global.json",
    "Core/SizeMatters/mod_localized_text.json",
    "Core/SkillBasedInit/mod_localized_text.json",
    "InstallOptions/CombatLog/CombatLogOff/mod.json",
    "InstallOptions/CombatLog/CombatLogOn/mod.json",
    "InstallOptions/Convoy/CU-ConvoyAI/mod.json",
    "InstallOptions/Convoy/CU-ConvoyManual/mod.json",
    "InstallOptions/Deployment/CU-DeployAsk/mod.json",
    "InstallOptions/Deployment/CU-DeployAutomatic/mod.json",
    "InstallOptions/Deployment/CU-DeployManual/mod.json",
    "InstallOptions/FX/CrystalClear/mod.json",
    "InstallOptions/FogOfWar/LowVisFOWRedraw/mod.json",
    "InstallOptions/FogOfWar/LowVisFOWRedrawOff/mod.json",
    "InstallOptions/GlobalDifficulty/GlobalDifficultyByCompany/settings.json",
    "InstallOptions/GlobalDifficulty/GlobalDifficultyByLegacyCompany/settings.json",
    "InstallOptions/GlobalDifficulty/GlobalDifficultyByPlanets/settings.json",
    "InstallOptions/MapSize/MC-Mapsize-100/settings.json",
    "InstallOptions/MapSize/MC-Mapsize-33/settings.json",
    "InstallOptions/MapSize/MC-Mapsize-66/settings.json",
    "InstallOptions/MapSize/MC-Mapsize-STD/settings.json",
    "InstallOptions/MapSpawnRandomizer/MC-NoRandomizer/settings.json",
    "InstallOptions/MapSpawnRandomizer/MC-Randomizer/settings.json",
    "InstallOptions/MechSort/CU-SortByCbill/mod.json",
    "InstallOptions/MechSort/CU-SortByName/mod.json",
    "InstallOptions/MechSort/CU-SortByNoSort/mod.json",
    "InstallOptions/MechSort/CU-SortByTonnage/mod.json",
    "InstallOptions/NightVision/LowVisNightVisionOff/mod.json",
    "InstallOptions/NightVision/LowVisNightVisionOn/mod.json",
    "InstallOptions/Panic/Panic-FloatieFalse/mod.json",
    "InstallOptions/Panic/Panic-FloatieTrue/mod.json",
    "InstallOptions/Pilots/PilotsProcedural/pilotselectsettings.json",
    "InstallOptions/SupportLances/MC-Default/settings.json",
    "InstallOptions/WarTechIIC/extendedContracts/Attack.json",
    "InstallOptions/WarTechIIC/extendedContracts/Raid.json",
]


def main() -> int:
    root = Path(__file__).parent.parent.parent
    ok = 0
    failed = 0

    for rel in FILES:
        path = root / rel
        changed, msg = fix_file(path)
        status = "FIXED  " if changed else ("ERROR  " if msg.startswith("still") else "OK     ")
        if msg.startswith("still"):
            failed += 1
            print(f"{status} {rel}: {msg}")
        else:
            ok += 1
            print(f"{status} {rel}")

    print(f"\n{ok} files OK, {failed} failed")
    return 1 if failed else 0


if __name__ == "__main__":
    sys.exit(main())
