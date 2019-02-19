
using System;
using System.Collections.Generic;
using HBS.Logging;
using Harmony;
using System.Reflection;
using BattleTech;
using BattleTech.UI;
using DynModLib;
using InControl;
using UnityEngine;
using Logger = HBS.Logging.Logger;

namespace SpeedMod
{
    public static class Control
    {
        private static Mod mod;

        private static SpeedSettings settings = new SpeedSettings();

        public static void Start(string modDirectory, string json)
        {
            mod = new Mod(modDirectory);
            mod.LoadSettings(settings);
			
			var harmony = HarmonyInstance.Create(mod.Name);
            harmony.PatchAll(Assembly.GetExecutingAssembly());

            // logging output can be found under BATTLETECH\BattleTech_Data\output_log.txt
            // or also under yourmod/log.txt
            mod.Logger.Log("Loaded " + mod.Name);
        }

        public class SpeedSettings : ModSettings
        {
            public bool FastForwardKeyIsToggle = true;
            public bool SpeedUpIsConstant = true;
            public float SpeedBaseFactor = 1.0f;
        }

        private static PlayerAction SpeedUpAction
        {
            get { return BTInput.Instance.Combat_FFCurrentMove(); }
        }

        private static bool speedToggled;

        [HarmonyPatch(typeof(CombatSelectionHandler), "ProcessInput")]
        public static class CombatSelectionHandlerProcessInputPatch
        {
            public static void Prefix(CombatSelectionHandler __instance)
            {
                try
                {
                    if (!settings.FastForwardKeyIsToggle)
                    {
                        return;
                    }

                    if (SpeedUpAction == null || !SpeedUpAction.HasChanged || !SpeedUpAction.IsPressed)
                    {
                        return;
                    }

                    speedToggled = !speedToggled;
                    
                    mod.Logger.Log("toggled speed " + speedToggled);
                }
                catch (Exception e)
                {
                    mod.Logger.LogError(e);
                }
            }
        }

        [HarmonyPatch(typeof(OrderSequence), "OnUpdate")]
        public static class OrderSequenceOnUpdatePatch
        {
            public static IEnumerable<CodeInstruction> Transpiler(IEnumerable<CodeInstruction> instructions)
            {
                return instructions
                    .MethodReplacer(
                        AccessTools.Method(typeof(OneAxisInputControl), "get_WasReleased"),
                        AccessTools.Method(typeof(OrderSequenceOnUpdatePatch), "get_WasReleased")
                    );
            }

            public static bool get_WasReleased(OneAxisInputControl @this)
            {
                if (settings.FastForwardKeyIsToggle)
                {
                    return false;
                }

                return SpeedUpAction.WasReleased;
            }
        }

        [HarmonyPatch(typeof(StackManager), "GetProgressiveDeltaTime", new[] { typeof(float), typeof(bool ) })]
        public static class StackManagerGetProgressiveDeltaTime1Patch
        {
            public static void Prefix(StackManager __instance, ref float t, ref bool isSpedUp, ref float __result)
            {
                if (speedToggled)
                {
                    isSpedUp = true;
                }
            }
        }

        [HarmonyPatch(typeof(StackManager), "GetProgressiveAttackDeltaTime")]
        public static class StackManagerGetProgressiveAttackDeltaTimePatch
        {
            public static IEnumerable<CodeInstruction> Transpiler(IEnumerable<CodeInstruction> instructions)
            {
                return instructions
                    .MethodReplacer(
                        AccessTools.Method(typeof(StackManager), "get_AttackTimeMultiplier"),
                        AccessTools.Method(typeof(StackManagerGetProgressiveAttackDeltaTimePatch), "get_AttackTimeMultiplier")
                    );
            }

            public static float get_AttackTimeMultiplier(StackManager @this)
            {
                var num = @this.AttackTimeMultiplier;
                if (speedToggled)
                {
                    if (Mathf.Approximately(num, 1f))
                    {
                        return @this.Combat.Constants.CombatUIConstants.AttackSpeedUpFactor;
                    }
                }
                return num;
            }
        }

        [HarmonyPatch(typeof(StackManager), "GetProgressiveDeltaTime", new[] { typeof(float), typeof(float) })]
        public static class StackManagerGetProgressiveDeltaTime2Patch
        {
            public static bool Prefix(StackManager __instance, ref float t, ref float multiplier, ref float __result)
            {
                multiplier *= settings.SpeedBaseFactor;

                if (!settings.SpeedUpIsConstant)
                {
                    return true;
                }

                __result = __instance.deltaTime * multiplier;

                return false;
            }
        }
    }
}
