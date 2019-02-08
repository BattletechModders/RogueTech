# MechEngineer
BattleTech mod that adds engines and other components to mechs based on TT rules.

## Requirements

either
* install BattleTechModTools using [BattleTechModInstaller](https://github.com/CptMoore/BattleTechModTools/releases)

or
* install [BattleTechModLoader](https://github.com/Mpstark/BattleTechModLoader/releases) using [instructions here](https://github.com/Mpstark/BattleTechModLoader)
* install [ModTek](https://github.com/Mpstark/ModTek/releases) using [instructions here](https://github.com/Mpstark/ModTek)
* install [CustomComponents](https://github.com/Denadan/CustomComponents/releases) using [instructions here](https://github.com/Denadan/CustomComponents)
* install [DynModLib](https://github.com/CptMoore/DynModLib/releases) using [instructions here](https://github.com/CptMoore/DynModLib)

## Suggested Mods

Use these mods to maximize enjoyment
* [CBT Heat](https://github.com/McFistyBuns/CBTHeat) - replaces overheat damage to be crit rolls
* [CBT Movement](https://github.com/McFistyBuns/CBTMovement) - movement reduces accuracy
* [CBT Piloting](https://github.com/McFistyBuns/CBTPiloting) - mech can stumble by chance
* [Pansar](https://github.com/hokvel/pansar) - applies armor ratio enforcement according to CBT rules

## Features

* Engine ratings
  * defines the walk and sprint speeds of a mech
  * determines the amount of jump jets a mech can mount
* Engine types
  * defines the weight and space use of an engine
  * Standard, XL, Light, Compact, XXL, Clan XL and XXL variants
* Engine crits
  * each crit reduces heat sink dissipation
  * on third crit, destroy engine
  * each destroyed slot of an engine counts as a critical hit
* Engine heat sinks
  * global heat dissipation removed
  * engines come with internal heat sinks already installed
  * can add additional heat sinks to an engine through drag & drop
  * can convert an engine to use DHS heat sinks instead of SHS through drag & drop of an DHS conversion kit
* Armor and Structure components
  * these provide weight savings and in turn require critical slots
  * Endo Steel, Endo Composite, Clan Endo Steel
  * Ferros Fibrous, Heavy FF, Light FF, Clan FF
* MechLab enhancements
  * fixes to have a better approximation of slot count in a mech (12 torso slots, 2 leg slots, 2 head due to cockpit etc..)
  * enforces that gyro, cockpit and engine parts are mounted
  * enforce engine side torso requirements
  * does not allow to mix heat sink types (can be disabled)
  * updated summary and enhanced tooltip info for movement and heat management 
  * hide engine ratings that would make the mech slower or faster than allowed
* Auto-fixes existing mechs and weapons on load
  * reduces initial tonnage to 10% structure
  * auto adds cockpit and gyro
  * auto adds engine components
  * auto fix chassis to have inventory sizes that match the CBT standard implemented in this mod (* actuators are still missing)
  * fun fact, the atlas is perfectly auto-fixed
  * also auto-fixes existing save games
  * weapons resized to CBT spec
  * AC20 is not full size until crit splitting is implemented
* Prepared item packs
  * enabled by modifying the mod.json and removing the "disabled_" prefixes
  * standard package, that provides lore* and time appropiate items to the game (*lore as the game sees fit, so LosTech is OK)
  * exotic package, adds in stuff like clan tech
  * test package, to play around in skirmish mechlab with everythig
* Settings and Modding
  * players can disable some of the restritions
  * modders can add more components using CustomComponents
  * add engines using the generate.pl script in engine_generator
  * there are additional settings like factional accounting or partical weight savings for structure and armor components
  * see [Settings Source Code](https://github.com/CptMoore/MechEngineer/blob/master/source/MechEngineerSettings.cs) for all available settings

### Components

cockpit | exotic
--- | ---
standard | -
small | yes
cockpit upgrades* | -

*\*upgrades are auto-converted to act as the actual item*

gyro | exotic
--- | ---
standard | -
gryo upgrades* | -

*\*upgrades are auto-converted to act as the actual item*

engine core | exotic
--- | ---
rating 60 | -
rating 100-400 | -

engine type | exotic
--- | ---
std | -
xl | -
compact | yes
light | yes
cxl | yes
xxl | yes
cxxl | yes

engine kits | exotic
--- | ---
DHS conversion | -
CDHS conversion | yes

heat sinks | exotic
--- | ---
Clan Double Heat Sink | yes

armor | exotic
--- | ---
ferros-fibrous | -
clan ferros-fibrous | yes
light ferros-fibrous | yes
heavy ferros-fibrous | yes
stealth | yes

structure | exotic
--- | ---
endo-steel | -
clan endo-steel | yes
endo-composite | yes

Ratings are chosen by what the base game requires + JK chassis variants needed.
The engine generator can be used to quickly add more engine ratings:
* edit engine_generator/stock_std_ratings.txt
* right click on folder -> git bash here -> type in "./generate.pl"

### TODO

* see [issues list](https://github.com/CptMoore/MechEngineer/issues)

## Contributors

* Aliencreature - ideas, lore and rules, item variants, testing
* CptMoore - ideas, rules, coding, testing, core items
* CrusherBob - ideas, lore and rules, engine rating to walk/sprint distance conversions
* Denadan - ideas, custom components lib, coding
* Gentleman Reaper - ideas, lore and rules, testing
* TotalMeltdown - ideas, lore and rules

## Download

Downloads can be found on [github](https://github.com/CptMoore/MechEngineer/releases).

## Install

After installing BTML, ModTek, CustomComponents and DynModLib, put the mod into the \BATTLETECH\Mods\ folder and launch the game.

## Development

* Use git
* Use Visual Studio to compile the project
