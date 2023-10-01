import json, math, copy, traceback, os

path = "RogueTech/Core/RogueTechCore/Lances/_Rework/"

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

def grab_diff_weight_excludes(diff, index):
    return weight_excludes[weight_map[diff-1][index]]

def grab_reduced_tonnage_tags(diff):
    if diff < 8:
        return weight_excludes["light"]
    elif diff < 16:
        return weight_excludes["med/light"]
    else:
        return weight_excludes["hvy/med/light"]

def grab_unit_include_exclude(index, diff, category, composition, variant, extra):
    include_tags = ["{CUR_TEAM.faction}"]
    exclude_tags = ["unit_noncombatant"] + grab_diff_weight_excludes(diff, index)

    if category in ["solo","gladiator"] and index > 0:
        exclude_tags = ["unit_noncombatant"] + grab_reduced_tonnage_tags(diff)

    match(variant):
        case "low":
            include_tags.append("unit_bracket_low")
        case "med":
            include_tags.append("unit_bracket_med")
        case "high":
            include_tags.append("unit_bracket_high")
        case "primitive":
            include_tags.remove("{CUR_TEAM.faction}")
            include_tags.append("unit_primitive")
        case "vtol":
            pass
#            if diff < 6:
#                include_tags.append("unit_bracket_low")
#            elif diff < 16:
#                include_tags.append("unit_bracket_med")
#            else:
#                include_tags.append("unit_bracket_high")
        case "varied":
            if diff <= 10:
                exclude_tags.append("unit_bracket_high")
            else:
                exclude_tags.append("unit_bracket_low")
    
        case _:
            print("bad variant: " + str(variant))
            traceback.print_stack()
            print("bad variant: " + str(variant))
            exit()

    match(composition):
        case "mech":
            include_tags.append("unit_mech")

        case "mixed":
            if index in [1,2]:
                include_tags.append("unit_vehicle")
            else:
                include_tags.append("unit_mech")

        case "vehicle":
            include_tags.append("unit_vehicle")

        # convoys
        case "allied":
            include_tags.append("unit_vehicle_apc")

            exclude_tags.remove("unit_noncombatant")
            exclude_tags.append("unit_noconvoy")
            exclude_tags.append("unit_vtol")
            exclude_tags.append("unit_airship")
            exclude_tags.append("unit_hover")
        case "opfor":
            include_tags.append("unit_vehicle")

            exclude_tags.remove("unit_noncombatant")
            exclude_tags.append("unit_noconvoy")
            exclude_tags.append("unit_vtol")
            exclude_tags.append("unit_airship")
            exclude_tags.append("unit_hover")
        case "mechconvoy":
            include_tags.append("unit_mech")
            exclude_tags.append("unit_urbie")
            exclude_tags.append("unit_noconvoy")

        case "carrier":
            if index in [0,1,2]:
                include_tags.append("unit_vehicle")
            else:
                include_tags.append("unit_mech")

        case _:
            print("bad composition: " + str(composition))
            traceback.print_stack()
            print("bad composition: " + str(composition))
            exit()

    if variant == "vtol":
        if "unit_vehicle" in include_tags:
            include_tags.remove("unit_vehicle")
            include_tags.append("unit_vtol")

    match(category):
        case "battle":
            if extra == "risc":
                if  index in [0,1,2]:
                    include_tags.remove("{CUR_TEAM.faction}")
                    include_tags.append("unit_risc")
            elif extra == "MBT":
                include_tags.append("unit_lance_tank")
            elif extra == "demolisher":
                include_tags.append("unit_demolisher")

        case "cavalry":
            if index in [0,1,2]:
                include_tags.append("unit_lance_vanguard")
            exclude_tags.append("unit_lance_support")

        case "fire":
            if index in [0,1,2]:
                include_tags.append("unit_lance_assassin")
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
                include_tags.append("unit_lance_vanguard")
            exclude_tags.append("unit_lance_assassin")
            
        case "support":
            if extra == "stealth":
                include_tags.append("unit_stealth")
                if index < 2: # loosen faction requirement for half the slots
                    include_tags.remove("{CUR_TEAM.faction}")
            elif composition == "carrier":
                if index == 3:
                    include_tags.append("unit_predator")
                else:
                    include_tags.append("unit_carrier")
            else:
                if index == 0:
                    include_tags.append("unit_lance_tank")
                elif index in [1,2]:
                    include_tags.append("unit_lance_support")
                exclude_tags.append("unit_lance_assassin")

        case "convoy":
            pass

        case "solo":
            if index == 0:
                exclude_tags.append("unit_protomech")
                exclude_tags.append("unit_powerarmor")
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
                exclude_tags.append("unit_protomech")
                exclude_tags.append("unit_powerarmor")
                include_tags.append("unit_legendary")

        case "duel":
            exclude_tags.append("unit_protomech")
            exclude_tags.append("unit_powerarmor")

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
            else:
                if index == 0:
                    include_tags.append("unit_lance_tank")
                elif index == 1:
                    include_tags.append("unit_lance_support")

            if diff < 10:
                exclude_tags.append("unit_sniper")
                exclude_tags.append("unit_arrow")
            if diff < 15:
                exclude_tags.append("unit_longtom")
                exclude_tags.append("unit_nuke")
                exclude_tags.append("unit_legendary")

        case "MCDuel":
            exclude_tags.append("unit_nuke")
            exclude_tags.append("unit_powerarmor")
            exclude_tags.append("unit_protomech")

            if extra == "advanced":
                include_tags.append("unit_advanced")
            else:
                include_tags.append("unit_legendary")

        case _:
            print("bad category: " + str(category))
            traceback.print_stack()
            print("bad category: " + str(category))
            exit()

    if "unit_mech" in include_tags and "unit_risc" not in include_tags and "unit_legendary" not in exclude_tags:
        if index == 3 and diff > 14:
            include_tags.append("unit_legendary")
        elif index == 2 and diff > 17:
            include_tags.append("unit_legendary")

    # not many assault convoy vehicles, always allow heavies for variety in those lances
    if composition in ["allied", "opfor"] and "unit_assault" not in exclude_tags and "unit_heavy" in exclude_tags:
        exclude_tags.remove("unit_heavy")

    return (include_tags, exclude_tags)

def grab_pilot_include_exclude(index, diff, category, composition, variant, extra):
    include_tags = []
    exclude_tags = []

    pilot_diff = math.ceil(diff/2.0)

    if category == "duel" or extra == "elite":
        include_tags.append("pilot_elite_d"+str(pilot_diff))

    elif extra == "risc":
        include_tags.append("pilot_npc_d"+str(pilot_diff))
        include_tags.append("pilot_risc")

    elif composition == "mech":
        include_tags.append("pilot_npc_d"+str(pilot_diff))
        if index == 0 or (index == 1 and diff%2 == 0):
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
        if index == 3:
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

def build_lances(category, composition, variant, start_diff, stop_diff, extra = "", subfolder = ""):

    for diff in range(start_diff, stop_diff+1):

        lancedef = copy.deepcopy(template)
        lance_tags = []

        slots = 4
        if extra == "small" or category == "solo":
            slots = 3

        if category == "gladiator":
            if diff < 8:
                slots = 2
            elif diff < 16:
                slots = 3

        if category == "MCSupport":
            if diff < 5:
                slots = 3
        elif category == "MCDuel":
            slots = 2

        if slots < 4:
            lance_tags.append("lance_type_notfull")

        diff_delta = 0
        if variant == "primitive":
            diff_delta = 2
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
                lance_tags.append("lance_type_gladiator")

            case "duel":
                lance_tags.append("lance_type_duel")

            case "MCSupport":
                pass
            case "MCDuel":
                pass


            case _:
                print("bad category: " + str(category))
                traceback.print_stack()
                print("bad category: " + str(category))
                exit()

        match(composition):
            case "mech":
                lance_tags.append("lance_type_mech")
                lance_tags.append("lance_type_notallvehicles")

            case "mixed":
                lance_tags.append("lance_type_mixed")
                lance_tags.append("lance_type_notallvehicles")

            case "vehicle":
                lance_tags.append("lance_type_vehicle")

            # convoys
            case "allied":
                lance_tags.append("lance_type_convoy")
            case "opfor":
                lance_tags.append("lance_type_OpForConvoy")
            case "mechconvoy":
                lance_tags.append("lance_type_mechconvoy")

            case "carrier":
                lance_tags.append("lance_type_mixed")
                lance_tags.append("lance_type_notallvehicles")

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
                lance_tags.append("lance_bracket_low")

            case "vtol":
                if composition == "vehicle":
                    lance_tags.append("lance_type_vtol")
#                if diff < 6:
#                    lance_tags.append("lance_bracket_low")
#                elif diff < 16:
#                    lance_tags.append("lance_bracket_med")
#                else:
#                    lance_tags.append("lance_bracket_high")

            case "varied":
                pass

            case _:
                print("bad variant: " + str(variant))
                traceback.print_stack()
                print("bad variant: " + str(variant))

        lancedef["LanceTags"]["items"] = lancedef["LanceTags"]["items"] + lance_tags

        if category == "MCSupport":
            lancedef["LanceTags"]["items"] = ["lance_type_MCSupport"]
        elif category == "MCDuel":
            lancedef["LanceTags"]["items"] = ["lance_type_MCDuel"]
            
        lancedef["LanceUnits"] = []

        for index in range(0, slots):

            slot = copy.deepcopy(slot_template)

            unit_tags = grab_unit_include_exclude(index, diff+diff_delta, category, composition, variant, extra)

            slot["unitTagSet"]["items"] = unit_tags[0]
            slot["excludedUnitTagSet"]["items"] = unit_tags[1]

            pilot_tags = grab_pilot_include_exclude(index, diff, category, composition, variant, extra)

            slot["pilotTagSet"]["items"] = pilot_tags[0]
            slot["excludedPilotTagSet"]["items"] = pilot_tags[1]

            if "unit_mech" in unit_tags[0]:
                slot["unitType"] = "Mech"
            elif any(tag in ["unit_vehicle", "unit_vtol", "unit_vehicle_apc"] for tag in unit_tags[0]):
                slot["unitType"] = "Vehicle"
            else:
                print("unhandled slot type")
                print(" ".join([composition, category, variant]))
                print(unit_tags[0])
                exit()

            lancedef["LanceUnits"].append(slot)

        lancedef["Difficulty"] = diff
        lancedef["Description"]["Id"] = "_".join(["lancedef", composition, category, variant, "d"+str(diff)])

        if extra != "":
            lancedef["Description"]["Id"] = lancedef["Description"]["Id"] + "_" + extra

        lancedef["Description"]["Name"] = " ".join(["Dynamic", "D"+str(diff), composition.capitalize(), category.capitalize()])

        if subfolder != "":
            save_path = path + subfolder + "/"
        else:
            save_path = path
        
        save_path += "/".join([category if category in ["MCSupport", "MCDuel"] else category.capitalize(), composition.capitalize(), variant.upper() if variant == "vtol" else variant.capitalize()])

        if not os.path.exists(save_path):
            os.makedirs(save_path)

        save_path +=  "/" + lancedef["Description"]["Id"] + ".json"

        with open(save_path, 'w', newline='\r\n') as new_file:
            json.dump(lancedef, new_file, indent=2)


# lance_type_battle

build_lances("battle", "mech", "low", 1, 3, "small")
build_lances("battle", "mech", "low", 1, 8)
build_lances("battle", "mech", "med", 5, 16)
build_lances("battle", "mech", "high", 13, 20)
build_lances("battle", "mech", "primitive", 1, 3, "small")
build_lances("battle", "mech", "primitive", 1, 10)

build_lances("battle", "mixed", "low", 1, 3, "small")
build_lances("battle", "mixed", "low", 1, 8)
build_lances("battle", "mixed", "med", 5, 16)
build_lances("battle", "mixed", "high", 13, 20)
build_lances("battle", "mixed", "primitive", 1, 3, "small")
build_lances("battle", "mixed", "primitive", 1, 10)

build_lances("battle", "vehicle", "low", 1, 3, "small")
build_lances("battle", "vehicle", "low", 1, 8)
build_lances("battle", "vehicle", "med", 5, 16)
build_lances("battle", "vehicle", "high", 13, 20)
build_lances("battle", "vehicle", "primitive", 1, 10)

build_lances("battle", "mixed", "vtol", 1, 20)


# lance_type_cavalry - 3 vanguard, no support

build_lances("cavalry", "mech", "low", 1, 3, "small")
build_lances("cavalry", "mech", "low", 1, 8)
build_lances("cavalry", "mech", "med", 5, 16)
build_lances("cavalry", "mech", "high", 13, 20)

build_lances("cavalry", "mixed", "low", 1, 3, "small")
build_lances("cavalry", "mixed", "low", 1, 8)
build_lances("cavalry", "mixed", "med", 5, 16)
build_lances("cavalry", "mixed", "high", 13, 20)

build_lances("cavalry", "vehicle", "low", 1, 3, "small")
build_lances("cavalry", "vehicle", "low", 1, 8)
build_lances("cavalry", "vehicle", "med", 5, 16)
build_lances("cavalry", "vehicle", "high", 13, 20)


# lance_type_fire - 3 assassin, no vanguard

build_lances("fire", "mech", "low", 1, 3, "small")
build_lances("fire", "mech", "low", 1, 8)
build_lances("fire", "mech", "med", 5, 16)
build_lances("fire", "mech", "high", 13, 20)

build_lances("fire", "mixed", "low", 1, 3, "small")
build_lances("fire", "mixed", "low", 1, 8)
build_lances("fire", "mixed", "med", 5, 16)
build_lances("fire", "mixed", "high", 13, 20)

build_lances("fire", "vehicle", "low", 1, 3, "small")
build_lances("fire", "vehicle", "low", 1, 8)
build_lances("fire", "vehicle", "med", 5, 16)
build_lances("fire", "vehicle", "high", 13, 20)


# lance_type_recon - 1 predator 1 support 1 vanguard, no assassin

build_lances("recon", "mech", "low", 1, 3, "small")
build_lances("recon", "mech", "low", 1, 8)
build_lances("recon", "mech", "med", 5, 16)
build_lances("recon", "mech", "high", 13, 20)

build_lances("recon", "mixed", "low", 1, 3, "small")
build_lances("recon", "mixed", "low", 1, 8)
build_lances("recon", "mixed", "med", 5, 16)
build_lances("recon", "mixed", "high", 13, 20)

build_lances("recon", "vehicle", "low", 1, 3, "small")
build_lances("recon", "vehicle", "low", 1, 8)
build_lances("recon", "vehicle", "med", 5, 16)
build_lances("recon", "vehicle", "high", 13, 20)

build_lances("recon", "mixed", "vtol", 1, 20)
build_lances("recon", "vehicle", "vtol", 1, 20)

# lance_type_support - 1 tank 2 support, no assassin

build_lances("support", "mech", "low", 1, 3, "small")
build_lances("support", "mech", "low", 1, 8)
build_lances("support", "mech", "med", 5, 16)
build_lances("support", "mech", "high", 13, 20)

build_lances("support", "mixed", "low", 1, 3, "small")
build_lances("support", "mixed", "low", 1, 8)
build_lances("support", "mixed", "med", 5, 16)
build_lances("support", "mixed", "high", 13, 20)

build_lances("support", "vehicle", "low", 1, 3, "small")
build_lances("support", "vehicle", "low", 1, 8)
build_lances("support", "vehicle", "med", 5, 16)
build_lances("support", "vehicle", "high", 13, 20)

build_lances("support", "mixed", "vtol", 1, 20)
build_lances("support", "vehicle", "vtol", 1, 20)


# lance_type_convoy, allied side convoy
build_lances("convoy", "allied", "varied", 1, 20)

# lance_type_OpForConvoy, ambush convoy target
build_lances("convoy", "opfor", "low", 1, 8)
build_lances("convoy", "opfor", "med", 5, 16)
build_lances("convoy", "opfor", "high", 13, 20)

# lance_type_mechconvoy, both sides, bad pilots
build_lances("convoy", "mechconvoy", "low", 1, 8)
build_lances("convoy", "mechconvoy", "med", 5, 16)
build_lances("convoy", "mechconvoy", "high", 13, 20)


# lance_type_solo, assassination, high prio target + light support
build_lances("solo", "mech", "low", 1, 8, "littlefriend")
build_lances("solo", "mech", "med", 5, 16, "littlefriend")
build_lances("solo", "mech", "high", 13, 20, "littlefriend")
build_lances("solo", "mech", "low", 1, 8, "advanced")
build_lances("solo", "mech", "med", 5, 16, "advanced")
build_lances("solo", "mech", "high", 13, 20, "advanced")
build_lances("solo", "mixed", "low", 1, 8, "advanced")
build_lances("solo", "mixed", "med", 5, 16, "advanced")
build_lances("solo", "mixed", "high", 13, 20, "advanced")


# lance_type_gladiator, limited drop and other fp, like solo but less units total
build_lances("gladiator", "mech", "low", 1, 8)
build_lances("gladiator", "mech", "med", 5, 16)
build_lances("gladiator", "mech", "high", 13, 20)
build_lances("gladiator", "mixed", "low", 1, 8)
build_lances("gladiator", "mixed", "med", 5, 16)
build_lances("gladiator", "mixed", "high", 13, 20)


# Elites submod

# lance_type_duel, coupe & friends, mechs kitted to gills, elite + legendary + 2 advanced
build_lances("duel", "mech", "low", 1, 8, subfolder="Elite")
build_lances("duel", "mech", "med", 5, 16, subfolder="Elite")
build_lances("duel", "mech", "high", 13, 20, subfolder="Elite")

build_lances("support", "mech", "varied", 5, 20, "stealth", subfolder="Elite")
# build_lances("support", "mixed", "varied", 5, 20, "stealth") bad idea, practically only risc has stealth vees

build_lances("solo", "mech", "med", 5, 16, "elite", subfolder="Elite")
build_lances("solo", "mech", "high", 13, 20, "elite", subfolder="Elite")

build_lances("fire", "mech", "med", 5, 16, "elite", subfolder="Elite")
build_lances("fire", "mech", "high", 13, 20, "elite", subfolder="Elite")

# I initially missed MC elite indirect? added fire as option for late stage support lances already

# Risc submod

build_lances("battle", "mech", "varied", 5, 20, "risc", subfolder="RISC")
build_lances("battle", "mixed", "varied", 5, 20, "risc", subfolder="RISC")
build_lances("battle", "vehicle", "varied", 5, 20, "risc", subfolder="RISC")
build_lances("battle", "mixed", "vtol", 5, 20, "risc", subfolder="RISC")

# Mission control
# support lances & duels

build_lances("MCSupport", "mech", "low", 1, 8, subfolder="MC")
build_lances("MCSupport", "mech", "med", 5, 16, subfolder="MC")
build_lances("MCSupport", "mech", "high", 13, 20, subfolder="MC")
build_lances("MCSupport", "mixed", "low", 1, 8, subfolder="MC")
build_lances("MCSupport", "mixed", "med", 5, 16, subfolder="MC")
build_lances("MCSupport", "mixed", "high", 13, 20, subfolder="MC")
build_lances("MCSupport", "vehicle", "low", 1, 8, subfolder="MC")
build_lances("MCSupport", "vehicle", "med", 5, 16, subfolder="MC")
build_lances("MCSupport", "vehicle", "high", 13, 20, subfolder="MC")

build_lances("MCSupport", "mech", "low", 1, 8, "indirect", subfolder="MC")
build_lances("MCSupport", "mech", "med", 5, 16, "indirect", subfolder="MC")
build_lances("MCSupport", "mech", "high", 13, 20, "indirect", subfolder="MC")
build_lances("MCSupport", "mixed", "low", 1, 8, "indirect", subfolder="MC")
build_lances("MCSupport", "mixed", "med", 5, 16, "indirect", subfolder="MC")
build_lances("MCSupport", "mixed", "high", 13, 20, "indirect", subfolder="MC")
build_lances("MCSupport", "vehicle", "low", 1, 8, "indirect", subfolder="MC")
build_lances("MCSupport", "vehicle", "med", 5, 16, "indirect", subfolder="MC")
build_lances("MCSupport", "vehicle", "high", 13, 20, "indirect", subfolder="MC")

build_lances("MCDuel", "mech", "low", 1, 8, subfolder="MC")
build_lances("MCDuel", "mech", "med", 5, 16, subfolder="MC")
build_lances("MCDuel", "mech", "high", 13, 20, subfolder="MC")
build_lances("MCDuel", "mech", "low", 1, 8, "advanced", subfolder="MC")
build_lances("MCDuel", "mech", "med", 5, 16, "advanced", subfolder="MC")
build_lances("MCDuel", "mech", "high", 13, 20, "advanced", subfolder="MC")


# special themed / variety lances

# get demolished
build_lances("battle", "vehicle", "varied", 15, 20, "demolisher")
build_lances("battle", "vehicle", "varied", 8, 20, "MBT")
# spotter 3 carriers
build_lances("support", "carrier", "varied", 10, 20)

exit()