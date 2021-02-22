# Quick Guide

### Base Case

* ChassisDef
    * Name: Canon chassis name
    * UIName: Canon chassis name
    * VariantName: Canon model name
* MechDef
    * Name: `ChassisDef.Name` + `ChassisDef.VariantName`
    * UIName: `MechDef.Name`

### Other cases flow

1. Is it a ProtoMech or Powered Armor?
    * See [ProtoMech / Powered Armor](#ProtoMech / Powered Armor)
1. Is it a RISC or Society model of a standard Mech?
   * Use the [Base Case](#Base Case) but use *-Z*, *-RX*, *-RSC* or similar ending suffix to its `VariantName`.
1. Is it a standard mech?
    1. Are there mechs of the same chassis?
        * Yes: Use same naming convention
    1. Is it an OmniMech?
        1. RogueOmni: See [MechDef](#MechDef) for special rules.
        1. Inner Sphere: Use the [Base Case](#Base Case)
        1. Clan:
            * ChassisDef.Name/UIName: Chassis name
            * ChassisDef.VariantName: Make up a fitting abbreviation for the chassis, add the configuration
              letter or number at the end.
            * MechDef.Name: `ChassisDef.Name` + configuration designation (e.g. Prime, A, etc)
            * UIName: `MechDef.Name`
1. Is it named after its MechWarrior?
    1. Is it based on a standard model of the same chassis?
        * ChassisDef.Name/UIName: Chassis name
        * ChassisDef.VariantName: Base model name, add a unique identifier at the end based on the Hero's name.
        * MechDef.Name: `ChassisDef.Name` + base model name
        * UIName: `ChassisDef.Name` + `ChassisDef.VariantName`
    1. Otherwise use the [Base Case](#Base Case) with the addition of adding the Hero name at the end of
       the `MechDef.UIName`
1. Is it a specially named Elite/Prototype/Hero Mech?
    * ChassisDef.Name/UIName: Chassis name
    * ChassisDef.VariantName: Chassis model prefix combined with a suitable abbreviation.
    * MechDef.Name: `ChassisDef.Name` + `ChassisDef.VariantName`
    * UIName: Special name

Not covered? Check examples, read the detailed explanations or ask Redbat.

# Examples

### Standard Mechs

| MechDef ID | Offical Name (if applicable)  | ChassisDef Name/UIName   | VariantName   | MechDef Name  | MechDef UIName   | Comment |
|---|---|---|---|---|---|---|
|mechdef_flea_FLE-4| Flea FLE-4 | Flea | FLE-4 | Flea FLE-4  | Flea FLE-4 | Base Case |
|mechdef_blackjack_BJ2-O| Blackjack BJ2-O | Blackjack | BJ2-O | Blackjack BJ2-O  | Blackjack BJ2-O | OmniMech, Inner Sphere, base configuration |
|mechdef_blackjack_BJ2-OE| Blackjack BJ2-OE | Blackjack | BJ2-OE | Blackjack BJ2-OE  | Blackjack BJ2-OE | OmniMech, Inner Sphere, alternate configuration |
|mechdef_adder_ADR-Prime|  Clan: Adder Prime <br>IS: Puma Prime| Adder | ADR-Prime | Adder Prime  | Adder Prime | OmniMech, Clan, base configuration |
|chassisdef_mad_cat_mk_ii_MCII-4|  Mad Cat Mark II A| Mad Cat Mk II | MCII-4 | Mad Cat Mk II MCII-4  | Mad Cat Mk II MCII-4 | OmniMech, Clan, alternate configuration |
|mechdef_babd_catha_BC-O|    | Archer  | BC-O  | Archer BC-O  | Babd Catha BC-O  | RogueOmni |

### Hero Mechs

| MechDef ID | Offical Name (if applicable)  | ChassisDef Name/UIName   | VariantName   | MechDef Name  | MechDef UIName   | Comment |
|---|---|---|---|---|---|---|
|mechdef_atlas_AS7-D_Danielle| Atlas AS7-D *Danielle*   | Atlas  | AS7-DD  | Atlas AS7-D  | Atlas AS7-D Danielle  | HeroMech, older VariantName style |
|mechdef_ostroc_OSR-2C-Michi| Ostroc OSR-2C *Michi*   | Ostroc  | OSR-2C-M  | Ostroc OSR-2C  | Ostroc OSR-2C Michi  | HeroMech, new VariantName style |

### Elite/Legendary Mechs

| MechDef ID | Offical Name (if applicable)  | ChassisDef Name/UIName   | VariantName   | MechDef Name  | MechDef UIName   | Comment |
|---|---|---|---|---|---|---|
|mechdef_rifleman_ii_RFL-3N-2_LK2|  Rifleman II RFL-3N-2 *Legend Killer*   | Rifleman II  | RFL-3N-2-LK2  | Rifleman II RFL-3N-2  | Legend Killer  | Elite mech based on a base model |
|mechdef_rifleman_RFL-DB|  *Dao Breaker*  | Rifleman  | RFL-DB  | Rifleman RFL-DB  | Dao Breaker  | Elite mech **not** based on a base model |
|mechdef_blood_asp_BAS-Z|    | Blood Asp  | BAS-Z  | Blood Asp BAS-Z  | Blood Asp BAS-Z  | Society Mech |

### Power Armor / ProtoMech

| MechDef ID | Offical Name (if applicable)  | ChassisDef Name/UIName   | VariantName   | MechDef Name  | MechDef UIName   | Comment |
|---|---|---|---|---|---|---|
|mechdef_amazon_IS-A_Rifle|  Amazon IS-A (Rifle loadout)   | Amazon  | IS-A  | Amazon IS-A  | Amazon IS-A  | Non-base loadout of Power Armor |
|mechdef_harpy_HRP-1| Harpy 1   | Harpy  | HRP-1 | Harpy 1  | Harpy 1 | ProtoMech|

# Use in Roguetech Mods

## Low Visibility
The LowVis mod heavy relies on several different fields from the JSON files based on what sensor and information level the opposing Mechs are on the combat map.\
Based on the sensor information level the mod selects what to display as the nametag following this pattern:

* No Sensor Information: Display `?`
* Location and type Display `Mech`
* Armor and weapon type: Display `ChassisDef.Name`
* Structure and weapon: Display `MechDef.Name`
* All information: Display `MechDef.UIName`

For Non-hostile and the Player's own Mechs it uses the custom name (set by Player) first if there is one, otherwise the `MechDef.UIName`.

More information can be found in the mods [README](https://github.com/BattletechModders/LowVisibility)

## IRTweaks
This mod switches certain locations to use a different than default naming source:
* MechLab Info Widget: Uses `MechDef.UIName`
* Lance Drop selection Panel: Uses `MechDef.UIName`
* Mech Tooltip: Player set name or `Chassis.Name` + `Chassis.VariantName`

More information can be found in the mods [README](https://github.com/BattletechModders/IRTweaks)

# Detailed Explanations

Below is the general considerations when naming a mech with a more detailed reasoning.\
Just be aware that a lot of mechs **don't follow** these rules yet, and should possibly be given a pass over at some
point.

## ChassisDef

The ChassisDef naming patterns are fairly straightforward with a few exceptions.

### Name / UIName

Both name fields in the ChassisDef should be the base name of the Chassis the mech represents, even if a Legendary,
Elite or HeroMech.\
This is to hide its configuration until more sensor information is received. See LowVisibility section for more
information.\

* If there are roman numerals in the name (e.g. *IIC*, *II*, *Mk. II*), this is considered part of the chassis name.
* If it is a Clan Mech, and it has an Inner Sphere and a Clan name, we generally use the Clan name.

###### Exception

The exception to this is some special cases where we want to hide that it is in fact an upgrade chassis.\
This is used to hide the modified OmniMechs in the RogueOmnis-Module, such as the *Badb Catha* which is a modified *
Archer*-chassis.\
However, this should be the only cases where this is done.

### VariantName

#### Base Rule

The VariantName field is what is displayed in the MechLab grid of available 'Mechs.\
Due to this it should always be unique, so it doesn't appear that two similar mechs are in fact the same one due to same
displayed text in the grid.\

#### Special (Hero, Legendary or EliteMechs)

If a special model has the same official model name is same as another model, it is recommended to add a dash followed
by an abbreviation of their special name (in some cases the dash is skipped). E.g. *Rifleman RFL-3N-2 Legend Killer* has
the VariantName *RFL-3N-2-LK*.

###### Note

The VariantNames have not consistently been done like this, so a lot of clashes still exist between model names.

#### OmniMech

###### Inner Sphere

The Inner Sphere OmniMechs generally follow the pattern of having a proper VariantName, which is usable directly.\
The base load-out is the general model name, and the others just add a letter at the end.\
This pattern is also followed by the Word of Blake Celestial series of OmniMechs.

###### Clan

Clan OmniMechs generally follow the pattern of either a single letter, or a number, for the configurations, and with the base configuration being named *Prime* or *1*.\
Since this is not possible to use as a VariantName in most cases an abbreviation of their chassis name is made up, and the VariantName is created by adding the actual configuration name after a dash, e.g.
*Adder Prime* results into the VariantName *ADR-Prime*.\
* There are some inconsistencies on if *Prime* should be in all capital letters or not, but usually it is not.
* If there are roman numerals in the chassis name, they are generally included in the variant name as well. E.g *Mad Cat
  Mk II 1* has the variant name *MCII-1*
* If the base configuration does not have a *Prime*, *A*, *1* or similar designation, use the one that matches with the sequence of the other configurations.

###### ProtoMech / Powered Armor

* ProtMechs generally follow the base rule combined with the clan OmniMech VariantName rule
* Another exception to the base rule for Powered Armor is that they have the same model name if the
load-out is the only difference.\
E.g. both versions of the *Amazon IS-A* have the VariantName *IS-A*.

## MechDef

The MechDef naming patters are considerably more intricate and depends on several factors such as the 'Mech is an
OmniMech, if it is a special Hero/Elite or a Word of Blake 'Mech and so on.

### Name

The **Name** field on the MechDef is used to display Chassis and VariantName combined.\
This represents when you have enough vision and/or sensor information to see its basic traits, but not the actual
configuration.\

#### Base Rule

Normally this is done by just adding the ChassisDef Name and VariantName fields together, however there are a number of
exceptions.

#### Omni

The original intent was to have Clan OmniMechs actually display their canon name, e.g. *Adder Prime* rather than *Adder
ADR-Prime*.\
However this has not been fully implemented yet, but we should aim to use it from now on.\
If it is a RogueOmni mech, use the *fake* chassis name together with the actual VariantName.

#### Special (Hero, Legendary or EliteMechs)

To hide the fact that the 'Mech is a special one before players have a good enough sensor lock on it, the **Name**-field
for such variants should be the model they are based on **if there is one**.\
This way it can be a surprise to the player that the 'Mech they thought was a simple base model is a fully upgraded
Elite one when they get closer.

### UIName

The **UIName** field on the MechDef is used when you have almost all or all sensor information of a 'Mech. This is the
most detailed name.\

#### Base Rule

The Base Rule is that it should be the same as the MechDef *Name* field, however there are a lot of special cases.

#### Special (Hero, Legendary or EliteMechs)

Depending on the canon name the special 'Mechs can be handled in several ways.\

* If the name is unique and same as the **MechDef.Name**, just use that.
* If the name is a base mech with the MechWarriors name added at the end (e.g. *Atlas AS7-D Danielle*), the **UIName** is
  constructed by adding the hero name to the **MechDef.Name**-fields value, which most of the time then will match the canon
  name.
* If the name is a specific Hero, Elite, Prototype model or similar, e.g. the *Supernova* (a *Boiler* custom model), the **UIName** can be just the special name.
