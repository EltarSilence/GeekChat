<?php
class Controller{
  /*
    Funzione per settare la nuova descrizione
    @input
      id    -> id dell'utente
      new   -> nuova descrizione
  */
  public static function editDescrizione($id, $new){
    $mysqli = new mysqli(
      ZConfig::config("DB_HOST", "localhost"),
      ZConfig::config("DB_USER", "root"),
      ZConfig::config("DB_PASSWORD", ""),
      ZConfig::config("DB_DATABASE", "geekchat")
    );
    if($mysqli->connect_errno){
      die();
    }
    $ret = $mysqli->query("UPDATE utenti SET bio = '".$new."' WHERE id = ".$id);
    return boolval($ret);
  }

  /*
    Funzione per settare che un utente è online
    @input
      id    -> id dell'utente
  */
  public static function updateOnlineStatus($id){
    $DB = new mysqli(
      ZConfig::config("DB_HOST", "localhost"),
      ZConfig::config("DB_USER", "root"),
      ZConfig::config("DB_PASSWORD", ""),
      ZConfig::config("DB_DATABASE", "geekchat")
    );
    if($DB->connect_errno){
      die();
    }
    $ret = $DB->query("UPDATE utenti SET lastAccess = NOW() WHERE id = ".$id);
    return boolval($ret);
  }

  public static function send($data){
    $DB = new mysqli(
      ZConfig::config("DB_HOST", "localhost"),
      ZConfig::config("DB_USER", "root"),
      ZConfig::config("DB_PASSWORD", ""),
      ZConfig::config("DB_DATABASE", "geekchat")
    );
    if($DB->connect_errno){
      die();
    }
    $text = $data['text'];
    $idUser = $_SESSION['id'];
    $idReply = "null";
    $date = date("Y-m-d H:i:s");

    $ret = $DB->query("INSERT INTO messaggi(testo, dataOraInvio, idReply, idUtente) VALUES('".$text."', '".$date."', ".$idReply.", ".$idUser.")");
    $ret = $DB->query("SELECT id FROM messaggi ORDER BY id DESC");
    $id = $ret->fetch_assoc()['id'];

    switch ($data['type']) {
      case 'link':
        $ret = $DB->query("INSERT INTO links(url, idMessaggio) VALUES('".$data['data']."', ".$id.")");
        break;
      case 'image':



    }



  }



}
