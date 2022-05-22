<pre>
How is it working:
CustomLocalization.dll on load searches recursively through Mods folder for files Localization.json
this files contains array of records like this 
[
  {
    "FileName": "C:\\Games\\steamapps\\common\\BATTLETECH\\Mods\\ActivatableEquipment\\upgrades\\Gear_Cockpit_CPU.json", - not used by CustomLocalization.dll itself. 
                                                                                                                          Can be used for moder to commentary purposes
    "Name": "CustomActivatableEquipment.Gear_Cockpit_CPU.UIName",                - name of localized string should be unique. 
    "Localization": {                                                            - localization map
      "CULTURE_EN_US": "Machine Spirit",
      "CULTURE_DE_DE": "Machine Spirit",
      "CULTURE_RU_RU": "Machine Spirit"
    }
    NOTE! supported cultures 
      CULTURE_DE_DE
      CULTURE_ZH_CN
      CULTURE_ES_ES
      CULTURE_FR_FR
      CULTURE_IT_IT
      CULTURE_RU_RU
      CULTURE_PT_PT
      CULTURE_PT_BR    
  }
]
code loads all files it founds merge them (if there records with same name and different cultures content in different files content will be merged, 
so you can keep localization of same strings for different languages in different file if you want).
All values consolidated to global localization table indexed by Name.
Just before output to screen code will search in string for patterns __/<Name>/__ and replace them according current selected language. 
If there no value for this language CULTURE_EN_US will be used.
For localize your mod you have two options
1. You are controlling mod sources, you have not very much content or just started.
  You should create Localization.json by your self, replace all strings in your mod you want to be translated to __/<Name>/__ and add record to Localization.json accordingly.
  Good practice is to avoid hardcoded string in your C# code, moving them to settings. 
2. You trying to localize mod not created by you or having much content already. 
  You can use CustomLocalizationPrepare.exe utility shipped with CustomLocalization mod. At first after start you should point to 
  Battletech game folder by clicking button ">" near right top coner of main application window.
  Than look at three lists at main part of the window. Left list is list of mods. It will be filled after base game folder selection.
  Center list is list of mod's parts avaible for localization. Can be expanded in future releases.
  Right list is list of supported cultures. 
  After choose mods, parts and languages you can press "Prepare selected mods". 
  On preparing CustomLocalizationPrepare utility will look through all files in selected mods, searching for patterns defined by selected parts in parts list.
  On finding pattern in file it will change its content to __/<Name>/__ (Name will be automatically generated) and add record to resulting Localization.json
  Cultures list in resulting file will bee tied to cultures you have selected in according list.
  If you select to save result to already existing file CustomLocalizationPrepare will NOT overwrite it, instead content will be merged. 
  Avaible parts 
      Description.UIName - it is obvious, it code will search top level Description in jsons and UIName in it, mostly used in component's definitions.
      Description.Name - it is obvious, it code will search top level Description in jsons and Name in it, used very wide: star maps, design masks, heraldy, lore records etc.
      Description.Details - it is obvious, it code will search top level Description in jsons andDetailsName in it, used very wide.
      StockRole - stock role for chassis
      YangsThoughts - nothing to say
      StatusEffects.Name - name in StatusEffects arrays.
      StatusEffects.Details - details in StatusEffects arrays.
      Mode.StatusEffects.Name - name in StatusEffects arrays relative to CAC's weapon modes.
      Mode.StatusEffects.Details - same as above but for descriptions
      CAE.statusEffects.Description.Name - name in StatusEffects arrays relative to CAE activatables
      CAE.statusEffects.Description.Details - same as above but for descriptions
      CAE.offlineStatus.Description.Name  - name in StatusEffects arrays relative to CAE activatables offline effects
      CAE.offlineStatus.Description.Details - same as above but for descriptions
      CAE.Explosion.statusEffects.Description.Name - name in StatusEffects arrays relative to CAE activatables explosion effects
      CAE.Explosion.statusEffects.Description.Details - same as above but for descriptions
      contractName - name of contracts
      shortDescription - short descriptions mostly used for contracts 
      longDescription - long descriptions mostly used for contracts 
      FlashpointShortDescription - nothing to say
      objectiveList.title - titles for objectives mostly used for contracts 
      objectiveList.description - description for objectives mostly used for contracts 
      contents.words - used for dialogs
      dialogueList.dialogueContent.words - used for dialogs in battle
      Options.Description.Name - event's options names
      Options.Description.Details - event's options details
      Options.ResultSets.Description.Name - event's results names
      Options.ResultSets.Description.Details - event's results desctiptions
      Conversations(binary) - conversation's binaries modifiers 
  NOTE! After preparing mod will not display strings properly without CustomLocalization mod.
  NOTE! Using CustomLocalizationPrepare always backup original files.
</pre>