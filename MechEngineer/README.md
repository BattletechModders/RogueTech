# MechEngineer
BattleTech mod that adds engines and other components to mechs based on TT rules.

## Download

Downloads of the latest release can be found on [github](https://github.com/BattletechModders/MechEngineer/releases).

## Requirements and Installation

install [RogueTech](https://www.nexusmods.com/battletech/mods/79) for an in-depth MechEngineer experience

or

install [BattleTech Advanced](https://www.nexusmods.com/battletech/mods/452) for another in-depth MechEngineer experience

or

* install [ModTek](https://github.com/BattletechModders/ModTek/releases) using [instructions here](https://github.com/BattletechModders/ModTek)
* install [CustomComponents](https://github.com/BattletechModders/CustomComponents/releases) using [instructions here](https://github.com/BattletechModders/CustomComponents)
* install MechEngineer by copying the MechEngineer folder to the mods/ directory of ModTek

Note: HBS BattleTech ModLoader is not supported, you need to get ModTekV2 for DLC support.

## Suggested Mods

* [Pansar](https://github.com/hokvel/pansar) - applies armor ratio enforcement according to CBT rules

## TODOs and Bug Reporting

* see [issues list](https://github.com/BattletechModders/MechEngineer/issues)

## Contributors

Maintainers:
CptMoore ([MechEngineer](https://github.com/BattletechModders/MechEngineer))
, Denadan ([CustomComponents](https://github.com/BattletechModders/CustomComponents))

* adammartinez271828 - rounding logic
* Aliencreature - ideas, lore and rules, item variants, testing
* bhtail - ideas, testing
* Colobos - ideas, lore and rules, item and mech balancing, testing
* CptMoore - ideas, rules, coding, testing, core items
* CrusherBob - ideas, lore and rules, engine rating to walk/sprint distance conversions
* Denadan - ideas, custom components lib, coding
* Gentleman Reaper - ideas, lore and rules, testing
* kmission - russian localization support improvements
* LadyAlekto + RT Team - ideas, lore and rules, lots of testing, items
* TotalMeltdown - ideas, lore and rules

### How-to start contributing

MechEngineer uses publicized assemblies, those are .NET dlls whose classes and methods visibility were changed to public.

0. Install ModTekV2 if not already done.
1. Download the [improved AssemblyPublicizer](https://github.com/BattletechModders/MechEngineer/releases/download/v2.3.10/AssemblyPublicizer.exe) (originally from [MrPurple6411/AssemblyPublicizer](https://github.com/MrPurple6411/AssemblyPublicizer) but that one release there adds publicized suffixes to all dlls)
2. Drag'n Drop all dlls found in BATTLETECH/BattleTech_Data/Managed/ onto the exe and it will create a BATTLETECH/BattleTech_Data/Managed/publicized_assemblies directory.
3. Checkout the MechEngineer repository to BATTLETECH/mods/MechEngineer.
4. Copy the Directory.Build.props.template to Directory.Build.props and replace the ReferencePath directory with the location of the publicized_assemblies directory.
5. Open the solution in Visual Studio 2019 and compile the MechEngineer.dll .
6. Start the game.

## Features

The current features are always described right within the default settings in `Settings.defaults.json`.

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
