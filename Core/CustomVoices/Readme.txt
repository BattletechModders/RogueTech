this mod allow using external sound banks as voice packs for pilots
it creates custom resource for ModTek - VoicePackDef
{
  "name":"tex_voice", - name of voice pack. This name should be set in PilotDef.Voice field
  "vobank":"tex_voice_soundbank", - sound bank for voice pack. 
  "volumes": {            - volume for certain custom basses, used only if custom audio samples (mp3/ogg/wav) is played
                            can be also altered via local settings modsettings/CustomAudio.json
    "MusicBus": 0.5,
	"AmbientBus": 1,
	"CombatBus": 1,
	"VoiceOverBus": 1
  },
  "baseVoice":"m_vizzini01", - fallback in-game voice 
  "stop_event": "tex_stop_voice", - event name from sound bank which is fired if voice audio should be stopped. Should be exported by sound bank.
  "gender":"Male", - gender of voice pack. Used for auto-generated pilots. 
  "dark_phrases":{ - phrases vocalized by pilots have two moods "dark" and "light". By default pilot have "light" mood. 
                     On critical hit, overheat, fall, friendly death mood changed to "dark".
    "target_alpha": ["tex_hit_target"],  - map for linked game events to audio events. 
                                         Record like "ammo_gone_ac10": ["tex_missed_target"] means on ac10 depletion tex_missed_target sound event will be fired.
  },
  "light_phrases":{
   ...........................................
  }
}

now loading mp3/ogg/wav files is supported
to make voice over bank with mp3/ogg/wav such files you should add them to manifest with AudioFile type 
and refer them in VoicePackDef. For using external samples vobank and stop_event fields should be empty.
absent phrases will be played from baseVoice. There are no way to mix external soundbanks (vobank not empty) and external samples

Game build-in music override is now available. On start CustomVoices search for Music folder near game executable.
If not found creating it. Than it is searching in Music folder for sub-folders named "MusicState_<AudioState_Music_State enumerateble>".
If not found creating it. In MusicState_<AudioState_Music_State enumerateble> sub-folders it is searching for sub-sub-folders named
"MissionStatus_<AudioSwitch_Mission_Status>". If not found creating it. In MissionStatus_<AudioSwitch_Mission_Status> sub-sub-folders 
it is searching for "PlayerState_<AudioState_Player_State>" sub-sub-sub-folders. If not found creating it. In PlayerState_<AudioState_Player_State>
sub-sub-sub-folders it is searching for all *.mp3, *.ogg and *.wav files recursively.
Once game engine request to play music CustomVoices selects random audio file from 
Music/MusicState_<AudioState_Music_State enumerateble>/MissionStatus_<AudioSwitch_Mission_Status>/PlayerState_<AudioState_Player_State> folder
and play it instead of build-in music. If state remains same when music audio file is over, CustomVoices chooses another random file and plays it.
If relevant Music/MusicState_<AudioState_Music_State enumerateble>/MissionStatus_<AudioSwitch_Mission_Status>/PlayerState_<AudioState_Player_State> folder is empty
build-in music is played. 
if you want MusicState_<AudioState_Music_State enumerateble one> folder being copy of another MusicState_<AudioState_Music_State enumerateble two> folder 
place file MusicState_<AudioState_Music_State enumerateble two>.txt to MusicState_<AudioState_Music_State enumerateble one> folder
eg. if you want MusicState_badlands_day to be copy of MusicState_rainy_day you should place empty MusicState_rainy_day.txt to MusicState_badlands_day folder
Same rule for other sub-folders type MissionStatus_<AudioSwitch_Mission_Status> and PlayerState_<AudioState_Player_State>

To speed up loading process CustomVoices caching Music folder structure in Mods/.modtek/music_cache.json file. After adding or deleting files
from Music folder you should delete this file to make CustomVoices recognize changes. 