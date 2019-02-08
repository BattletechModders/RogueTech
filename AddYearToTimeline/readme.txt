-----------------
AddYearToTimeline
-----------------

This mod adds the year to the date in the game timeline message and the event window.
The default year is 3025, but it can be change to any year in the mod settings.

-----------
Description
-----------
This mod change the format of the date message used in both the timeline and the event window. It allows to display the year in addition to the week and day of the default in game format.
The default year is 3025 as per the era the game campaign is set in, but it can be changed to any year in the mod settings.
The number of weeks per year can be configured as well but this has an effect on the number of days per year since the mod calculates the length of a year by multiplying the number of weeks by 7.
With the terran format, the date use a standard format displaying the month and the day of the month. The date is calculated using a DateTime object based on the first day of the year configured in the mod settings. Then it adds the number of days passed in the current game. The number of weeks per year is not used if you choose this format.


----------------------
User Interface changes
----------------------
* Adds the year to the date in the timeline message.
* Adds the year to the date in the event window.
* The starting year is configured in the mod settings.
* The number of weeks per year can be configured in the mod settings.
* You can choose to use the HBS format (default) or the Terran format.

--------
Settings
--------
* UseTerranTime
    Boolean true/false. Default is false.
    Use standard DateTime object to calculate the date using only the StartingYear setting.
    Takes precedence on the HBSformat if both are set to true.
* UseHBSFormat
    Boolean true/false. Default is true.
    Use HBS vanilla format adding the year.
    The week number is calculated based on the number of WeeksPerYear setting. |
* StartingYear
    int Default is 3025.
    The base value used to calculate the year.
* WeeksPerYear
    int Default is 52.
    The base value used to calculate the week in the HBSFormat.
    Does not affect the TerranFormat.

------------
Requirements
------------
Warning: Uses the experimental BTML mod loader and ModTek that might change, come here again to check for updates 

* Install BattleTechModLoader
    https://github.com/Mpstark/BattleTechModLoader/releases
    using the instructions here:
    https://github.com/Mpstark/BattleTechModLoader
* Install ModTek
    https://github.com/Mpstark/ModTek/releases
    using the instructions here:
    https://github.com/Mpstark/ModTek/tree/master/ModTek

------------
Installation
------------

Extract/Copy the AddYearToTimeline folder to the mods directory of Battletech.
If you do not have a mods folder in the Battletech folder, please refer to the requirements installations first for details.

--------------
Special Thanks
--------------
This mod would not be possible without all tools and mods provided for the community by the following persons. Special thanks to:
* Pardeike : https://github.com/pardeike for Harmony.
* Mpstark : https://github.com/Mpstark for BTML and ModTek.
