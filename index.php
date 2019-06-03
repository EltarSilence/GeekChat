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
  if (isset($_SESSION['id']))
    redirect("chat");
  else
    redirect("login");
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

ZRoute::get("/logout", function (){
  $_SESSION['id']=null;
  $_SESSION['username']=null;
  $_SESSION['isAdmin']=null;
  session_destroy();
  redirect("login");
}, "logout");





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
  $r = [];
  for($i = 0; $i < sizeof($m); $i++){
    $r[$m[$i]['id']] =(new Message($m[$i]))->getHtml();
  }
  header('Content-type: apllication/json');
  echo json_encode($r);
});

ZRoute::post("/modifyProfile", function($data){
  if(isset($data['bio'], $_SESSION['id'])){
    if(Controller::editDescrizione($_SESSION['id'], $data['bio'])){
    }else{
      http_response_code(500);
      die();
    }
  }
  if(isset($data['_FILES']['image']['name'])){
    $n = "images/profile/". date("Ymdhis")."z.".strtolower(end(explode('.',$data['_FILES']['image']['name'])));
    if(move_uploaded_file($data['_FILES']["image"]["tmp_name"], $n)){
      $m = new mysqli(
        ZConfig::config("DB_HOST", "localhost"),
        ZConfig::config("DB_USER", "root"),
        ZConfig::config("DB_PASSWORD", ""),
        ZConfig::config("DB_DATABASE", "geekchat")
      );
      $sql = 'UPDATE utenti SET immagine="'.$n.'" WHERE id ='.$_SESSION['id'];
      if($m->query($sql)){
        die();
      }else{
        http_response_code(500);
        die();
      }
    }else{
      http_response_code(500);
      die();
    }
  }
  die();
});

ZRoute::listen();

?>
