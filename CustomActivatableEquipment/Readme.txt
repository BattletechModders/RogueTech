to invoke activation dialog ctrl+click on move button in mech HUD. 
to invoke heat sinks manipulation dialog ctrl+click on brace (shield) button in mech HUD. 
   heat sinks manipulation limitations: you can switch on and off only dedicated heat sinks not engine internal ones
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
			                             NOTES: component with AutoActivateOnHeat > 0 can't be activated or deactivated maually
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
