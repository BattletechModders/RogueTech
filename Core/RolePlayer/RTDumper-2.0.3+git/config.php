<?php
class Config{
   public static $RT_Mods_dir="C:\games\steam\steamapps\common\BATTLETECH\Mods";
   public static $ignore_mechs_with_tags=array('no_rp_tool');

   #These are meant for developers
   public static $debug=FALSE;
   public static $info=FALSE;
   public static $warn=FALSE;
  
   public static $debug_single_mech=null;

   //useful to see the calculation for multiple mechs at a time when debugging the tag
   public static $debug_mechs_ai_tag=array();
   //public static $debug_mechs_ai_tag=array('ai_dfa','mechdef_ajax_AJX-A2','mechdef_highlander_HGN-732b','mechdef_elemental_toad','mechdef_black_queen_LVT-BKQN','mechdef_falcon_FLC-4N','mechdef_anvil_ANV-3M');
   //public static $debug_mechs_ai_tag=array('ai_melee','mechdef_atlas_AS7-C','mechdef_black_queen_LVT-BKQN',"mechdef_obsidian_skull_AS-IIC-OS","mechdef_moozilla_CM-XXX3");
   //public static $debug_mechs_ai_tag=array('ai_flank',"mechdef_ajax_AJX-A2","mechdef_ajax_AJX-X1","mechdef_albatross_ALB-3U","mechdef_anvil_ANV-6M","mechdef_anvil_ANV-8M","mechdef_arctic_cheetah_ACH-C","mechdef_arctic_cheetah_ACH-D","mechdef_arctic_cheetah_ACH-Prime","mechdef_adder_ADR-C");
	//public static $debug_mechs_ai_tag=array('ai_lance','mechdef_anvil_ANV-3M','mechdef_adder_ADR-A','mechdef_ajax_AJX-A2','mechdef_atlas_AS7-CM','mechdef_atlas_AS7-A');
	//public static $debug_mechs_ai_tag=array('ai_flank','ai_lance','mechdef_adder_ADR-C','mechdef_anvil_ANV-3M','mechdef_anvil_ANV-5M','mechdef_anvil_ANV-6M','mechdef_anvil_ANV-8M','mechdef_atlas_AS7-CM','mechdef_avatar_AV1-OC','mechdef_avatar_AV1-OD');
	//public static $debug_mechs_ai_tag=array('ai_flank','ai_lance','mechdef_mackie_MSK-9H','mechdef_mackie_MSK-9Hb','mechdef_mackie_MSK-9Hc');
	 /*public static $debug_mechs_ai_tag=array('ai_lethalself','mechdef_albatross_ALB-3U','mechdef_adder_ADR-A','mechdef_adder_ADR-B','mechdef_helepolis_HEP-2H','mechdef_leviathan_LVT-C',
'mechdef_leviathan_LVT-Prime','mechdef_Mekagojira_KJ-U','mechdef_moozilla_CM-XXX','mechdef_centurion_CN9-D3','mechdef_centurion_CN9-AL','mechdef_centurion_CN9-D','mechdef_elemental_toad','mechdef_wolverine_WVR-X');(/)
	/*public static $debug_mechs_ai_tag=array('ai_move','mechdef_atlas_AS7-CM','mechdef_atlas_AS7-C','mechdef_adder_ADR-A','mechdef_adder_ADR-C','mechdef_helepolis_HEP-2H','mechdef_leviathan_LVT-C',
'mechdef_leviathan_LVT-Prime','mechdef_Mekagojira_KJ-U','mechdef_moozilla_CM-XXX','mechdef_ajax_AJX-A2','mechdef_moozilla_CM-XXX2','mechdef_moozilla_CM-XXX3','mechdef_elemental_toad','mechdef_elemental_toad_Flamer','mechdef_gemji_CRB-GI');*/
	/*public static $debug_mechs_ai_tag=array('ai_priority','mechdef_adder_ADR-A','mechdef_adder_ADR-C','mechdef_helepolis_HEP-2H','mechdef_leviathan_LVT-C',
'mechdef_leviathan_LVT-Prime','mechdef_moozilla_CM-XXX','mechdef_ajax_AJX-A2','mechdef_moozilla_CM-XXX2','mechdef_moozilla_CM-XXX3','mechdef_elemental_toad','mechdef_elemental_toad_Flamer','mechdef_gemji_CRB-GI','mechdef_catapult_CPLT-C2','mechdef_catapult_CPLT-H2');*/
	/*public static $debug_mechs_ai_tag=array('ai_reserve','mechdef_ajax_AJX-A2','mechdef_adder_ADR-A','mechdef_adder_ADR-C','mechdef_helepolis_HEP-2H','mechdef_leviathan_LVT-C',
'mechdef_leviathan_LVT-Prime','mechdef_moozilla_CM-XXX2','mechdef_elemental_toad','mechdef_elemental_toad_Flamer','mechdef_gemji_CRB-GI','mechdef_catapult_CPLT-C2','mechdef_catapult_CPLT-H2','mechdef_flashman_FLS-9C','mechdef_firestarter_FS9-OD','mechdef_firestarter_FS9-OX','mechdef_raven_RVN-3X');*/
	/*public static $debug_mechs_ai_tag=array('ai_shooting','mechdef_roughneck_RGH-1C','mechdef_leviathan_LVT-C','mechdef_moozilla_CM-XXX2','mechdef_elemental_toad','mechdef_elemental_toad_Flamer','mechdef_gemji_CRB-GI','mechdef_catapult_CPLT-C2','mechdef_catapult_CPLT-H2',
	'mechdef_leviathan_LVT-Prime','mechdef_adder_ADR-A','mechdef_adder_ADR-C','mechdef_panther_PNT-10K');*/
	/*public static $debug_mechs_ai_tag=array('ai_surrounded','mechdef_leviathan_LVT-C','mechdef_moozilla_CM-XXX2','mechdef_elemental_toad','mechdef_gemji_CRB-GI','mechdef_catapult_CPLT-C2','mechdef_catapult_CPLT-H2',
	'mechdef_leviathan_LVT-Prime','mechdef_adder_ADR-A','mechdef_adder_ADR-C','mechdef_black_queen_LVT-BKQN','mechdef_highlander_HGN-732b','mechdef_falcon_FLC-4N');*/
}