import json
from collections import OrderedDict
import os
import os.path
import pprint



# put factions to duplicate here
FactionsToDuplicate = [ 
    
]

# update this to the year tag you want
Year = 3150


FactionDir = '../../Core/RogueTechCore/Factions/'
FactionEnum = '../../Core/RogueTechCore/Faction.json'
IsmLogoFile = '../../Core/InnerSphereMap/settings.json'
FpEnablerSettingsFile = '../../DLC/RogueFlashPointModule/settings.json'

factionsAddedMap = {}
factionDefIdsMap = {
}

for fp in os.listdir(FactionDir):
    if fp.endswith('.json'):
        with open(os.path.join(FactionDir, fp), 'rb') as f:
            jData = json.loads(f.read(), object_hook=OrderedDict, object_pairs_hook=OrderedDict)
            if jData['factionID'] in FactionsToDuplicate:
                newId = f'{jData["factionID"]}{Year}'
                factionDefId = f'{jData["ID"]}{Year}'
                factionsAddedMap[jData['factionID']] = newId
                factionDefIdsMap[newId] = factionDefId
                jData["factionID"] = newId
                jData["ID"] = factionDefId
                filePath = os.path.join(FactionDir, factionDefId + '.json')
                with open(filePath, 'wb') as fd:
                    bData = json.dumps(jData, indent=4, ensure_ascii=False).encode()
                    fd.write(bData)


for faction in FactionsToDuplicate:
    if faction not in factionsAddedMap:
        raise Exception(f'Faction {faction} not found')

fpEnablerData = None
with open(FpEnablerSettingsFile, 'rb') as f:
    fpEnablerData = json.loads(f.read(), object_hook=OrderedDict, object_pairs_hook=OrderedDict)
for key in factionsAddedMap:
    fpEnablerData["excludedFactions"].append(factionsAddedMap[key])

with open(FpEnablerSettingsFile, 'wb') as f:
    f.write(json.dumps(fpEnablerData, indent=4, ensure_ascii=False).encode())

ismSettingsData = None
with open(IsmLogoFile, 'rb') as f:
    ismSettingsData = json.loads(f.read(), object_hook=OrderedDict, object_pairs_hook=OrderedDict)

for key in factionsAddedMap:
    for logo in ismSettingsData["logos"]:
        if logo["factionName"] == key:
            newEntry = OrderedDict()
            newEntry["factionName"] = factionsAddedMap[key]
            newEntry["logoImage"] = logo["logoImage"]
            ismSettingsData["logos"].append(newEntry)
            break

factionEnumData = None
with open(FactionEnum, 'rb') as f:
    factionEnumData = json.loads(f.read(), object_hook=OrderedDict, object_pairs_hook=OrderedDict)

highestEnumValue = 0
for faction in factionEnumData["enumerationValueList"]:
    if faction["ID"] > highestEnumValue:
        highestEnumValue = faction["ID"]


for key in factionDefIdsMap:
    highestEnumValue += 1
    newEntry = OrderedDict()
    newEntry["ID"] = highestEnumValue
    newEntry["Name"] = key
    newEntry["FriendlyName"] = key
    newEntry["Description"] = ""
    newEntry["FactionDefID"] = factionDefIdsMap[key]
    newEntry["IsRealFaction"] = True
    newEntry["IsGreatHouse"] = False
    newEntry["IsClan"] = False
    newEntry["IsMercenary"] = False
    newEntry["IsPirate"] = False
    newEntry["DoesGainReputation"] = False
    newEntry["CanAlly"] = False
    newEntry["IsProceduralContractFaction"] = False
    newEntry["IsPossibleNeutralToAllFaction"] = False
    newEntry["IsPossibleHostileToAllFaction"] = False
    newEntry["IsPossibleAllyFallbackFaction"] = False
    newEntry["IsCareerScoringFaction"] = False
    newEntry["IsCareerIgnoredContractTarget"] = False
    newEntry["IsCareerStartingDisplayFaction"] = False
    newEntry["IsStoryStartingDisplayFaction"] = False
    newEntry["HasAIBehaviorVariableScope"] = False
    factionEnumData["enumerationValueList"].append(newEntry)

with open(FactionEnum, 'wb') as f:
    f.write(json.dumps(factionEnumData, indent=4, ensure_ascii=False).encode())