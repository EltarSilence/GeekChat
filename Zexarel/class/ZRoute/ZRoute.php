<?php
class ZRoute{
	private static $_route = [];
	public static function __callStatic($name, $arg){
		if(in_array(strtoupper($name), ["GET", "POST", "PUT", "DELETE", "HEAD"])){
			ZRoute::$_route[] = new Route(strtoupper($name), trim($arg[0], '/\^$'), $arg[1], (isset($arg[2]) ? $arg[2] : null));
		}
	}
	public static function getUri($name){
		/*
		Metodo getUri
		ha un argomento
		cerca tra i nomi registrati url della route corrispondente
		*/
		foreach(ZRoute::$_route as $r){
			if($r->getName() == $name){
				return $r->getUrl();
			}
		}
		return "";
	}

	public static function getRoute($name){
		foreach(ZRoute::$_route as $r){
			if($r->getName() == $name){
				return $r;
			}
		}
	}

	public static function listen(){
		/*
		Metodo listen
		non ha argomenti
		legge le richieste e a seconda del REQUEST_METHOD, controlla se tale route esiste e chiama la callable corrispondente altrimenti ritorna HTTP 1.1 404 Route Not Found
		*/
		$req = new Request();
		for($i = 0; $i < sizeof(ZRoute::$_route); $i++){
			if(ZRoute::$_route[$i]->compareRequestAndRun($req)){
				exit();
			}
		}
		http_response_code(404);
		include(__DIR__ . "/../../error/404.html");
		exit;
	}
}
?>
