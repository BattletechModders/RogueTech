# BiggerDrops
<pre>
Settings 
{
  "debugLog": true, - debug log, log is small most time at contract init, no performance impact, assumed to be true by default
  "additionalLanceName": "EXTRA LANCE", - name of additional lance at drop UI, for localization compatibility in future 
  "additinalMechSlots": 4, - number of additional mech slots, if grater than 4 assumed to be 4
  "additinalPlayerMechSlots": 4, - number of additional slots for direct player control, can't be grater than additinalMechSlots.
                              Example: additinalMechSlots = 3, additinalPlayerMechSlots = 1. You will get 3 available slots at drop UI. 
                              At battle start you will be able to control 5 meches (4+1) directly (5 portraits) and additional employer's lance friendly AI controlled with 2 meches.
  "defaultMaxTonnage": 800, - max tonnage by default, if contract not overriding it.
}
</pre>