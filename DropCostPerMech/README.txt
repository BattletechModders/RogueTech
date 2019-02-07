# DropCostPerMech
BattleTech mod (using BTML) that makes you pay an operational cost for each mech you want to use in a mission, based on its chassis price.

## Requirements
** Warning: Uses the experimental BTML mod loader that might change, come here again to check for updates **

* install [BattleTechModLoader](https://github.com/Mpstark/BattleTechModLoader/releases) using the [instructions here](https://github.com/Mpstark/BattleTechModLoader)

## Features
- You now pay an operational cost based on the mechs you send to the mission.
- Lighter mechs are cheaper so it's a decision if you really need those 4 assaults. 

## Settings
Setting | Type | Default | Description
--- | --- | --- | ---
percentageOfMechCost | float | default 0.0025 | set this to anything between 0 and 1 to set the percentage of the chassis cost you have to pay for the mission. 0 = 0%, 1 = 100%
CostByTons | bool | default false | set this to true if you want tonnage to be the factor to determine the drop costs.
cbillsPerTon | int | default 500 | if CostByTons is true, this sets the cost per ton.

## Download
Downloads can be found on [github](https://github.com/Morphyum/DropCostPerMech/releases).

## Install
- After installing BTML, put everything into \BATTLETECH\mods\ folder and launch the game.
- In \BATTLETECH\mods\DropCostPerMech you will find the settings.json in which you can change the settings.
- Start the game.

