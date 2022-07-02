**New MineField config options**

MineField Defs (i.e the stuff in `"MineField": {` in the AmmunitionDef) now have the following additional configuration options. All config options default to current (not t-boned) behavior.

```
	"ExposedStructureEndMove": true,
	"MoveCostFactor": 0.0,
	"CausesSympatheticDetonation": false,
	"SubjectToSympatheticDetonationChance": 0.0,
	"DetonateAllMinesInStackChance": 0.0,
	"MisfireOnDeployChance": 0.0,
	"MinefieldDefID": "GenericMinefield",
	"ShouldAddToExistingFields": false
```

`ExposedStructureEndMove` - If false, units moving through the minefield will not stop when structure is exposed

`MoveCostFactor` - If > 0, this minefield apply a multiplier to final movecost by `MoveCostFactor x MineField.Count) (count of mines in field)`. If multiple minefields with MoveCostFactor > 0 occupy the same cell, their multipliers are added together before final movecost is multiplied.

`CausesSympatheticDetonation`: If true, when mine is detonated, it can trigger other mines within this mines AOE to detonate as well. These "sympathetic" detonations will then inflict AOE damge, but *not* primary damage, and will not set off further sympathetic detonations.

`SubjectToSympatheticDetonationChance`: if > 0, is chance for this minefield to be triggered if within AOE of a normally detonated mine with `"CausesSympatheticDetonation": true`. All mines in minefield (MineField.Count) are triggered.

`DetonateAllMinesInStackChance`: If > 0, is chance for all mines in current minefield (MineField.Count) to be detonated when one is triggered.

`MisfireOnDeployChance`: If > 0, is chance for individual mines within the minefield (MineField.Count) to "fail to arm" when the minefield is deployed. Rolled for each of Minefield.Count.

`MinefieldDefID` and `ShouldAddToExistingFields`: If `"ShouldAddToExistingFields": true`, minefields deployed to same cell by same team and have identical `MinefieldDefID` will simply add to MineField.Count rather than deploying "new" minefields.