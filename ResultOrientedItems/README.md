ResultOrientedItems (ROI) is a mod for HBS's Battletech computer game. It was inspired by [ajkroeg's MoneyCanBuyLove][https://github.com/ajkroeg/MoneyCanBuyLove], and allows mod authors to associate items with effects, allowing items to have effects beyond sitting there passively in the player's inventory. The mod's homepage is https://github.com/BlueWinds/ResultOrientedItems, where you can always find the most up to date source code.

ROI does very little on its own - it is a dll designed to open up possibilities for other content creators to work with. It comes with a few sample items and events, but these are far from the only use.

ROI is distributed under the GNU General Public License v3.0 license. Special permission is granted to Battletech Advanced: 3062 and Roguetech to distribute this alongside Custom Bundle and other proprietary code. Please reach out to BlueWinds on github, or the BTA/RogueTech discords for more details.

## Triggering ItemEvents
Whenever an item (UpgradeDef, JumpJetDef, WeaponDef, etc) would be added to the player's inventory, ROI checks to see if any `itemEvents.Item` matches. If one is found, the `Requirements` are checked, and if all are found to match, the the `Results` are applied.

If the ItemEvent's `AllowInInventory` is false, then the item disappears without even entering the player's possession. If true, they get it as normal.

That's it.

## Additional options for Results
ROI also patches SetSimGameStat to give mod authors additional power. You can now use `Reputation.Owner` as a stat name, which will be converted to the current system owner before being applied. It respects a faction's `DoesGainReputation`, so Locals will still never gain or lose rep. For example:
```
"Stats": [
  {
    "typeString": "System.Int32",
    "name": "Reputation.Owner",
    "value": "15",
    "set": false
  }
],
```
will give the player +15 rep with the system owner (as long as they aren't the Locals).
