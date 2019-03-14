<?php
class Route{
	private $method;
	private $url;
	private $pattern;
	private $parameter;
	private $callback;
	private $name;
	public function __construct($method, $url, $callback, $name = null){
		$this->method = $method;
		$this->url = $url;
		$p = explode("/", $this->url);
		$this->pattern = "";
		$f = false;
		for($i = 0; $i < sizeof($p); $i++){
			if(preg_match('/\<+[a-zA-Z0-9]*+\>/', $p[$i])){
				if($f){
					$this->pattern .= "+\/";
				}
				$f = true;
				$this->pattern .= '+[a-zA-Z0-9]*';
				$this->parameter[] = $p[$i];
			}elseif(preg_match('/\\[+[a-zA-Z0-9]*+\]/', $p[$i])){
				$this->pattern .= "+(\/+".str_replace(["[", "]"], "", $p[$i]).')?';
			}else{
				if($f){
					$this->pattern .= "+\/";
				}
				$this->pattern .= $p[$i];
				$f = true;
			}
		}
		$this->callback = $callback;
		$this->name = $name;
	}
	public function getUrl(){
		return $this->url;
	}
	public function getName(){
		return $this->name;
	}
	public function getPattern(){
		return $this->pattern;
	}
	public function compareRequestAndRun(Request $req){
		if($req->getMethod() == $this->method){
				$arr = $req->getParameters();
				if(preg_match("#^".$this->pattern."$#", $req->getUrl())){
				$arr["_COOKIE"] = $req->getCookies();
				$arr["_FILES"] = $req->getFiles();
				if($this->url != $req->getUrl()){
					$f = explode("/", $this->url);
					$r = explode("/", $req->getUrl());
					for($i = 0, $k = 0; $i < sizeof($r); $i++, $k++){
						if($r[$i] == $f[$k]){
						}else{
							if(preg_match('/\[+[a-zA-Z0-9]*+\]/', $f[$k])){
								$e = str_replace(["[", "]"], "", $r[$i]);
								$arr[str_replace(["[", "]"], "", $f[$k])] = ($e == $f[$k]);
								$i--;
							}elseif(preg_match('/\<+[a-zA-Z0-9]*+\>/', $f[$k])){
								$e = str_replace(["<", ">"], "", $r[$i]);
								$arr[$f[$k]] = $e;
							}
						}
					}
				}
				$this->run($arr);
				if($req->getMethod() == "HEAD"){
					ob_end_clean();
				}
				return true;
			}
		}
		return false;
	}
	private function run($data){
		$arr[0] = $data;
		if(gettype($this->callback) == "string"){
			$cal = explode("@", $this->callback);
			if(sizeof($a) == 2){
				call_user_func_array($cal, $arr);
			}
		}elseif(is_callable($this->callback)){
			call_user_func_array($this->callback, $arr);
		}
	}
}
?>
