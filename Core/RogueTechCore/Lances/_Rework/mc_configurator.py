import json, math, copy, traceback, os

path = "RogueTech/Core/MissionControl/config/AdditionalLances/"

for diff in range(1, 50+1):

    file_path = path + "Difficulty" + str(diff) + ".json"
    diff_config = {}

    with open(file_path) as json_file:
        diff_config = json.load(json_file)

    ally_lances = []
    opfor_lances = []

    if diff < 5:
        ally_lances = ["Damaged_Lightly_MCSupport", "Damaged_Heavily_MCSupport"]
        opfor_lances = ["Damaged_Lightly_MCSupport", "Damaged_Heavily_MCSupport"]
    elif diff < 10:
        ally_lances = ["Standard_MCSupport", "Damaged_Lightly_MCSupport"]
        opfor_lances = ["Standard_MCSupport", "Damaged_Lightly_MCSupport"]
    elif diff < 15:
        ally_lances = ["Standard_MCSupport"]
        opfor_lances = ["Standard_MCSupport", "Standard_Support"]
    else:
        ally_lances = ["Standard_MCSupport"]
        opfor_lances = ["Standard_MCSupport", "Standard_Support", "Standard_Fire"]

    diff_config["LancePool"] = {}
    diff_config["Enemy"]["LancePool"] = {}
    diff_config["Enemy"]["LancePool"]["ALL"] = opfor_lances
    diff_config["Allies"]["LancePool"] = {}
    diff_config["Allies"]["LancePool"]["ALL"] = ally_lances

    with open(file_path, 'w', newline='\r\n') as new_file:
        json.dump(diff_config, new_file, indent=2)
