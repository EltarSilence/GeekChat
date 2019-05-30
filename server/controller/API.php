<?php
class API{

  /*
    Funzione per ottenere i dati di un profilo
    @input
      id    -> id dell'utente
  */
  public static function getProfile($id){
    $j = [];            //array associativo di risposta
    if(isset($id) && !empty($id)){
      $mysqli = new mysqli(
        ZConfig::config("DB_HOST", "localhost"),
        ZConfig::config("DB_USER", "root"),
        ZConfig::config("DB_PASSWORD", ""),
        ZConfig::config("DB_DATABASE", "geekchat")
      );
      if($mysqli->connect_errno){
        die();
      }
      $result = $mysqli->query("SELECT * FROM utenti WHERE id = ".$id);
      if($result->num_rows == 0){     //no user found
        $j['error'] = true;
        $j['errorMSG'] = "Non esistono utenti con questo ID";
      }else{                          //utente trovato -> assegnazione dati
        $data = $result->fetch_assoc(); //da obj a arr associativo
        $j['username'] = $data['username'];
        $j['isAdmin'] = $data['isAdmin'];
        $j['bio'] = $data['bio'];
        $j['immagine'] = isset($data['immagine']) ? $data['immagine'] : "user.png";
        $j['lastAccess'] = $data['lastAccess'];
        $j['error'] = false;
      }
    }else{                            //manca il parametro
      $j['error'] = true;
      $j['errorMSG'] = "Nessun ID rilevato";
    }
    return $j;
  }

  /*
    Funzione per ottenere tutti gli utenti divisi tra online e offline
    @input
      /
    @output
      [
        [
          "username" : <username>,
          "immagine" : <immagine>,
          "bio" : <bio>,
          "online" : <true/false>,
        ]
      ]
  */
  public static function getOnlineUser(){
    $j = [];            //array associativo di risposta
    $mysqli = new mysqli(
      ZConfig::config("DB_HOST", "localhost"),
      ZConfig::config("DB_USER", "root"),
      ZConfig::config("DB_PASSWORD", ""),
      ZConfig::config("DB_DATABASE", "geekchat")
    );
    if($mysqli->connect_errno){
      die();
    }
    $date = new DateTime('- 15 second');
    $result = $mysqli->query("SELECT id, username, immagine, bio FROM utenti WHERE lastAccess >='".$date->format('Y-m-d H:i:s')."' ORDER BY username");
    while($row = $result->fetch_assoc()){
      $row['online'] = true;
      $row['immagine'] = isset($row['immagine']) ? $row['immagine'] : "user.png";
      $j[] = $row;
    }
    $result = $mysqli->query("SELECT id, username, immagine, bio FROM utenti WHERE lastAccess <'".$date->format('Y-m-d H:i:s')."' ORDER BY username");
    while($row = $result->fetch_assoc()){
      $row['online'] = false;
      $row['immagine'] = isset($row['immagine']) ? $row['immagine'] : "user.png";
      $j[] = $row;
    }
    return $j;
  }


  public static function getMessageFrom($id){
    $mysqli = new mysqli(
      ZConfig::config("DB_HOST", "localhost"),
      ZConfig::config("DB_USER", "root"),
      ZConfig::config("DB_PASSWORD", ""),
      ZConfig::config("DB_DATABASE", "geekchat")
    );
    if($mysqli->connect_errno){
      die();
    }
    $result = $mysqli->query("SELECT m.id, m.testo, m.dataOraInvio, m.idReply, u.id AS idUtente, u.username, mi.url AS immagine, ma.url AS audio, ml.url AS link, md.url AS documento, mp.lat, mp.lon
    FROM messaggi AS m
    	INNER JOIN utenti AS u ON u.id = m.idUtente
    	LEFT JOIN immagini AS mi ON mi.idMessaggio = m.id
    	LEFT JOIN audio AS ma ON ma.idMessaggio = m.id
    	LEFT JOIN posizioni AS mp ON mp.idMessaggio = m.id
    	LEFT JOIN links AS ml ON ml.idMessaggio = m.id
    	LEFT JOIN documenti AS md ON md.idMessaggio = m.id
    WHERE m.id >= ".$id);

    $ret = [];
    while($row = $result->fetch_assoc()){
    	$a = [];
    	$a['id'] = $row['id'];
    	$a['testo'] = $row['testo'];
    	$a['dataOraInvio'] = $row['dataOraInvio'];
    	$a['idUtente'] = $row['idUtente'];
    	$a['username'] = $row['username'];
    	$b = [];
    	$b['type'] = isset($row['immagine']) ? "immagine" :
    		isset($row['audio']) ? "audio" :
    		isset($row['link']) ? "link" :
    		isset($row['documento']) ? "documento" :
    		isset($row['lat'], $row['lon']) ? "posizione" : null;
    	if(isset($b['type'])){
    		switch($b['type']){
    			case "immagine":
    			case "audio":
    			case "link":
    			case "documento":
    				$b['url'] = $row[$b['type']];
    				break;
    			case "posizione":
    				$b['lat'] = $row['lat'];
    				$b['lon'] = $row['lon'];
    				break;
    		}
    	}
    	$a['content'] = $b;

    	$c = [];
    	if(isset($row['idReply'])){
    		$res =$mysqli->query("SELECT m.id, m.testo, u.username, mi.url AS immagine, ma.url AS audio, ml.url AS link, md.url AS documento, mp.lat, mp.lon
    			FROM messaggi AS m
    				INNER JOIN utenti AS u ON u.id = m.idUtente
    				LEFT JOIN immagini AS mi ON mi.idMessaggio = m.id
    				LEFT JOIN audio AS ma ON ma.idMessaggio = m.id
    				LEFT JOIN posizioni AS mp ON mp.idMessaggio = m.id
    				LEFT JOIN links AS ml ON ml.idMessaggio = m.id
    				LEFT JOIN documenti AS md ON md.idMessaggio = m.id
    			WHERE m.id >= ".$row['idReply']);
    		$r = $res->fetch_assoc();

    		$c['id'] = $r['id'];
    		$c['testo'] = $r['testo'];
    		$c['username'] = $r['username'];

    		$b = [];
    		$b['type'] = isset($r['immagine']) ? "immagine" :
    			isset($r['audio']) ? "audio" :
    			isset($r['link']) ? "link" :
    			isset($r['documento']) ? "documento" :
    			isset($r['lat'], $r['lon']) ? "posizione" : null;

    		if(isset($b['type'])){
    			switch($b['type']){
    				case "immagine":
    				case "audio":
    				case "link":
    				case "documento":
    					$b['url'] = $r[$b['type']];
    					break;
    				case "posizione":
    					$b['lat'] = $r['lat'];
    					$b['lon'] = $r['lon'];
    					break;
    			}
    		}
    		$c['content'] = $b;
    	}
    	if(sizeof($c) == 0){
    		$c = null;
    	}
    	$a['reply'] = $c;
    	$ret[] = $a;
    }

    return $ret;
  }

  public static function createContent($type, $data){
    switch($type){
      case 'link':
        return new LinkContent(['url' => $data['data']]);
      case 'image':
        return new ImageContent(['file' => sizeof($data['_FILES']['data']['name'])]);




    }

  }


}
