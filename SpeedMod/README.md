# SpeedMod

**SINCE BattleTech Patch 1.1 THIS MOD IS NOT A NECESSITY ANYMORE**

BattleTech mod (using ModTek and DynModLib) that speeds up gameplay.

## Requirements and Installation

* install [DynModLib](https://github.com/CptMoore/DynModLib/releases) using [instructions here](https://github.com/CptMoore/DynModLib)
* install SpeedMod by putting it into the \BATTLETECH\Mods\ folder

## Features

**Update**: BattleTech 1.1 introduced a fast forward key, however it's not a toggle and the animation acceleration feels way off, so this mod is still supported.

This mod modifies the behavior of the fast forward key and the acceleration curve of the animations.

Setting | Type | Default | Description
--- | --- | --- | ---
FastForwardKeyIsToggle | bool | true | true allows the space bar to be used as a toggle instead of having to spam it at the time
SpeedUpIsConstant | bool | true | true means that the animations don't accelerate/deaccelerate anymore
SpeedBaseFactor | float | 1.0 | this speed multiplier is always applied, useful to speed up / down the game permanently

The speed up factors are found as json patches in the mod folder, right now I use the same factor the mod used before 1.1 

## Download

Downloads can be found on [github](https://github.com/CptMoore/SpeedMod/).

## Development

* Use git
* Use Visual Studio or DynModLib to compile the project
