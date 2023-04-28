<?php
include ".\php\common.php";
/* 
1000-ft view of how it works.
Measure over a 100 mech characteristics.
Rate these on characteristics on 0-1 scale.
Calculate a value for each ai tag based on some set of previous characteristics.
Covert the values to 0-1 scale. Give outliers low/high tags, and the rest normal.
Tagging attempts to ask the questions CAN the mech do X? SHOULD the the mech do X? WHY would the mech do X?

Notes
Dump dumps the mech characteristics
DumpStats compares mechs against each other.
AItags translates the stats into actionable ai info i.e. tags

stats are rated.
Rating {R} [0-1]. Based on the max/min/average/standard deviation of a stat.
{RA} is a rating scheme where average numbers are scored 1 and outliers in BOTH directions are scored toward zero - for scenarios in which extreme values need to be seperated from the avg
Boolean false / true based on if a mech has a characteristic , are also converted to rating {R} [0/1]. 

For each AI tag determine a value between [0-1] . Each AI tag, is grouped into low(<.2), normal (.2-.8) , high > .8 

*1. Heat: how it handles heat
RTDumper understands CASE , AmmoExplosions , Volatile AmmoExplosions , AMS Heat , heat damage injury, heat activated components, heat efficency.
Heat Efficency is just spare heat dissipation after alpha strike expressed as % (+/-) over overheat level

tag based on:
{R Max Ammo Explosion damage}  {R Max Volatile Ammo Explosion damage}  {R "AMS Single Heat"}  {R "AMS Multi Heat" }  {R Heat Damage Injury} {R Heat Efficency } {R Auto Activation Heat}

low - avoids overheating, has volatile ammo 
normal - will run hot but be carefull, basically most mechs
high - will ride the redline hard, for units like the nova 

Desired AI Behaviour:
* low: Turn OFF AMS,heat generating components when redlined. Avoid overheating.
* normal/high: switch ON AMS Overload if available. Switch ON heat generating components (Hotseat cockpit/Vibro blade etc).
* high: run near the readline, use alpha strike even if it can't dissipate heat. Overheat. Turn of injury causing components before alpha strike.


*2 dfa: likelyhood to dfa
RTDumper understands DFA damage / self damage , leg armour & structure repair ,DFA buffing equipment
//DFA Self Damage Efficency is how many a DFAs a mech can perform before both its legs break
//DFA Damage Efficency is DFA damage per mech tonnage
//DFA Self Instability Efficency is Self UnsteadyThreshold remaining after DFA expressed as % of UnsteadyThreshold

tag based on:
{R DFA Self Damage Efficency}  {R DFA Damage Efficency} {R DFA Self Instability Efficency} {R DFA Target Damage} {R DFA Target Instability}

low - avoids DFA at all cost
normal - may dfa when reasonable
high - has dfa buffing gear and wants to jump in their face

Desired AI Behaviour:
*low: avoid DFA, However may DFA light targets only. Other targets would cause severe leg damage- due to CBTBE 'Settings' (['Melee']['DFA']['AttackerDamagePerTargetTon'])
*normal: DFA if better than weapon attack / high weapon heat / No line of sight / poor weapon too hit
*high: DFA whenever possible

*3 melee: melee damage behaviour
RTDumper understands Kick , Punch , Physical damage
Currently ignoring charge as it will ?ALWAYS? result in instability
//Melee Damage Efficency is Max(Kick,Punch,Physical)Melee damage per mech tonnage

tag based on:
{R KickDamage}{R PhysicalWeaponDamage}{R PunchDamage} {R Melee Damage Efficency}

low - has little to no melee damage or equipment and avoid it
normal - can punch if it needs to
high - has melee equipment and wants to get close


*4 flank:  flanking behaviour
Try to understand if the mech is flank capable - basically speed 
Bonus if the mech is good at stuff to do when flanked. Active ECM ,Enemy Debuffs, Melee , DFA , TAG , NARC , Single Hit Damage , Single Hit Instability
avoids flank if aoe/indirect fire capable

tag based on:
{R Max Run activated} 
	( {R KickDamage}{R PhysicalWeaponDamage}{R PunchDamage} {R Melee Damage Efficency} ) 
	( {R DFA Self Damage Efficency}  {R DFA Damage Efficency} {R DFA Self Instability Efficency} {R DFA Target Damage} {R DFA Target Instability} )
	( {R .Enemy.OnHit_LV_NARC_signatureMod} {R .Enemy.OnHit_LV_NARC_detailsMod} {R.Enemy.OnHit_LV_NARC_attackMod} )
	( {R .Enemy.OnHit_LV_TAG_signatureMod} {R .Enemy.OnHit_LV_TAG_detailsMod} {R .Enemy.OnHit_LV_TAG_attackMod} )
	( {R Weapons Best Single Hit Damage} {R Weapons Best Single Hit Instability} )
	( {R EnemiesWithinRange_LV_ECM_JAMMED} {R EnemiesWithinRange_LV_PROBE_PING } {R EnemiesWithinRange_LV_ECM_SHIELD} )
	( {R EnemiesWithinRange_SensorSignatureModifier} {R EnemiesWithinRange_SpottingVisibilityMultiplier} {R EnemiesWithinRange_MoraleBonusGain} {R EnemiesWithinRange_BaseInitiative} {R EnemiesWithinRange_PanicStatModifier} )
	( {R AOECapable} {R IndirectFireCapable} )

low - little to no desire to attempt flanking
normal - will try to backstab but not overly
high - will want to run into their backs often

Desired AI Behaviour
Use Walk/Run bonus equipment

*5 lance: 
Try to understand if the mech is better of hanging back or charging forward
	i.e. (Can debuff enemies,weapon optimal ranges are either extreme, aoe OR indirect fire capable, walk/run speeds are either extreme)
Stick together if walk/run is nearer avg and optimum range is nearer avg or has variety of optimum ranges , can buff allies

{RA Max Walk activated} {RA Max Run activated} {R Max Walk activated} {R Max Run activated} 
	( {RA Weapons Overall Optimum Range} {R Weapons Optimum Range Std Dev} {R Damage percent at Optimum Range} )
	( {R  AlliesWithinRange_LV_ECM_JAMMED} {R AlliesWithinRange_LV_ECM_SHIELD} {R AlliesWithinRange_SensorDistanceAbsolute} {R AlliesWithinRange_SpotterDistanceAbsolute} )
	( {R EnemiesWithinRange_LV_ECM_JAMMED} {R EnemiesWithinRange_LV_PROBE_PING } {R EnemiesWithinRange_LV_ECM_SHIELD} )
	( {R EnemiesWithinRange_SensorSignatureModifier} {R EnemiesWithinRange_SpottingVisibilityMultiplier} {R EnemiesWithinRange_MoraleBonusGain} {R EnemiesWithinRange_BaseInitiative} {R EnemiesWithinRange_PanicStatModifier} )
	( {R AOECapable} {R IndirectFireCapable} )
	( {R .Enemy.OnHit_LV_NARC_signatureMod} {R .Enemy.OnHit_LV_NARC_detailsMod} {R.Enemy.OnHit_LV_NARC_attackMod} )
	( {R .Enemy.OnHit_LV_TAG_signatureMod} {R .Enemy.OnHit_LV_TAG_detailsMod} {R .Enemy.OnHit_LV_TAG_attackMod} )
	( {R AMS Multi Heat} )

low - does not care to be near friends
normal - tries to keep lance coherent
high - has buffing gear like ews or c3 and wants to hug buddies

Desired AI behaviours:
normal /high should switch AMS to overload
use walk/run bonus equip

*6 lethal self:

avoiding damage behaviour
{R Armor} {R Armor per ton} {R Tons} {R Heat Damage Injury}
	( {R AMS Single Heat} {R AMS Multi Heat} )
	( {R Max Evasive Pips} {R CACAPProtection} )
    ( {R DamageReductionMultiplierAll} {R DamageReductionMultiplierBallistic} {R DamageReductionMultiplierMissile} {R DamageReductionMultiplierEnergy} {R DamageReductionMultiplierMelee} )
	( {R DFA Self Damage Efficency}  {R DFA Damage Efficency} {R DFA Self Instability Efficency} {R DFA Target Damage} {R DFA Target Instability} )
	( {R KickDamage}{R PhysicalWeaponDamage}{R PunchDamage} {R Melee Damage Efficency} )
	( {R Weapons Overall Optimum Range} {R Weapons Optimum Range Std Dev} {R Damage percent at Optimum Range} )
	( {R AOECapable} {R IndirectFireCapable} )
	( {R LV_ECM_SHIELD} {R LV_ECM_JAMMED} )
	( {R LV_STEALTH_signature_modifier} {R LV_STEALTH_details_modifier} {R LV_STEALTH_mediumAttackMod} {R LV_STEALTH_longAttackmod} {R LV_STEALTH_extremeAttackMod} )
    ( {R LV_MIMETIC_maxCharges} {R LV_MIMETIC_visibilityModPerCharge} {R LV_MIMETIC_attackModPerCharge} {R LV_MIMETIC_hexesUntilDecay } )
	( {R Repair Armor} )
low - does care little for damage it may receive, for units with hardened other pure tanks
normal - will try to avoid incoming fire and enemy damage
high - will try to stay back and fire only safe shots

Equipment:
Long Range Weapons
Below average armor
Indirect firing weapons

*7 movement:
how much it wants to run. Primarily based on speed. Don't decay mimetic. High Speed Ally buffers may need to slow down to stay cohesive. NARC/TAG units may run to mark targets ASAP.
Slower units may run to keep up.

Tag based on.
{RA Max Walk activated} {RA Max Run activated} {R Max Walk activated} {R Max Run activated} 
	( {R Max Evasive Pips} )
    ( {R LV_MIMETIC_maxCharges} {R LV_MIMETIC_visibilityModPerCharge} {R LV_MIMETIC_attackModPerCharge} {R LV_MIMETIC_hexesUntilDecay } )
	( {R KickDamage}{R PhysicalWeaponDamage}{R PunchDamage} {R Melee Damage Efficency} ) 
	( {R DFA Self Damage Efficency}  {R DFA Damage Efficency} {R DFA Self Instability Efficency} {R DFA Target Damage} {R DFA Target Instability} )
	( {R .Enemy.OnHit_LV_NARC_signatureMod} {R .Enemy.OnHit_LV_NARC_detailsMod} {R.Enemy.OnHit_LV_NARC_attackMod} )
	( {R .Enemy.OnHit_LV_TAG_signatureMod} {R .Enemy.OnHit_LV_TAG_detailsMod} {R .Enemy.OnHit_LV_TAG_attackMod} )
	( {R  AlliesWithinRange_LV_ECM_JAMMED} {R AlliesWithinRange_LV_ECM_SHIELD} {R AlliesWithinRange_SensorDistanceAbsolute} {R AlliesWithinRange_SpotterDistanceAbsolute} )    ( {R Weapons Overall Optimum Range} {R Weapons Optimum Range Std Dev} {R Damage percent at Optimum Range} )

low - slower units, not much desire to sprint a lot and stay more stable
normal - moderate desire to move and shoot
high - wants to run as much as possible

*8 priority: desire to stay on target
Note:currently have melee / dfa mechs spreading the chaos, rather than focusing on priority target , revisit if needed.
Tag based on.
( {R Weapons Best Single Hit Damage} {R Weapons Best Single Hit Instability} )
( {RA Weapons Overall Optimum Range} {R Weapons Overall Optimum Range} {R Weapons Optimum Range Std Dev} {R Damage percent at Optimum Range} )
( {R AOECapable} {R IndirectFireCapable} )
( {R Weapons Damage Weighted APCriticalChanceMultiplier} )
( {R KickDamage}{R PhysicalWeaponDamage}{R PunchDamage} {R Melee Damage Efficency} ) 
( {R DFA Self Damage Efficency}  {R DFA Damage Efficency} {R DFA Self Instability Efficency} {R DFA Target Damage} {R DFA Target Instability} )
( {R .Enemy.OnHit_LV_NARC_signatureMod} {R .Enemy.OnHit_LV_NARC_detailsMod} {R.Enemy.OnHit_LV_NARC_attackMod} )
( {R .Enemy.OnHit_LV_TAG_signatureMod} {R .Enemy.OnHit_LV_TAG_detailsMod} {R .Enemy.OnHit_LV_TAG_attackMod} )

low - willing to distribute fire and deal damage to various targets
normal - will try to stay on target but react to threats
high - will try to kill their priority target at all costs

*9 reserve: willingness to reserve
Tag based on.
( {R Max Run activated} )
( {R AOECapable} {R IndirectFireCapable} )
( {R .Enemy.OnHit_LV_NARC_signatureMod} {R .Enemy.OnHit_LV_NARC_detailsMod} {R.Enemy.OnHit_LV_NARC_attackMod} )
( {R .Enemy.OnHit_LV_TAG_signatureMod} {R .Enemy.OnHit_LV_TAG_detailsMod} {R .Enemy.OnHit_LV_TAG_attackMod} )
( {R  AlliesWithinRange_LV_ECM_JAMMED} {R AlliesWithinRange_LV_ECM_SHIELD} {R AlliesWithinRange_SensorDistanceAbsolute} {R AlliesWithinRange_SpotterDistanceAbsolute} )
( {R EnemiesWithinRange_LV_ECM_JAMMED} {R EnemiesWithinRange_LV_PROBE_PING } {R EnemiesWithinRange_LV_ECM_SHIELD} )
( {R EnemiesWithinRange_SensorSignatureModifier} {R EnemiesWithinRange_SpottingVisibilityMultiplier} {R EnemiesWithinRange_MoraleBonusGain} {R EnemiesWithinRange_BaseInitiative} {R EnemiesWithinRange_PanicStatModifier} )
( {R Weapons Best Single Hit Damage} {R Weapons Best Single Hit Instability} )
( {R Weapons Overall Optimum Range} {R Weapons Optimum Range Std Dev} {R Damage percent at Optimum Range} )
( { R Weapons Total Damage} )
( {R KickDamage}{R PhysicalWeaponDamage}{R PunchDamage} {R Melee Damage Efficency} ) 
( {R DFA Self Damage Efficency}  {R DFA Damage Efficency} {R DFA Self Instability Efficency} {R DFA Target Damage} {R DFA Target Instability} )

low - will not reserve and prefer to always do something (eg scouts)
normal - will only reserve if nothing else presents itself
high - attempt to reserve and get the last move in

Equipment:
PRobes and active ECM as well as basic c3 wants to always sniff around
Heavy hitters willing to wait
Missile boats indifferent

*10 shooting: 
Ammo heavy loadouts wants to take good shots only, exception is ammo for more then 20 turns
Energy only loadouts are willing to take every potshot they
Longer range with low ammo loadout will conserve more than Shorter range with low loadouts.

Tag based on.
( {R Weapons Overall Optimum Range} {R Weapons Optimum Range Std Dev} {R Damage percent at Optimum Range} )
( {R Nth Turn Total Damage} {R Nth Turn Damage available} )
( {R Nth Turn Optimum Range Damage} {R Nth Turn Damage percent at Optimum Range} {R Turn Out Of optimum Range Ammo} )

low - will try to take any shot it can even with bad accuracy
normal - will try to conserve fire
high - will attempt to only get really good shots

*11 surrounded:
Below average armor and long ranges wants to stay out of enemy firing lines as much as possible
Heavy armors like hardened or lamellor (damage reducing stats) is more willing to stay near enemys

Tag based on:
{R Armor} {R Armor per ton} {R Tons}
	( {R Repair Armor} )
	( {R CACAPProtection} )
    ( {R DamageReductionMultiplierAll} {R DamageReductionMultiplierBallistic} {R DamageReductionMultiplierMissile} {R DamageReductionMultiplierEnergy} {R DamageReductionMultiplierMelee} )
	( {R "AMS Single Heat"}  {R "AMS Multi Heat" })
	( {R Weapons Overall Optimum Range} {R Weapons Optimum Range Std Dev} {R Damage percent at Optimum Range} )
	( {R AOECapable} {R IndirectFireCapable} )
low - does not care about being surrounded and will not avoid it
normal - will try to not get surrounded
high - will want to stay away from enemys as much as possible (eg lrm boats)

*/

class AITag extends Config{
   public static function main(){
    AITag::init();
	AITag::processStats();
	//and dump what we need to csv
	AITag::dump();
   }

   public static function init(){
	   GLOBAL $data_collect,$csv_min_stat,$csv_max_stat,$ai_tags,$ai_tags_calc,$ai_tags_weights,$ai_tags_reverserating,$csv_header;
	   for ($x = 0; $x < count($ai_tags); $x++) {
			$data_collect[$x]=array();
	   }
	   for ($x = 0; $x < count($ai_tags); $x++) {
	   			$s="TAGGER: ".$ai_tags[$x]." : ".PHP_EOL ;

			   for ($i = 0; $i <  count($ai_tags_weights[$x]); $i++) {
					$s.="{ R".(($ai_tags_weights[$x][$i]<0) ? "A":"")." ".$csv_header[$ai_tags_calc[$x][$i]]." ".(($ai_tags_reverserating[$x][$i]) ? "\/":" ^")." (x".abs($ai_tags_weights[$x][$i]).")}\t";
			   }
			   $s.=	PHP_EOL.PHP_EOL;
				if(AITag::$debug || (AITag::$debug_mechs_ai_tag &&
				( in_array ($ai_tags[$x], AITag::$debug_mechs_ai_tag ) )) ){
					echo $s;
				}  
	   }
   }

     public static function processStats(){
	   GLOBAL $csv_header,$stat_min,$stat_max,$stat_avg,$stat_stddev_lt,$stat_stddev_gt,$data_collect,$csv_min_stat,$csv_max_stat,$csv_header,$ai_tags,$ai_tags_calc,$ai_tags_weights,$ai_tags_ignore_zeros,$ai_tags_skew;
	   $file = fopen('./Output/mechratings.csv', 'r');
		while (($line = fgetcsv($file)) !== FALSE) {
		   if(!startswith($line[0],"#"))
		   {
			   for ($x = 0; $x < count($ai_tags); $x++) {
					$data_collect[$x][]=(float)$line[count($csv_header)+$x];
			   }
			}
		}
		fclose($file);
		for ($x = 0; $x < count($ai_tags); $x++) {
				$data=$data_collect[$x];
				//echo json_encode($stats_ignore_zeros)."<>".$x.PHP_EOL;
				$ignore_zeros=in_array ($ai_tags[$x] , $ai_tags_ignore_zeros );
				if($ignore_zeros){
					$data=array_filter($data, function($a) { return ($a != 0); });
					//echo json_encode($data).PHP_EOL;
				}
				$stat_min[$x]=min($data);
				$stat_max[$x]=max($data);
				$stat_avg[$x]=(array_sum($data) / count($data));
				$avg=$stat_avg[$x];
				$stat_stddev_lt[$x]=sd(array_filter($data, function($a)  use ($avg){ return ($a <=$avg); }),$stat_avg[$x]);
				$stat_stddev_gt[$x]=sd(array_filter($data, function($a)  use ($avg){ return ($a >=$avg); }),$stat_avg[$x]);

				$display_ai_tag=str_pad ( $ai_tags[$x],15);
				if(AITag::$debug_mechs_ai_tag){
					 if( in_array ($ai_tags[$x], AITag::$debug_mechs_ai_tag ))
						$display_ai_tag="\e[1;33;40m".$display_ai_tag."\e[0m";
				}
				if(AITag::$debug_single_mech || AITag::$info || count(AITag::$debug_mechs_ai_tag)>0)
					echo $display_ai_tag." MIN: ".str_pad ( $stat_min[$x],8)."  | ".str_pad ( number_format($avg-$stat_stddev_lt[$x],2),8)." < ".str_pad ( number_format($stat_avg[$x],2),8)." (AVG)> ".str_pad ( number_format($avg+$stat_stddev_gt[$x],2),8)." | MAX: ".str_pad ( $stat_max[$x],8)." N=".count($data).PHP_EOL;
		}	
		$file = fopen('./Output/mechratings.csv', 'r');
		$fp = fopen('./Output/mechaitags.csv', 'wb');
		$csv_header_r=array();
		$csv_header_r[]=$csv_header[0];
		$csv_header_r[]=$csv_header[count($csv_header)-1];
		for($x=0; $x<count($ai_tags); $x++){
			$csv_header_r[]=$ai_tags[$x].' Rating';
		}
		for($x=0; $x<count($ai_tags); $x++){
			$csv_header_r[]=$ai_tags[$x];
		}
		fputcsv($fp, $csv_header_r);
		while (($line = fgetcsv($file)) !== FALSE) {
		   if(startswith($line[0],"#"))
				continue;

			if(AITag::$debug_mechs_ai_tag){
				if( in_array ($line[0] , AITag::$debug_mechs_ai_tag ) || (AITag::$debug_single_mech && $line[0]==AITag::$debug_single_mech) )
					AITag::$info=TRUE;
				else
					AITag::$info=FALSE;
			}else if(AITag::$debug_single_mech){
				if($line[0]==AITag::$debug_single_mech)
					AITag::$info=TRUE;
				else
					AITag::$info=FALSE;
			}
			
			if(AITag::$info){
				$log=array();
				$log[]=$line[0];
				for ($x = 0; $x < count($ai_tags); $x++) {
				 $s=$line[count($csv_header)+$x];
				 //https://joshtronic.com/2013/09/02/how-to-use-colors-in-command-line-output/
				 if( in_array ($ai_tags[$x], AITag::$debug_mechs_ai_tag ))
					$s="\e[0;36;40m".$s."\e[0m";
				 $log[]=$s;
				}
				echo implode(",", $log) . PHP_EOL;
			}

			$dump=array();
			$dump[]=$line[0];
			$dump[]=$line[count($csv_header)-1];
			for($x=0; $x<count($ai_tags); $x++){
				$dump[]=0;
				$dump[]=0;
			}
			for ($x = 0; $x < count($ai_tags); $x++) {
					$data=(float)$line[count($csv_header)+$x];
					$avg=$stat_avg[$x];
					$max=$stat_max[$x];
					$min=$stat_min[$x];
					$maxsd=$avg+$stat_stddev_gt[$x];
					if($maxsd>$max)
					  $maxsd=$max;
					$minsd=$avg-$stat_stddev_lt[$x];
					if($minsd<$min)
					  $minsd=$min;
					$ignore_zeros=in_array ($ai_tags[$x] , $ai_tags_ignore_zeros );
					$ignore_zeros=false;//LA wants dfa_low on mechs without JJ

					//normalize all stats to 0-1 scale <0.2 & >0.8 are for statistical outliers <= & => avg+/-standard deviation
					if($ignore_zeros && $data==0){
					   $dump[2+count($ai_tags)+$x]='';
					   $dump[2+$x]='';
					}else
					{
						if($data<=$minsd){
						  $dump[2+count($ai_tags)+$x]='low';
						  if($minsd==$min)
							$dump[2+$x]=0;
						  else 
							$dump[2+$x]=($data-$min)/($minsd-$min)*0.2;
						}else if($data>$minsd && $data<=$avg){
							$dump[2+count($ai_tags)+$x]='normal';
							$dump[2+$x]=0.2+(($data-$minsd)/($avg-$minsd)*0.3);
						}else if($data>=$avg && $data<$maxsd){
							$dump[2+count($ai_tags)+$x]='normal';
							$dump[2+$x]=0.5+(($data-$avg)/($maxsd-$avg)*0.3);
						}else if($data>=$maxsd){
						  $dump[2+count($ai_tags)+$x]='high';
						  if($maxsd==$max)
							$dump[2+$x]=1;
						  else 
							$dump[2+$x]=0.8+(($data-$maxsd)/($max-$maxsd)*0.2);
						}

						//skew
						$data=$dump[2+$x];
						$data+=$ai_tags_skew[$x];

						//skew can push it below [0-1]
						if($data<0)
							$data=0;
						if($data>1)
							$data=1;
					
						//echo $ai_tags[$x].":". "!!!! ".$dump[0]." >> ".$dump[2+$x]." -> ".$data.PHP_EOL;

						$dump[2+$x]=$data;//write back
						$stash=$dump[2+count($ai_tags)+$x];
						//retag adjusting for skew
						if($data<=0.2){
						  $dump[2+count($ai_tags)+$x]='low';
						}else if($data>0.2 && $data<0.8){
						  $dump[2+count($ai_tags)+$x]='normal';
						}else if($data>=0.8){
						  $dump[2+count($ai_tags)+$x]='high';
						}

						if(AITag::$info && $stash!=$dump[2+count($ai_tags)+$x])
							echo $ai_tags[$x].":". $dump[0]." >> skew moved ".$ai_tags[$x]." from $stash to ".$dump[2+count($ai_tags)+$x].PHP_EOL;
					
					}

			}	

			fputcsv($fp, $dump);
			if(AITag::$info){
				for ($x = 0; $x < count($ai_tags); $x++) {
					 //https://joshtronic.com/2013/09/02/how-to-use-colors-in-command-line-output/
					 if( in_array ($ai_tags[$x], AITag::$debug_mechs_ai_tag )){
						$dump[2+$x]="\e[1;36;40m".$dump[2+$x]."\e[0m";
						$c="\e[1;33;40m";
						if($dump[2+count($ai_tags)+$x]=='normal')
							$c="\e[1;37;40m";
						else if($dump[2+count($ai_tags)+$x]=='high')
							$c="\e[1;31;40m";
						$dump[2+count($ai_tags)+$x]=$c.$dump[2+count($ai_tags)+$x]."\e[0m";
					 }
				}
				echo implode(",", $dump) . PHP_EOL. PHP_EOL;
			}
		}

		fclose($file);
		fclose($fp);
   }

   public static function dump(){
   }

}

AITag::main();
 
?>