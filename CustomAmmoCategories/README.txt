Special thanks to janxious, LadyAlekto, MpStark, Morphyum, m22spencer, bloodydoves, Colobos, CptMoore, Danadan, LtShade, CWolf and many others make this mod possible

CharlesB cannibalized. Readme in CharlesB_README.md. Settings in CharlesB_settings.json 
Unpack to Mods folder
CustomAmmoCategories settings 
CustomAmmoCategoriesSettings.json
WeaponRealizer settings
WeaponRealizerSettings.json (for description look at the WR-README)
AttackImprovementMod settings
AIM_settings.json (for description look at the AIM-README)

WARNING! Shipped versions of AIM can't be loaded by ModTek and can't be used standalone.
WARNING! This version of CAC can be used only with ModTek 0.7.6.5+ cause it utilizes dynamic enums for subsystem for AmmoCategory 

click on right side of HUD weapon slot to switch mode (near hit chance)
click on center of HUD weapon slot to switch ammo (near ammo count)
ctrl+left click on weapon slot will eject current ammo 
ctrl+T will toggle attack direction marks visibility (circles under mechs feets)
NOTE: ammo can't be ejected if mech moved this round
     after ejection mech can't jump and sprint until end of round
    
NOTE: You can modify weapon accuracy on specific range via unit statistic parameters
X - firing distance
CACMinRangeAccuracyMod - 0 < X < MinRange
CACShortRangeAccuracyMod - MinRange <= X < ShortRange
CACMediumRangeAccuracyMod - ShortRange <= X < MediumRange
CACLongRangeAccuracyMod - MediumRange <= X < LongRange
CACExtraLongRangeAccuracyMod - LongRange <= X < MaxRange


Additional unit statistic
CACAPProtection - boolean - if true unit is protected from all AP damage including AP crits. If armor is absent crits will be rolled anyway
CACAoEDamageMult - float - multipicator for all AoE damage to unit including AoE heat and stability if applicable. (Working for weapon attacks, landmines and component explosions)
CACAPDamageMult - float - multipicator for all AP damage to unit (only pierce through part of damage)
CACIncomingHeatMult - float - multipicator for all incoming heat (weapon attacks, landmines, burning terrain, AoE damage)
CACIncomingStabilityMult - float - multipicator for all incoming stability (weapon attacks, landmines, burning terrain, AoE damage)

{
"debugLog":true, - enable debug log 
"ImprovedBallisticByDefault": true - Default value for ImprovedBallistic flag if not set explicitly in weapon definition. Default true.
"ShowEvasiveAsNumber": true, - if true near evasive pips bar its amount will be showed as number
"EvasiveNumberFontSize" : 24 - font size for evasive pips count
"EvasiveNumberWidth": 25 - size of background for evasive pips count. You should adjust this if changed font size. 
"EvasiveNumberHeight": 20
"ResetHeatSinkMessageTemplate":"USED HEAT SINKS:{0}=>{1}", - template for reset used heatsinks message
"ApplyHeatSinkMessageTemplate":"APPLY HEAT SINKS:{0}=>{1} HCAP:{1} USED:{2}=>{3}", - template for allied heatsinks message
"ApplyHeatSinkActorStat":"CACOverrallHeatSinked", - actor's stat name for overall heat sinked during battle
"OverrallShootsCountWeaponStat": "CACOverallShoots" - actor's stat name for overall shoots from weapon during battle
"AmmoGenericBoxUINameAsName": true - if true for fake ammo box UIName needed to buy ammo without box Name of ammunition will be used rather than UIName.
"modHTTPServer":false, - enable debug http server
"modHTTPListen":"http://localhost:65080/" - debug http server url, if enabled
"forbiddenRangeEnable:true, - enable or disable forbidden range mechanic, if false ForbiddenRange always counts as 0 
"ClusterAIMult":0.2, - AI use this value to calculate cluster weapon mode/ammo (more projectiles, less damage per projectile) prefer coefficient 
                            in case of low target armor and/or exposed locations
"PenetrateAIMult":0.4 - AI use this value to calculate penetrate weapon mode/ammo (less projectiles, more damage per projectile) prefer coefficient 
                            in case of full target armor and no exposed locations
"JamAIAvoid":1.0, - if higher than 1.0, AI will more avoid jamming modes/ammo. 0.0 will result division by zero exception. 
                      0 < X < 1.0f AI will prefer jamming modes/ammo (i don't know why it needs, but you can)
"DamageJamAIAvoid":2.0, - if higher than 1.0, AI will more avoid modes/ammo that damage weapon on jamming. 0.0 will result division by zero exception. 
                      0 < X < 1.0f AI will prefer damage jamming modes/ammo (i don't know why it needs, but you can)
					  NOTE: if AI has exposed locations, it will lose all fear and will not avoid dangerous modes and ammo.
"AmmoCanBeExhausted":true - enables or disables ammo exhaustion mechanic. See CanBeExhaustedAt parameter is ammo definition.
"BurningForestDesignMask":"DesignMaskBurningForest", - design mask for burning forest
"BurnedForestDesignMask":"DesignMaskBurnedForest",  - design mask for burned forest
"BurningTerrainDesignMask":"DesignMaskBurningTerrain" - design mask for burning terrain
"BurningForestCellRadius":3, - obsolete. You should avoid change this value
"BurningForestTurns":3, - rounds forest on fire
"AdditinalAssets": ["nuked"], - additional assets for VFX to load on init
"BurningForestStrength":30, - heat damage for burning forest
"BurningForestBaseExpandChance":0.5, - chance to expand for burning cell (fire can be expanded only to hex cell with forest)
"DynamicDesignMasksDefs":["DesignMaskCrystals","DesignMaskForest","DesignMaskGeothermal","DesignMaskGeothermalLava","DesignMaskIce","DesignMaskRadiation","DesignMaskSpores","DesignMaskBurningForest","DesignMaskBurnedForest","DesignMaskBurningTerrain"],
 list of design mask to load. <BurningForestDesignMask> and <BurnedForestDesignMask> should always included to this list. 
"BurningFX":"vfxPrfPrtl_fireTerrain_lrgLoop", - VFX prefab spawned in hex cell on fire
"BurnedFX":"vfxPrfPrtl_miningSmokePlume_lrg_loop", - not used any more
"BurningScaleX":1, - scale for burning VFX (note not all VFXes supports scaling vfxPrfPrtl_fireTerrain_lrgLoop does not)
"BurningScaleY":1,
"BurningScaleZ":1,
"BurnedScaleX":1,  - scale for burned VFX (note not all VFXes supports scaling vfxPrfPrtl_miningSmokePlume_lrg_loop does not)
"BurnedScaleY":1,
"BurnedScaleZ":1,
"BurnedOffsetX":0, - offset for burning VFX
"BurnedOffsetY":0,
"BurnedOffsetZ":0,
"BurningOffsetX":0, - offset for burned VFX
"BurningOffsetY":0,
"BurningOffsetZ":0,
"DontShowNotDangerouceJammMessages": true, - if true cooldown and jamming weapon without damage not cause floatie message
"MineFieldPathingMods":{ - landmines hit roll modificator by pathing. Effective value multiplicative. If not found in this table consider as 1.0.
    "pathingdef_light":0,
	"pathingdef_medium":0.5
  },
"JumpLandingMineAttractRadius": 2, - radius of terrain cells affected on landing after jump
"BurnedTrees":{  - better not to change anything unless you know what you are doing 
  "Mesh":"envMdlTree_deadWood_polar_frozen_shapeA_LOD0", - prefab containing burned tree mesh (must be loaded as part of additional assets)
  "BumpMap":"envTxrTree_treesVaried_polar_frozen_nrm", - burned trees textures (must be loaded as part of additional assets)
  "MainTex":"envTxrTree_treesVaried_polar_frozen_alb",
  "OcculusionMap":"envTxrTree_treesVaried_polar_frozen_amb",
  "Transmission":"envTxrTree_treesVaried_polar_frozen_trs",
  "MetallicGlossMap":"envTxrTree_treesVaried_polar_frozen_mtl",
  "BurnedTreeScale":2,  - scale of burned trees 
  "DecalScale":40, - size of burned terrain decale
  "DecalTexture":"envTxrDecl_terrainDmgSmallBlack_alb" - burned terrain decale texture (must be loaded as part of additional assets)
},
"DontShowBurnedTrees":false, - if true burned trees will be hidden instead of drawing burned variant
"DontShowScorchTerrain":false - if true burned terrain decal will not be applied 
"AAMSAICoeff":0.2 - factor that determines how much AI will prefer the strategic mode of missile defence in the presence of friendly units in the area of the anti-missile system 
"ForestBurningDurationBiomeMult":{  -        per biome forest fire duration multiplayer, applied to BurningForestTurns value (rounded to nearest integer)
	"DesignMaskBiomeBadlandsParched":0.7,
	"DesignMaskBiomeDesertParched":0.7,
	"DesignMaskBiomeHighlandsFall":1,
	"DesignMaskBiomeHighlandsSpring":1,
	"DesignMaskBiomeJungleTropical":1.5,
	"DesignMaskBiomeLowlandsCoastal":1,
	"DesignMaskBiomeLowlandsFall":1,
	"DesignMaskBiomeLowlandsSpring":1,
	"DesignMaskBiomeLunarVacuum":0.0,
	"DesignMaskBiomeMartianVacuum":0.0,
	"DesignMaskBiomePolarFrozen":0.7,
	"DesignMaskBiomeTundraFrozen":0.7
},
"WeaponBurningDurationBiomeMult":{  -        per biome fire duration multiplayer, applied to effective Weapon.FireDurationWithoutForest value (rounded to nearest integer)
	"DesignMaskBiomeBadlandsParched":1,
	"DesignMaskBiomeDesertParched":1,
	"DesignMaskBiomeHighlandsFall":1,
	"DesignMaskBiomeHighlandsSpring":1,
	"DesignMaskBiomeJungleTropical":0.7,
	"DesignMaskBiomeLowlandsCoastal":1,
	"DesignMaskBiomeLowlandsFall":1,
	"DesignMaskBiomeLowlandsSpring":1,
	"DesignMaskBiomeLunarVacuum":0.2,
	"DesignMaskBiomeMartianVacuum":0.3,
	"DesignMaskBiomePolarFrozen":0.7,
	"DesignMaskBiomeTundraFrozen":0.7
},
"ForestBurningStrengthBiomeMult":{  -        per biome forest fire strength multiplayer, applied to BurningForestStrength value (rounded to nearest integer)
	"DesignMaskBiomeBadlandsParched":1.5,
	"DesignMaskBiomeDesertParched":1.5,
	"DesignMaskBiomeHighlandsFall":1,
	"DesignMaskBiomeHighlandsSpring":1,
	"DesignMaskBiomeJungleTropical":0.5,
	"DesignMaskBiomeLowlandsCoastal":1,
	"DesignMaskBiomeLowlandsFall":1,
	"DesignMaskBiomeLowlandsSpring":1,
	"DesignMaskBiomeLunarVacuum":0,
	"DesignMaskBiomeMartianVacuum":0,
	"DesignMaskBiomePolarFrozen":0.3,
	"DesignMaskBiomeTundraFrozen":0.3
},
"WeaponBurningStrengthBiomeMult":{   -        per biome fire strength multiplayer, applied to effective Weapon.FireTerrainStrength value (rounded to nearest integer)
	"DesignMaskBiomeBadlandsParched":1,
	"DesignMaskBiomeDesertParched":1,
	"DesignMaskBiomeHighlandsFall":1,
	"DesignMaskBiomeHighlandsSpring":1,
	"DesignMaskBiomeJungleTropical":0.7,
	"DesignMaskBiomeLowlandsCoastal":1,
	"DesignMaskBiomeLowlandsFall":1,
	"DesignMaskBiomeLowlandsSpring":1,
	"DesignMaskBiomeLunarVacuum":1,
	"DesignMaskBiomeMartianVacuum":1,
	"DesignMaskBiomePolarFrozen":0.5,
	"DesignMaskBiomeTundraFrozen":0.5
},
"LitFireChanceBiomeMult":{   -        per biome fire chance multiplayer, applied to effective Weapon.FireTerrainChance and BurningForestBaseExpandChance values
	"DesignMaskBiomeBadlandsParched":2.0,
	"DesignMaskBiomeDesertParched":2.0,
	"DesignMaskBiomeHighlandsFall":1,
	"DesignMaskBiomeHighlandsSpring":1,
	"DesignMaskBiomeJungleTropical":0.7,
	"DesignMaskBiomeLowlandsCoastal":1,
	"DesignMaskBiomeLowlandsFall":1,
	"DesignMaskBiomeLowlandsSpring":1,
	"DesignMaskBiomeLunarVacuum":1,
	"DesignMaskBiomeMartianVacuum":1,
	"DesignMaskBiomePolarFrozen":0.5,
	"DesignMaskBiomeTundraFrozen":0.5
}
NOTE: Current values is my own vision of flame mechanics process, adjust them for you own will
								
"AmmoCookoff":{ - AmmoCookoffSettings
					Ammo explosions roll a chance to explode every time your mech overheats, and they roll a more severe chance if you overheat enough to force a shut down.
					By default, these values are 10% per box, and 20% per box respectively.
					there are some settings on how the chances work, and they should be self-explanatory.
  "Enabled":false, - enable or disable AmmoCookoff mechanic overall 
  "OverheatChance":10,
  "ShutdownHeatChance":25,
  "UseHBSMercySetting":true
},
"AdvancedCirtProcessing":true, - if false vanilla crit processing used. Eg only mechs, crit to can inflicted to empty slot. 
                                If true crit to occupied slots and to mechs, vehicles and turrets. 
"APMinCritChance": 0.1, - Minimal crit chance on AP processing.
                          Basics: 
                            advanced crit calculations:
                              normal crit: crit chance = Max(Constants.ResolutionConstants.MinCritChance, (1 - <current structure>/<max structure>))
                              so minimal value is Constants.ResolutionConstants.MinCritChance maximum 1 (if structure near zero). If random roll less than this value crit success if grater - no crit
                              AP crit:
                                 basic crit chance = Max(APMinCritChance, (1 - <current structure>/<max structure>))
                                 armor shards mod = 1 + (1 - <current armor>/<max armor>)*weapon.APArmorShardsMod. 
                                 armor thickness mod = (1f - armor / weapon.APMaxArmorThickness) if weapon.APMaxArmorThickness = 0 armor thickness mod is 1.0. 
                                 if armor greater weapon.APMaxArmorThickness and weapon.APMaxArmorThickness grater than zero armor thickness mod = 0 (mean no AP crit)
                                 weapon ap crit mod = weapon.APCriticalChanceMultiplier (if weapon.APCriticalChanceMultiplier = 0, weapon ap crit mod set to 1.0)
                                 crit chance =  basic crit chance * armor shards mod * armor thickness mod * weapon ap crit mod
                                 Main idea: weapon can have two mechanics of armor piece - solid core and cumulative jet
                                    first one cause shards from previously damaged armor hit components increasing crit chance
                                    second one have limited cumulative jet length and can't penetrate armor if too thick 
"DestroyedComponentsCritTrap":true, - if true destroyed component can be crit trap. Eg destroyed components is involved in crit roll but crit to destroyed component do nothing. 
"CritLocationTransfer": true, - if true if there no components suitable for crit roll in mech's location crit will be transfered arm/leg->side torso->center torso 
"NoCritFloatieMessage": false, - if set enables or disables criticals floatie messages. If omitted it tries to detect MechEngineer, if detects consider as true (eg. no floatie messages)
"RemoveFromCritRollStatName": "IgnoreDamage", - on criticals resolution components having this staistic set as true will be excluded from list of available for crit. 
                                                NOTE! excluding from list have side effect with CritLocationTransfer enabled. If in location there are only components with IgnoreDamage:true 
                                                it consider as empty and crit will be transfered to another location according transfer logic. 
"bloodSettings":{   - if DestructibleUrbanFlimsy it can leave blood spot
  "DecalScales":{    - sizes of blood spots by types. Types: NOT_SET, generic, smallMetal, mediumMetal, largeMetal, smallStone, mediumStone, largeStone, 
                                                             smallGlass, mediumGlass, largeGlass, smallMixed, mediumMixed, largeMixed, smallFence, mediumFence,
                                                             largeFence, smallRadiotower, mediumRadiotower, largeRadiotower, smallVehicle, mediumVehicle, largeVehicle, 
                                                             electronic,lightPole, vehicleFiery
    "smallVehicle":10,
    "mediumVehicle":20,
    "largeVehicle":30,
    "vehicleFiery":15
  },
  "DecalTexture": "envTxrDecl_terrainDmgSmallBlood_alb", - texture for blood spot
  "DrawBloodChance": 0.3 - chance on leave blood spot on destruction
  "DefaultAoEDamageMult": {  - AoE modifiers by unit's types. Available types: Mech, Vehicle, Turret, Building
    "Building": {
      "Range": 1.2,
      "Damage": 5
    }
  },
  "TagAoEDamageMult": {      - AoE modifiers by unit's tags. Tags watching lists: for mechs: MechTags and ChassisTags; for vehicles: VehicleTags; for turrets: TurretTags
							   Note: all unit types also use EncounterTags. This tags listed at contract definitions. 
							   Also alternate representation switching can alter unit EncounterTags
    "aoe_increased_minor": {
      "Range": 1.2,
      "Damage": 1.2
    },
    "aoe_increased_major": {
      "Range": 2,
      "Damage": 2
    },
    "aoe_reduced_minor": {
      "Range": 0.8,
      "Damage": 0.8
    },
    "aoe_reduced_major": {
      "Range": 0.5,
      "Damage": 0.5
    },
    "aoe_reduced_huge": {
      "Range": 0.1,
      "Damage": 0.1
    }
  },
},
"showMissBehavior":"Default", - miss margin behavior.
                                   None - miss floaties never shown
                                   Vanilla - miss floaties shown as in vanilla (no miss margin)
                                   Default - miss floaties shown as AIM's ShowMissMargin: true
                                   All - show all miss floaties with miss margin
"DestoryedLocationDamageTransferStructure":true - if true damage to destroyed locations transferred to structure directly instead of armor 
"NullifyDestoryedLocationDamage": true - if true damage to destroyed locations will be nullified 
"DestoryedLocationCriticalAllow": true - if false and on hit locations had 0 structure criticals will not be rolled 
"uiIcons": [ "weapon_up", "weapon_down" ] - some prewarm icons 
  "WeaponPanelBackWidthScale": 1.45, - !!you should avoid change this value!!
  "OrderButtonWidthScale": 0.5, - obsolete 
  "OrderButtonPaddingScale": 0.3, - obsolete 
  "SidePanelInfoSelfExternal": false, - if true info side panel content about selected unit is controlled by external mod
  "SidePanelInfoTargetExternal": true - if true info side panel content about selected target is controlled by external mod
  there two methods in API 
    CustAmmoCategories.CombatHUDInfoSidePanelHelper.SetSelfInfo(AbstractActor actor, Text text) 
    CustAmmoCategories.CombatHUDInfoSidePanelHelper.SetTargetInfo(AbstractActor actor,ICombatant target, Text text)
  on each invocation side panel refreshing. 
  "MechHasNoStabilityTag": ["mech_no_stability"], - if mech chassis have this tag no instability damage applied by incoming attacks, land mines, components explosions.
  "TransferHeatDamageToNormalTag": ["heat_damage_to_normal"], - if mech chassis have this tag incoming heat damage from attacks, land mines, burning terrain, components explosions transferred to normal damage instead.
  "InfoPanelDefaultState": false, - if true side info panel is shown by default
  "AttackLogWrite": false - if true csv attack log will be created in CustomAmmoCatogories/AttacksLogs
  "ShowAttackGroundButton": false - obsolete, attack ground button showing always
  "ShowWeaponOrderButtons": false - obsolete, order buttons showing always
  "ToHitSelfJumped":2, - from AIM
  "ToHitMechFromFront":0, - from AIM
  "ToHitMechFromSide":-1, - from AIM
  "ToHitMechFromRear":-2, - from AIM
  "ToHitVehicleFromFront":0, - from AIM
  "ToHitVehicleFromSide":-1, - from AIM
  "ToHitVehicleFromRear":-2, - from AIM
  "WeaponPanelWidthScale":0.7, - scale for weapon panel
  "WeaponPanelHeightScale":0.7, - scale for weapon panel
  "MinefieldDetectorStatName": "MinefieldDetection", - stat name for actor's landmines detection level (float). Default value 1.
  "MinefieldIFFStatName": "MinefieldIFF", - stat name for actor landmines IFF ability (float). Default value 0. 
  "AmmoNameInSidePanel": true - if true in side panel AmmunitionDef.Name will be shown instead of AmmunitionDef.UIName
  "ShowApplyHeatSinkMessage": true - show floatie message on heatsinks appying.
  "AMSCantFireFloatie": false, - if true if AMS can't fire reason will be shown in floatie message
  "ShowJammChance": true - if true side panel will show jam chance calculation formula
  "RemoveToHitModifiers":[] - list of to-hit modifiers to forbid 
                              posible values
								ranged only
							        "RANGE"
									"OBSTRUCTED"
									"ARM MOUNTED"
									"HEIGHT DIFF"
									"FROM" - attacker design mask
									"INTO" - target design mask
									"TARGET MOVED"
									"ATTACKER ACCURACY" - (SENSORS IMPAIRED/INSPIRED)
									"REFIRE"
									"SENSOR LOCK"
									"INDIRECT FIRE"
									"MORALE"
									"DIRECT"
									"TARGET TYPE"  - tags
								both
									"JUMPED"
									"MOVED SELF"
									"HEAT"
									"STOOD UP"
									"WEAPON ACCURACY"
									"SPRINTED"
									"WEAPON DAMAGED"
									"DAMAGED" - location damaged
									"DIRECTION" - flank/rear
									"TARGET SIZE"
									"TARGET SHUTDOWN"
									"TARGET PRONE"
									"ENEMY EFFECTS"
								melee
									"DEATH FROM ABOVE"
									"CHASSIS BONUS"
									"TERRAIN" - same as INTO for ranged
									"MELEE ARM MOUNTED"
									"MELEE HEIGHT DIFF"
									"MELEE RECOIL"
									"MELEE TARGET MOVED"

}

Weapon definition
new fields
  "BuildingsDamageModifier":1,    - weapon damage modifier if target is building
  "TurretDamageModifier":1,       - weapon damage modifier if target is turret
  "VehicleDamageModifier":1,      - weapon damage modifier if target is vehicle
  "MechDamageModifier":1,         - weapon damage modifier if target is mech  
  "QuadDamageModifier":1,         - weapon damage modifier if target is quad
  "TrooperSquadDamageModifier":1, - weapon damage modifier if target is trooper squad
  "AirMechDamageModifier":1,      - weapon damage modifier if target is in air mech mode
  "VTOLDamageModifier":1,         - weapon damage modifier if target is VTOL (unaffected by pathing and flying height > 1m)
	                       NOTE: to make this modifiers work you should also have CustomUnits mod enabled
						   NOTE: this modifiers multiplicative for weapon, ammo, mode. Default value - 1.0
						   NOTE: this modifiers affects all damage types - normal, ap, heat, stability
						   NOTE: this modifiers multiplicative per target type. Quad is still a mech so it will have both modifiers. 
						         VTOL is still vehicle, mech in air mech mode is still mech.
  "MinMissRadius": 5,
  "MaxMissRadius": 15,
                        - min and max radius. Used only in ground attack and indirect attack. Additive for ammo/mode/weapon
						  If MinMissRadius less than target radius (for mechs in chassis definition, for vehicles and turrets 5) radius value will be used.
						  If MaxMissRadius less or equal than MinMissRadius value MinMissRadius * 3 will be used.
						  actual scatter radius = ((MaxMissRadius - MinMissRadius) * (hitRoll - toHitChance) / (1 - toHitChance) + MinMissRadius)
  "evasivePipsMods": {  - list of modifiers for values by current evasive pips count. Additive per weapon/ammo/mode. 
                          Overall formula value = [base value] * ([evasive pips count]^[mod value]). Example base damage = 35, evasive pips count = 7, mod value = -1
                          damage = 35 * (7^-1) = 35 * 0.142857(142857) = 5.
                          NOTE: of evasive pips count = 0, value will not been altered. If mod value = 0 same behavior.
      "Damage":0,
      "APDamage":0,
      "Heat":0,
      "Instablility":0,
      "GeneratedHeat":0,
      "FlatJammingChance":0,
      "MinRange":0,
      "ShortRange":0,
      "MediumRange":0,
      "LongRange":0,
      "MaxRange":0,
      "AOERange":0,
      "AOEDamage":0,
      "AOEHeatDamage":0,
      "AOEInstability":0,
      "RefireModifier":0,
      "APCriticalChanceMultiplier":0,
      "AccuracyModifier":0,
      "DamageVariance":0,
      "CriticalChanceMultiplier":0
  },
  "deferredEffect":{                                   - deferred effect !!!CAN!!! be set per mode, ammo, weapon. Mode have priority than ammo and than weapon.
    "id":"LOIC",                                       - id used in logs 
    "rounds":2,                                        - rounds to effects apply
    "text":"LOIC",                                     - text displayed while waiting 
    "VFX":"vfxPrfPrtl_orbitalPPC_oneshot",             - vfx displayed after timeout
    "waitVFX":"vfxPrfPrtl_artillerySmokeSignal_loop",  - vfx displayed while waiting
    "SFX":"ion_cannon_example",                        - sound played on VFX played
    "VFXtime":20,                                      - time in seconds while VFX is played. After this vfx will be stopped and pooled.
    "damageApplyTime": 6,                              - time in seconds from start to apply damage/status effects/terrain effects. 
	                                                     Once effect playing is starts turn can't be advanced until damage apply
    "AOERange":50,                                     - AOE range
    "AOEDamage": 1000,                                 - AOE damage
    "AOEHeatDamage": 1000,                             - AOE heat damage
    "AOEInstability": 1000,                            - AOE instability 
	                                                   
    "RangeColor":{"C":"#00FF00","I":1.5},              - Color for text and range circle	                                                   
    "FireTerrainChance": 0.8,                          - fire terrain chance 
    "FireDurationWithoutForest": 0,                    - turns fire will exists on terrain without forest 
    "FireTerrainStrength": 30,                         - heat damage from fire
    "FireTerrainCellRadius": 12,                       - radius in game cells (each cell have 4x4 size)
    "TerrainVFX":"vfxPrfPrtl_terrainLavaCracks_loop",  - terrain vfx (apply to each hex cell)
    "TerrainVFXScale": {"x":1,"y":1,"z":1},            - scale for vfx
    "tempDesignMask":"DesignMaskGeothermalLava",       - design mask
    "tempDesignMaskTurns": 99,                         - length in turns design mask and terrain vfx exists
    "tempDesignMaskCellRadius": 12,                    - radius in game cells 
	                                                   NOTE: all values above have same apply logic as mine explosions. 
    "statusEffects": [],                               - status effects array
	  "statusEffectsRangeFalloff": true,                 - range falloff for status effects - if true effect will be applience will be optional, 
	                                                     chance is based on distance from center of effect. 
	  "sticky": true                                     - it true on success hit deferred effect position links to target. Does not matter if it moves or become dead.
  },
  "ShotsPerAmmo": 1,              - shots per ammo. Example: you have effective shots count = 4 and ShotsPerAmmo = 0.5. After fire ammo will be decremented by 2 (4 * 0.5)
                                    Mutiplicative per weapon, ammo, mode. Default value 1. NOTE: Ammo decrement value rounded to nearest integer. 
                                    If it will be less than 0.5 - it will be your own problem - no ammo will be used.
  "InternalAmmo":{                - starting ammo capacity per ammo id.
    "Ammunition_intLRM":20,                    StartingAmmoCapacity is counted as default ammo for base category
    "Ammunition_intSRM":15
  },
  "preFireSFX":"Play_PPC3",       - sound played on weapon's fire !!!CAN!!! be set per mode, ammo, weapon. Mode have priority than ammo and than weapon.
  "blockWeaponsInMechLocations": [], - list of mech locations. all weapons installed in this locations can't fire if this weapon is functional.
                                       NOTE: weapon can block itself.
  "CanBeBlocked": true               - if false weapon can't be blocked by other weapons presents (default is true).
  "blockWeaponsInInstalledLocation": true - if true this weapon blocks weapons in location it installed. Weapon block itself until CanBeBlocked is false
  "EjectWeapon": true,                 - if true weapon become non functional (without explosion) instead of ammo ejection on eject ammo command. 
                                         Can be used to unblock other weapons. Default false.
  "AOEEffectsFalloff": false, if true and weapon inflicts AoE damage, random roll will be permitted before onHit effect apply. 
                              Example: aoe range = 100m, projectile hits ground in 30m from combatant - onHits effects will be applied with 0.7 chance ((100 - 30) / 100).
  "isHeatVariation": true, - if true heat damage will be altered using DamageVariance/DistantVariance/DistantVarianceReversed values. Per mode/ammo/weapon.
  "isStabilityVariation": true, - if true stability damage will be altered using DamageVariance/DistantVariance/DistantVarianceReversed values. Per mode/ammo/weapon.
  "isDamageVariation": true, - if true normal damage will be altered using DamageVariance/DistantVariance/DistantVarianceReversed values. Per mode/ammo/weapon.
  "DamageNotDivided": false, - if true and ImprovedBallistic and BallisticDamagePerPallet are true also damage(heat and stability) will not be divided by ProjectilesPerShot.
  "APDamage": 10, - damage amount always inflicted to inner structure trough armor. If armor breached this damage will be added to normal damage. Additive per mode/ammo/weapon, default 0.
  "APCriticalChanceMultiplier": 0.5, - armor pierce crit chance multiplier. Additive per mode/ammo/weapon, default 0.
                                  NOTE: if effective APDamage > 0 crit roll is placed anyway. But if even if APDamage = 0 and APCriticalChanceMultiplier is set per mode ammo or weapon crit will be placed on each hit without damage to inner structure (like AP autocannon ammo). So weapon can inflict AP damage + AP crit or AP crit alone.
                                  To have APCriticalChanceMultiplier apply normally AdvancedCirtProcessing should be true.
                                  On crit resolve if there is still armor > 0 in location crit chance will be multiplied to APCriticalChanceMultiplier (if set). 
                                  Consider to be used to lower crit chance if trough armor. If there no armor in location crit chance will not be altered.
                                  If AdvancedCirtProcessing is false crit will still be rolled but chance will not be altered. 
  "APMaxArmorThickness": 0f, - max armor thickness for AP crits. See APMinCritChance setting notes.
  "APArmorShardsMod": 0f, - AP crit modifier for damaged armor. See APMinCritChance setting notes.
  "EvasivePipsIgnored" : 1, This value can be controlled via weapon's EvasivePipsIgnored statistic value (float)
  "ProjectileSpeedMultiplier": 0.1, - projectile speed multiplier. Less is slower. Multiplicative per weapon/mode/ammo. Works only with ImprovedBallistic true (ballistic/laser/ppc/missile)
                                     NOTE! Do not set this to low values cause if projectile flying takes too long attack sequence will be terminated by timeout.
                                     NOTE! For lasers ProjectileSpeed it is duration so greater value will result longer firing 
                                        (opposite for other effects greater value makes projectiles fly faster and lower duration).
  "MissileVolleySize": 5, - volley size override for missile launchers. Only works with ImprovedBallistic true. 
                             Some basics: every missile launcher model have emmiters. Launcher counts number of emmiters as volley size. 
                             If model not setuped properly launcher effects it fallbacks to one emmiter with weapon object position so volley size always 1. 
                             You can use this to override this behavior. 
  "ProjectileScale": {"x":10,"y":10,"z":10}, - scale for projectile. Only works with ImprovedBallistic true or IsAMS/IsAAMS (only for AMS fire sequence). 
                                                Works properly only for missiles/autocannons/gauss/ppc. Impact effects and missiles explosions scales accordingly.
                                                Can be set per mode/ammo/weapon. Higher priority replace lower priority value. Mode have priority, than ammo, than weapon.
  "ColorsTable" : [ - Colors array per weapon
    {
      "C":"red"     - Color in html notation. Note for ballistic and ppc effect color can be not fully accurate. If color can't be parsed fallback color is magenta
      ,"I":5        - Color intensivity, used only for lasers 
    },
    {"C":"orange","I":5},{"C":"yellow","I":5},{"C":"green","I":5},{"C":"aqua","I":5},{"C":"blue","I":5},{"C":"purple","I":5}
  ],
  "ColorSpeedChange": 7, - Color change speed. Approximately this number shows how many colors changed during projectile flying. Per mode/ammo/weapon. 
                            Higher priority replace lower priority value. Mode have priority, than ammo, than weapon. 0 counts as not set so will be used next value by priority.
  "ColorChangeRule": "Linear", - Color changing rule. Possible values
                                 None - original color
                                 Linear - colors chanded one by one from start of weapon's colors table
                                 Random - color will be choosed randomly from weapon's colors table. On change while firing next color will be choosed randomly also.
                                 RandomOnce - color will be chosen randomly as projectile start and will not be changed during firing. 
                                 t0 - color with index 0 will be choosen from weapon's colors table and will not be changed during firing. 
                                 t1 - color with index 1 will be choosen from weapon's colors table and will not be changed during firing. 
                                 ........................................................................................................
                                 t31 - color with index 31 will be choosen from weapon's colors table and will not be changed during firing. 
                                 Higher priority replace lower priority value. Mode have priority, than ammo, than weapon. "None" counts as not set so will be used next value by priority.
                                 If color need to be changed it is always changed smoothly. 
                          NOTE! Changing colors avaible only for ImprovedBallistic true or IsAMS/IsAAMS (only for AMS fire sequence) and only for laser/ppc/autocannon effects.
                          NOTE! Coloring of missile trail possible too but only for normal missiles (not AMS) and without changing while flying. Eg ColorSpeedChange for missiles trail if useless
                          ColorChangeRule - Linear equivalent t0,  Random = RandomOnce. 
                          NOTE! "I" value in color table is used for missile trail too (consider be around 2, but you can experiment)
  "MissileFiringIntervalMultiplier": 10, - multiplier for firing interval. Only for missile firing effect. Only works with ImprovedBallistic true. Greater is slower. 
                                     NOTE! Do not set this to very high values cause if delay will be too long  attack sequence will be terminated by timeout.
  "MissileVolleyIntervalMultiplier": 10, - multiplier for missile volley fire interval. Only for missile firing effect. Only works with ImprovedBallistic true. Greater is slower. 
                                     NOTE! Do not set this to very high values cause if delay will be too long  attack sequence will be terminated by timeout.
                                     Some basics: every missile launcher prefab have emiter points. For example your missile launcher prefab have 3 emmiters and you lauching 4 missiles, 
                                     than missile fire sequence looks like: 
                                     missile 0 launch (emmiter 0) -> delay (firing interval) -> missile 1 launch (emmiter 1) -> delay (firing interval) 
                                       -> missile 2 launch (emmiter 2) -> delay (volley interval) -> missile 3 launch (emmiter 0)
  "FireDelayMultiplier": 10, - multiplier for multi-shot fire delay. Only works with ImprovedBallistic. Default for weapon 10. Multiplicative per weapon/mode/ammo. For ammo and mode default is 1.
                              !PLEASE READ NEXT NOTE CAREFULY: Now ImprovedBallistic works for lasers and PPCs, but laser ans PPC effects has no shotDelay parameter in assets which ballistic has. 
                              So, for laser and PPC effects i have to use other parameter for shot delay. This parameter is projectileSpeed.
                              For lasers projectileSpeed controls beam duration, so improved laser fire sequence looks like: beam (projectileSpeed duration) -> delay (projectileSpeed*FireDelayMultiplier) -> next beam
                              For PPC projectileSpeed it is projectile speed, so improved PPC fire sequence looks like: 
                                pulse start -> pulse fly (duration distance/projectileSpeed) -> pulse hit -> delay ((distance/projectileSpeed)*FireDelayMultiplier) -> next pulse start
  "CantHitUnaffecedByPathing": false, - if true this weapon can't hit targets unaffected by pathing. 
                                        If user tries to perform DFA attack having this weapon enabled he/she will receive blocking popup message.
                                        can be set per weapon/ammo/mode mode have priority than ammo than weapon
  "Streak": true/false - if true only success hits will be shown, ammo decremental and heat generation will be based on success hits. 
                          Can be set for mode/ammo/weapon. Mode have priority than ammo, than weapon.
							with "HitGenerator" : "Streak" - will be true streak effect all-hit-or-no-fire
  "HitGenerator" : "Streak", Set to hit generator. Supported values ("Individual"/"Cluster"/"Streak"). 
                                  Streak hit generator is sort of cluster, 
								  if first projectile hit, rest hit too (location distribution as cluster hit generator),
								  if first projectile misses, rest misses too
								  if not set weapon hit generator will be used.
								  if not set hit generator will be choosed by weapon type.
								  if weapon define has tag "wr-clustered_shots", "Cluster" hit generator will be forced. 
  "DirectFireModifier" : -10.0, Accuracy modifier if weapon can strike directly
  "DamageVariance": 20, - Simple damage variance as implemented in WeaponRealizer
  "DamageFalloffStartDistance": 0, - distance where damage starts to change, additive per ammo/mode/weapon.
  "DamageFalloffEndDistance": 0, - distance where damage stops to change, additive per ammo/mode/weapon.
  "DistantVariance": 0.3, - Distance damage variance addiditve per ammo/mode/weapon
  "DistantVarianceReversed": false, - Set is distance damage variance is reversed (mode have priority, than ammo, than weapon)
	Distance variance logic:
	1. If DistantVarianceReversed false
	  a) if DistantVariance > 1.0 - (0 <= distance <= DamageFalloffStartDistance) damage coeff = DistantVariance
	                       (DamageFalloffStartDistance < distance < DamageFalloffEndDistance)
						   damage coeff decrease from DistantVariance(at DamageFalloffStartDistance) to 1(at DamageFalloffEndDistance)
	  b) if DistantVariance < 1.0 - (0 <= distance <= DamageFalloffStartDistance) damage coeff = 1
	                       (DamageFalloffStartDistance < distance < DamageFalloffEndDistance)
						   damage coeff decrease from 1(at DamageFalloffStartDistance) to DistantVariance(at DamageFalloffEndDistance)
						   if DamageFalloffStartDistance is 0 assumed to be MediumRange
						   if DamageFalloffEndDistance is less than DamageFalloffStartDistance assumed to be MaxRange
	2. If DistantVarianceReversed true
	  a) if DistantVariance > 1.0 - (0 <= distance <= DamageFalloffStartDistance) damage coeff = 1
	                       (DamageFalloffStartDistance < distance < DamageFalloffEndDistance) 
						   damage coeff grow from 1(at DamageFalloffStartDistance) to DistantVariance(at DamageFalloffEndDistance)
						   (DamageFalloffEndDistance <= distance < MaxRange) damage coeff = DistantVariance
	  b) if DistantVariance < 1.0 - (0 <= distance <= DamageFalloffStartDistance) damage coeff = DistantVariance
	                       (DamageFalloffStartDistance < distance < DamageFalloffEndDistance) 
						   damage coeff grow from DistantVariance(at DamageFalloffStartDistance) to 1(at DamageFalloffEndDistance)
						   (DamageFalloffEndDistance <= distance < MaxRange) damage coeff = 1
						   if DamageFalloffStartDistance is 0 assumed to be MinRange
						   if DamageFalloffEndDistance is less than DamageFalloffStartDistance assumed to be MediumRange						   
  "RangedDmgFalloffType": "Linear", - function to recalculate distance ratio to damage in distance variance
                           Posible values: "Quadratic", "Cubic", "SquareRoot", "Log10", "LogE", "Exp", "Linear"
						   mode have priority, than ammo, than weapon. Default value Quadratic
  "AoEDmgFalloffType": "Linear", - function to distance ratio to damage in AoE damage processing
                           Posible values: "Quadratic", "Cubic", "SquareRoot", "Log10", "LogE", "Exp", "Linear"
						   mode have priority, than ammo, than weapon. Default value Linear
  "DamageOnJamming": true/false, - if true on jamming weapon will be damaged
  "DestroyOnJamming": true/false, - if true on jamming weapon will be destroyed (need DamageOnJamming to be set true also)
  "FlatJammingChance": 1.0, - Chance of jamming weapon after fire. 1.0 is jamm always. Unjamming logic implemented as in WeaponRealizer
                              NOTE! There FlatJammingChance can be altered via CACFlatJammingChance statistic value per actor's and/or per weapon's statistic collections
  "GunneryJammingBase": 5, - 
  "GunneryJammingMult": 0.05, - this values uses to alter flat jamming chance by pilot skills 
                                  formula effective jamming chance = FlatJammingChance + (GunneryJammingBase - Pilot Gunnery)* GunneryJammingMult
								  if FlatJammingChance = 1.0, GunneryJammingBase = 6, GunneryJammingMult = 0.1, GunnerySkill = 10
								  result = 1.0 + (6-10)*0.1 = 0.6
								  GunneryJammingBase if ommited in weapon def., ammo def. and mode def. assumed as 5. 
  "DisableClustering": true/false - if true ProjectilesPerShot > 1 will affect only visual nor damage. If omitted consider as true.
  (not used any more)"NotUseInMelee": true, - if true even AntiPersonel weapon type will not fire on melee attack, AI aware. 
  "AlternateDamageCalc": false, - if true alternate damage calc formula will be implemented 
                              DamagePerShot = (damage from weaponDef + (damage from ammo) + (damage from mode)*(damage multiplayer from ammo)*(damage multiplayer from mode)*(damage with effects)/(damage from weaponDef)
  "AlternateHeatDamageCalc": false, - same as  AlternateDamageCalc but for heat 
  "AlternateInstabilityCalc": false, - same as  AlternateDamageCalc but for instability 
  "AMSHitChance": 0.0, - if this weapon is AMS, this value is AMS efficiency, 
                         if this weapon is missile launcher this value shows how difficult to intercept missile with AMS. Negative value - is harder, 
						 positive is easer.
  "IsAMS": false, - if true this weapon acts as AMS. It will not fire during normal attack. But tries to intercept incomming missiles.
                    rude model: every 10 meters of missile fly path there is check, if it in range of any AMS. 
					If so, AMS have AMS.AMSHitChance + missile.AMSHitChance chance to shoot missile down. Avaible shoots count of AMS is decrementing.
					If AMS have no shoots avaible it will not shoot. At end of turn AMS shoots count set to AMS.ShootsWhenFired.
					If missile intercepted, no further checks will be made. 
					Commentary: as you can see, if missile fly path is short chance to be shooted down is less. 
					If missiles is few, and fly path is long chance to be shooted down grows rapidly. 
					AMS can become jammed, have damage-on-jam option and so on. AMSHitChance and ShootsWhenFired can be updated in AMS ammo or mode.
					AMS uses ammunition and heated while firing. Damage and on hit status effects will on be applied. 
  "IsAAMS": false - if true, weapon acts as advanced AMS, it will fire all missiles from enemies in range, not only attacking.
						NOTE! AMS can be setted by mode, ammo and weapon. Mode have priority, than ammo, and then weapon. 
						NOTE! If you weapon shoots as AMS in current round you can't use it in offensive mode (if any) until next round.
							  On other hand if you fired weapon this round you will not be able to use this weapon as AMS until next activation completes 
						NOTE! Every weapon effect can be used as visuals for AMS fire (missile, machine gun, ballistic, laser, gauss) you can experiment,
						      but some effects is more suitable.
  "AMSShootsEveryAttack": false, - if true AMS will not share AMS.ShootsWhenFired between all missile attacks this round. 
                                       Every missile attack will cause AMS.ShootsWhenFired shoots. 
								   if false AMS will shoot AMS.ShootsWhenFired per round
  "AMSImmune": false - if true, weapon missiles is immune to AMS and none AMS will try to intercept them. Can be set for mode ammo and weapon
  "MissileHealth": 1, - health of missile. Used while AMS working. If missile health become 0 missile counted as intercepted. Additive for ammo, mode, weapon.
  "AMSDamage": 1, - damage AMS inflicting to missiles subtracting from missile health on success hit. Used while AMS working. If missile health become 0 missile counted as intercepted. Additive for ammo, mode, weapon.
  "AOECapable" : false, - if true weapon will included in AOE damage calculations. If true set in weapon definition 
                            all shoots will have AoE effect (even for energy weapon). If true, it can't be overridden by ammo.
  "AOERange": 100, - Area of effect range. If AOECapable in weapon is set to true this value will be used. If AOECapable is true, it can't be overridden by ammo.
  "AOEDamage": 0 - AoE damage. Same rules as for AOERange
  "AOEHeatDamage": 0 - AoE heat. Same rules as for AOERange 
  "AOEInstability": 0 - instability AoE damage. Same rules as for AOERange 
  "SpreadRange": 0, - Area of projectiles spread effect. If > 0 projectiles will include in spread calculations. Per weapon, ammo, mode values are additive.
                         if used for missiles, and target have AMS it will fire no matter if it is not advanced and target is not primary.
  "IFFDef" : "IFFComponentDefId", if not empty and target have component with such defId it will exclude form AoE and spread targets list. 
                                   if not empty weapon owner will be excluded form AoE and spread targets list anyway even it has no suitable IFF component.
								   supposed weapon have IFF transponder for own projectiles. If not empty ammo transponder has priority, than mode, and than weapon
								   There is special transponder name "_IFFOffile" - if transponder defId set as IFFOffline it counts as have no transponder at all.
  "HasShells": true/false, if defined determinate has shots shrapnel effect or not. If defined can't be overriden by ammo or mode. 
                            Shells count is effective ProjectilesPerShot for this weapon/ammo/mode.
                            Damage per shell - full damage per projectile / ProjectilesPerShot
                            Only for missiles, ballistic and gauss effects.
							NOTE! If ImprovedBallistic is false HasShells considered as false too no matter real value. 
  "ShellsRadius": 90, determines if shells will have spreading. Works same way as SpreadRange. Per weapon value will be used if HasShells is true for this weapon.
  "MinShellsDistance": 30, Minimum distance missile have to fly before explode. Min value 30.
  "MaxShellsDistance": 100, Distance from end of trajectory where missile should separate. Min value 20
                             Note: example - trajectory length 200, min 80, max 100 - missile will separate 100m from end.
							       example 2 trajectory length 100, min 80, max 100 - missile will separate 20m from end cause it have to fly 80m until separation. 
								   example 3 trajectory length 100 min 120, max 200 - missile will not separate at all. 
  "Unguided": false, for missiles effect only. If true missile trajectory will be strait line instead of curvy. Like it is unguided as old WW2 rockets. 
          Have no influence to indirect fire curvy
					logic: if ammo unguided is true - launch will be unguided no matter mode and weapon settings, 
					if ammo unguided is false or not set i'm looking at mode. if mode unguided is true launch will be unguided, 
					if mode unguided is false or not set i'm looking at weapon. 
					if weapon unguided is true launch will be unguided if not set or false launch will be guided
  "FireTerrainChance":1, - chance to fireup hex cell. Additive for weapon, ammo and mode
  "FireDurationWithoutForest":1, - duration of fire if hex cell has no forest, if > 0 even hex cell with no forest will burn. 
                                  If cell have forest burn period is max from FireDurationWithoutForest and BurningForestTurns
								  additive for weapon mode and ammo.
  "FireTerrainStrength":0, - strength of fire. If 0 and hex cell have no forest cell will not fire. If > 0 and hex cell have forest strength is max from FireTerrainStrength and BurningForestStrength
                                  additive for weapon mode and ammo.
  "FireOnSuccessHit" : true, - if true roll to fire hex cell will be permitted even on success hit. In that case fire hex cell will be detected as current target position. 
                               if false only projectiles that hits ground have chance to fire terrain. If ommited in weapon ammo and mode supposed as false.
							   mode value have priority, than ammo and than weapon.
					NOTES: expanding logic each turn each burning cell (no matter having forest or not) have BurningForestBaseExpandChance to expand no neighbour cell with forest 
					       burning cell not counted as forest.
						   If mech or vehicle ending move in burning cell they suffer heat damage. For mech it is heat damage, for vehicle it is normal damage splitted by all locations except turret.
						   Damage inflicted to vehicle that way are not cause critical damage to internal components only armor and structure.
						   Fired cell not saved on battle save/reload.
   "FireTerrainCellRadius":6, - radius in in-game cells to fire check roll. On impact each hex cell containing at least one map cell with in radius will have chance to be burned
                                additive for weapon mode and ammo.
   "AdditionalImpactVFX":"WFX_Nuke", - additional VFX played on impact. Mode have priority, than ammo, than weapon. Long played effects not supposed. 
                                       Effect game object will be cleaned and returned to pool on next fire sequence of this weapon. 
   "AdditionalImpactVFXScaleX":10, - scale of additional VFX, used only when AdditionalImpactVFX is not empty. Note, not all VFXs supports scaling.
   "AdditionalImpactVFXScaleY":10,
   "AdditionalImpactVFXScaleZ":10,
   "ClearMineFieldRadius": 4, - radius in in-game terrain cells. Minefields in all cells within radius will be cleared in terrain impact.
                                Clearing on success hit controled by FireOnSuccessHit flag.
   "Cooldown": 2, - number of rounds weapon will be unacceptable after fire this mode
   "ImprovedBallistic": true, - whether use or not own ballistic/laser/PPC/missile weapon effect engine. 
								Difference between "improved" and vanilla engine:
								1. Improved mode uses ShotsWhenFire properly (vanilla had not used them at all)
								2. Improved mode can use curvy trajectory for indirect fire (ballistic only) (indirect gauss bullet can be used too, but looks very funny)
								3. Improved mode fire ShotsWhenFire volleys with ProjectilesPerShot bullets in each. 
								   Bullets/beams/pulses in one volley fired simultaneously instead of one by one (as in WeaponRealizer)
								   But damage still dealt once per volley, not per bullet, to keep compatibility with vanilla.
								NOTE! If ImprovedBallistic is set DisableClustering is forced to true and "wr-clustered_shots" tag removed from definition. 
  "BallisticDamagePerPallet": true - if true damage inflicted per pallet instead of per shot. Only working with ImprovedBallistic true, ballistic/laser/PPC weapon effect and HasShels false
                                     Damage will be divided by ProjectilesPerShot value, heat damage and stable damage too.
	"StatusEffectsPerHit":false - if true OnHit status effects applying on each hit instead on once. 
	"AdditionalAudioEffect": "enum:AudioEventList_explosion.explosion_propane_tank", - additional sound effect on projectile impact. Value format "<type>:<name>".
							 type values: "enum" - building in-game enum value
							              "id" - unsigned integer (if you know value)
								   		  "name" - audio event name 
										  "none" - none additional sound for this type name doesn't matter
							 may be set per ammo, mode and weapon. Mode have priority than ammo than weapon
   "Modes": array of modes for weapon
	[{
		"Id": "x4",  - Must be unique per weapon
		"UIName": "x4", - This string will be displayed near weapon name
		"Name": "x4", - This string will be displayed in side panel. If absent UIName used.
		"Description":"", - This string will be displayed in side panel if this mode is selected.
    "APDamage": 10, - damage amount always inflicted to inner structure trough armor. If armor breached this damage will be added to normal damage. Additive per mode/ammo/weapon, default 0.
    "APCriticalChanceMultiplier": 0.5, - armor pierce crit chance multiplier. Additive per mode/ammo/weapon, default 0.
                                    NOTE: if effective APDamage > 0 crit roll is placed anyway. But if even if APDamage = 0 and APCriticalChanceMultiplier is set per mode ammo or weapon crit will be placed on each hit without damage to inner structure (like AP autocannon ammo). So weapon can inflict AP damage + AP crit or AP crit alone.
                                    To have APCriticalChanceMultiplier apply normally AdvancedCirtProcessing should be true.
                                    On crit resolve if there is still armor > 0 in location crit chance will be multiplied to APCriticalChanceMultiplier (if set). 
                                    Consider to be used to lower crit chance if trough armor. If there no armor in location crit chance will not be altered.
                                    If AdvancedCirtProcessing is false crit will still be rolled but chance will not be altered. 
    "ProjectileSpeedMultiplier": 1, - projectile speed multiplier. Less is slower. Multiplicative per weapon/mode/ammo. 
                                       NOTE! Do not set this to low values cause if projectile flying takes too long attack sequence will be terminated by timeout.
    "MissileFiringIntervalMultiplier": 10, - multiplier for firing interval. Only for missile firing effect. Greater is slower. 
                                       NOTE! Do not set this to very high values cause if delay will be too long  attack sequence will be terminated by timeout.
    "MissileVolleyIntervalMultiplier": 10, - multiplier for missile volley fire interval. Only for missile firing effect. Greater is slower. 
                                       NOTE! Do not set this to very high values cause if delay will be too long  attack sequence will be terminated by timeout.
                                       Some basics: every missile launcher prefab have emiter points. For example your missile launcher prefab have 3 emmiters and you lauching 4 missiles, 
                                       than missile fire sequence looks like: 
                                       missile 0 launch (emmiter 0) -> delay (firing interval) -> missile 1 launch (emmiter 1) -> delay (firing interval) 
                                         -> missile 2 launch (emmiter 2) -> delay (volley interval) -> missile 3 launch (emmiter 0)
    "FireDelayMultiplier": 1, - multiplier for multi-shot fire delay. Only works with ImprovedBallistic. Default for weapon 10. Multiplicative per weapon/mode/ammo. For ammo and mode default is 1.
                                !PLEASE READ NEXT NOTE CAREFULY: Now ImprovedBallistic works for lasers and PPCs, but laser ans PPC effects has no shotDelay parameter in assets which ballistic has. 
                                So, for laser and PPC effects i have to use other parameter for shot delay. This parameter is projectileSpeed.
                                For lasers projectileSpeed controls beam duration, so improved laser fire sequence looks like: beam (projectileSpeed duration) -> delay (projectileSpeed*FireDelayMultiplier) -> next beam
                                For PPC projectileSpeed it is projectile speed, so improved PPC fire sequence looks like: 
                                  pulse start -> pulse fly (duration distance/projectileSpeed) -> pulse hit -> delay ((distance/projectileSpeed)*FireDelayMultiplier) -> next pulse start
    "CantHitUnaffecedByPathing": false, - if true this weapon can't hit targets unaffected by pathing. 
                                          If user tries to perform DFA attack having this weapon enabled he/she will receive blocking popup message.
                                          can be set per weapon/ammo/mode mode have priority than ammo than weapon
    "Streak": true/false - if true only success hits will be shown, ammo decremental and heat generation will be based on success hits. 
                            Can be set for mode/ammo/weapon. Mode have priority than ammo, than weapon.
		"isBaseMode":true, - Weapon must have one base mode. Mode with this setting will used by default
		"WeaponEffectID" : "WeaponEffect-Weapon_PPC", Played fire effect can be set in mode definition
		"EvasivePipsIgnored" : 0, This value will be added to EvasivePipsIgnored (current weapon status effects will be used too)

		"AccuracyModifier" : -10.0, This value will be added to AccuracyModifier (current weapon status effects will be used too)
		"CriticalChanceMultiplier" : 0.0, This value will be added to CriticalChanceMultiplier (current weapon status effects will be used too)
		"DamagePerShot": -50.0, This value will be added to DamagePerShot (current weapon status effects will be used too)
		"ShotsWhenFired" : 0, This value will be added to ShotsWhenFired (current weapon status effects will be used too)
		"ProjectilesPerShot" : 0, This value will be added to ProjectilesPerShot (current weapon status effects will be used too)
		"HeatDamagePerShot": 0.0, This value will be added to HeatDamagePerShot (current weapon status effects will be used too)
		   
		"MinRange": 0.0, This value will be added to MinRange (current weapon status effects will be used too)
		"MaxRange": 0.0, This value will be added to MaxRange (current weapon status effects will be used too)
		"ShortRange": 0.0, This value will be added to ShortRange (current weapon status effects will be used too)
		"MediumRange": 0.0, This value will be added to MediumRange (current weapon status effects will be used too)
		"LongRange": 0.0, This value will be added to LongRange (current weapon status effects will be used too)
			 NOTE: Range modifications not always displays correctly while viewing shooting arc, but hit chance and possibility calculated normally. 
		"ForbiddenRange": 90, - weapon can't fire at all if range to target is less than this value
		"HeatGenerated" : 0, This value will be added to HeatGenerated (current weapon status effects will be used too)
		"RefireModifier" : 0, This value will be added to RefireModifier (current weapon status effects will be used too)
		"Instability" : 0, This value will be added to Instability (current weapon status effects will be used too)
		"AttackRecoil" : 0, This value will be added to AttackRecoil
		"IndirectFireCapable" : false, Effective IndirectFireCapable will be taken from ammo. If not set in ammo define, weapon value will be used
		"EvasivePipsIgnored" : 0, This value will be added to EvasivePipsIgnored.
		"HitGenerator" : "Individual", Set to hit generator. Supported values ("Individual"/"Cluster"/"Streak"). 
									  Streak hit generator is sort of cluster, 
									  if first projectile hit, rest hit too (location distribution as cluster hit generator),
									  if first projectile misses, rest misses too
									  if not set weapon hit generator will be used.
									  if weapon define has tag "wr-clustered_shots", "Cluster" hit generator will be forced. 
		"DirectFireModifier" : -10.0, Accuracy modifier if weapon can strike directly
		"FlatJammingChance": 1.0, - Chance of jamming weapon after fire. 1.0 is jamm always. Unjamming logic implemented as in WeaponRealizer
	    "GunneryJammingBase": 5, - 
	    "GunneryJammingMult": 0.05, - this values uses to alter flat jamming chance by pilot skills 
									  formula effective jamming chance = FlatJammingChance + (GunneryJammingBase - Pilot Gunnery)* GunneryJammingMult
									  if FlatJammingChance = 1.0, GunneryJammingBase = 6, GunneryJammingMult = 0.1, GunnerySkill = 10
									  result = 1.0 + (6-10)*0.1 = 0.6
								      GunneryJammingBase if omitted in weapon def., ammo def. and mode def. assumed as 5. 
		"DamageVariance": 20, - Simple damage variance as implemented in WeaponRealizer
		"Cooldown": 2, - number of rounds weapon will be unacceptable after fire this mode
		"AIHitChanceCap": 0.3, - not used any more
		"DamageOnJamming": true/false, - if true on jamming weapon will be damaged
    "DestroyOnJamming": true/false, - if true on jamming weapon will be destroyed (need DamageOnJamming to be set true also)
		"DamageMultiplier":2.0, - damage multiplier for this mode. Multiplicative per ammo/mode. If omitted assumed to be 1.0.
		"HeatMultiplier":2.0, - heat multiplier for this mode. Multiplicative per ammo/mode. If omitted assumed to be 1.0.
		"InstabilityMultiplier":2.0, - instability multiplier for this mode. Multiplicative per ammo/mode. If omitted assumed to be 1.0.
		"AlwaysIndirectVisuals": false, if true missiles will always plays indirect visuals, even if direct line of sight exists
		"AmmoCategory": "LRM", AmmoCategory can now be overridden by weapon mode. If setted as "NotSet" weapon wouldn't use any ammo. 
		                       If weapon has mode with "NotSet" ammo category you will not see warnings in mechlab for this weapon, 
							   even if you are not supply this weapon with ammo.
		  "AMSHitChance": 0.0, - if this weapon is AMS, this value is AMS efficiency, 
								 if this weapon is missile launcher this value shows how difficult to intercept missile with AMS. Negative value - is harder, 
								 positive is easer.
	  "SpreadRange": 0, - Area of projectiles spread effect. If > 0 projectiles will include in spread calculations. Per weapon, ammo, mode values are additive.
							 if used for missiles, and target have AMS it will fire no matter if it is not advanced and target is not primary.
	  "IFFDef" : "IFFComponentDefId", if not empty and target have component with such defId it will exclude form AoE and spread targets list. 
									   if not empty weapon owner will be excluded form AoE and spread targets list anyway even it has no suitable IFF component.
									   supposed weapon have IFF transponder for own projectiles. If not empty ammo transponder has priority, than mode, and than weapon
									   There is special transponder name "_IFFOffile" - if transponder defId set as IFFOffline it counts as have no transponder at all.
	  "HasShells": true/false, if defined determinate has shots shrapnel effect or not. If defined can't be overriden by ammo or mode. 
								Shells count is effective ProjectilesPerShot for this weapon/ammo/mode.
								Damage per shell - full damage per projectile / ProjectilesPerShot
								Only for missiles, ballistic and gauss effects. Should not be used with AoE.
								NOTE! If ImprovedBallistic is false HasShells considered as false too no matter real value. 
	  "ShellsRadius": 90, determines if shells will have spreading. Works same way as SpreadRange. Per mode value will be used if HasShells is true for this mode.
	  "MinShellsDistance": 30, Minimum distance missile have to fly before explode. Min value 30.
	  "MaxShellsDistance": 100, Distance from end of trajectory where missile should separate. Min value 20
								 Note: example - trajectory length 200, min 80, max 100 - missile will separate 100m from end.
									   example 2 trajectory length 100, min 80, max 100 - missile will separate 20m from end cause it have to fly 80m until separation. 
									   example 3 trajectory length 100 min 120, max 200 - missile will not separate at all. 
	  "Unguided": false, for missiles effect only. If true missile trajectory will be strait line instead of curvy. Like it is unguided as old WW2 rockets. 
          Have no influence to indirect fire curvy
					logic: if ammo unguided is true - launch will be unguided no matter mode and weapon settings, 
					if ammo unguided is false or not set i'm looking at mode. if mode unguided is true launch will be unguided, 
					if mode unguided is false or not set i'm looking at weapon. 
					if weapon unguided is true launch will be unguided if not set or false launch will be guided
  "FireTerrainChance":1, - chance to fireup hex cell. Additive for weapon, ammo and mode
  "FireDurationWithoutForest":1, - duration of fire if hex cell has no forest, if > 0 even hex cell with no forest will burn. 
                                  If cell have forest burn period is max from FireDurationWithoutForest and BurningForestTurns
								  additive for weapon mode and ammo.
  "FireTerrainStrength":0, - strength of fire. If 0 and hex cell have no forest cell will not fire. If > 0 and hex cell have forest strength is max from FireTerrainStrength and BurningForestStrength
                                  additive for weapon mode and ammo.
  "FireOnSuccessHit" : true, - if true roll to fire hex cell will be permitted even on success hit. In that case fire hex cell will be detected as current target position. 
                               if false only projectiles that hits ground have chance to fire terrain. If ommited in weapon ammo and mode supposed as false.
							   mode value have priority, than ammo and than weapon.
					NOTES: expanding logic each turn each burning cell (no matter having forest or not) have BurningForestBaseExpandChance to expand no neighbour cell with forest 
					       burning cell not counted as forest.
						   If mech or vehicle ending move in burning cell they suffer heat damage. For mech it is heat damage, for vehicle it is normal damage splitted by all locations except turret.
						   Damage inflicted to vehicle that way are not cause critical damage to internal components only armor and structure.
						   Fired cell not saved on battle save/reload.
   "FireTerrainCellRadius":6, - radius in in-game cells to fire check roll. On impact each hex cell containing at least one map cell with in radius will have chance to be burned
                                additive for weapon mode and ammo.
   "AdditionalImpactVFX":"WFX_Nuke", - additional VFX played on impact. Mode have priority, than ammo, than weapon. Long played effects not supposed. 
                                       Effect game object will be cleaned and returned to pool on next fire sequence of this weapon. 
   "AdditionalImpactVFXScaleX":10, - scale of additional VFX, used only when AdditionalImpactVFX is not empty. Note, not all VFXs supports scaling.
   "AdditionalImpactVFXScaleY":10,
   "AdditionalImpactVFXScaleZ":10,
   "ClearMineFieldRadius": 4, - radius in in-game terrain cells. Minefields in all cells within radius will be cleared in terrain impact.
                                Clearing on success hit controled by FireOnSuccessHit flag.
	  "IsAMS": false, - if true this weapon acts as AMS. It will not fire during normal attack. But tries to intercept incomming missiles.
						rude model: every 10 meters of missile fly path there is check, if it in range of any AMS. 
						If so, AMS have AMS.AMSHitChance + missile.AMSHitChance chance to shoot missile down. Avaible shoots count of AMS is decrementing.
						If AMS have no shoots avaible it will not shoot. At end of turn AMS shoots count set to AMS.ShootsWhenFired.
						If missile intercepted, no further checks will be made. 
						Commentary: as you can see, if missile fly path is short chance to be shooted down is less. 
						If missiles is few, and fly path is long chance to be shooted down grows rapidly. 
						AMS can become jammed, have damage-on-jam option and so on. AMSHitChance and ShootsWhenFired can be updated in AMS ammo or mode.
						AMS uses ammunition and heated while firing. Damage and on hit status effects will on be applied. 
	  "IsAAMS": false - if true, weapon acts as advanced AMS, it will fire all missiles from enemies in range, not only attacking.
						NOTE! AMS can be setted by mode, ammo and weapon. Mode have priority, than ammo, and then weapon. 
						NOTE! If you weapon shoots as AMS in current round you can't use it in offensive mode (if any) until next round.
							  On other hand if you fired weapon this round you will not be able to use this weapon as AMS until next activation completes 
						NOTE! Every weapon effect can be used as visuals for AMS fire (missile, machine gun, ballistic, laser, gauss) you can experiment,
						      but some effects is more suitable.
  "BallisticDamagePerPallet": true - if true damage inflicted per pallet instead of per shot. Only working with ImprovedBallistic true, ballistic weapon effect and HasShels false
                                     Damage will be divided by ProjectilesPerShot value, heat damage and stable damage too. 
	"AdditionalAudioEffect": "enum:AudioEventList_explosion.explosion_propane_tank", - additional sound effect on projectile impact. Value format "<type>:<name>".
							 type values: "enum" - building in-game enum value
							              "id" - unsigned integer (if you know value)
								   		  "name" - audio event name 
										  "none" - none additional sound for this type name doesn't matter
							 may be set per ammo, mode and weapon. Mode have priority than ammo than weapon
  "Lock":{ - setting to lock using of this mode. 
    "HeatLevel":{"Low":40,"High":60}, - lock by absolute heat. If current heat is less Low or greater High, mode using will be forbidden.
    "OverheatLevel":{"Low":0.5,"High":1.0}, - lock by heat relative to Overheat. If current heat level is less Low or greater High, mode using will be forbidden.
    "MaxheatLevel":{"Low":0.3,"High":0.5}, - lock by heat relative to maximum heat. If current heat level is less Low or greater High, mode using will be forbidden.
                                             NOTE! If two or more lock options defined check logic will be: at first checked HeatLevel(if available) if pass 
                                             check OverheatLevel(if available) if pass check (MaxheatLevel is available) if all available options pass mode is allowed. 
                                             NOTE! Heat level have sense only for mechs, for vehicles and turrets check is always passed. 
                                             NOTE! If all modes fail check weapon will be disabled.
  }
	}]
  
  
Ammo definition
{
   "Custom" : {} - custom section on ammunition will be merged to all boxes definitions using this ammo. 
   "AutoRefill": "Automatic" - how this ammunition will be refilled after battle. Available values
							  "Automatic" - same behavior as before. Default
							  "Shop" - ammo will be bought automatically if available in system store and player have sufficient c-bills amount
							  "Manual" - player have to buy ammo by himself
							  NOTE! "Shop" and "Manual" is not recommended to use at current development stage
   "AvailableOnPlanet": [], - tags list planet should have to ammo (without boxes) can be bought.
   "HideIfOnlyVariant": true, - if true this ammo name will be hidden if only variant for this mode. Default false.
   "Description" : {
      "Id" : "Ammunition_LBX10ECM",
      "Name" : "LBX/10 ECM Ammo",
      "UIName" : "ECM",
      "Details" : "Large caliber rounds capable of dealing heavy damage, and designed to be used in an LBX/10.",
      "Icon" : null,
      "Cost" : 0,
      "Rarity" : 0,
      "Purchasable" : false
   },
   "Type" : "Normal",
   "Category" : "LBX10", 
      
   
   "WeaponEffectID" : "WeaponEffect-Weapon_PPC", Played fire effect can be set in ammo definition, for example this LBX AC10 will fire as PPC if ECM ammo is choosed
    "APDamage": 10, - damage amount always inflicted to inner structure trough armor. If armor breached this damage will be added to normal damage. Additive per mode/ammo/weapon, default 0.
    "APCriticalChanceMultiplier": 0.5, - armor pierce crit chance multiplier. Additive per mode/ammo/weapon, default 0.
                                    NOTE: if effective APDamage > 0 crit roll is placed anyway. But if even if APDamage = 0 and APCriticalChanceMultiplier is set per mode ammo or weapon crit will be placed on each hit without damage to inner structure (like AP autocannon ammo). So weapon can inflict AP damage + AP crit or AP crit alone.
                                    To have APCriticalChanceMultiplier apply normally AdvancedCirtProcessing should be true.
                                    On crit resolve if there is still armor > 0 in location crit chance will be multiplied to APCriticalChanceMultiplier (if set). 
                                    Consider to be used to lower crit chance if trough armor. If there no armor in location crit chance will not be altered.
                                    If AdvancedCirtProcessing is false crit will still be rolled but chance will not be altered. 
   "EvasivePipsIgnored" : 0, This value will be added to EvasivePipsIgnored (current weapon status effects will be used too)
    "Streak": true/false - if true only success hits will be shown, ammo decremental and heat generation will be based on success hits. 
                            Can be set for mode/ammo/weapon. Mode have priority than ammo, than weapon.
    "ProjectileSpeedMultiplier": 1, - projectile speed multiplier. Less is slower. Multiplicative per weapon/mode/ammo. 
                                       NOTE! Do not set this to low values cause if projectile flying takes too long attack sequence will be terminated by timeout.
    "MissileFiringIntervalMultiplier": 10, - multiplier for firing interval. Only for missile firing effect. Greater is slower. 
                                       NOTE! Do not set this to very high values cause if delay will be too long  attack sequence will be terminated by timeout.
    "MissileVolleyIntervalMultiplier": 10, - multiplier for missile volley fire interval. Only for missile firing effect. Greater is slower. 
                                       NOTE! Do not set this to very high values cause if delay will be too long  attack sequence will be terminated by timeout.
                                       Some basics: every missile launcher prefab have emiter points. For example your missile launcher prefab have 3 emmiters and you lauching 4 missiles, 
                                       than missile fire sequence looks like: 
                                       missile 0 launch (emmiter 0) -> delay (firing interval) -> missile 1 launch (emmiter 1) -> delay (firing interval) 
                                         -> missile 2 launch (emmiter 2) -> delay (volley interval) -> missile 3 launch (emmiter 0)
    "FireDelayMultiplier": 1, - multiplier for multi-shot fire delay. Only works with ImprovedBallistic. Default for weapon 10. Multiplicative per weapon/mode/ammo. For ammo and mode default is 1.
                                !PLEASE READ NEXT NOTE CAREFULY: Now ImprovedBallistic works for lasers and PPCs, but laser ans PPC effects has no shotDelay parameter in assets which ballistic has. 
                                So, for laser and PPC effects i have to use other parameter for shot delay. This parameter is projectileSpeed.
                                For lasers projectileSpeed controls beam duration, so improved laser fire sequence looks like: beam (projectileSpeed duration) -> delay (projectileSpeed*FireDelayMultiplier) -> next beam
                                For PPC projectileSpeed it is projectile speed, so improved PPC fire sequence looks like: 
                                  pulse start -> pulse fly (duration distance/projectileSpeed) -> pulse hit -> delay ((distance/projectileSpeed)*FireDelayMultiplier) -> next pulse start
    "CantHitUnaffecedByPathing": false, - if true this weapon can't hit targets unaffected by pathing. 
                                          If user tries to perform DFA attack having this weapon enabled he/she will receive blocking popup message.
                                          can be set per weapon/ammo/mode mode have priority than ammo than weapon
   "AccuracyModifier" : -10.0, This value will be added to AccuracyModifier (current weapon status effects will be used too)
   "CriticalChanceMultiplier" : 0.0, This value will be added to CriticalChanceMultiplier (current weapon status effects will be used too)
   "DamagePerShot": -50.0, This value will be added to DamagePerShot (current weapon status effects will be used too)
   "AIBattleValue":90, Not used any more
   "ShotsWhenFired" : 0, This value will be added to ShotsWhenFired (current weapon status effects will be used too)
   "ProjectilesPerShot" : 0, This value will be added to ProjectilesPerShot (current weapon status effects will be used too)
   "HeatDamagePerShot": 0.0, This value will be added to HeatDamagePerShot (current weapon status effects will be used too)
       
   "MinRange": 0.0, This value will be added to MinRange (current weapon status effects will be used too)
   "MaxRange": 0.0, This value will be added to MaxRange (current weapon status effects will be used too)
   "ShortRange": 0.0, This value will be added to ShortRange (current weapon status effects will be used too)
   "MediumRange": 0.0, This value will be added to MediumRange (current weapon status effects will be used too)
   "LongRange": 0.0, This value will be added to LongRange (current weapon status effects will be used too)
         NOTE: Range modifications not always displays correctly while viewing shooting arc, but hit chance and possibility calculated normally. 
		 
   "HeatGenerated" : 0, This value will be added to HeatGenerated (current weapon status effects will be used too)
   "RefireModifier" : 0, This value will be added to RefireModifier (current weapon status effects will be used too)
   "Instability" : 0, This value will be added to Instability (current weapon status effects will be used too)
   "AttackRecoil" : 0, This value will be added to AttackRecoil
   "IndirectFireCapable" : false, Effective IndirectFireCapable will be taken from ammo. If not set in ammo define, weapon value will be used
   "EvasivePipsIgnored" : 0, This value will be added to EvasivePipsIgnored (current weapon status effects will be used too)
   "HitGenerator" : "Individual", Set to hit generator. Supported values ("Individual"/"Cluster"/"Streak"). 
                                  Streak hit generator is sort of cluster, 
								  if first projectile hit, rest hit too (location distribution as cluster hit generator),
								  if first projectile misses, rest misses too
								  if not set weapon hit generator will be used.
								  if weapon define has tag "wr-clustered_shots", "Cluster" hit generator will be forced. 
   "DirectFireModifier" : -10.0, Accuracy modifier if weapon can strike directly
   "FlatJammingChance": 1.0, - Chance of jamming weapon after fire. 1.0 is jamm always. Unjamming logic implemented as in WeaponRealizer
   "DamageVariance": 20, - Simple damage variance as implemented in WeaponRealizer
		"DamageMultiplier":2.0, - damage multiplier for this mode. Multiplicative per ammo/mode. If omitted assumed to be 1.0.
		"HeatMultiplier":2.0, - heat multiplier for this mode. Multiplicative per ammo/mode. If omitted assumed to be 1.0.
		"InstabilityMultiplier":2.0, - instability multiplier for this mode. Multiplicative per ammo/mode. If omitted assumed to be 1.0.
								I can't use existing "ArmorDamageModifier" and "ISDamageModifier" cause 
								  1) it is unknown what damage must be displayed in HUD
								  2) it is difficult separate damage at place of impact 
   "AMSHitChance": 0.0, - if this weapon is AMS, this value is AMS efficiency, 
                         if this weapon is missile launcher this value shows how difficult to intercept missile with AMS. Negative value - is harder, 
						 positive is easer.
   "AlwaysIndirectVisuals": false, if true missiles will always plays indirect visuals, even if direct line of sight exists
   "HeatGeneratedModifier" : 1, - heat generated modifier multiplicative for ammo/mode default 1
   "ArmorDamageModifier" : 1,
   "ISDamageModifier" : 1,
   "CriticalDamageModifier" : 1,
   "AOECapable" : false, - if true shoots will be included in AOE damage calculations 
   "AOERange": 100, - Area of effect range
						  AOE shots can inflict heat damage. It value based on weapon heat damage per shot and decreasing linear by distance between target and impact base point.
						  Projectiles intercepted by AMS will not cause AOE damage.
						  AOE to hit effect will be implemented to all targets in AoE range. 
						  On fire weapon effects will be implemented to real target only
						  Base point of AoE range calculations will be point where first projectile,
						            (if weapon have ShotsWhenFired > 1) not intercepted by AMS, hits ground.
						  It is recommended to use LRM5, LRM10, LRM15 or LRM20 as weapon subtype cause other subtypes have too huge spread when misses
						  It is good idea to set ForbiddenRage for AoE weapon
						  AOE weapon can't hit mech head, cause every headshot inflicts pilot injury. With fact AoE always dealt damage it will be imbalance. 
						  Damage variations are not applying to AoE damage
  "AOEDamage": 0 - if > 0 alternative AoE damage algorithm will be used. Main projectile will not always miss. Instead it will inflict damage twice 
                            one for main target - direct hit (this damage can be have variance) and second for all targets in AoE range including main. 
  "AOEHeatDamage": 0 - if > 0 alternative AoE damage algorithm will be used. Main projectile will not always miss. Instead it will inflict damage twice 
                            one for main target - direct hit (this damage can be have variance) and second for all targets in AoE range including main. 
  "AOEInstability": 0 - instability AoE damage 
  "SpreadRange": 0, - Area of projectiles spread effect. If > 0 projectiles will include in spread calculations. Per weapon, ammo, mode values are additive.
                         if used for missiles, and target have AMS it will fire no matter if it is not advanced and target is not primary.
  "IFFDef" : "IFFComponentDefId", if not empty and target have component with such defId it will exclude form AoE and spread targets list. 
                                   if not empty weapon owner will be excluded form AoE and spread targets list anyway even it has no suitable IFF component.
								   supposed weapon have IFF transponder for own projectiles. If not empty ammo transponder has priority, than mode, and than weapon
								   There is special transponder name "_IFFOffile" - if transponder defId set as "_IFFOffline" it counts as have no transponder at all.
  "HasShells": true/false, if defined determinate has shots shrapnel effect or not. If defined can't be overriden by ammo or mode. 
                            Shells count is effective ProjectilesPerShot for this weapon/ammo/mode.
                            Damage per shell - full damage per projectile / ProjectilesPerShot
                            Only for missiles, ballistic and gauss effects. Should not be used with AoE.
							NOTE! If ImprovedBallistic is false HasShells considered as false too no matter real value. 
  "IsAMS": false, - if true this weapon acts as AMS. It will not fire during normal attack. But tries to intercept incomming missiles.
					rude model: every 10 meters of missile fly path there is check, if it in range of any AMS. 
					If so, AMS have AMS.AMSHitChance + missile.AMSHitChance chance to shoot missile down. Avaible shoots count of AMS is decrementing.
					If AMS have no shoots avaible it will not shoot. At end of turn AMS shoots count set to AMS.ShootsWhenFired.
					If missile intercepted, no further checks will be made. 
					Commentary: as you can see, if missile fly path is short chance to be shooted down is less. 
					If missiles is few, and fly path is long chance to be shooted down grows rapidly. 
					AMS can become jammed, have damage-on-jam option and so on. AMSHitChance and ShootsWhenFired can be updated in AMS ammo or mode.
					AMS uses ammunition and heated while firing. Damage and on hit status effects will on be applied. 
  "IsAAMS": false - if true, weapon acts as advanced AMS, it will fire all missiles from enemies in range, not only attacking.
					NOTE! AMS can be setted by mode, ammo and weapon. Mode have priority, than ammo, and then weapon. 
					NOTE! If you weapon shoots as AMS in current round you can't use it in offensive mode (if any) until next round.
						  On other hand if you fired weapon this round you will not be able to use this weapon as AMS until next activation completes 
					NOTE! Every weapon effect can be used as visuals for AMS fire (missile, machine gun, ballistic, laser, gauss) you can experiment,
						  but some effects is more suitable.
  "ShellsRadius": 90, determines if shells will have spreading. Works same way as SpreadRange. Per mode value will be used if HasShells is true for this mode.
  "MinShellsDistance": 30, Minimum distance missile have to fly before explode. Min value 30.
  "MaxShellsDistance": 100, Distance from end of trajectory where missile should separate. Min value 20
							 Note: example - trajectory length 200, min 80, max 100 - missile will separate 100m from end.
								   example 2 trajectory length 100, min 80, max 100 - missile will separate 20m from end cause it have to fly 80m until separation. 
								   example 3 trajectory length 100 min 120, max 200 - missile will not separate at all. 
  "UnseparatedDamageMult": 0.8, Damage multiplier applying to shell missile which hadn't separated due to short trajectory length
  "ArmorDamageModifier" : 1, Armor damage modifier 
  "ISDamageModifier" : 1, Inner structure damage modifier
                        Note: if armor can be breached with this shot more complicated formula will be used - 
						part of damage will remove rest armor, rest part of damage will be multiply to ISDamageModifier. 
						example target have 10 armor, ArmorDamageModifier - 2, ISDamageModifier - 0.2, damage 10.
						5 points of raw damage will remove 10 armor. Rest 5 points of raw damage will inflict 1 = (5*0.2) damage to IS
						consolidated damage will be 5+1 = 6. 
	"CanBeExhaustedAt": 0.5 - if greater than 0 enables per ammo exhaustion mechanic. At end of attack sequence each uses in this attack ammo box is checked.
	                           if it has (ammo level) = (current ammo/ammo capacity) LESS than CanBeExhaustedAt for this ammo it has 
								(CanBeExhaustedAt - (ammo level)) / (ammo level) chance to be exhausted. Which means component become destroyed without explosion.	
								Example: ammo box has capacity 10, ammo has CanBeExhaustedAt - 0.5, current ammo upon check - 4. Exhaustion chance = (0.5 - 0.4)/0.5 = 0.2
								Note: if current ammo is 0, Exhaustion chance become 1. One ammo box checked once per attack. Ammo ejections initiates exhaustion check too. 
    "Unguided": false, for missiles effect only. If true missile trajectory will be strait line instead of curvy. Like it is unguided as old WW2 rockets. 
          Have no influence to indirect fire curvy
					logic: if ammo unguided is true - launch will be unguided no matter mode and weapon settings, 
					if ammo unguided is false or not set i'm looking at mode. if mode unguided is true launch will be unguided, 
					if mode unguided is false or not set i'm looking at weapon. 
					if weapon unguided is true launch will be unguided if not set or false launch will be guided
   "MineField":{
      "UIName": "cool landmine", - UI name. It is good idea to fill this field
	  "stealthLevel": 1, - Inital landmine stealth level. If effective stealth level is 1 landmine is visible on map but its type and damage marked as unknown
	                       If effective stealth level <= 0 landmine is visible and its info and type is showed in side panel.
						   If effective stealth level > 1 landmine is fully invisible.
						   effective stealth level = inital stealth level - team's landmines detection level for current hex.
						   Landmines detection level is highest <MinefieldDetectorStatName> value form team's actors (and team's allies) 
						   which basic sensors (from CAE) cover this current hex. 
						   Default inital landmine stealth level is 1.
	  "IFFLevel": 1, - Inital IFF level. If effective IFFLevel > 0 landmine will not explode if triggered by creator's team member or its ally and for creator and its allies 
	                   effective stealth level is always 0. If landmine with IFFLevel > 0 is triggered by enemy and its <MinefieldIFFStatName> > landmine effective IFFLevel
					   landmine will not explode. If landmine IFFLevel = 0 it is hostile to all. 
	  "burnReaction": "None" - How landmine reacts on hex burn.
	                           "None" - nothing happens. Default
							   "Destroy" - minefield vanished 
							   "LooseElectronic" - stealth level becomes 1, IFFlevel becomes 0
	  "InstallCellRange": 0, - radius in in-game cells to install minefield. On impact each hex cell containing at least one map cell with in radius will have minefield installed
                                0 - means only hex containing cell where impact occurs
      "Count": 1, - count of land mines in each affected hex
      "Heat": 10, - heat damage by each landmine
      "Chance": 0.8, - chance of explosion 
      "Damage": 100, - normal damage on explosion 
      "AOEDamage" : 100, - area of effect damage
      "AOERange" : 90, - area of effect range 
      "AOEHeat" : 40, - area of effect heat damage (for non mechs added to AOEDamage)
      "AOEInstability": 0, - AoE stability damage
      "VFXprefab": "WFX_Nuke", - visual effect played on landmine explosion
      "VFXMinDistance": 30, - minimal distance between landmine explosion visual effects (to control its count if there are many explosions to not overwhelm GPU). Min value 20
      "VFXScaleX": 10, - VFX scale
      "VFXScaleY": 10,
      "VFXScaleZ": 10,
      "VFXOffsetX": 0, - VFX offset
      "VFXOffsetY": 0,
      "VFXOffsetZ": 0, 
      "tempDesignMaskCellRadius":6, - radius in in-game cells to install temp design mask. On explode each hex cell containing at least one map cell with in radius will be affected by
      "tempDesignMaskOnImpactTurns":99, - count of turns persistent terrain effect played
      "tempDesignMaskOnImpact":"DesignMaskRadiation", - design mask applied on impact
                                 NOTE: tempDesignMaskOnImpact design mask are not superseding original mask (if avaible) instead new design mask creating at runtime. 
								                 This new mask is result of addition current terrain mask and tempDesignMaskOnImpact. All integer or float values is addiditve. 
								                 Name will be result of concatenation as well as description. Sticky effects concatenating too. 
       "LongVFXOnImpact": "", - terrain landmine explosion vfx supposed to be played few turns 
       "LongVFXOnImpactScaleX":1, - scale for persistent terrain vfx 
       "LongVFXOnImpactScaleY":1,
       "LongVFXOnImpactScaleZ":1,
      "SFX":"enum:AudioEventList_explosion.explosion_propane_tank", - sound effect on explosion
      "FireTerrainChance":0.8, - chance to fireup hex cell.
      "FireDurationWithoutForest":0, - duration of fire if hex cell has no forest, if > 0 even hex cell with no forest will burn. 
                                      If cell have forest burn period is max from FireDurationWithoutForest and BurningForestTurns
      "FireTerrainStrength":0, - strength of fire. If 0 and hex cell have no forest cell will not fire. If > 0 and hex cell have forest strength is max from FireTerrainStrength and BurningForestStrength
      "FireOnSuccessHit" : true, - if true roll to fire hex cell will be permitted even on success hit. In that case fire hex cell will be detected as current target position. 
                                   if false only projectiles that hits ground have chance to fire terrain. If ommited in weapon ammo and mode supposed as false.
                                  NOTES: expanding logic each turn each burning cell (no matter having forest or not) have BurningForestBaseExpandChance to expand no neighbour cell with forest 
                                         burning cell not counted as forest.
                                       If mech or vehicle ending move in burning cell they suffer heat damage. For mech it is heat damage, for vehicle it is normal damage splitted by all locations except turret.
                                       Damage inflicted to vehicle that way are not cause critical damage to internal components only armor and structure.
                                       Fired cell not saved on battle save/reload.
       "FireTerrainCellRadius":6, - radius in in-game cells to fire check roll. On impact each hex cell containing at least one map cell with in radius will have chance to be burned
	  "AoEDmgFalloffType": "Linear", - function to distance ratio to damage in AoE damage processing
                           Posible values: "Quadratic", "Cubic", "SquareRoot", "Log10", "LogE", "Exp", "Linear"
						   Default value - "Linear"
      "statusEffects" : [ - status effects applying on landmine explosion
      ]
      NOTE! For moving landmine hit roll performed every terrain cell, but only one landmine can explode. Moving and melee sequence will be interrupted after armor breach.
            But if armor has been breached already move sequence will ne interrupted only on location destroy.
            For jumping every landmine in target hex cell rolling for explode.
            Original unit triggered landmine receive only MineField.Damage. MineField.AOEDamage all other targets in MineField.AOERange
   }
   "MineFieldRadius": 3, - mapped to MineField.InstallCellRange
   "MineFieldCount": 1, - mapped to MineField.Count
   "MineFieldHeat": 4, - mapped to MineField.Heat
   "MineFieldHitChance": 0.12, - mapped to MineField.Chance
   "MineFieldDamage": 4, - mapped to MineField.Damage
  "FireTerrainChance":1, - chance to fireup hex cell. Additive for weapon, ammo and mode
  "FireDurationWithoutForest":1, - duration of fire if hex cell has no forest, if > 0 even hex cell with no forest will burn. 
                                  If cell have forest burn period is max from FireDurationWithoutForest and BurningForestTurns
								  additive for weapon mode and ammo.
  "FireTerrainStrength":0, - strength of fire. If 0 and hex cell have no forest cell will not fire. If > 0 and hex cell have forest strength is max from FireTerrainStrength and BurningForestStrength
                                  additive for weapon mode and ammo.
  "FireOnSuccessHit" : true, - if true roll to fire hex cell will be permitted even on success hit. In that case fire hex cell will be detected as current target position. 
                               if false only projectiles that hits ground have chance to fire terrain. If ommited in weapon ammo and mode supposed as false.
							   mode value have priority, than ammo and than weapon.
					NOTES: expanding logic each turn each burning cell (no matter having forest or not) have BurningForestBaseExpandChance to expand no neighbour cell with forest 
					       burning cell not counted as forest.
						   If mech or vehicle ending move in burning cell they suffer heat damage. For mech it is heat damage, for vehicle it is normal damage splitted by all locations except turret.
						   Damage inflicted to vehicle that way are not cause critical damage to internal components only armor and structure.
						   Fired cell not saved on battle save/reload.
   "FireTerrainCellRadius":6, - radius in in-game cells to fire check roll. On impact each hex cell containing at least one map cell with in radius will have chance to be burned
                                additive for weapon mode and ammo.
   "AdditionalImpactVFX":"WFX_Nuke", - additional VFX played on impact. Mode have priority, than ammo, than weapon. Long played effects not supposed. 
                                       Effect game object will be cleaned and returned to pool on next fire sequence of this weapon. 
   "AdditionalImpactVFXScaleX":10, - scale of additional VFX, used only when AdditionalImpactVFX is not empty. Note, not all VFXs supports scaling.
   "AdditionalImpactVFXScaleY":10,
   "AdditionalImpactVFXScaleZ":10,
   "LongVFXOnImpact": "vfxPrfPrtl_artillerySmokeSignal_loop", - terrain impact vfx supposed to be played few turns 
   "LongVFXOnImpactScaleX":3, - scale for persistent terrain vfx 
   "LongVFXOnImpactScaleY":20,
   "LongVFXOnImpactScaleZ":3,
   "tempDesignMaskCellRadius":6, - radius in in-game cells to fire check roll. On impact each hex cell containing at least one map cell with in radius will be affected by change
   "tempDesignMaskOnImpactTurns":3, - count of turns persistent terrain effect played
   "tempDesignMaskOnImpact":"DesignMaskSmoke", - design mask applied on impact
                                 NOTE: tempDesignMaskOnImpact design mask are not superseding original mask (if avaible) instead new design mask creating at runtime. 
								 This new mask is result of addition current terrain mask and tempDesignMaskOnImpact. All integer or float values is addiditve. 
								 Name will be result of concatenation as well as description. Sticky effects concatenating too. 
								 Appliance of mask and visuals on success hit is controled by FireOnSuccessHit flag. 
								 NOTE on design mask concatenation: if no other mask on terrain, temp mask will be implemented as defined. If there is other mask
	result - effective resulting mask.
    parentMask - undelying mask
	newMask - applying mask
	
      result.Description.Name = parentMask.Description.Name + " " + newMask.Description.Name;
      result.Description.Details = parentMask.Description.Details + "\n" + newMask.Description.Details;
      result.Description.Icon = newMask.Description.Icon;
      result.hideInUI = newMask.hideInUI;
      result.moveCostMechLight = parentMask.moveCostMechLight + newMask.moveCostMechLight - 1f;
      result.moveCostMechMedium = parentMask.moveCostMechMedium + newMask.moveCostMechMedium - 1f; 
      result.moveCostMechHeavy = parentMask.moveCostMechHeavy + newMask.moveCostMechHeavy - 1f; 
      result.moveCostMechAssault = parentMask.moveCostMechAssault + newMask.moveCostMechAssault - 1f; 
      result.moveCostTrackedLight = parentMask.moveCostTrackedLight + newMask.moveCostTrackedLight - 1f; 
      result.moveCostTrackedMedium = parentMask.moveCostTrackedMedium + newMask.moveCostTrackedMedium - 1f; 
      result.moveCostTrackedHeavy = parentMask.moveCostTrackedHeavy + newMask.moveCostTrackedHeavy - 1f; 
      result.moveCostTrackedAssault = parentMask.moveCostTrackedAssault + newMask.moveCostTrackedAssault - 1f; 
      result.moveCostWheeledLight = parentMask.moveCostWheeledLight + newMask.moveCostWheeledLight - 1f; 
      result.moveCostWheeledMedium = parentMask.moveCostWheeledMedium + newMask.moveCostWheeledMedium - 1f; 
      result.moveCostWheeledHeavy = parentMask.moveCostWheeledHeavy + newMask.moveCostWheeledHeavy - 1f; 
      result.moveCostWheeledAssault = parentMask.moveCostWheeledAssault + newMask.moveCostWheeledAssault - 1f;
      result.moveCostSprintMultiplier = parentMask.moveCostSprintMultiplier + newMask.moveCostSprintMultiplier - 1f;
      result.stabilityDamageMultiplier = parentMask.stabilityDamageMultiplier + newMask.stabilityDamageMultiplier - 1f;
      result.visibilityMultiplier = parentMask.visibilityMultiplier + newMask.visibilityMultiplier - 1f;
      result.visibilityHeight = parentMask.visibilityHeight + newMask.visibilityHeight;
      result.signatureMultiplier = parentMask.signatureMultiplier + newMask.signatureMultiplier - 1f;
      result.sensorRangeMultiplier = parentMask.sensorRangeMultiplier + newMask.sensorRangeMultiplier - 1f;
      result.targetabilityModifier = parentMask.targetabilityModifier + newMask.targetabilityModifier;
      result.meleeTargetabilityModifier = parentMask.meleeTargetabilityModifier + newMask.meleeTargetabilityModifier - 1f;
      result.grantsGuarded = newMask.grantsGuarded;
      result.grantsEvasive = newMask.grantsEvasive;
      result.toHitFromModifier = parentMask.toHitFromModifier + newMask.toHitFromModifier;
      result.heatSinkMultiplier = parentMask.heatSinkMultiplier + newMask.heatSinkMultiplier - 1f;
      result.heatPerTurn = parentMask.heatPerTurn + newMask.heatPerTurn;
      result.legStructureDamageMin = parentMask.legStructureDamageMin + newMask.legStructureDamageMin;
      result.legStructureDamageMax = parentMask.legStructureDamageMax + newMask.legStructureDamageMax;
      result.canBurn = newMask.canBurn;
      result.canExplode = newMask.canExplode;
      result.allDamageDealtMultiplier = parentMask.allDamageDealtMultiplier + newMask.allDamageDealtMultiplier - 1f;
      result.allDamageTakenMultiplier = parentMask.allDamageTakenMultiplier + newMask.allDamageTakenMultiplier - 1f;
      result.antipersonnelDamageDealtMultiplier = parentMask.antipersonnelDamageDealtMultiplier + newMask.antipersonnelDamageDealtMultiplier - 1f;
      result.antipersonnelDamageTakenMultiplier = parentMask.antipersonnelDamageTakenMultiplier + newMask.antipersonnelDamageTakenMultiplier - 1f;
      result.energyDamageDealtMultiplier = parentMask.energyDamageDealtMultiplier + newMask.energyDamageDealtMultiplier - 1f;
      result.energyDamageTakenMultiplier = parentMask.energyDamageTakenMultiplier + newMask.energyDamageTakenMultiplier - 1f;
      result.ballisticDamageDealtMultiplier = parentMask.ballisticDamageDealtMultiplier + newMask.ballisticDamageDealtMultiplier - 1f;
      result.ballisticDamageTakenMultiplier = parentMask.ballisticDamageTakenMultiplier + newMask.ballisticDamageTakenMultiplier - 1f;
      result.missileDamageDealtMultiplier = parentMask.missileDamageDealtMultiplier + newMask.missileDamageDealtMultiplier - 1f;
      result.missileDamageTakenMultiplier = parentMask.missileDamageTakenMultiplier + newMask.missileDamageTakenMultiplier - 1f;
      result.audioSwitchSurfaceType = parentMask.audioSwitchSurfaceType;
      result.audioSwitchRainingSurfaceType = parentMask.audioSwitchRainingSurfaceType;
      result.customBiomeAudioSurfaceType = parentMask.customBiomeAudioSurfaceType;
								 
	!!!!!Not all of this parameters actually used by engine. You can make some experiments to know which of them used actually. 
	
   "ClearMineFieldRadius": 4, - radius in in-game terrain cells. Minefields in all cells within radius will be cleared in terrain impact.
                                Clearing on success hit controled by FireOnSuccessHit flag.
  "BallisticDamagePerPallet": true - if true damage inflicted per pallet instead of per shot. Only working with ImprovedBallistic true, ballistic weapon effect and HasShels false
                                     Damage will be divided by ProjectilesPerShot value, heat damage and stable damage too. 
	"AdditionalAudioEffect": "enum:AudioEventList_explosion.explosion_propane_tank", - additional sound effect on projectile impact. Value format "<type>:<name>".
							 type values: "enum" - building in-game enum value
							              "id" - unsigned integer (if you know value)
								   		  "name" - audio event name 
										  "none" - none additional sound for this type name doesn't matter
							 may be set per ammo, mode and weapon. Mode have priority than ammo than weapon
   "ChassisTagsAccuracyModifiers":{ - Accuracy for mods tags (mechs - MechTags and ChassisTags, Vehicles - VehicleTags, Turrets - TurretTags)
      "unit_assault":-10,
      "unit_mech":10,
   },
   Note: all unit types also use EncounterTags. This tags listed at contract definitions. Also alternate representation switching can alter unit EncounterTags
   "statusEffects" : [   - will be applied on weapon hit (only "OnHit" effectTriggerType)
        {
            "durationData" : {
                "duration" : 5,
                "ticksOnActivations" : true,
                "useActivationsOfTarget" : true,
                "ticksOnEndOfRound" : false,
                "ticksOnMovements" : false,
                "stackLimit" : 0,
                "clearedWhenAttacked" : false
            },
            "targetingData" : {
                "effectTriggerType" : "OnHit",
                "triggerLimit" : 0,
                "extendDurationOnTrigger" : 0,
                "specialRules" : "NotSet",
                "effectTargetType" : "NotSet",
                "range" : 0,
                "forcePathRebuild" : false,
                "forceVisRebuild" : false,
                "showInTargetPreview" : true,
                "showInStatusPanel" : true
            },
            "effectType" : "StatisticEffect",
            "Description" : {
                "Id" : "AbilityDefPPC",
                "Name" : "SENSORS IMPAIRED",
                "Details" : "[AMT] Difficulty to all of this unit's attacks until its next activation.",
                "Icon" : "uixSvgIcon_status_sensorsImpaired"
            },
            "nature" : "Debuff",
            "statisticData" : {
                "appliesEachTick" : false,
                "effectsPersistAfterDestruction" : false,
                "statName" : "AccuracyModifier",
                "operation" : "Float_Add",
                "modValue" : "5.0",
                "modType" : "System.Single",
                "additionalRules" : "NotSet",
                "targetCollection" : "NotSet",
                "targetWeaponCategory" : "NotSet",
                "targetWeaponType" : "NotSet",
                "targetAmmoCategory" : "NotSet",
                "targetWeaponSubType" : "NotSet"
            },
            "tagData" : null,
            "floatieData" : null,
            "actorBurningData" : null,
            "vfxData" : null,
            "instantModData" : null,
            "poorlyMaintainedEffectData" : null
        }
    ]
}

Note:
 MinMissRadius,MaxMissRadius,AMSDamage,MissileHealth have special processing
 For this values weapon have statistic values "CAC_<name>" and "CAC_<name>_Mod" (eg CAC_MinMissRadius and CAC_MinMissRadius_Mod etc)
 Effective value formula value = (<value from ammo> + <value from mode> + <CAC_<name> statistic value>) * (<CAC_MinMissRadius_Mod statistic value>)
 For CAC_<name> default value is from definition, for CAC_<name>_Mod is 1.0

Note on damage modifiers
you can register your own modifier via API
	DamageModifiersCache.RegisterDamageModifier(
		 string id,					- your modifier unique id
	     string staticName,         - static name will be shown in UI
		 bool isStatic,             - true means your damage modifier actual value can be calculated before actual fire. 
		                              For example target type can't be changed during attack, if your modifier based on target type it can be static,
									  but if your modifier based on specific hit location it can't be static
		 bool isNormal,             - true if your modifier is normal damage modifier
		 bool isAP,                 - true if your modifier is through armor damage modifier
		 bool isHeat,               - true if your modifier is heat modifier
		 bool isStability,          - true if your modifier is stability modifier
		                              all this flags can be used simultaneity 
		 Func<                      - delegate, function will be called when damage engine will calculate your modifier actual value
			Weapon,                 - weapon
			Vector3,                - attack position
			ICombatant,             - target combatant
			bool,                   - is shot is breaching
			int,                    - hit location (for static modifiers function will be called with value = 0)
			float,                  - current normal damage (for static modifiers function will be called with value = 0.0f)
			float,                  - current ap damage (for static modifiers function will be called with value = 0.0f)
			float,                  - current heat damage (for static modifiers function will be called with value = 0.0f)
			float,                  - current stability damage (for static modifiers function will be called with value = 0.0f)
			float                   - return result type
		> modifier, 
		Func<						- delegate, function will be called when damage engine will calculate your modifier actual name to show in UI
			Weapon,                 - weapon
			Vector3,                - attack position
			ICombatant,             - target combatant
			bool,                   - is shot is breaching
			int,                    - hit location (for static modifiers function will be called with value = 0)
			float,                  - current normal damage (for static modifiers function will be called with value = 0.0f)
			float,                  - current ap damage (for static modifiers function will be called with value = 0.0f)
			float,                  - current heat damage (for static modifiers function will be called with value = 0.0f)
			float,                  - current stability damage (for static modifiers function will be called with value = 0.0f)
			string					- return result type
		> modname
	)

Note on toHit modifiers
CustAmmoCategories.ToHitModifiersHelper.registerModifier(
      string id, - modifier id. If modifier with same id already exists it will be replaced
      string name,  - name, string will be added to tooltip if dname is null
      bool ranged, - flag is modifier is ranged
      bool melee, - flag is modifier is melee
                 if both true modifier will be applied both ranged and melee if target selected
                 if both false modifier will be applied both ranged and melee if target is not selected
      Func<ToHit, 
        AbstractActor, - attacker
        Weapon, - weapon
        ICombatant, - target
        Vector3, - attack position
        Vector3, - target position
        LineOfFireLevel, - line of fire level
        MeleeAttackType, - melee attack type
        bool, - is calledShot
        float - result
        > modifier, - delegate method to calculate modifier value 
      Func<ToHit, 
        AbstractActor, - attacker
        Weapon, - weapon
        ICombatant, - target
        Vector3, - attack position
        Vector3, - target position
        LineOfFireLevel, - line of fire level
        MeleeAttackType, - melee attack type
        bool, - is calledShot
        string - result
        > dname - delegate method to calcualte modifier name, if UI name should be dynamic (if null name value will be used)
      ) 

demo code 

using BattleTech;
using System;
using System.Collections.Generic;
using System.IO;
using System.Linq;
using System.Reflection;
using System.Text;
using System.Threading;
using System.Threading.Tasks;
using UnityEngine;

namespace CACAccModDemo {
  public class Core {
    private static MethodInfo ToHitModifiersHelper_registerModifier = null;
    private static MethodInfo DamageModifiersCache_RegisterDamageModifier = null;
    public static bool CACModifierHelperDetected() { return ToHitModifiersHelper_registerModifier != null; }
    public static bool CACDamageModifierHelperDetected() { return DamageModifiersCache_RegisterDamageModifier != null; }
    public static float MyCACModifier(ToHit toHit, AbstractActor attacker, Weapon weapon, ICombatant target, Vector3 attackPos, Vector3 targetPos, LineOfFireLevel lof, MeleeAttackType meleType, bool isCalled) {
      return 1f;
    }
    public static string MyCACModifierName(ToHit toHit, AbstractActor attacker, Weapon weapon, ICombatant target, Vector3 attackPos, Vector3 targetPos, LineOfFireLevel lof, MeleeAttackType meleType, bool isCalled) {
      return "Cust. mod. "+attacker.DisplayName;
    }
    public static float MyDmgCACModifier(Weapon weapon, Vector3 attackPosition, ICombatant target, bool IsBreachingShot, int location, float dmg, float ap, float heat, float stab) {
      return 0f;
    }
    public static string MyDmgCACModifierName(Weapon weapon, Vector3 attackPosition, ICombatant target, bool IsBreachingShot, int location, float dmg, float ap, float heat, float stab) {
      return "Cust. mod. " + target.DisplayName;
    }
    public static void registerCACModifier(string id, string name, bool ranged, bool melee,
      Func<ToHit, AbstractActor, Weapon, ICombatant, Vector3, Vector3, LineOfFireLevel, MeleeAttackType, bool, float> modifier,
      Func<ToHit, AbstractActor, Weapon, ICombatant, Vector3, Vector3, LineOfFireLevel, MeleeAttackType, bool, string> dname
    ) {
      if (ToHitModifiersHelper_registerModifier == null) { return; }
      ToHitModifiersHelper_registerModifier.Invoke(null, new object[] { id, name, ranged, melee, modifier, dname });
    }
    public static void registerCACDmgModifier(string id, string staticName, bool isStatic, bool isNormal, bool isAP, bool isHeat, bool isStability,
      Func<Weapon, Vector3, ICombatant, bool, int, float, float, float, float, float> modifier,
      Func<Weapon, Vector3, ICombatant, bool, int, float, float, float, float, string> modname
    ) {
      if (DamageModifiersCache_RegisterDamageModifier == null) { return; }
      DamageModifiersCache_RegisterDamageModifier.Invoke(null, new object[] { id, staticName, isStatic, isNormal, isAP, isHeat, isStability, modifier, modname });
    }
    public static void detectCAC() {
      Assembly[] assemblies = AppDomain.CurrentDomain.GetAssemblies();
      foreach (Assembly assembly in assemblies) {
        if (assembly.FullName.StartsWith("CustomAmmoCategories")) {
          Type helperType = assembly.GetType("CustAmmoCategories.ToHitModifiersHelper");
          if (helperType != null) {
            ToHitModifiersHelper_registerModifier = helperType.GetMethod("registerModifier", BindingFlags.Static | BindingFlags.Public);
          }
          Type dmgHelperType = assembly.GetType("CustAmmoCategories.DamageModifiersCache");
          if (dmgHelperType != null) {
            DamageModifiersCache_RegisterDamageModifier = dmgHelperType.GetMethod("RegisterDamageModifier", BindingFlags.Static | BindingFlags.Public);
          }
        }
      }
    }
    public static void FinishedLoading(List<string> loadOrder) {
      detectCAC();
      registerCACModifier("MYMOD DYN NAME", "MYMOD", true, false, MyCACModifier, null);
      registerCACModifier("MYMOD", "MYMOD", true, false, MyCACModifier, MyCACModifierName);
      registerCACDmgModifier("MYMOD", "MYMOD", false, true, false, false, false, MyDmgCACModifier, MyDmgCACModifierName);
    }
    public static void Init(string directory, string settingsJson) {
    }
  }
}
     
Note for Explosion API
CustAmmoCategories.ExplosionAPIHelper.AoEExplode(
string VFX - VFX name
, Vector3 vfxScale - VFX scale
, float vfxDuration - VFX playing duration in seconds
, string SFX - sound effect
, Vector3 pos - position
, float radius - AoE radius in meters
, float damage - AoE damage
, float heat - AoE heat
, float stability - AoE stability damage
, List<EffectData> effects - list of applying effects
, bool effectsFalloff - not used
, int fireRadius - fire radius in cells
, int fireStrength - fire strength
, float fireChance - fire chance
, int fireDurationNoForest - fire duration in turns if no forest in affected hex
   (all values allied with respect to biome)
, string LongVFX - long VFX prefab
, Vector3 longVFXScale - long VFX scale
, string designMask - design mask to apply
, int dmRadius - radius in cells to apply design mask
, int turns - duration of design mask and long VFX if set
)
example
ExplosionAPIHelper.AoEExplode("WFX_Nuke", Vector3.one * 50f, 20f, "big_explosion", this.targetPosition, 100f, 2000f, 100f, 100f, new List<EffectData>(), false, 3, 40, 1f, 5, string.Empty, Vector3.zero, string.Empty, 0, 0);
CustAmmoCategories.ExplosionAPIHelper.LayMineField(MineFieldDef def, Vector3 pos)

Notes for external AI (CleverGirl):
weapon.gatherDamagePrediction(Vector3 attackPos, ICombatant target) - returns Dictionary<AmmoModePair, WeaponFirePredictedEffect>
AmmoModePair can be used in weapon.ApplyAmmoMode(AmmoModePair ammoMode) to switch weapon to this specific ammo and mode 
                                      (no checking performed, eg. you can switch to ammo/mode not available for weapon)
result will contain only valid for this weapon mode/ammo pairs with respect to mode locking subsystem and ammo boxes state and available ammo count.
                                      
public class WeaponFirePredictedEffect {
  public AmmunitionDef ammo { get; set; } 
  public ExtAmmunitionDef exAmmo { get; set; }
  public Weapon weapon { get; set; }
  public WeaponMode mode { get; set; }
  public bool isAMS { get; set; }
  public bool isAAMS { get; set; }
  public float JammChance { get; set; }
  public int Cooldown { get; set; }
  public bool DamageOnJamm { get; set; }
  public bool DestroyOnJamm { get; set; }
  public int ammoUsage { get; set; } - is literally ShotsWhenFire for this ammo/mode
  public int avaibleAmmo { get; set; } - if weapon not use ammo value will be -1. Calculated with respect to ammo boxes state and ammo count.
  public List<DamagePredictionRecord> predictDamage { get; set; } - if weapon have stray, shells stray or AoE damage this list will be filled accordingly 
}                                      

public class DamagePredictionRecord {
  public float Normal { get; set; } - normal damage
  public float AP { get; set; } - damage penetrates armor
  public float Heat { get; set; }
  public float Instability { get; set; }
                               NOTE: all damage values filled with respect to variance, attacker and target current design masks 
                               (note, design mask and sticky effects on path from current position to attack position are not predicted)
                               All damage to meant to be inflicted by one hit.
  public float HitsCount { get; set; } - Actual hits count. Can be not integer cause of stray/shells range calculation
  public bool isAoE { get; set; } - Flag for AoE damage. If damage is AoE AP is always 0. Normal, Heat, Instability - full damage with distance falloff. 
  public List<int> PossibleHitLocations { get; set; } - List of possible hit locations
  public List<EffectData> ApplyEffects { get; set; } - List of effects applied on hit
  public ICombatant Target { get; set; } 
  public float ToHit { get; set; } - To hit chance for this ammo/mode/target. Note: LoS/Range not checked, if damage is AoE ToHit always 1.0
}

NOTE! To disable internal ammo/mode choose CustomAmmoCategories.DisableInternalWeaponChoose can be set to true. It will prevent all internal AI ammo/mode alterations.

audio enums:
NOTE: I certainly don't know how they sounds like, you are welcome to try. 
usage "enum:<enum class name>.<enum value>" (example "enum:AudioEventList_ac10.ac10_auto_single")

public enum AudioEventList_ac10
{
  ac10_auto_single = 340, // 0x00000154
  ac10_auto_start = 341, // 0x00000155
  ac10_auto_stop = 342, // 0x00000156
  ac10_cannon = 343, // 0x00000157
}
public enum AudioEventList_ac2
{
  ac2_shot = 344, // 0x00000158
}
public enum AudioEventList_ac20
{
  ac20_auto_single = 345, // 0x00000159
  ac20_auto_start = 346, // 0x0000015A
  ac20_auto_stop = 347, // 0x0000015B
  ac20_cannon = 348, // 0x0000015C
}
public enum AudioEventList_ac5
{
  ac5_1stand2ndshot = 349, // 0x0000015D
  ac5_3rdshot = 350, // 0x0000015E
}
public enum AudioEventList_activeProbe
{
  activeProbe_play = 189, // 0x000000BD
  activeProbe_priming_off = 190, // 0x000000BE
  activeProbe_priming_on = 191, // 0x000000BF
  activeProbe_stop = 192, // 0x000000C0
}
public enum AudioEventList_aircraft
{
  aircraft_dropship_gencon_landing,
  aircraft_leopard_destruction,
  aircraft_leopard_landing,
  aircraft_leopard_takeoff,
  aircraft_leopard_touchAndGo,
  aircraft_union_destruction,
  aircraft_union_landing,
}
public enum AudioEventList_amb
{
  amb_steam_engineeringRoom = 24, // 0x00000018
}
public enum AudioEventList_ambiences
{
  ambiences_start = 25, // 0x00000019
  ambiences_stop = 26, // 0x0000001A
}
public enum AudioEventList_breakable
{
  breakable_building_damage = 289, // 0x00000121
  breakable_concrete = 290, // 0x00000122
  breakable_concrete_barrier = 291, // 0x00000123
  breakable_concrete_large = 292, // 0x00000124
  breakable_concrete_medium = 293, // 0x00000125
  breakable_concrete_small = 294, // 0x00000126
  breakable_dumpster = 295, // 0x00000127
  breakable_fence = 296, // 0x00000128
  breakable_fence_large = 297, // 0x00000129
  breakable_fence_medium = 298, // 0x0000012A
  breakable_fence_small = 299, // 0x0000012B
  breakable_glass = 300, // 0x0000012C
  breakable_lightpole = 301, // 0x0000012D
  breakable_metal = 302, // 0x0000012E
  breakable_metal_large = 303, // 0x0000012F
  breakable_metal_medium = 304, // 0x00000130
  breakable_metal_small = 305, // 0x00000131
  breakable_radio_tower = 306, // 0x00000132
  breakable_vehicle = 307, // 0x00000133
  breakable_vehicle_fiery = 308, // 0x00000134
}
public enum AudioEventList_collapse
{
  collapse_large = 309, // 0x00000135
  collapse_large_fiery = 310, // 0x00000136
  collapse_large_fiery_tall = 311, // 0x00000137
  collapse_medium = 312, // 0x00000138
  collapse_medium_fiery = 313, // 0x00000139
  collapse_short = 314, // 0x0000013A
  collapse_short_fiery = 315, // 0x0000013B
  collapse_tiny = 316, // 0x0000013C
  collapse_tiny_fiery = 317, // 0x0000013D
}
public enum AudioEventList_crab
{
  crab_close_impact = 113, // 0x00000071
  crab_close_move = 114, // 0x00000072
  crab_opentoattack = 115, // 0x00000073
  crab_opentoready = 116, // 0x00000074
}
public enum AudioEventList_docking
{
  docking_dock = 27, // 0x0000001B
  docking_release = 28, // 0x0000001C
}
public enum AudioEventList_ducking
{
  ducking_on_melee = 117, // 0x00000075
}
public enum AudioEventList_ecm
{
  ecm_enter = 318, // 0x0000013E
  ecm_exit = 319, // 0x0000013F
}
public enum AudioEventList_eject
{
  eject_launch = 118, // 0x00000076
  eject_projectile = 119, // 0x00000077
}
public enum AudioEventList_environment
{
  environment_beacon_loop_play = 70, // 0x00000046
  environment_beacon_loop_stop = 71, // 0x00000047
  environment_beacon_pulse = 72, // 0x00000048
  environment_dustdevils_loop_start = 73, // 0x00000049
  environment_dustdevils_loop_stop = 74, // 0x0000004A
}
public enum AudioEventList_explosion
{
  explosion_coolant = 320, // 0x00000140
  explosion_electrical = 321, // 0x00000141
  explosion_large = 322, // 0x00000142
  explosion_medium = 323, // 0x00000143
  explosion_propane_tank = 324, // 0x00000144
  explosion_small = 325, // 0x00000145
}
public enum AudioEventList_fire
{
  fire_large_180seconds = 326, // 0x00000146
  fire_large_start = 327, // 0x00000147
  fire_large_stop = 328, // 0x00000148
  fire_medium_180seconds = 329, // 0x00000149
  fire_medium_start = 330, // 0x0000014A
  fire_medium_stop = 331, // 0x0000014B
  fire_small_180seconds = 332, // 0x0000014C
  fire_small_start = 333, // 0x0000014D
  fire_small_stop = 334, // 0x0000014E
}
public enum AudioEventList_flamer
{
  flamer_start = 351, // 0x0000015F
  flamer_stop = 352, // 0x00000160
}
public enum AudioEventList_foley
{
  foley_long = 120, // 0x00000078
  foley_medium = 121, // 0x00000079
  foley_short = 122, // 0x0000007A
}
public enum AudioEventList_gauss
{
  gauss_chargeup = 353, // 0x00000161
  gauss_shoot = 354, // 0x00000162
}
public enum AudioEventList_hatchet
{
  hatchet_latch = 123, // 0x0000007B
  hatchet_move = 124, // 0x0000007C
  hatchet_slide = 125, // 0x0000007D
  hatchet_sparks = 126, // 0x0000007E
}
public enum AudioEventList_impact
{
  impact_weapon = 335, // 0x0000014F
}
public enum AudioEventList_jump
{
  jump_end = 29, // 0x0000001D
  jump_start = 30, // 0x0000001E
}
public enum AudioEventList_laser
{
  laser_beam_stop_large = 355, // 0x00000163
  laser_beam_stop_medium = 356, // 0x00000164
  laser_beam_stop_small = 357, // 0x00000165
  laser_large = 358, // 0x00000166
  laser_medium = 359, // 0x00000167
  laser_small = 360, // 0x00000168
}
public enum AudioEventList_lrm
{
  lrm_launcher_end = 361, // 0x00000169
  lrm_launcher_start = 362, // 0x0000016A
  lrm_missile_launch = 363, // 0x0000016B
  lrm_missile_launch_last = 364, // 0x0000016C
  lrm_projectile_start = 365, // 0x0000016D
  lrm_projectile_stop = 366, // 0x0000016E
}
public enum AudioEventList_machine
{
  machine_gun_start = 367, // 0x0000016F
  machine_gun_stop = 368, // 0x00000170
}
public enum AudioEventList_mech
{
  mech_bodyfall = 127, // 0x0000007F
  mech_bodyfall_heavy = 128, // 0x00000080
  mech_bodyfall_light = 129, // 0x00000081
  mech_bodyfall_medium = 130, // 0x00000082
  mech_cockpit_explosion = 131, // 0x00000083
  mech_coolant_vent = 132, // 0x00000084
  mech_damage_burning_electrical_start = 133, // 0x00000085
  mech_damage_burning_electrical_stop = 134, // 0x00000086
  mech_damage_burning_sparks_start = 135, // 0x00000087
  mech_damage_burning_sparks_stop = 136, // 0x00000088
  mech_damage_bursts_sparks = 137, // 0x00000089
  mech_destruction_a = 138, // 0x0000008A
  mech_destruction_b = 139, // 0x0000008B
  mech_destruction_c = 140, // 0x0000008C
  mech_engine_damaged_badly = 141, // 0x0000008D
  mech_engine_damaged_mildly = 142, // 0x0000008E
  mech_engine_powerdown = 143, // 0x0000008F
  mech_engine_powerdown_death = 144, // 0x00000090
  mech_engine_powerup = 145, // 0x00000091
  mech_engine_start = 146, // 0x00000092
  mech_engine_stop = 147, // 0x00000093
  mech_fire_large = 148, // 0x00000094
  mech_fire_medium = 149, // 0x00000095
  mech_fire_small = 150, // 0x00000096
  mech_fire_small_internal = 151, // 0x00000097
  mech_fire_stop = 152, // 0x00000098
  mech_footstep = 153, // 0x00000099
  mech_footstep_idle = 154, // 0x0000009A
  mech_impact01 = 155, // 0x0000009B
  mech_impact02 = 156, // 0x0000009C
  mech_impact03 = 157, // 0x0000009D
  mech_impact04 = 158, // 0x0000009E
  mech_jumpjets_heavy_start = 159, // 0x0000009F
  mech_jumpjets_heavy_stop = 160, // 0x000000A0
  mech_jumpjets_light_start = 161, // 0x000000A1
  mech_jumpjets_light_stop = 162, // 0x000000A2
  mech_jumpland = 163, // 0x000000A3
  mech_metal_squeal = 164, // 0x000000A4
  mech_part_break_a = 165, // 0x000000A5
  mech_part_break_b = 166, // 0x000000A6
  mech_part_break_c = 167, // 0x000000A7
  mech_surface_strike = 168, // 0x000000A8
  mech_water_enter = 169, // 0x000000A9
  mech_water_exit = 170, // 0x000000AA
}
public enum AudioEventList_motor
{
  motor_buzzy_start = 171, // 0x000000AB
  motor_buzzy_stop = 172, // 0x000000AC
  motor_clicky_start = 173, // 0x000000AD
  motor_clicky_stop = 174, // 0x000000AE
  motor_sawserver_start = 175, // 0x000000AF
  motor_sawserver_stop = 176, // 0x000000B0
}
public enum AudioEventList_move
{
  move_mechanical = 177, // 0x000000B1
  move_mechanical_short = 178, // 0x000000B2
}
public enum AudioEventList_MU
{
  MU_Play_GameplayMusic = 185, // 0x000000B9
  MU_Play_MenuMusic = 186, // 0x000000BA
  MU_Stop_AllAudioExceptMusic = 187, // 0x000000BB
  MU_Stop_GameplayMusic = 188, // 0x000000BC
}
public enum AudioEventList_on
{
  on_ground_impact_hit = 179, // 0x000000B3
  on_ground_impact_miss = 180, // 0x000000B4
  on_melee_impact = 181, // 0x000000B5
}
public enum AudioEventList_play
{
  play_distant_battle_m010 = 75, // 0x0000004B
  play_fan = 76, // 0x0000004C
  play_generator = 77, // 0x0000004D
  play_laser_mining_machine = 78, // 0x0000004E
  play_mission060_klaxon = 79, // 0x0000004F
  play_orbital_gun = 80, // 0x00000050
  play_rubble_electrical = 81, // 0x00000051
  play_spores = 82, // 0x00000052
  play_urban_fan = 83, // 0x00000053
  play_urban_fountain_large = 84, // 0x00000054
  play_urban_fountain_medium = 85, // 0x00000055
  play_urban_fountain_small = 86, // 0x00000056
  play_urban_generator_coolant = 87, // 0x00000057
  play_urban_generator_electrical = 88, // 0x00000058
  play_urban_holograms = 89, // 0x00000059
  play_water_skirt_vent = 90, // 0x0000005A
  play_waterfall_short_narrow = 91, // 0x0000005B
  play_waterfall_short_wide = 92, // 0x0000005C
  play_waterfall_tall_narrow = 93, // 0x0000005D
  play_waterfall_tall_wide = 94, // 0x0000005E
  play_artillery_impact = 95, // 0x0000005F
  play_artillery_projectile = 96, // 0x00000060
  play_dropPod_impact = 97, // 0x00000061
  play_dropPod_projectile = 98, // 0x00000062
  play_orbital_ppc = 99, // 0x00000063
}
public enum AudioEventList_ppc
{
  ppc_shoot = 369, // 0x00000171
}
public enum AudioEventList_pulse
{
  pulse_lrg_chargeup = 370, // 0x00000172
  pulse_lrg_shoot = 371, // 0x00000173
  pulse_med_chargeup = 372, // 0x00000174
  pulse_med_shoot = 373, // 0x00000175
  pulse_sml_chargeup = 374, // 0x00000176
  pulse_sml_shoot = 375, // 0x00000177
}
public enum AudioEventList_radio
{
  radio_end = 46, // 0x0000002E
  radio_test01 = 47, // 0x0000002F
  radio_test02 = 48, // 0x00000030
  radio_test03 = 49, // 0x00000031
}
public enum AudioEventList_small
{
  small_building_collapse_large = 336, // 0x00000150
  small_building_collapse_med = 337, // 0x00000151
  small_building_collapse_small = 338, // 0x00000152
  small_building_collapse_tiny = 339, // 0x00000153
}
public enum AudioEventList_srm
{
  srm_launcher_end = 376, // 0x00000178
  srm_launcher_start = 377, // 0x00000179
  srm_missile_launch = 378, // 0x0000017A
  srm_missile_launch_last = 379, // 0x0000017B
  srm_projectile_start = 380, // 0x0000017C
  srm_projectile_stop = 381, // 0x0000017D
}
public enum AudioEventList_stop
{
  stop_distant_battle_m010 = 100, // 0x00000064
  stop_fan = 101, // 0x00000065
  stop_generator = 102, // 0x00000066
  stop_laser_mining_machine = 103, // 0x00000067
  stop_rubble_electrical = 104, // 0x00000068
  stop_urban_fan = 105, // 0x00000069
  stop_urban_fountain_large = 106, // 0x0000006A
  stop_urban_fountain_medium = 107, // 0x0000006B
  stop_urban_fountain_small = 108, // 0x0000006C
  stop_urban_generator_coolant = 109, // 0x0000006D
  stop_urban_generator_electrical = 110, // 0x0000006E
  stop_urban_holograms = 111, // 0x0000006F
  stop_water_skirt_vent = 112, // 0x00000070
}
public enum AudioEventList_torso
{
  torso_rotate_interrupted = 182, // 0x000000B6
  torso_rotate_start = 183, // 0x000000B7
  torso_rotate_stop = 184, // 0x000000B8
}
public enum AudioEventList_ui
{
  ui_action_generic = 193, // 0x000000C1
  ui_action_gunnery = 194, // 0x000000C2
  ui_action_guts = 195, // 0x000000C3
  ui_action_jump = 196, // 0x000000C4
  ui_action_notavailable = 197, // 0x000000C5
  ui_action_observation = 198, // 0x000000C6
  ui_action_piloting = 199, // 0x000000C7
  ui_action_sprint = 200, // 0x000000C8
  ui_callout_inspired_buff = 201, // 0x000000C9
  ui_callout_toast = 202, // 0x000000CA
  ui_ecm_buff_down = 203, // 0x000000CB
  ui_ecm_buff_up = 204, // 0x000000CC
  ui_ecm_start = 205, // 0x000000CD
  ui_ecm_stop = 206, // 0x000000CE
  ui_esc_menu_hover = 207, // 0x000000CF
  ui_esc_menu_in = 208, // 0x000000D0
  ui_esc_menu_out = 209, // 0x000000D1
  ui_esc_menu_select = 210, // 0x000000D2
  ui_generic_confirm = 211, // 0x000000D3
  ui_generic_hover = 212, // 0x000000D4
  ui_mech_action_choose_yes = 213, // 0x000000D5
  ui_mech_action_hover = 214, // 0x000000D6
  ui_mech_choose_hover = 215, // 0x000000D7
  ui_mech_choose_off = 216, // 0x000000D8
  ui_mech_choose_on = 217, // 0x000000D9
  ui_mech_move = 218, // 0x000000DA
  ui_mech_move_path = 219, // 0x000000DB
  ui_mech_move_path_confirm = 220, // 0x000000DC
  ui_mech_move_rotate_start = 221, // 0x000000DD
  ui_mech_move_rotate_stop = 222, // 0x000000DE
  ui_mech_restart = 223, // 0x000000DF
  ui_mission_done = 224, // 0x000000E0
  ui_mission_fail = 225, // 0x000000E1
  ui_mission_popup_off = 226, // 0x000000E2
  ui_mission_popup_on = 227, // 0x000000E3
  ui_mission_withdraw = 228, // 0x000000E4
  ui_mp_chat_alert = 229, // 0x000000E5
  ui_mp_go_to_mech_select = 230, // 0x000000E6
  ui_mp_menu_hover = 231, // 0x000000E7
  ui_mp_select_go = 232, // 0x000000E8
  ui_mp_select_mech_value_ok = 233, // 0x000000E9
  ui_mp_select_mech_value_over = 234, // 0x000000EA
  ui_objective_add = 235, // 0x000000EB
  ui_objective_done = 236, // 0x000000EC
  ui_objective_fail = 237, // 0x000000ED
  ui_overheat_alarm_1 = 238, // 0x000000EE
  ui_overheat_alarm_2 = 239, // 0x000000EF
  ui_overheat_alarm_3 = 240, // 0x000000F0
  ui_overheat_imminent = 241, // 0x000000F1
  ui_overheat_shutdown_imminent = 242, // 0x000000F2
  ui_panels_down = 243, // 0x000000F3
  ui_panels_up = 244, // 0x000000F4
  ui_phase_1 = 245, // 0x000000F5
  ui_phase_turn_me = 246, // 0x000000F6
  ui_phase_turn_you = 247, // 0x000000F7
  ui_radar_blip_detected = 248, // 0x000000F8
  ui_radar_blip_moving = 249, // 0x000000F9
  ui_salvage_received = 250, // 0x000000FA
  ui_settings_menu_check = 251, // 0x000000FB
  ui_settings_menu_uncheck = 252, // 0x000000FC
  ui_sim_back = 253, // 0x000000FD
  ui_sim_event_popup = 254, // 0x000000FE
  ui_sim_menu_appear = 255, // 0x000000FF
  ui_sim_menu_hover = 256, // 0x00000100
  ui_sim_menu_select = 257, // 0x00000101
  ui_sim_object_hover = 258, // 0x00000102
  ui_sim_object_select = 259, // 0x00000103
  ui_sim_pilot_pic_appear = 260, // 0x00000104
  ui_sim_platform_start = 261, // 0x00000105
  ui_sim_platform_stop = 262, // 0x00000106
  ui_sim_popup_newChassis = 263, // 0x00000107
  ui_sim_rewardbox1 = 264, // 0x00000108
  ui_sim_rewardbox2 = 265, // 0x00000109
  ui_sim_submenu_appear = 266, // 0x0000010A
  ui_sim_submenu_hover = 267, // 0x0000010B
  ui_sim_travel_loop_play = 268, // 0x0000010C
  ui_sim_travel_loop_stop = 269, // 0x0000010D
  ui_sim_travel_ping_play = 270, // 0x0000010E
  ui_sim_whoosh_room_change = 271, // 0x0000010F
  ui_sim_whoosh_zoom = 272, // 0x00000110
  ui_target_cycling = 273, // 0x00000111
  ui_target_lock_bracket = 274, // 0x00000112
  ui_target_lock_bracket_last = 275, // 0x00000113
  ui_target_lock_hard = 276, // 0x00000114
  ui_target_lock_soft = 277, // 0x00000115
  ui_target_rotate_start = 278, // 0x00000116
  ui_target_rotate_stop = 279, // 0x00000117
  ui_target_sensor_lock_hard = 280, // 0x00000118
  ui_target_sensor_lock_soft = 281, // 0x00000119
  ui_target_sensor_lock_soft_off = 282, // 0x0000011A
  ui_target_sensor_sweep_start = 283, // 0x0000011B
  ui_target_sensor_sweep_stop = 284, // 0x0000011C
  ui_weapon_choose_yes = 285, // 0x0000011D
  ui_weapon_destroyed = 286, // 0x0000011E
  ui_weapon_disabled = 287, // 0x0000011F
  ui_weapon_hover = 288, // 0x00000120
}
public enum AudioEventList_vehicle
{
  vehicle_explosion_a = 7,
  vehicle_explosion_b = 8,
  vehicle_gallant_engine_start = 9,
  vehicle_gallant_engine_stop = 10, // 0x0000000A
  vehicle_gallant_start = 11, // 0x0000000B
  vehicle_gallant_stop = 12, // 0x0000000C
  vehicle_striker_engine_start = 13, // 0x0000000D
  vehicle_striker_engine_stop = 14, // 0x0000000E
  vehicle_striker_start = 15, // 0x0000000F
  vehicle_striker_stop = 16, // 0x00000010
  vehicle_tank_engine_start = 17, // 0x00000011
  vehicle_tank_engine_stop = 18, // 0x00000012
  vehicle_tank_start = 19, // 0x00000013
  vehicle_tank_stop = 20, // 0x00000014
  vehicle_turret_interrupted = 21, // 0x00000015
  vehicle_turret_start = 22, // 0x00000016
  vehicle_turret_stop = 23, // 0x00000017
}
public enum AudioEventList_vo
{
  vo_play_argo_ambient = 50, // 0x00000032
  vo_play_argo_group = 51, // 0x00000033
  vo_play_argo_simgame = 52, // 0x00000034
  vo_play_computer_ai = 53, // 0x00000035
  vo_play_missions = 54, // 0x00000036
  vo_play_pilot_player_character = 55, // 0x00000037
  vo_play_pilots = 56, // 0x00000038
  vo_play_procedural_mission = 57, // 0x00000039
  vo_play_restoration_mission = 58, // 0x0000003A
  vo_static_start_mission = 59, // 0x0000003B
  vo_static_start_pilot = 60, // 0x0000003C
  vo_static_stop_mission = 61, // 0x0000003D
  vo_static_stop_pilot = 62, // 0x0000003E
  vo_stop_argo_ambient = 63, // 0x0000003F
  vo_stop_argo_group = 64, // 0x00000040
  vo_stop_argo_simgame = 65, // 0x00000041
  vo_stop_missions = 66, // 0x00000042
  vo_stop_pilots = 67, // 0x00000043
  vo_stop_procedural_mission = 68, // 0x00000044
  vo_stop_restoration_mission = 69, // 0x00000045
}
public enum AudioEventList_whoosh
{
  whoosh_argo_large = 31, // 0x0000001F
  whoosh_argo_medium = 32, // 0x00000020
  whoosh_argo_short = 33, // 0x00000021
  whoosh_leopard_large = 34, // 0x00000022
  whoosh_leopard_medium = 35, // 0x00000023
  whoosh_leopard_small = 36, // 0x00000024
  whoosh_long_hi = 37, // 0x00000025
  whoosh_long_lo = 38, // 0x00000026
  whoosh_long_mix = 39, // 0x00000027
  whoosh_medium_hi = 40, // 0x00000028
  whoosh_medium_lo = 41, // 0x00000029
  whoosh_medium_mix = 42, // 0x0000002A
  whoosh_short_hi = 43, // 0x0000002B
  whoosh_short_lo = 44, // 0x0000002C
  whoosh_short_mix = 45, // 0x0000002D
}



overriden methods

