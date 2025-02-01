import json
from collections import OrderedDict
import os
import os.path
import pprint




FactionDir = '../../Core/RogueTechCore/Factions/'
FactionEnum = '../../Core/RogueTechCore/Faction.json'
FpEnablerSettingsFile = '../../DLC/RogueFlashPointModule/settings.json'


existingFactions = []
highestEnumValue = 0
factionsAddedMap = {}
factionDefIdsMap = {
}

factionEnumData = None
with open(FactionEnum, 'rb') as f:
    factionEnumData = json.loads(f.read(), object_hook=OrderedDict, object_pairs_hook=OrderedDict)


for faction in factionEnumData["enumerationValueList"]:
    if faction["ID"] > highestEnumValue:
        highestEnumValue = faction["ID"]

    if faction['Name'] not in existingFactions:
        existingFactions.append(faction['Name'])

for fp in os.listdir(FactionDir):
    if fp.endswith('.json'):
        with open(os.path.join(FactionDir, fp), 'rb') as f:
            jData = json.loads(f.read(), object_hook=OrderedDict, object_pairs_hook=OrderedDict)
            if jData['factionID'] not in existingFactions:
                factionsAddedMap[jData['factionID']] = jData['ID']


fpEnablerData = None
with open(FpEnablerSettingsFile, 'rb') as f:
    fpEnablerData = json.loads(f.read(), object_hook=OrderedDict, object_pairs_hook=OrderedDict)
for key in factionsAddedMap:
    fpEnablerData["excludedFactions"].append(factionsAddedMap[key])

with open(FpEnablerSettingsFile, 'wb') as f:
    f.write(json.dumps(fpEnablerData, indent=4, ensure_ascii=False).encode())


for key in factionsAddedMap:
    highestEnumValue += 1
    newEntry = OrderedDict()
    newEntry["ID"] = highestEnumValue
    newEntry["Name"] = key
    newEntry["FriendlyName"] = key
    newEntry["Description"] = ""
    newEntry["FactionDefID"] = factionsAddedMap[key]
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