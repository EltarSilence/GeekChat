<?php
$bt = debug_backtrace();
$dir = "";
if(sizeof($bt) > 0){
	$bt = $bt[0]['file'];
	if(dirname(__FILE__) != dirname($bt)){
		$dir = dirname(find_relative_path($bt, __FILE__));
	}else{
		$dir = dirname(__FILE__);
	}
}else{
	$dir = dirname(__FILE__);
}
$c = file_get_contents($dir.DIRECTORY_SEPARATOR."package.json");
$c = json_decode($c, true);
if(isset($c['require'])){
	Zrequire($dir, $c['require']);
}
function Zrequire($dir = "", $a){
	foreach($a as $k => $v){
		if(is_array($v)){
			Zrequire($dir.DIRECTORY_SEPARATOR.$k, $v);
		}else{
			require_once($dir.DIRECTORY_SEPARATOR.$v);
		}
	}
}

function find_relative_path($frompath, $topath ){
	$from = explode(DIRECTORY_SEPARATOR, $frompath); // Folders/File
	$to = explode(DIRECTORY_SEPARATOR, $topath); // Folders/File
	$relpath = '';
	$i = 0;
	// Find how far the path is the same
	while(isset($from[$i]) && isset($to[$i])){
		if($from[$i] != $to[$i])
			break;
		$i++;
	}
	$j = count( $from ) - 1;
	// Add '..' until the path is the same
	while($i + 1 <= $j ){
		if(!empty($from[$j]))
			$relpath .= '..'.DIRECTORY_SEPARATOR;
		$j--;
	}
	// Go to folder from where it starts differing
	while(isset($to[$i])){
		if(!empty($to[$i]))
			$relpath .= $to[$i].DIRECTORY_SEPARATOR;
		$i++;
	}
	// Strip last separator
	return substr($relpath, 0, -1);
}

?>
