import json, copy

patchdef_template = json.loads("""{
    "version" : 1,
    "patches" : []
}""")

patch_base = json.loads("""{
    "targetFile" : "Core/MissionControl/config/AdditionalLances/Difficulty1.json",
    "priority" : 20,
    "patch" : {
        "Enemy": {
            "Max": 0,
            "ChanceToSpawn": 0.0
        }
    }
}""")

patchdef_template_kt = json.loads("""{
    "version" : 1,
    "patches" : [
        {
            "targetFile" : "Core/MissionControl/settings.json",
            "priority" : 20,
            "arrayHandle" : "Replace",
            "patch" : {
                "AdditionalLances": {
                    "Enable": true,
                    "ExcludeContractTypes": [
                        "SoloDuel",
                        "DuoDuel"
                    ],
                    "IsPrimaryObjectiveIn": [
                        "SimpleBattle",
                        "CaptureBase"
                    ]
                }
            }
        }
    ]
}""")

patch_base_kt = json.loads("""{
    "targetFile" : "Core/MissionControl/config/AdditionalLances/Difficulty1.json",
    "priority" : 20,
    "arrayHandle" : "Replace",
    "patch" : {
        "Enemy": {
            "Max": 1,
            "ChanceToSpawn": 2.0,
            "LancePool": {
                "ALL": [
                    "Mixed_Battle_KillTeams"
                ]
            }
        }
    }
}""")

patchdef_hugs = copy.deepcopy(patchdef_template)
patchdef_easy = copy.deepcopy(patchdef_template)
patchdef_kt = copy.deepcopy(patchdef_template_kt)

for diff in range(1, 50+1):

    filepath = "Difficulty" + str(diff) + ".json"
    diff_config = {}

    with open(filepath) as json_file:
        diff_config = json.load(json_file)

    ally_lances = []
    opfor_lances = []

    if diff < 4:
        ally_lances = ["Standard_MCSupport", "Damaged_Lightly_MCSupport", "Damaged_Heavily_MCSupport"]
        opfor_lances = ["Standard_MCSupport", "Damaged_Lightly_MCSupport", "Damaged_Heavily_MCSupport"]
    elif diff < 8:
        ally_lances = ["Standard_MCSupport", "Damaged_Lightly_MCSupport"]
        opfor_lances = ["Standard_MCSupport", "Damaged_Lightly_MCSupport"]
    elif diff < 14:
        ally_lances = ["Standard_MCSupport"]
        opfor_lances = ["Standard_MCSupport", "Standard_Support"]
    else:
        ally_lances = ["Standard_MCSupport"]
        opfor_lances = ["Standard_MCSupport", "Standard_Support", "Standard_Fire"]

    diff_config["LancePool"] = {}
    diff_config["LancePool"]["ALL"] = []
    diff_config["Enemy"]["LancePool"] = {}
    diff_config["Enemy"]["LancePool"]["ALL"] = opfor_lances
    diff_config["Allies"]["LancePool"] = {}
    diff_config["Allies"]["LancePool"]["ALL"] = ally_lances

    diff_config["Enemy"]["EliteLances"] = {}
    diff_config["Allies"]["EliteLances"] = {}

    diff_config["Allies"]["Max"] = 1
    diff_config["Enemy"]["Max"] = 1 if diff < 10 else 2 

    # .5 .45 .4 .35 ... .05 .01 .01 .01
    diff_config["Allies"]["ChanceToSpawn"] = round(max(0.01, 0.5 - 0.05*(diff-1)), ndigits=2)

    if diff < 10:
        diff_config["Enemy"]["ChanceToSpawn"] = round(0.1 + 0.05*(diff-1), ndigits=2)
    else:
        diff_config["Enemy"]["ChanceToSpawn"] = round(0.25 + 0.05*(diff-10), ndigits=2)

    with open(filepath, 'w', newline='\r\n') as new_file:
        json.dump(diff_config, new_file, indent=2)

    # no support
    patch_hugs = copy.deepcopy(patch_base)
    patch_hugs["targetFile"] = "Core/MissionControl/config/AdditionalLances/" + filepath
    patchdef_hugs["patches"].append(patch_hugs)
    
    # max 1 + lower chances 
    patch_easy = copy.deepcopy(patch_base)
    patch_easy["targetFile"] = "Core/MissionControl/config/AdditionalLances/" + filepath
    patch_easy["patch"]["Enemy"]["Max"] = 1
    patch_easy["patch"]["Enemy"]["ChanceToSpawn"] = round(max(0.0, 0.1 + 0.05*(diff-4)), ndigits=2)
    patchdef_easy["patches"].append(patch_easy)
    
    # higher chance max 1 before KTs from 16 onwards
    if diff > 9:
        if diff > 15:
            patch_kt = copy.deepcopy(patch_base_kt)
            patch_kt["targetFile"] = "Core/MissionControl/config/AdditionalLances/" + filepath
        else:
            patch_kt = copy.deepcopy(patch_base)
            patch_kt["targetFile"] = "Core/MissionControl/config/AdditionalLances/" + filepath
            patch_kt["patch"]["Enemy"]["Max"] = 1
            patch_kt["patch"]["Enemy"]["ChanceToSpawn"] = round(0.1 + 0.05*(diff+3), ndigits=2)
        patchdef_kt["patches"].append(patch_kt)

with open("patchdef_hugs.json", 'w', newline='\r\n') as new_file:
        json.dump(patchdef_hugs, new_file, indent=2)

with open("patchdef_easy.json", 'w', newline='\r\n') as new_file:
        json.dump(patchdef_easy, new_file, indent=2)

with open("patchdef_kt.json", 'w', newline='\r\n') as new_file:
        json.dump(patchdef_kt, new_file, indent=2)
