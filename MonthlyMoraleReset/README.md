# MonthlyMoraleReset
This mod is my small attempt at changing the basic company morale system from HBS's BATTLETECH PC game.
## TL;DR Gameplay changes
* Introduce a morale reset at the end of each in game month.
* The new morale value can be seen in the monthly financial report.
* The reset is applied before the expenditure level is selected ensuring the selection bonus or malus affect the next period correctly.
* The reset base value is the _StartingMorale_ value from _SimGameConstants.json_.
This is overided by the mod to allow fine tuning to your linking. The basic value is still the defualt 25.
* The reset base value is adjusted by the Argo active (already built) upgrades.
* The mod also overides the expenditure levels morales maluses and bonuses. The basic modded values are -10, -5, +5 and +10 from the default -4, -2, +1 and +2.
## Description
The mod introduce a new morale reset at the end of each in game month, just before the monthly financial report is displayed. This allows a more meaningful usage of the in game assets and events. Upgrading the Argo now actually matters since each recreational upgrades are permanent and raise the monthly morale reset threshold by a few points. Each new event encountered now provide only a temporary bonus or malus but this can give a small edge when starting new missions until the next reset happens. This also change the mid to late game gameplay since you cannot permanently have a full morale bar anymore. The mod also raise the expenditure morale maluses and bonuses to reward _Generous_ and _Extravagant_ expenditure levels and at the same time punish _Restricted_ and _Spartan_ expenditure levels. Having a full morale bar now cost money and requires a few lucky events to show up.
## Requirements
** Warning: Uses the experimental BTML mod loader and ModTek that might change, come here again to check for updates **
* Install [BattleTechModLoader](https://github.com/Mpstark/BattleTechModLoader/releases) using the [instructions here](https://github.com/Mpstark/BattleTechModLoader)
* Install [ModTek](https://github.com/Mpstark/ModTek/releases) using the [instructions here](https://github.com/Mpstark/ModTek/tree/master/ModTek)
## Special Thanks
This mod would not be possible without all tools and mods provided for the community by the following persons. Special thanks to:
* [Andreas Pardeike](https://github.com/pardeike) for **Harmony**.
* [Mpstark](https://github.com/Mpstark) for **BTML** and **ModTek**
* [CptMoore](https://github.com/CptMoore) for **StartingMercsMod** and his code which inspîred my own.
* ACCount12 for **Better Sorting** and his code which gave me pointers about how to handle image data.
