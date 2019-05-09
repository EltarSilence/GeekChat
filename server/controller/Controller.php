<?php
class Controller{
  /*
    Funzione per settare il nuovo username
    @input
      id    -> id dell'utente
      new   -> nuovo username
  */
  public static function editUsername($id, $new){
    $mysqli = new mysqli(
      ZConfig::config("DB_HOST", "localhost"),
      ZConfig::config("DB_USER", "root"),
      ZConfig::config("DB_PASSWORD", ""),
      ZConfig::config("DB_DATABASE", "geekchat")
    );
    if($DB->connect_errno){
      die();
    }
    $ret = $DB->query("UPDATE utenti SET username = '".$new."' WHERE id = ".$id);
    return boolval($ret);
  }

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
    if($DB->connect_errno){
      die();
    }
    $ret = $DB->query("UPDATE utenti SET bio = '".$new."' WHERE id = ".$id);
    return boolval($ret);
  }




}
