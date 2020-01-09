# HandHeld

This mod allow use of HandHeld and TSMInfo custom for implement HandHeld weapon

## HandHeld

this custom component mark item as hand held and set it parameters
```
"HandHeld" : {
	"Tonnage" : 5,	// tonnage of item
	"HandsUsed" : 2 // how many hand actuators item use 
}
```

## TSMInfo
```
"TSMInfo" : {
	"HandHeldFactor" : 2 // Allow to change avaliable carry weight for Mech, buy TT rules tsm doubles carry weight
}
```
if this custom used on item TSMTags will be ignored

## HandHeldDefault
```
"HandHeldDefault" : {
	"Item2H_ID" : "Gear_HandHeld_Default_2",
	"TypeH" : "Upgrade"
}

"HandHeldDefault" : {
	"Item2H_ID" : "Gear_HandHeld_Default_2",
	"TypeH" : "Upgrade",
	"Item1H_ID1" : "Gear_HandHeld_Default_0",
	"Type1" : "Upgrade",
}


"HandHeldDefault" : {
	"Item1H_ID1" : "Gear_HandHeld_Default_0",
	"Type1" : "Upgrade",
	"Item1H_ID2" : "Gear_HandHeld_Default_1",
	"Type2" : "Upgrade"
}

"HandHeldDefault" : {
	"Item1H_ID1" : "Gear_HandHeld_Default_0",
	"Type1" : "Upgrade"
}
```
Chassis custom which et defaults for handhelds. Item1H_ID1/2 = for first/second 1h slot. Item2H_ID - for 2hand slot.  Type1/2/H - set type of default item. if "Upgrade" - can be skipped.

if Item2H_ID and Item1H_ID1 set - Item1H_ID1 will be used when other 1h item installed, other way HandHeldSlotItemID will be used.
if both Item1H_ID1 and Item1H_ID2 set - Item1H_ID2 is first candidate for replace. 
if Item1H_ID2 not set - second slot will be HandHeldSlotItemID, which will be replaced first
if Item1H_ID1 not set while Item1H_ID2 set - Item1H_ID2 will be replac first leaving HandHeldSlotItemID for second item

## Settings

`"CarryWeightFactor" : "0.1"`
base allow carry weight - 10% of mech tonnage. One hand items can use only half of this.

```
"TSMTags" : [
	{ "Tag" : "TSM", "Mul" : 2 }
],
```
Allow define items which change carryweigh by component tag or categoryid. only first found tag or categoryid will be used. 
`"MultiplicativeTonnageFactor" : true`
how calculate tonnage factor - by default multiplicative so 2 items with 1.5 Mul give 2.25 total increase. with false - 2 (additive) 

`"UseHandTag" : true`
`"HandsItemTag" : "Hand"`
when set to false use MechEngeneer ArmActuator custom to define hands. When se to true use HandsItemTag. HandsItemTag is component tag only.

`"HandHeldSlotItemID" :"Gear_HandHeld_Slot"`
default item used as empty slot if mech have not preset defaults

```
"WrongWeightMessage" : "{0} weight {1:0.00}t, mech can carry up to {2:0.00}t items",
"WrongWeightMessage1H" : "{0} weight {1:0.00}t, mech can carry up to {2:0.00}t items in one hand",
"TwoHandMissed" : "Mech need two free hand actuators to use {0}",
"OneHandMisse" : "Mech need one free hand actuators to use {0}"
```
Error messages shown in mechlab when try to equip wrong handheld item

`"LocationLabel" : "HandHeld {0:0.00}/{1:0.00}t` 
Text for handheld widget {0} - used tonnage, {1} - avaliable tonnage 

`"Debug_IgnoreWeightFIlter" : false,`
when set to true not filter avaliable handhelds by tonnage