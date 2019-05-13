<?php
class ZLogger{

	public function __construct(){
		$dir = __DIR__."../../../../".ZConfig::config("LOG_DIRECTORY", "logs");
		if(!file_exists($dir)){
			mkdir($dir);
		}
		$this->file = $dir."/log_".date("Y-m-d").".txt";
	}

	public function read(){
		$dir = ZConfig::config("LOG_DIRECTORY", "logs");
		if(!file_exists($dir)){
			mkdir($dir);
		}
		$scan = scandir($dir, SCANDIR_SORT_DESCENDING);
		array_pop($scan);
		array_pop($scan);
		$ret = [];
		for($k = 0; $k < sizeof($scan) && $k < 30; $k++){
			$h = fopen($dir."/".$scan[$k], "r");
			$str = fread($h, filesize($dir."/".$scan[$k]));
			fclose($h);
			$f = explode("\r\n[", $str);
			for($i = 0; $i < sizeof($f); $i++){
				$find = explode("\n", $f[$i]);
				$d[0] = (substr($find[0], 0, 1) == "[" ? "" : "[").$find[0];
				array_shift($find);
				$d[1] = implode("\n", $find);
				preg_match_all('/\[([0-9]{4}\-[0-9]{2}\-[0-9]{2}) ([0-9]{2}\:[0-9]{2}\:[0-9]{2})\]\[([A-Z]*)\] \: ([a-zA-Z\ ]*)/', $d[0], $find);
				$ret[] = new Log("r", $find[1][0], $find[2][0], $find[3][0], $find[4][0], $d[1]);
			}
		}
		return $ret;
	}

	public function write($type, $message, $data = null){
		$a = new Log("w", date("Y-m-d"), date("H:i:s"), $type, $message, $data);
		$a->write(fopen($this->file, "a"));
	}

	public function debug($message, $data = null){
		$this->write("DEBUG", $message, $data);
	}
	public function info($message, $data = null){
		$this->write("INFO", $message, $data);
	}
	public function notice($message, $data = null){
		$this->write("NOTICE", $message, $data);
	}
	public function warning($message, $data = null){
		$this->write("WARNING", $message, $data);
	}
	public function error($message, $data = null){
		$this->write("ERROR", $message, $data);
	}
	public function critical($message, $data = null){
		$this->write("CRITICAL", $message, $data);
	}
	public function alert($message, $data = null){
		$this->write("ALERT", $message, $data);
	}
	public function emergency($message, $data = null){
		$this->write("EMERGENCY", $message, $data);
	}
}
?>
