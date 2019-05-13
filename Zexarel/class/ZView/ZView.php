<?php
class ZView{

	protected static $viewDir = "view";
	protected static $appFile = "app.html";

	private static $html;
	private static $dir;

	private static function loadContent($name, $match){
		$tmp = file_get_contents(ZView::$dir . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . $name . (find(".", substr($name, -6)) < 0 ?".html" : ""));
		for($i = 0; $i < sizeof($match[1]); $i++){
			$t = strlen(ZView::$html);
			ZView::$html = str_replace("@include('".$match[1][$i]."')", get_string_between($tmp, "@".$match[1][$i], "@end".$match[1][$i]), ZView::$html);
			if($t == strlen(ZView::$html)){
				ZView::$html = str_replace('@include("'.$match[1][$i].'")', get_string_between($tmp, "@".$match[1][$i], "@end".$match[1][$i]), ZView::$html);
			}
		}
	}

	private static function loadYield($name){
		return file_get_contents(ZView::$dir . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . $name.(find(".", substr($name, -6)) < 0 ? ".html" : ""));
	}

	public static function get($content, $base = null, $data = null){
		if(!isset($base)){
			$base = "";
		}
		if(!isset($data)){
			$data = [];
		}
		$content = static::$viewDir .$content;
		ZView::$dir = dirname((new ReflectionClass(get_called_class()))->getFilename());
		ZView::$html = file_get_contents(ZView::$dir . DIRECTORY_SEPARATOR . static::$appFile);
		preg_match_all('/\@include\([\'"]{1}([a-zA-Z\\\'"_]*)[\'"]{1}\)/', ZView::$html, $match);
		ZView::loadContent($content, $match);
		if(find('@base', ZView::$html) >= 0){
			ZView::$html = str_replace('@base', ($base == "" ? "" : '<base href="'.$base.'" />'), ZView::$html);
		}
		while(preg_match('/\@yield\([\'"]{1}([a-zA-Z\\\'"_]*)[\'"]{1}\)/', ZView::$html, $match)){
			ZView::$html = str_replace($match[0], ZView::loadYield(static::$viewDir . DIRECTORY_SEPARATOR . $match[1]), ZView::$html);
		}
		echo ZBladeCompiler::compile(ZView::$html, $data);
	}
}
?>
