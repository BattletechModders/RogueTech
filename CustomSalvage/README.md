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

**`AllwaysRecover`** - lost mech allways return to player

**`NeverRecover`** - lost mech allways lost

### PartCountType

How to calculate number of Parts you get from mech

**Vanila** - base 1 for destroyed ct, 2 for legs, 3 for head/eject

**VanilaAdjusted** - same, but proportional to needed parts for assembly option

- `float VACTDestroyedMod = 0.35f` - num of parts you get when ct destroyed
- `float VABLDestroyedMod = 0.68f` - num of parts you get when legs destroyed

**PartDestroyed** - CC method, less parts for each destroyed location

Additional options
- `int CenterTorsoDestroyedParts = 1` - parts get if CT destroyed
- `public float SalvageArmWeight = 0.75f`
- `public float SalvageLegWeight = 0.75f`
- `public float SalvageTorsoWeight = 1f`
- `public float SalvageHeadWeight = 0.5f`

Formula is `NumParts = MaxParts * survived_part_weight / total_part_weight`

### LostMechActionType 
Defines what to do with your lost mech

**ReturnItemsToPlayer** - undestroyed items will return to player(Vanila way)

**ReturnItemsAndPartsToPlayer** - MechParts and items will return to player

**MoveItemsToSalvage** - items put on salvage list and can be looted

**MoveItemsAndPartsToSalvage** - items and mechparts put on salvage list

### other salvage options

- `bool SalvageTurrets = true` - add turrets to salvage
- `bool UpgradeSalvage = false` - salavaged items have chance to upgrade to "+" variants(not span into player lost mech items if they go to salvage)
- `float SalvageTurretsComponentChance = 0.33f` - in vanila game turret components dont broke, and usually turret have a lot of weapon. so this modifier give less salvage for balance
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
- `float MinPartsToAssembly = 0.5` - minimum parts equere to asembly = MaxParts * MinPartsToAssembly rounded up
- `string[] ExcludeTags = { "BLACKLISTED" }` - list of tags that exclude mech from variants assembly
- `string[] ExclideVariants = { }` - list of mech variants excluded variants assembly
- `int MaxVariantsInDescription = 5` - max number of lines added to description. more then this will be rolled up to " and X variants more"

- `float AdaptPartBaseCost = 0.02f` - base price for adapt other variant part. mechcost * this / partsmax. recomended value = 0.02 for vanila, 0.15 for RT
- `float MaxAdaptMod = 5f` - maximum multiplier for part cost(mod based on mech cost difference. x5 very big value)
- `float AdaptModWeight = 2f` - affect of price difference to part adaptation cost. ( 1 + abs(basepartcost - otherpartcost)/basepartcost*this)


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

- `float RepairMechLimbsChance = 0.75f` - chance for repair location
- `public bool RandomStructureOnRepairedLimbs = true` - repaired location have randoimized structure
- `public float MinStructure = 0.25f` - minimum structure of repaired location
- `bool RepairMechComponents = true` - need to repair components(components on destroyed location will be destroyed anyway)
- `float RepairComponentsFunctionalThreshold = 0.25f` - chance to get fully repaired component
- `float RepairComponentsNonFunctionalThreshold = 0.5f` - chance to get broken, but repairable component.

----------------
## Thanks:

@Morphyum for broke mech code from https://github.com/Morphyum/AdjustedMechAssembly

@Mpstark for dialog relaed stuff from https://github.com/BattletechModders/SalvageOperations






