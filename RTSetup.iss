; Inno Setup

#define isfiles "isfiles-unicode"
#define BTDirectory "D:\RogueTechStuff\RogueTech"

#define AppVerJSON
#define FileHandle
#define FileLine
#sub ProcessFileLine
  #define FileLine = FileRead(FileHandle)
  #expr AppVerJSON = AppVerJSON + Str(FileLine)
#endsub
#for {FileHandle = FileOpen(BTDirectory + '/RogueTech Core/mod.json'); \
  FileHandle && !FileEof(FileHandle); ""} \
  ProcessFileLine
#if FileHandle
  #expr FileClose(FileHandle)
#endif

#define tmpStr Copy(AppVerJSON, Pos('"Version": "', AppVerJSON) + 12)
#define len (Pos('"', tmpStr) - 1)
#define RTVersion Copy(AppVerJSON, Pos('"Version": "', AppVerJSON) + 12, len)
#pragma message 'Version: ' + RTVersion
#undef tmpStr
#undef len

[Setup]
AppName=RogueTech
AppId=RogueTech mod (for BATTLETECH)
AppVersion={#RTVersion}
AppPublisher=Lady Alekto
AppPublisherURL=http://reddit.com/r/roguetech
AppSupportURL=http://reddit.com/r/roguetech
AppUpdatesURL=http://reddit.com/r/roguetech
AppMutex=mmon-BATTLETECH-BattleTech-exe-SingleInstanceMutex-Default,Global\mmon-BATTLETECH-BattleTech-exe-SingleInstanceMutex-Default
SetupMutex=RogueTechSetupMutex,Global\RogueTechSetupMutex
DefaultDirName={code:GetDefaultDir}
DisableProgramGroupPage=yes
AppendDefaultDirName=no
;DefaultGroupName=Inno Setup 5
AllowNoIcons=yes
Compression=lzma2/ultra
InternalCompressLevel=ultra
SolidCompression=yes
Uninstallable=yes
UninstallDisplayIcon={#BTDirectory}\RogueTechIcons\Battletech-RogueTech-B (2018).ico
LicenseFile=/RogueTech Core/RogueTech.txt
WizardImageAlphaFormat=premultiplied
WizardImageFile={#SourcePath}\WizardImageLarge.bmp,{#SourcePath}\WizardImageLarge2.bmp
WizardSmallImageFile={#SourcePath}\WizardImageSmall.bmp,{#SourcePath}\WizardImageSmall2.bmp
SourceDir={#BTDirectory}
SetupIconFile={#BTDirectory}\RogueTechIcons\Battletech-RogueTech-D_2018.ico
DirExistsWarning=no
UsePreviousAppDir=no
UsePreviousTasks=no
DisableWelcomePage=no
OutputDir={#SourcePath}
OutputBaseFilename=RogueTechCore-{#RTVersion}
BackColor=clRed
BackColor2=clBlack

[Files]
;Source: "/RogueTech Core/RogueTech.txt"; DestDir: "{app}/Mods/RogueTech Core"; Flags: isreadme ignoreversion
Source: "/*"; Excludes: ".git,.modtek,.git,log.txt,RTAssetsSetup.iss,*.log,RogueOmnis,RogueOmnisFlashpoint,RogueOmnisHeavyMetal,MissionControlRandomX2,MissionControlRandomX3,MissionControlRandomX4,Republic HeavyMetal Unique,Republic HeavyMetal,DarkAge HeavyMetal,UrbieNuke Heavy Metal,RogueModuleElitesHeavyMetal,PirateTech Urbanwarfare Module,PirateTech HeavyMetal Module,PirateTech Flashpoint Module,Jihad HeavyMetal Unique,Jihad Heavy metal,ClanUpgradesJihad HeavyMetal,Civil War Heavy Metal Unique,Civil War Heavy Metal,Base HeavyMetal Unique,Civil War FlashPoint,Base UrbanWarfare Unique,Base HeavyMetal,RogueHeavyMetalModule,MissionControlNoRandom,ContractSort,GalaxyAtWar,PersistentMapClient,RogueUrbanWarfareModule,LV426,SortByTonnage,Warhammer Emblems,NROL Emblems,MissionControlRandom,MissionControlMassive,HistoricPirateFlags,rubyscripts,RepublicArtillery,Risc Urban Warfare,RogueModuleElitesFlashpoint,MechPortraitsArmakoir,MechPortraitsENOVA,MechPortraitsJK,MechPortraitsCrew,RogueTechDebug,ClanUpgrades,ClanUpgradesCivilWar,ClanUpgradesDarkAge,ClanUpgradesJihad,ClanUpgradesRepublic,Protomechs,GlobalDifficultyByRep,RogueFlashPointModuleStoryline,DarkAgeArtillery,PirateTech,RISCtech module,Dark Age Unique,Jihad Urban Warfare,Jihad Unique,Jihad 3068-3080,Republic Unique Mechs,Republic Urban Warfare,Republic FlashPoint,Civil War Unique,Base FlashPoint,Civil War Urban Warfare,CivilWar 3062-3067,Base UrbanWarfare,Republic 3081-3130,RogueTechSounds,UrbocalypseDarkAge,EnovaEmblems,FlashPointArtillery,DarkAge,FlashPointDarkAge,ExperimentalWeapons_SHcompat,Urbocalypse,ArtilleryUnits,LootedClanMechs,The Drones Of Syberia,ClanEmblems,SpeedMod,Flashpoint-The-Raid,SkipTravelCutscenes,RandomTravelContracts,PersistentMapClient,RogueModuleElites,CommanderPortraitLoader,Superheavys,RogueFlashPointModule,ExperimentalWeapons,RaelM Emblem,UrbieNuke,GlobalDifficultyByCompany,GlobalDifficultyByPlanets,Retrainer,Silence,FreeCam,BindableEscapeKey,ArmorRepair,ArmorPoints,RogueEmblems,All 3025 Mercs,Capellan Emblems,SkipIntro,CrystalClear" ; DestDir: "{app}/Mods"; Flags: recursesubdirs ignoreversion

Source: "/PersistentMapClient/*"; Excludes: "log.txt"; DestDir: "{app}/Mods/PersistentMapClient"; Flags: recursesubdirs ignoreversion createallsubdirs; Components: RogueTechMode\Online;
Source: "/RandomTravelContracts/*"; Excludes: "log.txt"; DestDir: "{app}/Mods/RandomTravelContracts"; Flags: recursesubdirs ignoreversion createallsubdirs; Components: RogueTechMode\Online;
Source: "/ContractSort/*"; Excludes: "log.txt"; DestDir: "{app}/Mods/ContractSort"; Flags: recursesubdirs ignoreversion createallsubdirs; Components: RogueTechMode\Online;
Source: "/GalaxyAtWar/*"; Excludes: "log.txt"; DestDir: "{app}/Mods/GalaxyAtWar"; Flags: recursesubdirs ignoreversion createallsubdirs; Components: RogueTechMode\Offline;

Source: "/RogueEmblems/*"; Excludes: "log.txt"; DestDir: "{app}/Mods/RogueEmblems"; Flags: recursesubdirs ignoreversion createallsubdirs; Components: emblems\rogueemblems;
Source: "/RaelM Emblem/*"; Excludes: "log.txt"; DestDir: "{app}/Mods/RaelM Emblem"; Flags: recursesubdirs ignoreversion createallsubdirs; Components: emblems\raelmemblems;
Source: "/All 3025 Mercs/*"; Excludes: "log.txt"; DestDir: "{app}/Mods/All 3025 Mercs"; Flags: recursesubdirs ignoreversion createallsubdirs; Components: emblems\mercemblems;
Source: "/Capellan Emblems/*"; Excludes: "log.txt"; DestDir: "{app}/Mods/Capellan Emblems"; Flags: recursesubdirs ignoreversion createallsubdirs; Components: emblems\capellaemblems;
Source: "/ClanEmblems/*"; Excludes: "log.txt"; DestDir: "{app}/Mods/ClanEmblems"; Flags: recursesubdirs ignoreversion createallsubdirs; Components: emblems\ClanEmblems;
Source: "/EnovaEmblems/*"; Excludes: "log.txt"; DestDir: "{app}/Mods/EnovaEmblems"; Flags: recursesubdirs ignoreversion createallsubdirs; Components: emblems\EnovaEmblems;
Source: "/HistoricPirateFlags/*"; Excludes: "log.txt"; DestDir: "{app}/Mods/HistoricPirateFlags"; Flags: recursesubdirs ignoreversion createallsubdirs; Components: emblems\HistoricPirateFlags;
Source: "/NROL Emblems/*"; Excludes: "log.txt"; DestDir: "{app}/Mods/NROL Emblems"; Flags: recursesubdirs ignoreversion createallsubdirs; Components: emblems\NROLEmblems;
Source: "/Warhammer Emblems/*"; Excludes: "log.txt"; DestDir: "{app}/Mods/Warhammer Emblems"; Flags: recursesubdirs ignoreversion createallsubdirs; Components: emblems\WarhammerEmblems;

Source: "/SkipIntro/*"; Excludes: "log.txt"; DestDir: "{app}/Mods/SkipIntro"; Flags: recursesubdirs ignoreversion createallsubdirs; Components: qol\skipintro;
Source: "/BindableEscapeKey/*"; DestDir: "{app}/Mods/BindableEscapeKey"; Flags: ignoreversion; Components: qol\esckeybind;
Source: "/Retrainer/*"; DestDir: "{app}/Mods/Retrainer"; Flags: ignoreversion; Components: qol\Retrainer;
Source: "/SpeedMod/*"; DestDir: "{app}/Mods/SpeedMod"; Flags: ignoreversion; Components: qol\SpeedMod;
Source: "/RogueTechDebug/*"; DestDir: "{app}/Mods/RogueTechDebug"; Flags: recursesubdirs ignoreversion createallsubdirs; Components: qol\RogueTechDebug;
Source: "/SortByTonnage/*"; DestDir: "{app}/Mods/SortByTonnage"; Flags: ignoreversion; Components: qol\SortByTonnage;

Source: "/CommanderPortraitLoader/*"; Excludes: "log.txt"; DestDir: "{app}/Mods/CommanderPortraitLoader"; Flags: recursesubdirs ignoreversion createallsubdirs; Components: gfx\CommanderPortraitLoader;
Source: "/CrystalClear/*"; Excludes: "log.txt"; DestDir: "{app}/Mods/CrystalClear"; Flags: recursesubdirs ignoreversion createallsubdirs; Components: gfx\crystal;
Source: "/SkipTravelCutscenes/*"; Excludes: "log.txt"; DestDir: "{app}/Mods/SkipTravelCutscenes"; Flags: recursesubdirs ignoreversion createallsubdirs; Components: gfx\SkipTravelCutscenes;
Source: "/Silence/*"; Excludes: "log.txt"; DestDir: "{app}/Mods/Silence"; Flags: recursesubdirs ignoreversion createallsubdirs; Components: gfx\silence;
Source: "/RogueTechSounds/*"; DestDir: "{app}/Mods/RogueTechSounds"; Flags: recursesubdirs ignoreversion uninsneveruninstall createallsubdirs; Components: gfx\soundmod

Source: "/MechPortraitsJK/*"; Excludes: "log.txt"; DestDir: "{app}/Mods/RoguePortraits"; Flags: recursesubdirs ignoreversion createallsubdirs; Components: portraits\mechportraitsJK;
Source: "/MechPortraitsENOVA/*"; Excludes: "log.txt"; DestDir: "{app}/Mods/RoguePortraits"; Flags: recursesubdirs ignoreversion createallsubdirs; Components: portraits\mechportraitsENOVA;
Source: "/MechPortraitsArmakoir/*"; Excludes: "log.txt"; DestDir: "{app}/Mods/RoguePortraits"; Flags: recursesubdirs ignoreversion createallsubdirs; Components: portraits\mechportraitsArmakor;
Source: "/MechPortraitsCrew/*"; Excludes: "log.txt"; DestDir: "{app}/Mods/RoguePortraits"; Flags: recursesubdirs ignoreversion createallsubdirs; Components: portraits\mechportraitsCrew;

Source: "/ArmorRepair/*"; Excludes: "log.txt"; DestDir: "{app}/Mods/ArmorRepair"; Flags: recursesubdirs ignoreversion createallsubdirs; Components: repair\on;
Source: "/ArmorPoints/*"; DestDir: "{app}/Mods/ArmorPoints"; Flags: ignoreversion; Components: repair\off;

Source: "/GlobalDifficultyByCompany/*"; Excludes: "log.txt"; DestDir: "{app}/Mods/GlobalDifficulty"; Flags: recursesubdirs ignoreversion createallsubdirs; Components: difficulty\Company;
Source: "/GlobalDifficultyByPlanets/*"; DestDir: "{app}/Mods/GlobalDifficulty"; Flags: recursesubdirs ignoreversion createallsubdirs; Components: difficulty\Planet;
Source: "/GlobalDifficultyByRep/*"; DestDir: "{app}/Mods/GlobalDifficulty"; Flags: recursesubdirs ignoreversion createallsubdirs; Components: difficulty\Rep;

Source: "/ClanUpgrades/*"; Excludes: "log.txt"; DestDir: "{app}/Mods/ClanUpgrades"; Flags: recursesubdirs ignoreversion createallsubdirs; Components: RogueTechOptionals\ClanUpgrades;
Source: "/ClanUpgradesCivilWar/*"; Excludes: "log.txt"; DestDir: "{app}/Mods/ClanUpgradesCivilWar"; Flags: recursesubdirs ignoreversion createallsubdirs; Components: RogueTechOptionals\ClanUpgrades;
Source: "/ClanUpgradesDarkAge/*"; Excludes: "log.txt"; DestDir: "{app}/Mods/ClanUpgradesDarkAge"; Flags: recursesubdirs ignoreversion createallsubdirs; Components: RogueTechOptionals\ClanUpgrades;
Source: "/ClanUpgradesJihad/*"; Excludes: "log.txt"; DestDir: "{app}/Mods/ClanUpgradesJihad"; Flags: recursesubdirs ignoreversion createallsubdirs; Components: RogueTechOptionals\ClanUpgrades;
Source: "/ClanUpgradesRepublic/*"; Excludes: "log.txt"; DestDir: "{app}/Mods/ClanUpgradesRepublic"; Flags: recursesubdirs ignoreversion createallsubdirs; Components: RogueTechOptionals\ClanUpgrades;
Source: "/ClanUpgradesJihad HeavyMetal/*"; Excludes: "log.txt"; DestDir: "{app}/Mods/ClanUpgradesJihad HeavyMetal"; Flags: recursesubdirs ignoreversion createallsubdirs; Components: RogueTechOptionals\ClanUpgrades;

Source: "/PirateTech/*"; Excludes: "log.txt"; DestDir: "{app}/Mods/PirateTech"; Flags: recursesubdirs ignoreversion createallsubdirs; Components: RogueTechOptionals\PirateTech;
Source: "/PirateTech Flashpoint Module/*"; Excludes: "log.txt"; DestDir: "{app}/Mods/PirateTech Flashpoint Module"; Flags: recursesubdirs ignoreversion createallsubdirs; Components: RogueTechOptionals\PirateTech;
Source: "/PirateTech Urbanwarfare Module/*"; Excludes: "log.txt"; DestDir: "{app}/Mods/PirateTech Urbanwarfare Module"; Flags: recursesubdirs ignoreversion createallsubdirs; Components: RogueTechOptionals\PirateTech;
Source: "/PirateTech HeavyMetal Module/*"; Excludes: "log.txt"; DestDir: "{app}/Mods/PirateTech HeavyMetal Module"; Flags: recursesubdirs ignoreversion createallsubdirs; Components: RogueTechOptionals\PirateTech;

Source: "/RISCtech module/*"; Excludes: "log.txt"; DestDir: "{app}/Mods/RISCtech module"; Flags: recursesubdirs ignoreversion createallsubdirs; Components: RogueTechOptionals\RISCtechmodule;
Source: "/RISCtech Heavy Metal module/*"; Excludes: "log.txt"; DestDir: "{app}/Mods/RISCtech Heavy Metal module"; Flags: recursesubdirs ignoreversion createallsubdirs; Components: RogueTechOptionals\RISCtechmodule;
Source: "/Risc Urban Warfare/*"; Excludes: "log.txt"; DestDir: "{app}/Mods/Risc Urban Warfare"; Flags: recursesubdirs ignoreversion createallsubdirs; Components: RogueTechOptionals\RISCtechmodule;

Source: "/RogueModuleElites/*"; Excludes: "log.txt"; DestDir: "{app}/Mods/RogueModuleElites"; Flags: recursesubdirs ignoreversion createallsubdirs; Components: RogueTechOptionals\RogueModuleElites;
Source: "/RogueModuleElitesFlashpoint/*"; Excludes: "log.txt"; DestDir: "{app}/Mods/RogueModuleElitesFlashpoint"; Flags: recursesubdirs ignoreversion createallsubdirs; Components: RogueTechOptionals\RogueModuleElites;
Source: "/RogueModuleElitesHeavyMetal/*"; Excludes: "log.txt"; DestDir: "{app}/Mods/RogueModuleElitesHeavyMetal"; Flags: recursesubdirs ignoreversion createallsubdirs; Components: RogueTechOptionals\RogueModuleElites;

Source: "/RogueOmnis/*"; Excludes: "log.txt"; DestDir: "{app}/Mods/RogueOmnis"; Flags: recursesubdirs ignoreversion createallsubdirs; Components: RogueTechOptionals\RogueOmnis;
Source: "/RogueOmnisHeavyMetal/*"; Excludes: "log.txt"; DestDir: "{app}/Mods/RogueOmnisHeavyMetal"; Flags: recursesubdirs ignoreversion createallsubdirs; Components: RogueTechOptionals\RogueOmnis;
Source: "/RogueOmnisFlashpoint/*"; Excludes: "log.txt"; DestDir: "{app}/Mods/RogueOmnisFlashpoint"; Flags: recursesubdirs ignoreversion createallsubdirs; Components: RogueTechOptionals\RogueOmnis;

Source: "/UrbieNuke/*"; Excludes: "log.txt"; DestDir: "{app}/Mods/UrbieNuke"; Flags: recursesubdirs ignoreversion createallsubdirs; Components: RogueTechOptionals\Nukes;
Source: "/UrbieNuke Heavy Metal/*"; Excludes: "log.txt"; DestDir: "{app}/Mods/UrbieNuke Heavy Metal"; Flags: recursesubdirs ignoreversion createallsubdirs; Components: RogueTechOptionals\Nukes;

Source: "/LV426/*"; Excludes: "log.txt"; DestDir: "{app}/Mods/LV426"; Flags: recursesubdirs ignoreversion createallsubdirs; Components: RogueTechOptionals\LV426;
Source: "/Protomechs/*"; Excludes: "log.txt"; DestDir: "{app}/Mods/Protomechs"; Flags: recursesubdirs ignoreversion createallsubdirs; Components: RogueTechOptionals\Protomechs;

Source: "/ExperimentalWeapons/*"; Excludes: "log.txt"; DestDir: "{app}/Mods/ExperimentalWeapons"; Flags: recursesubdirs ignoreversion createallsubdirs; Components: RogueTechOptionals\ExperimentalWeapons;
Source: "/ExperimentalWeapons_SHcompat/*"; Excludes: "log.txt"; DestDir: "{app}/Mods/ExperimentalWeapons_SHcompat"; Flags: recursesubdirs ignoreversion createallsubdirs; Components: RogueTechOptionals\ExperimentalWeapons;
Source: "/Superheavys/*"; Excludes: "log.txt"; DestDir: "{app}/Mods/Superheavys"; Flags: recursesubdirs ignoreversion createallsubdirs; Components: RogueTechOptionals\Superheavys;

Source: "/ArtilleryUnits/*"; Excludes: "log.txt"; DestDir: "{app}/Mods/ArtilleryUnits"; Flags: recursesubdirs ignoreversion createallsubdirs; Components: RogueTechOptionals\ArtilleryUnits;
Source: "/FlashPointArtillery/*"; Excludes: "log.txt"; DestDir: "{app}/Mods/FlashPointArtillery"; Flags: recursesubdirs ignoreversion createallsubdirs; Components: RogueTechOptionals\ArtilleryUnits;
Source: "/RepublicArtillery/*"; Excludes: "log.txt"; DestDir: "{app}/Mods/RepublicArtillery"; Flags: recursesubdirs ignoreversion createallsubdirs; Components: RogueTechOptionals\ArtilleryUnits;
Source: "/The Drones Of Syberia/*"; Excludes: "log.txt"; DestDir: "{app}/Mods/The Drones Of Syberia"; Flags: recursesubdirs ignoreversion createallsubdirs; Components: RogueTechOptionals\Drones;
Source: "/LootedClanMechs/*"; Excludes: "log.txt"; DestDir: "{app}/Mods/LootedClanMechs"; Flags: recursesubdirs ignoreversion createallsubdirs; Components: RogueTechOptionals\LootedClanMechs;
Source: "/Urbocalypse/*"; Excludes: "log.txt"; DestDir: "{app}/Mods/Urbocalypse"; Flags: recursesubdirs ignoreversion createallsubdirs; Components: RogueTechOptionals\Urbocalypse;
Source: "/UrbocalypseDarkAge/*"; Excludes: "log.txt"; DestDir: "{app}/Mods/UrbocalypseDarkAge"; Flags: recursesubdirs ignoreversion createallsubdirs; Components: RogueTechOptionals\Urbocalypse;
Source: "/RogueFlashPointModuleStoryline/*"; Excludes: "log.txt"; DestDir: "{app}/Mods/RogueFlashPointModuleStoryline"; Flags: recursesubdirs ignoreversion createallsubdirs; Components: RogueTechOptionals\FlashpointStory;

Source: "/MissionControlRandom/*"; DestDir: "{app}/Mods/MissionControl"; Flags: recursesubdirs ignoreversion createallsubdirs; Components: MC\MissionControlRandom; 
Source: "/MissionControlNoRandom/*"; DestDir: "{app}/Mods/MissionControl"; Flags: recursesubdirs ignoreversion createallsubdirs; Components: MC\MissionControlNoRandom;  
Source: "/MissionControlRandomX2/*"; DestDir: "{app}/Mods/MissionControl"; Flags: recursesubdirs ignoreversion createallsubdirs; Components: MC\MissionControlRandomX2; 
Source: "/MissionControlRandomX3/*"; DestDir: "{app}/Mods/MissionControl"; Flags: recursesubdirs ignoreversion createallsubdirs; Components: MC\MissionControlRandomX3; 
Source: "/MissionControlRandomX4/*"; DestDir: "{app}/Mods/MissionControl"; Flags: recursesubdirs ignoreversion createallsubdirs; Components: MC\MissionControlRandomX4; 

Source: "/RogueFlashPointModule/*"; DestDir: "{app}/Mods/RogueFlashPointModule"; Flags: recursesubdirs ignoreversion createallsubdirs; Components: DLC\FLASHPOINT; 
Source: "/Flashpoint-The-Raid/*"; DestDir: "{app}/Mods/Flashpoint-The-Raid"; Flags: recursesubdirs ignoreversion createallsubdirs; Components: DLC\FLASHPOINT;
Source: "/Base FlashPoint/*"; DestDir: "{app}/Mods/Base FlashPoint"; Flags: recursesubdirs ignoreversion createallsubdirs; Components: DLC\FLASHPOINT;

Source: "/Base UrbanWarfare/*"; DestDir: "{app}/Mods/Base UrbanWarfare"; Flags: recursesubdirs ignoreversion createallsubdirs; Components: DLC\UrbanWarfare;
Source: "/RogueUrbanWarfareModule/*"; DestDir: "{app}/Mods/RogueUrbanWarfareModule"; Flags: recursesubdirs ignoreversion createallsubdirs; Components: DLC\UrbanWarfare;
Source: "/Base UrbanWarfare Unique/*"; DestDir: "{app}/Mods/Base UrbanWarfare Unique"; Flags: recursesubdirs ignoreversion createallsubdirs; Components: DLC\UrbanWarfare;

Source: "/Base HeavyMetal/*"; DestDir: "{app}/Mods/Base HeavyMetal"; Flags: recursesubdirs ignoreversion createallsubdirs; Components: DLC\HeavyMetal;
Source: "/RogueHeavyMetalModule/*"; DestDir: "{app}/Mods/RogueHeavyMetalModule"; Flags: recursesubdirs ignoreversion createallsubdirs; Components: DLC\HeavyMetal;
Source: "/Base HeavyMetal Unique/*"; DestDir: "{app}/Mods/Base HeavyMetal Unique"; Flags: recursesubdirs ignoreversion createallsubdirs; Components: DLC\HeavyMetal;

Source: "/Civil War Unique/*"; Excludes: "log.txt"; DestDir: "{app}/Mods/Civil War Unique"; Flags: recursesubdirs ignoreversion createallsubdirs; Components: RogueTechEraUnique\CivilWarUnique;
Source: "/Civil War Heavy Metal Unique/*"; Excludes: "log.txt"; DestDir: "{app}/Mods/Civil War Heavy Metal Unique"; Flags: recursesubdirs ignoreversion createallsubdirs; Components: RogueTechEraUnique\CivilWarUnique;

Source: "/Jihad Unique/*"; Excludes: "log.txt"; DestDir: "{app}/Mods/Jihad Unique"; Flags: recursesubdirs ignoreversion createallsubdirs; Components: RogueTechEraUnique\JihadUnique;
Source: "/Jihad HeavyMetal Unique/*"; Excludes: "log.txt"; DestDir: "{app}/Mods/Jihad HeavyMetal Unique"; Flags: recursesubdirs ignoreversion createallsubdirs; Components: RogueTechEraUnique\JihadUnique;

Source: "/Republic Unique/*"; Excludes: "log.txt"; DestDir: "{app}/Mods/Republic Unique"; Flags: recursesubdirs ignoreversion createallsubdirs; Components: RogueTechEraUnique\RepublicUnique;
Source: "/Republic HeavyMetal Unique/*"; Excludes: "log.txt"; DestDir: "{app}/Mods/Republic HeavyMetal Unique"; Flags: recursesubdirs ignoreversion createallsubdirs; Components: RogueTechEraUnique\RepublicUnique;

Source: "/Dark Age Unique/*"; Excludes: "log.txt"; DestDir: "{app}/Mods/Dark Age Unique"; Flags: recursesubdirs ignoreversion createallsubdirs; Components: RogueTechEraUnique\DarkAgeUnique;

Source: "/CivilWar 3062-3067/*"; Excludes: "log.txt"; DestDir: "{app}/Mods/CivilWar 3062-3067"; Flags: recursesubdirs ignoreversion createallsubdirs; Components: RogueTechEra\CivilWar;
Source: "/Civil War Urban Warfare/*"; Excludes: "log.txt"; DestDir: "{app}/Mods/Civil War Urban Warfare"; Flags: recursesubdirs ignoreversion createallsubdirs; Components: RogueTechEra\CivilWar;
Source: "/Civil War FlashPoint/*"; Excludes: "log.txt"; DestDir: "{app}/Mods/Civil War FlashPoint"; Flags: recursesubdirs ignoreversion createallsubdirs; Components: RogueTechEra\CivilWar;
Source: "/Civil War Heavy Metal/*"; Excludes: "log.txt"; DestDir: "{app}/Mods/Civil War Heavy Metal"; Flags: recursesubdirs ignoreversion createallsubdirs; Components: RogueTechEra\CivilWar;

Source: "/Jihad 3068-3080/*"; Excludes: "log.txt"; DestDir: "{app}/Mods/Jihad 3068-3080"; Flags: recursesubdirs ignoreversion createallsubdirs; Components: RogueTechEra\Jihad;
Source: "/Jihad Urban Warfare/*"; Excludes: "log.txt"; DestDir: "{app}/Mods/Jihad Urban Warfare"; Flags: recursesubdirs ignoreversion createallsubdirs; Components: RogueTechEra\Jihad;
Source: "/Jihad Flashpoint/*"; Excludes: "log.txt"; DestDir: "{app}/Mods/Jihad Flashpoint"; Flags: recursesubdirs ignoreversion createallsubdirs; Components: RogueTechEra\Jihad;
Source: "/Jihad Heavy metal/*"; Excludes: "log.txt"; DestDir: "{app}/Mods/Jihad Heavy metal"; Flags: recursesubdirs ignoreversion createallsubdirs; Components: RogueTechEra\Jihad;

Source: "/Republic 3081-3130/*"; Excludes: "log.txt"; DestDir: "{app}/Mods/Republic 3081-3130"; Flags: recursesubdirs ignoreversion createallsubdirs; Components: RogueTechEra\Republic;
Source: "/Republic FlashPoint/*"; Excludes: "log.txt"; DestDir: "{app}/Mods/Republic FlashPoint"; Flags: recursesubdirs ignoreversion createallsubdirs; Components: RogueTechEra\Republic;
Source: "/Republic Urban Warfare/*"; Excludes: "log.txt"; DestDir: "{app}/Mods/Republic Urban Warfare"; Flags: recursesubdirs ignoreversion createallsubdirs; Components: RogueTechEra\Republic;
Source: "/Republic HeavyMetal/*"; Excludes: "log.txt"; DestDir: "{app}/Mods/Republic HeavyMetal"; Flags: recursesubdirs ignoreversion createallsubdirs; Components: RogueTechEra\Republic;

Source: "/DarkAge/*"; Excludes: "log.txt"; DestDir: "{app}/Mods/DarkAge"; Flags: recursesubdirs ignoreversion createallsubdirs; Components: RogueTechEra\DarkAge;
Source: "/DarkAgeArtillery/*"; Excludes: "log.txt"; DestDir: "{app}/Mods/DarkAgeArtillery"; Flags: recursesubdirs ignoreversion createallsubdirs; Components: RogueTechEra\DarkAge;
Source: "/FlashPointDarkAge/*"; Excludes: "log.txt"; DestDir: "{app}/Mods/FlashPointDarkAge"; Flags: recursesubdirs ignoreversion createallsubdirs; Components: RogueTechEra\DarkAge;
Source: "/DarkAge HeavyMetal/*"; Excludes: "log.txt"; DestDir: "{app}/Mods/DarkAge HeavyMetal"; Flags: recursesubdirs ignoreversion createallsubdirs; Components: RogueTechEra\DarkAge;

Source: "{#SourcePath}Optionals\ModTek\0Harmony.dll"; DestDir: "{app}\Mods\ModTek\"; Flags: ignoreversion; Tasks: BTML\BTMLinst;
Source: "{#SourcePath}Optionals\ModTek\ModTekInjector.exe"; DestDir: "{app}\Mods\ModTek\"; Flags: ignoreversion; Tasks: BTML\BTMLinst;
Source: "{#SourcePath}Optionals\ModTek\ModTek.dll"; DestDir: "{app}\Mods\ModTek\"; Flags: ignoreversion; Tasks: BTML\BTMLinst;
Source: "{#SourcePath}Optionals\ModTek\modtekassetbundle"; DestDir: "{app}\Mods\ModTek\"; Flags: ignoreversion; Tasks: BTML\BTMLinst;
Source: "{#SourcePath}Optionals\ModTek\Ionic.Zip.dll"; DestDir: "{app}\Mods\ModTek\"; Flags: ignoreversion; Tasks: BTML\BTMLinst;
Source: "{#SourcePath}Optionals\ModTek\Mono.Cecil.dll"; DestDir: "{app}\Mods\ModTek\"; Flags: ignoreversion; Tasks: BTML\BTMLinst;
Source: "{#SourcePath}Optionals\ModTek\Mono.Cecil.Mdb.dll"; DestDir: "{app}\Mods\ModTek\"; Flags: ignoreversion; Tasks: BTML\BTMLinst;
Source: "{#SourcePath}Optionals\ModTek\Mono.Cecil.Pdb.dll"; DestDir: "{app}\Mods\ModTek\"; Flags: ignoreversion; Tasks: BTML\BTMLinst;
Source: "{#SourcePath}Optionals\ModTek\Mono.Cecil.Rocks.dll"; DestDir: "{app}\Mods\ModTek\"; Flags: ignoreversion; Tasks: BTML\BTMLinst;
Source: "{#SourcePath}Optionals\ModTek\Newtonsoft.Json.dll"; DestDir: "{app}\Mods\ModTek\"; Flags: ignoreversion; Tasks: BTML\BTMLinst;
Source: "{#SourcePath}Optionals\ModTek\System.Runtime.Serialization.dll"; DestDir: "{app}\Mods\ModTek\"; Flags: ignoreversion; Tasks: BTML\BTMLinst;
Source: "{#SourcePath}Optionals\ModTek\mod.json"; DestDir: "{app}\Mods\ModTek\"; Flags: ignoreversion; Tasks: BTML\BTMLinst;
Source: "{#SourcePath}Optionals\ModTek\0Harmony.dll"; DestDir: "{app}\Mods\ModTek\"; Flags: ignoreversion; Tasks: BTML\BTMLinst2;
Source: "{#SourcePath}Optionals\ModTek\ModTekInjector.exe"; DestDir: "{app}\Mods\ModTek\"; Flags: ignoreversion; Tasks: BTML\BTMLinst2;
Source: "{#SourcePath}Optionals\ModTek\ModTek.dll"; DestDir: "{app}\Mods\ModTek\"; Flags: ignoreversion; Tasks: BTML\BTMLinst2;
Source: "{#SourcePath}Optionals\ModTek\modtekassetbundle"; DestDir: "{app}\Mods\ModTek\"; Flags: ignoreversion; Tasks: BTML\BTMLinst2;
Source: "{#SourcePath}Optionals\ModTek\Ionic.Zip.dll"; DestDir: "{app}\Mods\ModTek\"; Flags: ignoreversion; Tasks: BTML\BTMLinst2;
Source: "{#SourcePath}Optionals\ModTek\Mono.Cecil.dll"; DestDir: "{app}\Mods\ModTek\"; Flags: ignoreversion; Tasks: BTML\BTMLinst2;
Source: "{#SourcePath}Optionals\ModTek\Mono.Cecil.Mdb.dll"; DestDir: "{app}\Mods\ModTek\"; Flags: ignoreversion; Tasks: BTML\BTMLinst2;
Source: "{#SourcePath}Optionals\ModTek\Mono.Cecil.Pdb.dll"; DestDir: "{app}\Mods\ModTek\"; Flags: ignoreversion; Tasks: BTML\BTMLinst2;
Source: "{#SourcePath}Optionals\ModTek\Mono.Cecil.Rocks.dll"; DestDir: "{app}\Mods\ModTek\"; Flags: ignoreversion; Tasks: BTML\BTMLinst2;
Source: "{#SourcePath}Optionals\ModTek\Newtonsoft.Json.dll"; DestDir: "{app}\Mods\ModTek\"; Flags: ignoreversion; Tasks: BTML\BTMLinst2;
Source: "{#SourcePath}Optionals\ModTek\System.Runtime.Serialization.dll"; DestDir: "{app}\Mods\ModTek\"; Flags: ignoreversion; Tasks: BTML\BTMLinst2;
Source: "{#SourcePath}Optionals\ModTek\mod.json"; DestDir: "{app}\Mods\ModTek\"; Flags: ignoreversion; Tasks: BTML\BTMLinst2;

[Messages]
SetupAppRunningError=Setup has detected that another RT setup or BATTLETECH game is currently running.%n%nPlease close all instances of it now, then click OK to continue, or Cancel to exit.
BrowseDialogTitle=Select your BattleTech folder
SelectDirDesc=[name] needs your BattleTech folder
SelectDirBrowseLabel=To continue, click Next. It should be your BattleTech folder
NoUninstallWarning=Setup has detected that the following components are already installed on your computer:%n%n%1%n%nDeselecting these components will not uninstall them.%n%n You HAVE to remove Mods folder on next step!
WizardPreparing=Preparing for Drop, Brace yourself
WelcomeLabel1=Welcome to the [name] Setup, Commander

[Components]
Name: "RogueTechMode"; Description: "Choose Game Mode"; Types: full custom compact; Flags: fixed dontinheritcheck
Name: "RogueTechMode\Online"; Description: "Online War Map Mode"; Types: custom; Flags: exclusive
Name: "RogueTechMode\Offline"; Description: "Galaxy at War Offline Mode"; Types: full compact; Flags: exclusive 
Name: "difficulty"; Description: "Choose difficulty scaling"; Types: full custom compact; Flags: fixed dontinheritcheck
Name: "difficulty\Rep"; Description: "Difficulty by Reputation - Online Map Only"; Types: custom; Flags: exclusive
Name: "difficulty\Company"; Description: "Difficulty by Company Rating - Scales with your Power Level"; Types: full compact; Flags: exclusive 
Name: "difficulty\Planet"; Description: "Difficulty by Planet Rating - Planets never change their Skulls"; Types: custom; Flags: exclusive
Name: "MC"; Description: "Mission Control - 2 Lances and Battle Extras!"; Types: full custom compact;  Flags: fixed dontinheritcheck
Name: "MC\MissionControlNoRandom"; Description: "No Spawn Randomizer"; Types: custom; Flags: exclusive
Name: "MC\MissionControlRandom"; Description: "Randomizes Battle Spawns"; Types: full compact; Flags: exclusive
Name: "MC\MissionControlRandomX2"; Description: "Randomized Spawns & X2 Map Size"; Types: custom; Flags: exclusive
Name: "MC\MissionControlRandomX3"; Description: "Randomized Spawns & X3 Map Size"; Types: custom; Flags: exclusive
Name: "MC\MissionControlRandomX4"; Description: "Randomized Spawns & X4 Map Size"; Types: custom; Flags: exclusive
Name: "DLC"; Description: "DLC Modules - Only use when you have it!"; Types: custom compact;
Name: "DLC\FLASHPOINT"; Description: "Flashpoint"; Types: custom
Name: "DLC\UrbanWarfare"; Description: "Urban Warfare"; Types: custom
Name: "DLC\HeavyMetal"; Description: "Heavy Metal"; Types: custom
Name: "RogueTechEra"; Description: "Select which Era's Units to Enable"; Types: full custom compact;
Name: "RogueTechEra\CivilWar"; Description: "Mech's of the Civil War Era 3062-3067"; Types: full compact;
Name: "RogueTechEra\Jihad"; Description: "Mech's of the WoB Jihad Era 3068-3080"; Types: full compact;
Name: "RogueTechEra\Republic"; Description: "Mech's of the Republic Era 3080-3130"; Types: full compact;
Name: "RogueTechEra\DarkAge"; Description: "Mech's of the Dark Age Era 3130+"; Types: full compact;
Name: "RogueTechEraUnique"; Description: "Select which Era's Unique and Hero Units to Enable"; Types: full custom compact;
Name: "RogueTechEraUnique\CivilWarUnique"; Description: "Unique Mech's of the Civil War Era"; Types: full compact;
Name: "RogueTechEraUnique\JihadUnique"; Description: "Unique Mech's of the WoB Jihad Era"; Types: full compact;
Name: "RogueTechEraUnique\RepublicUnique"; Description: "Unique Mech's of the Republic Era"; Types: full compact;
Name: "RogueTechEraUnique\DarkAgeUnique"; Description: "Unique Mech's of the Dark Age Era"; Types: full compact;
Name: "RogueTechOptionals"; Description: "Optional Mods and Components"; Types: full custom compact; 
Name: "RogueTechOptionals\FlashpointStory"; Description: "Arano Restoration Story as Flashpoint - REQUIRES FLASHPOINT! - by Akodoreign"; Types: full compact;
Name: "RogueTechOptionals\Protomechs"; Description: "Protomechs - by Rumia"; Types: full compact;
Name: "RogueTechOptionals\ClanUpgrades"; Description: "Non-Canon IIC Units - by Raza"; Types: custom;
Name: "RogueTechOptionals\LootedClanMechs"; Description: "Looted Clan Mechs - Arrr be taking this!"; Types: custom;
Name: "RogueTechOptionals\Urbocalypse"; Description: "Urbocalypse - Trascans Galore!"; Types: custom;
Name: "RogueTechOptionals\Superheavys"; Description: "Superheavys - Oversized Mechs&Tanks and their Missions by LadyAlekto&CargoVroom"; Types: custom;
Name: "RogueTechOptionals\RogueModuleElites"; Description: "Elite Pilots and Mechs - Lances and Contracts to face Superior Skilled Forces"; Types: custom;
Name: "RogueTechOptionals\RogueOmnis"; Description: "Custom OmniMechs - Plug and Play Galore"; Types: custom;
Name: "RogueTechOptionals\RISCtechmodule"; Description: "Republic Institute of Strategic Combat - Black Ops R&D"; Types: custom;
Name: "RogueTechOptionals\PirateTech"; Description: "Pirate Tech Units - 'Laws are to be Broken!'"; Types: custom;
Name: "RogueTechOptionals\ArtilleryUnits"; Description: "Artillery Units - Rain down the Sky"; Types: custom;
Name: "RogueTechOptionals\ExperimentalWeapons"; Description: "Experimental Weapons - by MXMach"; Types: custom;
Name: "RogueTechOptionals\Drones"; Description: "Drones of Syberia- Barely Canon FP - Requires Flashpoint- by Akodoreign"; Types: custom;
Name: "RogueTechOptionals\Nukes"; Description: "Nuclear Weapon Carriers - The RT Team"; Types: custom;
Name: "RogueTechOptionals\LV426"; Description: "LV-426 Flashpoint&Units - The RT Team"; Types: custom;
Name: "emblems"; Description: "Emblem Options"; Types: custom;      
Name: "emblems\rogueemblems"; Description: "RogueTech Emblems"; Types: custom;
Name: "emblems\raelmemblems"; Description: "RaelM Emblems"; Types: custom;
Name: "emblems\mercemblems"; Description: "3025 Mercenary Emblems"; Types: custom;
Name: "emblems\capellaemblems"; Description: "Capellan Emblems"; Types: custom;
Name: "emblems\ClanEmblems"; Description: "Clan Emblems"; Types: custom;
Name: "emblems\EnovaEmblems"; Description: "ENOVA's Emblems"; Types: custom;
Name: "emblems\NROLEmblems"; Description: "NROL Emblems by Mellowseven"; Types: custom;
Name: "emblems\WarhammerEmblems"; Description: "Warhammer Emblems by Mellowseven"; Types: custom;
Name: "emblems\HistoricPirateFlags"; Description: "Historic Pirate Flags Emblems by peteg1013"; Types: custom;
Name: "gfx"; Description: "FX Options"; Types: custom;
Name: "gfx\CommanderPortraitLoader"; Description: "Commander Portrait Loader"; Types: full;
Name: "gfx\soundmod"; Description: "Battletech Sound Replacement Pack by Zota6"; Types: full compact;
Name: "gfx\SkipTravelCutscenes"; Description: "Skip Travel cutscenes"; Types: full compact;
Name: "gfx\crystal"; Description: "Crystal Clear - Drastically reduce Postprocessing"; Types: full compact;
Name: "gfx\silence"; Description: "Silence - Disable most Ambient Chatter"; Types: custom;
Name: "portraits"; Description: "Select Style of Alternative Portraits for Mechs"; Types: full custom compact; Flags: fixed dontinheritcheck
Name: "portraits\mechportraitsCrew"; Description: "Default RogueTech Mech Portraits - by the RT Crew"; Types: full compact; Flags: exclusive
Name: "portraits\MechPortraitsENOVA"; Description: "Photography styled Mech Icons - by ENOVA"; Types: custom; Flags: exclusive
Name: "portraits\mechportraitsJK"; Description: "Vanilla styled nicer Mech Icons - by JK"; Types: custom; Flags: exclusive
Name: "portraits\mechportraitsArmakor"; Description: "Coloured Mech Portraits by Armakoir"; Types: custom; Flags: exclusive
Name: "qol"; Description: "Quality of Life Options"; Types: full compact custom;
Name: "qol\skipintro"; Description: "Skip Intro"; Types: full compact;
Name: "qol\SpeedMod"; Description: "Speed Mod - Double the Game Speed"; Types: full compact;
Name: "qol\SortByTonnage"; Description: "Sort Mechs by Cost"; Types: custom;
Name: "qol\Retrainer"; Description: "Retrainer - Spend 500k Cbills to retrain your pilots once"; Types: full compact;
Name: "qol\esckeybind"; Description: "Use Mouse4 as ESC key"; Types: custom;
Name: "qol\RogueTechDebug"; Description: "Debug Logger Enabled - Only use for Bugfinding"; Types: custom;
Name: "repair"; Description: "Tech and Repair Boni Options"; Types: full custom compact; Flags: fixed dontinheritcheck
Name: "repair\on"; Description: "Repair Armor After Battle - Required for Tech and Repair Boni"; Types: full compact; Flags: exclusive 
Name: "repair\off"; Description: "FREE Repair Armor After Battle - Disables Tech and Repair Boni"; Types: custom; Flags: exclusive

[Types]
Name: "full"; Description: "Full installation";
Name: "compact"; Description: "Compact installation";
Name: "Custom"; Description: "Custom installation"; Flags: iscustom

[Tasks]
Name: BTML; Description: "Choose RogueTechModLoader-Modtek option";
Name: BTML\BTMLinst; Description: "First Time install Modtek";Flags: unchecked exclusive
Name: BTML\BTMLinst2; Description: "Patch ModTek"; Flags: exclusive
Name: idautofixer; Description: "Autofix Unicode File Id's"; Flags: unchecked
Name: cleanup; Description: "Clean previous install"; GroupDescription: "Additional options:";
Name: cleanup\modtek; Description: "Remove ModTek Cache (RECOMMENDED!)"; Flags: unchecked
Name: cleanup\mods; Description: "Remove Mods folder (RECOMMENDED!)"; Flags: unchecked
Name: cleanup\skirmish; Description: "Remove skirmish saves and game settings"; Flags: unchecked
Name: debugmenu; Description: "Activate Debug Menu"; Flags: unchecked


[Run]
;Filename: "https://www.nexusmods.com/battletech/mods/79?tab=articles"; Description: "Open NexusMods Articles. THOSE ARTICLES ARE THE MANUAL!"; Flags: postinstall nowait shellexec skipifsilent
Filename: "https://roguetech.gamepedia.com/Roguetech_Wiki"; Description: "The RogueTech Wiki! Read it"; Flags: postinstall nowait shellexec skipifsilent
Filename: "https://old.reddit.com/r/roguetech/"; Description: "The RogueTech subreddit"; Flags: postinstall nowait shellexec skipifsilent
Filename: "https://discord.gg/93kxWQZ"; Description: "The RogueTech Discord"; Flags: postinstall nowait shellexec skipifsilent
Filename: "https://www.nexusmods.com/battletech/mods/393/"; Description: "The Assetbundle YOU NEED THIS!"; Flags: postinstall nowait shellexec skipifsilent
;Filename: "{app}/BattleTech.exe"; Description: "Launch BATTLETECH"; Flags: postinstall skipifsilent unchecked
;Filename: "{app}/Mods/RogueTech Core/RogueTech.txt"; Description: "View the Changelog file"; Flags: postinstall nowait shellexec skipifsilent unchecked
Filename: "{app}\Mods\ModTek\ModTekInjector.exe"; Parameters: -f factions.zip /nokeypress ; Tasks: BTML\BTMLinst
Filename: "{app}\Mods\ModTek\ModTekInjector.exe"; Parameters: /restore /nokeypress; Tasks: BTML\BTMLinst2
Filename: "{app}\Mods\ModTek\ModTekInjector.exe"; Parameters: -f factions.zip /nokeypress ; Tasks: BTML\BTMLinst2
Filename: "{app}\Mods\BTJsonIDCheck.exe"; Parameters: -f factions.zip /nokeypress ; Tasks: idautofixer

[UninstallRun]
Filename: "{app}\BattleTech_Data\Managed\BattleTechModLoaderInjector.exe"; Parameters: /restore /nokeypress

[InstallDelete]
Type: filesandordirs; Name: "{app}\Mods\.modtek"; Tasks: cleanup\modtek
Type: filesandordirs; Name: "{app}\Mods"; Tasks: cleanup\mods
Type: filesandordirs; Name: "{userappdata}\LocalLow\Harebrained Schemes\BATTLETECH\profiles.dat"; Tasks: cleanup\skirmish
Type: filesandordirs; Name: "{localappdata}\HarebrainedSchemes"; Tasks: cleanup\skirmish
Type: filesandordirs; Name: "{%TEMP|{localappdata}\Temp\Harebrained Schemes}"; Tasks: cleanup\skirmish
Type: filesandordirs; Name: "{reg:HKLM\SOFTWARE\WOW6432Node\Valve\Steam,InstallPath}\steamapps\shadercache\637090"; Tasks: cleanup\skirmish
Type: filesandordirs; Name: "{code:GetSteamUserDir}\637090\remote\C0\settings_cloud.sav"; Tasks: cleanup\skirmish
Type: filesandordirs; Name: "{localappdata}\gog.com\Galaxy\Applications\50593543263669699\storage\shared\files\c0\settings_cloud.sav"; Tasks: cleanup\skirmish
Type: filesandordirs; Name: "{localappdata}\gog.com\Applications\50593543263669699\storage\shared\files\c0\settings_cloud.sav"; Tasks: cleanup\skirmish

[UninstallDelete]
; delete cache
Type: filesandordirs; Name: "{app}\Mods\.modtek"

[Registry]
Root: HKCU; Subkey: "Software\Harebrained Schemes\BATTLETECH"; Flags: deletekey uninsdeletekey; Tasks: cleanup\skirmish
Root: HKCU; Subkey: "Software\Harebrained Schemes\BATTLETECH"; ValueType: dword; ValueName: "last_debug_state_h176629417"; ValueData: "1"; Tasks: debugmenu


[Code]
procedure InitializeWizard;
begin
  ExpandConstant('{#SourcePath}');
end;

// detect gog or steam installation
function GetDefaultDir(def: string): string;
var
I : Integer;
P : Integer;
steamInstallPath : string;
gameInstallPath : string;
configFile : string;
fileLines: TArrayOfString;
begin
	steamInstallPath := 'not found';
	if RegQueryStringValue( HKEY_LOCAL_MACHINE, 'SOFTWARE\WOW6432Node\Valve\Steam', 'InstallPath', steamInstallPath ) then
	begin
	end;

	if FileExists(steamInstallPath + '\steamapps\common\BattleTech\BattleTech.exe') then
	begin
		Result := steamInstallPath + '\steamapps\common\BattleTech';
		Exit;
	end
	else
	begin
		configFile := steamInstallPath + '\config\config.vdf';
		if FileExists(configFile) then
		begin
			if LoadStringsFromFile(configFile, FileLines) then
			begin
				for I := 0 to GetArrayLength(FileLines) - 1 do
				begin
					P := Pos('BaseInstallFolder_', FileLines[I]);
					if P > 0 then
					begin
						steamInstallPath := Copy(FileLines[I], P + 23, Length(FileLines[i]) - P - 23);
						if FileExists(steamInstallPath + '\steamapps\common\BattleTech\BattleTech.exe') then
						begin
							Result := steamInstallPath + '\steamapps\common\BattleTech';
							Exit;
						end;
					end;
				end;
			end;
		end;
  end;
  
  gameInstallPath := 'not found';
  if RegQueryStringValue( HKEY_LOCAL_MACHINE, 'SOFTWARE\WOW6432Node\Microsoft\Windows\CurrentVersion\Uninstall\1482783682_is1', 'InstallLocation', gameInstallPath ) then
  begin
    Result := gameInstallPath;
    Exit;
  end;
	
	Result := 'C:\BATTLETECH';
end;

// detect gog or steam installation
function GetSteamUserDir(def: string): string;
var
useriddword : Cardinal;
userid : string;
Names: TArrayOfString;
I: Integer;
S: String;
steamInstallPath : string;
begin
	if RegQueryDWordValue( HKEY_CURRENT_USER, 'SOFTWARE\Valve\Steam\ActiveProcess', 'ActiveUser', useriddword ) then
 	begin
		userid := IntToStr(useriddword);
 	end else
		begin
			if RegGetSubkeyNames(HKEY_CURRENT_USER, 'SOFTWARE\Valve\Steam\Users', Names) then
			begin
				S := '';
				for I := 0 to GetArrayLength(Names)-1 do
					S := Names[I];
				userid := S;
			end else
			begin
				userid := '0';
			end;
		end;
	
	RegQueryStringValue( HKEY_LOCAL_MACHINE, 'SOFTWARE\WOW6432Node\Valve\Steam', 'InstallPath', steamInstallPath )
	Result := steamInstallPath + '\userdata\' + userid;
end;
