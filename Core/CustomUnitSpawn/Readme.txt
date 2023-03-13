this mod makes units selecting by tags little bit more fuzzy
  "Settings": {
    "required_tags_weights": {
      "test_unit_mech": { "weight": 100, "replace": [ "unit_mech1", "unit_mech2", "" ] },
      "test_unit_legendary":  { "weight": 10, "replace": [ "unit_legendary1", "unit_legendary2", "" ] },
      "test_terranhegemony":  { "weight": 5, "replace": [ "terranhegemony1", "terranhegemony2", "" ] },
      "test_unit_bracket_high":  { "weight": 1, "replace": [ "unit_bracket_high1", "unit_bracket_high2", "" ] },
      "test_unit_noncombatant":  { "weight": 1000, "replace": [ "unit_noncombatant1", "unit_noncombatant2", "" ] },
    }
    "excluded_tags_weights": {
      "test_unit_light": { "weight": 20, "replace": [ "unit_light1", "unit_light2", "" ] },
      "test_unit_generic": { "weight": 1000, "replace": [ "unit_generic1", "unit_generic2", "" ] },
      "test_NoBiome_highlandsSpring":  { "weight": 50, "replace": [ "" ] }
    }
  },

if on certain units selection it encounters empty result it will try to replace tags (both excluded and required)
according settings. It starts from lower weight tags. Tags not mentioned in tags_weights have effective weight 9999.0
Empty string in "replace" array means tag can be removed
for example you have required tags "test_unit_mech" (100), "test_terranhegemony" (5) excluded tags "test_unit_light" (20), "test_NoBiome_highlandsSpring" (50)
it will try

"test_unit_mech", "test_terranhegemony" | "test_unit_light", "test_NoBiome_highlandsSpring"
"test_unit_mech", "terranhegemony1" | "test_unit_light", "test_NoBiome_highlandsSpring"
"test_unit_mech", "terranhegemony2" | "test_unit_light", "test_NoBiome_highlandsSpring"
"test_unit_mech", | "test_unit_light", "test_NoBiome_highlandsSpring"
"test_unit_mech", "test_terranhegemony" | "unit_light1", "test_NoBiome_highlandsSpring"
"test_unit_mech", "terranhegemony1" | "unit_light1", "test_NoBiome_highlandsSpring"
"test_unit_mech", "terranhegemony2" | "unit_light1", "test_NoBiome_highlandsSpring"
"test_unit_mech", | "unit_light1", "test_NoBiome_highlandsSpring"
"test_unit_mech", "test_terranhegemony" | "unit_light2", "test_NoBiome_highlandsSpring"
"test_unit_mech", "terranhegemony1" | "unit_light2", "test_NoBiome_highlandsSpring"
"test_unit_mech", "terranhegemony2" | "unit_light2", "test_NoBiome_highlandsSpring"
"test_unit_mech", | "unit_light2", "test_NoBiome_highlandsSpring"
"test_unit_mech", "test_terranhegemony" |  "test_NoBiome_highlandsSpring"
"test_unit_mech", "terranhegemony1" |  "test_NoBiome_highlandsSpring"
"test_unit_mech", "terranhegemony2" |  "test_NoBiome_highlandsSpring"
"test_unit_mech", | "test_NoBiome_highlandsSpring"
"test_unit_mech", "test_terranhegemony" | "test_unit_light"
"test_unit_mech", "terranhegemony1" | "test_unit_light"
"test_unit_mech", "terranhegemony2" | "test_unit_light"
"test_unit_mech", | "test_unit_light"
"test_unit_mech", "test_terranhegemony" | "unit_light1"
"test_unit_mech", "terranhegemony1" | "unit_light1"
"test_unit_mech", "terranhegemony2" | "unit_light1"
"test_unit_mech", | "unit_light1"
"test_unit_mech", "test_terranhegemony" | "unit_light2"
"test_unit_mech", "terranhegemony1" | "unit_light2"
"test_unit_mech", "terranhegemony2" | "unit_light2"
"test_unit_mech", | "unit_light2"
"test_unit_mech", "test_terranhegemony" | 
"test_unit_mech", "terranhegemony1" |  
"test_unit_mech", "terranhegemony2" |  
"test_unit_mech", | 
"unit_mech1", "test_terranhegemony" | "test_unit_light", "test_NoBiome_highlandsSpring"
"unit_mech1", "terranhegemony1" | "test_unit_light", "test_NoBiome_highlandsSpring"
"unit_mech1", "terranhegemony2" | "test_unit_light", "test_NoBiome_highlandsSpring"
"unit_mech1", | "test_unit_light", "test_NoBiome_highlandsSpring"
"unit_mech1", "test_terranhegemony" | "unit_light1", "test_NoBiome_highlandsSpring"
"unit_mech1", "terranhegemony1" | "unit_light1", "test_NoBiome_highlandsSpring"
"unit_mech1", "terranhegemony2" | "unit_light1", "test_NoBiome_highlandsSpring"
"unit_mech1", | "unit_light1", "test_NoBiome_highlandsSpring"
"unit_mech1", "test_terranhegemony" | "unit_light2", "test_NoBiome_highlandsSpring"
"unit_mech1", "terranhegemony1" | "unit_light2", "test_NoBiome_highlandsSpring"
"unit_mech1", "terranhegemony2" | "unit_light2", "test_NoBiome_highlandsSpring"
"unit_mech1", | "unit_light2", "test_NoBiome_highlandsSpring"
"unit_mech1", "test_terranhegemony" |  "test_NoBiome_highlandsSpring"
"unit_mech1", "terranhegemony1" |  "test_NoBiome_highlandsSpring"
"unit_mech1", "terranhegemony2" |  "test_NoBiome_highlandsSpring"
"unit_mech1", | "test_NoBiome_highlandsSpring"
"unit_mech1", "test_terranhegemony" | "test_unit_light"
"unit_mech1", "terranhegemony1" | "test_unit_light"
"unit_mech1", "terranhegemony2" | "test_unit_light"
"unit_mech1", | "test_unit_light"
"unit_mech1", "test_terranhegemony" | "unit_light1"
"unit_mech1", "terranhegemony1" | "unit_light1"
"unit_mech1", "terranhegemony2" | "unit_light1"
"unit_mech1", | "unit_light1"
"unit_mech1", "test_terranhegemony" | "unit_light2"
"unit_mech1", "terranhegemony1" | "unit_light2"
"unit_mech1", "terranhegemony2" | "unit_light2"
"unit_mech1", | "unit_light2"
"unit_mech1", "test_terranhegemony" | 
"unit_mech1", "terranhegemony1" |  
"unit_mech1", "terranhegemony2" |  
"unit_mech1", | 
"unit_mech2", "test_terranhegemony" | "test_unit_light", "test_NoBiome_highlandsSpring"
"unit_mech2", "terranhegemony1" | "test_unit_light", "test_NoBiome_highlandsSpring"
"unit_mech2", "terranhegemony2" | "test_unit_light", "test_NoBiome_highlandsSpring"
"unit_mech2", | "test_unit_light", "test_NoBiome_highlandsSpring"
"unit_mech2", "test_terranhegemony" | "unit_light1", "test_NoBiome_highlandsSpring"
"unit_mech2", "terranhegemony1" | "unit_light1", "test_NoBiome_highlandsSpring"
"unit_mech2", "terranhegemony2" | "unit_light1", "test_NoBiome_highlandsSpring"
"unit_mech2", | "unit_light1", "test_NoBiome_highlandsSpring"
"unit_mech2", "test_terranhegemony" | "unit_light2", "test_NoBiome_highlandsSpring"
"unit_mech2", "terranhegemony1" | "unit_light2", "test_NoBiome_highlandsSpring"
"unit_mech2", "terranhegemony2" | "unit_light2", "test_NoBiome_highlandsSpring"
"unit_mech2", | "unit_light2", "test_NoBiome_highlandsSpring"
"unit_mech2", "test_terranhegemony" |  "test_NoBiome_highlandsSpring"
"unit_mech2", "terranhegemony1" |  "test_NoBiome_highlandsSpring"
"unit_mech2", "terranhegemony2" |  "test_NoBiome_highlandsSpring"
"unit_mech2", | "test_NoBiome_highlandsSpring"
"unit_mech2", "test_terranhegemony" | "test_unit_light"
"unit_mech2", "terranhegemony1" | "test_unit_light"
"unit_mech2", "terranhegemony2" | "test_unit_light"
"unit_mech2", | "test_unit_light"
"unit_mech2", "test_terranhegemony" | "unit_light1"
"unit_mech2", "terranhegemony1" | "unit_light1"
"unit_mech2", "terranhegemony2" | "unit_light1"
"unit_mech2", | "unit_light1"
"unit_mech2", "test_terranhegemony" | "unit_light2"
"unit_mech2", "terranhegemony1" | "unit_light2"
"unit_mech2", "terranhegemony2" | "unit_light2"
"unit_mech2", | "unit_light2"
"unit_mech2", "test_terranhegemony" | 
"unit_mech2", "terranhegemony1" |  
"unit_mech2", "terranhegemony2" |  
"unit_mech2", | 
"test_terranhegemony" | "test_unit_light", "test_NoBiome_highlandsSpring"
"terranhegemony1" | "test_unit_light", "test_NoBiome_highlandsSpring"
"terranhegemony2" | "test_unit_light", "test_NoBiome_highlandsSpring"
| "test_unit_light", "test_NoBiome_highlandsSpring"
"test_terranhegemony" | "unit_light1", "test_NoBiome_highlandsSpring"
"terranhegemony1" | "unit_light1", "test_NoBiome_highlandsSpring"
"terranhegemony2" | "unit_light1", "test_NoBiome_highlandsSpring"
| "unit_light1", "test_NoBiome_highlandsSpring"
 "test_terranhegemony" | "unit_light2", "test_NoBiome_highlandsSpring"
 "terranhegemony1" | "unit_light2", "test_NoBiome_highlandsSpring"
 "terranhegemony2" | "unit_light2", "test_NoBiome_highlandsSpring"
| "unit_light2", "test_NoBiome_highlandsSpring"
 "test_terranhegemony" |  "test_NoBiome_highlandsSpring"
 "terranhegemony1" |  "test_NoBiome_highlandsSpring"
 "terranhegemony2" |  "test_NoBiome_highlandsSpring"
| "test_NoBiome_highlandsSpring"
 "test_terranhegemony" | "test_unit_light"
 "terranhegemony1" | "test_unit_light"
 "terranhegemony2" | "test_unit_light"
| "test_unit_light"
"test_terranhegemony" | "unit_light1"
"terranhegemony1" | "unit_light1"
"terranhegemony2" | "unit_light1"
| "unit_light1"
"test_terranhegemony" | "unit_light2"
"terranhegemony1" | "unit_light2"
"terranhegemony2" | "unit_light2"
| "unit_light2"
"test_terranhegemony" | 
"terranhegemony1" |  
"terranhegemony2" |  
| 

once it find required/excluded tags sets variant with nonempty result it stops searching ad returns result list to caller