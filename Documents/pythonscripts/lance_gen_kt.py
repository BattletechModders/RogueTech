import json, copy

path_to_lances = "../../Core/RogueTechCore/Lances/KillTeams"

template = json.loads("""{
  "Description": {
    "Id": "",
    "Name": "",
    "Details": "",
    "Icon": "",
    "Cost": 0,
    "Rarity": 0,
    "Purchasable": false
  },
  "Difficulty": 1,
  "LanceTags": {
    "items": [
      "lance_type_roguetech",
      "lance_killteams"
    ],
    "tagSetSourceFile": "Tags/LanceTags"
  },
  "LanceUnits": []
}""")
    
slot_template = json.loads("""{
    "unitType": "Mech",
    "unitId": "Tagged",
    "unitSimGameID": null,
    "pilotId": "Tagged",
    "pilotSimGameID": null,
    "unitTagSet": {
        "items": [],
        "tagSetSourceFile": "Tags/UnitTags"
    },
    "excludedUnitTagSet": {
        "items": [],
        "tagSetSourceFile": "Tags/UnitTags"
    },
    "pilotTagSet": {
        "items": [],
        "tagSetSourceFile": "Tags/PilotTags"
    },
    "excludedPilotTagSet": {
        "items": [],
        "tagSetSourceFile": "Tags/PilotTags"
    },
    "locked": false
}""")

# tuple (include_tags, exclude_tags)
tags = {}
tags["easy"] = (["unit_killteam", "unit_kt_easy"], ["unit_kt_hard"])
tags["mixed"] = (["unit_killteam"], [])
tags["hard"] = (["unit_killteam", "unit_kt_hard"], ["unit_kt_easy"])

tags["regular"] = (
    ["{CUR_TEAM.faction}", "unit_mech", "unit_bracket_high", "unit_legendary"],
    ["unit_noncombatant", "unit_killteam"]
)

progressionA = [
    ("easy",    "regular",  "regular",  "regular"),
    ("easy",    "regular",  "regular",  "regular"),
    ("mixed",   "regular",  "regular",  "regular"),
    ("mixed",   "hard",     "regular",  "regular"),
    ("mixed",   "hard",     "regular",  "regular"),
    ("mixed",   "hard",     "regular",  "regular"),
    ("mixed",   "hard",     "regular",  "regular"),
    ("mixed",   "hard",     "hard",     "regular"),
    ("mixed",   "hard",     "hard",     "regular"),
    ("mixed",   "hard",     "hard",     "regular"),
    ("mixed",   "hard",     "hard",     "regular"),
    ("mixed",   "hard",     "hard",     "regular")
]

progressionB = [
    ("regular", "regular",  "regular",  "regular"),
    ("regular", "regular",  "regular",  "regular"),
    ("easy",    "regular",  "regular",  "regular"),
    ("easy",    "regular",  "regular",  "regular"),
    ("hard",    "regular",  "regular",  "regular"),
    ("hard",    "easy",     "regular",  "regular"),
    ("hard",    "easy",     "regular",  "regular"),
    ("hard",    "hard",     "regular",  "regular"),
    ("hard",    "hard",     "regular",  "regular"),
    ("hard",    "hard",     "easy",     "regular"),
    ("hard",    "hard",     "easy",     "regular"),
    ("hard",    "hard",     "hard",     "regular")
]

assert len(progressionA) == len(progressionB)
start_diff = 19

def make_lances(progression, indicator):

    for num in range(0, len(progressionA)):
        diff = start_diff + num
        lance = copy.deepcopy(template)

        lance["Difficulty"] = diff
        id = f"lancedef_killteams_d{diff}_{indicator.lower()}"
        lance["Description"]["Id"] = id
        lance["Description"]["Name"] = f"Killteams D{diff} {indicator.upper()}"

        for index in range(0, 4):

            slot = copy.deepcopy(slot_template)

            kind = progression[num][index]
            unit_tags = tags[kind]
            slot["unitTagSet"]["items"] = unit_tags[0]
            slot["excludedUnitTagSet"]["items"] = unit_tags[1]

            if kind == "regular":
                slot["pilotTagSet"]["items"] = ["pilot_npc_high", "pilot_npc_d10"] if diff < 25 else ["pilot_npc_killteamseasy"]
            else:
                slot["pilotTagSet"]["items"] = ["pilot_npc_killteamseasy"] if diff < 25 else ["pilot_npc_killteamshard"]

            lance["LanceUnits"].append(slot)

        with open(f"{path_to_lances}/{id}.json", 'w', newline='\n') as new_file:
            json.dump(lance, new_file, indent=2)
            new_file.write("\n")

make_lances(progressionA, "a")
make_lances(progressionB, "b")
