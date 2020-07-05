Battletech Modding Community Mech Affinity Tool 1.1
=====================================================
Simple tool to detect all chassis prefabs and quirks and list those used and unused for Mech Affinity mod.

Requires Java 14 or newer, download at https://adoptopenjdk.net/releases.html. Make sure your JAVA_HOME environment variable is set.
Put files in the same folder as the settings.json for Mech Affinity, or copy settings.json to the location of these files.


Configuration options (application.properties):

battletech.location.source-directory -> the location of the Battletech mods directory or local Git repository of the mods, defaults to parent directory of current directory
battletech.location.output-directory -> where to write output and log files, defaults to current directory
battletech.affinity.quirk-category -> name of the category ID for quirks, defaults to "PositiveQuirk"