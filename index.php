<?php
require_once 'Zexarel/loader.php';

require_once 'server/view/AppView.php';
require_once 'server/controller/Controller.php';
require_once 'server/controller/API.php';
require_once 'server/model/User.php';
require_once 'server/model/MyProfile.php';
require_once 'server/model/Profile.php';
require_once 'server/model/Message.php';
require_once 'server/model/LinkContent.php';
require_once 'server/model/ImageContent.php';

session_start();
$_SESSION['id'] = 1;
$_SESSION['username'] = "Zexal0807";

ZRoute::get("/", function (){
  redirect("chat");
});

ZRoute::get("/chat", function (){
  AppView::get("chat");
}, "chat");

/*           CHIAMATE AJAX            */
ZRoute::post("/updateOnlineStatus", function(){
  if(isset($_SESSION['id'])){
    if(Controller::updateOnlineStatus($_SESSION['id'])){
      die();
    }
    http_response_code(500);
    die();
  }
  http_response_code(500);
  die();
});
ZRoute::post("/getOnlineUser", function (){
  $j = API::getOnlineUser();
  foreach($j as $k => $v){
    $u = new User($v);
    echo $u->getHtml();
  }
});

ZRoute::post("/myProfile", function (){
  if(isset($_SESSION['id'])){
    $p = new MyProfile(API::getProfile($_SESSION['id']));
    echo $p->getHtml();
  }else{
    http_response_code(500);
    die();
  }
});

ZRoute::post("/showProfile", function ($data){
  if(isset($data['id'])){
    $p = new Profile(API::getProfile($data['id']));
    echo $p->getHtml();
  }else{
    http_response_code(500);
    die();
  }
});

ZRoute::post("/getContent", function ($data){
  if(isset($data['type'])){
    $p = API::createContent($data['type'], $data);
    echo $p->getHtml();
  }else{
    http_response_code(500);
    die();
  }
});

ZRoute::post("/sendMessage", function ($data){
  Controller::send($data);
});

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
    http_response_code(500);
    die();
  }
  http_response_code(500);
  die();
});

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
    http_response_code(500);
    die();
  }
  http_response_code(500);
  die();
});


ZRoute::listen();

?>
