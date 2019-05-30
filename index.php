<?php
require_once 'Zexarel/loader.php';

require_once 'server/view/AppView.php';
require_once 'server/view/LoginView.php';
require_once 'server/controller/Controller.php';
require_once 'server/controller/API.php';
require_once 'server/model/User.php';
require_once 'server/model/MyProfile.php';
require_once 'server/model/Profile.php';
require_once 'server/model/Message.php';

session_start();

ZRoute::get("/", function (){
  redirect("chat");
});

ZRoute::get("/chat", function (){
  AppView::get("chat");
}, "chat");

ZRoute::get("/login", function (){
  LoginView::get("login");
}, "login");

ZRoute::post("/login", function ($data){
  include "/assets/php/functions.php";
  //d_var_dump($data);
  login($data['username'], $data['password']);
});

ZRoute::get("/registrazione", function ($data){
  LoginView::get("registrazione", ["get" => $data]);
}, "registrazione");

ZRoute::post("/registrazione", function ($data){
  include "/assets/php/functions.php";
  //d_var_dump($data);
  registrazione($data['username'], $data['pw']);
});



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

ZRoute::post("/getMessage", function ($data){
  $m = API::getMessageFrom($data['id']);
  for($i = 0; $i < sizeof($m); $i++){
    echo (new Message($m[$i]))->getHtml();
  }
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
