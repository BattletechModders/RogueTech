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
	"Id":"LGAUSS", - имя новой категории, может быть любым 
	"BaseCategory":"GAUSS" - имя базовой категории, должно быть из перечня (AC2/AC5/AC10/AC20/GAUSS/Flamer/AMS/MG/SRM/LRM), 
	                         необходимо для обеспечения обратной совместимости. 
	                         Все остальные механизмы игры, за исключением подсчетам оставшихся патронов в бою и соотвествия оружия и амуниции в мехлабе.
},
]

Weapon definition
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
   "AccuracyModifier" : -10.0, будет сложено с соотвествующи модификатором оружия
   "CriticalChanceMultiplier" : 0.0, будет сложено с соотвествующи модификатором оружия
   "DamagePerShot": -50.0, будет сложено с соотвествующи модификатором оружия
   "AIBattleValue":90, используется ИИ для выбора оружия. ИИ использует для выстрела из данного оружия боеприпас с большим значением из доступных
   "ShotsWhenFired" : 0, будет сложено с соотвествующи модификатором оружия
   "ProjectilesPerShot" : 0, будет сложено с соотвествующи модификатором оружия
   "HeatDamagePerShot": 0.0, будет сложено с соотвествующи модификатором оружия
   "HeatGenerated" : 0,
   "HeatGeneratedModifier" : 1,
   "ArmorDamageModifier" : 1,
   "ISDamageModifier" : 1,
   "CriticalDamageModifier" : 1,
   "statusEffects" : [   - будет применено при попадании
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