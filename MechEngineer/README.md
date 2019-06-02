# MechEngineer
BattleTech mod that adds engines and other components to mechs based on TT rules.

## Download

Downloads of the latest release can be found on [github](https://github.com/BattletechModders/MechEngineer/releases).

## Requirements and Installation

either install [RogueTech](https://www.nexusmods.com/battletech/mods/79) for the full MechEngineer experience

or

* install [ModTek](https://github.com/BattletechModders/ModTek/releases) using [instructions here](https://github.com/BattletechModders/ModTek)
* install [CustomComponents](https://github.com/BattletechModders/CustomComponents/releases) using [instructions here](https://github.com/BattletechModders/CustomComponents)
* install MechEngineer by putting it into the \BATTLETECH\Mods\ folder

## Suggested Mods

Use these mods to maximize enjoyment
* [CBT Heat](https://github.com/McFistyBuns/CBTHeat) - replaces overheat damage to be crit rolls
* [CBT Movement](https://github.com/McFistyBuns/CBTMovement) - movement reduces accuracy
* [CBT Piloting](https://github.com/McFistyBuns/CBTPiloting) - mech can stumble by chance
* [Pansar](https://github.com/hokvel/pansar) - applies armor ratio enforcement according to CBT rules

Compatibility Patches
* [JK-ME](https://github.com/17783/JK-ME_Fix) - fixes JK mech variants to work with MechEngineer

## TODOs and Bug Reporting

* see [issues list](https://github.com/BattletechModders/MechEngineer/issues)

## Contributors

Maintainer: CptMoore

* adammartinez271828 - rounding logic
* Aliencreature - ideas, lore and rules, item variants, testing
* Colobos - ideas, lore and rules, item and mech balancing, testing
* CptMoore - ideas, rules, coding, testing, core items
* CrusherBob - ideas, lore and rules, engine rating to walk/sprint distance conversions
* Denadan - ideas, custom components lib, coding
* Gentleman Reaper - ideas, lore and rules, testing
* LadyAlekto - ideas, lore and rules, testing, items
* TotalMeltdown - ideas, lore and rules

## Features

### Arm Actuators

Consists of CustomComponents to help define supported arm actuators of a chassis and define which components are arm actuators.

Also allows components to define an arm accuracy value.

### ArmorStructureChanges

A CustomComponent to change overall structure and armor values of the mech. Works by multipling/divining armor and structure values before/after combat.

### ArmorStructureRatio

A CBT rule enforcement, that armor at every mechs location is not more than 2 times the structure, head is allowed to be 3 times.

Setting | Type | Description
--- | --- | ---
ArmorStructureRatioEnforcement | bool | disable the rule if you want to
ArmorStructureRatioEnforcementSkipMechDefs | string[] | mechs to skip the enforcement for

### AutoFix

Fixes MechDefs, ChassisDefs and MechComponentDefs. Changes the sizes of components, the supported slots of chassis, reclassifies upgrades as CBT components, adds engines to MechDefs.

Reason this is done programmatically, is to allow fixing of save game MechDefs, however all other fixes could be done using ModTek json merging.

Settings:

Setting | Type | Description
--- | --- | ---
AutoFixMechDefSkip | string[] | 
AutoFixUpgradeDefSkip | string[] | 
AutoFixMechDefEngine | bool | 
AutoFixMechDefEngineTypeDef | string | 
AutoFixMechDefCoolingDef | string | 
AutoFixMechDefHeatBlockDef | string | 
AutoFixGyroCategorizer | IdentityHelper | 
AutoFixMechDefGyroAdder | AddHelper | 
AutoFixGyroSlotChange | ValueChange<int> | 
AutoFixCockpitCategorizer | IdentityHelper | 
AutoFixMechDefCockpitAdder | AddHelper | 
AutoFixCockpitTonnageChange | ValueChange<float> | 
AutoFixCockpitSlotChange | ValueChange<int> | 
AutoFixMechDefArmActuator | bool | 
AutoFixArmActuatorCategorizer | IdentityHelper | 
AutoFixArmActuatorSlotChange | ValueChange<int> | 
AutoFixLegUpgradesCategorizer | IdentityHelper | 
AutoFixLegUpgradesSlotChange | ValueChange<int> | 
AutoFixArmorCategorizer | IdentityHelper | 
AutoFixMechDefArmorAdder | AddHelper | 
AutoFixStructureCategorizer | IdentityHelper | 
AutoFixMechDefStructureAdder | AddHelper | 
AutoFixChassisDefSkip | string[] | 
AutoFixChassisDefSlotsChanges | ChassisSlotsChange[] | 
AutoFixChassisDefInitialTonnage | bool | 
AutoFixChassisDefInitialToTotalTonnageFactor | float | 
AutoFixChassisDefMaxJumpjets | bool | 
AutoFixChassisDefMaxJumpjetsCount | int | 
AutoFixChassisDefMaxJumpjetsRating | int | 
AutoFixWeaponDefSlotsChanges | WeaponSlotChange[] |

IdentityHelper

Field | Type | Description
--- | --- | ---
AllowedLocations | ChassisLocations | 
ComponentType | ComponentType | 
Prefix | string | 
CategoryId | string | 
AutoAddCategoryIdIfMissing | bool | 

AddHelper

Field | Type | Description
--- | --- | ---
ChassisLocation | ChassisLocations | 
ComponentDefId | string | 
ComponentType | ComponentType | 

ValueChange<T>

Field | Type | Description
--- | --- | ---
From | T | 
By | T | 
FromIsMin | bool | 
NewMin | T? | 

ChassisSlotsChange

Field | Type | Description
--- | --- | ---
Location | ChassisLocations | 
Change | ValueChange<int> | 

WeaponSlotChange

Field | Type | Description
--- | --- | ---
Type | WeaponSubType | 
Change | ValueChange<int> | 

### BTLoadFix

Fixes the vaniella issue with items missing in inventory until exiting the mechlab and reentering it.

### ChassisQuirks

The CustomComponent allows to attach status effects to chassis, to make those more unique. Avoids having to introduce fake/fixed equipment to a mech.

### ComponentExplosions

Vanilla simulates CASE protected compartments for all locations of a mech. This features introduces CustomComponents to specify if a component can explode and with how much force, as well as CASE components that follow the CBT rules to protect the mech from such explosions. Explosions without CASE containing them will propagate throughout the mech.

### CriticalHitStates

A CustomComponent that allows components to survive multiple critical hits and have different status effects active for each critical level of a component.

### (Bonus-)Descriptions

Display different textual versions of the same bonus in tooltips, slot and inventory elements. Uses CustomComponents.

Setting | Type | Description
--- | --- | ---
BonusDescriptionsBonusTemplate | string | formatting of a single bonus entry
BonusDescriptionsDescriptionTemplate | string | format of how all bonus entries are wrapped
BonusDescriptions | BonusDescriptionSettings[] | the list of bonus descriptions

### DynamicSlots

Used to define dynamic slots a component requires.

Settings:

Setting | Type | Description
--- | --- | ---
DynamicSlotsValidateDropEnabled | bool | don't allow dropping of items that would exceed the available slots

### Engines

A major feature of MechEngineer is the introduction of engine items. An engine consists of several parts, each representing a CBT variable in regards to engines.

- **Fusion Core** (e.g. Core 100):
The fusion core rating defines the movement speed, number of jump jets and internal engine heat sinks of a mech.
By default the weight of these items assume standard engine shielding.

- **Engine (Shielding)** (e.g. Std. Engine):
Just called "Engine", it actually represents the shielding of the fusion core.
An XL engine is extra-light shielding for the engine.
In combination with CC and the Weights feature, shielding differs in size and influences the fusion core weight.

- **Mech Cooling System** (e.g. Cooling DHS):
When choosing a heat sink system for the mech, in CBT one has to decide between standard and double heat sinks.
Since the engine heat sink type is derived from the mechs heat sink system, this is still part of the Engine feature.

- **Engine Cooling System** (e.g. E-Cooling + 2):
In CBT additional heat sinks can be added to engines for core sizes 275 and higher,
this item represents the additional heat sinks added.

All these items are linked together in case of receiving critical hits, and if any engine item is destroyed, all of them flagged as destroyed.
The `EngineCriticalHitStates` setting defines what happens on critical hits.

Settings:

Setting | Type | Description
--- | --- | ---
DefaultEngineHeatSinkId | string | default heat sink type for engines without a kit
EngineMissingFallbackHeatSinkCapacity | int | heat sink capacity if no engine is detected

Settings-Section: CBTMovement

Setting | Type | Description
--- | --- | ---
UseGameWalkValues | bool | set to false to use TT walk values
JJRoundUp | bool | this setting controls if the allowed number of jump jets is rounded up or down
TTWalkMultiplier | float | translate TT movement values to game movement values
TTSprintMultiplier | float | translate TT movement values to game movement values
EngineCriticalHitStates | CriticalHitStates | the critical hit states that apply to an engine
MinimumHeatSinksOnMech | int | minimum heatsinks a mech requires
EnforceRulesForAdditionalInternalHeatSinks | bool | can't have those juicy ++ cooling systems with smaller fusion cores than the rules allow it
AllowMixingHeatSinkTypes | bool | only useful for patchwork like behavior

### HardpointFix

see other section and put here

#### HardpointFixMod

Originally a standalone mod, it is now incorporated into MechEngineer.

### InvalidInventory

Makes sure that InvalidInventory issues with mech loadouts are properly rejected in skirmish and campaign play.

### InventorySorter

A CustomComponent that allows specifying a sorting key that is used in the inventory part of the MechLab.

### MechLabSlots

This patches the machlab, so changes to the chassis slot count are visually represented in the mechlab.

### SaveMechToFile

Saves the mechdef to a file when confirming a mech in the mechlab. Useful when modding new mechdefs.

Setting | Type | Description
--- | --- | ---
SaveMechDefOnMechLabConfirm | bool | only enable it if you want to

### ShutdownInjuryProtection

Small patches to enable injury incase the mech shuts down or the heat threshold is stepped over.

Setting | Type | Description
--- | --- | ---
HeatDamageInjuryEnabled | bool | when overheating, injure the pilot
ShutdownInjuryEnabled | bool | when shutting down due to overheating, injure the pilot

### Weights

The Weights CustomComponent influences various weights of the mech.

Setting | Type | Description
--- | --- | ---
ArmorRoundingPrecision | float? | overwrite the weight precision for armor points

### Misc

Additional CC categories are added to the game.

Additional CC tag restrictions are added to the game.

Setting | Type | Description
--- | --- | ---
FractionalAccountingPrecision | float | change to 0.001 for kg fractional accounting precision

To see a complete list of settings look into see the
[Settings Source Code](https://github.com/BattletechModders/MechEngineer/blob/master/source/MechEngineerSettings.cs)
for all available settings.

#### Components

Some of the components introduced are only aesthetic or placeholders for the converted upgrades.

RogueTech introduces more components.

Cockpit | test only
--- | ---
standard | -
small | yes
cockpit upgrades* | -

*\*vanilla upgrades are auto-converted to be the items themselves*

Gyro | test only
--- | ---
standard | -
gryo upgrades* | -

*\*vanilla upgrades are auto-converted to be the items themselves*

Engine Core | test only
--- | ---
rating 005-400 | -

engine type | test only
--- | ---
std | -
xl | -
compact | yes
light | yes
cxl | yes
xxl | yes
cxxl | yes

E-Cooling | test only
--- | ---
DHS | -
CDHS | yes

Heat Sink | test only
--- | ---
Clan Double Heat Sink | yes

Armor | test only
--- | ---
standard | -
ferros-fibrous | -
clan ferros-fibrous | yes
light ferros-fibrous | yes
heavy ferros-fibrous | yes
stealth | yes

Structure | test only
--- | ---
standard | -
endo-steel | -
clan endo-steel | yes
endo-composite | yes

#### HardpointFixMod

Originally a standalone mod, it is now incorporated into MechEngineer.

- Fix bad visual loadout issues, sometimes the wrong or ugly looking loadout was shown, a new algorithm should improve upon this.
  Sometimes attaching a PPC after having already attached many small lasers would hide the PPC, this should be fixed now.
- Restrict weapon loadouts to what is supported by the mech model.
  BattleTech has some of the best looking models due to MWO, however we never know what mechs support which model hardpoints and therefore we might mount weapons that can't be shown.

An example of how the weapon loadout restrictions feature work for the Highlander assault mech:
The left torso has 2 missle hardpoint slots, however only one can mount an LRM20, the other is limited to LRM10. Without this mod you can mount an LRM20 also for the second slot, but it visually would only be showing up as LRM10. With this mod you can't mount the second LRM20 anymore, you have to take either an LRM10 or LRM5. Of course SRMs are still an option.
The left arm is also limited to an LRM15 and you can't mount an LRM20 at all.

There are currently the following configuration settings available:

Settings-Section: HardpointFix

Setting | Type | Default | Description
--- | --- | --- | ---
EnforceHardpointLimits | bool | false | set this to false to deactivate the hardpoint limits in mechlab
AllowDefaultLoadoutWeapons | bool | true | always allow to reattach weapons the mech comes with by default
AllowLRMInSmallerSlotsForAll | bool | true | set this to false so only mechs with a proper sized hardpoint can field an LRM20.
AllowLRMInSmallerSlotsForMechs | string[] | default ["atlas"] | a list of mechs that can field larger LRM sizes even in smaller slots, even if allowLRMsInSmallerSlotsForAll is false.
AllowLRMInLargerSlotsForAll | bool | true | allow smaller sized LRMs to be used in larger sized hardpoint slots. E.g. an LRM10 should fit into an LRM20 slot.
AutoFixChassisDefWeaponHardpointCounts | bool | false | changes the hardpoint limits per chassis location based on configured prefabs.

Limitations:

- can't replace weapons by dragging another weapon ontop of it, you have to remove the weapon first and then add another one (you dont have to leave the mechlab for this to work)
