import json, math, copy, traceback, os

path = "RogueTech/Core/MissionControl/config/AdditionalLances/"

for diff in range(1, 50+1):

    file_path = path + "Difficulty" + str(diff) + ".json"
    diff_config = {}

    with open(file_path) as json_file:
        diff_config = json.load(json_file)

    ally_lances = []
    opfor_lances = []

    if diff < 4:
        ally_lances = ["Standard_MCSupport", "Damaged_Lightly_MCSupport", "Damaged_Heavily_MCSupport"]
        opfor_lances = ["Standard_MCSupport", "Damaged_Lightly_MCSupport", "Damaged_Heavily_MCSupport"]
    elif diff < 8:
        ally_lances = ["Standard_MCSupport", "Damaged_Lightly_MCSupport"]
        opfor_lances = ["Standard_MCSupport", "Damaged_Lightly_MCSupport"]
    elif diff < 12:
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

    diff_config["Allies"]["Max"] = 1
    diff_config["Enemy"]["Max"] = 1 if diff < 10 else 2 

    # .5 .45 .4 .3 ... .05 .01 .01 .01
    diff_config["Allies"]["ChanceToSpawn"] = round(max(0.01, 0.5 - 0.05*(diff-1)), ndigits=3)

    if diff < 10:
        diff_config["Enemy"]["ChanceToSpawn"] = round(0.1 + 0.05*(diff-1), ndigits=3)
    else:
        diff_config["Enemy"]["ChanceToSpawn"] = round(0.25 + 0.05*(diff-10), ndigits=3)

    with open(file_path, 'w', newline='\r\n') as new_file:
        json.dump(diff_config, new_file, indent=2)
