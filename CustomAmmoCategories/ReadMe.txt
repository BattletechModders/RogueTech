Unpack to Mods folder

Settings 
CustomAmmoCategoriesSettings.json

{
"debugLog":true, - enable debug log 
"modHTTPServer":false, - enable debug http server
"modHTTPListen":"http://localhost:65080" - debug http server url, if enabled
}

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
  "DisableClustering": true/false - if true ProjectilesPerShot > 1 will affect only visual nor damage. If omitted consider as true.
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
		"DistantVarianceReversed": false, - Set is distance damage variance is reversed
		"Cooldown": 2, - number of rounds weapon will be unacceptable after fire this mode
		"AIHitChanceCap": 0.3, - AI will choose mode with minimal delta |current toHit with this mode - AIHitChanceCap|
		"DamageOnJamming": true/false, - if true on jamm weapon will be damaged
		"DamageMultiplier":2.0, - damage multiplier for this mode effective value will be Weapon.DamagePerShot*Ammo.DamageMultiplier*Mode.DamageMultiplier rounded
									to nearest integer. If omitted assumed to be 1.0
		"AlwaysIndirectVisuals": false, if true missiles will always plays indirect visuals, even if direct line of sight exists
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
   "AlwaysIndirectVisuals": false, if true missiles will always plays indirect visuals, even if direct line of sight exists
   "HeatGeneratedModifier" : 1,
   "ArmorDamageModifier" : 1,
   "ISDamageModifier" : 1,
   "CriticalDamageModifier" : 1,
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
