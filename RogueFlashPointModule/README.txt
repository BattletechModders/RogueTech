# FlashpointEnabler

Activates features of FPs

## Requirements
* install [BattleTechModLoader](https://github.com/BattletechModders/BattleTechModLoader/releases) using the [instructions here](https://github.com/BattletechModders/BattleTechModLoader)
* install [ModTek](https://github.com/BattletechModders/ModTek/releases) using the [instructions here](https://github.com/BattletechModders/ModTek)

## Features
- Activates the repeatable flag on FlashpointDefs.
- Can randomize Planets for all flashpoints.
- Can make all flashpoints repeatable.
- Adds new Tags to create Flashpoints.

## New Tags
{RANDOM} | Use for employer or target to generate a random faction as those.
{PLANETOWNER} | Use for employer or target to use current planet owner as the faction selected.

## Download

Downloads can be found on [github](https://github.com/Morphyum/RepeatableFlashpoints/releases).

## Settings
Setting | Type | Default | Description
--- | --- | --- | ---
randomPlanet | bool | default false | Makes ALL flashpoints go to random planets.
debugAllRepeat | bool | default false | Makes ALL flashpoints repeatable.(This will be removed later, when we figure out how to set the flag in existing flashpoints done by HBS)
    
## Install
- After installing BTML and ModTek, put  everything into \BATTLETECH\Mods\ folder.
- If you want different settings set it in the settings.json.
- Start the game.