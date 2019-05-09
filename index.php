<?php
require_once 'Zexarel/loader.php';

require_once 'server/view/AppView.php';
require_once 'server/controller/Controller.php';
require_once 'server/model/user.php';

ZRoute::get("/", function (){
  redirect("chat");
});

ZRoute::get("/chat", function (){
  AppView::get("chat");
}, "chat");

ZRoute::get("/test", function (){

});

/*           CHIAMATE AJAX            */
ZRoute::post("/getOnlineUser", function (){
  $j = Controller::getOnlineUser();
  foreach($j as $k => $v){
    $u = new User($v);
    echo $u->getHtml();
  }

});

ZRoute::post("/show_my_profile", function (){
  //Qui ci va lo script che deve essere esguito quando si fa una chiamata AJAX per mostrare il mio profilo
}, "my_profile");

/*
  Chiamata per settare un nuovo username
  @input:
    username  ->  Nuovo username
*/
ZRoute::post("/edit_username", function($data){
  if(isset($data['username'], $_SESSION['id'])){
    if(Controller::editUsername($_SESSION['id'], $data['username'])){
      die();
    }
    http_responce_code(500);
    die();
  }
  http_responce_code(500);
  die();
}, "edit_username");

/*
  Chiamata per settare un nuova descrizione
  @input:
    desc  ->  Nuova descrizione
*/
ZRoute::post("/edit_descrizione", function($data){
  if(isset($data['desc'], $_SESSION['id'])){
    if(Controller::editDescrizione($_SESSION['id'], $data['desc'])){
      die();
    }
    http_responce_code(500);
    die();
  }
  http_responce_code(500);
  die();
}, "edit_descrizione");


ZRoute::listen();

?>
