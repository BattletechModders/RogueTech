this mod makes next things
1. it makes stack limit works logical. Instead of vanilla behavior where effects exceeding stack limit skips and overrides duration of latest effect satisfying limit
if makes effect actually apply but not modify statistic value. When/if previously applied effect expired or canceled - stack limit conditions recalculating
making effects not satisfying stack limits before apply their statistic modifications.
2. stack limit calculates with this mod per entity it is applied to rather than unit as in vanilla. This allows stack limit working properly if applied to components
3. if ModTek 3.0+ and StatisticDataInjector 1.0.6+ both used - there is now additional field in EffectData.durationData - stackId. If set stack limits is calculated per stackId rather than by Description.Id

if you create statistic effect with statistic name "_CANCEL_EFFECT" on application this effect cancels all effects with same 
stackId or Description.Id if stackId is not set from target (unit or component)
