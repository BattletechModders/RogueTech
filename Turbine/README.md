# Turbine 1.1.1

For BATTLETECH 1.1.2 and 1.2.0

Turbine is a BattleTech mod that lighten and speed up the game's resource loading.
If your game has a tendency to crash on very long loads, this mod _may_ fix your problem.
Or general loading speed up if you have no problem.

Because of its low-level nature and the scale of the problem, it is rather delicate.
If it works for you, you should see an obvious improvement in your game's loading time.
If it does not work, your game will crash or hang. Delete the mod to revert it to normal.

This mod does not modify game data or save games.
This mod does not fix memory leaks, either. Rest your eyes.

- GitHub: https://github.com/Sheep-y/BattleTech_Turbine
- Nexus Mods: https://www.nexusmods.com/battletech/mods/288

# Installation

1. Install [BTML](https://github.com/janxious/ModTek/wiki/The-Drop-Dead-Simple-Guide-to-Installing-BTML-&-ModTek-&-ModTek-mods). ModTek is optional if you don't use other mods.
2. [Download this mod](https://github.com/Sheep-y/BattleTech_Turbine/releases), extract in the mod folder. i.e. You should see `BATTLETECH\Mods\Turbine.dll`.
3. Launch and play as normal. This mod has no settings.
4. If the game crash or hang up during a loading screen or blank screen, delete the mod and try again.

**IMPORTANT NOTE** - Do not run Turbine as ModTek, i.e. do not move into subfolder. It'll crash if you try to make modtek load it.

# Compatibility

Compatible with original BTML v0.23 and Janxious's [updated BTMLs](https://github.com/janxious/BattleTechModLoader/releases/).

Turbine is not expected to work with mods that also speed up _resource_ loading, such as WhySoSlow.

It should otherwise work with all mods, including those that add new files for the game to load.

# How It Works

The mod has a few functional parts.

Before any work starts, two safety rails are installed around `VFXNamesDef.AllNames` and `CombatGameConstants.CreateFromSaved`,
to cache their results so that repeated calls can be served immediately and to avoid potential errors.

Real work starts with the request filter. A cheap and safe check is done after every `DataManagerRequestCompleteMessage` creation.
If the request is invalid or same as last one, it is filtered out.

Then we have the compressor.
It is a pretty big rewrite of `BattleTech.Data.DataManager`, totally replaces two request queues and takes over their management.
A Dictionary is used to speed up matching of incoming request against queued requests, improving engine efficiently.

Bypass come after the compressor. It works on MechDefs, big request blocks that cost lot of fuel to burn.
When a new MechDef is encountered, it is allowed through and the compressor is signalled to trace it.
Once it is through, we have captured its request dependency list, which opens the bypass tunnel for the MechDef.

If anything cause the MechDef to re-enter the engine, it will now bypass its original dependency processing.
This continues until all its dependencies are processed. Then the MechDef is manually summoned back and allowed pass.
Its bypass will stay open; only one MechDef may pass through the engine at any one time.
Others are still bypassed when one is in the pipeline.

Thanks to the bypass, the engine can skip lots of inefficient work for a higher horsepower, and can fit into a smaller call stack.

Requests that are not bypassed will go through a turbine, that the original engine does not have.
It is an unfinished task queue, maintained separately from the full job queue, that drives the compressor's operation.

As you can expect, all these parts work together to make the game's resource engine more efficient.
If the turbine broke, the compressor may cease to spin, and the whole engine stops.
If the bypass took too much requests away, the turbine may stops and again the whole engine stops.
What if an explosion happens and damages the compressor? Well, you can expect the whole engine to breakdown.

As a safety measure, the mod has a kill switch, that is triggered when it detects any explosion (not same as engine stop).
When the unfortunate happens, the whole mod will disintegrates and falls away, leaving bare the original engine.
This is best happened during part installation. If any part does not fit, perhaps because of game update, all parts will break away.

It can also happens when the game is running. Unlike Hollywood movie, though, engine repairs rarely work mid-flight.
In the whole bypass development, it saved a running game once. That once is the _only_ reason the explosive bolts are kept.

Then an afterburner is added. It calculates the hash of data files in parallel, pushing harddisk and cpu to work much harder.
If the Harmony injector is new enough, the `CSVReader` fuel pipe will be refitted with a streamlined model.

After the engine upgrades, the original exhause pipe is replaced with a turbine nozzle that speeds up json processing.
Air filters, afterburner, and nozzle are outside the core engine, and are unaffected by kill switch.

Finally, the mod has a blackbox logger. It keeps a non-persistent log of installed parts and general performance of the turbine.
But its real value is its sensors, installed in all parts, that allow it to log explosions. Records are kept in `Log_Turbine.txt`.

# Credits

- Thanks [Denedan](https://github.com/Denadan) for finding the two original [performance](https://github.com/saltyhotdog/BattletechIssueTracker/issues/14) [issues](https://github.com/saltyhotdog/BattletechIssueTracker/issues/17)
- Thanks [Matthew Spencer](https://github.com/m22spencer) for doing very detailed and amazing profiling so that I know where to start hacking, and suggested ways to speed the game up further.
- Thanks LadyAlekto and many brave RogueTech users on the BATTLETECHGAME discord for testing the mod despite its high tendency to explode their games.
- Thanks HBS the game developer for giving me a ComStar experience when working on this mod. Can't get any closer to maintaining Lostech.
