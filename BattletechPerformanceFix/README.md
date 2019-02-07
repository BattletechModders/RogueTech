This mod is fully compatible with https://github.com/Sheep-y/BattleTech_Turbine

# Requirements
- BTML  : [https://github.com/janxious/BattleTechModLoader/releases](https://github.com/janxious/BattleTechModLoader/releases)
- ModTek: [https://github.com/janxious/ModTek/releases](https://github.com/janxious/ModTek/releases)

For an install guide see here: [https://github.com/janxious/ModTek/wiki/The-Drop-Dead-Simple-Guide-to-Installing-BTML-&-ModTek-&-ModTek-mods](https://github.com/janxious/ModTek/wiki/The-Drop-Dead-Simple-Guide-to-Installing-BTML-&-ModTek-&-ModTek-mods)


# What does this mod do?
- LoadFixes
   - Swap the default json parser for a faster one, and falling back to the slow parser if necessary
   - (Decrease load times, less useful in BattleTech 1.3)
- NoSalvageSoftlock
   - Prevents the game from softlocking (causing you to lose progress) in case of more than 7 salvage picks
- MissingAssetsContinueLoad
   - If the game fails to locate an asset from the manifest, create a dummy item in its place
   - This fix can allow you to progress past some types of infinite loads
- DataLoaderGetEntryCheck
   - Disables file exists & modify checks in a critical code path. Speeds up loading by about 1 second in vanilla.
- DynamicTagsFix
   - Restores some broken code in 1.3 that was not allowing mods to see user faction tags.
   - (This fix is provided by HBS_Eck. Thanks!)
- BTLightControllerThrottle (disabled by default)
   - Very large cpu usage reduction. Causes lights to look like crap, useful for very low spec machines.
- ShopTabLagFix
   - Prevents BattleTech from sorting the item list every single time an item is added.
   - Exponential speedup (Hoarders/Late game players will see the most benefit)
   
- MDDB_InMemoryCache
   - Prevent the hang on HBS logo + general game speedup by transferring the disk MDDB to an in memory one.
- ContractLagFix
   - Speeds up Contract generation in the command center, and removes some stutter from battle when completing objectives.
- ParallelizeLoad (Disabled by default: Experimental, Dangerous)
   - An in progress patch, it is recommended you do not enable this patch at this time.

# How do I disable/enable X
   Set it to `true` or `false` in `BATTLETECH/Mods/BattletechPerformanceFix/Settings.json`

# Comparisons (Right side is with fix applied)

## Store Fix (249 unique items in sell list) 
![](gifs/compare-store.gif)

---  

## MechlabThottling + ItemsList Fix (249 unique items in list)
![](gifs/compare-mechlab.gif)

---  

## Load times (Note: both sides include [Sheep-y's Turbine fix](https://github.com/Sheep-y/BattleTech_Turbine))
#### experimentalLazyRoomInitialization  
- Delay loading of rooms on Leopard until you actually require them  
#### experimentalLoadFixes  
- Speed up JSON processing by only stripping comments & correcting if required.  
![](gifs/compare-load-turbine-both.gif)
