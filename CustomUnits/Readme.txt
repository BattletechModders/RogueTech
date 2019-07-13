this mod allows you next things 
1. Add external animated parts to vehicles
2. Changing chassiss terrain interactions
3. Forbids certain meches/vehisles to spawn on certain biomes

DesignMask definition
new section 
	"Custom":{
		"CustomMoveCost":{
			"Hover": {    - name of move cost overriden section. You can set same name at chassis definition to override move cost for this chassis and biome
								additive for CAC temp masks. 
								For example radioactive_forest.Hover.moveCost = forest.Hover.moveCost + radioactive.Hover.moveCost - 1.0
				"moveCost":9999.9,
				"SprintMultiplier":9999.9
			}
		}
	}

VehicleChassis/Chassis
"CustomParts":{
    "AOEHeight": 55,  - this value will be added to y-coordinate of current position in AoE damage calculations (weapon/landmines/component's explosions). 
                        Can be altered runtime via CUAOEHeight actor's statistic value (float)
    "Unaffected":{  
      "DesignMasks": true,   - if true chassis will be unaffected to all terrain design masks effects except move cost. Can be altered runtime via CUDesignMasksUnaffected actor's statistic value (boolean)
      "Pathing": true,       - if true chassis will be unaffected by pathing limitations 
							(eg can climb vertcall surface, other actors collisions, not cause filmsy objects destruction on impact). 
							If choosed as melee target attacker melee (NOT AP) weapon always miss. Ignore terrain move cost.
              Can be altered runtime via CUPathingUnaffected actor's statistic value (boolean)
      "Fire": true,         - if true chassis not receive damage passing burning terrain. Can be altered runtime via CUFireActorStatUnaffected actor's statistic value (boolean)
      "Landmines": true,     - if true chassis not cause landmines to explode (still can receive AoE damage from landmines if explosion triggered by someone else).
                               Can be altered runtime via CULandminesUnaffected actor's statistic value (boolean)
      "MoveCostBiome":true   - if true unaffected by move modify per biome. Can be altered runtime via CUMoveCostBiomeUnaffected actor's statistic value (boolean)
    },
    "MoveCostModPerBiome":{  - dictionary of move cost modify per biome design mask
      "DesignMaskBiomeMartianVacuum":2.0,
      "DesignMaskBiomeLunarVacuum":10.0
    }, 
	"MoveCost":"Hover",     - move cost per design mask overridence (useless if Unaffected.Pathing is true).
                            Can be altered runtime via CUMoveCost actor's statistic value (string)
    "TieToGroundOnDeath":false, - if true tied to ground on death (useful if prefab positions is altered by sections below)
	"HighestLOSPosition":{"x":0,"y":60,"z":0}, - offset for targeting
	"TurretAttach":{
		"offset":{"x":-0.6,"y":52.3,"z":5.5}, - offset for turret location, if omitted not touched
		"rotate":{"x":0,"y":0,"z":0} - rotation for turret location, if omitted not touched
	},
	"BodyAttach":{
		"offset":{"x":-0.6,"y":54,"z":0}  - offset for body location, if omitted not touched
	},
    "TurretLOS":{
		"offset":{"x":-0.6,"y":52.3,"z":5.5} - offset for turret line-of-sight location (usually same as TurretAttach), if omitted not touched
	},
	"LeftSideLOS":{
		"offset":{"x":-2,"y":54,"z":0} - offset for left side line-of-sight location, if omitted not touched
	},
	"RightSideLOS":{
		"offset":{"x":2,"y":54,"z":0} - offset for right side line-of-sight location, if omitted not touched
	},
	"leftVFXTransform":{
		"offset":{"x":-2,"y":54,"z":0} - offset for left vfx attach point (usually same as LeftSideLOS), if omitted not touched
	},
	"rightVFXTransform":{
		"offset":{"x":2,"y":54,"z":0} - offset for right vfx attach point (usually same as RightSideLOS), if omitted not touched
	},
	"rearVFXTransform":{
		"offset":{"x":0,"y":54,"z":-7} - offset for rear vfx attach point (usually same as RightSideLOS), if omitted not touched
	},
	"thisTransform":{
		"offset":{"x":0,"y":52,"z":0} - offset for main transform (as far as i can see not used for vehicles), if omitted not touched
	},
	"lightsTransforms":[ - offsets and rotations array for lights (i don't know why y-coordinate have to be doubled this values get from experiments)
		{"offset":{"x":-1.1,"y":103.8,"z":4.7},"rotate":{x:"60","y":0,"z":0}},
		{"offset":{"x":1.2,"y":103.8,"z":4.7},"rotate":{x:"60","y":0,"z":0}}
    ],
		"CustomParts":[  - array for external animated parts for chassis (all prefabs will be requested on loading dependences for chassis)
			{
				"prefab":"warrior_rotor_top_x10_brass", - prefab name
				"prefabTransform":{                     - prefab transformations
					"offset":  {"x":0,"y":1.4,"z":0.5},
					"scale":   {"x":20,"y":20,"z":20},
					"rotation":{"x":0, "y":0, "z":0}
				},
        "VehicleChassisLocation":"Front",               - attach location
				"AnimationType":"SimpleRotator",        - animation type
				"AnimationData":{"speed":5,"axis":"y"}  - data specific for animation type
			},
			{
				"prefab":"warrior_rotor_bottom_x10_brass",
				"prefabTransform":{
					"offset":  {"x":0,"y":1.2,"z":0.5},
					"scale":   {"x":20,"y":20,"z":20},
					"rotation":{"x":0, "y":0, "z":0}
				},
        "VehicleChassisLocation":"Front",
				"AnimationType":"SimpleRotator",
				"AnimationData":{"speed":-5,"axis":"y"}
			},
			{
				"prefab":"warrior_turret_x10_red",
				"prefabTransform":{
					"offset":  {"x":0,"y":0,"z":0},
					"scale":   {"x":20,"y":20,"z":20},
					"rotation":{"x":0, "y":0, "z":0}
				},
        "VehicleChassisLocation":"Turret",
				"AnimationType":"Turret",                - turret animation not implemented yet
				"AnimationData":{"speed":-10,"axis":"y"}
			}
		]
}, 


you can control per-biome spawning via vehicle/mech tags
current supported values:
	NoBiome_generic,
	NoBiome_highlandsSpring,
	NoBiome_highlandsFall,
	NoBiome_lowlandsSpring,
	NoBiome_lowlandsFall,
	NoBiome_desertParched,
	NoBiome_badlandsParched,
	NoBiome_lowlandsCoastal,
	NoBiome_lunarVacuum,
	NoBiome_martianVacuum,
	NoBiome_polarFrozen,
	NoBiome_tundraFrozen,
	NoBiome_jungleTropical,
	NoBiome_urbanHighTech,

