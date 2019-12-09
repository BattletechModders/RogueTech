# Charles B

Make BattleTech mechs fall down when they miss because that's funny.


##
BattleTech Mod that adds instability/knockdown when a melee attack misses.

## Features

- when melee'ing and miss, add some instability
- when melee'ing and legged and miss, add a different amount of instability
- when DFA'ing, add some additional instability on a miss
- when DFA'ing and attacker is legged (WHHHHHY would you choose this), even more instability 
- get knocked down if you enough instability, even if not unsteady before the attack 
- piloting skill can mitigate these additional instability points
- DFA leg damage and instability damage can be mitigated by piloting level

## Download
Devoured by CustomAmmoCategories

## Install
Devoured by CustomAmmoCategories

## Settings

Setting | Type | Default | Description
--- | --- | --- | ---
`attackMissInstability` | `bool` | `true` | enable/disable instability to the attacker when a melee strike misses
`attackMissInstabilityPercent` | `int` | `30` | the percentage of your stability bar that is filled when a mech misses a melee attack
`attackMissInstabilityLeggedPercent` | `int` | `70` | the percentage of your stability bar that is filled when the attacking mech is legged and misses a melee attack
`dfaMissInstability` | `bool` | `true` | enable/disable (additional) instability to the attacker when a dfa misses
`dfaMissInstabilityPercent` | `int` | `30` | the percentage of your stability bar that is filled when a mech misses a dfa
`dfaMissInstabilityLeggedPercent` | `int` | `70` | the percentage of your stability bar that is filled when the dfa'ing mech is legged and misses the dfa
`pilotingSkillInstabilityMitigation` | `bool` | `true` | allows the piloting skill to mitigate up to piloting skill * 10% of the additional instability caused by missed melee/dfa attacks
`allowSteadyToKnockdownForMelee` | `bool` | `true` | allow a mech to go from steady to knockdown as part of melee attack miss
`pilotingSkillDFASelfDamageMitigation` | `bool` | `true` | allows the piloting skill to mitigate up to piloting skill * 10% of the additional leg damage caused by melee/dfa attacks
`pilotingSkillFallingDamageMitigation` | `bool` | `true` | allows the piloting skill to mitigate up to piloting skill * 10% of falling damage if falling damage is enabled
`fallingDamage` | `bool` | `true` | enable mechs to take falling damage when they fall down for any reason
`fallingAmountDamagePerTon` | `float` | `0.5` | the amount of damage a mech takes per ton to a random location when it falls down if falling damage is enabled
`debug` | `bool` | `false` | enable debugging logs, probably not useful unless you are changing the code or looking at it as you run the mod

## Special Thanks

HBS, @Mpstark, @Morphyum

## License

[MIT](LICENSE)