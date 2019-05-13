<?php
class ZModel{
	protected $dir = "model/";			//string, directory del modello
	protected $name = "model";			//string, nome del modello
	private $property;					//array, contiene gli attributi della classe
	public function __construct($data = null){
		/*
		Metodo costruttore
		ha un parametro
		passandogli i dati setta l'attributo property con i valori ricevuti
		*/
		$this->property = [];
		if(isset($data)){
			foreach($data as $k => $v){
				$this->property[$k] = $v;
			}
		}
	}

	public function __get($name){
		if(array_key_exist($name, $this->property)){
			return $this->property[$name];
		}else {
			return "";
		}
	}

	public function getHtml(){
		/*
		Metodo get
		non ha argomenti
		legge il file del modello, sostituisce i valori con quelli dei parametri, esegue la funzione eval sul risultato e ritorna l'html generato
		*/
		$str = file_get_contents($this->dir.$this->name.".html");
		$html = ZBladeCompiler::compile($str, $this->property);
		return $html;
	}
}
?>
