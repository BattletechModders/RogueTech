<?php
include ".\php\common.php";
 
class DumpStats extends Config{
   public static function main(){
    DumpStats::init();
	DumpStats::processStats();
	//and dump what we need to csv
	DumpStats::dump();
   }

   public static function init(){
	   GLOBAL $data_collect,$csv_min_stat,$csv_max_stat;
	   for ($x = $csv_min_stat; $x <= $csv_max_stat; $x++) {
			$data_collect[$x]=array();
	   }
   }

     public static function processStats(){
	   GLOBAL $csv_header,$stat_min,$stat_max,$stat_avg,$stat_stddev_lt,$stat_stddev_gt,$data_collect,$csv_min_stat,$csv_max_stat,$csv_header,$ai_tags,$ai_tags_calc,$ai_tags_weights,$ai_tags_reverserating,$stats_ignore_zeros;
	   if($csv_header[$csv_max_stat+1]!="Equipment")
	   {
		echo "ERROR:Stat Count is broken ";
		exit;
	   }
	   $file = fopen('./Output/mechs.csv', 'r');
		while (($line = fgetcsv($file)) !== FALSE) {
		   if(!startswith($line[0],"#"))
		   {
			   for ($x = $csv_min_stat; $x <= $csv_max_stat; $x++) {
					$data_collect[$x][]=(float)$line[$x];
			   }	
			}
		}
		fclose($file);
		for ($x = $csv_min_stat; $x <= $csv_max_stat; $x++) {
				$data=$data_collect[$x];
				//echo json_encode($stats_ignore_zeros)."<>".$x.PHP_EOL;
				$ignore_zeros=in_array ($x , $stats_ignore_zeros );
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
				//echo str_pad ( $csv_header[$x],25)." STD DEV LOW | ".str_pad ( number_format($stat_stddev_lt[$x],2),8)." | STD DEV UPR | ".str_pad ( number_format($stat_stddev_gt[$x],2),8)." | ".PHP_EOL;
				if(DumpStats::$debug_single_mech || DumpStats::$info || count(DumpStats::$debug_mechs_ai_tag)>0)
					echo str_pad ( $csv_header[$x],25)." MIN: ".str_pad ( $stat_min[$x],8)."  | ".str_pad ( number_format($avg-$stat_stddev_lt[$x],2),8)." < ".str_pad ( number_format($stat_avg[$x],2),8)." (AVG)> ".str_pad ( number_format($avg+$stat_stddev_gt[$x],2),8)." | MAX: ".str_pad ( $stat_max[$x],8)." N=".count($data).PHP_EOL;
		}	
		$file = fopen('./Output/mechs.csv', 'r');
		$fp = fopen('./Output/mechratings.csv', 'wb');
		$csv_header_r=array();
		$csv_header_r=$csv_header_r+ $csv_header;
		for($x=0; $x<count($ai_tags); $x++){
			$csv_header_r[]=$ai_tags[$x]." Value";
		}
		fputcsv($fp, $csv_header_r);
		while (($line = fgetcsv($file)) !== FALSE) {
		   if(startswith($line[0],"#"))
				continue;
			
			if(DumpStats::$debug_single_mech){
				if($line[0]==DumpStats::$debug_single_mech)
					DumpStats::$info=TRUE;
				else
					DumpStats::$info=FALSE;
			}

			$dump=$line;
			for ($x = $csv_min_stat; $x <= $csv_max_stat; $x++) {
					$data=(float)$line[$x];
					$avg=$stat_avg[$x];
					$max=$stat_max[$x];
					$min=$stat_min[$x];
					$maxsd=$avg+$stat_stddev_gt[$x];;
					if($maxsd>$max)
					  $maxsd=$max;
					$minsd=$avg-$stat_stddev_lt[$x];
					if($minsd<$min)
					  $minsd=$min;
					//when ignoring zeros $min can be greater than 0;
					if($data<$min)
						$data=$min;
					//normalize all stats to 0-1 scale <0.2 & >0.8 are for statistical outliers <= & => avg+/-standard deviation
					if($data<=$minsd){
					  if($minsd==$min)
						$dump[$x]=0;
					  else 
	                    $dump[$x]=($data-$min)/($minsd-$min)*0.2;
					}else if($data>$minsd && $data<=$avg){
	                    $dump[$x]=0.2+(($data-$minsd)/($avg-$minsd)*0.3);
					}else if($data>=$avg && $data<$maxsd){
	                    $dump[$x]=0.5+(($data-$avg)/($maxsd-$avg)*0.3);
					}else if($data>=$maxsd){
					  if($maxsd==$max)
						$dump[$x]=1;
					  else 
	                    $dump[$x]=0.8+(($data-$maxsd)/($max-$maxsd)*0.2);
					}

			}	
			for ($x = 0; $x < count($ai_tags); $x++) {
				$t=0;
				for ($y = 0; $y < count($ai_tags_calc[$x]); $y++) {
					$w=$ai_tags_weights[$x][$y];
					$value=$dump[$ai_tags_calc[$x][$y]];
					//The are scenarios in which extreme values need to be seperated from the avg
					//for eg avg speed rating is .5 , we want this to be treated as 1 and mechs with extreme low/high speed to be treated as 0
					//(reversal over this is still possible)
					//we flag this by using a negative weight
					if($w<0){
						//echo "{RA} $w $value =>";
						$w=$w*-1;
						$value=1-abs(1-($value*2));
						//echo " $w $value".PHP_EOL;
					}
					$rating=$value*$w;
					if($ai_tags_reverserating[$x][$y]){
						$rating=(1*$w)-$rating;
					}
					$t+=$rating;
				}
				$dump[]=$t;
			}
			if(DumpStats::$info)
				echo implode(",", $dump) . PHP_EOL;
			fputcsv($fp, $dump);
		}

		fclose($file);
		fclose($fp);
   }

   public static function dump(){
   }

}

DumpStats::main();
 
?>