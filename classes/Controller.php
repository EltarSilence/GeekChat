<?php
class Controller{
  public static function getProfile($id){
  	$j = array(); //array associativo di risposta
  	if (isset($id) && !empty($id)){
      $db = new Database();
      $data = $db->selectAll()
        ->from("utenti")
        ->where("id", "=", $id)
        ->execute();
  		if(sizeof($data) == 0){   //no user found
  			$j['error'] = true;
  			$j['errorMSG'] = "Non esistono utenti con questo ID";
  		}else{ //utente trovato -> assegnazione dati
  			$j['username'] = $data['username'];
  			$j['isAdmin'] = $data['isAdmin'];
  			$j['bio'] = $data['bio'];
  			$j['immagine'] = $data['immagine'];
  			$j['lastAccess'] = $data['lastAccess'];
  			$j['error'] = false;
  		}
  	}else{  //manca il parametro
  		$j['error'] = true;
  		$j['errorMSG'] = "Nessun ID rilevato";
  	}
  	echo json_encode($j);
  }

  /*
    Funzione per settare il nuovo username
    @input
      id    -> id dell'utente
      new   -> nuovo username
  */
  public static function editUsername($id, $new){
    $DB =  new Database();
    $ret = $DB->update("utenti")
      ->set("username", $new)
      ->where("id", "=", $id)
      ->getSQL();
      echo $ret;
      //->execute();
    return boolval($ret);
  }

}
