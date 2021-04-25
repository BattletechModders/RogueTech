<?php
include ".\php\common.php";

class WriteTag extends Config{
   public static function main(){
    WriteTag::init();
	WriteTag::writeTags();
   }

   public static function init(){
   }

    public static function writeTags(){
		GLOBAL $ai_tags;
		$writecount=0;
		$file = fopen('./Output/mechaitags.csv', 'r');
		while (($line = fgetcsv($file)) !== FALSE) {
			if(!startswith($line[0],"#"))
			{
				$newtags=array();
				$oldtags=array();
				$mech=$line[0];
				$path=WriteTag::$RT_Mods_dir.$line[1];
				for ($x = 0; $x < count($ai_tags); $x++) {
					$tval=$line[2+count($ai_tags)+$x];
					if($tval=="low" || $tval=="normal" || $tval=="high")
								$newtags[]=$ai_tags[$x]."_".$tval;
				}

				$mechjd=WriteTag::parseJSONFile($path);
				$tag_items=$mechjd["MechTags"]["items"];
				foreach($mechjd["MechTags"]["items"] as $tag){
					for ($x = 0; $x < count($ai_tags); $x++) {
						if(startswith($tag,$ai_tags[$x])){
							$tag_items = array_diff($tag_items, array($tag));
							$oldtags[]=$tag;
						}
					}
				}

				$should_write=count(array_diff ( $newtags , $oldtags ))+count(array_diff ( $oldtags,$newtags ));
				$write_tags=array_merge($tag_items, $newtags);
				if(WriteTag::$debug_single_mech && WriteTag::$debug_single_mech==$mech)
				{
					echo "$mech =>".PHP_EOL."New Tags:".json_encode($newtags,JSON_PRETTY_PRINT).PHP_EOL."Old Tags:".json_encode($oldtags,JSON_PRETTY_PRINT).PHP_EOL;
					echo $should_write ? "Writing".PHP_EOL : "Skipped (Up to date)".PHP_EOL;
					echo $should_write ? "Cleaned Tags:".json_encode($tag_items,JSON_PRETTY_PRINT).PHP_EOL:"";
					echo $should_write ? "Generated Tags:".json_encode($write_tags,JSON_PRETTY_PRINT).PHP_EOL:"";
				}
				if($should_write){
					$mechjd["MechTags"]["items"]=$write_tags;
					$fp = fopen($path, 'wb');
					fputs($fp,json_encode($mechjd,JSON_PRETTY_PRINT));
					fclose($fp);
					$writecount++;
				}
				
			}
		}
		
		fclose($file);
		echo "Updated Role Player Tags in $writecount files.".PHP_EOL;
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
}

WriteTag::main();
 
?>