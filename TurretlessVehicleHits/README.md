# TurretlessVehicleHits
When a vehicle without a turret is hit in the turret, the hit is moved to the facing side/front/rear.

## Requires

[ModTek](https://github.com/BattletechModders/ModTek/releases)

While I haven't tested this mod with the built in modloader, I see no reason that it shouldn't work.

## Credits

* HBS for making a great game

## Details

Once the hit location on a vehicle is determined, this mod examines the result.  If the vehicle doesn't have a turret, and the hit location is "turret", the hit is moved to the facing side of the vehicle:  attacks from front hit front, side hit that side, and rear hit rear.

Logging can be enabled.  To do so, edit the mod.json to set
	"logActions": true
The log file ModExecution.log will be created in the mod directory and overwritten each time the game is started with this mod enabled.
