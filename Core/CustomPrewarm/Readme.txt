CustomPrewarm have a mechanic to remove records from CompanyStats for items with 0 count. 
if for certain item ids or types it is unwanted there is blacklisting mechanism 
to YOUR mod you should add "ItemsCountSanitizeBlackListDef" record to a mod.json manifest
example
	"Manifest": [
			{
					"Type": "ItemsCountSanitizeBlackListDef",
					"Path": "blacklist"
			}
	]

also good idea is to add "ItemsCountSanitizeBlackListDef" to "CustomResourceTypes" list of YOUR mod's mod.json
example 
 "CustomResourceTypes": [ "ItemsCountSanitizeBlackListDef" ]
it does not require your mod to really process ItemsCountSanitizeBlackListDef but allows ModTek to load your mod.json
properly even without CustomPrewarm but it is on your concentration. 

ItemsCountSanitizeBlackListDef example

{
	"blacklistedIds":[  - list of ids not allowed to sanitize - will be kept even if value <= 0
		"Gear_Attachment_LaserInsulator"
	],
	"blacklistedTypes":[ - list of types not allowed to sanitize
	]
}

in CompanyStats items count records stored as Item.<item type>.<item id>[.<damaged state>]
for example 
Item.UpgradeDef.Gear_Attachment_LaserInsulator