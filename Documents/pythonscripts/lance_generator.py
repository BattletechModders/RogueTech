import json, math, copy, traceback, os

# writes standard dynamic lances for RT Core and Optionals
# run with python3 lance_generator.py
# adjust script, run script, inspect git diff for changes

path_to_lances = "../../Core/RogueTechCore/Lances/"

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
      "lance_type_dynamic"
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

weight_excludes = {}
weight_excludes["light"] = ["unit_assault","unit_heavy","unit_medium"]
weight_excludes["med/light"] = ["unit_assault","unit_heavy"]
weight_excludes["med"] = ["unit_assault","unit_heavy","unit_light"]
weight_excludes["hvy/med"] = ["unit_assault","unit_light"]
weight_excludes["hvy"] = ["unit_assault","unit_medium","unit_light"]
weight_excludes["ass/hvy"] = ["unit_medium","unit_light"]
weight_excludes["ass"] = ["unit_heavy","unit_medium","unit_light"]
weight_excludes["hvy/med/light"] = ["unit_assault"]
weight_excludes["ass/hvy/med/light"] = []

weight_map = [
    ["light","light","light","light"],
    ["med/light","light","light","light"],
    ["med/light","med/light","light","light"],
    ["med","med/light","med/light","light"],
    ["med","med","med/light","light"], #5
    ["med","med","med/light","med/light"], 
    ["hvy/med","med","med","med/light"],
    ["hvy/med","hvy/med","med","med/light"],
    ["hvy","hvy/med","med","med/light"],
    ["hvy","hvy","hvy/med","med/light"], #10
    ["hvy","hvy","hvy/med","hvy/med/light"],
    ["ass/hvy","hvy","hvy/med","hvy/med/light"],
    ["ass/hvy","ass/hvy","hvy","hvy/med/light"],
    ["ass/hvy","ass/hvy","hvy","hvy/med/light"],
    ["ass","ass/hvy","hvy","hvy/med/light"], #15
    ["ass","ass","ass/hvy","ass/hvy/med/light"],
    ["ass","ass","ass/hvy","ass/hvy/med/light"],
    ["ass","ass","ass/hvy","ass/hvy/med/light"],
    ["ass","ass","ass/hvy","ass/hvy/med/light"],
    ["ass","ass","ass/hvy","ass/hvy/med/light"] #20
]

number = 0

def grab_diff_weight_excludes(diff, index):
    return weight_excludes[weight_map[diff-1][index]]

def grab_reduced_tonnage_tags(diff):
    if diff < 8:
        return weight_excludes["light"]
    elif diff < 16:
        return weight_excludes["med/light"]
    else:
        return weight_excludes["hvy/med/light"]

def grab_tonnage_tags_for_weight(weight):
    match weight:
        case "medium":
            return weight_excludes["med"]
        case "heavy":
            return weight_excludes["hvy"]
        case "assault":
            return weight_excludes["ass"]

def grab_unit_include_exclude(index, diff, category, composition, variant, extra):
    include_tags = ["{CUR_TEAM.faction}"]
    exclude_tags = ["unit_noncombatant"]

    if category in ["solo","gladiator"] and index > 0:
        exclude_tags += grab_reduced_tonnage_tags(diff)
    elif extra in ["demolisher"]:
        # no weight excludes for these special lances
        pass
    elif extra in ["medium", "heavy", "assault"]:
        exclude_tags += grab_tonnage_tags_for_weight(extra)
    else:
        exclude_tags += grab_diff_weight_excludes(diff, index)

    match(variant):
        case "low":
            include_tags.append("unit_bracket_low")
        case "med":
            include_tags.append("unit_bracket_med")
        case "high":
            include_tags.append("unit_bracket_high")
        case "primitive":
            # allow low&med with primitive on "high" diff
            if (diff > 6 and index == 3) or (diff > 9 and index == 1):
                exclude_tags.append("unit_bracket_high")
            else: 
                include_tags.append("unit_primitive")
                include_tags.remove("{CUR_TEAM.faction}")

        case "stealth":
            pass
        case "risc":
            pass
        case "urbie":
            pass
        case "command":
            pass

        case "":
            pass
    
        case _:
            print("bad variant: " + str(variant))
            traceback.print_stack()
            print("bad variant: " + str(variant))
            exit()

    match(composition):
        case "mech":
            include_tags.append("unit_mech")

        case "mixed":
            if category != "turret":
                if index in [1,2]:
                    include_tags.append("unit_vehicle")
                else:
                    include_tags.append("unit_mech")
            else:
                include_tags.append("unit_turret")
                if index > 2:
                    include_tags.append("unit_aaa")

        case "vehicle":
            include_tags.append("unit_vehicle")

        # convoys
        case "allied":
            include_tags.append("unit_vehicle")
            include_tags.append("unit_vehicle_apc")

            exclude_tags.remove("unit_noncombatant")
            exclude_tags.append("unit_noconvoy")
            exclude_tags.append("unit_vtol")
            exclude_tags.append("unit_airship")
            exclude_tags.append("unit_hover")
            exclude_tags.append("unit_vbied")
            exclude_tags.append("unit_thumper")
            exclude_tags.append("unit_sniper")
            exclude_tags.append("unit_longtom")
            exclude_tags.append("unit_arrow")
        case "opfor":
            include_tags.append("unit_vehicle")

            exclude_tags.remove("unit_noncombatant")
            exclude_tags.append("unit_noconvoy")
            exclude_tags.append("unit_vtol")
            exclude_tags.append("unit_airship")
            exclude_tags.append("unit_hover")
            exclude_tags.append("unit_vbied")
            exclude_tags.append("unit_thumper")
            exclude_tags.append("unit_sniper")
            exclude_tags.append("unit_longtom")
            exclude_tags.append("unit_arrow")
        case "mechconvoy":
            include_tags.append("unit_mech")
            exclude_tags.append("unit_urbie")
            exclude_tags.append("unit_noconvoy")
            exclude_tags.append("unit_thumper")
            exclude_tags.append("unit_sniper")
            exclude_tags.append("unit_longtom")
            exclude_tags.append("unit_arrow")

        case "carrier":
            if index in [0,1,2]:
                include_tags.append("unit_vehicle")
            elif extra == "vtol":
                include_tags.append("unit_vehicle")
                include_tags.append("unit_vtol")
            else:
                include_tags.append("unit_mech")

        # turrets
        case "standard":
            include_tags.append("unit_turret")
        case "AAA":
            include_tags.append("unit_turret")
            if index < 3:
                include_tags.append("unit_aaa")
        case "artillery":
            if index < 2:
                include_tags.append("unit_artilleryturret")
                include_tags.remove("{CUR_TEAM.faction}")
            else:
                include_tags.append("unit_turret")

        case _:
            print("bad composition: " + str(composition))
            traceback.print_stack()
            print("bad composition: " + str(composition))
            exit()

    if extra == "vtol" and composition != "carrier":
        if "unit_vehicle" in include_tags:
            include_tags.append("unit_vtol")

    match(category):
        case "battle":
            if variant == "risc":
                if  index in [0,1] or diff > 10 and index == 2:
                    include_tags.remove("{CUR_TEAM.faction}")
                    include_tags.append("unit_risc")
            elif variant == "urbie":
                    include_tags.remove("{CUR_TEAM.faction}")
                    include_tags.append("unit_urbie")

                    if "unit_light" in exclude_tags:
                        exclude_tags.remove("unit_light")
            elif extra == "MBT":
                include_tags.append("unit_lance_tank")
            elif extra == "demolisher":
                include_tags.append("unit_demolisher")
            elif extra == "tank" and index == 0:
                include_tags.append("unit_lance_tank")
            elif extra == "vanguard" and index == 0:
                include_tags.append("unit_lance_vanguard")
            elif extra == "cheap" and index == 3:
                if "unit_bracket_high" in include_tags:
                    include_tags.remove("unit_bracket_high")
                if "unit_bracket_med" in include_tags:
                    include_tags.remove("unit_bracket_med")
                exclude_tags.append("unit_bracket_high")

        case "cavalry":
            if index in [0,1]:
                include_tags.append("unit_lance_vanguard")
            else:
                exclude_tags.append("unit_lance_support")

        case "fire":
            if index in [0,1]:
                include_tags.append("unit_lance_assassin")
            else:
                exclude_tags.append("unit_lance_vanguard")
            
            if extra == "elite":
                if  index == 0:
                    include_tags.remove("unit_lance_assassin")
                    include_tags.remove("{CUR_TEAM.faction}")
                    include_tags.append("unit_elite")
                elif index == 1:
                    include_tags.remove("unit_lance_assassin")
                    include_tags.remove("{CUR_TEAM.faction}")
                    include_tags.append("unit_stealth")
            
        case "recon":
            if index == 0:
                include_tags.append("unit_predator")
            elif index == 1:
                include_tags.append("unit_lance_support")
            elif index == 2:
                if variant != "high" and diff < 10 and "unit_mech" in include_tags:
                    include_tags.append("unit_role_scout")
            else:
                exclude_tags.append("unit_lance_assassin")
            
        case "support":
            if variant == "stealth":
                include_tags.append("unit_stealth")
                if index > 1: # loosen faction requirement for half the slots
                    include_tags.remove("{CUR_TEAM.faction}")
            elif composition == "carrier":
                if index == 3:
                    include_tags.append("unit_predator")
                else:
                    include_tags.append("unit_carrier")
            elif variant == "command":
                if index == 0:
                    include_tags.append("unit_lance_tank")
                elif index in [1,2]:
                    include_tags.append("unit_indirectFire")
                else:
                    exclude_tags.remove("unit_noncombatant")
                    include_tags.append("unit_command")
                    include_tags.append("unit_advanced")
            else:
                if index == 0:
                    include_tags.append("unit_lance_tank")
                elif index in [1,2]:
                    include_tags.append("unit_lance_support")
                else:
                    exclude_tags.append("unit_lance_assassin")

        case "convoy":
            pass

        case "solo":
            if index == 0:
                exclude_tags.append("unit_squad")
                include_tags.append("unit_legendary")

            match (extra):
                case "littlefriend":
                    if index > 0:
                        include_tags.append("unit_littlefriend")
                        if "unit_bracket_high" in include_tags:
                            include_tags.remove("unit_bracket_high")                        
                case "advanced":
                    if index == 1:
                        include_tags.append("unit_advanced")

        case "gladiator":
            if index == 0:
                exclude_tags.append("unit_squad")
                include_tags.append("unit_legendary")

        case "duel":
            exclude_tags.append("unit_squad")

            if index == 0:
                include_tags.remove("{CUR_TEAM.faction}")
                include_tags.append("unit_elite")
            elif index == 1:
                include_tags.append("unit_legendary")
            else:
                include_tags.append("unit_advanced")

        case "MCSupport":
            if extra == "indirect":
                include_tags.append("unit_indirectFire")
            elif extra == "elite":
                if  index in [1,2]:
                    include_tags.remove("{CUR_TEAM.faction}")
                    include_tags.append("unit_elite")
            else:
                if index in [1, 2]:
                    include_tags.append("unit_lance_support")

            if diff < 5:
                exclude_tags.append("unit_sniper")
                exclude_tags.append("unit_arrow")
            if diff < 10:
                exclude_tags.append("unit_longtom")
                exclude_tags.append("unit_nuke")
                exclude_tags.append("unit_legendary")

        case "MCDuel":
            exclude_tags.append("unit_nuke")
            exclude_tags.append("unit_squad")

            if extra == "advanced":
                include_tags.append("unit_advanced")
            else:
                include_tags.append("unit_legendary")

        case "turret":
            if diff < 5:
                exclude_tags.append("unit_artilleryturret")

        case _:
            print("bad category: " + str(category))
            traceback.print_stack()
            print("bad category: " + str(category))
            exit()
    
    # loosen tags for vtols
    if "unit_vtol" in include_tags:
        if "unit_lance_support" in include_tags:
            include_tags.remove("unit_lance_support")
        if "unit_lance_vanguard" in include_tags:
            include_tags.remove("unit_lance_vanguard")
        if "unit_lance_assassin" in include_tags:
            include_tags.remove("unit_lance_assassin")
        if "unit_lance_tank" in include_tags:
            include_tags.remove("unit_lance_tank")
            
        if "unit_lance_support" in exclude_tags:
            exclude_tags.remove("unit_lance_support")
        if "unit_lance_vanguard" in exclude_tags:
            exclude_tags.remove("unit_lance_vanguard")
        if "unit_lance_assassin" in exclude_tags:
            exclude_tags.remove("unit_lance_assassin")
        if "unit_lance_tank" in exclude_tags:
            exclude_tags.remove("unit_lance_tank")

        if "unit_bracket_low" in include_tags:
            include_tags.remove("unit_bracket_low")
        if "unit_bracket_med" in include_tags:
            include_tags.remove("unit_bracket_med")
        if "unit_bracket_high" in include_tags:
            include_tags.remove("unit_bracket_high")

        if "unit_assault" not in exclude_tags and "unit_heavy" in exclude_tags:
            exclude_tags.remove("unit_heavy")
        elif "unit_heavy" not in exclude_tags and "unit_medium" in exclude_tags:
            exclude_tags.remove("unit_medium")

        if "unit_predator" in include_tags:
            include_tags.remove("unit_predator")

    # loosen tags for vehicles
    elif "unit_vehicle" in include_tags:
        if "unit_lance_support" in exclude_tags:
            exclude_tags.remove("unit_lance_support")
        if "unit_lance_vanguard" in exclude_tags:
            exclude_tags.remove("unit_lance_vanguard")
        if "unit_lance_assassin" in exclude_tags:
            exclude_tags.remove("unit_lance_assassin")
        if "unit_lance_tank" in exclude_tags:
            exclude_tags.remove("unit_lance_tank")

    if "unit_mech" in include_tags:
        if not any(tag in include_tags for tag in ["unit_legendary", "unit_elite"]) and category not in ["solo","duel","MCDuel","gladiator"]:
            if diff < 6 and index > 0:
                exclude_tags.append("unit_legendary")
            elif diff < 12 and index > 1:
                exclude_tags.append("unit_legendary")

        if "unit_legendary" not in exclude_tags and not any(tag in include_tags for tag in ["unit_risc", "unit_bracket_low", "unit_command"]) and extra != "cheap":
            if index == 3 and diff > 14:
                include_tags.append("unit_legendary")

    # not many assault convoy vehicles, always allow heavies for variety in those lances
    if composition in ["allied", "opfor"] and "unit_assault" not in exclude_tags and "unit_heavy" in exclude_tags:
        exclude_tags.remove("unit_heavy")

    # allow heavies in bracket med assault slots to plug some holes
    if "unit_bracket_med" in include_tags and "unit_assault" not in exclude_tags and "unit_heavy" in exclude_tags:
        exclude_tags.remove("unit_heavy")

    exclude_tags.append("unit_killteam")

    return (include_tags, exclude_tags)

def grab_pilot_include_exclude(index, diff, category, composition, variant, extra):
    include_tags = []
    exclude_tags = []

    pilot_diff = math.ceil(diff/2.0)

    if category == "duel" or extra == "elite":
        include_tags.append("pilot_elite_d"+str(pilot_diff))

    elif variant == "risc":
        include_tags.append("pilot_npc_d"+str(pilot_diff))
        include_tags.append("pilot_risc")
        
    elif category == "turret":
        include_tags.append("pilot_turret_d"+str(pilot_diff))

    elif composition == "mech":
        include_tags.append("pilot_npc_d"+str(pilot_diff))
        if (index == 0 or (index == 1 and diff%2 == 0)):
            if diff > 4 or category in ["solo", "gladiator", "MCDuel"]: 
                include_tags.append("pilot_npc_high")   

    elif composition in ["vehicle", "allied", "opfor"]:
        include_tags.append("pilot_npc_tanker_d"+str(pilot_diff))
        include_tags.append("{CUR_TEAM.faction}")

    elif composition == "mixed":
        if index == 1 or index == 2:
            include_tags.append("pilot_npc_tanker_d"+str(pilot_diff))
            include_tags.append("{CUR_TEAM.faction}")
        else:
            include_tags.append("pilot_npc_d"+str(pilot_diff))
            if index == 0:
                include_tags.append("pilot_npc_high")

    elif composition == "mechconvoy":
        include_tags.append("pilot_npc_d"+str(pilot_diff))
        include_tags.append("pilot_npc_low")

    elif composition == "carrier":
        if index == 3 and extra != "vtol":
            include_tags.append("pilot_npc_d"+str(pilot_diff))
            include_tags.append("pilot_npc_high")
        else:
            include_tags.append("pilot_npc_tanker_d"+str(pilot_diff))
            include_tags.append("{CUR_TEAM.faction}")

    else:
        print("unhandled pilots: " + " ".join([category,composition]))
        traceback.print_stack()
        print("unhandled pilots: " + " ".join([category,composition]))
        exit()

    return (include_tags, exclude_tags)

def build_lances(category, composition, variant, start_diff, stop_diff, extra = "", location = ""):

    for diff in range(start_diff, stop_diff+1):

        lancedef = copy.deepcopy(template)
        lance_tags = []

        slots = 4
        if extra == "small" or category == "solo" or (diff < 3 and extra == "vtol"):
            slots = 3

        if category == "gladiator":
            if diff < 10:
                slots = 3

        if category == "MCSupport":
            if diff < 3:
                slots = 3
        elif category == "MCDuel":
            slots = 2

        if slots < 4:
            lance_tags.append("lance_type_notfull")

        diff_delta = 0
        if variant == "primitive":
            diff_delta = 3
        elif extra == "risc":
            diff_delta = -2

        match(category):
            case "battle":
                lance_tags.append("lance_type_battle")

            case "cavalry":
                lance_tags.append("lance_type_cavalry")

            case "fire":
                lance_tags.append("lance_type_fire")

            case "recon":
                lance_tags.append("lance_type_recon")

            case "support":
                lance_tags.append("lance_type_support")

            case "convoy":
                pass # tagged based on composition

            case "solo":
                lance_tags.append("lance_type_solo")

            case "gladiator":
                pass

            case "duel":
                lance_tags.append("lance_type_duel")

            case "MCSupport":
                pass
            case "MCDuel":
                pass
            case "turret":
                lance_tags.append("lance_type_turret")

            case _:
                print("bad category: " + str(category))
                traceback.print_stack()
                print("bad category: " + str(category))
                exit()

        match(composition):
            case "mech":
                if category != "duel":
                    lance_tags.append("lance_type_mech")
                    lance_tags.append("lance_type_notallvehicles")

            case "mixed":
                if category != "turret":
                    lance_tags.append("lance_type_mixed")
                    lance_tags.append("lance_type_notallvehicles")

            case "vehicle":
                lance_tags.append("lance_type_vehicle")
                if extra == "vtol":
                    lance_tags.append("lance_type_vtol")

            # convoys
            case "allied":
                lance_tags.append("lance_type_convoy")
            case "opfor":
                lance_tags.append("lance_type_OpForConvoy")
            case "mechconvoy":
                lance_tags.append("lance_type_mechconvoy")

            case "carrier":
                if extra == "vtol":
                    lance_tags.append("lance_type_vehicle")
                else:
                    lance_tags.append("lance_type_mixed")
                    lance_tags.append("lance_type_notallvehicles")
            
            # turrets
            case "standard":
                pass
            case "mixed":
                pass
            case "AAA":
                lance_tags.append("lance_type_AAA_turret")
            case "artillery":
                lance_tags.append("lance_type_arty_turret")
                pass

            case _:
                print("bad composition: " + str(composition))
                traceback.print_stack()
                print("bad composition: " + str(composition))
                exit()

        match(variant):
            case "low":
                lance_tags.append("lance_bracket_low")

            case "med":
                lance_tags.append("lance_bracket_med")

            case "high":
                lance_tags.append("lance_bracket_high")

            case "primitive":
                lance_tags.append("lance_type_primitive")
                lance_tags.append("lance_bracket_low")

            case "stealth":
                pass
            case "risc":
                pass
            case "urbie":
                pass
            case "command":
                pass
            case "":
                pass

            case _:
                print("bad variant: " + str(variant))
                traceback.print_stack()
                print("bad variant: " + str(variant))

        lancedef["LanceTags"]["items"] = lancedef["LanceTags"]["items"] + lance_tags

        if category == "gladiator":
            lancedef["LanceTags"]["items"] = ["lance_type_gladiator"]
        elif category == "MCSupport":
            lancedef["LanceTags"]["items"] = ["lance_type_MCSupport"]
        elif category == "MCDuel":
            lancedef["LanceTags"]["items"] = ["lance_type_dynamic", "lance_type_MCduel"]
            
        lancedef["LanceUnits"] = []

        for index in range(0, 4):

            slot = copy.deepcopy(slot_template)

            if index >= slots:
                slot["unitId"] = "mechDef_None"
                lancedef["LanceUnits"].append(slot)
                continue

            unit_tags = grab_unit_include_exclude(index, diff+diff_delta, category, composition, variant, extra)

            slot["unitTagSet"]["items"] = unit_tags[0]
            slot["excludedUnitTagSet"]["items"] = unit_tags[1]

            pilot_tags = grab_pilot_include_exclude(index, diff, category, composition, variant, extra)

            slot["pilotTagSet"]["items"] = pilot_tags[0]
            slot["excludedPilotTagSet"]["items"] = pilot_tags[1]

            if "unit_mech" in unit_tags[0]:
                slot["unitType"] = "Mech"
            elif any(tag in ["unit_vehicle", "unit_vtol"] for tag in unit_tags[0]):
                slot["unitType"] = "Vehicle"
            elif any(tag in ["unit_turret", "unit_artilleryturret"] for tag in unit_tags[0]):
                slot["unitType"] = "Turret"
            else:
                print("unhandled slot type")
                print(" ".join([composition, category, variant]))
                print(unit_tags[0])
                exit()

            lancedef["LanceUnits"].append(slot)

        lancedef["Difficulty"] = diff
        lance_id = "lancedef"
        lance_id += "_" + composition
        lance_id += "_" + category
        if variant != "":
            lance_id += "_" + variant
        lance_id += "_" +  "d"+str(diff)
        lancedef["Description"]["Id"] = lance_id

        if extra != "":
            lancedef["Description"]["Id"] = lancedef["Description"]["Id"] + "_" + extra

        lancedef["Description"]["Name"] = " ".join(["Dynamic", "D"+str(diff), composition.capitalize(), category.capitalize()])

        save_path = path_to_lances + location
        save_path += "/".join([category if category in ["MCSupport", "MCDuel"] else category.capitalize(), composition.capitalize(), variant.capitalize()])

        if not os.path.exists(save_path):
            os.makedirs(save_path)

        save_path +=  "/" + lancedef["Description"]["Id"] + ".json"

        with open(save_path, 'w', newline='\r\n') as new_file:
            json.dump(lancedef, new_file, indent=2)
            new_file.write("\n")

        global number
        number += 1


# lance_type_battle

build_lances("battle", "mech", "low", 1, 2, extra="small")
build_lances("battle", "mech", "low", 1, 6)
build_lances("battle", "mech", "med", 4, 16)
build_lances("battle", "mech", "high", 10, 20)
build_lances("battle", "mech", "primitive", 1, 2, extra="small")
build_lances("battle", "mech", "primitive", 1, 11)

build_lances("battle", "mixed", "low", 1, 2, extra="small")
build_lances("battle", "mixed", "low", 1, 6)
build_lances("battle", "mixed", "med", 4, 16)
build_lances("battle", "mixed", "high", 10, 20)
build_lances("battle", "mixed", "primitive", 1, 2, extra="small")
build_lances("battle", "mixed", "primitive", 1, 11)

build_lances("battle", "vehicle", "low", 1, 2, extra="small")
build_lances("battle", "vehicle", "low", 1, 6)
build_lances("battle", "vehicle", "med", 4, 16)
build_lances("battle", "vehicle", "high", 10, 20)
build_lances("battle", "vehicle", "primitive", 1, 11)

build_lances("battle", "mixed", "med", 4, 16, extra="vtol")
build_lances("battle", "mixed", "high", 10, 20, extra="vtol")


# lance_type_cavalry - 2 vanguard, no support

build_lances("cavalry", "mech", "low", 1, 2, extra="small")
build_lances("cavalry", "mech", "low", 1, 6)
build_lances("cavalry", "mech", "med", 4, 16)
build_lances("cavalry", "mech", "high", 10, 20)

build_lances("cavalry", "mixed", "low", 1, 2, extra="small")
build_lances("cavalry", "mixed", "low", 1, 6)
build_lances("cavalry", "mixed", "med", 4, 16)
build_lances("cavalry", "mixed", "high", 10, 20)

build_lances("cavalry", "vehicle", "low", 1, 2, extra="small")
build_lances("cavalry", "vehicle", "low", 1, 6)
build_lances("cavalry", "vehicle", "med", 4, 16)
build_lances("cavalry", "vehicle", "high", 10, 20)


# lance_type_fire - 2 assassin, no vanguard

build_lances("fire", "mech", "low", 1, 2, extra="small")
build_lances("fire", "mech", "low", 1, 6)
build_lances("fire", "mech", "med", 4, 16)
build_lances("fire", "mech", "high", 10, 20)

build_lances("fire", "mixed", "low", 1, 2, extra="small")
build_lances("fire", "mixed", "low", 1, 6)
build_lances("fire", "mixed", "med", 4, 16)
build_lances("fire", "mixed", "high", 10, 20)

build_lances("fire", "vehicle", "low", 1, 2, extra="small")
build_lances("fire", "vehicle", "low", 1, 6)
build_lances("fire", "vehicle", "med", 4, 16)
build_lances("fire", "vehicle", "high", 10, 20)


# lance_type_recon - 1 predator 1 support 1 vanguard, no assassin

build_lances("recon", "mech", "low", 1, 2, extra="small")
build_lances("recon", "mech", "low", 1, 6)
build_lances("recon", "mech", "med", 4, 16)
build_lances("recon", "mech", "high", 10, 20)

build_lances("recon", "mixed", "low", 1, 2, extra="small")
build_lances("recon", "mixed", "low", 1, 6)
build_lances("recon", "mixed", "med", 4, 16)
build_lances("recon", "mixed", "high", 10, 20)

build_lances("recon", "vehicle", "low", 1, 2, extra="small")
build_lances("recon", "vehicle", "low", 1, 6)
build_lances("recon", "vehicle", "med", 4, 16)
build_lances("recon", "vehicle", "high", 10, 20)

build_lances("recon", "mixed", "med", 4, 16, extra="vtol")
build_lances("recon", "mixed", "high", 10, 20, extra="vtol")
build_lances("recon", "vehicle", "", 1, 20, extra="vtol")

#build_lances("recon", "mixed", "med", 4, 16, extra="hover")
#build_lances("recon", "mixed", "high", 10, 20, extra="hover")
#build_lances("recon", "vehicle", "", 1, 20, extra="hover")

# lance_type_support - 1 tank 2 support, no assassin

build_lances("support", "mech", "low", 1, 2, extra="small")
build_lances("support", "mech", "low", 1, 6)
build_lances("support", "mech", "med", 4, 16)
build_lances("support", "mech", "high", 10, 20)

build_lances("support", "mixed", "low", 1, 2, extra="small")
build_lances("support", "mixed", "low", 1, 6)
build_lances("support", "mixed", "med", 4, 16)
build_lances("support", "mixed", "high", 10, 20)

build_lances("support", "vehicle", "low", 1, 2, extra="small")
build_lances("support", "vehicle", "low", 1, 6)
build_lances("support", "vehicle", "med", 4, 16)
build_lances("support", "vehicle", "high", 10, 20)

build_lances("support", "mixed", "med", 4, 16, extra="vtol")
build_lances("support", "mixed", "high", 10, 20, extra="vtol")
build_lances("support", "vehicle", "", 1, 20, extra="vtol")

#build_lances("support", "mixed", "med", 4, 16, extra="hover")
#build_lances("support", "mixed", "high", 10, 20, extra="hover")
#build_lances("support", "vehicle", "", 1, 20, extra="hover")

# lance_type_convoy, allied side convoy
build_lances("convoy", "allied", "", 1, 20)

# lance_type_OpForConvoy, ambush convoy target
build_lances("convoy", "opfor", "low", 1, 6)
build_lances("convoy", "opfor", "med", 4, 16)
build_lances("convoy", "opfor", "high", 10, 20)

# lance_type_mechconvoy, both sides, bad pilots
build_lances("convoy", "mechconvoy", "low", 1, 6)
build_lances("convoy", "mechconvoy", "med", 4, 16)
build_lances("convoy", "mechconvoy", "high", 10, 20)

# lance_type_solo, assassination, high prio target + light support
build_lances("solo", "mech", "low", 1, 6, extra="littlefriend")
build_lances("solo", "mech", "med", 4, 16, extra="littlefriend")
build_lances("solo", "mech", "high", 10, 20, extra="littlefriend")
build_lances("solo", "mech", "low", 1, 6, extra="advanced")
build_lances("solo", "mech", "med", 4, 16, extra="advanced")
build_lances("solo", "mech", "high", 10, 20, extra="advanced")
build_lances("solo", "mixed", "low", 1, 6, extra="advanced")
build_lances("solo", "mixed", "med", 4, 16, extra="advanced")
build_lances("solo", "mixed", "high", 10, 20, extra="advanced")


# lance_type_gladiator, limited drop and some other fp, like solo but less units total
build_lances("gladiator", "mech", "low", 1, 6)
build_lances("gladiator", "mech", "med", 4, 16)
build_lances("gladiator", "mech", "high", 10, 20)
build_lances("gladiator", "mixed", "low", 1, 6)
build_lances("gladiator", "mixed", "med", 4, 16)
build_lances("gladiator", "mixed", "high", 10, 20)


# Elites submod

# lance_type_duel, coupe & friends, mechs kitted to gills, elite + legendary + 2 advanced
build_lances("duel", "mech", "low", 1, 6, location="../../../Optionals/RogueElites/Base/Lances/")
build_lances("duel", "mech", "med", 4, 16, location="../../../Optionals/RogueElites/Base/Lances/")
build_lances("duel", "mech", "high", 10, 20, location="../../../Optionals/RogueElites/Base/Lances/")

build_lances("support", "mech", "stealth", 6, 20, extra="elite", location="../../../Optionals/RogueElites/Base/Lances/")
# no stealth mixed/vee as practically only risc has stealth vees

build_lances("solo", "mech", "med", 4, 16, extra="elite", location="../../../Optionals/RogueElites/Base/Lances/")
build_lances("solo", "mech", "high", 10, 20, extra="elite", location="../../../Optionals/RogueElites/Base/Lances/")

build_lances("fire", "mech", "med", 4, 16, extra="elite", location="../../../Optionals/RogueElites/Base/Lances/")
build_lances("fire", "mech", "high", 10, 20, extra="elite", location="../../../Optionals/RogueElites/Base/Lances/")

# elite support
build_lances("MCSupport", "mech", "high", 10, 20, extra="elite", location="../../../Optionals/RogueElites/Base/Lances/")

# Risc submod
build_lances("battle", "mech", "risc", 6, 20, location="../../../Optionals/RISCtech/Base/Lances/")
build_lances("battle", "mixed", "risc", 6, 20, location="../../../Optionals/RISCtech/Base/Lances/")
build_lances("battle", "mixed", "risc", 6, 20, extra="vtol", location="../../../Optionals/RISCtech/Base/Lances/")

# urbie submod
build_lances("battle", "mech", "urbie", 1, 8, location="../../../Optionals/Urbocalypse/Base/Lances/")
build_lances("battle", "mixed", "urbie", 4, 8, location="../../../Optionals/Urbocalypse/Base/Lances/")

# Mission control
# support lances & duels

build_lances("MCSupport", "mech", "low", 1, 6, location="../../MissionControl/")
build_lances("MCSupport", "mech", "med", 4, 16, location="../../MissionControl/")
build_lances("MCSupport", "mech", "high", 10, 20, location="../../MissionControl/")
build_lances("MCSupport", "mixed", "low", 1, 6, location="../../MissionControl/")
build_lances("MCSupport", "mixed", "med", 4, 16, location="../../MissionControl/")
build_lances("MCSupport", "mixed", "high", 10, 20, location="../../MissionControl/")
build_lances("MCSupport", "vehicle", "low", 1, 6, location="../../MissionControl/")
build_lances("MCSupport", "vehicle", "med", 4, 16, location="../../MissionControl/")
build_lances("MCSupport", "vehicle", "high", 10, 20, location="../../MissionControl/")

build_lances("MCSupport", "mech", "low", 1, 6, extra="indirect", location="../../MissionControl/")
build_lances("MCSupport", "mech", "med", 4, 16, extra="indirect", location="../../MissionControl/")
build_lances("MCSupport", "mech", "high", 10, 20, extra="indirect", location="../../MissionControl/")
build_lances("MCSupport", "mixed", "low", 1, 6, extra="indirect", location="../../MissionControl/")
build_lances("MCSupport", "mixed", "med", 4, 16, extra="indirect", location="../../MissionControl/")
build_lances("MCSupport", "mixed", "high", 10, 20, extra="indirect", location="../../MissionControl/")
build_lances("MCSupport", "vehicle", "low", 1, 6, extra="indirect", location="../../MissionControl/")
build_lances("MCSupport", "vehicle", "med", 4, 16, extra="indirect", location="../../MissionControl/")
build_lances("MCSupport", "vehicle", "high", 10, 20, extra="indirect", location="../../MissionControl/")

build_lances("MCDuel", "mech", "low", 1, 6, location="../../MissionControl/")
build_lances("MCDuel", "mech", "med", 4, 16, location="../../MissionControl/")
build_lances("MCDuel", "mech", "high", 10, 20, location="../../MissionControl/")
build_lances("MCDuel", "mech", "low", 1, 6, extra="advanced", location="../../MissionControl/")
build_lances("MCDuel", "mech", "med", 4, 16, extra="advanced", location="../../MissionControl/")
build_lances("MCDuel", "mech", "high", 10, 20, extra="advanced", location="../../MissionControl/")


build_lances("turret", "standard", "", 1, 20)
build_lances("turret", "mixed", "", 1, 20)
build_lances("turret", "AAA", "", 1, 20)
build_lances("turret", "artillery", "", 20, 20)

# special themed / variety lances

# get demolished
build_lances("battle", "vehicle", "", 14, 20, extra="demolisher")
build_lances("battle", "vehicle", "", 8, 20, extra="MBT")

# spotter 3 carriers
build_lances("support", "carrier", "", 10, 20)


# tank + indirect + command
build_lances("support", "mech", "command", 8, 20)
build_lances("support", "mixed", "command", 8, 20)
build_lances("support", "vehicle", "command", 8, 20)


# more battle variety

# first slot tanky
build_lances("battle", "mech", "med", 4, 16, extra="tank")
build_lances("battle", "mech", "high", 10, 20, extra="tank")

build_lances("battle", "mixed", "med", 4, 16, extra="tank")
build_lances("battle", "mixed", "high", 10, 20, extra="tank")

# first slot vanguard
build_lances("battle", "mech", "low", 1, 6, extra="vanguard")
build_lances("battle", "mech", "med", 4, 16, extra="vanguard")
build_lances("battle", "mech", "high", 10, 20, extra="vanguard")

build_lances("battle", "mixed", "low", 1, 6, extra="vanguard")
build_lances("battle", "mixed", "med", 4, 16, extra="vanguard")
build_lances("battle", "mixed", "high", 10, 20, extra="vanguard")

# last slot bracket low
build_lances("battle", "mech", "med", 4, 16, extra="cheap")
build_lances("battle", "mech", "high", 10, 20, extra="cheap")

build_lances("battle", "mixed", "med", 4, 16, extra="cheap")
build_lances("battle", "mixed", "high", 10, 20, extra="cheap")

# mono weight class lance
build_lances("battle", "mech", "med", 5, 10, extra="medium")
build_lances("battle", "mech", "high", 10, 15, extra="medium")
build_lances("battle", "mech", "med", 10, 15, extra="heavy")
build_lances("battle", "mech", "high", 15, 20, extra="heavy")
build_lances("battle", "mech", "med", 15, 17, extra="assault")
build_lances("battle", "mech", "high", 17, 20, extra="assault")

build_lances("battle", "mixed", "med", 5, 10, extra="medium")
build_lances("battle", "mixed", "high", 10, 15, extra="medium")
build_lances("battle", "mixed", "med", 10, 15, extra="heavy")
build_lances("battle", "mixed", "high", 15, 20, extra="heavy")
build_lances("battle", "mixed", "med", 15, 17, extra="assault")
build_lances("battle", "mixed", "high", 17, 20, extra="assault")

build_lances("battle", "vehicle", "med", 5, 10, extra="medium")
build_lances("battle", "vehicle", "high", 10, 15, extra="medium")
build_lances("battle", "vehicle", "med", 10, 15, extra="heavy")
build_lances("battle", "vehicle", "high", 15, 20, extra="heavy")
build_lances("battle", "vehicle", "med", 15, 17, extra="assault")
build_lances("battle", "vehicle", "high", 17, 20, extra="assault")





print(f"Finished writing {number} LanceDefs.")

exit()

