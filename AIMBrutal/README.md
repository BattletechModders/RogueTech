# AIM - Attack Improvement Mod 2.3 development #
For BATTLETECH 1.2.0

- [Features Overview](#features-overview)
- [Installation](#installation)
- [Configuration](#configuration)
- [Settings](#settings)
  * [User Interface Settings](#user-interface-settings)
  * [Targeting Line Settings](#targeting-line-settings)
  * [Called Shot Settings](#called-shot-settings)
  * [Melee and DFA Settings](#melee-and-dfa-settings)
  * [Individual Modifier Settings](#individual-modifier-settings)
  * [Net Hit Modifier Settings](#net-hit-modifier-settings)
  * [Hit Roll Settings](#hit-roll-settings)
  * [Hit Chance Preview Settings](#hit-chance-preview-settings)
  * [Critical Hit Settings](#critical-hit-settings)
  * [Hit Resolution Settings](#hit-resolution-settings)
  * [Attack Log Settings](#attack-log-settings)
- [Compatibilities](#compatibilities)
- [The Story of AIM](#the-story-of-aim)
- [Learn to Mod](#learn-to-mod)
- [Credits](#credits)


AIM is a BattleTech mod that fixes, enhances, and customise your combat experience, such as coloured facing rings and targeting lines, tune down roll correction, show heat and stability numbers, or a detailed attack log.  The default settings aims to not deviate too far from vanilla.

This mod does *not* modify game data.  Saves made with this mod on will *not* be affected by disabling or removing this mod.

# Features Overview

**ALL features can be enabled or disabled individually.**

## Game Bugs Fixed and HUD Enhancements ##

* Damaged Structure Display fixed and enhanced.
* Grey Head Disease fixed.
* Line of Fire fixed and stylised by type and direction.
* Coloured facing ring and floating armour bar.
* Multi-Target Back Out fixed.
* Make sure 0 HP means dead, never zombie.
* Show Ammo Count in paper doll hover.
* Show Heat and Stability Numbers.
* Show Base Hit Chance in accuracy modifier popup.
* Post-Move To-Hit Penalties (default none) factored in action preview.
* (Optional) Show Mech Tonnage.
* (Optional) Show Corrected Hit chance and Called Shot Chance.

## Mechanic Enhancements ##

* Unlock Hit Chance Stepping to make odd piloting useful.
* Called Shots cluster around called mech location.
* Precise Hit Distribution that improves SRM and MG called shot.
* More Melee Modifiers, and fixes the absent of stood up penalty.
* Directional Attack Bonus.
* Allow Net Bonus Hit modifiers.
* Allow Negative Height Modifier.
* Remove Melee Position Cap.
* Ammo Loader AI that balance ammo usage for less explosion.
* Auto Jettison useless ammo.
* Skip Criting the Dead Mechs.

## Other Adjustables ##

* Tabular Attack Log that can be opened directly in Excel.
* Old Attack Log are archived and auto-deleted.
* Adjustable Roll Correction Strength, default halved.
* Adjustable Miss Streak Breaker.
* Adjustable Base Hit Chance.
* Adjustable Hit Chance stepping and min/max cap.
* Control Display Precision of hit chance and called shot chance.


# Installation

<span style="color:red">
**IMPORTANT Note on upgrading FROM mod version 1.0**:</span>
Rename your old `mod.json` to `settings.json` to keep old settings.

1. Install [BTML and ModTek](https://github.com/janxious/ModTek/wiki/The-Drop-Dead-Simple-Guide-to-Installing-BTML-&-ModTek-&-ModTek-mods).
2. [Download this mod](https://github.com/Sheep-y/Attack-Improvement-Mod/releases), extract in the mod folder. i.e. You should see `BATTLETECH\Mods\AttackImprovementMod\mod.json`
3. Launch the game. The mod will creates a "settings.json" and a mod log in the same folder as `mod.json`.
4. Open `settings.json` to see mod settings.  If you want to change it, restart game to apply changes.


# Configuration

When the mod is first loaded by the game, it will try to read settings.json and validate its settings.

Some configurations are bundled with the mod.  You may copy or rename a setting to `settings.json` to apply it.

* `settings.default.json` - Out of box default.
* `settings.spartan.json` - Enable diminishing modifier, more melee modifiers, more info display, enemy ammo balancing and jettison, and disables roll correction and streak breaker.
* `settings.fix-only.json` - Only enable game fixes for a bug-free vanilla experience.  Enhancements need to be enabled manually.
* `settings.log-only.json` - Disable all features except attack log, which is also enabled in other presets but this has a higher archive cap.

Note that `settings.json` is auto-managed.  Old settings will be upgraded and removed, out of range settings will be corrected, and the formats and comments are fixed.  You can only change setting values.

Unlike many simpler mods, this mod is designed to run as fast as it can be, so don't worry about performance.
Disabled features won't slow down the game and does not modify any code, and normally slow features are usually cached or optimised.

Because of high number of features and flexibility, bugs may slip through tests.
Please report them on [GitHub](https://github.com/Sheep-y/Attack-Improvement-Mod/issues) or [Nexus](https://www.nexusmods.com/battletech/mods/242?tab=bugs).


# Settings

These settings can be changed in `settings.json`.


## User Interface Settings


**Colour Floating Armour Bars**

>  Setting: `FloatingArmorColourPlayer`  (color string, default "cyan")<br>
>  Setting: `FloatingArmorColourEnemy`  (color string, default "")<br>
>  Setting: `FloatingArmorColourAlly`  (color string, default "teal")<br>
>
>  When non-empty, change colour of armour bars floating above field units, making it easier to tell friends from foes.


**Fix Rear Structure Display**

> Setting: `FixPaperDollRearStructure`  (true/false, default true)
>
> The rear structure of the paper dolls are showing front structure on the reverse side because of a typo in the code.  If the front has armour, it means the damaged structure will not be displayed.
>
> When set to true, this mod can fix all paper dolls, including selection panel, target panel, called shot panel, post-mission status, and in mech bay.


**Show Under-Armour Damage**

> Setting: `ShowUnderArmourDamage `  (true/false, default true)
>
> Not sure why the game didn't do this.  When set to true, armour of damaged location will have a striped pattern instead of solid.


**Show Heat and Stability Numbers**

> Setting: `ShowHeatAndStab`  (true/false, default true)
>
> When set to true, display heat and stability numbers in the selection panel (bottom left) and targeting panel (top center), and predicts post action numbers.  Predictions supplied by the game and is subject to all its quirks and bugs and mods.


**Show Unit Tonnage**

> Setting: `ShowUnitTonnage`  (true/false, default false)
>
> When set to true, show mech and vehicle tonnage in selection and target panel.
>
> Duplicates with Extended Information, but AIM override it and use a shorter form for mechs to fit in heat and stability numbers.  Default false because the short form can overwhelm inexperienced players.


**Show Ammo In Tooltip**

> Setting: `ShowAmmoInTooltip`  (true/false, default true)<br>
> Setting: `ShowEnemyAmmoInTooltip`  (true/false, default false)<br>
>
> When set to true, show ammo count in the list of components when you mouseover a location on the paper doll.
>
> The main purpose is to allow you to see the state of each ammo bin and tell whether they are at risk of exploding.


**Fix Multi-Target Back Out**

> Setting: `FixMultiTargetBackout`  (true/false, default true)
>
> The game's Muti-Target back out (escape/right click) is bugged. Backing out from first target will cancel the action, and second back out (regardless of target) will always cancel the whole thing.
>
> When set to true, this mod will make Multi-Target back out deselect targets one by one as expected.



## Targeting Line Settings

**Change Widths of Targeting Lines**

> Setting: `LOSWidth`  (0 to 10, default 2, game default 1)
>
> Set width of all targeting lines (direct, indirect, blocked, can't attack etc.).  Game default is 1  Mod default is 2.
<br>

> Setting: `LOSWidthBlocked`  (0 to 10, default 1.5, game default 0.75)
>
> Set width of obstructed part of an obstructed targeting lines, which is normally thinner than other lines by default.  Game default is 0.75.  Mod default is 1.5.
<br>

> When the mod "Firing Line Improvement" is detected, these settings will be disabled to avoid conflicts.


**Styles and Colours Targeting Lines**

> Setting: `LOSIndirectDotted`  (default true, game default false)<br>
> Setting: `LOSNoAttackDotted`  (default true)<br>
> Setting: `LOSMeleeDotted`  (default false)<br>
> Setting: `LOSClearDotted`  (default false)<br>
> Setting: `LOSBlockedPreDotted`   (default false)<br>
> Setting: `LOSBlockedPostDotted`  (default false)<br>
> Setting: `LOSMeleeColors`  (default "")<br>
> Setting: `LOSClearColors`  (default "")<br>
> Setting: `LOSBlockedPreColors`   (default "#D0F")<br>
> Setting: `LOSBlockedPostColors`  (default "#C8E")<br>
> Setting: `LOSIndirectColors`  (default "")<br>
> Setting: `LOSNoAttackColors`  (default "")<br>
>
> Set the colour and style of various targeting lines.
> Obstructed lines has two parts. The part before obstruction is Pre, and the part after is Post.
>
> Colours are either empty or in HTML hash syntax.  For example `"#F00"` = red, `"#0F0"` = green, `"#00F"` = blue, `"#FFF"` = white, `"#888"` = grey, `"#000"` = black.
> Four parts means RGBA, while three parts mean full opacity RGB.  Supports full and short form. e.g. #28B = #2288BB = #2288BBFF.
>
> Colours and only colours can also vary by attack direction, separated by comma.  The directions are Front, Left, Right, Rear, and Prone, in order.
> If less colours are specified than direction, the missing directions will use the last colour.
> For example "red,cyan,cyan,green" will result in front red, side cyan, and back/prone green.
>
> When the mod "Firing Line Improvement" is detected, these settings will be disabled to avoid conflicts.


**Colours Facing Rings**

> Setting: `FacingMarkerPlayerColors`  (default "#FFFF,#CCFF,#CCFF,#BFBF,#FFBF")<br>
> Setting: `FacingMarkerEnemyColors`  (default "#FFFF,#CCFF,#CCFF,#FBBF,#FFBF")<br>
> Setting: `FacingMarkerTargetColors`  (default "#F41F,#F41F,#F41F,#F41F,#F41F")<br>
>
> When non-empty, change the colours of each arc for friends, foes, and targeted arc during attack.  The colours are for Front, Left, Right, Rear, and Prone.


**Change Widths of Obstruction Marker**

> Setting: `LOSMarkerBlockedMultiplier`  (0 to 10, default 1.5)
>
> Scale the obstruction marker of targeting lines, the "light dot" that split the obstructed line into two. 2 means double width and height, 0.5 means half-half.  Set to 1 to leave at game default.  Set to 0 will not remove them from game but will effectively hide them.
>
> When the mod "Firing Line Improvement" is detected, this setting will be disabled to avoid conflicts.


**Refine or Rough Fire Arc and Jump Arc**

> Setting: `ArcLinePoints`  (2 to 1000, default 48, game default 18)
>
> On a high resolution monitor it is easy to see the hard corners of the arc of indirect targeting lines.  Lines are quick to draw, so this mod will happily improves their qualities for you.
> Set to 2 to make them flat like other lines.  Set to 18 to leave at game default.
>
> When the mod "Firing Line Improvement" is detected, this setting will be disabled to avoid conflicts.


**Fix LoS Inconsistency between Walk and Jump**

> Setting: `FixLosPreviewHeight`  (true/false, default true)
>
> Walk and Jump will sometimes predicts different Line of Sight, because the walking preview height is slightly different from jumping preview height.  Set to true to make them the same.



## Called Shot Settings


**Fix Grey Head Disease**

> Setting: `FixGreyHeadDisease`  (true/false, default true)
>
> Set to true to confine the grey head disease to the boss and not spread.
>
> When anyone, friends or foes, attacks a headshot immune character, all attacks from the same direction will never hit the head ever again.  Every one's head will be grey.  I call it the grey head disease.  It lasts until you load the game.
<br>

> Setting: `FixBossHeadCalledShotDisplay`  (true/false, default true)
>
> Set to true to make sure boss head is always unselectable.
>
> Did you know that grey head in called shot popup is actually a bug?
(I hope it is a bug.)
> If you try to call shot the boss before any headshot-immune unit is attacked, such as right after a load, the head is actually selectable!
> This is most apparent with FixGreyHeadDisease on, since the head will be always available.
>
> If `FixGreyHeadDisease` is true but `FixBossHeadCalledShotDisplay` is false, the boss's head will be selectable for called shot, but it is false hope.  Your shots will never hit the head.


**Enable Clustering Called Shot**

> Setting: `CalledShotUseClustering` (true/false, default true)
>
> When set to true, called shot has a higher chance to hit adjacent locations.
>
> For example, head called shot would bias the head, but also the three torsos to a lesser degree.
>
> This is the default behaviour on and before game version 1.0.4, which was bugged and caused very low called head shot chances since head is excluded from clustering.  The bug is one of the driving forces of this mod's initial creation.  This mod can recreate the clustering effect without the bug.
>
> Note that this does not apply to Vehicle called shot; the default vehicle clustering is only half done, and even when fixed there are too few locations to have meaningful cluster.



**Adjust Called Shot Weight**

> Setting: `MechCalledShotMultiplier`  (0 to 1024.0, default 0.33)
>
> When clustering called shot is enabled, chance to hit called locations will be amplified by clustering weight.  This setting let you tune called shot's weight multipliers.
> Default is 0.33 to counter the effect of CalledShotClusterStrength.  Set to 1.0 would leave original multiplier unchanged, while 0.0 will removing it leaving only clustering effect (if enabled).
<br>

> Setting: `VehicleCalledShotMultiplier`  (0 to 1024.0, default 0.75)
>
> Called shot didn't work on vehicles without modding.  Once that is fixed, unmodified called shot is pretty powerful on vehicles because of its low number of locations.  This setting tries to balance that.


**Show Modded Called Shot Chance**

> Setting: `ShowRealMechCalledShotChance`  (true/false, default true)<br>
> Setting: `ShowRealVehicleCalledShotChance`  (true/false, default true)
>
> When enabled, the popups will reflect modded hit distribution.  Also, if vehicle called shot fix is disabled, vehicle called shot chance will be updated to reflect disabled called shot.


(Advanced) **Format Called Shot Hit Distribution Chances**

> Setting: `CalledChanceFormat`  (string, default "")
>
> Use Microsoft C# [String.Format](https://docs.microsoft.com/en-us/previous-versions/visualstudio/visual-studio-2008/0c899ak8(v=vs.90) syntax to format called shot location chances.
>
> Set to "{0:0.0}%" to always show one decimal, or "{0:0.00}%" for two decimals.
> Leave empty to round them to nearest integer.
>
> Replace the old "ShowDecimalCalledChance" setting in mod version 1.0.


## Melee and DFA Settings


**Allow free Melee and DFA positioning**

> Setting: `IncreaseMeleePositionChoice`  (true/false, default true)<br>
> Setting: `IncreaseDFAPositionChoice`  (true/false, default true)
>
> When set to true, melee and DFA can use all available positions, instead of nearest three.  Compatible with MeleeMover.
>
>
> Setting: `UnlockMeleePositioning`  (true/false, default true)
>
> When enabled, free player units from standing still when target is already in melee range.  Auto-disable to avoid conflict when MeleeMover is used.



## Individual Modifier Settings


**Allow Height Diff Penalty**

> Setting: `AllowLowElevationPenalty`  (true/false, default true)
>
> When set to true, attacking from low ground to high ground will incur an accuracy penalty that is the exact reverse of attacking from high ground to low.
> Game default is false.


**Modify Base Hit Chance**

> Setting: `BaseHitChanceModifier` (-10.0 to 10.0, default 0)<br>
> Setting: `MeleeHitChanceModifier` (-10.0 to 10.0, default 0)
>
> Increase or decrease base hit chance of ranged/melee attacks.
> e.g. -0.05 to lower base accuracy by 5%, 0.1 to increase it 10%.


**Directional Modifier**

> Setting: `ToHitMechFromFront`  (-20 to 20, default 0)<br>
> Setting: `ToHitMechFromSide`  (-20 to 20, default -1)<br>
> Setting: `ToHitMechFromRear`  (-20 to 20, default -2)<br>
> Setting: `ToHitVehicleFromFront`  (-20 to 20, default 0)<br>
> Setting: `ToHitVehicleFromSide`  (-20 to 20, default -1)<br>
> Setting: `ToHitVehicleFromRear`  (-20 to 20, default -2)<br>
>
> Determine the modifier for attacking from side or rear.
> Effective only if "Ditection" is in the modifier lists.


**Jumped Modifier**

> Settings: `ToHitSelfJumped` (-20 to 20, default 0)
>
> The game has self moved modifier and self sprint modifier in CombatGameConstants.json, but not self jumped modifier.
> You may set it with this mod if you want to.



## Net Hit Modifier Settings

**Allow Net Bonus Modifier**

> Setting: `AllowNetBonusModifier`  (true/false, default true)
>
> When set to true, total modifier of an attack can be a net bonus that increases the hit chance beyond the attacker's base hit chance (but still subjects to 95% cap unless lifted by the `MaxFinalHitChance` settings).
> Game default is false.
>
> When the net modifier is a bonus, it will use the same handling as penalty but reversed: first 10 modifiers are ±5% each, and subsequence modifiers are ±2.5% each.


**Unlock Modifier Stepping and Range**

> Setting: `HitChanceStep`  (0.0 to 1.0, default 0)
>
> The game will round down final hit chance to lower 5% by default.
> This affects some calculations, such as rendering odd gunnery stats and piloting stats less effective then they should be.
> Set this to 0 to remove all stepping.  Set it to 0.005 will step the accuracy by 0.5%, and so on.
>
>
> Setting: `MaxFinalHitChance`  (0.1 to 1.0, default 0.95)<br>
> Setting: `MinFinalHitChance`  (0.0 to 1.0, default 0.0)
>
> Use this to set max and min hit chance after all modifiers but before roll correction.
> Note that 100% hit chance may still miss if roll correction is enabled.

**Diminishing Hit Chance Modifier**

> Setting: `DiminishingHitChanceModifier`  (true/false, default false)
>
> Set this to true to enable diminishing return of modifiers, instead of simple add and subtract.
> As a result, small penalties have a bigger effect, but very large penalties may be more bearable.
<br>

> Setting: `DiminishingBonusPowerBase`  (default 0.8)<br>
> Setting: `DiminishingBonusPowerDivisor`  (default 6)<br>
> Setting: `DiminishingPenaltyPowerBase`  (default 0.8)<br>
> Setting: `DiminishingPenaltyPowerDivisor`  (default 3.3)<br>
>
> Bonus formula is "2-Base^(Modifier/Divisor)". <br>
> Example: +3 Bonus = 0.8^(3/6) = -1.1055728 = 110%. <br>
> Thus +3 Bonus @ 80% To Hit = 80% x 110% = 88% final to hit.
>
> Penalty formula is "Base^(Modifier/Divisor)". <br>
> Penalty Example: +6 Penalty = 0.8^(6/3.3) = 0.6665 = 66.7%. <br>
> Thus +6 Penalty @ 80% To Hit = 80% x 66.7% = 53% final to hit.
<br>

> Setting: `DiminishingBonusMax`  (default 16)
> Setting: `DiminishingPenaltyMax`  (default 32)
>
> The modifiers are pre-calculated to run faster.  These settings determine how many results are cached.  Modifiers beyond the max will be regarded as same as max.


**Change Modifiers List**

> Setting: `RangedAccuracyFactors`  (comma separated value)<br>
> Setting: `MeleeAccuracyFactors`  (comma separated value)<br>
>
> A list of hit modifiers of ranged / melee and DFA attacks.  Leave empty to keep unchanged.  Order and letter case does not matter.
>
> Since this feature will override both mouseover display and actual modifier calculation, this will fix the bug that SelfStoodUp is displayed in melee mouseover but not counted in melee modifier.
>
> Ranged default is "ArmMounted, Direction, Height, Indirect, Inspired, Jumped, LocationDamage, Obstruction, Precision, Range, Refire, SelfHeat, SelfStoodUp, SelfTerrain, SensorImpaired, SensorLock, Sprint, TargetEffect, TargetEvasion, TargetProne, TargetShutdown, TargetSize, TargetTerrain, Walked, WeaponAccuracy, WeaponDamage".
> Melee default is "Direction, DFA, Height, Inspired, Jumped, SelfChassis, SelfHeat, SelfStoodUp, SelfTerrainMelee, Sprint, TargetEffect, TargetEvasion, TargetProne, TargetShutdown, TargetSize, TargetTerrainMelee, Walked, WeaponAccuracy".
>
> Options:<br>
> **ArmMounted** - (Ranged) Apply arm mounted modifier if weapon is mounted on an arm. (Melee) Apply arm mount bonus if the punching arm is intact and the attack is not DFA and not against prone mech or vehicle. <br>
> **Direction** - Apply bonus if attack is made from the target's side or rear. <br>
> **DFA** - (Melee) Apply DFA penalty if attack is DFA. <br>
> **Height** - (Ranged) Apply height modifier.  (Melee) Apply one level of height modifier if height different is at least half of melee reach.  DFA height difference is calculated like ranged weapon - from pre-flight attacker position to target position. <br>
> **Indirect** - (Ranged) Apply indirect fire penalty. <br>
> **Inspired** - Apply inspired bonus. <br>
> **Jumped** - Apply jumped penalty after jump, if any. <br>
> **LocationDamage** - (Ranged) Apply location damage penalty, if any. <br>
> **Obstruction** - Apply obstructed penalty. <br>
> **Precision** - (Ranged) Apply Precision Strike bonus. <br>
> **Range** - (Ranged) Apply range penalty. <br>
> **Refire** - Apply refire penalty.  (Melee) Should be 0 by default but can be changed in weapon data files. <br>
> **SelfChassis** - (Melee) Apply chassis modifier. <br>
> **SelfHeat** - Apply overheat penalty. <br>
> **SelfStoodUp** - Apply stood up penalty. <br>
> **SelfTerrain** - Apply self terrain penalty as if this is a ranged attack. <br>
> **SensorImpaired** - Apply sensor impaired penalty. <br>
> **SensorLock** - Apply sensor lock bonus. <br>
> **Sprint** - Apply sprint penalty, if somehow you can attack after sprint. <br>
> **TargetEffect** - Apply target effect penalty such as gyro. <br>
> **TargetEvasion** - Apply target evasion penalty.  Melee attacks ignore up to 4 evasion by default. <br>
> **TargetProne** - Apply target prone penalty. <br>
> **TargetShutdown** - Apply target shutdown bonus. <br>
> **TargetSize** - Apply target size penalty. <br>
> **TargetTerrain** - Apply target terrain's ranged penalty. <br>
> **TargetTerrainMelee** - Apply target terrain's melee penalty. <br>
> **Walked** - Apply self walked penalty, default 0 but can be changed in game configuration file. <br>
> **WeaponAccuracy** - Apply weapon accuracy, TTS, and mod bonus. <br>
> **WeaponDamage** - (Ranged) Apply weapon damaged penalty.
>
> The modifier system is designed to be moddable.
> Patch `ModifierList.GetCommonModifierFactor`, `ModifierList..GetRangedModifierFactor`, and/or `ModifierList.GetMeleeModifierFactor` to add new modifiers.



## Hit Roll Settings

**Adjust Roll Correction**

> Setting: `RollCorrectionStrength`  (0.0 to 2.0, default 0.5)
>
> It is no secret that the game fudge all hit rolls, called a "correction".  As a result, real hit chances are shifted away from 50%, for example 75% becomes 84% while 25% becomes 16%.  This can create a rift between what you see and what you get, especially on low chance shots.
>
> This mod does not aim to completely disable roll adjustment, and thus default to half its strength.  You can set the strength to 0 to disable it, 1 to use original formula, 2 to amplify it, or any value between 0 and 2.
>
> If the "True RNG Hit Rolls" mod is detected, this setting will be switched to 0 for consistency.


(Advanced) **Adjust Miss Streak Threshold**

> Setting: `MissStreakBreakerThreshold`  (0.0 to 1.0, default 0.5)
>
> In addition to roll adjustment, the game also has a "miss streak breaker".  Whenever you miss an attack of which uncorrected hit chance > 50%, the streak breaker will adjust your hit chance up on top of roll correction.  The bonus accumulates until you land a hit (regards of hit chance), at which point it resets to 0.
>
> This setting let you adjust the threshold.  0.75 means it applies to attack of which hit chance > 75% (excluding 75%).  Set to 0 enable it for all attacks, or set to 1 to disable it.  Default is 0.5 which is the game's default.
>
> If the "True RNG Hit Rolls" mod is detected, this setting will be switched to 1 for consistency.


(Advanced) **Adjust Miss Streak Bonus**

> Setting: `MissStreakBreakerDivider`  (-100.0 to 100.0, default 5.0)
>
> For every miss that crosses the streak breaker threshold, the threshold is deduced from hit chance, then divided by 5.  The result is then added as streak breaker bonus.
>
> Set this setting to a positive number to override the divider.  For example at threshold 0.5 and divider 3, a 95% miss result in (95%-0.5)/3 = 15% bonus to subsequence shots until hit.  Default is 5 which is the game's default.
>
> Set this setting to zero or negative integer to replace it with a constant value.  For example -5 means each triggering miss adds 5% bonus, and -100 will make sure the next shot always hit.



## Hit Chance Preview Settings


> Setting: `ShowBaseHitchance`  (true/false, default true)
>
> Show the mechwarrior's base hit chance in modifier tooltip.


> Setting: `FixSelfSpeedModifierPreview`  (true/false, default true)
>
> If moved/sprint/jumped modifier is non-zero, this mod can patch the game to factor them in during action planning.


(Advanced) **Show Corrected Hit Chance**

> Setting: `ShowCorrectedHitChance`  (true/false, default false)
>
> It's one thing to fudge the rolls.  It is another to let you know.
> Set this to true to show the corrected hit chance in weapon panel.
>
> Renamed from old "ShowRealWeaponHitChance" setting since version 2.0.
> If the "Real Hit Chance" mod is detected, this settings will be switched to on and overrides that mods.


**Format Hit Chance** (default "")

> Setting: `HitChanceFormat`  (free string, default "")
>
> Use Microsoft C# [String.Format](https://docs.microsoft.com/en-us/previous-versions/visualstudio/visual-studio-2008/0c899ak8(v=vs.90) syntax to format weapon hit chances.
>
> Set to "{0:0.0}%" to always show one decimal, or "{0:0.00}%" for two decimals.
> When empty AND HitChanceStep is 0, will use "{0:0.#}%" to optionally show hit chance to one decimal point.
>
> Replace the old "ShowDecimalHitChance" setting in mod version 1.0.



## Critical Hit Settings


**Skip Criting the Dead Mech**

> Setting: `SkipCritingDeadMech`  (true/false, default true)
>
> When true, critical hits are not rolled for dead units.
> This is mainly designed to prevent crit messages from flooding over cause of death.
> It will also slightly increase salvaged components.


**Crit Follows Damage Transfer**

> Setting: `CritFollowDamageTransfer`  (true/false, default true)
>
> When true, critical hits will be rolled on last damaged location, i.e. they follows damage transfer.
>
> In un-modded game, critical hit is checked only on the rolled hit location and does not follow damage transfer.
> For example, when a laser hits a destroyed arm and structurally damage a side torso, crit is not rolled since the arm is already destroyed.


**Fix False Positive Crits**

> Setting: `FixFullStructureCrit`  (true/false, default true)
>
> When true, critical hit does not happens on locations with intact structure.
>
> In un-modded game, critical hit is rolled on all location that is hit and has zero armour.
> This means crit is rolled even if an attack reduce the armour to exactly zero, even if it does not do any structural damage.
> Given the default min crit chance of 50%, a crit slot will be rolled half the time when this happens!
>
> This settings is ignored when through armour critical (below) is on, in which case zero armour uses the through armour rules.


**Through Armour Critical Hits**

> Setting: `ThroughArmorCritThreshold`  (0 to 1000, default 9)
>
> Each weapon must deal this much damage to a location in an attack for through armour critical hit to be checked.
>
> Default is 9 which is 3 MG hits, 3 LRM hits, or 2 SRM hits to the same location when un-braced and un-covered.
>
> If the number is between 0 and 1 (exclusive), the threshold is a fraction of the max armour of the location.
> e.g. 0.2 means a weapon must do as much damage as 20% of the max armour of the location.


> Setting: `ThroughArmorCritChanceZeroArmor`  (0 to 1, default 0)<br>
> Setting: `ThroughArmorCritChanceFullArmor`  (-1 to 1, default 0)<br>
>
> The two settings together determine the range of through armour base critical chance.
> ThroughArmorCritChanceZeroArmor is the max chance, and ThroughArmorCritChanceFullArmor is the min chance.
> When ThroughArmorCritChanceZeroArmor is 0, through armour critical hit is disabled.
>
> For a fixed crit chance, set both numbers to be the same.  Classic BattleTech has around 2% chance.
>
> Otherwise, the crit chance increase in proportion to armour damage.
> Example: When zero = 0.4 and Full = 0, a location with half armour has a 20% base crit chance.
> Example: When zero = 0.2 and Full = -0.1, crit happens after armour is reduced to 2/3 or below.
>
> When through armour critical hit happens and it is logged by this mod's Attack Log,
> the Max HP column logs the max armour of the location instead of max structure.



## Hit Resolution Settings


**Balance Ammo Consumption**

> Setting: `BalanceAmmoConsumption`  (true/false, default true)<br>
> Setting: `BalanceEnemyAmmoConsumption`  (true/false, default false)
>
> When set to true, mechs will draw ammo in an intelligent way to minimise chance of ammo explosion.
> After that is done, the AI will then minimise risk of losing ammo to crits and destroyed locations.
>
> The AI is pretty smart, but it can't shift ammo, so manually spreading ammo around can help it does its job.


**Auto Jettison Ammo**

> Setting: `AutoJettisonAmmo`  (true/false, default true)<br>
> Setting: `AutoJettisonEnemyAmmo`  (true/false, default false)
>
> When set to true, mechs will jettison useless ammo at end of its turn,
> provided it has not moved, is not prone, and is not shutdown.
> (The jettison doors are at the rear, so no prone jettisons.)
>
> This can happens if all weapons that use that kind of ammo are destroyed mid-fight,
> or if the mech was deployed with new ammo installed but not the weapon yet.
> Jettisoning the ammo will make sure they won't explode when hit.


**Precise Hit Location Distribution**

> Setting: `FixHitDistribution`  (true/false, default true)
>
> Set to true to increase hit location precision, specifically to improve the hit distribution of SRM and MG called shots.
>
> Game version 1.1 introduced degrading called shot effect for SRM and MG,
but because the code that determine hit distribution is not designed for fraction called shot weight, the actual distribution is slightly bugged.


**Kill Zombies**

> Setting: `KillZeroHpLocation`  (true/false, default true)
>
> Set to true to prevent locations and units from surviving at 0 HP.
>
> Some units have non-integer hp (usually turrets), and an attack may dealt non-integer damage (e.g. cover).  As a result, this may result in zombie locations and units that are at 0 structure but not dead.
>
> This mod can detect these cases and boosts the final damage just enough to finish the job.


## Attack Log Settings

(Advanced) **Attack Log**

> Setting: `AttackLogLevel`  ("None", "Attack", "Shot", "Location", "Damage", "Critical", or "All", default "All")
>
> When not None, the mod will writes to an attack log in the mod's folder, called Log_Attack.txt.
>
> The levels are progressive.  Attack info is fully included by Shot level, Shot info is fully included by Location level, etc.  The deeper the level, the more the mod needs to eavesdrops and the higher the chance things will go wrong because of game update or interference from other mods.
>
> **None** - It is a bug if you see a log file at this log level.  That or the file is a ghost that comes back to haunt you, in which case you should seek the church.
>
> **Attack** - Time, Attacker (team, pilot, mech), Target (team, pilot, mech), Direction, Range, Combat Id, and Action Id. The Ids can be used to consolidate data by-combat or by-action.  For example a Multi-Target attack may have three attacks that share the same Action Id.
>
> **Shot** - For each shot, log the Weapons, Weapon Template, Weapon Id, Attack Roll, Hit Chance, related info, and either Hit or Miss.  Weapon Id is unique *per mech*, and can be used to consolidate data by weapon.
>
> **Location** - Location Roll, Hit Table, Called Shot, and the Hit Location.
>
> **Damage** - Damage, Final Damaged Location, and Armor/HP of this location.
> Damage is determined in a different phase from hit and location, and is a rather complicated info to log.
>
> **Critical** - Crit Location, Crit Roll, Crit Slot, Crit Component, and the result of the crit.
> Crit is determined in yet another phase, so the log code is *very fun* to write.
>
> **All** - same as Critical for now.  More info may be added in the future, though I am not sure I wouldn't go crazy.  Would you believe logging is the most complicated feature of this mod?
>
> Default AttackLogLevel was None in mod version 2.0, but mod 2.1 switched to a multi-thread logging system so it now defaults to All.


(Advanced) **Log Options**

> Setting: `AttackLoFormat`  ("csv", "tsv", "txt", default "csv")
>
> Set the format and extension of attack log.  Default is csv which can be opened directly by Excel.
<br>

> Setting: `AttackLogArchiveMaxMB`  (0 to 1 million, default 4)
>
> When the game first enter combat every launch, old attack log is archived through rename.
> Then log exceeding this size limit will be deleted in the background.
<br>

> Setting: `LogFolder`  (string, default "")
>
> Set path of mod log and attack log.  Default is empty which will use mod folder.



# Compatibilities

* BattleTech 1.0 - AIM 1.0.1.
* BattleTech 1.1 - AIM 1.0.1, 2.0, 2.1, and 2.1.1.
* BattleTech 1.2 - AIM 2.2.

AIM is aware of some other mods and will behave differently in their present to meet player expectations.

These behaviours will not change saved settings.  If you want to replace them with AIM, you may need to change AIM settings.

**[Firing Line Improvement](https://www.nexusmods.com/battletech/mods/135)**
AIM will skip line styling and arc point adjustment to not crash line drawings.

**[MeleeMover](https://www.nexusmods.com/battletech/mods/226)**
AIM will skip its own melee unlock to preserve sprint range melee.

**[Real Hit Chance](https://www.nexusmods.com/battletech/mods/90)**
AIM will enable corrected hit chance display and overrides this mod, since it does not support AIM features such as adjustable correction strength.

**[True RNG Hit Rolls](https://www.nexusmods.com/battletech/mods/100)**
AIM will disable its own adjustable roll correction and miss streak breaker.

**[CBT Movement](https://github.com/McFistyBuns/CBTMovement)**
AIM will log a warning that jumping modifier feature is duplicated and one of them should be zero.

The first thing to check when you suspect any compatibility problems with the game or with other mods is to remove or disable the mods.

You can also check the mod log (`BATTLETECH\Mods\AttackImprovementMod\Log_AIMAttackImprovementMod.log`), BTML log (`BATTLETECH\Mods\*.log`), and the game's own log (`BATTLETECH\`).  The keyword is "Exception".  It is almost always followed by lots of code.  If you see *any* exception with "AttackImprovementMod" in the code below it, please [file an issue](https://github.com/Sheep-y/Attack-Improvement-Mod/issues/new) and attach the log.


# The Story of AIM

If you asked me whether I would play a hardcore mech game like BattleTech, a month before I started doing this mod, my answer would be no.

This is my first serious game modding attempt, and is totally unexpected.

One day in summer 2018 when I pay the online game shops a visit, I noticed that one single game is is on the top of top sellers on GOG, Humble Store, and Steam.  The game is BATTLETECH.  It is not exactly my cup of tea, but I don't see that happens often either.  The game has just been launched, and Steam has a pretty big discount in my local currency.

By the time I finished the campaign, I have written a [GameFAQ guide](https://gamefaqs.gamespot.com/pc/205058-battletech/faqs/75955) and a [data miner](https://github.com/Sheep-y/Sheep-y.github.io/tree/dev/battletech/parser) in Node.js.

That is *almost* the end.

Except that I can't shake the feeling that the called hit chance is wrong.

So, I modded LRM and SRM to fire 500 shots and did some light testing, for the guide.
The first few tests fails my own testing standard, but the result is obvious: the numbers are VERY wrong, in game version 1.0.x.

After I improved my methodology, I did some [large scale tests](https://steamcommunity.com/app/637090/discussions/0/1697176044370891096/) totaling over 60k missiles against live King Crabs.  For a while it was a hot topic on Steam.

The result is not pretty.  And I don't mean to the crabs.

Called shot at the head not only has lower chance to hit the head than non-called shots, but the head is biased in virtually all attacks and has double chance to be hit than intended by normal attacks.

Baffled by the result, I learned how to use programing tools to see game code.  Finding the bugs is the easy part.  Fixing it is the hard part, since I knew *nothing* about BattleTech, paper or code, and I *never* hijacked any code before.

I started by injecting loggings into the system, to learn the process.
These logs later become the Attack Log feature.
How about the roll correction?  A mod kills it.  Can I tune it down instead? (Play with formulas in Excel.) Ok, let's do that.
Hmm, now I need to show the modified hit chance. (Re-learn algebra and coded perhaps the most complicated formula in all BattleTech mods.)

Eventually I fixed the two bugs I intended to fix, plus fixing vehicle called shot. (Fixed in 1.2.0 beta, two months after AIM is released.)
When I am mostly done, game updates 1.1 landed just the day before I plan to release, and it changed how called shot works.  Took me two whole days to update the mod, before I went back to enjoy the game.

Or so I hoped.

In reality, I now see game bugs everywhere, and many many ways to improve the game.
I want to fix Multi-Target back out.  I want to fix the paper doll.  I want to see more information.  I want to colour the lines and open source it.  LadyAlekto of RogueTech also *helpfully* reported more game bug in form of feature wishes.

All the bug fixes and new features and enhancements is much bigger than what I originally envisioned.  Even as I tie up AIM version 2.0, the ever expanding idea list grow at an even greater pace.  If there is an end in sight, it is an abrupt one when a game that I like better come out, such as Phoenix Point.

This is the story of how I went from "stay away from BattleTech" to "wrote 3500 lines of BattleTech mod" in three month's time.  Now let me see whether Paradox is hiring remote freelancer.

# Learn to Mod

The [source code](https://github.com/Sheep-y/Attack-Improvement-Mod/) of this mod is open and free.
You can take it, modify it, and even release it, provided that you include *your* code when you distribute your work, and don't claim my work as yours.
License: [AGPL v3](https://www.gnu.org/licenses/agpl-3.0.en.html)

Follow these steps to see game code and learn how BATTLETECH mod works:

1. Install [Visual Studio](https://www.visualstudio.com/downloads/) which is free. This mod is developed with VS 2017 Community Edition. You'll need the ".NET desktop development" workload.
1. Down and Run [DnSpy](https://github.com/0xd4d/dnSpy/releases)
1. Select File > Open, and find `BATTLETECH\BattleTech_Data\Managed\Assembly-CSharp.dll`.  This will load the assembly.  It contains most BATTLETECH code.
1. You may now search and browse the assembly!  For example in Edit > Search you can type "GetCorrectedRoll" to find the method.  Clicking on it will show you the roll correction code.
1. Right click on method name (or any identifier) and click "Analyse".  It'll help you find where and how the method is called, or its override hierarchy.
1. Analyse is very fast because it works with compiled code.  It is not 100% accurate, though, sometimes you'll want to exported code and search there instead.
1. Left click the assembly, then File > Export to Project.  This will decompile all code which you can browse with other editor or IDE.
1. Head to the [ModTek wiki](https://github.com/Mpstark/ModTek/wiki) to learn how to make a mod.  For a code mode like this one, you need to compile a [dll](https://github.com/Mpstark/ModTek/wiki/Writing-ModTek-DLL-mods) and perhaps a [`mod.json`](https://github.com/Mpstark/ModTek/wiki/The-mod.json-Format).
1. The code of this mod is available on GitHub: https://github.com/Sheep-y/Attack-Improvement-Mod/ and you can also find other people's mods such as [Firing Line Improvement](https://github.com/janxious/BTMLColorLOSMod) or [MeleeMover](https://github.com/Morphyum/MeleeMover) and we all use different licenses.
1. You may notice that this patch manually calls Harmony to patch things, instead of using annotations. This gives me much better control. Read [Harmony wiki](https://github.com/pardeike/Harmony/wiki) to learn how it works.

# Credits

* Thanks Mpstark (Michael Starkweather) for making BTML and ModTek and various mods and release them to the public domain.
* Thanks LadyAlekto for various feature requests and cool proposals such as melee modifiers and ammo jettison.

Despite feature overlap with some mods, this mod does not reference or use their code due to lack of license, and in most cases the approaches are different.
