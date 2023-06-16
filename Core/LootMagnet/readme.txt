config

RollupPartsInsideMechUsePartCost: false -  if true use MechDef.SimGameMechPartCost instead MechDef.Description.Cost for full unit chassis slots cost calculations
RollupPartsInsideMechUseRestStructure: true - if true use percentage of rest structure for full unit chassis slots cost calculations

RollupComponentsInsideMechStrategy: "UpToThreshold" - stragegy for calculation full unit components slots cost
	"None" - each componet use 1 slot
	"AvgCost" - result = <cost of all components> / <reputation threshold value> result can't be greater than amount of components
	"UpToThreshold" - all components agrigate into buckets. Summ cost of components in each bucket can't be greater than <reputation threshold value>. Result is about of such buckets
	"UpToThresholdSame" - same a prev. but only components of the same type can be in one bucket
	"FlatModifier" - result = <amount of components> * <RollupFullUnitComponent for current reputation> rounded up. If <RollupFullUnitComponent for current reputation> is 0 than <amount of components>
	
<reputation threshold value> for full unit components slot cost calculation is <RollupMRBValue for current MRB> * <RollupFullUnitComponent for current reputation>
