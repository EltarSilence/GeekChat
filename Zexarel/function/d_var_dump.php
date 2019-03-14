<?php

const NULL_COLOR = "rgb(0, 0, 0)";
const BOOLEAN_COLOR = "rgb(0, 0, 125)";
const DOUBLE_COLOR = "rgb(125, 0, 0)";
const INTEGER_COLOR = "rgb(200, 0, 0)";
const STRING_COLOR = "rgb(0, 125, 0)";
const OBJECT_COLOR = "rgb(255, 180, 180)";

function d_var_dump($arr, $size = null){
	echo '<pre style="font-size:'.(isset($size) ? $size : '17').'px">';
	_v($arr, "");
	echo "</pre>";
}
function _v($arr, $p){
	$t = gettype($arr);
	switch($t){
		case "NULL":
			echo '<span style="color:'.NULL_COLOR.'"><b>';
			echo "NULL</b></span>";
			break;
		case "boolean":
			echo '<span style="color:'.BOOLEAN_COLOR.'">';
			echo "Bool </span>";
			echo ' '.($arr == 0 ? "false" : "true");
			break;
		case "double":
			echo '<span style="color:'.DOUBLE_COLOR.'">';
			echo "Double </span>";
			echo ' '.$arr;
			break;
		case "integer":
			echo '<span style="color:'.INTEGER_COLOR.'">';
			echo "Integer </span>";
			echo ' '.$arr;
			break;
		case "string":
			echo '<span style="color:'.STRING_COLOR.'">';
			echo "String(".strlen($arr).")</span>";
			echo ' "'.str_replace(["<", ">"], ["&lt;", "&gt;"], $arr).'"';
			break;
		case "array":
			echo "Array(".sizeof($arr).") {\r\n";
			foreach($arr as $k => $v){
				if(gettype($k) == "string"){
					echo $p."\t".'["'.$k.'"] => ';
				}else{
					echo $p."\t"."[".$k."] => ";
				}
				_v($v, $p."\t");
				echo "\r\n";
			}
			echo $p."}";
			break;
		case "object":
			$class = get_class($arr);
			$super = get_parent_class($arr);

			echo '<span style="color:'.OBJECT_COLOR.'">';
			echo "Object";
			echo "</span>(".$class.($super != false ? " extends ".$super : "")."){\r\n";

			$o = (array)$arr;

			foreach($o as $k => $v){
				$type = "";
				$name = "";

				if(substr($k, 1, 1) == "*"){
					$type = "protected";
					$name = substr($k, 2);
				}else if(substr($k, 1, strlen($class)) == $class){
					$type = "private";
					$name = substr($k, strlen($class) + 1);
				}else if($super != false && substr($k, 1, strlen($super)) == $super){
					$type = $super." private";
					$name = substr($k, strlen($super) + 1);
				}else{
					$type = "public";
					$name = $k;
				}
				echo $p."\t"."[<u>".$type."</u> : ".$name."] => ";
				_v($v, $p."\t");
				echo "\r\n";
			}
			echo $p."}";
			break;
		default:
			break;
	}
}
?>
