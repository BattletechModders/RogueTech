# ArmorRepair
A BattleTech mod that introduces an armor repair mechanic into the game.

ArmorRepair does this by automatically generating Mech Bay work orders to replace any lost mech armor after battles, for a time and cost just as if you added armor to a mech in the mech bay. 

The mod also uses the same system to create automatic structural repair orders after battles (you can disable this in the mod.json settings).

The intent of this mod is to provide a "Mech Fatigue" style mechanic, where mechs taking hits in battle actually costs your merc company some time and cbills to sort out. This ultimately should slow the pace
of snowballing in a campaign, and with the repairs scaled by tonnage it will also help other mods in creating a more meaningful decision over which mechs to take, and to risk, on different missions.


## Requirements
* install [BattleTechModLoader](https://github.com/Mpstark/BattleTechModLoader/releases) using the [instructions here](https://github.com/Mpstark/BattleTechModLoader)
* install [ModTek](https://github.com/Mpstark/ModTek/releases) using the [instructions here](https://github.com/Mpstark/ModTek)
* install [CustomComponents](https://github.com/BattletechModders/CustomComponents/releases)

## Recommended Mods
* TBC pending real play testing :)

## Features
- Armor loss now matters
- Less busywork with basic repairs... Let Yang take care of typical armor/structure repairs.
- Automated repair work orders can be cancelled safely, and will refund any sub items not paid for.
- Scales both structure and armor costs with the mech tonnage, making Light mechs more cost effective on milk runs, and taking Heavy/Assault mechs more of a consideration than the only choice.

## IMPORTANT NOTES
* Armor Tech Costs:
	* The vanilla SimGameConstants setting `ArmorInstallTechPoints` had to be increased in this mod by a factor of 100 to make armor repairs work correctly. 
	* This is because Harebrained Schemes set it up as an integer (a whole number). By default, even setting it to its lowest usable integer value (1) resulted in massive armor modification / repair times, and we needed much more flexibility than that overall.
	* When tweaking this setting in SimGameConstants while using this mod, bear in mind it needs to be much higher than it would be in vanilla. For example, an `ArmorInstallTechPoints` setting of 100 with this mod would be equal to 1 in vanilla.
* Disabling Mech Tonnage Cost Scaling:
	* If you disable the `scaleStructureCostByTonnage` or `scaleArmorCostByTonnage` functionality, remember to lower the relevant costs in the mod's SimGameConstants.json accordingly.
* Unused Tonnage warnings in Mech Bay:
	* We have had to use the Unused Tonnage warning symbol in the mech bay to flag up when a mech's repair work orders have been completed, but the mech has damaged components on it (e.g. a destroyed heatsink)
	* This is just because it was easily available, and HBS don't specifically have a warning flag or check for destroyed components, and otherwise it wasn't obvious to the player something was wrong with the mech.

## Download
Downloads can be found on [github](https://github.com/citizenSnippy/ArmorRepair/releases).

## Installation
* After installing BTML and ModTek, unpack everything from the release zip into the \BATTLETECH\Mods\ folder.
	* This must result in you having a folder called \BATTLETECH\Mods\ArmorRepair\ with the ArmorRepair.dll file in it, otherwise the mod has not been unpacked correctly!
* If you want to enable / disable mod features like automatic structure repair orders, or mech tonnage scaling, edit the Settings in the mod.json file.
* If you want to adjust the Armor / Structure costs, you'll need to edit \Mods\ArmorRepair\StreamingAssets\data\simGameConstants\SimGameConstants.json
* Start the game.

## CustomComponents

### ArmorRepair
Control cost of armor repair, set by armor item. Parameters
Setting | Default | Description
ArmorTPCost | 1 | multiplier for armor repair techpoints cost
ArmorCBCost | 1 | multiplier for armor repair cbills cost

### StructureRepair
Control cost of structure repair, set by structure item. Parameters
Setting | Default | Description
StructureTPCost | 1 | multiplier for structure repair techpoints cost
StructureCBCost | 1 | multiplier for structure repair cbills cost

## Repair Cost By Tag

You can use tags to change repair cost of armor or structure. Tags sets on chassis(work for both armor and structure), armor item(only armor repair cost affected) or structure item(only structure repair)

To set flag use  RepairCostByTag parameter in mod.json. This is a list of RepairCost records with given parameters(if multipliers is lower or equal 0 - it will be replaced with 1)
```
		"RepairCostByTag" : [
			{
				"Tag" : "SOME_TEMPLATE_TAG",
				"ArmorTPCost" : 1,
				"ArmorCBCost" : 1,
				"StructureTPCost" : 1,
				"StructureCBCost" : 1
			}
		]
```

## mod.json Settings
Setting | Type | Default | Description
--- | --- | --- | ---
enableStructureRepair | boolean | default true | Whether to automatically issue structure damage repair work orders
scaleStructureCostByTonnage | bool | default true | Set to false if you don't want to scale structure repair time/costs by mech tonnage
scaleArmorCostByTonnage | bool | default true | Set to false if you don't want to scale armor repair time/costs by mech tonnage
enableAutoRepairPrompt | bool | default true | Set to false if you don't want Yang to summarise repair costs and ask if you want him to auto-repair 'Mechs
autoRepairMechsWithDestroyedComponents | bool | default true | Set to false to never auto-repair 'Mechs if they have destroyed components
ArmorCategory | string | default "Armor" | CategoryID for armor item
StructureCategory | string | default | Sttructure | CategoryID for structure item
debug | bool | default true | Set this to false to turn off debug logging (See ArmorRepair\Log.txt)
RepairCostByTag | list of RepairCost | default empty | set repair cost by tag


## SimGameConstants.json Settings
Setting | Type | Default | Description
--- | --- | --- | ---
StructureRepairTechPoints | float | default 0.7 | Number of tech points to repair structure. With mech tonnage scaling enabled, this is a maximum - you will typically only pay 30-50% of this early game.
StructureRepairCost | float | default 600 | Number of cbills to repair structure. With mech tonnage scaling enabled, this is a maximum - you will typically only pay 30-50% of this early game.
ArmorInstallTechPoints | float | default 25 | Number of tech points to repair armor (remember this is divided by 100 so this is equivalent 0.35 of StructureRepairTechPoints. With mech tonnage scaling enabled, this is a maximum - you will typically only pay 30-50% of this early game. 
ArmorInstallCost | float | default 150 | Number of cbills to repair armor. With mech tonnage scaling enabled, this is a maximum - you will typically only pay 30-50% of this early game.
MechLabRefundModifier | float | default 1.0 | This enables full refunds of work orders now that we are generating them automatically. In vanilla this is 0.9 for a 90% rebate on cancelling work orders.

## Credits
All credit to [Beaglerush](https://www.twitch.tv/beagsandjam) for the whole mod concept, and for the interesting mechanics discussions & help along the way.

Many thanks to everyone over at the [BattleTech Discord](https://discord.gg/zRptMZD) - in particular Morphyum, LadyAlekto and mpstark for their assistance.

Also cheers to HBS for another damn fine game!