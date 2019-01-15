; Inno Setup

#define isfiles "isfiles-unicode"
#define BTDirectory "D:\RogueTechStuff\RogueTechAssetBundles"

#define AppVerJSON
#define FileHandle
#define FileLine
#sub ProcessFileLine
  #define FileLine = FileRead(FileHandle)
  #expr AppVerJSON = AppVerJSON + Str(FileLine)
#endsub
#for {FileHandle = FileOpen(BTDirectory + '/RogueAssets/mod.json'); \
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
AppName=RogueTech AssetBundle
AppId=AssetBundles for RogueTech
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
LicenseFile=/RogueAssets/RogueAssetsReadme.txt
WizardImageAlphaFormat=premultiplied
WizardImageFile={#SourcePath}\WizardImageLarge.bmp,{#SourcePath}\WizardImageLarge2.bmp
WizardSmallImageFile={#SourcePath}\WizardImageSmall.bmp,{#SourcePath}\WizardImageSmall2.bmp
SourceDir={#BTDirectory}
SetupIconFile={#BTDirectory}\RogueTechIcons\Battletech-RogueTech-A (2018).ico
DirExistsWarning=no
UsePreviousAppDir=no
UsePreviousTasks=no
DisableWelcomePage=no
OutputDir={#SourcePath}
OutputBaseFilename=RogueTechAssetBundle-v{#RTVersion}
BackColor=clRed
BackColor2=clBlack

[Files]
;Source: "/RogueAssets/RogueAssetsReadme.txt"; DestDir: "{app}/Mods/RogueAssets"; Flags: isreadme ignoreversion
Source: "/*"; DestDir: "{app}/Mods"; Flags: recursesubdirs ignoreversion

[Messages]
SetupAppRunningError=Setup has detected that another RT setup or BATTLETECH game is currently running.%n%nPlease close all instances of it now, then click OK to continue, or Cancel to exit.
BrowseDialogTitle=Select your BattleTech folder
SelectDirDesc=[name] needs your BattleTech folder
SelectDirBrowseLabel=To continue, click Next. It should be your BattleTech folder
NoUninstallWarning=Setup has detected that the following components are already installed on your computer:%n%n%1%n%nDeselecting these components will not uninstall them.%n%n You HAVE to remove Mods folder on next step!
WizardPreparing=Preparing for Drop, Brace yourself
WelcomeLabel1=Welcome to the [name] Setup, Commander


[Run]
Filename: "https://roguetech.gamepedia.com/Roguetech_Wiki"; Description: "The RogueTech Wiki! Read it"; Flags: postinstall nowait shellexec skipifsilent



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
