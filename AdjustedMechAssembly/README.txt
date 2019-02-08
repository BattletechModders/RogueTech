# AdjustedMechAssembly
BattleTech mod (using ModTek) that makes mechs, that have been assembled by parts, spawn in the mechbay completly broken.

## Requirements
* install [BattleTechModLoader](https://github.com/Mpstark/BattleTechModLoader/releases) using the [instructions here](https://github.com/Mpstark/BattleTechModLoader)
* install [ModTek](https://github.com/Mpstark/ModTek/releases) using the [instructions here](https://github.com/Mpstark/ModTek)

## Features
- Assembled mechs from parts appear in your mechbay broken.
- This makes it more realistic, because you have to spent time and money to actually bring them to the field.

## Download

Downloads can be found on [github](https://github.com/Morphyum/BrokenSalvagedMechs/releases).

## Settings
Setting | Type | Default | Description
--- | --- | --- | ---
HeadRepaired | bool | default false | Head has a 100% chance to appear in mechbay already repaired.
LeftArmRepaired | bool | default false | Left arm has a 100% chance to appear in mechbay already repaired.
RightArmRepaired | bool | default false | Right arm has a 100% chance to appear in mechbay already repaired.
CentralTorsoRepaired | bool | default false | Center torso has a 100% chance to appear in mechbay already repaired.
LeftTorsoRepaired | bool | default false | Left torso has a 100% chance to appear in mechbay already repaired.
RightTorsoRepaired | bool | default false | Right torso has a 100% chance to appear in mechbay already repaired.
LeftLegRepaired | bool | default false | Left leg has a 100% chance to appear in mechbay already repaired.
RightLegRepaired | bool | default false | Right leg has a 100% chance to appear in mechbay already repaired.
RepairMechLimbs | bool | default false | Activate random repair chance for limps not set to true above.
RepairMechLimbsChance | float | default 0.75 | The chance for each limp to be repaired.
RandomStructureOnRepairedLimbs | bool | default false | Will make repaired limps spawn with a random number of sctructure points left.
RepairMechComponents | bool | default false | Toggles if the mech spawns with or without it's component(weapons and so on) repaired or destroyed.
RepairComponentsFunctionalThreshold | float | default 0.25 | Chance any repaired componant has to be completely repaired when RepairMechComponents is set to true.
RepairComponentsNonFunctionalThreshold | float | default 0.5 | Chance any repaired componant has to be broken(but repairable) when RepairMechComponents is set to true.
AssembleVariants | bool | default true | Mechs of the same base model and same tonnage will now be assembled when the max partcount is reached, the actual mech that gets assembled is chance based with more parts = higher chance.

Every componant that is neither Functional nor NonFunctional will be destroyed even so you set RepairMechComponents to true.
    
## Install
- After installing BTML, put  everything into \BATTLETECH\Mods\ folder.
- If you want different settings set it in the settings.json.
- Start the game.
