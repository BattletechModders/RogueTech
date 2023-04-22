<?php
include ".\php\common.php";

function json_iterate($jd,$callback,$f){
		$jsonIterator = new RecursiveIteratorIterator(
		new RecursiveArrayIterator($jd),
			RecursiveIteratorIterator::SELF_FIRST);
        $scope=array();
		foreach ($jsonIterator as $key => $val) {
				
				while(count($scope)>$jsonIterator->getDepth()){
					 array_pop($scope);
				};
				$skey=join(".",$scope).".".$key;
				if(count($scope))
				 $skey=".".$skey;
				if(is_array($val)) {
					array_push($scope,$key);
				}
				$callback($skey,$val,$f);

			/*if(Dump::$debug ){
				//echo "<".$jsonIterator->getDepth().">";
				if(is_array($val)) {
					echo "$skey:{}".PHP_EOL;
				} else {
					echo "$skey => $val".PHP_EOL;
				}
			}*/
		}
}

function json_vals($jd,$f,&$scopes)
{
	$c=function($scope,$val,$f) use (&$scopes){ 
	   foreach ($scopes as $k=>$y) {
				if($k==$scope){
					$scopes[$k]=$val;
					break;
				}
		}
	};
	json_iterate($jd,$c,$f);
}

function json_val($jd,$f,$scope)
{
	$scopes=array($scope=>null);
	json_vals($jd,$f,$scopes);
	return $scopes[$scope];
}

//this just locates where these values are used / defined in the json. Runs in background while doing other useful stuff.
$debug_json_find=array();//"Gear_Myomer_TSM","Gear_MASC","chassisdef_leviathan_LVT-C","Gear_Engine_400");
$debug_json_find_ignore=array();//"ComponentDefID");//ignores keys containing this

$ignore_json_files=array("Settings.defaults.json","Settings.last.json");

abstract class JSONType
{
    const UNKNOWN = 0;
	const MECH = 1;
	const CHASSIS=2;
	const ENGINE=3;
	const COMPONENT=4;
	const MODJSON=5;
	const MESETTINGSJSON=6;
	const COMBATGAMECONSTANTS=7;
	const AMMO=8;
	const MAX_TYPE = 8;
}
$json_type_2_filenames=array();
$json_filename_2_decoded=array();
$json_index_2_filename=array();

//used to debug
$stat2operation=array();

//presence of these scoped json vars is used to determine .json file type
$json_type_hint = array( 
	JSONType::MECH => array (
		".MechTags",".ChassisID",".Description.Id"
	),
	JSONType::CHASSIS => array (
		".ChassisTags",".Description.Id"
	),
	JSONType::ENGINE => array (
	".Custom.EngineCore",".Description.Id"
	),
	JSONType::COMPONENT => array (
	".ComponentType",".Description.Id"
	),
	JSONType::MODJSON => array (
	".Name",".DependsOn",".ConflictsWith",".Settings"
	),
	JSONType::MESETTINGSJSON => array (
	".OrderedStatusEffects",".OrderedStatusEffects.FilterStatistics",".OrderedStatusEffects.Order",".Engine"
	),
	JSONType::COMBATGAMECONSTANTS => array (
	".Phase",".Skills",".Heat",".ToHit.ToHitMovingTargetDistances",".ToHit.EvasivePipsMovingTarget"
	),
	JSONType::AMMO => array (
	".Description.Id",".Category",".HeatGenerated",".HeatGeneratedModifier",".ArmorDamageModifier",".ISDamageModifier"
	),
);
//This is the Primary Key for lookup of each JSONType
$json_type_pk = array( 
	JSONType::MECH => ".Description.Id",
	JSONType::CHASSIS => ".Description.Id",
	JSONType::ENGINE => ".Description.Id",
	JSONType::COMPONENT => ".Description.Id",
	JSONType::MODJSON => ".Name",
	JSONType::MESETTINGSJSON => "#MESettings",//PKs starting with # are used as is and not looked up in json
	JSONType::COMBATGAMECONSTANTS => "#CombatGameConstants",
	JSONType::AMMO => ".Description.Id",
);

//some things are other things as well :P
$json_additional_types = array( 
	JSONType::MECH =>	array (),
	JSONType::CHASSIS => array (),
	JSONType::ENGINE => array (JSONType::COMPONENT),
	JSONType::COMPONENT => array (),
	JSONType::MODJSON => array (),
	JSONType::MESETTINGSJSON => array (JSONType::MODJSON),
	JSONType::COMBATGAMECONSTANTS => array (JSONType::MODJSON),
	JSONType::AMMO => array(),
);


function add_json_pk($jd,$f,$json_type,$base_type=null)
{
	GLOBAL $json_index_2_filename,$json_type_pk;
	//echo json_encode($json_type_pk).":=?".$json_type;
	$pk=$json_type_pk[$json_type];
	if(!startswith($pk,"#"))
		$pk=json_val($jd,$f,$json_type_pk[$json_type]);
	if($base_type!=null && startswith($json_type_pk[$base_type],"#") )
		$pk=$json_type_pk[$base_type];
	$k="[$json_type]".$pk;
	$json_index_2_filename[$k]=$f;
	/*if($json_type==JSONType::MESETTINGSJSON || $json_type==JSONType::MODJSON)
		echo "$k => $f".PHP_EOL;*/
}

function json_for_pk($json_type,$pk){
   GLOBAL $json_index_2_filename,$json_filename_2_decoded;
   $k="[$json_type]".$pk;
   return $json_filename_2_decoded[$json_index_2_filename[$k]];
}

$einfo_dump=array();

class Dump extends Config{
   public static function main(){
   //we construct an in memory json db
    Dump::init();
	Dump::loadFromFiles();
	//and dump what we need to csv
	Dump::dumpMechs();
   }

   public static function init(){
	   GLOBAL $json_type_2_filenames;
	   for ($x = 1; $x <= JSONType::MAX_TYPE; $x++) {
			$json_type_2_filenames[$x]=array();
	   }
   }

   public static function loadFromFiles(){
	   GLOBAL $json_type_2_filenames,$json_filename_2_decoded,$json_index_2_filename,$json_additional_types,$ignore_json_files;
   	   echo "Parsing *.json from ".Dump::$RT_Mods_dir.PHP_EOL;
		$files=array();
		Dump::getJSONFiles(Dump::$RT_Mods_dir,$files);
		foreach($files as $f){
			$jd=Dump::parseJSONFile($f);
			if(!$jd)
			  continue;
			//echo ">>>".$f.PHP_EOL;
			foreach($ignore_json_files as $if){
				if(endswith_i($f,$if))
					continue 2;
			}
			$json_type=Dump::guessJSONFileType($f,$jd);
			if($json_type){
				array_push($json_type_2_filenames[$json_type],$f);
				$json_filename_2_decoded[$f]=$jd;
				add_json_pk($jd,$f,$json_type);
				foreach($json_additional_types[$json_type] as $json_type_a){
					array_push($json_type_2_filenames[$json_type_a],$f);
					add_json_pk($jd,$f,$json_type_a,$json_type);
				}
			}
		}
		echo "Loaded..".PHP_EOL;
		echo "MECHS:".count($json_type_2_filenames[JSONType::MECH]).PHP_EOL;
		echo "CHASSIS:".count($json_type_2_filenames[JSONType::CHASSIS]).PHP_EOL;
		echo "ENGINE:".count($json_type_2_filenames[JSONType::ENGINE]).PHP_EOL;
		echo "COMPONENT:".count($json_type_2_filenames[JSONType::COMPONENT]).PHP_EOL;
		echo "MODJSON:".count($json_type_2_filenames[JSONType::MODJSON]).PHP_EOL;
		echo "MESETTINGSJSON:".count($json_type_2_filenames[JSONType::MESETTINGSJSON]).PHP_EOL;
		echo "COMBATGAMECONSTANTS:".count($json_type_2_filenames[JSONType::COMBATGAMECONSTANTS]).PHP_EOL;
		echo "AMMO:".count($json_type_2_filenames[JSONType::AMMO]).PHP_EOL;
		//echo json_encode(json_for_pk(JSONType::MODJSON,"#MESettings"));
		//echo json_encode(json_for_pk(JSONType::MODJSON,"#CombatGameConstants"));
   }

public static function getJSONFiles($dirname,&$array){
	if(!is_dir($dirname) || endswith($dirname,".modtek"))
		return;
	$dir = new DirectoryIterator($dirname);
	foreach ($dir as $fileinfo) {
	    if (!$fileinfo->isDot() && endswith($fileinfo->getFilename(),".json") ) {
			$array[]=$dirname.DIRECTORY_SEPARATOR.$fileinfo->getFilename();
	    }
	    if(!$fileinfo->isDot() && is_dir($dirname.DIRECTORY_SEPARATOR.$fileinfo->getFilename())){
			Dump::getJSONFiles($dirname.DIRECTORY_SEPARATOR.$fileinfo->getFilename(),$array);
	    }
	}

	return;
}

public static function parseJSONFile($f){
	$json = file_get_contents($f);

		$json=preg_replace('/\,\s+\}/', '}',$json);
		$json=preg_replace('/\,\s+\]/', ']',$json);
		// search and remove comments like /* */ and //
	    $json = preg_replace("#(/\*([^*]|[\r\n]|(\*+([^*/]|[\r\n])))*\*+/)|([\s\t]//.*)|(^//.*)#", '', $json);
		$json = preg_replace('/[[:^print:]]/', '', $json);

		$jd=json_decode($json, TRUE);

		if($jd==NULL){
			if(json_last_error_msg()!="No error"){
			echo "WARNING: BAD JSON in file:";
			echo $f.PHP_EOL;
			echo PHP_EOL.$json.PHP_EOL;
			echo "ERROR ".json_last_error_msg( ).PHP_EOL;
			}
		}

		return $jd;
}

public static function guessJSONFileType($f,$jd){
	
	$type=JSONType::UNKNOWN;
	$type_match=array();
	for ($x = 1; $x <= JSONType::MAX_TYPE; $x++) {
		$type_match[$x]=0;
	}

	$c=function($scope,$val,$f) use (&$type_match){ 
	   GLOBAL $json_type_hint,$debug_json_find,$debug_json_find_ignore;
	   for ($x = 1; $x <= JSONType::MAX_TYPE; $x++) {
			foreach ($json_type_hint[$x] as $y) {
				if($y==$scope)
				  $type_match[$x]++;
			}
	   }
	   if(DUMP::$debug && $f)
	   {
	    $ignored=false;
		foreach ($debug_json_find_ignore as $y) {
				if(strpos($scope,$y)!== false){
					$ignored=true;
					break;
				}
		}
		if(!$ignored){
	   		foreach ($debug_json_find as $y) {
					if($y===$val){
						echo "[DEBUG] $scope=> $val >>$f".PHP_EOL;
					}
			}
		}
	   }
	};

	json_iterate($jd,$c,$f);
	GLOBAL $json_type_hint;
    for ($x = 1; $x <= JSONType::MAX_TYPE; $x++) {
		//echo "[ $x ] => ".$type_match[$x]."/".count($json_type_hint["".$x]);
		if($type_match[$x]==count($json_type_hint["".$x]) ){
			$type=$x;
			break;//first match
		}
	}
	
	return $type;
}

public static function dumpMechs(){
	GLOBAL $json_type_2_filenames,$json_filename_2_decoded,$einfo_dump,$csv_header,$stat2operation;
	
	$fp = fopen('./Output/mechs.csv', 'wb');
	fputcsv($fp, $csv_header);
	foreach($json_type_2_filenames[JSONType::MECH] as $f){
	    //$f="C:\games\steam\steamapps\common\BATTLETECH\Mods\Superheavys\mech\mechdef_leviathan_LVT-C.json";$engine_rating
		//$f="C:\games\steam\steamapps\common\BATTLETECH\Mods\Jihad HeavyMetal Unique\mech\mechdef_stealth_STH-5X.json";
		//$f="C:\games\steam\steamapps\common\BATTLETECH\Mods\RogueOmnis\mech\mechdef_centurion_CN11-OX.json";

		//echo "!!!!!".$f.PHP_EOL;
		$mechjd=$json_filename_2_decoded[$f];
		if(DUMP::$debug_single_mech){
			if($mechjd["Description"]["Id"]==DUMP::$debug_single_mech)
				DUMP::$info=TRUE;
			else
			    DUMP::$info=FALSE;
		}
		$chasisjd=json_for_pk(JSONType::CHASSIS,$mechjd["ChassisID"]);
		
		/*if($chasisjd['Custom']['ChassisDefaults'])
		{
			echo $mechjd["Description"]["Id"]. " ".json_encode($chasisjd['Custom']['ChassisDefaults'],JSON_PRETTY_PRINT).PHP_EOL;
		}*/

		if(DUMP::$info){
			echo $mechjd["Description"]["Id"]." ---->".PHP_EOL;
			echo "CHASIS:".PHP_EOL.json_encode($chasisjd,JSON_PRETTY_PRINT).PHP_EOL;
			echo "MECH:".PHP_EOL.json_encode($mechjd,JSON_PRETTY_PRINT).PHP_EOL;
		}
		$equipment=array();
		$effects=array();//tree of effects that can be ordered (ME OrderedStatusEffects) or default order, before computing into $einfo
		$ammoeffects=array();//tree of ammo effects before computing into $einfo for Weapons and ToHit effects
		$einfo=DUMP::initEquipmentInfo();

		try{
			if($chasisjd['Custom']['ChassisDefaults'] && count($chasisjd['Custom']['ChassisDefaults'])>0)
			{
				$cdequip=array();
				foreach($chasisjd['Custom']['ChassisDefaults'] as $cd){
					$cdequip[]= array(
						"MountedLocation"=>$cd["Location"],
						"ComponentDefID"=>$cd["DefID"],
						"ComponentDefType"=>$cd["Type"]
					);
				}
				Dump::gatherEquipment(array('ChassisDefaults'=>$cdequip),"ChassisDefaults",$equipment,$einfo,$effects,$ammoeffects);
			}
			if($chasisjd["FixedEquipment"])
				Dump::gatherEquipment($chasisjd,"FixedEquipment",$equipment,$einfo,$effects,$ammoeffects);
			Dump::gatherEquipment($mechjd,"inventory",$equipment,$einfo,$effects,$ammoeffects);

		}catch (Exception $e) {
			if(DUMP::$debug)
				echo "[DEBUG] ".$e->getMessage().PHP_EOL;
		}	
		 
		
		$tonnage=$chasisjd["Tonnage"];
		$engine_rating=$einfo[".Custom.EngineCore"];
		if(!($engine_rating && $tonnage) )
		{
			//mechdef_deploy_director.json
			if(DUMP::$debug)
				echo "[DEBUG] Ignoring $f".PHP_EOL;
			continue;
		}

		DUMP::initMoveInfo($einfo,$engine_rating,$tonnage);
		Dump::initHeatInfo($einfo,$engine_rating,$tonnage);
		Dump::initDefensiveInfo($einfo,$chasisjd,$mechjd);
		Dump::initPhysicalInfo($einfo,$tonnage);

		if(DUMP::$info){
			echo "BASE EFFECTS:".PHP_EOL.json_encode($effects,JSON_PRETTY_PRINT).PHP_EOL;
			echo "AMMO EFFECTS:".PHP_EOL.json_encode($ammoeffects,JSON_PRETTY_PRINT).PHP_EOL;
			echo "BASE EINFO:".PHP_EOL.json_encode($einfo,JSON_PRETTY_PRINT).PHP_EOL;
		}

		DUMP::processStatusEffects($einfo,$effects);
		DUMP::processAmmoEffects($einfo,$ammoeffects);

		if(DUMP::$info){
			echo "PROCESSED EFFECTS:".PHP_EOL.json_encode($effects,JSON_PRETTY_PRINT).PHP_EOL;
			echo "PROCESSED EINFO:".PHP_EOL.json_encode($einfo,JSON_PRETTY_PRINT).PHP_EOL;
		}

		Dump::getMoveInfo($einfo,$engine_rating,$tonnage,$walk_base,$walk_activated,$run_base,$run_activated,$jump_distance_base,$jump_distance_activated,$max_evasion_pips);
		Dump::getHeatInfo($einfo,$engine_rating,$tonnage,$dissipation_capacity_base,$dissipation_capacity_activated,$heat_generated,$jump_heat_base,$jump_heat_activated,$heat_efficency);

		//CASE Explosion reduction
		if($einfo[".CBTBE_AmmoBoxExplosionDamage"]>0 && $einfo[".Custom.CASE.MaximumDamage"]>=0)
			$einfo[".CBTBE_AmmoBoxExplosionDamage"]=$einfo[".Custom.CASE.MaximumDamage"];
		if($einfo[".CBTBE_VolatileAmmoBoxExplosionDamage"]>0 && $einfo[".Custom.CASE.MaximumDamage"]>=0)
			$einfo[".CBTBE_VolatileAmmoBoxExplosionDamage"]=$einfo[".Custom.CASE.MaximumDamage"];

		//MEchs without Gyro - use default
		if(!$einfo['UnsteadyThreshold_activated'])
			$einfo['UnsteadyThreshold_activated']=40;

		Dump::getDefensiveInfo($einfo,$chasisjd,$armor,$structure,$leg_armor,$leg_structure,$armor_repair,$structure_repair,$leg_armor_repair,$leg_structure_repair);

		Dump::getPhysicalInfo($einfo,$chasisjd,$tonnage,$walk_activated,$jump_distance_activated,$leg_armor,$leg_structure,$leg_armor_repair,$leg_structure_repair,$ChargeAttackerDamage,$ChargeTargetDamage,$ChargeAttackerInstability,$ChargeTargetInstability,$DFAAttackerDamage,$DFATargetDamage,$DFAAttackerInstability,$DFATargetInstability,$KickDamage,$KickInstability,$PhysicalWeaponDamage,$PhysicalWeaponInstability,$PunchDamage,$PunchInstability,$dfa_self_damage_efficency,$dfa_damage_efficency,$dfa_self_instability_efficency);

		Dump::getWeaponsInfo($einfo,$tonnage,$Weapons_Total_Damage,$Weapons_Best_Single_Hit_Damage,$Weapons_Overall_Optimum_Range,$Weapons_Optimum_Range_Std_Dev,$Weapons_Damage_Efficency,$Weapons_Optimum_Range_Damage,$Damage_percent_at_Optimum_Range,
			$Weapons_Damage_Weighted_APCriticalChanceMultiplier,$CACAPProtection,
			$Weapons_Total_Instability,$Weapons_Best_Single_Hit_Instability,
			$AOECapable,$IndirectFireCapable,$Nth_Turn_Total_Damage,$Nth_Turn_Damage_available_perc,$Nth_Turn_Optimum_Range_Damage,$Nth_Turn_Damage_percent_at_Optimum_Range,$Turn_Out_Of_optimum_Range_Ammo);

		if(DUMP::$debug)
		 		$einfo_dump=array_merge($einfo_dump, $einfo);

		$dump=array($mechjd["Description"]["Id"],$tonnage,$engine_rating,
			$walk_base,$walk_activated,$run_base,$run_activated,
			$jump_distance_base,$jump_distance_activated,
			$dissipation_capacity_base,$dissipation_capacity_activated,$einfo[".Custom.ActivatableComponent.AutoActivateOnHeat"],$heat_generated,$jump_heat_base,$jump_heat_activated,
			$einfo[".CBTBE_AmmoBoxExplosionDamage"],$einfo[".CBTBE_VolatileAmmoBoxExplosionDamage"],
			$einfo[".AMSSINGLE_HeatGenerated"],$einfo[".AMSMULTI_HeatGenerated"],
			0+$einfo["ReceiveHeatDamageInjury_activated"],$heat_efficency,
			$ChargeAttackerDamage,$ChargeTargetDamage,$ChargeAttackerInstability,$ChargeTargetInstability,
			$DFAAttackerDamage,$DFATargetDamage,$DFAAttackerInstability,$DFATargetInstability,
			$KickDamage,$KickInstability,
			$PhysicalWeaponDamage,$PhysicalWeaponInstability,
			$PunchDamage,$PunchInstability,
			$armor,$leg_armor,$structure,$leg_structure,
			$armor_repair,$leg_armor_repair,$structure_repair,$leg_structure_repair,
			$dfa_self_damage_efficency,$dfa_damage_efficency,$dfa_self_instability_efficency,
			$einfo["UnsteadyThreshold_activated"],
			max($KickDamage,$PunchDamage,$PhysicalWeaponDamage)/$tonnage,//MeleeDamageEfficency
			$einfo["DamageReductionMultiplierAll_activated"],$einfo["DamageReductionMultiplierBallistic_activated"],$einfo["DamageReductionMultiplierMissile_activated"],$einfo["DamageReductionMultiplierEnergy_activated"],$einfo["DamageReductionMultiplierMelee_activated"],
			$max_evasion_pips,
			$einfo["LV_ADVANCED_SENSORS_activated"],$einfo["LV_PROBE_CARRIER_activated"],$einfo["LV_ECM_SHIELD_activated"],$einfo["LV_ECM_JAMMED_activated"],$einfo["LV_SHARES_VISION_activated"],$einfo["LV_NIGHT_VISION_activated"],$einfo["LV_PROBE_PING_activated"],
			$einfo["EnemiesWithinRange_LV_ECM_JAMMED_activated"],$einfo["EnemiesWithinRange_LV_PROBE_PING_activated"],$einfo["EnemiesWithinRange_LV_ECM_SHIELD_activated"],
			$einfo["AlliesWithinRange_LV_ECM_JAMMED_activated"],$einfo["AlliesWithinRange_LV_ECM_SHIELD_activated"],
			$einfo["EnemiesWithinRange_SensorSignatureModifier_activated"],$einfo["EnemiesWithinRange_SpottingVisibilityMultiplier_activated"],$einfo["EnemiesWithinRange_MoraleBonusGain_activated"],$einfo["EnemiesWithinRange_BaseInitiative_activated"],$einfo["EnemiesWithinRange_PanicStatModifier_activated"],
			$einfo["AlliesWithinRange_SensorDistanceAbsolute_activated"],$einfo["AlliesWithinRange_SpotterDistanceAbsolute_activated"],
			$einfo["SensorDistanceAbsolute_activated"],$einfo["SensorSignatureModifier_activated"],$einfo["SensorDistanceMultiplier_activated"],
			$einfo["SpottingVisibilityMultiplier_activated"],
   			//LV_STEALTH_signature_modifier","LV_STEALTH_details_modifier","LV_STEALTH_mediumAttackMod","LV_STEALTH_longAttackmod","LV_STEALTH_extremeAttackMod",
			 Dump::lowVisSplit($einfo["LV_STEALTH_activated"],0),Dump::lowVisSplit($einfo["LV_STEALTH_activated"],1),Dump::lowVisSplit($einfo["LV_STEALTH_activated"],2),Dump::lowVisSplit($einfo["LV_STEALTH_activated"],3),Dump::lowVisSplit($einfo["LV_STEALTH_activated"],4),
			//"LV_MIMETIC_maxCharges","LV_MIMETIC_visibilityModPerCharge","LV_MIMETIC_attackModPerCharge","LV_MIMETIC_hexesUntilDecay",
			Dump::lowVisSplit($einfo["LV_MIMETIC_activated"],0),Dump::lowVisSplit($einfo["LV_MIMETIC_activated"],1),Dump::lowVisSplit($einfo["LV_MIMETIC_activated"],2),Dump::lowVisSplit($einfo["LV_MIMETIC_activated"],3),
			//".Enemy.OnHit_LV_NARC_signatureMod",".Enemy.OnHit_LV_NARC_detailsMod",".Enemy.OnHit_LV_NARC_attackMod",
			Dump::lowVisSplit($einfo[".Enemy.OnHit_LV_NARC_activated"],0),Dump::lowVisSplit($einfo[".Enemy.OnHit_LV_NARC_activated"],1),Dump::lowVisSplit($einfo[".Enemy.OnHit_LV_NARC_activated"],2),
			//".Enemy.OnHit_LV_TAG_signatureMod",".Enemy.OnHit_LV_TAG_detailsMod",".Enemy.OnHit_LV_TAG_attackMod",
			Dump::lowVisSplit($einfo[".Enemy.OnHit_LV_TAG_activated"],0),Dump::lowVisSplit($einfo[".Enemy.OnHit_LV_TAG_activated"],1),Dump::lowVisSplit($einfo[".Enemy.OnHit_LV_TAG_activated"],2),
			$Weapons_Total_Damage,$Weapons_Best_Single_Hit_Damage,$Weapons_Overall_Optimum_Range,$Weapons_Optimum_Range_Std_Dev,$Weapons_Damage_Efficency,$Weapons_Optimum_Range_Damage,$Damage_percent_at_Optimum_Range,
			$Weapons_Damage_Weighted_APCriticalChanceMultiplier,$CACAPProtection,
			$Weapons_Total_Instability,$Weapons_Best_Single_Hit_Instability,
			$AOECapable,$IndirectFireCapable,
			$armor/$tonnage,
			$Nth_Turn_Total_Damage,$Nth_Turn_Damage_available_perc,
			$Nth_Turn_Optimum_Range_Damage,$Nth_Turn_Damage_percent_at_Optimum_Range,$Turn_Out_Of_optimum_Range_Ammo,
			implode(" ",$equipment),
			str_replace(Dump::$RT_Mods_dir,"",$f));

		if(DUMP::$info)
			echo implode(",", $dump) . PHP_EOL;
		fputcsv($fp, $dump);
		//break;
}
	fclose($fp);
	if(DUMP::$debug){
		$fp = fopen('./Output/debug_einfo.json', 'wb');
		fputs($fp,json_encode($einfo_dump,JSON_PRETTY_PRINT));
		fclose($fp);
		$fp = fopen('./Output/debug_statoperation.json', 'wb');
		fputs($fp,json_encode(array_filter($stat2operation, function($v, $k) {
			return true;//count($v)>1;//<-log only those stats with multiple operation
		}, ARRAY_FILTER_USE_BOTH),JSON_PRETTY_PRINT));
		fclose($fp);
	}
	echo "Exported Mechs to ".'./Output/mechs.csv'.PHP_EOL;
}

public static function initEquipmentInfo(){
	$combatgameconstants=json_for_pk(JSONType::MODJSON,"#CombatGameConstants");
	return array( // flattened list of all equipment effects and characteristics . Those starting with . are manually extracted, without are effects and auto extracted
		".Custom.EngineCore"=>"",
		".Custom.CASE.MaximumDamage"=>-1,
		".Custom.EngineHeatBlock"=>0,
		".Custom.Cooling.HeatSinkDefId" => "Gear_HeatSink_Generic_Standard",
		".Custom.ActivatableComponent.AutoActivateOnHeat"=>0,
		".DissipationCapacity"=>0,
		"CBTBE_RunMultiMod"=>0,//additively modifies default RunMulti
		".CBTBE_AmmoBoxExplosionDamage"=>0,
		".CBTBE_VolatileAmmoBoxExplosionDamage"=>0,
		"CBTBE_Charge_Attacker_Damage_Multi"=>1,
		"CBTBE_DFA_Attacker_Damage_Multi"=>1,
		"CBTBE_Charge_Target_Damage_Multi"=>1,
		"CBTBE_Charge_Attacker_Instability_Multi"=>1,
		"CBTBE_Charge_Target_Instability_Multi"=>1,
		"CBTBE_DFA_Target_Damage_Multi"=>1,
		"CBTBE_DFA_Attacker_Instability_Multi"=>1,
		"CBTBE_DFA_Target_Instability_Multi"=>1,
		"CBTBE_Kick_Target_Damage_Multi"=>1,
		"CBTBE_Kick_Target_Instability_Multi"=>1,
		"CBTBE_Physical_Weapon_Target_Damage_Multi"=>1,
		"CBTBE_Physical_Weapon_Target_Instability_Multi"=>1,
		"CBTBE_Punch_Target_Damage_Multi"=>1,
		"CBTBE_Physical_Weapon_Target_Instability_Multi"=>1,
		"CBTBE_Punch_Target_Instability_Multi"=>1,
		".AMSSINGLE_HeatGenerated"=>0,
		".AMSMULTI_HeatGenerated"=>0,
		"WalkSpeed_base"=>0,
		"WalkSpeed_activated"=>0,
		".JumpCapacity"=>0,
		"JumpDistanceMultiplier"=>1,
		"JumpHeat_base"=>0,
		"JumpHeat_activated"=>0,
		"DFASelfDamage_base"=>1,
		"DFASelfDamage_activated"=>1,
		"DamageReductionMultiplierAll"=>1,
		"DamageReductionMultiplierBallistic"=>1,
		"DamageReductionMultiplierMissile"=>1,
		"DamageReductionMultiplierEnergy"=>1,
		"DamageReductionMultiplierMelee"=>1,
		"MaxEvasivePips"=>6,
		"SensorDistanceAbsolute"=>$combatgameconstants["Visibility"]["BaseSensorDistance"],
		"SpottingVisibilityMultiplier"=>1,
		"SensorSignatureModifier"=>1,
		"EnemiesWithinRange_SensorSignatureModifier"=>1,
		"EnemiesWithinRange_SpottingVisibilityMultiplier"=>1,
		"AlliesWithinRange_SensorDistanceAbsolute"=>1,
		"AlliesWithinRange_SpotterDistanceAbsolute"=>1,
		"SensorSignatureModifier"=>1,
		"SensorDistanceMultiplier"=>1,
		"SpottingVisibilityMultiplier"=>1,
		"EnemiesWithinRange_PanicStatModifier"=>1
		);
}

public static function processAmmoEffects(&$einfo,&$ammoeffects){
  //Since only 1 ammo type can be used at a time,were going to fold the ToHit effect over each other such that we take only one of each effect.
  //for numbers its max for strings it is the last value that came in.
  $ammoeinfo=array();
  foreach($ammoeffects as $ae){
     Dump::processStatusEffects($ammoeinfo,$ae);
	 foreach($ammoeinfo as $key=>$v){
	 /*simplify key
	 ".Enemy.Ammo.|*|*|*|SNARC|.OnHit_LV_NARC"  ".Enemy.Ammo.|*|*|*|NARC|.OnHit_LV_NARC"  all simplify to  => ".Enemy.OnHit_LV_NARC" 
	 ".Enemy.Ammo.|*|*|*|NARC|.Weapon.|*|*|*|*|.OnHit_HeatGenerated"  simplifies to => ".Enemy.Weapon.OnHit_HeatGenerated"  */
		$k=explode (".", $key); 
		$nkey="";
		foreach($k as $tok)
		{
			if(!startswith($tok,"Ammo")  && !startswith($tok,"|") && $tok!=""){
				$nkey=$nkey.".".$tok;
			}
		}
		//echo "$key >>>> $nkey".PHP_EOL;
		if(!$einfo[$nkey]){
			$einfo[$nkey]=$v;//doesn't exist
		}else if(is_numeric ( $einfo[$nkey])){
			if($v>$einfo[$nkey]){
				$einfo[$nkey]=$v;//overwrite if greater
			}
		}else{
			$einfo[$nkey]=$v;//is not numeric overwrite
		}
	 }
  }
}

public static function processStatusEffects(&$einfo,&$effects){
		$MEmodjson=json_for_pk(JSONType::MODJSON,"#MESettings");

		//OrderedStatusEffects
		$order=$MEmodjson["OrderedStatusEffects"] ["Order"];
		$order[]="Set";
		foreach(array_keys($effects) as $k){
		   if(in_array($k,$MEmodjson["OrderedStatusEffects"]["FilterStatistics"])){
		   //https://github.com/BattletechModders/MechEngineer/blob/master/source/Features/OrderedStatusEffects/OrderedStatusEffectsFeature.cs
		   		if(DUMP::$info)
					echo "^ |OrderedStatusEffects for $k |^".PHP_EOL;
				usort($effects[$k],
					function ($a, $b) use ($order)
					{
						$av=array_search($a["operation"],$order)*2;
						if($a["activated"])
							$av++;
						$bv=array_search($b["operation"],$order)*2;
						if($b["activated"])
							$bv++;
						return $av-$bv;
					});
		   }else{
			    usort($effects[$k],
						function ($a, $b) use ($order)
						{
							    if ($a["activated"] == $b["activated"]) {
									return 0;
								}
								return ($a["activated"]) ? 1 : -1;
						});
		   }
		}

		//Compute EINFO _base and _activated
		foreach($effects as $k=>$v){
			 $base_val=0;
			 if($einfo[$k])
				$base_val=$einfo[$k];
			
			 for ($x = 0; $x <= count($v); $x++) {
		            $operation= $v[$x]["operation"];
					$modValue=$v[$x]["modValue"];
					$activated=$v[$x]["activated"];
					$componentid=$v[$x]["from"];
						switch ($operation) {
							case "Int_Add":
							case "Float_Add":
								if($x==0 && !$einfo[$k])
								    $base_val=0;
								if(!$activated)
									$base_val= $base_val + $modValue;
								break;
							case "Int_Subtract":
							case "Float_Subtract":
								if($x==0 && !$einfo[$k])
								    $base_val=0;
								if(!$activated)
									$base_val= $base_val - $modValue;
								break;
							case "Float_Multiply":
							case "Int_Multiply":
							case "Int_Multiply_Float":
								if($x==0 && !$einfo[$k])
								    $base_val=1;
								if(!$activated)
									$base_val= $base_val * $modValue;
								break;
							case "Set":
								if(!$activated)
									$base_val=$modValue;
								break;
							default:
								break;
						}
			 }

			 $activated_val=0;
			 if($einfo[$k])
				$activated_val=$einfo[$k];
			 for ($x = 0; $x <= count($v); $x++) {
		            $operation= $v[$x]["operation"];
					$modValue=$v[$x]["modValue"];
					$activated=$v[$x]["activated"];
					$componentid=$v[$x]["from"];
						switch ($operation) {
							case "Int_Add":
							case "Float_Add":
									if($x==0 && !$einfo[$k])
										$activated_val=0;
									$activated_val= $activated_val + $modValue;
								break;
							case "Int_Subtract":
							case "Float_Subtract":
								   if($x==0 && !$einfo[$k])
										$activated_val=0;
								   $activated_val= $activated_val - $modValue;
								break;
							case "Float_Multiply":
							case "Int_Multiply":
							case "Int_Multiply_Float":
								if($x==0 && !$einfo[$k])
								    $activated_val=1;
								$activated_val= $activated_val * $modValue;
								break;
							case "Set":
									$activated_val=$modValue;
								break;
							default:
								break;
						}
			 }
			 unset($einfo[$k]);
			 $einfo[$k."_base"]=$base_val;
			 $einfo[$k."_activated"]=$activated_val;
		}

		foreach(array_keys($einfo) as $k){
		  if(!startswith($k,".") && !endswith($k,"_base") && !endswith($k,"_activated"))
		  {
		  	 $v=$einfo[$k];
			 unset($einfo[$k]);
			 $einfo[$k."_base"]=$v;
			 $einfo[$k."_activated"]=$v;
		  }
		}
}

public static function initMoveInfo(&$einfo,$engine_rating,$tonnage){
		//walk/run distance
		//https://github.com/BattletechModders/CBTBehaviorsEnhanced
		$CBTmodjson=json_for_pk(JSONType::MODJSON,"CBTBehaviorsEnhanced");
		$MEmodjson=json_for_pk(JSONType::MODJSON,"#MESettings");

		if(DUMP::$warn && $CBTmodjson["Move"]["MPMetersPerHex"]!=$MEmodjson["Engine"]["MovementPointDistanceMultiplier"]){
			echo "WARNING: CBTBE MPMetersPerHex != ME MovementPointDistanceMultiplier".PHP_EOL;
		}

		$einfo["WalkSpeed"]=$engine_rating/$tonnage*$MEmodjson["Engine"]["MovementPointDistanceMultiplier"];

}

public static function getMoveInfo($einfo,$engine_rating,$tonnage,&$walk_base,&$walk_activated,&$run_base,&$run_activated,&$jump_distance_base,&$jump_distance_activated,&$max_evasion_pips){
		//walk/run distance
		//https://github.com/BattletechModders/CBTBehaviorsEnhanced
		$CBTmodjson=json_for_pk(JSONType::MODJSON,"CBTBehaviorsEnhanced");
		$MEmodjson=json_for_pk(JSONType::MODJSON,"#MESettings");
		$combatgameconstants=json_for_pk(JSONType::MODJSON,"#CombatGameConstants");

		//$ChargeAttackerDamage
		$MovementPointDistanceMultiplier = $CBTmodjson["Move"]["MPMetersPerHex"];
		$RunMulti = $CBTmodjson["Move"]["RunMulti"];
		$ToHitMovingTargetDistances = $combatgameconstants["ToHit"]["ToHitMovingTargetDistances"];
		$EvasivePipsMovingTarget = $combatgameconstants["ToHit"]["EvasivePipsMovingTarget"];

		$walk_base=round($einfo["WalkSpeed_base"]/$MovementPointDistanceMultiplier);
		$walk_activated=round($einfo["WalkSpeed_activated"]/$MovementPointDistanceMultiplier);
		$run_base=round (($einfo["WalkSpeed_base"]/$MovementPointDistanceMultiplier)*($RunMulti+$einfo["CBTBE_RunMultiMod_base"]));
		$run_activated=round(($einfo["WalkSpeed_activated"]/$MovementPointDistanceMultiplier)*($RunMulti+$einfo["CBTBE_RunMultiMod_activated"]));
		$jump_distance_base=(int) ($einfo[".JumpCapacity"]*$einfo["JumpDistanceMultiplier_base"]);
		$jump_distance_activated=(int) ($einfo[".JumpCapacity"]*$einfo["JumpDistanceMultiplier_activated"]);

		$evasion_from_jump=0;
		$jump_m=$jump_distance_activated*$MovementPointDistanceMultiplier;
		$evasion_from_run=0;
		$run_m=$einfo["WalkSpeed_activated"]*($RunMulti+$einfo["CBTBE_RunMultiMod_activated"]);

		for($x=0;$x<count($ToHitMovingTargetDistances);$x++){
			if($jump_m>=$ToHitMovingTargetDistances[$x])
				$evasion_from_jump=$EvasivePipsMovingTarget[$x];
			if($run_m>=$ToHitMovingTargetDistances[$x])
				$evasion_from_run=$EvasivePipsMovingTarget[$x];
		}

		$max_evasion_pips=max($evasion_from_jump,$evasion_from_run)+$einfo["EvasivePipsGainedAdditional_activated"];
		$max_evasion_pips=min($max_evasion_pips,$einfo["MaxEvasivePips_activated"]);

}

public static function initDefensiveInfo(&$einfo,$chasisjd,$mechjd){
	$locations=$chasisjd['Locations'];
	foreach($locations as $l) {
			if(DUMP::$info){
				echo "Location:".$l['Location'].PHP_EOL;
				if($l['MaxArmor']>0){
					echo "\tMaxArmor ".$l['MaxArmor'].PHP_EOL;
				}
				if($l['MaxRearArmor']>0){
					echo "\tMaxRearArmor ".$l['MaxRearArmor'].PHP_EOL;
				}
				if($l['InternalStructure']>0){
					echo "\tInternalStructure ".$l['InternalStructure'].PHP_EOL;
				}
			}
	}
	$locations=$mechjd['Locations'];
	foreach($locations as $l) {
			if(DUMP::$info){
				echo "Location:".$l['Location'].PHP_EOL;
				if($l['CurrentArmor']>0){
					echo "\tCurrentArmor ".$l['CurrentArmor'].PHP_EOL;
				}
				if($l['CurrentRearArmor']>0){
					echo "\tCurrentRearArmor ".$l['CurrentRearArmor'].PHP_EOL;
				}
				if($l['CurrentInternalStructure']>0){
					echo "\tCurrentInternalStructure ".$l['CurrentInternalStructure'].PHP_EOL;
				}
			}
			if($l['CurrentArmor']>0){
				$einfo[$l['Location'].".Armor"]+=$l['CurrentArmor'];
			}
			if($l['CurrentRearArmor']>0){
				$einfo[$l['Location'].".RearArmor"]+=$l['CurrentRearArmor'];
			}
			if($l['CurrentInternalStructure']>0){
				$einfo[$l['Location'].".Structure"]+=$l['CurrentInternalStructure'];
			}
	}
}



public static function getWeaponsInfo($einfo,$tonnage,
	&$Weapons_Total_Damage,&$Weapons_Best_Single_Hit_Damage,&$Weapons_Overall_Optimum_Range,&$Weapons_Optimum_Range_Std_Dev,&$Weapons_Damage_Efficency,&$Weapons_Optimum_Range_Damage,&$Damage_percent_at_Optimum_Range,
	&$Weapons_Damage_Weighted_APCriticalChanceMultiplier,&$CACAPProtection,
	&$Weapons_Total_Instability,&$Weapons_Best_Single_Hit_Instability,
	&$AOECapable,&$IndirectFireCapable,&$Nth_Turn_Total_Damage,&$Nth_Turn_Damage_available_perc,
	&$Nth_Turn_Optimum_Range_Damage,&$Nth_Turn_Damage_percent_at_Optimum_Range,&$Turn_Out_Of_optimum_Range_Ammo){
			$Weapons_Total_Damage=0;
			$Weapons_Best_Single_Hit_Damage=0;
			$Weapons_Overall_Optimum_Range=0;
			$Weapons_Optimum_Range_Std_Dev=0;
			$Weapons_Damage_Efficency=0;
			$Weapons_Optimum_Range_Damage=0;
			$Damage_percent_at_Optimum_Range=0;
			$Weapons_Damage_Weighted_APCriticalChanceMultiplier=0;
			$CACAPProtection=0;
			$Weapons_Total_Instability=0;
			$Weapons_Best_Single_Hit_Instability=0;
			$AOECapable=0;
			$IndirectFireCapable=0;
			$Nth_Turn_Total_Damage=0;
			$Nth_Turn_Damage_available_perc=0;
			$Nth_Turn_Optimum_Range_Damage=0;
			$Nth_Turn_Damage_percent_at_Optimum_Range=0;
			$Turn_Out_Of_optimum_Range_Ammo=0;

			//N for nth turn calcs
			$Nturn=20;

			//get AOECapable && IndirectFireCapable from AMMO if its set there
			foreach($einfo as $key => $value) {
				if (preg_match("/^\.Weapon([^\.|]*)\|([^\|]*)\|([^\|]*)\|([^\|]*)\|([^\|]*)\|.$/", $key,$matches)){
					$wkey=$matches[1];
				if($wkey=="AOECapable" || $wkey="IndirectFireCapable")
					//$wtype="|".$matches[2]."|".$matches[3]."|".$matches[4]."|".$matches[5]."|";
				
					if(DUMP::$info)
						echo $wkey." from $key = $value ".PHP_EOL;
				
					foreach($einfo as $ekey => $evalue) {
						if (startswith($ekey,"Weapon.|") && endswith($ekey,"|.".$wkey."_activated") && $evalue==1){
							 if(Dump::weaponMatch($key,$ekey)){
								if(DUMP::$info)
									echo "Y $ekey = $h x $evalue".PHP_EOL;
								$einfo[$key]=1;
							 }else{
								if(DUMP::$info)
									echo "X $ekey".PHP_EOL;
							 }
						}
					}
				}
			}

	$winfo=array();
	foreach($einfo as $ekey => $wvalue) {
		if (preg_match("/^\.Weapon([^\.|]*)\|([^\|]*)\|([^\|]*)\|([^\|]*)\|([^\|]*)\|.$/", $ekey,$matches)){
			$wkey=$matches[1];
			$wtype="|".$matches[2]."|".$matches[3]."|".$matches[4]."|".$matches[5]."|";
			//".WeaponDamage|Ballistic|Gauss|Gauss|HYPERGAUSS|."
			if(!$winfo[$wtype])
				$winfo[$wtype]=array();
			$winfo[$wtype] [$wkey]=$wvalue;
		}
	}	


	for($t=1;$t<=$Nturn;$t++){
		foreach($winfo as $k=>&$weapont){
			$ammokey=Dump::AmmoStat($k,"AmmoCount");
			$weapont["AMMO"]=$ammokey;
			//echo "[=>].$k ~ \t".$ammokey."\t".$einfo[$ammokey]."\t".$weapon["MaxTurnsFired"].PHP_EOL;
			if($weapont["StartingAmmoCapacity"]>0){
				$weapont["MaxTurnsFired"]=$weapont["StartingAmmoCapacity"]/$weapont["ShotsWhenFired"];
			}else if($ammokey==null){
				$weapont["MaxTurnsFired"]=$Nturn+1;		
			}else if($einfo[$ammokey]>=$weapont["ShotsWhenFired"]){
				$weapont["MaxTurnsFired"]=$t;
				$einfo[$ammokey]=$einfo[$ammokey]-$weapont["ShotsWhenFired"];
			}
		}
	}//dont use $weapont again , php doesnt have a block scope. https://bugs.php.net/bug.php?id=29992

	if(DUMP::$info){
		echo "WEAPON INFO: ".PHP_EOL.json_encode($winfo,JSON_PRETTY_PRINT).PHP_EOL;
				
	}


	$ranges=array();
	$range_2_damage=array();
	$weaponcount=0;	
	foreach($winfo as $weapon){
		if($weapon["WeaponCount"]==0)
			continue;
		$weaponcount+=$weapon["WeaponCount"];
		$Weapons_Total_Damage+=$weapon["Damage"];
		
		if($weapon["MaxTurnsFired"]>=$Nturn){
			$Nth_Turn_Total_Damage+=$weapon["Damage"];
		}

		if($Weapons_Best_Single_Hit_Damage< ($weapon["Damage"]/$weapon["ProjectilesWhenFired"]) ){
			$Weapons_Best_Single_Hit_Damage=($weapon["Damage"]/$weapon["ProjectilesWhenFired"]); 
		}

		$range_2_damage[$weapon["OptimumRange"]]+=$weapon["Damage"];

		for($c=0;$c<$weapon["WeaponCount"];$c++){
			$ranges[]=$weapon["OptimumRange"];
		}
		
		$Weapons_Damage_Weighted_APCriticalChanceMultiplier+=$weapon["Damage"]*$weapon["APCriticalChanceMultiplier"];
		$Weapons_Total_Instability+=$weapon["Instability"];
		if($Weapons_Best_Single_Hit_Instability< ($weapon["Instability"]/$weapon["ShotsWhenFired"]) ){
			$Weapons_Best_Single_Hit_Instability=($weapon["Instability"]/$weapon["ShotsWhenFired"]);
		}
		if($weapon["AOECapable"])
			$AOECapable=1;
		if($weapon["IndirectFireCapable"])
			$IndirectFireCapable=1;
	}

	foreach($range_2_damage as $range=> $damage){
	 if($Weapons_Optimum_Range_Damage<$damage){
	 	 $Weapons_Optimum_Range_Damage=$damage;
		 $Weapons_Overall_Optimum_Range=$range;
	 }
	}

	$Turn_Out_Of_optimum_Range_Ammo=$Nturn+1;
	foreach($winfo as $weapon){
		if($weapon["WeaponCount"]==0)
			continue;
		if($weapon["OptimumRange"]==$Weapons_Overall_Optimum_Range){
			if($weapon["MaxTurnsFired"]>=$Nturn){
				$Nth_Turn_Optimum_Range_Damage+=$weapon["Damage"];	
			}
			if($weapon["MaxTurnsFired"]<$Turn_Out_Of_optimum_Range_Ammo){
				$Turn_Out_Of_optimum_Range_Ammo=$weapon["MaxTurnsFired"];	
			}
		}
	}

	
	if(count($ranges)>1)
		$Weapons_Optimum_Range_Std_Dev=sd($ranges,$Weapons_Overall_Optimum_Range);

	$Weapons_Damage_Efficency=$Weapons_Total_Damage/$tonnage;//Weapons Damage Efficency is damage per mech ton
	if($einfo["CACAPProtection_activated"]){
		$CACAPProtection=$einfo["CACAPProtection_activated"];
	}else {
	   $CACAPProtection=0;
	}

	if($Weapons_Total_Damage>0){
		$Damage_percent_at_Optimum_Range=$Weapons_Optimum_Range_Damage/$Weapons_Total_Damage*100;
		$Nth_Turn_Damage_available_perc=$Nth_Turn_Total_Damage/$Weapons_Total_Damage*100;
		$Nth_Turn_Damage_percent_at_Optimum_Range=$Nth_Turn_Optimum_Range_Damage/$Weapons_Total_Damage*100;
		$Nth_Turn_Damage_percent_at_Optimum_Range=$Damage_percent_at_Optimum_Range-$Nth_Turn_Damage_percent_at_Optimum_Range; //reduction in damage % at optimum range at turn N
	}

	if(DUMP::$info){
		echo "\t Weapons_Total_Damage $Weapons_Total_Damage".
			"\t Weapons_Best_Single_Hit_Damage $Weapons_Best_Single_Hit_Damage".
			"\t Weapons_Overall_Optimum_Range $Weapons_Overall_Optimum_Range".
			"\t Weapons_Optimum_Range_Std_Dev $Weapons_Optimum_Range_Std_Dev".
			"\t Weapons_Damage_Efficency $Weapons_Damage_Efficency".
			"\t Weapons_Optimum_Range_Damage $Weapons_Optimum_Range_Damage".
			"\t Damage_percent_at_Optimum_Range $Damage_percent_at_Optimum_Range".
			"\t Weapons_Damage_Weighted_APCriticalChanceMultiplier $Weapons_Damage_Weighted_APCriticalChanceMultiplier".
			"\t CACAPProtection $CACAPProtection".
			"\t Weapons_Total_Instability $Weapons_Total_Instability".
			"\t Weapons_Best_Single_Hit_Instability $Weapons_Best_Single_Hit_Instability".
			"\t AOECapable $AOECapable".
			"\t IndirectFireCapable $IndirectFireCapable".
			"\t Nth_Turn_Total_Damage $Nth_Turn_Total_Damage".
			"\t Nth_Turn_Damage_available_perc $Nth_Turn_Damage_available_perc".
			"\t Nth_Turn_Optimum_Range_Damage $Nth_Turn_Optimum_Range_Damage".
			"\t Nth_Turn_Damage_percent_at_Optimum_Range $Nth_Turn_Damage_percent_at_Optimum_Range".
			"\t Turn_Out_Of_optimum_Range_Ammo $Turn_Out_Of_optimum_Range_Ammo".PHP_EOL;
	}
}

public static function getDefensiveInfo($einfo,$chasisjd,&$armor,&$structure,&$leg_armor,&$leg_structure,&$armor_repair,&$structure_repair,&$leg_armor_repair,&$leg_structure_repair){
	$armor=0;
	$structure=0;
	$leg_armor=0;
	$leg_structure=0;
	$armor_repair=0;
	$structure_repair=0;
	$leg_armor_repair=0;
	$leg_structure_repair=0;
	$locations=$chasisjd['Locations'];
	foreach($locations as $l) {
		if(DUMP::$info){
			echo "Location:".$l['Location'].PHP_EOL;
			if($einfo[$l['Location'].".Armor_base"]>0){
				echo "\t.Armor_base ".$einfo[$l['Location'].".Armor_base"].PHP_EOL;
			}
			if($einfo[$l['Location'].".RearArmor_base"]>0){
				echo "\t.RearArmor_base ".$einfo[$l['Location'].".RearArmor_base"].PHP_EOL;
			}
			if($einfo[$l['Location'].".Structure_base"]>0){
				echo "\t.Structure_base ".$einfo[$l['Location'].".Structure_base"].PHP_EOL;
			}
			if($einfo[".".$l['Location'].".Custom.ActivatableComponent.Repair.Armor"]>0){
				echo "\t.Custom.ActivatableComponent.Repair.Armor ".$einfo[".".$l['Location'].".Custom.ActivatableComponent.Repair.Armor"].PHP_EOL;
			}
			if($einfo[".".$l['Location'].".Custom.ActivatableComponent.Repair.InnerStructure"]>0){
				echo "\t.Custom.ActivatableComponent.Repair.InnerStructure ".$einfo[".".$l['Location'].".Custom.ActivatableComponent.Repair.InnerStructure"].PHP_EOL;
			}
		}
		if($einfo[$l['Location'].".Armor_base"]>0){
			$armor+=$einfo[$l['Location'].".Armor_base"];
			if(endswith($l['Location'],"Leg"))
				$leg_armor+=$einfo[$l['Location'].".Armor_base"];
		}
		if($einfo[$l['Location'].".RearArmor_base"]>0){
			$armor+=$einfo[$l['Location'].".RearArmor_base"];
			if(endswith($l['Location'],"Leg"))
				$leg_armor+=$einfo[$l['Location'].".RearArmor_base"];
		}
		if($einfo[$l['Location'].".Structure_base"]>0){
			$structure+=$einfo[$l['Location'].".Structure_base"];
			if(endswith($l['Location'],"Leg"))
				$leg_structure+=$einfo[$l['Location'].".Structure_base"];
		}
		
		if($einfo[".".$l['Location'].".Custom.ActivatableComponent.Repair.Armor"]>0){
			$armor_repair+=$einfo[".".$l['Location'].".Custom.ActivatableComponent.Repair.Armor"];
			if(endswith($l['Location'],"Leg"))
				$leg_armor_repair+=$einfo[".".$l['Location'].".Custom.ActivatableComponent.Repair.Armor"];
		}
		if($einfo[".".$l['Location'].".Custom.ActivatableComponent.Repair.InnerStructure"]>0){
			$structure_repair+=$einfo[".".$l['Location'].".Custom.ActivatableComponent.Repair.InnerStructure"];
			if(endswith($l['Location'],"Leg"))
				$leg_structure_repair+=$einfo[".".$l['Location'].".Custom.ActivatableComponent.Repair.InnerStructure"];
		}
	}
	if(DUMP::$info){
			echo "armor: $armor leg_armor: $leg_armor structure: $structure leg_structure=$leg_structure".PHP_EOL;
			echo "armor_repair: $armor_repair leg_armor_repair: $leg_armor_repair structure_repair: $structure_repair leg_structure_repair=$leg_structure_repair".PHP_EOL;
	}
	
}

public static function initPhysicalInfo(&$einfo,$tonnage){

}

public static function getPhysicalInfo($einfo,$chasisjd,$tonnage,$max_move,$jump_distance_activated,$leg_armor,$leg_structure,$leg_armor_repair,$leg_structure_repair, &$ChargeAttackerDamage,&$ChargeTargetDamage,&$ChargeAttackerInstability,&$ChargeTargetInstability,&$DFAAttackerDamage,&$DFATargetDamage,&$DFAAttackerInstability,&$DFATargetInstability,&$KickDamage,&$KickInstability,&$PhysicalWeaponDamage,&$PhysicalWeaponInstability,&$PunchDamage,&$PunchInstability,&$dfa_self_damage_efficency,&$dfa_damage_efficency,&$dfa_self_instability_efficency){

	//Watch https://github.com/BattletechModders/CBTBehaviorsEnhanced/commits/master/CBTBehaviorsEnhanced/CBTBehaviorsEnhanced/Extensions/MechExtensions.cs

	//derived from RTdumper avg stats for tonnage 58.x avg move ~5.1
	$avg_tonnage=60;
	$avg_hexesMoved=min(5,$max_move);//constant assumption of distance to target

	//Calculations from MechExtensions.cs in CBTBehaviorsEnhanced
	$modjson=json_for_pk(JSONType::MODJSON,"CBTBehaviorsEnhanced");

	//$ChargeAttackerDamage
	$AttackerDamagePerTargetTon=$modjson['Settings']['Melee']['Charge']['AttackerDamagePerTargetTon'];
	$CBTBE_Charge_Attacker_Damage_Mod=$einfo['CBTBE_Charge_Attacker_Damage_Mod_activated'];
	$CBTBE_Charge_Attacker_Damage_Multi=$einfo['CBTBE_Charge_Attacker_Damage_Multi_activated'];
	$ChargeAttackerDamage=ceil ( (ceil($AttackerDamagePerTargetTon*$avg_tonnage)+$CBTBE_Charge_Attacker_Damage_Mod)*$CBTBE_Charge_Attacker_Damage_Multi );
	if(DUMP::$info){
			echo " (AttackerDamagePerTargetTon x targetTonnage ( $AttackerDamagePerTargetTon x $avg_tonnage ) + CBTBE_Charge_Attacker_Damage_Mod ($CBTBE_Charge_Attacker_Damage_Mod) )* CBTBE_Charge_Attacker_Damage_Multi ($CBTBE_Charge_Attacker_Damage_Multi)".PHP_EOL;
			echo " ChargeAttackerDamage=$ChargeAttackerDamage".PHP_EOL;
	}

	//$DFAAttackerDamage

	$AttackerDamagePerTargetTon=$modjson['Settings']['Melee']['DFA']['AttackerDamagePerTargetTon'];
	$CBTBE_DFA_Attacker_Damage_Mod=$einfo['CBTBE_DFA_Attacker_Damage_Mod_activated'];
	$CBTBE_DFA_Attacker_Damage_Multi=$einfo['CBTBE_DFA_Attacker_Damage_Multi_activated'];
	$DFAAttackerDamage=ceil ( (ceil($AttackerDamagePerTargetTon*$avg_tonnage)+$CBTBE_DFA_Attacker_Damage_Mod)*$CBTBE_DFA_Attacker_Damage_Multi );
	$DFAAttackerDamage*=$einfo["DFASelfDamage_activated"];
	if(DUMP::$info){
			echo " (AttackerDamagePerTargetTon x targetTonnage ( $AttackerDamagePerTargetTon x $avg_tonnage ) + CBTBE_DFA_Attacker_Damage_Mod ($CBTBE_DFA_Attacker_Damage_Mod) )* CBTBE_DFA_Attacker_Damage_Multi ($CBTBE_DFA_Attacker_Damage_Multi)".PHP_EOL;
			if($einfo["DFASelfDamage_activated"]!=1)
				echo " x DFASelfDamage_activated (".$einfo["DFASelfDamage_activated"].")".PHP_EOL;
			echo " DFAAttackerDamage=$DFAAttackerDamage".PHP_EOL;
	}

	//$DFATargetDamage
	$TargetDamagePerAttackerTon=$modjson['Settings']['Melee']['DFA']['TargetDamagePerAttackerTon'];
	$CBTBE_DFA_Target_Damage_Mod=$einfo['CBTBE_DFA_Target_Damage_Mod_activated'];
	$CBTBE_DFA_Target_Damage_Multi=$einfo['CBTBE_DFA_Target_Damage_Multi_activated'];
	$DFATargetDamage=ceil ( (ceil($TargetDamagePerAttackerTon*$tonnage)+$CBTBE_DFA_Target_Damage_Mod)*$CBTBE_DFA_Target_Damage_Multi );
	if(DUMP::$info){
			echo " (TargetDamagePerAttackerTon x tonnage ( $TargetDamagePerAttackerTon x $tonnage ) + CBTBE_DFA_Target_Damage_Mod ($CBTBE_DFA_Target_Damage_Mod) )* CBTBE_DFA_Target_Damage_Multi ($CBTBE_DFA_Target_Damage_Multi)".PHP_EOL;
			echo " DFATargetDamage=$DFATargetDamage".PHP_EOL;
	}

	//$ChargeTargetDamage
	
	$TargetDamagePerAttackerTon=$modjson['Settings']['Melee']['Charge']['TargetDamagePerAttackerTon'];
	$CBTBE_Charge_Target_Damage_Mod=$einfo['CBTBE_Charge_Target_Damage_Mod_activated'];
	$CBTBE_Charge_Target_Damage_Multi=$einfo['CBTBE_Charge_Target_Damage_Multi_activated'];
	$ChargeTargetDamage=ceil ( (ceil($TargetDamagePerAttackerTon*$tonnage*$avg_hexesMoved)+$CBTBE_Charge_Target_Damage_Mod)*$CBTBE_Charge_Target_Damage_Multi );
	if(DUMP::$info){
			echo " (TargetDamagePerAttackerTon x tonnage x hexesMoved ( $TargetDamagePerAttackerTon x $tonnage x $avg_hexesMoved ) + CBTBE_Charge_Target_Damage_Mod ($CBTBE_Charge_Target_Damage_Mod) )* CBTBE_Charge_Target_Damage_Multi ($CBTBE_Charge_Target_Damage_Multi)".PHP_EOL;
			echo " ChargeTargetDamage=$ChargeTargetDamage".PHP_EOL;
	}

	//$ChargeAttackerInstability

	$AttackerInstabilityPerTargetTon=$modjson['Settings']['Melee']['Charge']['AttackerInstabilityPerTargetTon'];
	$CBTBE_Charge_Attacker_Instability_Mod=$einfo['CBTBE_Charge_Attacker_Instability_Mod_activated'];
	$CBTBE_Charge_Attacker_Instability_Multi=$einfo['CBTBE_Charge_Attacker_Instability_Multi_activated'];
	$ChargeAttackerInstability=ceil ( (ceil($AttackerInstabilityPerTargetTon*$avg_tonnage*$avg_hexesMoved)+$CBTBE_Charge_Attacker_Instability_Mod)*$CBTBE_Charge_Attacker_Instability_Multi );
	if(DUMP::$info){
			echo " (AttackerInstabilityPerTargetTon x targetTonnage x hexesMoved ( $AttackerInstabilityPerTargetTon x $avg_tonnage x $avg_hexesMoved ) + CBTBE_Charge_Attacker_Instability_Mod ($CBTBE_Charge_Attacker_Instability_Mod) )* CBTBE_Charge_Attacker_Instability_Multi ($CBTBE_Charge_Attacker_Instability_Multi)".PHP_EOL;
			echo " ChargeAttackerInstability=$ChargeAttackerInstability".PHP_EOL;
	}

	//$ChargeTargetInstability

	$TargetInstabilityPerAttackerTon=$modjson['Settings']['Melee']['Charge']['TargetInstabilityPerAttackerTon'];
	$CBTBE_Charge_Target_Instability_Mod=$einfo['CBTBE_Charge_Target_Instability_Mod_activated'];
	$CBTBE_Charge_Target_Instability_Multi=$einfo['CBTBE_Charge_Target_Instability_Multi_activated'];
	$ChargeTargetInstability=ceil ( (ceil($TargetInstabilityPerAttackerTon*$tonnage*$avg_hexesMoved)+$CBTBE_Charge_Target_Instability_Mod)*$CBTBE_Charge_Target_Instability_Multi );
	if(DUMP::$info){
			echo " (TargetInstabilityPerAttackerTon x tonnage x hexesMoved ( $TargetInstabilityPerAttackerTon x $tonnage x $avg_hexesMoved ) + CBTBE_Charge_Target_Instability_Mod ($CBTBE_Charge_Target_Instability_Mod) )* CBTBE_Charge_Target_Instability_Multi ($CBTBE_Charge_Target_Instability_Multi)".PHP_EOL;
			echo " ChargeTargetInstability=$ChargeTargetInstability".PHP_EOL;
	}

	//$DFAAttackerInstability
	
	$AttackerInstabilityPerTargetTon=$modjson['Settings']['Melee']['DFA']['AttackerInstabilityPerTargetTon'];
	$CBTBE_DFA_Attacker_Instability_Mod=$einfo['CBTBE_DFA_Attacker_Instability_Mod_activated'];
	$CBTBE_DFA_Attacker_Instability_Multi=$einfo['CBTBE_DFA_Attacker_Instability_Multi_activated'];
	$DFAAttackerInstability=ceil ( (ceil($AttackerInstabilityPerTargetTon*$avg_tonnage)+$CBTBE_DFA_Attacker_Instability_Mod)*$CBTBE_DFA_Attacker_Instability_Multi );
	if(DUMP::$info){
			echo " (AttackerInstabilityPerTargetTon x targetTonnage ( $AttackerInstabilityPerTargetTon x $avg_tonnage ) + CBTBE_DFA_Attacker_Instability_Mod ($CBTBE_DFA_Attacker_Instability_Mod) )* CBTBE_DFA_Attacker_Instability_Multi ($CBTBE_DFA_Attacker_Instability_Multi)".PHP_EOL;
			echo " DFAAttackerInstability=$DFAAttackerInstability".PHP_EOL;
	}

	//$DFATargetInstability

	$TargetInstabilityPerAttackerTon=$modjson['Settings']['Melee']['DFA']['TargetInstabilityPerAttackerTon'];
	$CBTBE_DFA_Target_Instability_Mod=$einfo['CBTBE_DFA_Target_Instability_Mod_activated'];
	$CBTBE_DFA_Target_Instability_Multi=$einfo['CBTBE_DFA_Target_Instability_Multi_activated'];
	$DFATargetInstability=ceil ( (ceil($TargetInstabilityPerAttackerTon*$tonnage)+$CBTBE_DFA_Attacker_Instability_Mod)*$CBTBE_DFA_Target_Instability_Multi );
	if(DUMP::$info){
			echo " (TargetInstabilityPerAttackerTon x tonnage ( $TargetInstabilityPerAttackerTon x $tonnage ) + CBTBE_DFA_Target_Instability_Mod ($CBTBE_DFA_Target_Instability_Mod) )* CBTBE_DFA_Target_Instability_Multi ($CBTBE_DFA_Target_Instability_Multi)".PHP_EOL;
			echo " DFATargetInstability=$DFATargetInstability".PHP_EOL;
	}
	
	//$KickDamage
	$TargetDamagePerAttackerTon=$modjson['Settings']['Melee']['Kick']['TargetDamagePerAttackerTon'];
	$CBTBE_Kick_Target_Damage_Mod=$einfo['CBTBE_Kick_Target_Damage_Mod_activated'];
	$CBTBE_Kick_Target_Damage_Multi=$einfo['CBTBE_Kick_Target_Damage_Multi_activated'];
	//LegActuatorDamageReduction does not apply as we are calculating based on undamaged mech
	$KickDamage=ceil ( (ceil($TargetDamagePerAttackerTon*$tonnage)+$CBTBE_Kick_Target_Damage_Mod)*$CBTBE_Kick_Target_Damage_Multi );
	if($einfo['CBTBE_Kick_Extra_Hits_Count'] && !$modjson['Settings']['Melee']['ExtraHitsAverageAllDamage'])
		$KickDamage=$KickDamage*(1+$einfo['CBTBE_Kick_Extra_Hits_Count']);
	if(DUMP::$info){
			echo " (TargetDamagePerAttackerTon x tonnage ( $TargetDamagePerAttackerTon x $tonnage ) + CBTBE_Kick_Target_Damage_Mod ($CBTBE_Kick_Target_Damage_Mod) )* CBTBE_Kick_Target_Damage_Multi ($CBTBE_Kick_Target_Damage_Multi)".PHP_EOL;
			if($einfo['CBTBE_Kick_Extra_Hits_Count'] && !$modjson['Settings']['Melee']['ExtraHitsAverageAllDamage'])
				echo " x 1+CBTBE_Kick_Extra_Hits_Count x".(1+$einfo['CBTBE_Kick_Extra_Hits_Count']);
			echo " KickDamage=$KickDamage".PHP_EOL;
	}

	//$KickInstability
	$TargetInstabilityPerAttackerTon=$modjson['Settings']['Melee']['Kick']['TargetInstabilityPerAttackerTon'];
	$CBTBE_Kick_Target_Instability_Mod=$einfo['CBTBE_Kick_Target_Instability_Mod_activated'];
	$CBTBE_Kick_Target_Instability_Multi=$einfo['CBTBE_Kick_Target_Instability_Multi_activated'];
	$KickInstability=ceil ( (ceil($AttackerInstabilityPerTargetTon*$tonnage)+$CBTBE_Kick_Target_Instability_Mod)*$CBTBE_Kick_Target_Instability_Multi );
	//LegActuatorDamageReduction does not apply as we are calculating based on undamaged mech
	if(DUMP::$info){
			echo " (TargetInstabilityPerAttackerTon x tonnage ( $TargetInstabilityPerAttackerTon x $tonnage ) + CBTBE_Kick_Target_Instability_Mod ($CBTBE_Kick_Target_Instability_Mod) )* CBTBE_Kick_Target_Instability_Multi ($CBTBE_Kick_Target_Instability_Multi)".PHP_EOL;
			echo " KickInstability=$KickInstability".PHP_EOL;
	}


	//$PhysicalWeaponDamage
	$DamagePerAttackerTon=$einfo["CBTBE_Physical_Weapon_Target_Damage_Per_Attacker_Ton_activated"];
	if($DamagePerAttackerTon<=0)
	 $DamagePerAttackerTon=$modjson['Settings']['Melee']['PhysicalWeapon']['DefaultDamagePerAttackerTon'];
	$CBTBE_Physical_Weapon_Target_Damage_Mod=$einfo['CBTBE_Physical_Weapon_Target_Damage_Mod_activated'];
	$CBTBE_Physical_Weapon_Target_Damage_Multi=$einfo['CBTBE_Physical_Weapon_Target_Damage_Multi_activated'];
	$PhysicalWeaponDamage=ceil ( (ceil($DamagePerAttackerTon*$tonnage)+$CBTBE_Physical_Weapon_Target_Damage_Mod)*$CBTBE_Physical_Weapon_Target_Damage_Multi );
	if($einfo['CBTBE_Physical_Weapon_Extra_Hits_Count'] && !$modjson['Settings']['Melee']['ExtraHitsAverageAllDamage'])
		$PhysicalWeaponDamage=$PhysicalWeaponDamage*(1+$einfo['CBTBE_Physical_Weapon_Extra_Hits_Count']);
	if(DUMP::$info){
			echo " (CBTBE_Physical_Weapon_Target_Damage_Per_Attacker_Ton/DefaultDamagePerAttackerTon x tonnage ( $DamagePerAttackerTon x $tonnage ) + CBTBE_Physical_Weapon_Target_Damage_Mod ($CBTBE_Physical_Weapon_Target_Damage_Mod) )* CBTBE_Physical_Weapon_Target_Damage_Multi ($CBTBE_Physical_Weapon_Target_Damage_Multi)".PHP_EOL;
			if($einfo['CBTBE_Physical_Weapon_Extra_Hits_Count'] && !$modjson['Settings']['Melee']['ExtraHitsAverageAllDamage'])
				echo " x 1+CBTBE_Physical_Weapon_Extra_Hits_Count x ".(1+$einfo['CBTBE_Physical_Weapon_Extra_Hits_Count']);
			echo " PhysicalWeaponDamage=$PhysicalWeaponDamage".PHP_EOL;
	}

	//$PhysicalWeaponInstability
	$InstabilityPerAttackerTon=$einfo["CBTBE_Physical_Weapon_Target_Instability_Per_Attacker_Ton_activated"];
	if($InstabilityPerAttackerTon<=0)
	 $InstabilityPerAttackerTon=$modjson['Settings']['Melee']['PhysicalWeapon']['DefaultInstabilityPerAttackerTon'];
	$CBTBE_Physical_Weapon_Target_Instability_Mod=$einfo['CBTBE_Physical_Weapon_Target_Instability_Mod_activated'];
	$CBTBE_Physical_Weapon_Target_Instability_Multi=$einfo['CBTBE_Physical_Weapon_Target_Instability_Multi_activated'];
	$PhysicalWeaponInstability=ceil ( (ceil($InstabilityPerAttackerTon*$tonnage)+$CBTBE_Physical_Weapon_Target_Instability_Mod)*$CBTBE_Physical_Weapon_Target_Instability_Multi );
	//LegActuatorDamageReduction does not apply as we are calculating based on undamaged mech
	if(DUMP::$info){
			echo " (CBTBE_Physical_Weapon_Target_Instability_Per_Attacker_Ton/DefaultInstabilityPerAttackerTon x tonnage ( $InstabilityPerAttackerTon x $tonnage ) + CBTBE_Physical_Weapon_Target_Instability_Mod ($CBTBE_Physical_Weapon_Target_Instability_Mod) )* CBTBE_Physical_Weapon_Target_Instability_Multi ($CBTBE_Physical_Weapon_Target_Instability_Multi)".PHP_EOL;
			echo " PhysicalWeaponInstability=$PhysicalWeaponInstability".PHP_EOL;
	}

		
	//$PunchDamage
	$DamagePerAttackerTon=$einfo["CBTBE_Punch_Target_Damage_Per_Attacker_Ton_activated"];
	if($DamagePerAttackerTon<=0)
	 $DamagePerAttackerTon=$modjson['Settings']['Melee']['Punch']['TargetDamagePerAttackerTon'];
	$TargetDamagePerAttackerTon=$modjson['Settings']['Melee']['Kick']['CBTBE_Punch_Target_Damage_Per_Attacker_Ton'];
	$CBTBE_Punch_Target_Damage_Mod=$einfo['CBTBE_Punch_Target_Damage_Mod_activated'];
	$CBTBE_Punch_Target_Damage_Multi=$einfo['CBTBE_Punch_Target_Damage_Multi_activated'];
	//ArmActuatorDamageReduction applies to mechs without arms.
	$reduction=1;
	if($chasisjd["Custom"]["ArmActuatorSupport"]["LeftLimit"]=="Upper" && $chasisjd ["Custom"]["ArmActuatorSupport"]["RightLimit"]== "Upper" )
		$reduction=$modjson['Settings']['Melee']['Punch']['ArmActuatorDamageReduction'];

	$PunchDamage=ceil ( (ceil($DamagePerAttackerTon*$tonnage)+$CBTBE_Punch_Target_Damage_Mod)*$CBTBE_Punch_Target_Damage_Multi*$reduction );
	
	if($einfo['CBTBE_Punch_Extra_Hits_Count'] && !$modjson['Settings']['Melee']['ExtraHitsAverageAllDamage'])
		$PunchDamage=$PunchDamage*(1+$einfo['CBTBE_Kick_Extra_Hits_Count']);
	if(DUMP::$info){
			echo " (DamagePerAttackerTon x tonnage ( $DamagePerAttackerTon x $tonnage ) + CBTBE_Punch_Target_Damage_Mod ($CBTBE_Punch_Target_Damage_Mod) )* CBTBE_Punch_Target_Damage_Multi ($CBTBE_Punch_Target_Damage_Multi) * ArmActuatorDamageReduction ($reduction)".PHP_EOL;
			if($einfo['CBTBE_Punch_Extra_Hits_Count'] && !$modjson['Settings']['Melee']['ExtraHitsAverageAllDamage'])
				echo " x 1+CBTBE_Punch_Extra_Hits_Count x".(1+$einfo['CBTBE_Punch_Extra_Hits_Count']);
			echo " PunchDamage=$PunchDamage".PHP_EOL;
	}

	//$PunchInstability
	$TargetInstabilityPerAttackerTon=$einfo["CBTBE_Punch_Target_Instability_Per_Attacker_Ton_activated"];
	if($TargetInstabilityPerAttackerTon<=0)
		$TargetInstabilityPerAttackerTon=$modjson['Settings']['Melee']['Punch']['TargetInstabilityPerAttackerTon'];
	$CBTBE_Punch_Target_Instability_Mod=$einfo['CBTBE_Punch_Target_Instability_Mod_activated'];
	$CBTBE_Punch_Target_Instability_Multi=$einfo['CBTBE_Punch_Target_Instability_Multi_activated'];
	//ArmActuatorDamageReduction applies to mechs without arms.
	$reduction=1;
	if($chasisjd["Custom"]["ArmActuatorSupport"]["LeftLimit"]=="Upper" && $chasisjd ["Custom"]["ArmActuatorSupport"]["RightLimit"]== "Upper" )
		$reduction=$modjson['Settings']['Melee']['Punch']['ArmActuatorDamageReduction'];
	$PunchInstability=ceil ( (ceil($TargetInstabilityPerAttackerTon*$tonnage)+$CBTBE_Punch_Target_Instability_Mod)*$CBTBE_Punch_Target_Instability_Multi*$reduction );
	//ArmActuatorDamageReduction does not apply as we are calculating based on undamaged mech
	if(DUMP::$info){
			echo " (CBTBE_Punch_Target_Instability_Per_Attacker_Ton/TargetInstabilityPerAttackerTon x tonnage ( $TargetInstabilityPerAttackerTon x $tonnage ) + CBTBE_Punch_Target_Instability_Mod ($CBTBE_Punch_Target_Instability_Mod) )* CBTBE_Punch_Target_Instability_Multi ($CBTBE_Punch_Target_Instability_Multi) * ArmActuatorDamageReduction ($reduction)".PHP_EOL;
			echo " PunchInstability=$PunchInstability".PHP_EOL;
	}
	if(!($einfo["CBTBE_Punch_Is_Physical_Weapon_activated"] && $einfo["CBTBE_Punch_Is_Physical_Weapon_activated"]==1))
	{
			$PhysicalWeaponDamage=0;
			$PhysicalWeaponInstability=0;
			if(DUMP::$info){
				echo "NO Physical weapon !!".PHP_EOL;
			}
	}
	if($jump_distance_activated<1){
		 $DFAAttackerDamage=0;
		 $DFATargetDamage=0;
		 $DFAAttackerInstability=0;
		 $DFATargetInstability=0;
		 	if(DUMP::$info){
				echo "NO JJ NO DFA !!".PHP_EOL;
			}
	}
	if(DUMP::$info){
		echo "ChargeTargetDamage=$ChargeTargetDamage, DFATargetDamage=$DFATargetDamage, KickDamage=$KickDamage, PhysicalWeaponDamage=$PhysicalWeaponDamage, PunchDamage=$PunchDamage, PunchInstability=$PunchInstability".PHP_EOL;
	}
	//Fake key to figure out damage multiplier
	$key=".WeaponDamagePerShot|something|something|Melee|something|.";
	if(DUMP::$info)
		echo "DamagePerShot from $key = <various> ".PHP_EOL;
				
	foreach($einfo as $ekey => $evalue) {
		if (startswith($ekey,"Weapon.|") && endswith($ekey,"|.DamagePerShot_activated") ){
				if(Dump::weaponMatch($key,$ekey)){
					if(DUMP::$info)
						echo "Y $ekey = <various> x $evalue".PHP_EOL;
					$ChargeTargetDamage=$ChargeTargetDamage*$evalue;
					$DFATargetDamage=$DFATargetDamage*$evalue;
					$KickDamage=$KickDamage*$evalue;
					$PhysicalWeaponDamage=$PhysicalWeaponDamage*$evalue;
					$PunchDamage=$PunchDamage*$evalue;
					$PunchInstability=$PunchInstability*$evalue;
					}else{
					if(DUMP::$info)
						echo "X $ekey".PHP_EOL;
					}
		}
	}

	$key=".WeaponDamagePerShot|something|something|DFA|something|.";
	if(DUMP::$info)
		echo "DamagePerShot from $key = $DFATargetDamage ".PHP_EOL;
				
	foreach($einfo as $ekey => $evalue) {
		if (startswith($ekey,"Weapon.|") && endswith($ekey,"|.DamagePerShot_activated") ){
				if(Dump::weaponMatch($key,$ekey)){
					if(DUMP::$info)
						echo "Y $ekey = $DFATargetDamage x $evalue".PHP_EOL;
						$DFATargetDamage=$DFATargetDamage*$evalue;
					}else{
					if(DUMP::$info)
						echo "X $ekey".PHP_EOL;
					}
		}
	}



	//DFA Self Damage Efficency is how many a DFAs a mech can perform before both its legs break
	//<check> For mechs with leg repair, its delibrately incorrect as mechs with repair could infinitely survive DFA ?
	//this calculation is adjusted for statistical weirdness when tagging
	$dfa_self_damage_efficency=0;
	$dfa_self_instability_efficency=0;
	if($DFAAttackerDamage>0){
		$turn_damage=$DFAAttackerDamage-min((/*repaired armour/struct*/$leg_armor_repair+$leg_structure_repair)/2/*repair duration adjust*/,$DFAAttackerDamage);
		if($turn_damage==0)//legs never going to break
			$dfa_self_damage_efficency= 25;
		else
			$dfa_self_damage_efficency=ceil(($leg_armor+$leg_structure)/$turn_damage);

		if($dfa_self_damage_efficency>25)//something else bound to kill mech
			$dfa_self_damage_efficency= 25;

		//DFA Self Instability Efficency is Self UnsteadyThreshold remaining after DFA  expressed as % of UnsteadyThreshold
		$dfa_self_instability_efficency=($einfo['UnsteadyThreshold_activated']-($DFAAttackerInstability*($einfo['ReceivedInstabilityMultiplier_activated']?$einfo['ReceivedInstabilityMultiplier_activated']:1) ))/$einfo['UnsteadyThreshold_activated']*100;
		if($dfa_self_instability_efficency<0)
			$dfa_self_instability_efficency=0;
	}

	//DFA Damage Efficency is DFA damage per mech(attacker) tonnage
	$dfa_damage_efficency=$DFATargetDamage/$tonnage;



	if(DUMP::$info){
		echo "ChargeTargetDamage=$ChargeTargetDamage, DFATargetDamage=$DFATargetDamage, KickDamage=$KickDamage, PhysicalWeaponDamage=$PhysicalWeaponDamage, PunchDamage=$PunchDamage, PunchInstability=$PunchInstability".PHP_EOL;
		echo "dfa_self_damage_efficency=$dfa_self_damage_efficency, dfa_damage_efficency=$dfa_damage_efficency, dfa_self_instability_efficency=$dfa_self_instability_efficency".PHP_EOL;
	}

	
	
}

public static function initHeatInfo(&$einfo,$engine_rating,$tonnage){
}

public static function getHeatInfo($einfo,$engine_rating,$tonnage,&$dissipation_capacity_base,&$dissipation_capacity_activated,&$heat_generated,&$jump_heat_base,&$jump_heat_activated,&$heat_efficency){
		$MEmodjson=json_for_pk(JSONType::MODJSON,"#MESettings");

		$MinimumHeatSinksOnMech=$MEmodjson["Engine"]["MinimumHeatSinksOnMech"];

		$dissipation_capacity_base=0;
		$dissipation_capacity_activated=0;
		$heat_generated=0;
		$jump_heat_base=0;
		$jump_heat_activated=0;
		$heat_efficency=100;

		$internal_hs=(int)($engine_rating/25);
		if($internal_hs>$MinimumHeatSinksOnMech)
		 $internal_hs=$MinimumHeatSinksOnMech;
		$internal_hs+= $einfo[".Custom.EngineHeatBlock"];
		$heatsinkjd=json_for_pk(JSONType::COMPONENT, $einfo[".Custom.Cooling.HeatSinkDefId"]);
		$per_heatsink_dissipation=$heatsinkjd["DissipationCapacity"];
		$dissipation_capacity_base=($internal_hs * $per_heatsink_dissipation)*(1+$einfo["heatSinkMultiplier_base"])+$einfo[".DissipationCapacity"]+$einfo["HeatSinkCapacity_base"]-$einfo["EndMoveHeat_base"];
		$dissipation_capacity_activated=($internal_hs * $per_heatsink_dissipation)*(1+$einfo["heatSinkMultiplier_activated"])+$einfo[".DissipationCapacity"]-$einfo["EndMoveHeat_activated"]+$einfo["HeatSinkCapacity_activated"];
		$heat_generated=0;

		foreach($einfo as $key => $value) {
			if (startswith($key,".WeaponHeatGenerated|")){
				$h=$value;
				
				if(DUMP::$info)
					echo "HeatGenerated from $key = $h ".PHP_EOL;
				
				foreach($einfo as $ekey => $evalue) {
					if (startswith($ekey,"Weapon.|") && endswith($ekey,"|.HeatGenerated_activated") ){
						 if(Dump::weaponMatch($key,$ekey)){
							if(DUMP::$info)
								echo "Y $ekey = $h x $evalue".PHP_EOL;
							$h=$h*$evalue;
						 }else{
							if(DUMP::$info)
								echo "X $ekey".PHP_EOL;
						 }
					}else if (startswith($ekey,"Weapon.|") && endswith($ekey,"|.WeaponHeatMultiplier_activated") ){
						 if(Dump::weaponMatch($key,$ekey)){
							if(DUMP::$info)
								echo "Y $ekey = $h x $evalue".PHP_EOL;
							$h=$h*$evalue;
						 }else{
							if(DUMP::$info)
								echo "X $ekey".PHP_EOL;
						 }
					}
				}
				if(DUMP::$info)
					echo "= $h ".PHP_EOL;
				$heat_generated+=$h;
			}
		}
		//$MinimJumpHeat=$MEmodjson["Engine"]["MinimJumpHeat"]; We are calculating per hex
		$jump_heat_base=$einfo["JumpHeat_base"];
		$jump_heat_activated=$einfo["JumpHeat_activated"];
		if(DUMP::$info){
			 echo "DissipationCapacity Internal[ $internal_hs x $per_heatsink_dissipation x ".(1+$einfo["heatSinkMultiplier_base"])." ] + External[".$einfo[".DissipationCapacity"]."] + HeatSinkCapacity[".+$einfo["HeatSinkCapacity_base"]."] -EndMoveHeat =[".$einfo["EndMoveHeat_base"]."] = ".$dissipation_capacity_base.PHP_EOL;
			 echo "Activated EndMoveHeat = ".$einfo["EndMoveHeat_activated"]." |Activatable HeatSinkCapacity=".$einfo["HeatSinkCapacity_activated"]." |Activatable heatSinkMultiplier =".$einfo["heatSinkMultiplier_activated"].PHP_EOL;
			 echo "Total Heat Generated (weapons) = $heat_generated".PHP_EOL;
		}
		$combatgameconstants=json_for_pk(JSONType::MODJSON,"#CombatGameConstants");
		//Heat Efficency is just spare heat dissipation after alpha strike expressed as % (+/-) over overheat level
		$heat_efficency=($dissipation_capacity_activated-$heat_generated)/($combatgameconstants["Heat"]["OverheatLevel"]*$combatgameconstants["Heat"]["MaxHeat"])*100;
}

public static function lowVisSplit($s,$x){
	$s=explode ("_", $s); 
	return $s[$x];
}

public static function AmmoStat($key,$stat){
//key |Ballistic|Autocannon|AC5|AC5|
	$k=explode ("|", $key); 
	if($k[4]=="*")
		return null;
	return ".Ammo.|*|*|*|".$k[4]."|.".$stat;

}

public static function weaponMatch($key,$ekey){
    //".WeaponHeatGenerated|Energy|Laser|LargeLaser|*|." key <-weapon
    //"Weapon.|*|Laser|*|*|.HeatGenerated_activated" ekey <-equipment with targetCollection Weapon
	$k=explode ("|", $key); 
	$e=explode ("|", $ekey); 
	if($e[1]!='*' && $e[1]!=$k[1])
		return FALSE;
	if($e[2]!='*' && $e[2]!=$k[2])
		return FALSE;
	if($e[3]!='*' && $e[3]!=$k[3])
		return FALSE;
	if($e[4]!='*' && $e[4]!=$k[4])
		return FALSE;
	return TRUE;
}

public static function gatherEquipment($jd,$json_loc,&$e,&$einfo,&$effects,&$ammoeffects){
	if(!$jd[$json_loc])
	{
		if(DUMP::$debug)
			echo "[DEBUG] Missing $json_loc in ".json_encode($jd,JSON_PRETTY_PRINT).PHP_EOL;
		return;
	}
	foreach($jd[$json_loc] as $item){
		array_push($e,$item["ComponentDefID"]);
		if(endswith_i($item["ComponentDefID"],"ReportMe"))
		{
			$einfo[".Custom.EngineCore"]=null;
			throw new Exception("Component caused mech to be ignored ".$item["ComponentDefID"]);
		}
		$location="ALL";
		if($item["MountedLocation"])
		  $location=$item["MountedLocation"];


		$componentjd=json_for_pk(JSONType::COMPONENT, $item["ComponentDefID"]);
		if(DUMP::$info)
			echo PHP_EOL."||".$item["ComponentDefID"]." ===========================> ".PHP_EOL.json_encode($componentjd,JSON_PRETTY_PRINT).PHP_EOL.PHP_EOL;
		
		//engine rating
		$enginejd=json_for_pk(JSONType::ENGINE, $item["ComponentDefID"]);
		if($enginejd){
			$einfo[".Custom.EngineCore"]=$enginejd["Custom"]["EngineCore"];
			if(DUMP::$info)
				echo "EINFO[.Custom.EngineCore ] : ".$einfo[".Custom.EngineCore"].PHP_EOL;
		}

		//CASE 
		if($componentjd["Custom"] && $componentjd["Custom"]["CASE"] && $componentjd["Custom"]["CASE"]["MaximumDamage"]){
			$einfo[".Custom.CASE.MaximumDamage"]= (int)$componentjd["Custom"]["CASE"]["MaximumDamage"];
			if(DUMP::$info)
				echo "EINFO[.Custom.CASE.MaximumDamage ] : ".$einfo[".Custom.CASE.MaximumDamage"].PHP_EOL;
		}
		
		//.AMSSINGLE_HeatGenerated && .AMSMULTI_HeatGenerated
		if($componentjd["PrefabIdentifier"]=="AMS"){
		 //echo "{}".$item["ComponentDefID"].PHP_EOL;
		 if($componentjd["IsAAMS"]==true && $componentjd["HeatGenerated"] && $componentjd["HeatGenerated"]>$einfo[".AMSMULTI_HeatGenerated"])
		 {
			$einfo[".AMSMULTI_HeatGenerated"]= $componentjd["HeatGenerated"];
		 }elseif($componentjd["IsAAMS"]==true && $componentjd["HeatGenerated"] && $componentjd["HeatGenerated"]>$einfo[".AMSSINGLE_HeatGenerated"]){
			$einfo[".AMSSINGLE_HeatGenerated"]=$mode["HeatGenerated"];
		 }
		 if(is_array($componentjd["Modes"])){
			 foreach($componentjd["Modes"] as $mode)
			 {
		 		 if(($mode["IsAAMS"]==true || $componentjd["IsAAMS"]==true) && $mode["HeatGenerated"]>$einfo[".AMSMULTI_HeatGenerated"])
				 {
					$einfo[".AMSMULTI_HeatGenerated"]= $mode["HeatGenerated"];
				 }elseif(($mode["IsAAMS"]==true || $componentjd["IsAAMS"]==true) && $mode["HeatGenerated"]>$einfo[".AMSSINGLE_HeatGenerated"]){
					$einfo[".AMSSINGLE_HeatGenerated"]=$mode["HeatGenerated"];
				 }
			 }
		 }

		if(DUMP::$info)
			echo "EINFO[.AMSMULTI_HeatGenerated ] : ".$einfo[".AMSMULTI_HeatGenerated"].PHP_EOL;
		if(DUMP::$info)
			echo "EINFO[.AMSSINGLE_HeatGenerated ] : ".$einfo[".AMSSINGLE_HeatGenerated"].PHP_EOL;
		}

		//.CBTBE_AmmoBoxExplosionDamage && .CBTBE_VolatileAmmoBoxExplosionDamage
		//this differs from CBTBE as it measures total explosion+heat+structure. We only take explosion damage
		if($componentjd["Custom"] && $componentjd["Custom"]["ComponentExplosion"] && $componentjd["Capacity"]){
			//ignore StabilityDamagePerAmmo as its non fatal
			//ignore HeatDamagePerAmmo as it adds heat and not damage. "CriticalHeatPerLocationLight" etc are set to 0 in RT
			$d=$componentjd["Custom"]["ComponentExplosion"]["ExplosionDamagePerAmmo"]*$componentjd["Capacity"];
			if($componentjd["Custom"] && $componentjd["Custom"]["VolatileAmmo"]){
				 if($componentjd["Custom"]["VolatileAmmo"]["damageWeighting"])
					$d*=$componentjd["Custom"]["VolatileAmmo"]["damageWeighting"];
				 if($d>$einfo[".CBTBE_VolatileAmmoBoxExplosionDamage"]){
					$einfo[".CBTBE_VolatileAmmoBoxExplosionDamage"]= $d;
					 if(DUMP::$info)
						echo "EINFO[.CBTBE_VolatileAmmoBoxExplosionDamage ] : ".$einfo[".CBTBE_VolatileAmmoBoxExplosionDamage"].PHP_EOL;
				 }
			}
			if($d>$einfo[".CBTBE_AmmoBoxExplosionDamage"]){
				$einfo[".CBTBE_AmmoBoxExplosionDamage"]= $d;
				if(DUMP::$info)
					echo "EINFO[.CBTBE_AmmoBoxExplosionDamage ] : ".$einfo[".CBTBE_AmmoBoxExplosionDamage"].PHP_EOL;
			}
		}

		//Heat
		if($componentjd["Custom"] && $componentjd["Custom"]["EngineHeatBlock"]){
			$einfo[".Custom.EngineHeatBlock"]=$einfo[".Custom.EngineHeatBlock"]+(int)$componentjd["Custom"]["EngineHeatBlock"];
			if(DUMP::$info)
				echo "EINFO[.Custom.EngineHeatBlock ] : ".$einfo[".Custom.EngineHeatBlock"].PHP_EOL;
		}
		if($componentjd["Custom"] && $componentjd["Custom"]["Cooling"] && $componentjd["Custom"]["Cooling"]["HeatSinkDefId"]){
			$einfo[".Custom.Cooling.HeatSinkDefId"]=$componentjd["Custom"]["Cooling"]["HeatSinkDefId"];
			if(DUMP::$info)
				echo "EINFO[.Custom.Cooling.HeatSinkDefId ] : ".$einfo[".Custom.Cooling.HeatSinkDefId"].PHP_EOL;
		}
		if($componentjd["DissipationCapacity"])
		{
			$einfo[".DissipationCapacity"]=$einfo[".DissipationCapacity"]+(float)$componentjd["DissipationCapacity"];
			if(DUMP::$info)
				echo "EINFO[.DissipationCapacity ] : ".$einfo[".DissipationCapacity"].PHP_EOL;
		}
		if($componentjd["JumpCapacity"])
		{
			$einfo[".JumpCapacity"]=$einfo[".JumpCapacity"]+(float)$componentjd["JumpCapacity"];
			if(DUMP::$info)
				echo "EINFO[.JumpCapacity ] : ".$einfo[".JumpCapacity"].PHP_EOL;
		}
		
		if($componentjd["HeatGenerated"])
		{
			$class=
				  "|".( (!$componentjd["Category"] || $componentjd["Category"]=="NotSet") ? "*" :$componentjd["Category"]).
				  "|".( (!$componentjd["Type"] || $componentjd["Type"]=="NotSet") ? "*" :$componentjd["Type"]).
				  "|".( (!$componentjd["WeaponSubType"] || $componentjd["WeaponSubType"]=="NotSet") ? "*" :$componentjd["WeaponSubType"]).
				  "|".( (!$componentjd["AmmoCategory"] || $componentjd["AmmoCategory"]=="NotSet") ? "*" :$componentjd["AmmoCategory"]).
				  "|.";
		    $k=".".$componentjd["ComponentType"]."HeatGenerated".$class;
			$einfo[$k]=($einfo[$k] ? $einfo[$k] :0) +(float)$componentjd["HeatGenerated"];
			if(DUMP::$info)
				echo "EINFO[$k ] : ".$einfo[$k].PHP_EOL;
		}
		//Heat

		//Damage
		if($componentjd["Damage"] && $componentjd["ShotsWhenFired"] && $componentjd["ProjectilesPerShot"])
		{
			$class=
				  "|".( (!$componentjd["Category"] || $componentjd["Category"]=="NotSet") ? "*" :$componentjd["Category"]).
				  "|".( (!$componentjd["Type"] || $componentjd["Type"]=="NotSet") ? "*" :$componentjd["Type"]).
				  "|".( (!$componentjd["WeaponSubType"] || $componentjd["WeaponSubType"]=="NotSet") ? "*" :$componentjd["WeaponSubType"]).
				  "|".( (!$componentjd["AmmoCategory"] || $componentjd["AmmoCategory"]=="NotSet") ? "*" :$componentjd["AmmoCategory"]).
				  "|.";

		    $k=".".$componentjd["ComponentType"]."Damage".$class;
			$einfo[$k]=($einfo[$k] ? $einfo[$k] :0) +((float)$componentjd["Damage"]*$componentjd["ShotsWhenFired"]*$componentjd["ProjectilesPerShot"]);
			if(DUMP::$info)
				echo "EINFO[$k ] : ".$einfo[$k].PHP_EOL;

			$k=".".$componentjd["ComponentType"]."WeaponCount".$class;
			$einfo[$k]=($einfo[$k] ? $einfo[$k] :0) +1;//count number of this weapon on mech
			if(DUMP::$info)
				echo "EINFO[$k ] : ".$einfo[$k].PHP_EOL;

			$k=".".$componentjd["ComponentType"]."ShotsWhenFired".$class;
			$einfo[$k]=($einfo[$k] ? $einfo[$k] :0) +$componentjd["ShotsWhenFired"];//count number of this weapon on mech
			if(DUMP::$info)
				echo "EINFO[$k ] : ".$einfo[$k].PHP_EOL;

			$k=".".$componentjd["ComponentType"]."ProjectilesWhenFired".$class;
			$einfo[$k]=($einfo[$k] ? $einfo[$k] :0) +($componentjd["ShotsWhenFired"]*$componentjd["ProjectilesPerShot"]);//count number of this weapon on mech
			if(DUMP::$info)
				echo "EINFO[$k ] : ".$einfo[$k].PHP_EOL;

			$k=".".$componentjd["ComponentType"]."OptimumRange".$class;
			$einfo[$k]=$componentjd["RangeSplit"][1];
			if(DUMP::$info)
				echo "EINFO[$k ] : ".$einfo[$k].PHP_EOL;

			$k=".".$componentjd["ComponentType"]."StartingAmmoCapacity".$class;
			$einfo[$k]=($einfo[$k] ? $einfo[$k] :0) +($componentjd["StartingAmmoCapacity"]);//check if this is built in ammo counter
			if(DUMP::$info)
				echo "EINFO[$k ] : ".$einfo[$k].PHP_EOL;
			
			$k=".".$componentjd["ComponentType"]."AOECapable".$class;
			if($componentjd["AOECapable"]){
				$einfo[$k]=1;				
			}else{
				$einfo[$k]=0;
			}
			if(DUMP::$info)
					echo "EINFO[$k ] : ".$einfo[$k].PHP_EOL;

			$k=".".$componentjd["ComponentType"]."IndirectFireCapable".$class;
			if($componentjd["IndirectFireCapable"]){
				$einfo[$k]=1;				
			}else{
				$einfo[$k]=0;
			}
			if(DUMP::$info)
					echo "EINFO[$k ] : ".$einfo[$k].PHP_EOL;

			if($componentjd["Modes"]){
				foreach($componentjd["Modes"] as $mode){
					$k=".".$componentjd["ComponentType"]."AOECapable".$class;
					if($mode["AOECapable"] && $mode["AOECapable"]===true){
						$einfo[$k]=1;				
						if(DUMP::$info)
							echo "EINFO[$k ] : ".$einfo[$k].PHP_EOL;
					}

					$k=".".$componentjd["ComponentType"]."IndirectFireCapable".$class;
					if($mode["IndirectFireCapable"] && $mode["IndirectFireCapable"]===true){
						$einfo[$k]=1;				
						if(DUMP::$info)
							echo "EINFO[$k ] : ".$einfo[$k].PHP_EOL;
					}
				}
			}


			$k=".".$componentjd["ComponentType"]."Instability".$class;
			$einfo[$k]=($einfo[$k] ? $einfo[$k] :0) +((float)$componentjd["Instability"]*$componentjd["ShotsWhenFired"]);
			if(DUMP::$info)
				echo "EINFO[$k ] : ".$einfo[$k].PHP_EOL;
			/* I'm just taking the AP chance , other stuff depends on target state
			=TAC Example=
			Mech with 100 armor from 200 and full structure. 
			Min crit chance 0.1. 
			Weapon has APArmorShardsMod = 0.5 
			APMaxArmorThickness = 150
			APCritChance = 0.5

			Shard Modifier = 1 + (1 - 100/200) = 1.5 
			Thickness Modifier = 1 - 100/150 = 0.33333(3)
			Overall chance  = 0.1 (Base minimum) * 1.5 (Shards Modifier) * 0.33333 (Thickness Modifier) * 0.5 (AP chance) = 0.025
			As armor becomes lower, both modifiers for shard and thickness will rise.
			*/
			$k=".".$componentjd["ComponentType"]."APCriticalChanceMultiplier".$class;
			$einfo[$k]=$componentjd["APCriticalChanceMultiplier"];
			if(DUMP::$info)
				echo "EINFO[$k ] : ".$einfo[$k].PHP_EOL;

			$k=".".$componentjd["ComponentType"]."APArmorShardsMod".$class;
			$einfo[$k]=$componentjd["APArmorShardsMod"];
			if(DUMP::$info)
				echo "EINFO[$k ] : ".$einfo[$k].PHP_EOL;

			$k=".".$componentjd["ComponentType"]."APMaxArmorThickness".$class;
			$einfo[$k]=$componentjd["APMaxArmorThickness"];
			if(DUMP::$info)
				echo "EINFO[$k ] : ".$einfo[$k].PHP_EOL;
		}

		if($componentjd["Custom"] && $componentjd["Custom"]["ActivatableComponent"] && $componentjd["Custom"]["ActivatableComponent"]["AutoActivateOnHeat"]){
			if($componentjd["Custom"]["ActivatableComponent"]["AutoActivateOnHeat"]>$einfo[".Custom.ActivatableComponent.AutoActivateOnHeat"])
				$einfo[".Custom.ActivatableComponent.AutoActivateOnHeat"]=(int) $componentjd["Custom"]["ActivatableComponent"]["AutoActivateOnHeat"];
			if(DUMP::$info)
				echo "EINFO[.Custom.ActivatableComponent.AutoActivateOnHeat ] : ".$einfo[".Custom.ActivatableComponent.AutoActivateOnHeat"].PHP_EOL;
		}

		//Repair
		if($componentjd["Custom"] && $componentjd["Custom"]["ActivatableComponent"] && $componentjd["Custom"]["ActivatableComponent"]["Repair"] && !$componentjd["Custom"]["ActivatableComponent"]["Repair"]["AffectInstalledLocation"]){
			//TODO
			echo "|WARNING| Repair non installation location not handled.".PHP_EOL;
			echo "||". $item["ComponentDefID"].PHP_EOL.json_encode($componentjd["Custom"]["ActivatableComponent"]["Repair"],JSON_PRETTY_PRINT).PHP_EOL;
		}

		if($componentjd["Custom"] && $componentjd["Custom"]["ActivatableComponent"] && $componentjd["Custom"]["ActivatableComponent"]["Repair"] && $componentjd["Custom"]["ActivatableComponent"]["Repair"]["AffectInstalledLocation"]){
			if($componentjd["Custom"]["ActivatableComponent"]["Repair"]["InnerStructure"]>0){
				$einfo[".".$location.".Custom.ActivatableComponent.Repair.InnerStructure"]+=$componentjd["Custom"]["ActivatableComponent"]["Repair"]["InnerStructure"];
				if($componentjd["Custom"]["ActivatableComponent"]["Repair"]["TurnsSinceDamage"]>0)
					$einfo[".".$location.".Custom.ActivatableComponent.Repair.InnerStructure"]*=$componentjd["Custom"]["ActivatableComponent"]["Repair"]["TurnsSinceDamage"];
				if(DUMP::$info)
					echo "EINFO[.".$location.".Custom.ActivatableComponent.Repair.InnerStructure ] : ".$einfo[".".$location.".Custom.ActivatableComponent.Repair.InnerStructure"].PHP_EOL;
			}
			if($componentjd["Custom"]["ActivatableComponent"]["Repair"]["Armor"]>0){
				$einfo[".".$location.".Custom.ActivatableComponent.Repair.Armor"]+=$componentjd["Custom"]["ActivatableComponent"]["Repair"]["Armor"];
				if($componentjd["Custom"]["ActivatableComponent"]["Repair"]["TurnsSinceDamage"]>0)
					$einfo[".".$location.".Custom.ActivatableComponent.Repair.Armor"]*=$componentjd["Custom"]["ActivatableComponent"]["Repair"]["TurnsSinceDamage"];
				if(DUMP::$info)
					echo "EINFO[.".$location.".Custom.ActivatableComponent.Repair.Armor ] : ".$einfo[".".$location.".Custom.ActivatableComponent.Repair.Armor"].PHP_EOL;
			}
		}

		if($componentjd["statusEffects"] ){
			foreach($componentjd["statusEffects"] as $effectjd){
				Dump::gatherEquipmentEffectInfo($item["ComponentDefID"],$location,$effectjd,$einfo,$effects);
			}
		}	

		if($componentjd["Auras"] ){
			foreach($componentjd["Auras"] as $aura){
			    if($aura["statusEffects"]){
					foreach($aura["statusEffects"]  as $effectjd){
						Dump::gatherEquipmentEffectInfo($item["ComponentDefID"],$location,$effectjd,$einfo,$effects);
					}
				}
			}
		}

		if($componentjd["Custom"] && $componentjd["Custom"]["ActivatableComponent"] && $componentjd["Custom"]["ActivatableComponent"]["statusEffects"]){
			foreach($componentjd["Custom"]["ActivatableComponent"]["statusEffects"]  as $effectjd){
				$force_activated=true;
				if($componentjd["Custom"]["ActivatableComponent"]["ActiveByDefault"]===TRUE)
				  $force_activated=false;
				Dump::gatherEquipmentEffectInfo($item["ComponentDefID"],$location,$effectjd,$einfo,$effects,$force_activated);
			}
		}

		if($componentjd["AmmoID"]){
			$ammoid=$componentjd["AmmoID"];
			$ammojd=json_for_pk(JSONType::AMMO,$ammoid);
			if(!$ammojd){
				echo "ERROR: AMMO json not loaded $ammoid".PHP_EOL;
				exit;
			}
			if(DUMP::$info)
				echo PHP_EOL."|AMMO|".$ammoid." ===========================> ".PHP_EOL.json_encode($ammojd,JSON_PRETTY_PRINT).PHP_EOL.PHP_EOL;

			$einfo[".Ammo.|*|*|*|".$ammojd["Category"]."|.AmmoCount"]=$einfo[".Ammo.|*|*|*|".$ammojd["Category"]."|.AmmoCount"]+$componentjd["Capacity"];

			if($ammojd["AOECapable"]){
				$einfo["Weapon.|*|*|*|".$ammojd["Category"]."|.AOECapable"]=1;
				if(DUMP::$info)
					echo "EINFO[."."Weapon.|*|*|*|".$ammojd["Category"]."|.AOECapable] = 1".PHP_EOL;
			}
			
			if($ammojd["IndirectFireCapable"]){
				$einfo["Weapon.|*|*|*|".$ammojd["Category"]."|.IndirectFireCapable"]=1;
				if(DUMP::$info)
					echo "EINFO[."."Weapon.|*|*|*|".$ammojd["Category"]."|.IndirectFireCapable]= 1".PHP_EOL;
			}

			if($ammojd["statusEffects"] ){
				$ammoeffectsarray=array();
				foreach($ammojd["statusEffects"]  as $effectjd){
					$force_activated=true;//weapons have to be fired
					Dump::gatherEquipmentEffectInfo($ammoid,$location,$effectjd,$einfo,$ammoeffectsarray/* defensively prevent modification of $effects*/,$force_activated,$ammoeffectsarray,$ammojd["Category"]);
				}
				$ammoeffects[]=$ammoeffectsarray; //Group effects for same AMMO Bin
			}
			if(DUMP::$info)
			echo" <===========================|AMMO|".PHP_EOL;
		}
		if(DUMP::$info)
			echo" <===========================||".PHP_EOL;
	}
}

public static function gatherEquipmentEffectInfo($componentid,$location,$effectjd,&$einfo,&$effects,$force_activated=false,&$ammoeffectarray=null,$ammocategory=null){
	
	GLOBAL $stat2operation;
	if($effectjd["targetingData"] && 
		( $effectjd["targetingData"]["effectTargetType"]=="Creator" ||
		$effectjd["targetingData"]["effectTargetType"]=="AlliesWithinRange" ||
		$effectjd["targetingData"]["effectTargetType"]=="EnemiesWithinRange" ||
		($effectjd["targetingData"]["effectTriggerType"]=="OnHit")
		)
	)
	{
		
		$effect=null;
		$effectval=null;
		$operation=null;

		$activated=true;

		//$force_activated is cos CAE status effect have duration -1 but they are activateable
		if(!$force_activated && $effectjd[ "durationData"] && $effectjd[ "durationData"]["duration"]<0)
			$activated=false;

		if($effectjd[ "statisticData"] && $effectjd[ "statisticData"]["operation"]){
			$effect=$effectjd[ "statisticData"]["statName"];
			if($effectjd["targetingData"]["effectTargetType"]=="AlliesWithinRange" ||
				$effectjd["targetingData"]["effectTargetType"]=="EnemiesWithinRange" )
			{
					$effect=$effectjd["targetingData"]["effectTargetType"]."_".$effect;
			}elseif($effectjd["targetingData"]["effectTriggerType"]=="OnHit" ){
				$effect=$effectjd["targetingData"]["effectTriggerType"]."_".$effect;
			}
			$operation=$effectjd[ "statisticData"]["operation"];
			switch ($operation) {
				case "Int_Add":
				case "Float_Add":
					$effectval = (float)$effectjd[ "statisticData"]["modValue"];
					break;
				case "Int_Subtract":
				case "Float_Subtract":
					$effectval = (float)$effectjd[ "statisticData"]["modValue"];
					break;
				case "Float_Multiply":
				case "Int_Multiply":
				case "Int_Multiply_Float":
					$effectval = (float)$effectjd[ "statisticData"]["modValue"];
					break;
				case "Set":
				    if ($effectjd[ "statisticData"]["modType"]=="System.Boolean") {
	                          if ($effectjd[ "statisticData"]["modValue"]=="true"){
								$effectval =1;
							  }else {
								$effectval =0;
                              }
                    }else if ($effectjd[ "statisticData"]["modType"]=="System.String") {
	                          	$effectval=$effectjd[ "statisticData"]["modValue"];
                    } 
				    break;
				default:
					if(DUMP::$debug){
						echo "[DEBUG] UNKNOWN OPERATION ".$operation.PHP_EOL;
						if(!$stat2operation[$effect]){
							$stat2operation[$effect]=array();
						}
						if(!in_array ($operation , $stat2operation[$effect] )){
							$stat2operation[$effect][]=$operation;
						}
					}
					break;
			}
			switch ($effectjd[ "statisticData"]["targetCollection"]) {
				case "Pilot":
				  $effect="Pilot.".$effect;
				  break;
				case "Weapon":
				  $class=
				  "|".( (!$effectjd[ "statisticData"]["targetWeaponCategory"] || $effectjd[ "statisticData"]["targetWeaponCategory"]=="NotSet") ? "*" :$effectjd[ "statisticData"]["targetWeaponCategory"]).
				  "|".( (!$effectjd[ "statisticData"]["targetWeaponType"] || $effectjd[ "statisticData"]["targetWeaponType"]=="NotSet") ? "*" :$effectjd[ "statisticData"]["targetWeaponType"]).
				  "|".( (!$effectjd[ "statisticData"]["targetWeaponSubType"] || $effectjd[ "statisticData"]["targetWeaponSubType"]=="NotSet") ? "*" :$effectjd[ "statisticData"]["targetWeaponSubType"]).
				  "|".( (!$effectjd[ "statisticData"]["targetAmmoCategory"] || $effectjd[ "statisticData"]["targetAmmoCategory"]=="NotSet") ? "*" :$effectjd[ "statisticData"]["targetAmmoCategory"]).
				  "|.";
				  $effect="Weapon.".$class.$effect;
				  $activated=true;//weapons have to be fired so always treat effect as activated.
				  break;
				default:
					/*if(DUMP::$debug)
						echo "[DEBUG]  targetCollection ".$effectjd[ "statisticData"]["targetCollection"]." >>".$effect.$activated=true;."( $componentid )".PHP_EOL;*/
					break;
			}
			if($ammocategory){
				  $class=
				  "|*".
				  "|*".
				  "|*".
				  "|".$ammocategory.
				  "|.";
				  $effect="Ammo.".$class.$effect;
				  $activated=true;//weapons have to be fired so always treat effect as activated.
			}
			if($effectjd["targetingData"] && $effectjd["targetingData"]["effectTriggerType"]=="OnHit" ){
				$effect=".Enemy.".$effect;
			}
		}
		if($effect!==null && $effectval!==null){
			if(DUMP::$debug){
				if(!$stat2operation[$effect]){
					$stat2operation[$effect]=array();
				}
				if(!in_array ( $effectjd[ "statisticData"]["operation"] , $stat2operation[$effect] )){
					$stat2operation[$effect][]=$operation;
				}
				if(!$stat2operation[$effect." from"]){
					$stat2operation[$effect." from"]=array();
				}
				if(!in_array ( $componentid , $stat2operation[$effect." from"] )){
					$stat2operation[$effect." from"][]=$componentid;
				}
			}
			$effect=str_replace("{location}",$location,$effect);
			if($ammocategory){
				if(!$ammoeffectarray[$effect])
					$ammoeffectarray[$effect]=array();
				$stackeffect=array(
				 'operation'=>$operation,
				 'modValue' =>$effectval,
				 'activated'=>$activated,
				 'from'=>$componentid
				);
				$ammoeffectarray[$effect][]=$stackeffect;
				if(DUMP::$info)
					echo "AMMOEFFECTS[ $effect] : ".json_encode($stackeffect).PHP_EOL;
			}else{
				if(!$effects[$effect])
					$effects[$effect]=array();
				$stackeffect=array(
				 'operation'=>$operation,
				 'modValue' =>$effectval,
				 'activated'=>$activated,
				 'from'=>$componentid
				);
				$effects[$effect][]=$stackeffect;
				if(DUMP::$info)
					echo "EFFECTS[ $effect] : ".json_encode($stackeffect).PHP_EOL;
			}
		}

	}
}
}

Dump::main();
 
?>