<?php
function find($find, $in){
	$r = strpos($in, $find);
	if($r === false){
		return -1;
	}else{
		return $r;
	}
}
?>