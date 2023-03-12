# Retrainer
Allows pilots to retrain skills in HBS BattleTech

https://www.nexusmods.com/battletech/mods/310


```
"Settings": {
        "cost": 500000,
        "onceOnly": true ,
        "trainingModuleRequired": true,
		    "ignoredAbilities": [
          "AbilityDefSecretSkills",
          "AbilityDefFireAndSteel"
        ],
```

`cost`, int: cbill cost to retrain

`onceOnly`, bool: whether you can only retrain a given pilot once

`trainingModuleRequired`, bool: whether the argo training module 2 upgrade is required to retrain

`ignoredAbilities`, List [strings]: list of AbilityDef names which will <i>not</i> be removed when retraining. Intended to be used with pre-set, non-tree abilities (if you put a normal ability here, you'd keep the ability but still get refunded the XP when retraininer).
