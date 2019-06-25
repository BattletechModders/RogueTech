# BT-WeaponRealizer

## Download

Get the latest version from [https://github.com/janxious/BT-WeaponRealizer/releases](https://github.com/janxious/BT-WeaponRealizer/releases). **Do not** click the source code links.

## What is this?

Battletech:Game Mod - experiments in restoring lost functions to weapons, and adding new ones.

This supercedes my previous mod [Weapon Variance](https://github.com/janxious/BT-WeaponVariance)

## Features

* Multishot Ballistics - see `ShotsWhenFired` in def
* Clustered fire ballistics (LBX) - this is based on having a tag `wr-clustered_shots`, and will fire a cluster of size `ProjectilesPerShot` from weapon def
* Multishot Lasers - see `ShotsWhenFired` in def
* Damage variance +/- around specified damage - see `DamageVariance` in def
* Increased damage done when overheated - see `OverheatedDamageMultiplier` in def
* Heat damage converted to normal damage vs. vehicles, buildings, and turrets
* Damage dropoff by distance - configured by tag on weapon def of format `wr-variance_by_distance-X`; `X` is a multiplier that controls the rate at which damage diminishes with distance
* Refire Modifier crit multiplication - weapons can now have a bigger refire penalty when damaged (critted); see setting `damagedWeaponRefireModifierMultiplier`
* Weapon Jamming - weapons with weapon defs tagged `wr-jammable_weapon` can jam, based on refire modifier and `jamChanceMultiplier`/`wr-jam_chance_multiplier-X`; `X` multiplies the refire modifier to determine a percent chance of jamming happening; Rolls against gunnery skill to save vs. jam and unjam are preformed.

## LICENSE
MIT © 2018 Joel Meador
