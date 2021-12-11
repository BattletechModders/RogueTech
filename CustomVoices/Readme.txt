this mod allow using external sound banks as voice packs for pilots
it creates custom resource for ModTek - VoicePackDef
{
  "name":"tex_voice", - name of voice pack. This name should be set in PilotDef.Voice field
  "vobank":"tex_voice_soundbank", - sound bank for voice pack. 
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