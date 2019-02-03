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
},
]

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
   
   "AIBattleValue":90,
   "DamagePerShot": -50.0,
   "HeatDamagePerShot": 0.0,
   
   "WeaponEffectID" : "WeaponEffect-Weapon_PPC", Played fire effect can be set in ammo definition, for example this LBX AC10 will fire as PPC if ECM ammo is choosed
   "EvasivePipsIgnored" : 0, Effective EvasivePipsIgnored will be Weapon.EvasivePipsIgnored + Ammo.EvasivePipsIgnored (current weapon status effects will be used too)
   
   "AccuracyModifier" : -10.0, Effective AccuracyModifier will be Weapon.AccuracyModifier + Ammo.AccuracyModifier (current weapon status effects will be used too)
   "CriticalChanceMultiplier" : 0.0, Effective AccuracyModifier will be Weapon.CriticalChanceMultiplier + Ammo.CriticalChanceMultiplier (current weapon status effects will be used too)
   "DamagePerShot": -50.0, Effective DamagePerShot will be Weapon.DamagePerShot + Ammo.DamagePerShot (current weapon status effects will be used too)
   "AIBattleValue":90, used for AI. It will use ammo with highest AIBattleValue on depletion switch to next 
   "ShotsWhenFired" : 0, Effective ShotsWhenFired will be Weapon.ShotsWhenFired + Ammo.ShotsWhenFired (current weapon status effects will be used too)
   "ProjectilesPerShot" : 0, Effective ProjectilesPerShot will be Weapon.ProjectilesPerShot + Ammo.ProjectilesPerShot (current weapon status effects will be used too)
   "HeatDamagePerShot": 0.0, Effective HeatDamagePerShot will be Weapon.HeatDamagePerShot + Ammo.HeatDamagePerShot (current weapon status effects will be used too)
       
   "MinRange": 0.0, Effective MinRange will be Weapon.MinRange + Ammo.MinRange (current weapon status effects will be used too)
   "MaxRange": 0.0, Effective MinRange will be Weapon.MaxRange + Ammo.MaxRange (current weapon status effects will be used too)
   "ShortRange": 0.0, Effective ShortRange will be Weapon.ShortRange + Ammo.ShortRange (current weapon status effects will be used too)
   "MiddleRange": 0.0, Effective MiddleRange will be Weapon.MiddleRange + Ammo.MiddleRange (current weapon status effects will be used too)
   "LongRange": 0.0, Effective LongRange will be Weapon.LongRange + Ammo.LongRange (current weapon status effects will be used too)
         NOTE: Range modifications not always displays correctly while viewing shooting arc, but hit chance and possibility calculated normally. 
		 
   "HeatGenerated" : 0, Effective HeatGenerated will be Weapon.HeatGenerated + Ammo.HeatGenerated (current weapon status effects will be used too)
   "RefireModifier" : 0, Effective RefireModifier will be Weapon.RefireModifier + Ammo.RefireModifier (current weapon status effects will be used too)
   "Instability" : 0, Effective Instability will be Weapon.Instability + Ammo.Instability (current weapon status effects will be used too)
   "AttackRecoil" : 0, Effective AttackRecoil will be Weapon.AttackRecoil + Ammo.AttackRecoil (current weapon status effects will be used too)
   
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