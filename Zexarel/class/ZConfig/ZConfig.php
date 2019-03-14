<?php
	class ZConfig{
		
		private static $file = ".zenv";		//string, nome del file contenente le configurazioni
		
		public static function config($name, $default = null){
			/*
			Metodo config
			ha due argomenti
			man mano che legge il file di configurazione ritorna il valore corrispondente al primo argomentonel caso lo trovi, altrimenti ritorna il secondo argomento
			*/
			if(!file_exists(ZConfig::$file)){
				return $default;
			}
			$f = file(ZConfig::$file);
			$ret = [];
			foreach($f as $ff){
				$a = explode(":", $ff);
				if($a[0] == $name){
					return str_replace("\r\n", "", $a[1]);
				}
			}
			return $default;
		}
	}	
?>