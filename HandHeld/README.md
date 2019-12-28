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

## Settings

`"CarryWeightFactor" : "0.05"`
base allow carry weight - 5% of mech tonnage

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

```
"WrongWeightMessage" : "{1:0.00}t requre to carry {0}, {2:0.00} left free",
"TwoHandMissed" : "Mech need two free hand actuators to use {0}",
"OneHandMisse" : "Mech need one free hand actuators to use {0}"
```
Error messages shown in mechlab when try to equip wrong handheld item

`"LocationLabel" : "HandHeld {0:0.00}/{1:0.00}t` 
Text for handheld widget {0} - used tonnage, {1} - avaliable tonnage 

`"Debug_IgnoreWeightFIlter" : false,`
when set to true not filter avaliable handhelds by tonnage