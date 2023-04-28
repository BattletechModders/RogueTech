<?php
include ".\php\common.php";

class RemoveTag extends Config{
   public static function main(){
    RemoveTag::init();
	RemoveTag::RemoveTags();
   }

   public static function init(){
   }

    public static function RemoveTags(){
		GLOBAL $ai_tags;
		$writecount=0;
		$file = fopen('./Output/mechaitags.csv', 'r');
		while (($line = fgetcsv($file)) !== FALSE) {
			if(!startswith($line[0],"#"))
			{
				$newtags=array();
				$oldtags=array();
				$mech=$line[0];
				$path=RemoveTag::$RT_Mods_dir.$line[1];
				for ($x = 0; $x < count($ai_tags); $x++) {
					$tval=$line[2+count($ai_tags)+$x];
					if($tval=="low" || $tval=="normal" || $tval=="high")
								$newtags[]=$ai_tags[$x]."_".$tval;
				}

				$mechjd=RemoveTag::parseJSONFile($path);
				$tag_items=$mechjd["MechTags"]["items"];
				foreach($mechjd["MechTags"]["items"] as $tag){
					for ($x = 0; $x < count($ai_tags); $x++) {
						if(startswith($tag,$ai_tags[$x])){
							$tag_items = array_diff($tag_items, array($tag));
							$oldtags[]=$tag;
						}
					}
				}

				$should_write=true;//count(array_diff ( $newtags , $oldtags ))+count(array_diff ( $oldtags,$newtags ));
				$write_tags=array_values(array_diff($tag_items, $oldtags));
				if(RemoveTag::$debug_single_mech && RemoveTag::$debug_single_mech==$mech)
				{
					echo "$mech =>".PHP_EOL."New Tags:".json_encode($newtags,JSON_PRETTY_PRINT).PHP_EOL."Old Tags:".json_encode($oldtags,JSON_PRETTY_PRINT).PHP_EOL;
					echo $should_write ? "Writing".PHP_EOL : "Skipped (Up to date)".PHP_EOL;
					echo $should_write ? "Cleaned Tags:".json_encode($tag_items,JSON_PRETTY_PRINT).PHP_EOL:"";
					echo $should_write ? "Generated Tags:".json_encode($write_tags,JSON_PRETTY_PRINT).PHP_EOL:"";
				}
				if($should_write){
					$mechjd["MechTags"]["items"]=$write_tags;
					$json=json_encode_rt($mechjd);
					if(endswith(file_get_contents($path),PHP_EOL)){
					  $json=$json.PHP_EOL;//preserve spurious ending newlines
					 }
					$fp = fopen($path, 'wb');
					fputs($fp,$json);
					fclose($fp);
					$writecount++;
				}
				
			}
		}
		
		fclose($file);
		echo "Removed Role Player Tags in /Rewrote  $writecount files.".PHP_EOL;
	}

	public static function parseJSONFile($f){
	$json = file_get_contents($f);

		$json=preg_replace('/\,\s+\}/', '}',$json);
		$json=preg_replace('/\,\s+\]/', ']',$json);
		// search and remove comments like /* */ and //
	    $json = preg_replace("#(/\*([^*]|[\r\n]|(\*+([^*/]|[\r\n])))*\*+/)|([\s\t]//.*)|(^//.*)#", '', $json);
		//$json = preg_replace('/[[:^print:]]/', '', $json);//breaks smart quotes,think they are non printable

		$jd=json_decode($json, TRUE,512,JSON_INVALID_UTF8_IGNORE);

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
}

RemoveTag::main();
 
?>