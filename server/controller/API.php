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




}
