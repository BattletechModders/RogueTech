# CusomSalvage

CustomSalvage - mod that allow customize salvage and assembly operations

## Salvage Options

### RecoveryType

How to define if you lost mech will return to you or need to recovered. Options

**Vanila** - Base Game variant. Roll vs fixed chance

**PartDestroyed** - Custom components based. 

Additional options
- `float RecoveryMod = 1` - multiplier to base game recovery chance
- `float LimbRecoveryPenalty = 0.05f` - penalty for lost leg or arm(each lost limb applied)
- `float TorsoRecoveryPenalty = 0.1f` - penalty for lost torso port(include CT)
- `float HeadRecoveryPenaly = 0` - for lost head
- `float EjectRecoveryBonus = 0.25f` - additional bonus if pilot ejected

**`AlwaysRecover`** - lost mech allways return to player

**`NeverRecover`** - lost mech allways lost

### PartCountType

How to calculate number of Parts you get from mech

**Vanila** - base 1 for destroyed ct, 2 for legs, 3 for head/eject

**VanilaAdjusted** - same, but proportional to needed parts for assembly option

- `float VACTDestroyedMod = 0.35f` - num of parts you get when ct destroyed
- `float VABLDestroyedMod = 0.68f` - num of parts you get when legs destroyed

**PartDestroyed** - CC method, less parts for each destroyed location, CT destroyed always give CenterTorsoDestroyedParts parts.

**PartDestroyedIgnoreCT** - CC method, each destroyed part affect how many parts you get


Additional options
- `int CenterTorsoDestroyedParts = 1` - parts get if CT destroyed, only for PartDestroyed

Weight of part into total part count
- `public float SalvageArmWeight = 0.75f`
- `public float SalvageLegWeight = 0.75f`
- `public float SalvageTorsoWeight = 1f`
- `public float SalvageHeadWeight = 0.25f`
- `public float SalvageCTWeight = 1.5f` - only for  PartDestroyedIgnoreCT

Formula is `NumParts = MaxParts * survived_part_weight / total_part_weight`

### LostMechActionType 
Defines what to do with your lost mech

**ReturnItemsToPlayer** - undestroyed items will return to player(Vanila way)

**ReturnItemsAndPartsToPlayer** - MechParts and items will return to player

**MoveItemsToSalvage** - items put on salvage list and can be looted

**MoveItemsAndPartsToSalvage** - items and mechparts put on salvage list

### other salvage options

- `public bool AllowDropBlackListed = false` - allow to drop BLACKLISTED tag items
- `bool SalvageTurrets = true` - add turrets to salvage
- `bool UpgradeSalvage = false` - salavaged items have chance to upgrade to "+" variants(not span into player lost mech items if they go to salvage)
- `float SalvageTurretsComponentChance = 0.33f` - in vanila game turret components dont broke, and usually turret have a lot of weapon. so this modifier give less salvage for balance

#### full units salvage
- `bool FullEnemyUnitSalvage = true` - allow to salvage units without dissassemling to part and components. If enabled units apears in salvage in state they been killed. If you killed mech by destroying legs it appers in salvage with destroyed legs. Same rule for its components destroyed in battle. For mechs there is special rule - if center torso is destroyed it will be dissasembled to parts anyway
- `int MaxFullUnitsInSalvage = 1` - maximum amount of full units in priority salvage. Full units can never apper in random salvage.
- `string FullUnitInfoIcon = "icons8-info"` - if FullEnemyUnitSalvage enabled, you can see actual unit state by clicking its icon in salvage slot. While cursor is hover over unit's icon its actual icon is replaced to this to point active cotrol.
- `float FullUnitRandomSalvageSlotUsingMod = 1f` - if full unit is selected for priority salvage random salvage amount is redused to (DefaultMechPartMax \* FullUnitRandomSalvageSlotUsingMod - 1).
- `bool FullUnitUsedAllRandomSalvageSlots = true` - if enabled any full unit added to priority salvage reduce random salvage amount to 0. Eg. you will only able to get priority salvage. 
- `bool SquadDisassembleComponents = false` - by current rules BA squads are always dissassembled to parts in salvage. If this option enabled its components goes to possible salvage. Option working regardless FullEnemyUnitSalvage state.
- `bool VehicleDisassembleComponents = false` - If this option enabled vehicle components goes to possible salvage if dissasembled to parts. If disabled only vehicle parts will be result of dissassemling. Option working regardless FullEnemyUnitSalvage state.
- `bool VehicleAlwaysDisassembled = false` - If this option enabled vehicles goes to salvage in dissasembled state, otherwise they always go in full state (vehciles have no CT).
- `bool FullUnitUsedAmountOfLootableComponents = true` - If true amount of not destroyed salvagable componetns will be added to required random salvage slots to be able to get full unit as salvage. Needed random salvage slots formula will be (DefaultMechPartMax + <amount of components>) \* FullUnitRandomSalvageSlotUsingMod - 1
- `float FullUnitStructurePersentage = 0.5f` - if above 0f (and FullEnemyUnitSalvage is true) additional rule to detect if unit goes to salvage in disassembled state will be used (regardless type) - percentage of rest structure - if unit have less than FullUnitStructurePersentage of overall structure it goes in disassembled state.

## Assembly options

### recoloring mech icons in storage
- `string StoredMechColor = "#7FFFD4` - Completed mech chassis
- `public string ReadyColor = "#32CD32"` - Mechhave enough parts to assamble
- `public string VariantsColor = "yellow"` - Mech can be assembled using parts of other mechs
- `public string NotReadyColor = "white"` - Mech dont have enough parts to assemble
- `public string ExcludedColor = "magenta"` - Mech excluded from assembly variants

*NOTE: Use beight colors, or they lost on background*

```
"BGColors" : [
  { "Tag" : "unit_assault", "Color" : "#b2babb10" },
  { "Tag" : "unit_heavy", "Color" : "#f0b27a10" },
  { "Tag" : "unit_medium", "Color" : "#82e0aa10" },
  { "Tag" : "unit_light", "Color" : "#85c1e910" }
]
```
Color Background according to mech tags. higher tag in list have prioirty. *NOTE: use low alpha(10 in example) or bg will be too bright*

- `bool AssemblyVariants = true` - Assemble variants. Variants defined by Chassis.PrefabIdentifier(can be overrided by ChassisCustom) and tonnage
- `float MinPartsToAssembly = 0.33` - minimum parts equere to asembly = MaxParts * MinPartsToAssembly rounded up
- `float MinPartsToAssemblySpecial = 0.5` - minimum parts equere to asembly special = MaxParts * MinPartsToAssembly rounded up
- `string[] ExcludeTags = { "BLACKLISTED" }` - list of tags that exclude mech from variants assembly
- `string[] ExclideVariants = { }` - list of mech variants excluded variants assembly
- `special[] SpecialTags = null` - list of tags that mark mech as special and increase price to adapt parts on it
```
"SpecialTags" : [ 
    { "Tag" : "elite_mech", "Mod" : 1.5 }
]
```
- `int MaxVariantsInDescription = 5` - max number of lines added to description. more then this will be rolled up to " and X variants more"

- `float AdaptPartBaseCost = 0.02f` - base price for adapt other variant part. mechcost * this / partsmax. recomended value = 0.02 for vanila, 0.15 for RT
- `float MaxAdaptMod = 5f` - maximum multiplier for part cost(mod based on mech cost difference. x5 very big value)
- `float AdaptModWeight = 2f` - affect of price difference to part adaptation cost. ( 1 + abs(basepartcost - otherpartcost)/basepartcost*this)
- `bool ApplyPartPriceMod = false` - if set to true increase cost of adapting parts from special mech
- `string OmniTechTag = null` - if set, mark mech with this tag as OmniMech. OmniMech can be assembled from one base part and have special multiplier to part cost
- `float OmniSpecialtoSpecialMod = 0.1f` - both mech are special - default 10% of adapt cost
- `float OmniSpecialtoNormalMod = 0.25f` - one mech are normal, second is special - default 25% of part adapt cost
- `float OmniNormalMod = 0f` - both mech are normal, default = free

- `bool AllowScrapToParts = true` - if enabled allow to scrap stored mech chassis to parts
- `float MinScrapParts = 0.51f` - min parts get from scraping mech(MaxParts * this rounded to int. Uses unity rounding so 0.5 give closest odd value)
- `float MaxScrapParts = 0.91f` - max parts get from scrapping mech


- `bool UnEquipedMech = false` - unequip assembled mech 
- `bool BrokenMech = true` - destroy location and equipment of assembled mech

- `public bool RepairMechLimbs = true` - need to try repair locations

- `bool HeadRepaired = false`
- `bool LeftArmRepaired = false`
- `bool RightArmRepaired = false`
- `bool CentralTorsoRepaired = false`
- `bool LeftTorsoRepaired = false`
- `bool RightTorsoRepaired = false`
- `bool LeftLegRepaired = false`
- `bool RightLegRepaired = false`
force repair location

- `float RepairMechLimbsChance = 0.33f` - chance for repair location(biger = better chances) **ATTENTION: Changed in 1.4**
- `public bool RandomStructureOnRepairedLimbs = true` - repaired location have randoimized structure
- `public float MinStructure = 0.25f` - minimum structure of repaired location
- `bool RepairMechComponents = true` - need to repair components(components on destroyed location will be destroyed anyway)
- `float RepairComponentsFunctionalThreshold = 0.25f` - Threshold to get fully repaired component(more - better)
- `float RepairComponentsNonFunctionalThreshold = 0.5f` - Threshold to get broken, but repairable component(more - better)

- `bool RepairChanceByTP = false;` - increase chance to get undamaget limbs and equipment with more 
- `int BaseTP = 10;` - base tp value, if you have more tp - chance increses, if less - decreases (using RepairMechLimbsChance, RepairComponentsFunctionalThreshold, RepairComponentsNonFunctionalThreshold as base)
- `float LimbChancePerTp = 0.01f;` - chance increase for limb per one tp
- `float ComponentChancePerTp = 0.01f;` - chance increase for component per one tp
- `float LimbMinChance = 0.1f;` - limits for limb repair chance
- `float LimbMaxChance = 0.9f;`
- `float ComponentMinChance = 0.1f;`  - limits for component repair chance( ComponentMinChance <= RepairComponentsFunctionalThreshold <= RepairComponentsNonFunctionalThreshold <= ComponentMaxChance)
- `float ComponentMaxChance = 0.95f;`

### component broke chances by tag

Can be used to change mech options by mech or repair tag. All values optional and will be ignored during calculation if missed. If mech have few tags - used average. 

```BrokeByTag = [
	{ "tag" : "hard_to_repair", "BaseTp" : "30", "Limb" : "0.0075", "Component" : "0.0075" },
	{ "tag" : "easy_to_repair", "Limb" : "0.015", "Component" : "0.015" },
	{ "tag" : "poor_maintained", "BaseTp" : "20" }
]
```


# Customs

## AssemblyVariant

```
"AssemblyVariant" : {
	"PrefabID" : "string",
	"Exclude" : false,
	"Inclide" : false,
	
	"ReplacePriceMult" false,
    "PriceMult" : 1,
    "PartsMin" : -1  if >=0 how many parts to start assemble(0-1 float)

}
```

Allow override assembly settings by chassis
- PrefabID - replace ChassisDef.PrefabIdentifier
- Exclude - force exclude mech from variants regardless tags
- Include - forse include mech to variants regardless tags
- ReplacePriceMult - if true discard tags mult and use value from custom only, if false - value multiplicative
- PriceMult - price multiplier for aseembly this mech
- PartsMin - if greater or equal 0 - replace min parts multiplier( = maxparts * this rounded up)

## LootableUniqueMech
```
    "LootableUniqueMech": {
      "ReplaceID": "mechdef_annihilator_ANH-2A",
	  "randomSearchTags":{
		"ShouldHaveTags":[],
		"ShouldNotHaveTags":[],
		"ExcludeSelfTags":[]
	  }
    }
```

Logic:
if player have unit with this chassiss it will try to replace it.
if ReplaceID is not empty - it will just replace current unit to this one.
if ReplaceID is empty it will try to find unit by tags (method is the same as for contract opfor generation, which means CustomUnitsSpawn behavior applied)
if ShouldHaveTags is empty list - it will fill ShouldHaveTags using MechTags, remove ShouldNotHaveTags (from current custom), remove ExcludeSelfTags (from current custom) 
and remove UniqieReplaceSearchExcludeTags (got from mod settings, default "unit_rarity_chassis_unique", "unit_unique")

----------------
## Thanks:

@Morphyum for broke mech code from https://github.com/Morphyum/AdjustedMechAssembly

@Mpstark for dialog relaed stuff from https://github.com/BattletechModders/SalvageOperations






