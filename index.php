<?php
require_once '../projects/autoloader.php';

ZRoute::get("/", function (){
  echo "Questa è la route della homepage";
}, "homepage");


/*           CHIAMATE AJAX            */
ZRoute::post("/show_my_profile", function (){
  //Qui ci va lo script che deve essere esguito quando si fa una chiamata AJAX per mostrare il mio profilo
}, "my_profile");


ZRoute::listen();

?>
