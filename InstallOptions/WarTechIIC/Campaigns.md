# Custom Campaigns
While the Milestone and Flashpoint systems in the base game are extremely flexible and powerful, they are also cumbersome and verbose; custom campaigns end up spread across dozens of files totally thousands of lines of JSON. Ask me how I know. ^^;;

WIIC provides an alternative format for creating custom campaigns. Campaigns do not map exactly onto any one concept in the base game; they hook into many different places. They:
- Can trigger events, sim game conversations and play cutscenes
- Offer rewards (rewardes) and contracts
- Ask the player to fly to different star systems to continue the story
- Have their own simple language for flow control and conditions

The overall goal is to make creating campaigns a pleasant and simple experience. They are written in YAML, which is very human-readible and less prone to mistakes than JSON.

## How they work
Campaigns begin by adding a company tag: `WIIC_begin_campaign {name}` (eg: `WIIC_begin_campaign Sword of Restoration`). They will never spawn on their own; you'll need to write an event (or some other result) that gives the player a company tag.

Campaigns have only a few top-level fields:
 - `name` - The name of the campaign. This should match the filename, and will be displayed to the player.
 - `beginsAt` - A star system where the campaign begins. This has no mechanical effect, but is displayed to the player iindicating where to go to get started.
 - `nodes` - A dictionary of named flow-control points. A campaign always begins with a node named `Start`.

Each node is a sequential list of Entries, representing something presented to the player, some action they must take, or a flow-control statement (`goto`) telling the campaign what happens next.

The final Entry in a node must *always* be `goto` without an `if` block. Flow control is never implicit, there is always a next step.

Example:
```
name: Sword of Restoration
beginsAt: starsystemdef_Coromodir

nodes:
  # YAML files support comments; any lines beginning with "#" are ignored.
  Start:
    - event:
        id: sword_1_post_coronation
    - goto: End
  End:
    - video: 1A-prologue.bk2
    - goto: Exit
```

All entries can have a condition applied, using `if`:

```
  Start:
    - if:
        companyHasTag: <tagName>
        companyDoesNotHaveTag: <tagName>
      event:
        id: <some event>
```

The entry will only happen if all the given conditions are true; if any are false, the entry is skipped. Usually you'll only use one condition in an `if` block.

The various types of entries are explained below.

### `goto`
The basic flow-control statement of a Campaign. It moves the campaign from the current node to a different one. The first Entry in the given node triggers immediately.

Example:
```
  Start:
    - if:
        companyHasTag: some_tag
      goto: NextNode
    - goto: Exit
  NextNode:
    - <...etc...>
```

The value of `goto` is either the name of another node, or `Exit` - the campaign is over!

### `event`
Triggers an event. Events (or conversations) are usually how players make decisions; use the `Options` in an event to add company tags, then follow up the `event` entry with forking `goto` based on their choice. The next Entry triggers once the event is concluded.

Example:
```
  Start:
    - event:
        id: event_FP_Storytime0
    - if:
        companyHasTag: decisionA
      goto: BranchA
    - goto: BranchB
  BranchA:
    - ...etc...
  BranchB:
    - ...etc...
```

`id` is, straightforwardly, an event id. Its requirements are ignored; use an `if` condition instead. Only events with `Company` or `Commander` scope are supported at the moment. If you really want another event scope for some reason, ask BlueWinds.

### `video`
Play a cutscene. The next Entry triggers once the video is done playing (or the player skips it).

Example:
```
  - video: 1A-prologue.bk2
```

The value is the name of file. You can either use Videos from the base game (`Battletech_Data/Videos/*.bk2`) or a [custom video loaded with ModTek](https://github.com/BattletechModders/ModTek/tree/master?tab=readme-ov-file#custom-types).

### `reward`
Give the player an itemcollection. This pops up a reward dialogue. The next Entry triggers once the reward is dismissed.

Example:
```
  - reward: Sword_Reward_Basic
```

### `fakeFlashpoint`
Add a fake flashpoint to the galaxy map. The campaign will be on hold until the player flys to that start system and accepts it. Beginning the fake "flashpoint" triggers the next Entry.

Example:
```
  - fakeFlashpoint:
      name: Arano Restoration - Coronation
      employer: AuriganRestoration
      employerPortrait: castDef_DariusDefault
      target: Unknown
      at: starsystemdef_Coromodir
      
      # You can use multi-line strings in yaml with "|". No "\r\n" like in JSON!
      description: |
        Your old mentor, Raju, has invited you to be one of [[DM.BaseDescriptionDefs[LoreKameaArano],Lady Kamea Arano's]] honor guards on the day of her coronation. Travel to [[DM.BaseDescriptionDefs[LoreCoromodir],Coromodir]] to meet with him.

        The [[DM.BaseDescriptionDefs[LoreAuriganCoalition],Aurigan Coalition]] will supply you with a mech for use in her procession, a venerable Shadowhawk that has been with the Aurigan Royal Guard for decades.
```

All fields are required. `employer` and `target` need not be who the player is actually going to fight for / against; they're display only.

`at` can be the current system; this is a fine way to offer the player break points in the action that they can return to later.

### `contract`
Offer a contract in the command center. Any requirements on the contract are ignored; use an `if` condition instead. If successful, the campaign moves onto the next Entry; if the player fails the mission, we go to `onFailGoto` instead (exactly as `goto`, explained above). It is recommended, but not required, that `onFailGoto` send the player to a `fakeFlashpoint` - this lets them put the campaign on hold, giving time to heal up, repair damage and build a stronger lance.

A contract always spawns in the current star system, and always blocks travel. Use a `fakeFlashpoint` to have the user travel or allow them to leave; custom campaigns do not support travel contracts for several reasons (mainly because they're extremely hard to work with programatically).

Example:
```
  - contract:
      id: Sword_4_LiberationOfWeldry
      employer: AuriganRestoration
      target: AuriganDirectorate
      onFailGoto: LiberationOfWeldry

      postContractEvent: sword_4_postcontract

      # A contract can only have withinDays or immediate, not both
      withinDays: 7
      immediate: true
```

`id`, `employer`, `target` and `onFailGoto` are required, all others are optional.

`postContractEvent` deserves some special explanation. If the player succeeds at the mission, the given event *replaces the objectives screen* in the after action report. The event must be `Company` or `StarSystem` scoped; no other scopes are supported.

*DO NOT* set `"disableAfterAction": true` or `travelOnly` in contracts, WIIC-campaign related or not; skipping the AAR will soft-lock the game, and travelOnly contracts have a variety of issues. This is a basegame issue, not caused by WIIC or any other mod, and I'm not going to fix it.

#### Time pressure
A contract without `withinDays` or `immediate` spawns without a time limit; the player can take other contracts and pass as much time as they please; the contract will wait for them, but they cannot leave the current system.

When a `withinDays` contract is available, it blocks all other contracts, and begins a ticking countdown of days; when it reaches zero (or immediately if it's set to `0`), the player is forced into the drop. They can still access the barracks, system store, save, load, etc, even if the countdown is 0. They just can't leave the system or take any other contracts.

`immediate` contracts are even more pressing; they lock the player in the command center, allowing them to save the game, but otherwise forcing an immediate drop - no time to visit the store, hire pilots, or do anything other than accept the contract.

### `conversation`
Trigger a SimGameConversation. Conversations are more immersive, but significantly more challenging to create, than Events. They also serve as an excellent place to offer the player choices. The next Entry triggers once the conversation is over.

Example:
```
  - conversation:
      id: StoryTime2-RentToOwn
      header: BETRAYAL AND DEBT
      subheader: In Orbit - Ur Cruinne
      characters:
        Kamea: true
        Darius: false
  - if:
      companyHasTag: refused_to_continue_storytime_campaign
    goto: Exit
```

`id`, `header`, `subheader` are required, while `characters` is optional. Create conversations using [ConverseTek](https://github.com/CWolfs/ConverseTek/).

`characters` controls who will be present / visible for the conversation. The default value is:
```
  Darius: true
  Farah: true
  Sumire: true
  Yang: true
  Kamea: false
  Alexander: false
```

You only need to set values that you want to change. Visible characters will be reset to the default after each conversation.

### `wait`
Wait for some number of days to pass, optionally with a work order.

Example:
```
  - wait:
      days: 10
      
  - wait:
      days: 14
      workOrder: Wait for further details
      sprite: uixTxrLogo_SelfEmployed
```

`workOrder` and `sprite` are optional (but go together). If there's no `workOrder`, the player will have no feedback that the campaiign is ongoing while the counter ticks down; use this sparingly.

### `popup`
Show a pause popup notification. Use this sparingly, but it's another option to present information / short bits of flavor to the player.

Example:
```
  - popup:
      title: Axylus
      sprite: guiTxrPort_Sumire_default_utr
      message: Commander, I'm setting a course for Lady Centrella's JumpShip. It's strange, though... this moon it's taking us to, Axylus, doesn't appear on any of my maps. Which leads me to wonder: where, exactly, are we going, and how do they intend to get us there?
```

All fields (`title`, `sprite`, `message`) are required. The title and message can be mad-libbed; you can use `COMPANY`, `COMANDER` and `TGT_SYSTEM` (current star system) to fill in text.
