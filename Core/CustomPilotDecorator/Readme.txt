this simple mod allowing you to add some decoration to pilot's slots in roster
1. it allows to display more than 3 abilities
2. it allows allow to add icons and descriptions to abilities list and after name
to add icon you should create PilotDecorationDef entry to manifest 
{
	"Description": {
		"Id": "pilotdecorationdef_can_drive_mech",
		"Name": "CAN DRIVE MECHS",
		"Details": "This pilot can drive mechs of all types",
		"Icon": "can_drive_mech"
	},
	"Type":"Shevron",    - two possible values "Shevron" and "Ability". 
	                       If "Ability" icon will be added to abilities list,
						   if "Shevron" icon will be added after callsign 
	"ShouldHaveTags": [ ] - list of tags pilot should have to display icon
	"ShouldNotHaveTags": [ "pilot_nomech_crew" ] - list pf tags pilot should not have to display icon
}