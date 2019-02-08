# AdjustedMechSalvage
AdjustedMechSalvage is a BattleTech mod (using ModTek) that changes the rules which generate partial mech salvage.

## Requirements
* install [BattleTechModLoader](https://github.com/Mpstark/BattleTechModLoader/releases) using the [instructions here](https://github.com/Mpstark/BattleTechModLoader)
* install [ModTek](https://github.com/Mpstark/ModTek/releases) using the [instructions here](https://github.com/Mpstark/ModTek)

## Features
- Your own mechs now get destroyed and leave behind salvage.
- Number of salvage is now based the number of parts you destroyed.
- Each arm or leg which is destroyed reduces the partial mech salvage generated.
	-- 3 partial mech salvage are required for a full mech unless changed.
	-- for each arm or leg destroyed, divide that number (3, or custom) by 5.
	-- round the total and generate partial mech salvage by subtracting it from DefaultMechPartMax (again, 3 by default).
- Destroying center torso always results in 1 salvage unless the mod setting centerTorsoHasCustomSalvageValue is set to true.

## Example: 
DefaultMechPartMax is set to 5:
- both legs destroyed : (5 / 5 + 5 / 5) = 2.  Subtracting 2 from 5, you obtain 3 partial mech salvage.

DefaultMechPartMax is set to 3 or 5 and centerTorsoHasCustomSalvageValue set to false:
- (each case because center torso always yields only 1)
- CT destroyed, rightleg destroyed = 1 partial mech salvage.
- CT destroyed destroyed = 1 partial mech salvage.
- CT destroyed, rightleg destroyed, leftarm destroyed = 1 partial mech salvage.

DefaultMechPartMax is set to 3:
- right arm, right leg destroyed : (3 / 5 + 3 / 5) = 1.2, rounded to 1.  Subtracting 1 from 3, you obtain 2 partial mech salvage.

## Download
Downloads can be found on [github](https://github.com/Morphyum/AdjustedMechSalvage/releases).
    
## Settings
- ownMechsForFree - bool - default false - Places the parts of the mechs you loose yourself directly into your inventory instead of making you salvage them.
- ejectRecoveryBonus - float - default 0 - Flat Bonus to your recovery chance if you punshed out.
- incapacitatedRecoveryBonus - float - default 0 - Flat Bonus to your recovery chance if pilot got incapacitated.
- centerTorsoSalvageValue" - float - default 0 - Sets how much salvage is generated from a mech with center torso destroyed.

Example: RecoveryRate set to 0.5 -> Can rolls 0-1 0.6 -> eject bonus is 0.15 -> 0.5 + 0.15 = 0.65 -> 0.6 is smaller then 0.65 so mech is recovered
       
## Install and use
- After installing BTML and ModTek, put the AdjustedMechSalvage folder into the \BATTLETECH\Mods\ folder.
- Optionally, change DefaultMechPartMax or any other settings in mods\AdjustedMechSalvage\StreamingAssets\data\simGameConstants\simGameConstants.json and settings.json
- Start the game
