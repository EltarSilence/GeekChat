<?php
class ZDatabase{

    protected $user;			//string, username del database
    protected $password;		//string, password del database
	protected $host;			//string, host del database
    protected $database;		//string, nome del database

	private $obj;				//oggetto mysqli

	public function __construct($host = null, $user = null, $password = null, $database = null) {
		/*
		Costruttore, inizializza tutti gli attributi come array vuoti (esclusi distinct che è un boolean e into che è una string)
		*/
		$this->host = ZConfig::config("DB_HOST", "");
		if(isset($host)){
			$this->host = $host;
		}
		$this->user = ZConfig::config("DB_USER", "");
		if(isset($user)){
			$this->user = $user;
		}
		$this->password = ZConfig::config("DB_PASSWORD", "");
		if(isset($password)){
			$this->password = $password;
		}
		$this->database = ZConfig::config("DB_DATABASE", "");
		if(isset($database)){
			$this->database = $database;
		}
		$this->select = [];
		$this->distinct = false;
		$this->from = [];
		$this->where = [];
		$this->groupBy = [];
		$this->having = [];
		$this->orderBy = [];
		$this->join = [];
		$this->error = [];
		$this->insert = [];
		$this->into = "";
		$this->value = [];
		$this->update = "";
		$this->set = [];
		if(
			isset($this->host) &&
			isset($this->user) &&
			isset($this->password) &&
			isset($this->database) &&
			$this->host != "" &&
			$this->user != "" &&
			$this->database != ""
		){
			$this->obj = new mysqli($this->host, $this->user, $this->password, $this->database);
		}else{
			throw new Exception("Database connection setting not completed");
		}/*
		if($this->obj){
			throw new Exception("Database connection not stabilized");
		}*/
    }

	public function __destruct(){
		/*
		Distruttore, chiude la connessione
		*/
		$this->obj->close();
	}

	private $select;		//array, elenco dei campi da selezionare
	private $distinct;		//boolean, la select è una distinc
	private $from;			//array, elenco delle tabelle da cui fare la select
	private $where;			//array, contiene degli array in cui (0 => campo, 1 => operatore, 2 => compare)
	private $orderBy;		//array, elenco dei campi in cui ordinare
	private $groupBy;		//array, elenco dei campi da raggruppare
	private $having;		//array, contiene degli array in cui (0 => campo, 1 => operatore, 2 => compare)
	private $join;			//array, contiene degli array in cui (0 => tabella, 1 => campo dalla tabella 1, 2 => compare, 3 => campo della tabella 2)

	private $insert;		//array, elenco dei campi che vengono inseriti
	private $into;			//string, nome tabella in cui inserire i valori
	private $value;			//array, contiene i valori da inserire

	private $update;		//string, nome della tabella da updatare
	private $set;			//array, contiene degli array in cui (0 => campo da updatare, 1 => nuovo valore)

	private $error;			//array, contiene gli errori trovati durante la creazione della sql

	public function select(){
		/*
		Metodo select
		ha un numero infinito di argomenti
		aggiunge all'attributo select uno o più nuovi campi
		*/
		$field = func_get_args();
		foreach($field as $k => $v){
			array_push($this->select, $v);
		}
		return $this;
	}
	public function selectAll(){
		/*
		Metodo selectAll
		non ha argomenti
		chiama il methodo select passano
		*/
		return $this->select("*");
	}
	public function selectDistinct(){
		/*
		Metodo selectDistinct
		ha un numero infinito di argomenti
		setta l'attributo distinct a true chiama il metodo select passano gli argomenti che ha ricevuto
		*/
		$field = func_get_args();
		$this->distinct = true;
		return $this->select($field);
	}
	public function from(){
		/*
		Metodo from
		non ha un argomenti
		aggiunge all'attributo from uno o più nuove tabelle
		*/
		$tables = func_get_args();
		foreach($tables as $k => $v){
			array_push($this->from, $v);
		}
		return $this;
    }
    public function where($field, $operator, $compare){
		/*
		Metodo where
		ha 3 argomenti
		aggiunge all'attributo where un nuovo array conenente i tre argomenti presi in input
		*/
		if(!in_array($operator, ["=", ">", ">=", "<", "<=", "LIKE", "<>", "IN"])){
			array_push($this->error, "Errore nell'operatore del WHERE");
		}else{
			$a = $this->haveErrorChar($compare);
			if($a == false && $a != 0){
				array_push($this->error, "Errore nel campo di comparazione del WHERE");
			}else{
				if(gettype($compare) == 'string'){
					$a = "'".$a."'";
				}
				array_push($this->where, [$field, $operator, $a]);
			}
		}
		return $this;
    }
    public function groupBy($group_options){
		/*
		Metodo groupBy
		ha un argomento
		aggiunge all'attributo groupBy un campo
		*/
        array_push($this->groupBy, $group_options);
		return $this;
    }
	public function having($field, $operator, $compare){
		/*
		Metodo having
		ha 3 argomenti
		aggiunge all'attributo having un nuovo array conenente i tre argomenti presi in input
		*/
		if(!in_array($operator, ["=", ">", ">=", "<", "<=", "LIKE", "<>", "IN"])){
			array_push($this->error, "Errore nell'operatore del HAVING");
		}else{
			$a = $this->haveErrorChar($compare);
			if($a == false && $a != 0){
				array_push($this->error, "Errore nel campo di comparazione del HAVING");
			}else{
				if(gettype($compare) == 'string'){
					$a = "'".$a."'";
				}
				array_push($this->having, [$field, $operator, $a]);
			}
		}
		return $this;
    }
	public function orderBy($order_options){
		/*
		Metodo orderBy
		ha un argomento
		aggiunge all'attributo orderBy un campo
		*/
		array_push($this->orderBy, $order_options);
		return $this;
    }
	public function innerJoin($table, $on, $operator, $compare){
		/*
		Metodo innerJoin
		ha 4 argomenti
		aggiunge all'attributo join un array contenente "INNER JOIN" e i 4 argomenti presi in input
		*/
		if(!in_array($operator, ["=", ">", ">=", "<", "<=", "LIKE", "<>"])){
			array_push($this->error, "Errore nell'operatore dell'INNER JOIN");
		}else{
			$a = $this->haveErrorChar($compare);
			if($a == false && $a != 0){
				array_push($this->error, "Errore nel campo di comparazione dell'INNER JOIN");
			}else{
				if(gettype($compare) == 'string'){
					if(strpos($a, ".") == false){
						$a = "'".$a."'";
					}
				}
				array_push($this->join, ["INNER JOIN", $table, $on, $operator, $a]);
			}
		}
		return $this;
	}
	public function leftJoin($table, $on, $operator, $compare){
		/*
		Metodo leftJoin
		ha 4 argomenti
		aggiunge all'attributo join un array contenente "LEFT JOIN" e i 4 argomenti presi in input
		*/
		if(!in_array($operator, ["=", ">", ">=", "<", "<=", "LIKE", "<>"])){
			array_push($this->error, "Errore nell'operatore del LEFT JOIN");
		}else{
			$a = $this->haveErrorChar($compare);
			if($a == false && $a != 0){
				array_push($this->error, "Errore nel campo di comparazione dell'LEFT JOIN");
			}else{
				if(gettype($compare) == 'string'){
					if(strpos($a, ".") == false){
						$a = "'".$a."'";
					}
				}
				array_push($this->join, ["LEFT JOIN", $table, $on, $operator, $a]);

			}
		}
		return $this;
	}
	public function rightJoin($table, $on, $operator, $compare){
		/*
		Metodo leftJoin
		ha 4 argomenti
		aggiunge all'attributo join un array contenente "RIGHT JOIN" e i 4 argomenti presi in input
		*/
		if(!in_array($operator, ["=", ">", ">=", "<", "<=", "LIKE", "<>"])){
			array_push($this->error, "Errore nell'operatore del RIGHT JOIN");
		}else{
			$a = $this->haveErrorChar($compare);
			if($a == false && $a != 0){
				array_push($this->error, "Errore nel campo di comparazione dell'RIGHT JOIN");
			}else{
				if(gettype($compare) == 'string'){
					if(strpos($a, ".") == false){
						$a = "'".$a."'";
					}
				}
				array_push($this->join, ["RIGHT JOIN", $table, $on, $operator, $a]);

			}
		}
		return $this;
	}
	public function insert(){
		/*
		Metodo insert
		ha un numero infinito di argomenti
		setta l'attributo into con il primo argomento ricevuto, e aggiunge all'atributo insert gli altri argomenti
		*/
		$arg = func_get_args();
		if(sizeof($arg) > 0){
			$this->into = $arg[0];
		}else{
			array_push($this->error, "Table non settata nell'INSERT");
		}
		array_unshift($arg);
		if(sizeof($arg) > 0){
			for($i = 1; $i < sizeof($arg); $i++){
				array_push($this->insert, $arg[$i]);
			}
		}else{
			array_push($this->error, "Campi non settati nell'INSERT");
		}
		return $this;
	}
	public function value(){
		/*
		Metodo value
		ha infiniti argomenti
		aggiunge all'atributo value un array contenente tutti gli argomenti ricevuti in iput
		*/
		$value = func_get_args();
		$v = [];
		foreach($value as $vv){
			$a = $this->haveErrorChar($vv);
			if($a == false && $a != 0){
				array_push($this->error, "Errore nel campo del VALUE");
				return $this;
			}else{
				if(gettype($a) == 'string'){
					$a = "'".$a."'";
				}
				array_push($v, $a);
			}
		}
		array_push($this->value, $v);
		return $this;
	}
	public function update($table){
		/*
		Metodo update
		ha un argomento
		setta l'attributo update con l'argomento ricevuto in input
		*/
		$this->update = $table;
		return $this;
	}
	public function set($field, $value){
		/*
		Metodo updsetate
		ha due argomenti
		aggiunge all'attributo set un array contenente gli argomenti ricevuti in input
		*/

		$f = $this->haveErrorChar($field);
		if($f == false && $f != 0){
			array_push($this->error, "Errore nel campo del SET");
			return $this;
		}else{
			$v = $this->haveErrorChar($value);
			if($v == false && $v != 0){
				array_push($this->error, "Errore nel valore del SET");
				return $this;
			}else{
				if(gettype($v) == 'string'){
					$v = "'".$v."'";
				}
				array_push($this->set, [$f, $v]);
				return $this;
			}
		}

	}
	public function getSQL(){
		/*
		Metodo getSQL
		non ha argomenti
		crea la sql partento dagli attributi della classe, e li azzera prima di ritorna la sql
		*/
		if(sizeof($this->error) > 0){
			throw new DataException("There is some error", $this->error);
		}else{
			$sql = "";
			if(sizeof($this->select) > 0){
				if(sizeof($this->from) > 0){
					$sql = "SELECT ".($this->distinct ? "DISTINCT " : "").implode(", ", $this->select)." FROM ";
					for($i = 0; $i < sizeof($this->from); $i++){
						$sql .=  $this->from[$i];
						if($i < sizeof($this->from) - 1){
							$sql .= " ,";
						}
					}
					if(sizeof($this->join)){
						for($i = 0; $i < sizeof($this->join); $i++){
							$sql .=  " ".$this->join[$i][0]." ".$this->join[$i][1]." ON ".$this->join[$i][2]." ".$this->join[$i][3]." ".$this->join[$i][4];
						}
					}
					if(sizeof($this->where) > 0){
						for($i = 0; $i < sizeof($this->where); $i++){
							if($i == 0){
								$sql .= " WHERE";
							}
							$sql .= " ".implode(" ", $this->where[$i]);
							if($i < sizeof($this->where) - 1){
								$sql .= " AND";
							}
						}
					}
					if(sizeof($this->groupBy)){
						for($i = 0; $i < sizeof($this->groupBy); $i++){
							if($i == 0){
								$sql .= " GROUP BY";
							}
							$sql .=  " ".$this->groupBy[$i];
							if($i < sizeof($this->groupBy) - 1){
								$sql .= ",";
							}
						}
						if(sizeof($this->having) > 0){
							for($i = 0; $i < sizeof($this->having); $i++){
								if($i == 0){
									$sql .= " HAVING";
								}
								$sql .= " ".implode(" ", $this->having[$i]);
								if($i < sizeof($this->having) - 1){
									$sql .= " AND";
								}
							}
						}
					}
					if(sizeof($this->orderBy)){
						for($i = 0; $i < sizeof($this->orderBy); $i++){
							if($i == 0){
								$sql .= " ORDER BY";
							}
							$sql .=  " ".$this->orderBy[$i];
							if($i < sizeof($this->orderBy) - 1){
								$sql .= ",";
							}
						}
					}
				}else{
					trigger_error("FROM non settato", E_USER_ERROR);
					exit();
				}
			}else if(sizeof($this->insert) > 0 && sizeof($this->value) > 0){
				$sql = "INSERT INTO ".$this->into;
				for($i = 0; $i < sizeof($this->insert); $i++){
					if($i == 0){
						$sql .= " (";
					}
					$sql .= $this->insert[$i].", ";
					if($i == sizeof($this->insert)-1){
						$sql = substr($sql, 0, strlen($sql)-2).")";
					}
				}
				$sql .= " VALUES ";
				for($i = 0; $i < sizeof($this->value); $i++){
					$sql .= "(";
					for($k = 0; $k < sizeof($this->value[$i]); $k++){
						$sql .= $this->value[$i][$k];
						if($k != sizeof($this->value[$i]) - 1){
							$sql .= ", ";
						}
					}
					$sql .= ")";
					if($i != sizeof($this->value) - 1){
						$sql .= ", ";
					}
				}
			}else if(sizeof($this->update) > 0 && sizeof($this->set) > 0){
				$sql = "UPDATE ".$this->update." SET";
				for($i = 0; $i < sizeof($this->set); $i++){
					$sql .= " ".implode(" = ", $this->set[$i]);
					if($i != sizeof($this->set) - 1){
						$sql .= ", ";
					}
				}
				if(sizeof($this->where) > 0){
					for($i = 0; $i < sizeof($this->where); $i++){
						if($i == 0){
							$sql .= " WHERE";
						}
						$sql .= " ".implode(" ", $this->where[$i]);
						if($i < sizeof($this->where) - 1){
							$sql .= " AND";
						}
					}
				}
			}else{
				//possibile ??
			}
			$this->select = [];
			$this->distinct = false;
			$this->from = [];
			$this->where = [];
			$this->groupBy = [];
			$this->having = [];
			$this->orderBy = [];
			$this->join = [];
			$this->error = [];
			$this->insert = [];
			$this->into = "";
			$this->value = [];
			$this->update = "";
			$this->set = [];
			return $sql;
		}
	}
	public function execute(){
		/*
		Metodo execute
		non ha argomenti
		richiama il metodo getSQL e executeSql passandogli la sql creata
		*/
		$sql = "";
		try{
			$sql = $this->getSQL();
			return $this->executeSql($sql);
		}catch(Exception $e){
			/*
			possibile log
			d_var_dump($e);
			*/
		}
	}
	private function haveErrorChar($str){
		/*
		Metodo haveErrorChar
		ha un argomento
		ritorna false nel caso nell'argomento ci sia uno dei caratteri che possono "rompere" una sql, altrimenti trasforma tutti gli ' in \' e ritorna la nuova stringa
		*/
		if(gettype($str) == 'string'){
			return str_replace(
				["'", "--", ";", "/*", "*/", "<?", "?>"],
				["\'", "\-\-", "&pv", "&sc", "&ec", "&sp", "&ep"],
				$str);
		}else{
			return $str;
		}
	}
	protected function beforeExecute($sql){
		/*
		Metodo beforeExecute
		metodo che viene richimato prima dell'esecuzione della query, utile per dei log
		*/
	}
	protected function afterExecute($sql, $result, $rowAffected){
		/*
		Metodo afterExecute
		metodo che viene richimato dopo dell'esecuzione della query, utile per dei log
		*/
	}
	public function executeSql($sql){
		/*
		Metodo executeSql
		ha un argomento
		richiama il metodo beforeExecute passandogli la sql ricevuta in input, esegue la sql e nel caso essa inizi con "SELECT" mette in un array tutti i record ottenuti come risultato e ritorna esso altrimenti ritorna un array vuoto
		*/
		$this->beforeExecute($sql);
        $result = $this->obj->query($sql);
		$this->afterExecute($sql, $result, $this->obj->affected_rows);
		$resultset = array();
		if(substr($sql, 0, 6) == "SELECT"){
      if($result->num_rows > 0){
  			$fields = $result->field_count;
  			while($row = $result->fetch_assoc()) {
  				$r = $row;
  				array_push($resultset, $r);
  			}
  			if(!empty($resultset)){
  				return $resultset;
  			}
      }
      return [];
		}else{
			return $result;
		}
    }
}
?>
