This mod is designed to provide the ability to create new maps
How it works:
The mod takes an existing map and modifies it according to the instructions in the json file
At the same time, the game cards remain completely untouched.

Basic concepts:

The game has two heightmaps, one used by Unity, the other in-game. These cards may not match.
The first map is what the player sees directly, the second is the one in accordance with which the units move.

This mod allows you to:
1. Modify unity surface heightmap
2. Change the in-game height map
3. Change the type of cells on the in-game height map
4. Disable visual objects on the map after loading the scene
5. Rotate, move, scale objects on the map after loading the scene
6. Disable tree rendering

What this mod does not yet do:
1. Change the position of trees and details on the map
2. Create new visual objects on the map

What else is planned to be done:
1. Create a plugin for UnityEditor that allows you to export the current scene to a format understood by the mod.

In its current state, this mod is meant to be a proof of concept.
In the attached files, based on the map for Skirmish - mapArena_brokenGrotto_vLow, a map is created completely covered with water
1. Trees are disabled
2. Rewrite heightmaps
3. Rewrite surface types
4. All visual objects are turned off except for water
5. Water mesh expands to the entire visible area of ​​the map

Further details on map creation process will be added later