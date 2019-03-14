<?php
class ZView{

	protected static $dir = 'view/';		//string, directory della vista
	protected static $app = "app.html";		//string, nome del file contenente l'app

	public static function getView($content, $base = null, $data = null){
		/*
		Metodo getView
		ha tre argomenti
		carica l'app prendendo la path dalle costanti della classe, e cerca la vista partendo dal nome ricevuto nel primo parametro, aggiunge il tag base settano il valore presente nel secondo argomento e passa i dati presenti nel terzo argomento
		*/
		if(!isset($base)){
			$base = "";
		}
		if(!isset($data)){
			$data = [];
		}
		$str = file_get_contents(__DIR__ . "/../../". static::$app);
		if(find('@base', $str) >= 0){
			$str = str_replace('@base', ($base == "" ? "" : '<base href="'.$base.'" />'), $str);
		}
		preg_match_all('/@include\([a-zA-Z\'"_]*\)/', $str, $match);
		for($i = 0; $i < sizeof($match[0]); $i++){
			$match[1][$i] = str_replace(["'", '"'], ["", ""], get_string_between($match[0][$i], "(", ")"));
		}
		$match = self::getInclude($content, $match);
		for($i = 0; $i < sizeof($match[0]); $i++){
			$str = str_replace($match[0][$i], $match[2][$i], $str);
		}
		preg_match_all('/@yield\([a-zA-Z\'"_]*\)/', $str, $match);
		for($i = 0; $i < sizeof($match[0]); $i++){
			$str = str_replace($match[0][$i], self::getYield($match[0][$i]), $str);
		}
		$str = preg_replace('/@foreach(.*)/', '<?php foreach$1{ ?>', $str);
		$str = preg_replace('/@for(.*)/', '<?php for$1{ ?>', $str);
		$str = preg_replace('/@endforeach/', '<?php } ?>', $str);
		$str = preg_replace('/@endfor/', '<?php } ?>', $str);
		$str = preg_replace('/@if(.*)/', '<?php if$1{ ?>', $str);
		$str = preg_replace('/@elseif(.*)/', '<?php }else if$1{ ?>', $str);
		$str = preg_replace('/@else/', '<?php }else{ ?>', $str);
		$str = preg_replace('/@endif/', '<?php } ?>', $str);
		$str = preg_replace('/{{{(.*)}}}/', '<?php $1; ?>', $str);
		$str = preg_replace('/{{(.*?)}}/', '<?php echo $1; ?>', $str);

		ob_start();
		if(sizeof($data) > 0 ){
			foreach($data as $k => $v){
				${$k} = $v;
			}
		}
		eval("?>".$str);
		$html = ob_get_contents();
		ob_end_clean();
		echo $html;
	}
	private static function getInclude($content, $match){
		/*
		Metodo getInclude
		ha due argomenti
		legge il file cercando il nome partendo dal primo argomento, e lo divide in nelle varie sezioni di cui è composto
		*/
		$str = file_get_contents(__DIR__ . "/../../". static::$dir.$content.".html");
		for($i = 0; $i < sizeof($match[1]); $i++){
			$match[2][$i] = get_string_between($str, "@".$match[1][$i], "@end".$match[1][$i]);
		}
		return $match;
	}
	private static function getYield($content){
		/*
		Metodo getYield
		ha un argomento
		legge e ritorna il contenuto del file
		*/
		$n = str_replace(["'", '"', "@yield(", ")"], ["", "", "", ""], $content);
		return file_get_contents(__DIR__ . "/../../". static::$dir.$n.".html");
	}
}
?>
