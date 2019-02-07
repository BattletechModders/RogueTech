Fix for HBS Battletech - RogueTech mod for Vehicle Evasion and Ace Pilot skill use
This corrects Ace Pilot to work with vehicles because by default it only functions correctly for Mechs and 
when a vehicle attempts to use ace pilot skill after firing an exception is thrown and the vehicle no longer receives the evasion benefit of moving. 
Additional fix to allow higher evasion pips as well following same fix to mechs when equipment etc adds more evasion pips than would be given by skill and movement.

Change Log
Version 1.1
Removed patch to correct for null exception in Ace Pilot Skill use for vehicles as Battletech game version 1.3 has fixed this internally so this was no longer needed