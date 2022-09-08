note on API
/listhangar - GET - list current bays content
/addmechfromfile - POST json - add mech to bay
		{
			"bayIndex": 0 - zero based index of bay slot
			"mechDef": {} - mech definition
		}
/addvehiclefromfile - POST json - add vehicle to bay
		{
			"bayIndex": 0 - zero based index of bay slot
			"vehicleDef": {} - mech definition
		}
/addmechfromdb - POST json - add mech to bay
		{
			"bayIndex": 0 - zero based index of bay slot
			"mechDefId": "<id>" - existing mech definition id
		}
/getmechlabmech - POST json - get current opened in mechlab mech as definition
		{
			"Id": "<id>" - set id for your new mech (if ommited value got from original definition)
			"Name": "<id>", - set name for your new mech (if ommited value got from original definition)
			"Details": "<id>",  - set details for your new mech (if ommited value got from original definition)
			"Icon": "<id>", - set icon for your new mech (if ommited value got from original definition)
			"Rarity": "<id>",  - set rarity for your new mech (if ommited value got from original definition)
		}
/addallequipment - POST json - add all available equipment to inventory
		{
			"count":20 - count for each item
		}
/getavaiblelists - GET - returns all available database lists for reading

/uisettings - POST json - store file can be got as /ui/settings.json

/openmechlab - POST json - force open specified mech in mechlab
	{
		"mechDef": "<id>" - NOTE it is an ID of existing mech
	}
/list/<list name> - GET - view item's ids of list (list names can be get from /getavaiblelists)

/get/<list name>/<item id> - GET - get json of an item

/set/<list name> - POST json - update database, write specified json to database (not all lists available for writing: can be used chassisDefs,mechDefs,vehicleDefs,vehicleChassisDefs,turretChassisDefs,ammoDefs,ammoBoxDefs,HeatSinkDefs,hardpointDataDefs,upgradeDefs,weaponDefs)

/view/<BattleTechResourceType> - GET - view item's ids of list (list names can be get from /getavaibleres)

/getavaibleres - GET - returns all available database lists for reading

/reload/<BattleTechResourceType>/<Id> - GET reload specific definition from file system  (not all types available for reloading - ChassisDef,VehicleChassisDef,TurretChassisDef,TurretDef,AmmunitionDef,AmmunitionBoxDef,JumpJetDef,HeatSinkDef,BattleTechResourceType.UpgradeDef,WeaponDef,HardpointDataDef,VehicleDef,MechDef supported)

/ui/* - GET - file from <mod dir>/ui

/ - GET - file <mod dir>/ui/index.html

/BattleTechResourceType - GET - list available manifest resource types

/Manifest/<BattleTechResourceType> - GET - list resources of <BattleTechResourceType> from manifest

/LoadManifest/<BattleTechResourceType> - GET - force loading resources of desired type to data manager
	                                   NOTE! resources content can be get by /get/<list name>/<item id> invocation available only after loading to data manager
									   either by loading save, opening skirmish mechbay or forcing it to load via this API
