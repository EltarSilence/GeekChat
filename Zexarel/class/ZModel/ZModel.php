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
	public function get(){
		/*
		Metodo get
		non ha argomenti
		legge il file del modello, sostituisce i valori con quelli dei parametri, esegue la funzione eval sul risultato e ritorna l'html generato
		*/
		$str = file_get_contents($this->dir.$this->name.".html");
		$str = preg_replace('/@for(.*)/', '<?php for$1{ ?>', $str);
		$str = preg_replace('/@endfor/', '<?php } ?>', $str);
		$str = preg_replace('/@if(.*)/', '<?php if$1{ ?>', $str);
		$str = preg_replace('/@elseif(.*)/', '<?php }else if$1{ ?>', $str);
		$str = preg_replace('/@else/', '<?php }else{ ?>', $str);
		$str = preg_replace('/@endif/', '<?php } ?>', $str);
		$str = preg_replace('/{{ \$(\S*) }}/', '<?php echo $this->property["$1"]; ?>', $str);
		ob_start();
		eval("?>".$str);
		$html = ob_get_contents();
		ob_end_clean();
		return $html;
	}
}
?>
