!WARNING! This version of CAE disabling vanilla aura COMPLETELY. I have to do it cause vanilla aura's code is very bad. 
Original code recalculating all auras for all combatant pairs every frame which is drop performance down especially if there many units on battle field.
My auras implementation written from scratch and using collides making Unity do all work for compare distances.
!NOTE! FrostRaptor's AurasHelper is assumed to be incompatible new auras code. But cause original auras disabled it assumed to be not needed. 

to invoke heat sinks manipulation dialog ctrl+click on brace (shield) button in mech HUD. 
   heat sinks manipulation limitations: you can switch on and off only dedicated heat sinks not engine internal ones
   
AI can activate component if it have correct tags
AI related tags:
	cae_ai_offence - component provides damage and/or accuracy boost
    cae_ai_defence - component provides defense boost
    cae_ai_explode - component can explode and damage other components in location and/or inner structure
    cae_ai_heat - component have negative impact on heat dissipation
    cae_ai_cool - component have positive impact on heat dissipation
    cae_ai_speed - component increase speed
    cae_ai_sensors - component increase sensors range
AI related mod settings
	"AIComponentUsefullModifyer":0.2 - if value if greater AI will less fair to activate potentially useful components which can make significant damage to himself on fail
	"AIComponentExtreamlyUsefulModifyer":0.4, - if value if greater AI will less fair to activate potentially very useful components which can make significant damage to himself on fail
	"AIOffenceUsefullCoeff":0.1, - if value if lesser AI will count cae_ai_offence more useful
	"AIDefenceUsefullCoeff":0.2, - if value if lesser AI will count cae_ai_defence more useful
	"AIHeatCoeffCoeff":0.9, - if value if greater AI will count cae_ai_cool less useful and cae_ai_heat less dangerous
	"AIOverheatCoeffCoeff":0.8 - if value if greater AI will count cae_ai_cool less useful and cae_ai_heat less dangerous
  "ToolTipWarningFailChance": 0.2, - if component can be activated manually, active and have fail chance grater than this value it will be shown in tooltip with orange color
  "ToolTipAlertFailChance": 0.4, - if component can be activated manually, active and have fail chance grater than this value it will be shown in tooltip with red color
                                   NOTE! Component will not be show in same turn it has been activated no matter fail chance, cause it will not suffer fail roll only this turn.
  "StartupByHeatControl":true, - if true startup after overheat controlled by current heat ratio
  "StartupMinHeatRatio":0.4, - min heat ratio that should be reached before mech can start up
                               NOTE! How it is working: mech shut down, on start up try there is check CurrentHeatRatio < StartupMinHeatRatio. If check pass start up normal. 
                               If fail mech will not start acting same as if you press "done with mech" (eg. mech remains down and only heatsinks applying lowering heat level).
                               Next turn you can try to start mech up again same rules. AI meches acting same.
  "StoodUpPilotingRoll":true, - if true mech stand up procedure becomes optional. Based on piloting roll.
  "StoodUpPilotingRollCoeff":0.1,
  "DefaultArmsAbsenceStoodUpMod":-0.1, - default value for CAEArmAbsenceStoodUpMod
  "LegAbsenceStoodUpMod":-0.1
                              NOTE! Mechanics: in stand up try there is roll(0-1) against 
                                       stand chance = <Piloting Skill> * <StoodUpPilotingRollCoeff> + <CAEStoodUpRollMod stat value> 
                                            + <count of destroyed arms> * <CAEArmAbsenceStoodUpMod stat value>
                                            + <count of destroyed legs> * <LegAbsenceStoodUpMod>
                                    if roll value less than stand chance mech starts normally, if not mech will not stand up acting same as if you press "done with mech".
                              NOTE! You can use CAEStoodUpRollMod and CAEArmAbsenceStoodUpMod actors statistic values to control stand up roll per chassis/mech
  "unaffectedByHeadHitStatName": "unaffectedByHeadHit" - unit statistic names if this value is set true at runtime mech will be unaffected by head hits
  "equipmentFlashFailChance": 0.1 if component is active currently and its fail chance more than this value its slot will flash red.
  "C3NetworkEncounterTags": [ "C3_network" ] - if any of this tags exists in unit's encounter tags it will be target of C3 calculations. See C3 implementation section
  "AdditionalInjuryReasonsTable": { <int>:"<string>" } - you can use this table to override InjuryReason to string evaluation. 
                                  example: 
								    settings:
								      "AdditionalInjuryReasonsTable": { 10: "Component Fail" }
								    component:
									  "InjuryReasonInt": 10
									on fail in floatie message will be "Component Fail" instead of "Error NotSet"
-----------------------------------------------------------------------------------------------------------------------                              
  NOT NEEDED ANY MORE. KEEPED FOR HISTORICAL REASONS.
  "auraUpdateFix": "Position" - type of fixing updating aura while unit movement.
                                Some basics: vanilla's code updating auras while unit moving looks like sabotage. If someone under my command write something like this he/she will be fired immediately.
                                !EVERY! frame while unit moves method recalculating all auras invoked, and this method is very slow, 
                                worst of all it is called in frame draw thread which inflicts huge FPS drop if there is ECMs at battlefield.
                                I've throttle calling this method. I'm offering next throttling strategies:
                                "None" - vanilla behavior
                                "Never" - fastest method. Auras not updating while moving, only at end of move or jump. 
                                          Drawback of this - you will see stealth animations only at end of move. But cause it is turnbased game it will not alter gameplay at all.
                                "Position" - auras updating while moving, but frequency of updates controlled by moving distance eg every 20 meters for example. 
                                          Distance controlled by auraUpdateMinPosDelta.
                                "Time" -  - auras updating while moving, but frequency of updates controlled by moving time eg every 2 seconds. Time delta controlled by auraUpdateMinTimeDelta.
                                I'm suggesting Position strategy with update every 20 meters, cause, i think, this settings is compromise between performance and visual.  
                                Maybe later i will reimplemented update strategy to use unity's collides subsystem it will remove any visual drawbacks cause auras will be updated only when it is needed. 
  "auraUpdateMinPosDelta": 20 - position delta for Position aura update fix strategy
  "auraUpdateMinTimeDelta": 2 - time delta for Time aura update fix strategy
------------------------------------------------------------------------------------------------------------------------
you can make active probe ability directional (in arc) instead of range
{
  "Description": {
    "Id": "AbilityDef_EWS_Ping",
    "Name": "EWS PING",
    "Details": "ACTION: Perform a Sensor Lock on enemies within [IntParam1] meters in 60 degrees arc, and generates [FloatParam2] Heat for the user. There is a [ActivationCooldown] round cooldown.",
    "Icon": "uixSvgIcon_action_sensorlock"
  },
  "ActivationTime": "ConsumedByFiring",
  "Targeting": "ActiveProbe",
  "ActivationCooldown": 4,
  "FloatParam1": 250.0,
  "StringParam2": "arc60",   - if StringParam2 is omitted normal 360 deg. ActiveProbe will be performed. Two possible values
                               arc60 for 60 deg. arc and arc90 for 90 deg. arc. If parameter is set for range IntParam1 will be used
							   instead of normal FloatParam1. !Note! AI still using 360 deg. ActiveProbe with FloatParam1 range
							   Limited arc is for player only. 
							   !NOTE! ensure you have "targeting_arc_60" and "targeting_arc_90" PNG 2d textures in your manifest. 
							   Directional active probe will not work if absent. 
  "IntParam1": 350,          - range for directional active probe ping
  "FloatParam2": 50.0,
  "StringParam1": "Active Probe is unavailable."
}
------------------------------------------------------------------------------------------------------------------------
    if ComponentRefInjector is installed (ModTek 3.0+ Mods/ModTek/Injectors/ComponentRefInjector.dll)
	you can create weapon addon component. Weapon addon can have target component - weapon it is attached to. 
	inside MechDef in inventory list two optional fields was added. "LocalGUID" and "TargetComponentGUID"
	non empty "TargetComponentGUID" means this component have dedicated target inside this MechDef.
	Relevant UI in mech lab been added to give user ability to select addon target. 
  "inventory": [
    {
      "MountedLocation": "RightTorso",
      "ComponentDefID": "Weapon_PPC_LPPCER_3",
      "SimGameUID": "",
      "ComponentDefType": "Weapon",
      "HardpointSlot": 0,
      "GUID": null,
      "DamageLevel": "Functional",
      "prefabName": null,
      "hasPrefabName": false
    },
    {
      "MountedLocation": "RightTorso",
      "ComponentDefID": "Weapon_PPC_LPPCER_3",
      "SimGameUID": "",
      "ComponentDefType": "Weapon",
      "HardpointSlot": 1,
      "GUID": null,
      "DamageLevel": "Functional",
      "prefabName": null,
      "hasPrefabName": false,
	  "LocalGUID":"some_guid_0"
    },
    {
      "MountedLocation": "RightTorso",
      "ComponentDefID": "Gear_C3_slave_debug",
      "SimGameUID": "",
      "ComponentDefType": "Upgrade",
      "HardpointSlot": -1,
      "GUID": null,
      "DamageLevel": "Functional",
      "prefabName": null,
      "hasPrefabName": false,
	  "TargetComponentGUID":"some_guid_0"
    }
],
    to make UpgradeDef a weapon addon you need to make two things.
	1. Create WeaponAddonDef json file and add it to any mod manifest
	2. Add AddonReference to UpgradeDef custom section

	"Custom": {
		"AddonReference":{ 
			"installedLocationOnly":true,     - if true user can only select weapons from same location as target for this addon
			"autoTarget":true,     - target for this component will be selected automatically on component add to mech configuration. 
				                     If false addon will be have no target unless user set it implicitly 
			"notTargetable":false,  - if true instead of targeting addons will be added to all suitable weapons. 
			                          !NOTE! "notTargetable" component will not share crits with weapon it adds modes
									  cause they are not counted as attached. "Location":"{target}" is not resolved also
			"WeaponAddonIds": [ "ppc_capacitor", "ppc_capacitor2" ] - list of addons. If component have multiply addons 
			                                                          only suitable (detected by targetComponentTags) will be actually applied
		},

WeaponAddonDef example

{
	"Id":"ppc_capacitor",  - ID should same as file name
	"addonType":"ppc_capacitor_type", - string used to track addons of the same type. If ommited Id is used. 
	                                    Only one addon of certain type can be attached to weapon
	"targetComponentTags":["overload_mode_unlockable"], - set of tags weapon should have to be able to be target for an addon
	"modes":[                                           - list of modes this addon adding to weapon. 
	                                                      If isBaseMode is true this mode will be forced to be default for this weapon
														  If weapon been damaged due to jamming crit goes to addon first. 
														  If addon been destroyed mode it added been disabled
														  If mode with same name exists already it will be merged with original mode
														  merge means resulting mode will have float and integer values as sum of original and new values
														  dictionaries and lists fields will be concatenated all other values (strings, enums etc)
														  replaced (if set in new mode)
														  Note! if overriden mode becomes locked (source component damage etc) original mode become available
														  Note! if you have two or more components overriding same original mode this will NOT create one mode
														  result of merge of all modes, instead you will gain two or more additional modes
														  "new mode 1" = "original mode" + "override mode A"(addon 1)
														  "new mode 2" = "original mode" + "override mode B"(addon 2)
    {
      "Id": "overload",
      "UIName": "purple",
      "isBaseMode": true,
      "DamagePerShot": 10,
      "FireDelayMultiplier": 1,
      "WeaponEffectID": "WeaponEffect-Weapon_PPC",
      "ProjectileScale": { "x": 3, "y": 3, "z": 3 },
      "preFireSFX": "Play_PPC3",
      "ColorChangeRule": "Linear",
      "ProjectileSpeedMultiplier": 0.5,
      "ShotsWhenFired": 1,
      "ColorSpeedChange": 7,
      "HeatGenerated": 50,
      "HeatDamagePerShot": 50
    }
	]
}

    if StatisticEffectDataInjector is installed (ModTek 3.0+ Mods/ModTek/Injectors/StatisticEffectDataInjector.dll)
	you can define Location field in statisticData
	if this field is set components from other locations can't be target for this statistic effect
	works for passive and activatable effects (not working for auras, abilities and weapon impact/on-fire effects)
	Location:"{current}" means location where component is installed
	Location:"{above}" means location where component is installed and only one nearest component placed in location 
	                   above current is affected. 
	Location:"{onlyone}" means location where component is installed and only one component placed in location current is affected.
	                     Affection is tracked by effect id. 
	Location:"{adjacent}" means ONE, just ONE location toward center from current (where component is installed). 
	                      for normal mechs and quads, LL->LT, RL->RT, LA->LT, RA->RT, H->CT, RT->CT, LT->CT, CT->None
						  for vehicles Rear->None, Front->None, Right->Front, Left->Front, Turret->Front
						  for turrets, squads always None
						  "None" no components and locations will be affected. 
	Location:"{damaged}" if effect is been created due to mech component damage processing, (for example MechEngineer critical processing)
	                     only component THIS damaged component been affected

    if ComponentRefInjector is installed (ModTek 3.0+ Mods/ModTek/Injectors/ComponentRefInjector.dll)
	Location:"{target}" means effect will be applied only component been selected as target for this weapon addon. Refer WeaponAddonDef section. 

	also Location is processed if target is not only component but unit. If unit is target for the effect, effect becomes location specific
	!NOTE! not all unit statistic effects can be specific for location. Even more you should count every effect to be not location specific unless 
	its locational nature mentioned explicitly. If you set non statistic value not processed by location - effect changes nothing.

    if StatisticEffectDataInjector is installed (ModTek 3.0+ Mods/ModTek/Injectors/StatisticEffectDataInjector.dll)
	you can define ShouldHaveTags and ShouldNotHaveTags fields in statisticData. 
	Value for both fields is string - set of tags separated by "," ("ShouldHaveTags":"my_cool_tag1,my_cool_tag2")
	if ShouldHaveTags field is set components do not have all mentioned tags in their definitions can't be target for this statistic effect
	if ShouldNotHaveTags field is set components have at least one mentioned tag in their definitions can't be target for this statistic effect
	if this field is set components does not have all mentioned tags in their definitions can't be target for this statistic effect
	"Custom":{
		"Category" : [ {"CategoryID" : "Activatable"}, {"CategoryID" : "MASC"}], 
		"AutoReplentish":{
			"ReplentishAmount": 10 - if component is ammo box, its current ammo value will increase by this value each round (at end of round)
			                         up to maximum capacity 
		},
		"ActivatableComponent":{
			"SwitchOffOnFall": false, - if true component will be switched off on mech knockdown. You should set it to true if you want your LAM animations working properly. 
			"ActivateOncePerRound": false, - if true component set up for auto activation on heat can be activated only once per round
			"CanActivateAfterFire": true, - if true component can be activated after fire. Default true.
			"CanActivateAfterMove": false, - if true component can be activated after move.
			"SafeActivation": false, - if true component will not begin activation on component toggle. Assumed to be true if component have no influence on pathing and can't fail.
			"ButtonName":"MASC",  - string used in activation/deactivation dialog button. Keep as sort as possible. 
			"activateVFXOutOfLOSHide":true, - if true active component's VFX will be shown only if unit is visible to player (default false)
			"presistantVFXOutOfLOSHide":true, - if true static component's VFX will be shown only if unit is visible to player (default false)
			"FailFlatChance":0.3, - chance of fail on cold activation. 
			"FailRoundsStart":1, - round since fail checks will be performed
			"FailChancePerTurn":0.5, - value which added to fail chance every round of activity.
			                        Fail mechanic notes: on battle start each active component's <FailChance> setted to FailFlatChance.
									On activation component will have <FailChance> to fail, than every time at end of moving sequence since FailRoundsStart round (activation round count as 0) 
									component will have check with <FailChance> to fail.
									Every end of round <FailChance> increasing by FailChancePerTurn if component is in active state or decreasing by FailChancePerTurn if not.
									If <FailChance> become less than FailFlatChance it tied to FailFlatChance.
			"FailISDamage":10,  - Damage to inner structure on fail
			"FailCrit":true, - if true fail inflicts critical rolls.
			"SelfCrit": false - if true make crit hit to self.
			"ShutdownOnFail": true, - if true on component fail it will be deactivated, if false component will continue to work after fail.
			                          Note: it does not affects manual activation. If component failed on manual activation it remains offline regardless this setting
			"FailCheckOnActivationEnd": false - if true fail check will be performed on activation end instead of move end
			"FailDamageLocations":["LeftLeg","RightLeg"], - list of locations to damage. 
			                              Available values Head,LeftArm, LeftTorso, CenterTorso, RightTorso,RightArm,LeftLeg,RightLeg. ONLY this values.
			"FailDamageVehicleLocations":["Front","Left"], - list of locations to damage. Used if component installed on vehicle
			                             Avaible values Front,Left,Right,Rear,Turret. If vehicle is turret-less damage will not be inflicted.
							Fail damage notes: if FailCrit is true crit is always inflicted. Random roll is just for detect target component. 
							Crits hits only occupied slots (instead of vanilla logic), if component is destroyed it is skipped from roll. 
			"FailCritComponents": false - if true fail inflicts critical rolls, but logic is different from "FailCrit".
			"FailCritLocations":["LeftLeg","RightLeg"], - list of locations to crit rolls. 
			"FailCritVehicleLocations": ["Front","Left"] - list of locations to crit rolls. 
			                              if "FailCrit" is true all fail damage to locations inflicts crit roll to detect which component 
										  will be targeted. Eg. if FailDamageLocations array contains three locations three crit roll will be preformed
										  But if FailCritComponents is true, fail results only one crit roll. It will list all components from FailCritLocations
										  and than choose one to crit.
			"FailDamageToInstalledLocation": false - if true location component is installed will be added to FailDamageLocations/FailDamageVehicleLocations
			"FailCritToInstalledLocation": false - if true location component is installed will be added to FailCritLocations/FailCritVehicleLocations
			"FailCritExcludeComponentsTags" : [], - if component have one of tag from this list it will be excluded from fail damage crit roll both (FailCrit and FailCritComponents) methods
			"FailCritOnlyComponentsTags" : [], - if not empty only component having at least one tag from this list will be used to drit roll crit roll both (FailCrit and FailCritComponents) methods
			"UnsafeFailChance":1.0 - chance component explode (fail effects application mentioned above) on fail. 
			                         If component fail and win(win have negative effect) this roll,
			                         all fail effects will be applied (if setup). Otherwise (failing this roll have positive 
									 effect) component just been deactivated without any side effect. 
									 By default UnsafeFailChance have value - 1.0 eg. all fails are dangerous.
									 In runtime value can be controlled by component statistic value "CAEUnsafeFailChance" 
									 (default value for this statistic is <UnsafeFailChance>)
									 Also there is per unit statistic "CAEUnsafeFailChanceMod" (default value is 1.0) multiplicative
									 and "CAEAIUnsafeFailChanceMod" (applied only is unit under AI control, default value is 
									 DefaultAIUnsafeFailChanceMod in mod settings)
			"MechTonnageWeightMult" : 20 - installed chassis tonnage restriction multiplier. Tonnage restriction from (Component.Tonnage-1)*(MechTonnageWeightMult)+1 to (Component.Tonnage)*(MechTonnageWeightMult)
			                                with component tonnage - 5 and MechTonnageWeightMult - 20 chassis tonnage restriction will be from (5-1)*20 + 1 = 81 to 5*20 = 100
			"MechTonnageSlotsMult" : 20  - installed chassis tonnage restriction multiplier.
			                               Tonnage restriction from (Component.InventorySize-1)*(MechTonnageWeightMult)+1 to (Component.InventorySize)*(MechTonnageWeightMult)
			                                with component InventorySize - 5 and MechTonnageWeightMult - 20 chassis tonnage restriction will be from (5-1)*20 + 1 = 81 to 5*20 = 100
			"EngineTonnageWeightMult" : 0, - installed engine tonnage restriction. Same logic as MechTonnageWeightMult but restricts engine weight instead of chassis tonnage.
												engine weight is calculated as weight of all components in mech with "EnginePart" category
			"EngineTonnageSlotsMult" : 0, - same logic as MechTonnageSlotsMult and EngineTonnageWeightMult
			"FailPilotingBase": 3, - base skill value for per piloting skill fail chance alteration
			"FailPilotingMult": 0.1, - multiplier for per piloting skill fail chance alteration
			                   EffectiveFailChance = CurrentFailChance + (FailPilotingBase - SkillPiloting) * FailPilotingMult
							   Example: FailChance = 0.8, PilotingSkill = 8, FailPilotingBase = 5, FailPilotingMult = 0.1
							   EffectiveFailChance = 0.8 + (5-8)*0.1 = 0.5
			"AutoActivateOnHeat": 40, - upon mech reaching this heat level unactive activatable component will be activated automaticly.
			"AutoDeactivateOnHeat": 30,  - upon mech reaching this heat level active activatable component will be deactivated automaticly.
			                             NOTES: 
										        activation/deactivation heat check performed after every heat sinks activation (usually after each fire and brace activity)
												state of active component activatable by heat level is still shown in activation menu but there is no button to activate them
												fail check is not performed on activation of component activated by heat, 
												but fail check after each move is still performed if crit chance is grater than zero
			"AutoActivateOnOverheatLevel": 0.8, same as AutoActivateOnHeat but instead of Heat level used persentage of Overheat
			"AutoDeactivateOverheatLevel": 0.8, same as AutoDeactivateOnHeat but instead of Heat level used persentage of Overheat
			"ActivationMessage": "ON", - string showing in activation floatie message along with component UI name
			"DeactivationMessage": "OFF", - string showing in deactivation floatie message along with component UI name
			"ActivationIsBuff": "true", - if true component activation floatie message will have buff icon, deactivation - debuff,
			"NoUniqueCheck": false, - if true disables unique component check in lechlab, so you can install nore than one component of the same type to one mech
			"ChargesCount": 0, - if > 0 charges logic will be used. On activation component will decrement charges couner instead of activation and than apply statusEffects
			                   NOTE: cause component not activating actualy FailChance will not increase from round to round.
			"FailStabDamage": 0, - damage to stability on fail
			"FailChancePerActivation": 0 - fail chance change per activation
			"AlwaysFail": false - each activation counts as fail no matter fail roll or fail chance
			"CanNotBeActivatedManualy": false - flag component can't be activated manually. WARNING! No backward compatibility - components with AutoActivateOnHeat > 0 can now be activated manually
												if CanNotBeActivatedManualy is set to false. This works so cause i want to provide possibility of both activation vectors auto-by-heat and manual
												if manual activation is unwanted CanNotBeActivatedManualy have to be true
												NOTE! if omitted consider as true. You have to set it as false if you want component to have ability to able to activate manualy.
			"activateVFX":{  - VFX applied on activation (removed on component destruction)
				"VFXPrefab":"vfxPrfPrtl_miningSmokePlume_lrg_loop" - VFX prefab name, same rules as for VFX names in CustomAmmoCategories. For external VFXes CAE relay on CAC
			    "VFXScaleX":1, - scale for VFX if supported
				"VFXScaleY":1,
				"VFXScaleZ":1,
				"VFXOffsetX":0, - offset for VFX
				"VFXOffsetY":0,
				"VFXOffsetZ":0,
			}, 
			"presistantVFX":{  - VFX applied on combat initialisation (removed on component destruction)
				"VFXPrefab":"vfxPrfPrtl_miningSmokePlume_lrg_loop" - VFX prefab name, same rules as for VFX names in CustomAmmoCategories. For external VFXes CAE relay on CAC
			    "VFXScaleX":1, - scale for VFX if supported
				"VFXScaleY":1,
				"VFXScaleZ":1,
				"VFXOffsetX":0, - offset for VFX
				"VFXOffsetY":0,
				"VFXOffsetZ":0,
			}, 
			"destroyedVFX":{  - VFX applied on component destruction and played until end of combat
				"VFXPrefab":"vfxPrfPrtl_miningSmokePlume_lrg_loop" - VFX prefab name, same rules as for VFX names in CustomAmmoCategories. For external VFXes CAE relay on CAC
			    "VFXScaleX":1, - scale for VFX if supported
				"VFXScaleY":1,
				"VFXScaleZ":1,
				"VFXOffsetX":0, - offset for VFX
				"VFXOffsetY":0,
				"VFXOffsetZ":0,
			}, 
							NOTE: if parent component is weapon with correct representation this representation object will be uses as parent object. If no unit itself will be used
			"activateSound":"enum:AudioEventList_ui.ui_ecm_start", - additional sound effect on component activation impact. Value format "<type>:<name>".
							 type values: "enum" - building in-game enum value
							              "id" - unsigned integer (if you know value)
								   		  "name" - audio event name 
										  "none" - none additional sound for this type name doesn't matter							
			"deactivateSound":"" - additional sound effect on component activation impact. Value format "<type>:<name>".
							 type values: "enum" - building in-game enum value
							              "id" - unsigned integer (if you know value)
								   		  "name" - audio event name 
										  "none" - none additional sound for this type name doesn't matter
			"destroySound":"" - additional sound effect on component activation impact. Value format "<type>:<name>".
							 type values: "enum" - building in-game enum value
							              "id" - unsigned integer (if you know value)
								   		  "name" - audio event name 
										  "none" - none additional sound for this type name doesn't matter
							NOTE! activateSound played only on success activation. If activation fail deactivateSound played (if any). 
			"Explosion":{ - component AoE explosion capabilities
			  "Range":90, - range. All combatants within range will be affected
			  "Damage":3000, - AoE damage linear decrease by distance between source and target
			  "Heat":100, - Heat damage. If target is not mech this value will be added to Damage in calcualtion
			  "Stability":100, - Stability damage. If target is not mech this value is ommited
			  "Chance":0.6, - Chance of explosion if commited
			  "ExplosionMessage" : "", - floatie message on explosion commit
			  "VFX":"WFX_Nuke" - additional VFX on explosion 
				"VFXScaleX":1, - VFX scale
				"VFXScaleY":1,
				"VFXScaleZ":1,
				"VFXOffsetX":0, - VFX offset
				"VFXOffsetY":0,
				"VFXOffsetZ":0,
							same as in CAC weapon incineration settings. Search for deteils in CAC readme. CAC biome settings applying too
				"FireTerrainChance": 0.3,
				"FireTerrainStrength": 40,
				"FireDurationWithoutForest": 0,
				"FireTerrainCellRadius":7,
							same rules as CAC terrain design mask applying on weapon impact. Search for deteils in CAC readme.
				"TempDesignMask":"DesignMaskRadiation",
				"TempDesignMaskTurns": 999,
				"TempDesignMaskCellRadius":12,
				"LongVFX":"",
				"LongVFXScaleX":1,
				"LongVFXScaleY":1,
				"LongVFXScaleZ":1,
				"LongVFXOffsetX":0,
				"LongVFXOffsetY":0,
				"LongVFXOffsetZ":0,
				"VFXActorStat":0,
							next some tricky part. You can change explosion parameters via unit "StatisticEffect"  statusEffects. If component allow this. 
							In component explosion settings you can set "<param>ActorStat" setting. Than in another component you can define status effect changing this setting. 
							Example: Component1 have 
							.............................
							"Exposion" : {
								"Chance":1,
								"Range":90,
								"Damage":100
								"RangeActorStat":"Component1RangeStat",
								"DamageActorStat":"Component1DamageStat"
							}
							.........................
							Component2 
							.......................
							"statusEffects": [
							..........................
							{
							............................
								"statisticData" : {
									....................................
									"statName" : "Component1RangeStat",
									"operation" : "Float_Multiply",
									"modValue" : "2.0",
									"modType" : "System.Single",
									.....................................
								},
							...........................
							},
							..........................
							{
							............................
								"statisticData" : {
									....................................
									"statName" : "Component1DamageStat",
									"operation" : "Float_Multiply",
									"modValue" : "3.0",
									"modType" : "System.Single",
									.....................................
								},
							...........................
							},
							..........................
							]
							Component3
							"Exposion" : {
								"Chance":1,
								"RangeActorStat":"Component1RangeStat",
								"DamageActorStat":"Component1DamageStat"
							}
							if unit have Component1 and Component3 - they(components) will explode with 90m ramge and 100 damage
							if unit have Component1, Component3 and Component2, than Component1 and Component3 explosion will be 180m ramge and 300 damage
							if unit have Component3 it will not explode case Range and Damage is not set (assumed 0)
				"VFXScaleXActorStat":"",
				"VFXScaleYActorStat":"",
				"VFXScaleZActorStat":"",
				"VFXOffsetXActorStat":"",
				"VFXOffsetYActorStat":"",
				"VFXOffsetZActorStat":"",
				"RangeActorStat":"",
				"DamageActorStat":"",
				"HeatActorStat":"",
				"StabilityActorStat":"",
				"ChanceActorStat":"",
				"FireTerrainChanceActorStat":"",
				"FireTerrainStrengthActorStat":"",
				"FireDurationWithoutForestActorStat":"",
				"FireTerrainCellRadiusActorStat":"",
				"TempDesignMaskActorStat":"",
				"TempDesignMaskTurnsActorStat":"",
				"TempDesignMaskCellRadiusActorStat":"",
				"LongVFXActorStat":"",
				"LongVFXScaleXActorStat":"",
				"LongVFXScaleYActorStat":"",
				"LongVFXScaleZActorStat":"",
				"LongVFXOffsetXActorStat":"",
				"LongVFXOffsetYActorStat":"",
				"LongVFXOffsetZActorStat":"",
				"AmmoCountScale": false - affects only if component is ammo box. If so explosion damage/heat/instability will be scaled by CurrentAmmo/AmmoCapasity. 
											If component is not functional scale factor will be zero.
				"AddSelfDamageTag":"", - if not empty explosion damage/heat/instability will be adjusted. 
				                         Effective values of damage/heat/instability of all other components which have AddOtherDamageTag value same as AddSelfDamageTag 
										 of current component will be added to explosion values.
										 Need to add ammo boxes explosion strength to engine core explosion strength. 
				"AddOtherDamageTag":"",
				"ExplodeSound":"" - additional sound effect on component explosion. Value format "<type>:<name>".
							 type values: "enum" - building in-game enum value
							              "id" - unsigned integer (if you know value)
								   		  "name" - audio event name 
										  "none" - none additional sound for this type name doesn't matter			
				"ExplodeSoundActorStat":"" - actor stat name for statisticEffect explode sound override
        "statusEffectsCollection": "NuclearExplosion", - name of static effect list
        "statusEffectsCollectionActorStat": "EngineExplodeStatusEffects", - unit's statistic name to control from other components
        "statusEffectsCollectionName": "NuclearExplosion", - name for status effect list in statusEffects list
         "statusEffects" : [] - status effect on component explosion
        NOTE! look in Gear_EngineCore, Gear_EngineType example to get an inspiration how component's AoE explosion status effects can be controlled 
         
			}, 			
							NOTE: parent unit owner of component is not affected. Only other combatants. So component owner is not have to be destroyed or damaged at all. On other modders concern.
							      Damage value calculation have same rules as CAC AoE damage.
			"ExplodeOnFail": false, - if true Explode will be activated on component activation fail
			"ExplodeOnDamage": false - if true Explode will be activated on component destruction
			"ActiveByDefault": false - if true component will be activated on combat start with no fail roll
			"ExplodeOnSuccess": false - if true component will explode on success activation
			"EjectOnFail": false - if true pilot will be ejected BEFORE damage appliance on fail activation roll
			"EjectOnSuccess": false - if true pilot will be ejected BEFORE effects appliance on success activation roll
			"EjectOnActivationTry": false - if true pilot will be ejected before roll check
			"InjuryOnFail": false - if true pilot will be injured BEFORE damage appliance on fail activation roll
			"InjuryOnSuccess": false - if true pilot will be injured BEFORE effects appliance on success activation roll (use with caution)
			"InjuryOnActivationTry": false - if true pilot will be injured before roll check  (use with caution)
			"InjuryReason": "ComponentExplosion" - injury reason. Possible values NotSet, ActorDestroyed, HeadHit, AmmoExplosion, Knockdown, SideTorsoDestroyed, ComponentExplosion
			"InjuryReasonInt": -1, - you can use this value instead of InjuryReason. If greater than 0 this value is used instead.  
			"KillPilotOnFail": false - if true pilot will be killed BEFORE damage appliance on fail activation roll
			"KillPilotOnSuccess": false - if true pilot will be killed BEFORE effects appliance on success activation roll (use with caution)
			"KillPilotOnActivationTry": false - if true pilot will be killed before roll check  (use with caution)
			"KillPilotDamageType": "ComponentExplosion" - kill pilot damage type. Possible values NOT_SET, Unknown, HeadShot, HeadShotMelee, Melee, DFA, DFASelf, Overheat, OverheatSelf, KnockdownSelf, Knockdown, AmmoExplosion, Weapon, Enemy, Combat, Artillery, SideTorso, DropShip, OverrideString, DropPod, ComponentExplosion
			"CheckPilotStatusFromAttack_reason": "Component fail" - string for CheckPilotStatusFromAttack invocation
								NOTE: Please keep in mind that all status effects will be canceled on unit destruction. Ejection counts as destruction too.
								If you want to keep unit statistic after component/mech destruction you have to set "effectsPersistAfterDestruction" : true
								It is really needed by components altering explosion stats cause do mech destruction they returned to default state which is usually unwanted
								NOTE: Injury<..> and KillPilot<..> settings are not applied to squads
      "offlineStatusEffects": [], - effects applying on component switch off. They removed if component will be switched on. If component have no ActiveByDefault - applying on combat start
			"AutoActivateOnIncomingHeat":0, - if > 0 component will be activated on incoming heat
			"incomingHeatActivationType": "Threshhold", - type of activation, controls how AutoActivateOnIncomingHeat will be processed 
                                                    possible values 
                                         Threshhold - component will be activated if heat from whole attack will be greater than AutoActivateOnIncomingHeat
                                         Single - component will be activated if heat from single source (one weapon if attacked) will be greater than AutoActivateOnIncomingHeat
                                         Level - component will be activated if (heat from whole attack)/(unit max heat) will be greater than AutoActivateOnIncomingHeat
			
      "ActivateOnDamageToMechLocations":["CenterTorso","CenterTorsoRear"], - list of locations sensible to damage for activation of this component (installed in mech)
			"ActivateOnDamageToVehicleLocations":["Turret","Rear"], - list of locations sensible to damage for activation of this component (installed in vehicle)
                                                              turrets have only one location so all turret locations is sensible
			"ActivateOnDamageToInstalledLocation":false - if true location component installed is sensible too (for mechs both front and rear locations used)
      
			"AutoActivateOnArmorDamage":0, - if > 0 component will be activated on incoming damage to armor
			"AutoActivateOnStructureDamage":0, - if > 0 component will be activated on incoming damage to structure
			"damageActivationType: "Threshhold", type of activation, controls how AutoActivateOnArmorDamage and/or AutoActivateOnStructureDamage will be processed 
               Threshhold - component will be activated if damage to any sensible location from whole attack will be greater 
                             than AutoActivateOnArmorDamage(to armor damage) or AutoActivateOnStructureDamage(to structure damage)
               Single - component will be activated if damage to any sensible location from single source 
                  (one pallet if attacked) will be greater than AutoActivateOnArmorDamage(to armor) or AutoActivateOnStructureDamage(to structure)
               Level - component will be activated if (damage to sensible location from whole attack)/(max armor/structure for location) 
                               than AutoActivateOnArmorDamage(to armor damage) or AutoActivateOnStructureDamage(to structure damage)
      some notes on mechanic: damage counting performed immediately after every attack sequence (useful for direct attacks), 
                              move/jump sequence (for landmines damage), at start of round (for any other sources)
                              after every activations damage calculation all damage info resets. This means if unit attacked many times per round damage calculations 
                              will be performed for every attack independently 
			"Repair":{ 
				"InnerStructure":10, - points of inner structure to repair (destroyed location can't be repaired)
				"Armor":15, - points of armor to repair (destroyed location can't be repaired)
				"MechStructureLocations":[], - list of mech structure locations to repair. 
                     Supported values Head,LeftArm,LeftTorso,CenterTorso,RightTorso,RightArm,LeftLeg,RightLeg
				"MechArmorLocations":[], - list of mech armor locations to repair. 
                     Supported values Head,LeftArm,LeftTorso,CenterTorso,RightTorso,RightArm,LeftLeg,RightLeg,LeftTorsoRear,CenterTorsoRear,RightTorsoRear
				"VehicleLocations":[], - list of vehicle locations to repair
                         Supported values Turret,Front,Left,Right,Rear
				"BuildingLocations":[], - list of turret locations to repair
                         Supported value Structure
				"AffectInstalledLocation":true, - if true location where component installed will be added to list. 
                          NOTE: for meches both front and rear location will be added to affecte4d list (if available for location)
        "TurnsSinceDamage": 1, - if this value >= 0 and location has been damaged more than this value rounds ago - no repair performed
				"repairTrigger":{  - repair triggers
					"OnActivation":false, - if true repairing will be committed on component on component activation
					"OnDamage":"InstalledLocation", - control on damage repair activation
                        Supported values: "None","AllUnit","InstalledLocation"
					"AtEndOfTurn":true - repair attempt making every turn. Combined with OnDamage setting
                                        if OnDamage = None repair every turn
                                          "AllUnit" - repair only if this turn damage was inflicted
                                          "InstalledLocation" - repair only if this turn damage to location component installed (for meches both front and rear armor locations counts) was inflicted
                                          NOTE: destroyed locations can't be repair. 
                                          NOTE: in fact repairing done at turn begin (counts damage inflicted previous turn)
                                          NOTE: if AtEndOfTurn - false repair can only performed on activation. If OnActivation - false too component is useless.
				}
			},
      "Linkage":{ - linked components info
        "OnActivate":{  
          "Activate":[],
          "Deactivate":["ECM"] - array of ButtonName's 
        },
        "OnDeactivate":{
          "Activate":[],
          "Deactivate":[]
        },
      },
      NOTE! Components activated by link counts as auto-activated and not suffer activation fail roll/
      NOTE! You can create link structure as complicated as you want, but if you create cycle you encounter stack overflow exception. Use this feature wisely.
	
			"statusEffects": [  - status effect applied on activation. Same rules as for other component's passive effects. 
				{
					"durationData" : {
						"duration" : -1,
						"ticksOnActivations" : false,
						"useActivationsOfTarget" : false,
						"ticksOnEndOfRound" : false,
						"ticksOnMovements" : false,
						"stackLimit" : -1,
						"clearedWhenAttacked" : false
					},
					"targetingData" : {
						"effectTriggerType" : "Passive",
						"triggerLimit" : 0,
						"extendDurationOnTrigger" : 0,
						"specialRules" : "NotSet",
						"effectTargetType" : "Creator",
						"range" : 0,
						"forcePathRebuild" : true,
						"forceVisRebuild" : false,
						"showInTargetPreview" : false,
						"showInStatusPanel" : true
					},
					"effectType" : "StatisticEffect",
					"Description" : {
						"Id" : "StatusEffect-MASC-WalkSpeedDouble",
						"Name" : "MASC DOUBLE SPEED",
						"Details" : "Speed doubled",
						"Icon" : "uixSvgIcon_equipment_Gyro"
					},
					"nature" : "Buff",
					"statisticData" : {
						"appliesEachTick" : false,
						"effectsPersistAfterDestruction" : false,
						"statName" : "WalkSpeed",
						"operation" : "Float_Multiply",
						"modValue" : "2.0",
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
				},
				{
					"durationData" : {
						"duration" : -1,
						"ticksOnActivations" : false,
						"useActivationsOfTarget" : false,
						"ticksOnEndOfRound" : false,
						"ticksOnMovements" : false,
						"stackLimit" : -1,
						"clearedWhenAttacked" : false
					},
					"targetingData" : {
						"effectTriggerType" : "Passive",
						"triggerLimit" : 0,
						"extendDurationOnTrigger" : 0,
						"specialRules" : "NotSet",
						"effectTargetType" : "Creator",
						"range" : 0,
						"forcePathRebuild" : true,
						"forceVisRebuild" : false,
						"showInTargetPreview" : false,
						"showInStatusPanel" : true
					},
					"effectType" : "StatisticEffect",
					"Description" : {
						"Id" : "StatusEffect-MASC-RunSpeedDouble",
						"Name" : "MASC DOUBLE SPEED",
						"Details" : "Speed doubled",
						"Icon" : "uixSvgIcon_equipment_Gyro"
					},
					"nature" : "Buff",
					"statisticData" : {
						"appliesEachTick" : false,
						"effectsPersistAfterDestruction" : false,
						"statName" : "RunSpeed",
						"operation" : "Float_Multiply",
						"modValue" : "2.0",
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
	},

  
  AURAS RELATED SETTINGS
  Hotkey - you can use LCtrl + A to switch auras circles visibility. By default only auras with HideOnNotSelected: false is show. Default -> LCtrl+A -> Hide all auras -> LCtrl+A -> Show all auras (even with HideOnNotSelected: true) 
COMPOPNENT 
  Auras array can be defined in components (allowed component types Update, Weapon) and abilities
  for auras defined in ability "State" have no meaning - aura acts same way if "State" is "Persistent"
  "Auras": [
    {
      Note! Aura can be defined in separate json. AuraDef in manifest. To point parsing engine Aura content should be loaded from
	  external json left only Id in component/ability you want to use 

	  "Id": "Gear_Sensor_Prototype_EWE_Aura_ECM", - Id should be unique per component definition. 
                                                    If Id set as "AMS" and component is weapon than Range is tied to weapon MaxRange and reticle is only shown if weapon is enabled and in AMS mode. 
                                                    Look at CustomAmmoCategories/weapon/Weapon_MachineGun_AMS_3-Hydra.json it defines empty aura not applying any effects just for colored circle showing range. 
      "TrackAcivation":false,                     - if true aura is active only if aura carrier is active.
	                                                unit counted as active when
													 1. Player can control unit current phase and selected this unit in HUD
													 2. Unit started to execute orders (player's or AI's) and not done yet
	  "MinefieldDetector": false                  - if true aura is used as minefield detector. Basic sensors have this forced true other auras default false. 
	  "LineType": "Dashes"                        - Line type of range circle. Possible values
                                                          Dashes - default. Looks as previous
                                                          Dots - looks like active probe range indicator
      "isSpining": false                          - if true range circle is spinning. Can be applied both Dashes and Dots line types                                   
      "Name": "ECM",                              - Name used in UI
      "ReticleColor": "#00f2ff",                  - Color of circle for aura
      "Range": 100,                               - aura effect radius
      "RangeStatistic":""                         - unit's statistic name used to inflict aura range at runtime
      "RemoveOnSensorLock": true,                 - if true all aura effects will be removed if unit become sensor locked
      "NotApplyMoving": false,					  - if true all aura effects
	                                                     1. will not apply to target when target goes to aura range if target moved this round
														 2. will be removed from target at end of move if target still in aura range
														 3. will be applied to target at target activation if not applied previously 
														 4. will be applied to target at the end of target activation if target had not been moved and not applied previously
														 summary: if target is in aura range effect will exist only if target not moving during activation
      "ApplyOnlyMoving": false,                   - if true all aura effects
	                                                     1. will not apply to target when target goes to aura range if target not moved this round
														 2. will be applied to target at end of move if target still in aura range
														 3. will be removed from target at target activation
														 4. will be removed from target the end of target activation if target had not been moved
														 summary: if target is in aura range effect will exists from movement end till next activation
      "State": "Online",                          - Settings describing relationship with component activation state.
                                                    Possible values: Online/Offline/Persistent
                                                    Online - aura enabled if component is actived
                                                    Offline - aura enabled if component is deactivated
                                                    Persistent - aura no matter component activation state
      "HideOnNotSelected": false,                 - if true aura circle will be hidden while unit not selected. True by default
      "FloatieAtEndOfMove": true,                 - if true floatie will be shown at end of move (jump) instead of aura collide. Default true.
                                                    NOTE: this feature works only in combat movement style, only for floaties (VFXes playing and effects applying still at collide) and only floaties emitted by aura itself.
      "ApplySelf": true,                          - if true aura effects will be applied to component's owner
              Next variables is used to make AI and preview calculations faster. 
              their values not tied to actual effects. They just should be set correct by moder to make AI and preview calculations correct.
      "AllyStealthAffection": "PositiveOne",      - affect to stealth charges. Possible values: None, Nullify, PositiveOne, PositiveTwo, PositiveThree, PositiveFour, PositiveFive, NegativeOne, NegativeTwo, NegativeThree, NegativeFour, NegativeFive
      "EnemyStealthAffection": "None",            - affect to stealth charges. Possible values: None, Nullify, PositiveOne, PositiveTwo, PositiveThree, PositiveFour, PositiveFive, NegativeOne, NegativeTwo, NegativeThree, NegativeFour, NegativeFive
      "IsPositiveToAlly": true,                   - next variables have names telling about their functions. Used by AI
      "IsNegativeToAlly": false,
      "IsNegativeToEnemy": false,
      "IsPositiveToEnemy": false,
	  "neededTags": [ "C3_slave" ],              - list of encounter tags unit should have for aura to be applied. 
	                                               See Encounter tags by statistic effect section for more detail and notes
	  "neededOwnerTags": [ "fancy_tag_name" ],   - list of encounter tags owner unit should have for aura to be working.
	                                               if owner does not have needed tags aura's effective radius counted as 0
												   once owner get all tags from list aura's effective radius stars to grow up to Range
												   if aura carrier state and source component state allow it. 
      "onlineVFX": [                             - static aura effects. Playing if aura active. Linked to aura carrier.
        {
          "VFXname": "vfxPrfPrtl_ECM_loop",      - vfx name
          "scale": true,                         - if true effect will be scaled by range
          "scaleToRangeFactor": 100              - to range scale. actual scale = Range/scaleToRangeFactor
        }
      ],
      "targetVFX": [                            - oneshot vfxes played when aura affects unit
        "vfxPrfPrtl_ECMtargetAdd_burst"
      ],
      "removeTargetVFX": [                      - oneshot vfxes played when unit lives aura
        "vfxPrfPrtl_ECMtargetRemove_burst"
      ],
      "ownerSFX": [                             - sound effect played at aura owner when someone enter aura
        "AudioEventList_ui_ui_ecm_start"
      ],
      "targetSFX": [                            - sound effect played at unit entering aura
        "AudioEventList_ecm_ecm_enter"
      ],
      "removeOwnerSFX": [                       - sound effect played at aura owner when someone leave aura
        "AudioEventList_ui_ui_ecm_stop"
      ],
      "removeTargetSFX": [                      - sound effect played at unit leaving aura
        "AudioEventList_ecm_ecm_exit"
      ],
      "statusEffects": [                        - list of status effects applied upon entering aura range
        {
          "durationData": {
            "duration": -1,
            "stackLimit": 1
          },
          "targetingData": {
            "effectTriggerType": "Passive",     - trigger should be passive
            "specialRules": "NotSet",           - should be NotSet
            "effectTargetType": "AlliesWithinRange",    - values: AlliesWithinRange, EnemiesWithinRange
            "range": 0.0,                               - not used
            "forcePathRebuild": false,
            "forceVisRebuild": false,
            "showInTargetPreview": false,
            "showInStatusPanel": false
          },
          "effectType": "StatisticEffect",
          "Description": {
            "Id": "ECMEffect_IndirectImmunityAura",
            "Name": "ECM MISSILE DEFENSE",
            "Details": "Friendly units within an ECM field gain +[AMT] Difficulty to missile attacks against them and immunity to Indirect Fire. Being Sensor Locked removes this effect.",
            "Icon": "uixSvgIcon_status_ECM-missileDef"
          },
          "statisticData": {
            "statName": "IsIndirectImmune",
            "operation": "Set",
            "modValue": "true",
            "modType": "System.Boolean"
          },
          "nature": "Buff"
        },
        {
          "durationData": {
            "duration": -1,
            "stackLimit": 1
          },
          "targetingData": {
            "effectTriggerType": "Passive",
            "specialRules": "NotSet",
            "effectTargetType": "AlliesWithinRange",
            "range": 0.0,
            "forcePathRebuild": false,
            "forceVisRebuild": false,
            "showInTargetPreview": true,
            "showInStatusPanel": true
          },
          "effectType": "StatisticEffect",
          "Description": {
            "Id": "ECMEffect_MissileDefense",
            "Name": "ECM MISSILE DEFENSE",
            "Details": "Friendly units within an ECM field gain +[AMT] Difficulty to missile attacks against them and immunity to Indirect Fire. Being Sensor Locked removes this effect.",
            "Icon": "uixSvgIcon_status_ECM-missileDef"
          },
          "statisticData": {
            "statName": "ToHitThisActorMissile",
            "operation": "Float_Add",
            "modValue": "4.0",
            "modType": "System.Single"
          },
          "nature": "Buff"
        },
        {
          "durationData": {
            "duration": -1,
            "stackLimit": 1
          },
          "targetingData": {
            "effectTriggerType": "Passive",
            "specialRules": "NotSet",
            "effectTargetType": "AlliesWithinRange",
            "range": 0.0,
            "forcePathRebuild": false,
            "forceVisRebuild": true,
            "showInTargetPreview": false,
            "showInStatusPanel": false
          },
          "effectType": "StatisticEffect",
          "Description": {
            "Id": "ECMStealth_GhostEffect_Allies",
            "Name": "STEALTH CHARGE",
            "Details": "Units within an ECM field gain a Stealth Charge and cannot be targeted.\n\nFiring a weapon, using an activated ability, or an enemy penetrating the ECM field removes a Stealth Charge. Being Sensor Locked removes all Stealth Charges.",
            "Icon": "uixSvgIcon_status_ECM-ghost"
          },
          "statisticData": {
            "statName": "GhostEffectStacks",
            "operation": "Int_Add",
            "modValue": "1",
            "modType": "System.Int32"
          },
          "nature": "Buff"
        }
      ]
    },  

    
GLOBAL SETTINGS 
Idea that unit inflicts all enemy units protected by ECM just standing in ECM range is looks insane and illogical to me.
So original counter ECM behaviour is changed. All units have sensors aura not connected to component. This aura is used to counter ECMs.
All enemies in this aura receive penalty to stealth charges.
Sensors aura is defined at CAE settings.
It have same definitions as component aura described above
    "sensorsAura":{
      "ReticleColor" : "white",
      "Id": "Sensors",
      "Name": "Sensors",
      "Range": 60,
      "RangeStatistic" : "CAE_SENSORS_RANGE",
      "ApplySelf": false,
      "EnemyStealthAffection": "NegativeOne",
      "IsNegativeToEnemy": true,
      "ownerVFX": [ ],
      "targetVFX": [ ],
      "removeOwnerVFX": [ ],
      "removeTargetVFX": [ ],
      "ownerSFX": [ ],
      "targetSFX": [ ],
      "removeOwnerSFX": [ ],
      "removeTargetSFX": [ ],
      "statusEffects" : [
        {
          "durationData" : {
                "duration": -1,
                "stackLimit": 1
            },
            "targetingData" : {
                "effectTriggerType" : "Passive",
                "specialRules" : "NotSet",
                "effectTargetType" : "EnemiesWithinRange",
                "range" : 0.0,
                "forcePathRebuild" : false,
                "forceVisRebuild" : true,
                "showInTargetPreview" : false,
                "showInStatusPanel" : false
            },
          "effectType" : "StatisticEffect",
          "Description" : {
            "Id" : "ECMStealth_SensorsEffect",
            "Name" : "ECM CARRIER",
            "Details" : "",
            "Icon" : ""
          },
          "statisticData" : {
            "statName" : "GhostEffectStacks",
            "operation": "Int_Add",
            "modValue": "-1",
            "modType": "System.Int32"
          },
          "nature" : "Buff"
        }        
      ]
    }
	},


C3 implementation

if unit have at least one tag from C3NetworkEncounterTags in its encounter tags, its RANGE (and only RANGE) to-hit modifier will be calculated differently
Math:
code will iterate all allies of current unit and search for unit closest to target having at least one C3 encounter tag same as current unit.
example:
 C3NetworkEncounterTags: "C3_network_a", "C3_network_b"
 unit A: have "C3_network_a"
 unit B: have "C3_network_b"
 unit C: have "C3_network_a", "C3_network_b"
 unit D: have "C3_network_b"
while detecting RANGE modifier for unit A only unit C will be tested
while detecting RANGE modifier for unit B units C and D will be tested
while detecting RANGE modifier for unit C units A, B and D will be tested 
Eg. there are two types of C3 networks - "C3_network_a", "C3_network_b", network A units A and C, network B units B,C and D
When closest unit found its distance to target (C3-distance) is used to calculate RANGE instead of current unit distance(original distance).
Exceptions: 
1. C3-distance should be less than original distance, if not original distance will be used
2. C3-distance less than minimal weapon range, C3-distance is counted equal to weapon min range. Eg short range modifier will be used.

NOTE even if RANGE modifier is 0 it is still will be added to list of weapon modifiers in case C3-distance is used for calculation.

Encounter tags by statistic effect

you can add or remove unit encounter tag by applying statistic effect
Statistic name should be "ADD_ENCOUNTER_TAG_<encounter tag name>"
"ADD_ENCOUNTER_TAG_<encounter tag name>" is float, default 0
if value is greater than 0 tag will be added if less or equal removed.

!!!NOTE!!!
if you are using Abilifier to limit effects appliance by encounter tags you should note 
Abilifier does no handle encounter tags dynamic nature. 
Example you have component applying passive bonus A only if encounter tag B is set.
encounter tag B added by passive statistic effect by component C.
If component C is installed before A - most things is ok, component C will be processed before A 
and add encounter tag B before component A processing. Bonus will be applied. 
But if component C installed after component A, on processing component A, unit will not have encounter tag B, bonus will be skipped.
Even if bonus applied correctly on component C destruction tag B will be removed, but bonus will remain still cause does not handle encounter tag removal.
Same story if component C adds tag B as activatable. Bonus will not be applied cause activatables processed after passive components.

That is why only method correctly working in dynamic is - made "ADD_ENCOUNTER_TAG_<encounter tag name>" as activatable and tag bonus itself as
aura with proper "neededTags" setting. Aura effect will be applied or removed according encounter tags even if changed.
Also it is very bad idea to apply encounter tags needed for aura to be have an effect by another aura. 
Only safe place for it is activatable section. 

You can make aura lowering "ADD_ENCOUNTER_TAG_<tag from C3NetworkEncounterTags>" statistic to simulate counter C3 electronic 