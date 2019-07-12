to invoke activation dialog ctrl+click on move button in mech HUD. 
to invoke heat sinks manipulation dialog ctrl+click on brace (shield) button in mech HUD. 
   heat sinks manipulation limitations: you can switch on and off only dedicated heat sinks not engine internal ones
   
AI can activate component if it have correct tags
AI related tags:
	cae_ai_offence - component provides damage and/or accuracy boost
    cae_ai_defence - component provides defence boost
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
	
    "Custom":{
		"Category" : [ {"CategoryID" : "Activatable"}, {"CategoryID" : "MASC"}], 
		"ActivatableComponent":{
			"ButtonName":"MASC",  - string used in activation/deactivation dialog button. Keep as sort as possible. 
			"FailFlatChance":0.3, - chance of fail on cold activation. 
			"FailRoundsStart":1, - round since fail checks will be perfomed
			"FailChancePerTurn":0.5, - value which added to fail chance every round of activity.
			                        Fail mechanic notes: on battle start each active component's <FailChance> setted to FailFlatChance.
									On activation component will have <FailChance> to fail, than every time at end of moving sequence since FailRoundsStart round (activation round count as 0) 
									component will have check with <FailChance> to fail.
									Every end of round <FailChance> increasing by FailChancePerTurn if component is in active state or decreasing by FailChancePerTurn if not.
									If <FailChance> become less than FailFlatChance it tied to FailFlatChance.
			"FailISDamage":10,  - Damage to inner structure on fail
			"FailCrit":true, - if true fail inflicts critical rolls.
			"SelfCrit": false - if true make crit hit to self.
			"FailDamageLocations":["LeftLeg","RightLeg"], - list of locations to crit rolls. 
			                              Avaible values Head,LeftArm, LeftTorso , CenterTorso,RightTorso,RightArm,LeftLeg,RightLeg. ONLY this values.
							Fail damage notes: if FailCrit is true crit is always inflicted. Random roll is just for component. 
							Crits hits only occupied slots (instead of vanilla logic) no matter if component is destroyed. 
							So have lone ammo boxes in FailDamageLocations without other crit-traps is a bad idea as showed in demo video.
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
			"AutoDeactivateOnOverheatLevel": 0.8, same as AutoDeactivateOnHeat but instead of Heat level used persentage of Overheat
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
        NOTE! look in Gear_EngineCore, Gear_EngineType example to realise how component's AoE explosion status effects can be controlled 
         
			}, 			
							NOTE: parent unit owner of component is not affected. Only other combatants. So component owner is not have to be destroyed or damaged at all. On other modders concern.
							      Damage value calculation have same rules as CAC AoE damage.
			"ExplodeOnFail": false, - if true Explode will be activated on component activation fail
			"ExplodeOnDamage": false - if true Explode will be activated on component destruction
			"ActiveByDefault": false - if true component will be activated on combat start with no fail roll
			"ExplodeOnSuccess": false - if true component will explode on success activation
			"EjectOnFail": false - if true pilot will eject BEFORE damage applience on fail activation roll
			"EjectOnSuccess": false - if true pilot will eject BEFORE effects applience on success activation roll
			"EjectOnActivationTry": false - if true pilot will be ejected before roll check
								NOTE: Please keep in mind that all status efeects will be canseled on unit destruction. Ejection counts as destruction too.
								If you want to keep unit statistic after component/mech destruction you have to set "effectsPersistAfterDestruction" : true
								It is really neaded by components altering explosion stats cause do mech destruction they returned to default state which is usualy unwanted
      "offlineStatusEffects": [], - effects applying on component switch off. They removed if component will be switched on. If component have no ActiveByDefault - applying on combat start
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
