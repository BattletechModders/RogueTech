WarTechIIC (WIIC) is a mod for HBS's Battletech computer game. It's inspired by the likes of WarTech, GalaxyAtWar, and RogueTech's PersistantMap. The mod's homepage is https://github.com/BlueWinds/WarTechIIC, where you can always find the most up to date source code.

WIIC is distributed under the GNU General Public License v3.0 license. Special permission is granted to Battletech Advanced: 3062 and Roguetech to distribute this alongside Custom Bundle and other proprietary code. Please reach out to BlueWinds on github, or the BTA/RogueTech discords for more details.

In order to keep the README at a manageable size, it is broken into three sections.
  - [Flareups.md](./Flareups.md) - Deals with Attacks and Raids, where factions on the galactic map fight for control of entire planets.
  - [ExtendedContracts.md](./ExtendedContracts.md) - Deals with scripted contracts that unfold over the course of multiple days or weeks. They also provide a new framework for creating custom campaigns.
  - [Campaigns.md](./Campaigns.md) - Deals with scripted campaigns. Similar to flashpoints, they are both significantly easier to work with and can be spread across multiple star systems.
  - The rest of this README deals with misc additional functionality that WIIC adds to the game.

# Simgame statistics and tags
WIIC reads and sets a variety of tags and statistics on companies and star systems. These can be used in conditions, set, updated or removed from events and flashpoints like any other stat or tag.

### Company Tags
When naming star systems, remember to use the ID and not the name. You want `starsystemdef_St.Ives`, not `St. Ives`. For factions, refer to them by factionID. You want `ClanCloudCobra`, not `Clan Cloud Cobra` or `faction_ClanCloudCobra`. This is slightly inconsistent, yes, but I work with what HBS gives me.

  * `WIIC_give_{system}_to_{newOwner}` (eg: `WIIC_give_starsystemdef_Terra_to_ClanWolf`) - Setting this will pass control of the named star system to the new owner. The tag won't actually added to the company - WIIC 'eats' it.
  * `WIIC_{faction}_attacks_{system}` (eg: `WIIC_Clan Jade Falcon_attacks_starsystemdef_Terra`) - Setting this will cause a new Attack to start in the given system, with the faction as the attacker, if one doesn't already exist. The tag won't actually added to the company - WIIC 'eats' it.
    * `WIIC_{faction}_attacks_SOMEWHERE` (eg: `WIIC_Clan Jade Falcon_attacks_SOMEWHERE`) - Special case of the above; the target system is chosen using the usual logic, rather than specified by the tag.
  * `WIIC_give_{system}_to_{newOwner}_on_attacker_win` (eg:  `WIIC_give_starsystemdef_Terra_to_ClanWolf_on_attacker_win`) - Setting this will cause the named star system to be given to {newOwner} *rather than* the attacker when an Attack on this system ends. Win or lose, the effect is cleared after the current attack.
  * `WIIC_{faction}_raids_{system}` (eg: `WIIC_Clan Jade Falcon_raids_starsystemdef_Terra`) - Setting this will cause a new Raid to start in the given system, with the faction as the raider, if one doesn't already exist. The tag won't actually added to the company - WIIC 'eats' it.
    * `WIIC_{faction}_raids_SOMEWHERE` (eg: `WIIC_Clan Jade Falcon_raids_SOMEWHERE`) - Special case of the above; the target system is chosen using the usual logic, rather than specified by the tag.
  * `WIIC_set_{system}_{attacker|defender}_strength_{number}` (eg: `WIIC_set_starsystemdef_Terra_defender_strength_10`) - Setting this will adjust the attacker or defender's strength in that system's flareup, if there is one. The tag won't actually added to the company - WIIC 'eats' it.
  * `WIIC_add_{tag}_to_{system} | WIIC_remove_{tag}_from_{system}` (eg: `WIIC_add_planet_other_pirate_to_starsystemdef_Terra` or `WIIC_remove_planet_other_pirate_from_starsystemdef_Terra`) - Setting this will add or remove the given tag from the given system. The tag won't actually added to the company - WIIC 'eats' it.
  * `WIIC_{employer}_offers_{contractID}_at_{system}_against_{target}` (eg: `WIIC_ClanJadeFalcon_offers_StoryTime_3_Axylus_Default_at_systemdef_Sol_against_ClanWolf`) - Setting this will cause the employer to offer a travel contract of the given type to the player at the given system.
  * `WIIC_{employer}_offers_extended_{contractID}_at_{system}_against_{target}` (eg: `WIIC_ClanJadeFalcon_offers_Garrison Duty_at_systemdef_Sol_against_ClanWolf`) - Setting this will cause WIIC to spawn the given extended contract at the given system with this employer and target. Note that this *ignores `employer`, `target` and `spawn_location`*, and just does the thing.
  
  * `WIIC_begin_campaign {campaignName}` (eg: `WIIC_begin_campaign Sword of Restoration`) - Begin the given campaign. See Campaigns.md for more details about custom campaigns. If it's already active, nothing will happen. Note the space, not the underscore, between `WIIC_begin_campaign` and the name.

### Company Stats
For all company stats, `-1` is a magic value - "ignore this". If present, we'll read the value from settings.json rather than the stat.

  * `WIIC_dailyAttackChance` (float) If present, this overrides the `dailyAttackChance` from settings.json. -1 will use the value from settings.json.
  * `WIIC_dailyRaidChance` (float) If present, this overrides the `dailyRaidChance` from settings.json. -1 will use the value from settings.json.
  * `WIIC_{attacker}_aggression` (float) If present, this overrides `aggression[attacker]` from settings.json. -1 will use the value from settings.json.
  * `WIIC_{attacker}_hates_{defender}` (float) If present, this overrides `hatred[attacker][defender]` from settings.json. -1 will use the value from settings.json.
  * `WIIC_{faction}_attack_strength` (int) Adds to the attack strength of any flareups or raids the faction engages in. Can be negative. Note that this is *additive* - it does not override that faction's default values. If you modify this from events, please add or subtract rather than set a value - Raids also adjust this, so setting a value would overwrite the raid history.
  * `WIIC_{faction}_defense_strength` (int) Adds to the attack strength of any flareups or raids the faction engages in. Can be negative. Note that this is *additive* - it does not override that faction's values. If you modify this from events, please add or subtract rather than set a value - Raids also adjust this, so setting a value would overwrite the raid history.

# Misc functionality
WarTechIIC modifies several base-game features.
  * Contracts in the current system refresh every time the month rolls over.
  * Contracts in the command center are sorted by difficulty (with travel contracts at the bottom and priority contracts at the top).
  * Contract descriptions can now use `{RES_OBJ}` for self-referencing descriptions ("mad libs"). For example, a contract can use its own name, `{RES_OBJ.Name}`, inside its `shortDescription`.
