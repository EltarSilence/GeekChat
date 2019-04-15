<?php
require_once 'Zexarel/loader.php';

ZRoute::get("/", function (){
  redirect("home");
});

ZRoute::get("/home", function (){
  echo "Questa è la route della homepage";
}, "home");

/*           CHIAMATE AJAX            */
ZRoute::post("/show_my_profile", function (){
  //Qui ci va lo script che deve essere esguito quando si fa una chiamata AJAX per mostrare il mio profilo
}, "my_profile");

/*Chiamata per settare un nuovo username*/
ZRoute::post("/edit_username", function($data){

}, "edit_username");



ZRoute::listen();

?>
