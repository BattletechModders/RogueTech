<pre>
Unpack to Mods folder
CustomAmmoCategories settings 
CustomAmmoCategoriesSettings.json
WeaponRealizer settings
WeaponRealizerSettings.json (for description look at the WR-README)
AttackImprovementMod settings
AIM_settings.json (for description look at the AIM-README)

WARNING! Shipped versions of AIM and WR can't be loaded by ModTek and can't be used standalone.

click on right side of HUD weapon slot to switch mode (near hit chance)
click on center of HUD weapon slot to switch ammo (near ammo count)
ctrl+left click on weapon slot will eject current ammo 
   NOTE: ammo can't be ejected if mech moved this round
         after ejection mech can't jump and sprint until end of round

{
"debugLog":true, - enable debug log 
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
"BurningForestCellRadius":3, - size of hex cell in grid used for terrain effects supported values 3,4 (you should not change this until you know what doing)
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
}

now CustomAmmoCategories.dll searching CustomAmmoCategories.json in every subfolder of Mods folder. 
CustomAmmoCategories.json
[
{
	"Id":"LGAUSS", - new ammo category name, precessed for WeaponDef.AmmoCategory and AmmunitionDef.Category fields, using it in other AmmoCategory field will lead load error
	"BaseCategory":"GAUSS" - base category name. Must bt in (AC2/AC5/AC10/AC20/GAUSS/Flamer/AMS/MG/SRM/LRM), 
	                         needed for backward compatibility. 
							 All other game mechanic (for example status effect targeting), except ammo count in battle and mech validator in mech lab will use this value.
							 !Flamer - is base category for energy ammo (plasma, chemical lasers etc)
},
]

Weapon definition
new fields
  "Streak": true/false - if true only success hits will be shown, ammo decremental and heat generation will be based on success hits. 
							with "HitGenerator" : "Streak" - will be true streak effect all-hit-or-no-fire
  "HitGenerator" : "Streak", Set to hit generator. Supported values ("Individual"/"Cluster"/"Streak"). 
                                  Streak hit generator is sort of cluster, 
								  if first projectile hit, rest hit too (location distribution as cluster hit generator),
								  if first projectile misses, rest misses too
								  if not set weapon hit generator will be used.
								  if not set hit generator will be choosed by weapon type.
								  if weapon define has tag "wr-clustered_shots", "Cluster" hit generator will be forced. 
  "DirectFireModifier" : -10.0, Accuracy modifier if weapon can strike directly
  "DamageOnJamming": true/false, - if true on jamm weapon will be damaged
  "FlatJammingChance": 1.0, - Chance of jamming weapon after fire. 1.0 is jamm always. Unjamming logic implemented as in WeaponRealizer
  "GunneryJammingBase": 5, - 
  "GunneryJammingMult": 0.05, - this values uses to alter flat jamming chance by pilot skills 
                                  formula effective jamming chance = FlatJammingChance + (GunneryJammingBase - Pilot Gunnery)* GunneryJammingMult
								  if FlatJammingChance = 1.0, GunneryJammingBase = 6, GunneryJammingMult = 0.1, GunnerySkill = 10
								  result = 1.0 + (6-10)*0.1 = 0.6
								  GunneryJammingBase if ommited in weapon def., ammo def. and mode def. assumed as 5. 
  "DisableClustering": true/false - if true ProjectilesPerShot > 1 will affect only visual nor damage. If omitted consider as true.
  "NotUseInMelee": true, - if true even AntiPersonel weapon type will not fire on melee attack, AI aware. 
  "AlternateDamageCalc": false, - if true alternate damage calc formula will be implemented 
                              DamagePerShot = (damage from weaponDef + (damage from ammo) + (damage from mode)*(damage multiplayer from ammo)*(damage multiplayer from mode)*(damage with effects)/(damage from weaponDef)
  "AlternateHeatDamageCalc": false, - same as  AlternateDamageCalc but for heat 
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
  "AMSImmune": false - if true, weapon missiles is immune to AMS and none AMS will try to intercept them.
  "AOECapable" : false, - if true weapon will included in AOE damage calculations. If true set in weapon definition 
                            all shoots will have AoE effect (even for energy weapon). If true, it can't be overridden by ammo.
  "AOERange": 100, - Area of effect range. If AOECapable in weapon is set to true this value will be used. If AOECapable is true, it can't be overridden by ammo.
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
								   There is special transponder name "_IFFOffile" - if transponder defId set as IFFOffline it counts as have no transponder at all.
  "HasShells": true/false, if defined determinate has shots shrapnel effect or not. If defined can't be overriden by ammo or mode. 
                            Shells count is effective ProjectilesPerShot for this weapon/ammo/mode.
                            Damage per shell - full damage per projectile / ProjectilesPerShot
                            Only for missiles, ballistic and gauss effects. Should not be used with AoE.
							NOTE! If ImprovedBallistic is false HasShells considered as false too no matter real value. 
  "ShellsRadius": 90, determines if shells will have spreading. Works same way as SpreadRange. Per weapon value will be used if HasShells is true for this weapon.
  "MinShellsDistance": 30, Minimum distance missile have to fly before explode. Min value 30.
  "MaxShellsDistance": 100, Distance from end of trajectory where missile should separate. Min value 20
                             Note: example - trajectory length 200, min 80, max 100 - missile will separate 100m from end.
							       example 2 trajectory length 100, min 80, max 100 - missile will separate 20m from end cause it have to fly 80m until separation. 
								   example 3 trajectory length 100 min 120, max 200 - missile will not separate at all. 
  "Unguided": false, for missiles effect only. If true missile trajectory will be strait line instead of curvy. Like it is unguided as old WW2 rockets. 
					True value tied IndirectCapablea and AlwaysIndirectVisuals to false. 
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
   "ImprovedBallistic": true, - whether use or not own ballistic weapon effect engine. 
								Difference between "improved" and vanilla engine:
								1. Improved mode uses ShotsWhenFire properly (vanilla had not used them at all)
								2. Improved mode can use curvy trajectory for indirect fire (indirect gauss bullet can be used too, but looks very funny)
								3. Improved mode fire ShotsWhenFire volleys with ProjectilesPerShot bullets in each. 
								   Bullets in one volley fired simultaneously instead of one by one (as in WeaponRealizer)
								   But damage still dealt once per volley, not per bullet, to keep compatibility with vanilla.
								NOTE! If ImprovedBallistic is set DisableClustering is forced to true and "wr-clustered_shots" tag removed from definition. 
  "BallisticDamagePerPallet": true - if true damage inflicted per pallet instead of per shot. Only working with ImprovedBallistic true, ballistic weapon effect and HasShels false
                                     Damage will be divided by ProjectilesPerShot value, heat damage and stable damage too. 
   "Modes": array of modes for weapon
	[{
		"Id": "x4",  - Must be unique per weapon
		"UIName": "x4", - This string will be displayed near weapon name
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
		"MiddleRange": 0.0, This value will be added to MiddleRange (current weapon status effects will be used too)
		"LongRange": 0.0, This value will be added to LongRange (current weapon status effects will be used too)
			 NOTE: Range modifications not always displays correctly while viewing shooting arc, but hit chance and possibility calculated normally. 
		"ForbiddenRange": 90, - weapon can't fire at all if range to target is less than this value
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
	    "GunneryJammingBase": 5, - 
	    "GunneryJammingMult": 0.05, - this values uses to alter flat jamming chance by pilot skills 
									  formula effective jamming chance = FlatJammingChance + (GunneryJammingBase - Pilot Gunnery)* GunneryJammingMult
									  if FlatJammingChance = 1.0, GunneryJammingBase = 6, GunneryJammingMult = 0.1, GunnerySkill = 10
									  result = 1.0 + (6-10)*0.1 = 0.6
								      GunneryJammingBase if omitted in weapon def., ammo def. and mode def. assumed as 5. 
		"DamageVariance": 20, - Simple damage variance as implemented in WeaponRealizer
		"DistantVariance": 0.3, - Distance damage variance as implemented in WeaponRealizer
		"DistantVarianceReversed": false, - Set is distance damage variance is reversed
		"Cooldown": 2, - number of rounds weapon will be unacceptable after fire this mode
		"AIHitChanceCap": 0.3, - not used any more
		"DamageOnJamming": true/false, - if true on jamming weapon will be damaged
		"DamageMultiplier":2.0, - damage multiplier for this mode effective value will be Weapon.DamagePerShot*Ammo.DamageMultiplier*Mode.DamageMultiplier rounded
									to nearest integer. If omitted assumed to be 1.0. HeatDamagePerShot affected too. 
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
						True value tied IndirectCapablea and AlwaysIndirectVisuals to false
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
	}]
  
  
Ammo definition
{
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
   "EvasivePipsIgnored" : 0, This value will be added to EvasivePipsIgnored (current weapon status effects will be used too)
   
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
   "MiddleRange": 0.0, This value will be added to MiddleRange (current weapon status effects will be used too)
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
   "DistantVariance": 0.3, - Distance damage variance as implemented in WeaponRealizer
   "DistantVarianceReversed": false - Set is distance damage variance is reversed
   "DamageMultiplier":0.1667, - damage multiplier for this mode effective value will be Weapon.DamagePerShot*Ammo.DamageMultiplier*Mode.DamageMultiplier rounded
								to nearest integer. If omitted assumed to be 1.0.
								I can't use existing "ArmorDamageModifier" and "ISDamageModifier" cause 
								  1) it is unknown what damage must be displayed in HUD
								  2) it is difficult separate damage at place of impact 
   "AMSHitChance": 0.0, - if this weapon is AMS, this value is AMS efficiency, 
                         if this weapon is missile launcher this value shows how difficult to intercept missile with AMS. Negative value - is harder, 
						 positive is easer.
   "AlwaysIndirectVisuals": false, if true missiles will always plays indirect visuals, even if direct line of sight exists
   "HeatGeneratedModifier" : 1,
   "ArmorDamageModifier" : 1,
   "ISDamageModifier" : 1,
   "CriticalDamageModifier" : 1,
   "AOECapable" : false, - if true shoots will be included in AOE damage calculations 
   "AOERange": 100, - Area of effect range
                   Notes: AOECapable will force AlwaysIndirectVisuals to true. 
				             So it is good idea to use only missile weapon effects unless i've implement indirect visuals for ballistic effect.
				          AOE projectiles always miss no matter toHit values, this is cause AOE dealt only AOE damage.
						     So it is good idea to set -10 for AccuracyModifier to help AI understand fact that AoE weapon always inflicts damage.
						  AOE shots can inflict heat damage. It value based on weapon heat damage per shot and decreasing linear by distance between target and impact base point.
						  Projectiles intercepted by AMS will not cause AOE damage.
						  AOE to hit effect will be implemented to all targets in AoE range. 
						  On fire weapon effects will be implemented to real target only
						  Base point of AoE range calculations will be point where first projectile,
						            (if weapon have ShotsWhenFired > 1) not intercepted by AMS, hits ground.
						  It is recommended to use LRM5, LRM10, LRM15 or LRM20 as weapon subtype cause other subtypes have too huge spread when misses
						  It is good idea to set ForbiddenRage for AoE weapon and set NotUseInMelee to true
						  AOE weapon can't hit mech head, cause every headshot inflicts pilot injury. With fact AoE always dealt damage it will be imbalance. 
						  Damage variations for AoE weapon should not be used cause it will lead completely wrong result 
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
	               True value tied IndirectCapablea and AlwaysIndirectVisuals to false
					logic: if ammo unguided is true - launch will be unguided no matter mode and weapon settings, 
					if ammo unguided is false or not set i'm looking at mode. if mode unguided is true launch will be unguided, 
					if mode unguided is false or not set i'm looking at weapon. 
					if weapon unguided is true launch will be unguided if not set or false launch will be guided
   "MineFieldRadius": 3, - Radius of minefield in in-game cells (one cell have 4x4 size)
   "MineFieldCount": 1, - Count of mines in one cell
   "MineFieldHeat": 4, - Heat damage from one mine explosion
   "MineFieldHitChance": 0.12, - Chance of mine explosion when actor steps to cell
   "MineFieldDamage": 4, - normal damage from one mine explosion
                      Notes: each projectile hited ground creates mine field. Projectile hits target inflicts normal damage and not creating minefield.
					         On ground impact for each projectile affected cell is calculated base on MineFieldRadius.
							 For radius 3 it will looks approximately like this(X it is cell where projectile hits ground)
                               #####
                              #######
                             #########
                             ####X####
                             #########
                              #######
                               #####
						     For each affected cell added record for mine field. This record contains info: MineFieldCount, MineFieldHitChance, MineFieldDamage, MineFieldHeat.
							 Cell can have unlimited mine fields records count (as long as there is enough memory, but cause each record uses very little amount of memory maximum count is about billions and literally unreachable).
							 On end on each move(or sprint) sequence list of cells actor visited is gathered.  
							 For each cell actor visited for each mine field record in these cells check is performed.
							 If count of mines in record grater than zero performed roll on MineFieldHitChance. If roll success mine counter in this record decremented, 
							 heat and damage incremented by MineFieldHeat and MineFieldDamage accordingly.
							 after all mine fields in path itterated damage and heat implemented to actor. If damage is lethal score added to owner of last minefield inflicted damage.
							 For meches damage splited between two legs and heat implemented as heat. Heat applied at end of activation. 
							 For vehicle damage splited between four locations (front,back,left,right) heat impemented as normal damage
   						     Damage inflicted that way are not cause critical damage to internal components only armor and structure.
	  					     Minefields not saved on battle save/reload.
							 Note on melee through mine field: if mech while moving to melee targets suffer normal damage attack will be interrupted. 
							 Mech get close to target but nor attack animation played nor melee damage inflicted.
							 Note on DFA attack on target standing on mine field: damage will be inflicted normaly AFTER DFA attack completes 
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


overriden methods

!!!BattleTech.AttackDirector.AttackSequence.GenerateHitInfo
	Prefix
Implement HitGenerator choosing. Original method completely rewritten and never invoking. 

!!!BattleTech.AttackDirector.AttackSequence.OnAttackSequenceResolveDamage:
	Prefix
add per ammo modification to applying status effects. Original method completely rewritten and never invoking

!!!BattleTech.Weapon.DecrementAmmo:
	Prefix
method completely rewritten to make weapon use only selected ammo and implement streak ammo decremental (decrement only success hits)
	
!!!BattleTech.AbstractActor.CalcAndSetAlphaStrikesRemaining:
	Prefix:
Method completely rewritten to make AI calc remaining alpha strikes correctly base on real weapon ammo category. Original method never invoking
	
!!!BattleTech.Weapon.SetAmmoBoxes
	Prefix
Method completely rewritten to make weapon use right ammo. Original method never invoking.

!!!BattleTech.Weapon.CurrentAmmo
	Prefix
Method completely rewritten to make weapon use right ammo. Original method never invoking.

!!!BattleTech.MechValidationRules.ValidateMechHasAppropriateAmmo:
	Prefix
Method completely rewritten to make mechlab validator functioning correctly.

!!!BattleTech.WeaponRepresentation.PlayWeaponEffect:
	Prefix
Method completely rewritten to play correct effect for each ammo. Original method never invoking.
	
!!!WeaponEffect.PlayProjectile:
	Prefix
Method completely rewritten to make correct AttackRecoil. Original method never invoking.

!BattleTech.ToHit.GetEvasivePipsModifier
	Prefix
add per ammo modification. If modification is done original method not invoked.

!BattleTech.WeaponDef.FromJSON
	Prefix
method make some modification on json. Original method always invoking.

!BattleTech.AmmunitionDef.FromJSON
	Prefix
method make some modification on json. Original method always invoking.

!BattleTech.UI.CombatHUDWeaponSlot.OnPointerDown
	Prefix
add trigger to ammo cycling. If click detected on right side of weapon slot original method not invoking.

!BattleTech.UI.CombatHUDWeaponSlot.OnPointerUp
	Prefix
add trigger to ammo cycling. If click detected on right side of weapon slot original method not invoking.

!BattleTech.UI.CombatHUDWeaponSlot.RefreshHighlighted
	Prefix
add check on DisplayWeapon == null if so original method not invoking.

BattleTech.Weapon.DamagePerShot getter
	Postfix
add per ammo/mode modification

BattleTech.Weapon.HeatDamagePerShot getter
	Postfix
add per ammo/mode modification

BattleTech.Weapon.get_ShotsWhenFired
	Postfix
add per ammo/mode modification

BattleTech.Weapon.get_ProjectilesPerShot:
	Postfix
add per ammo/mode modification

BattleTech.Weapon.get_CriticalChanceMultiplier:
	Postfix
add per ammo/mode modification

BattleTech.Weapon.get_AccuracyModifier:
	Postfix
add per ammo/mode modification

BattleTech.Weapon.get_MinRange:
	Postfix
add per ammo/mode modification

BattleTech.Weapon.get_MaxRange:
	Postfix
add per ammo/mode modification

BattleTech.Weapon.get_ShortRange:
	Postfix
add per ammo/mode modification

BattleTech.Weapon.get_MediumRange:
	Postfix
add per ammo/mode modification

BattleTech.Weapon.get_LongRange:
	Postfix
add per ammo/mode modification

BattleTech.Weapon.get_HeatGenerated:
	Postfix
add per ammo/mode modification

BattleTech.Weapon.get_IndirectFireCapable:
	Postfix
add per ammo/mode modification

BattleTech.Weapon.get_AOECapable:
	Postfix
add per ammo/mode modification

BattleTech.Weapon.Instability:
	Postfix
add per ammo/mode modification

BattleTech.Weapon.get_WillFire:
	Postfix
add per ammo/mode modification

BattleTech.Weapon.RefireModifier getter
	Postfix
add per ammo/mode modification
	
BattleTech.MechComponent.UIName getter:
	Postfix
add per ammo/mode modification

BattleTech.WeaponRepresentation.Init:
	Postfix
Registering additional weapon visual effects.

BattleTech.WeaponRepresentation.ResetWeaponEffect:
	Postfix
resetting additional per ammo visual effects

BattleTech.CombatGameState.ShutdownCombatState:
	Postfix
make some cleaning

BattleTech.AttackDirector.AttackSequence.Cleanup:
	Postfix
helps AI to cycle ammo on depletion 

BattleTech.UI.CombatHUDWeaponSlot.RefreshDisplayedWeapon:
	Transpiler
needed show real projectiles count when ProjectilesPerShot > 1

BattleTech.CombatGameState.RebuildAllLists
	Postfix
registering all weapon and ammo on battlefield.

BattleTech.CombatGameState.OnCombatGameDestroyed:
	Postfix
make some cleaning

BattleTech.UI.CombatHUD.Init:
	Prefix
registering all weapon and ammo on battlefield. Original method always invoking

AttackEvaluator.MakeAttackOrderForTarget
	Prefix
AI make decision what ammo he must use to hit target. Original method invoking always
	
AttackEvaluator.MakeAttackOrder
	Postfix
AI make decision what ammo he must use to hit target.

AIUtil.UnitHasLOFToTargetFromPosition:
	Transpiler
add per ammo modification of IndirectFireCapable. weapon.IndirectFireCapable changed to CustomAmmoCategories.getIndirectFireCapable(weapon)

AIUtil.UnitHasLOFToUnit:
	Transpiler
add per ammo modification of IndirectFireCapable. weapon.IndirectFireCapable changed to CustomAmmoCategories.getIndirectFireCapable(weapon)

BattleTech.AIRoleAssignment.EvaluateSniper:
	Transpiler
add per ammo modification of IndirectFireCapable. weapon.IndirectFireCapable changed to CustomAmmoCategories.getIndirectFireCapable(weapon)

BattleTech.AbstractActor.GetLongestRangeWeapon:
	Transpiler
add per ammo modification of IndirectFireCapable. weapon.IndirectFireCapable changed to CustomAmmoCategories.getIndirectFireCapable(weapon)

BattleTech.AbstractActor.HasIndirectLOFToTargetUnit:
	Transpiler
add per ammo modification of IndirectFireCapable. weapon.IndirectFireCapable changed to CustomAmmoCategories.getIndirectFireCapable(weapon)

BattleTech.AbstractActor.HasLOFToTargetUnit:
	Transpiler
add per ammo modification of IndirectFireCapable. weapon.IndirectFireCapable changed to CustomAmmoCategories.getIndirectFireCapable(weapon)

BattleTech.HostileDamageFactor.expectedDamageForShooting:
	Transpiler
add per ammo modification of IndirectFireCapable. weapon.IndirectFireCapable changed to CustomAmmoCategories.getIndirectFireCapable(weapon)

BattleTech.MultiAttack.FindWeaponToHitTarget:
	Transpiler
add per ammo modification of IndirectFireCapable. weapon.IndirectFireCapable changed to CustomAmmoCategories.getIndirectFireCapable(weapon)

BattleTech.MultiAttack.GetExpectedDamageForMultiTargetWeapon:
	Transpiler
add per ammo modification of IndirectFireCapable. weapon.IndirectFireCapable changed to CustomAmmoCategories.getIndirectFireCapable(weapon)

BattleTech.MultiAttack.PartitionWeaponListToKillTarget:
	Transpiler
add per ammo modification of IndirectFireCapable. weapon.IndirectFireCapable changed to CustomAmmoCategories.getIndirectFireCapable(weapon)

BattleTech.MultiAttack.ValidateMultiAttackOrder:
	Transpiler
add per ammo modification of IndirectFireCapable. weapon.IndirectFireCapable changed to CustomAmmoCategories.getIndirectFireCapable(weapon)

BattleTech.PreferExposedAlonePositionalFactor.InitEvaluationForPhaseForUnit:
	Transpiler
add per ammo modification of IndirectFireCapable. weapon.IndirectFireCapable changed to CustomAmmoCategories.getIndirectFireCapable(weapon)

BattleTech.PreferFiringSolutionWhenExposedAllyPositionalFactor.EvaluateInfluenceMapFactorAtPosition:
	Transpiler
add per ammo modification of IndirectFireCapable. weapon.IndirectFireCapable changed to CustomAmmoCategories.getIndirectFireCapable(weapon)

BattleTech.PreferLethalDamageToRearArcFromHostileFactor.expectedDamageForShooting:
	Transpiler
add per ammo modification of IndirectFireCapable. weapon.IndirectFireCapable changed to CustomAmmoCategories.getIndirectFireCapable(weapon)

BattleTech.PreferNotLethalPositionFactor.expectedDamageForShooting:
	Transpiler
add per ammo modification of IndirectFireCapable. weapon.IndirectFireCapable changed to CustomAmmoCategories.getIndirectFireCapable(weapon)

BattleTech.ToHit.GetAllModifiers:
	Transpiler
add per ammo modification of IndirectFireCapable. weapon.IndirectFireCapable changed to CustomAmmoCategories.getIndirectFireCapable(weapon)
	Postfix
add per ammo or weapon modificator if direct fire detected.

BattleTech.ToHit.GetAllModifiersDescription:
	Transpiler
add per ammo modification of IndirectFireCapable. weapon.IndirectFireCapable changed to CustomAmmoCategories.getIndirectFireCapable(weapon)
	Postfix
add per ammo or weapon modificator if direct fire detected.

BattleTech.UI.CombatHUDWeaponSlot.UpdateToolTipsFiring:
	Transpiler
add per ammo modification of IndirectFireCapable. weapon.IndirectFireCapable changed to CustomAmmoCategories.getIndirectFireCapable(weapon)

BattleTech.UI.CombatHUDWeaponTickMarks.GetValidSlots:
	Transpiler
add per ammo modification of IndirectFireCapable. weapon.IndirectFireCapable changed to CustomAmmoCategories.getIndirectFireCapable(weapon)

BattleTech.Weapon.WillFireAtTargetFromPosition:
	Transpiler
add per ammo modification of IndirectFireCapable. weapon.IndirectFireCapable changed to CustomAmmoCategories.getIndirectFireCapable(weapon)

LOFCache.UnitHasLOFToTarget:
	Transpiler
add per ammo modification of IndirectFireCapable. weapon.IndirectFireCapable changed to CustomAmmoCategories.getIndirectFireCapable(weapon)
 
</pre>
