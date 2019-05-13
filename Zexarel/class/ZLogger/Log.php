<?php
class Log{

	private $openMode;
	private $date;
	private $time;
	private $type;
	private $message;
	private $data;

	public function __construct($openMode, $date, $time, $type, $message, $data){
		$this->openMode = $openMode;
		$this->date = $date;
		$this->time = $time;
		$this->type = $type;
		$this->message = str_replace(["\n", "\r", "\r\n"], "", $message);
		$this->data = ($openMode == "w" ? "\t".$this->_v($data, "\t")."\r\n" : $data);
	}

	private function _v($arr, $p){
		$t = gettype($arr);
		switch($t){
			case "boolean":
				return "Bool : ".($arr == 0 ? "false" : "true");
				break;
			case "double":
				return "Double : ".$arr;
				break;
			case "integer":
				return "Integer : ".$arr;
				break;
			case "string":
				return 'String : "'.$arr.'"';
				break;
			case "array":
				$s = "Array(".sizeof($arr).") {\r\n";
				foreach($arr as $k => $v){
					if(gettype($k) == "string"){
						$s.= $p."\t".'["'.$k.'"] => ';
					}else{
						$s .= $p."\t"."[".$k."] => ";
					}
					$s .= $this->_v($v, $p."\t");
					$s .= "\r\n";
				}
				return $s.$p."}";
				break;
			default:
				break;
		}
	}

	public function write($handle){
		if($this->openMode == "w"){
			fwrite($handle, '['.$this->date.' '.$this->time.']['.$this->type.'] : '.$this->message."\r\n".$this->data);
		}
	}
	public function getDate(){
		return $this->date;
	}
	public function getTime(){
		return $this->time;
	}
	public function getType(){
		return $this->type;
	}
	public function getMessage(){
		return $this->message;
	}
	public function getData(){
		return $this->data;
	}
}
?>
