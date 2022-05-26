# ContractLanceRandomizer

Several Flashpoints assign specific 'Mechs to the player that they must use during a contract.  This mod allows for assigning random 'Mechs based on tags set in the contract.json.

## Requires

ModTek or Modlauncher.

## Configuration

Update the entries in the contract.json under "player1Team.lanceOverrideList[x].unitSpawnPointOverrideList[x]".  Set "unitDefID" to "Tagged"; this will trigger the code to find a random 'Mech for this slot.  Add tags to "unitTagSet" and "unitExcludedTagSet" as required.

For example, to update a player 'Mech from the assgined UM-R60 to a random UrbanMech, change
	"unitDefId" : "mechdef_urbanmech_UM-R60",
	"unitTagSet" : {
		"items" : [],
		"tagSetSourceFile" : "tags/UnitTags"
	}
to
	"unitDefId" : "Tagged",
	"unitTagSet" : {
		"items" : [
			"unit_urbie"
		],
		"tagSetSourceFile" : "tags/UnitTags"
	}