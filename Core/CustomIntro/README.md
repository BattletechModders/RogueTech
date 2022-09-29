this mod was created to customize the video playback mechanism in the game, primarily the intro.
Settings
<pre>
  "Settings": {
    "playEveryStart": false - play the intro on every start. If false, the intro will only play on the first run.
    "useModtekFolder": true - set true to use the .modtek directory to store the list of intros that have already been played.
                              If false, the directory where the local settings file is stored will be used to store the list of intros that have already been played.
                              If true, then the first launch after RT/BTA reconfiguration will be followed by playing the intro.
  }
</pre>

The name of the intro that will be played is stored in the intro.json file in the directory with CustomIntro.dll

<pre>
{
   "currentIntro":"wob" - intro id, if there is no custom intro with this id, vanilla intro will be played.
}
</pre>

The mod defines the following types of custom resources (read more about what custom resources are and how to use them in the ModTek manual)
IntroVideoFile , IntroVideoFileDef, IntroSubtitles

IntroVideoFile - video file in bik or bk2 format (ATTENTION! simply changing the file extension from avi or mp4 will not work, transcoding is required)
IntroSubtitles - subtitle file in srt format

IntroVideoFileDef

<pre>
{
  "id":"wob", - identifier, which can then be referred to when playing the video
  "videos": { - dictionary of video files for different language settings. In the example shown, if the Russian language is selected in the game, wob_ru.bik will be played,
                English or any other that is not in the wob_en.bik dictionary. ATTENTION! files must be specified in the manifest with resource type IntroVideoFile
    "CULTURE_EN_US":"wob_en",
    "CULTURE_RU_RU":"wob_ru"
  },
  "subtitles":{ - subtitles dictionary, the rules are the same as for the videos section
  }
}
</pre>

This mod also allows you to play videos on milestone's actions, you only have to set "value" to id of one of IntroVideoFileDef