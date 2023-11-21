import json
from collections import OrderedDict
import os
import os.path

factionIds = []
blackList = ["MagistracyCentrella", "MajestyMetals", "Nautilus", "MercenaryReviewBoard", "Betrayers", "AuriganMercenaries", "INVALID_UNSET"]
FactionDir = '../../Core/RogueTechCore/Factions/'

for fp in os.listdir(FactionDir):
    if fp.endswith('.json'):
        with open(os.path.join(FactionDir, fp), 'rb') as f:
            jData = json.loads(f.read(), object_hook=OrderedDict, object_pairs_hook=OrderedDict)
            if jData['factionID'] not in blackList:
                factionIds.append(jData['factionID'])

for fp in os.listdir(FactionDir):
    if fp.endswith('.json'):
        jData = None
        with open(os.path.join(FactionDir, fp), 'rb') as f:
            jData = json.loads(f.read(), object_hook=OrderedDict, object_pairs_hook=OrderedDict)
        if 'OrienteProtectorat' in jData['Enemies']:
            jData['Enemies'].remove('OrienteProtectorat')
        if jData['factionID'] not in blackList:
            for faction in factionIds:
                if faction not in jData['Enemies'] and faction != jData['factionID']:
                    jData['Enemies'].append(faction)
            with open(os.path.join(FactionDir, fp), 'wb') as f:
                bData = json.dumps(jData, indent=4, ensure_ascii=False).encode()
                f.write(bData)
