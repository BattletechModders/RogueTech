# Overview

ModTek has been updated from v4.1.0 to v4.3.6. Attached is an abbreviated Changelog for reference. 
- Harmony12X folder has been deleted
- Provided `*.dlls` have been moved to `ModTek/lib`. To avoid breaking projects, a copy of these `*.dll` are available at `ModTek/` 

# Abbreviated Changes

Partial Changelog copied from ModTek's git.
Since v2, ModTek adheres to [Semantic Versioning](http://semver.org/) for runtime compatibility with mods.

## Known Issues

- Injected assemblies (dlls) are saved to disk during startup, virus scanners could trigger or block this process.
- Some mods expect the managed assemblies location to be in the `Managed` directory,
  however injected assemblies are now found under `Mods/.modtek/AssembliesInjected` or loaded directly into memory after injection.
- The HarmonyX feature works well, however some mods might rely on some buggy Harmony 1.2 behaviors that HarmonyX shims don't replicate.

## 4.3 - CptMoore

For modders:
- (Experimental!) Added ability to run injectors as part of a build task outside of BT.
  - API might change in the future.
  - Requires injectors to target netstandard2.0 or it mostly won't work.
    - In a future ModTek version, non-netstandard Injectors will be unsupported even when running under BT.
  - See [RogueTechPerfFixes](https://github.com/BattletechModders/RogueTechPerfFixes) as an example.
    - Consists of an injector that adds fields to the base-game dlls, which the main project requires for compilation.
    - CI/CD can build both without having the ability to run a game.
  - TODO some nicer documentation would be nice.
- Some libraries were renamed, as always don't just copy-paste, clean-copy-paste!
- Moved the NullableLogger to the `ModTek.Public` namespace. The NullableLogger allows readable code when skipping
  trace and debug logging, but otherwise it is equivalent to the HBS logger. Do not use if you don't need it.
- The load order is now deterministic:
  - The load order ignores load_order.json during sorting.
  - It is now based 1. dependency instructions 2. path depth 3. path name
- Updated UnityDoorstop to 4.3.0

## 4.2 - CptMoore

For users:
- Updated UnityDoorstop to latest version + still including our custom steamfix.
- Fixed run.sh to work with new steam wrappers

For modders:
- Moved all ModTek dlls (ModTek, HarmonyX, MonoMod, etc..) to `ModTek/lib`.
  - Requires to update the doorstop ini
  - Made run.sh depend on the doorstop.ini instead of having its own inline options
- Updated HarmonyX
  - New HarmonyX is based on a major rewrite of MonoMod, several bugs were encountered and fixed
  - Still providing an older version of HarmonyX due to reports of instability (those went away after a restart or 2)
- Various Logging improvements and changes
  - Async logging is now highly optimized
    - reduction of 300+ ns to <100 ns spent on the caller thread (usually the unity main thread)
  - Reduced logging (format) options to increase performance
    - actual formatting times were reduces from 6-8 us to below 1 us
    - now nvme drives are the bottleneck (~3 us), not the formatting code
  - HBS' ILog.Flush() method is now supported and flushes OS buffers to disk

## 4.1 - kMiSSioN

For modders:
- Added a DebugDumpServer to allow triggering log dumps via HTTP calls, disabled by default