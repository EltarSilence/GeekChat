<?php
/*
tramite la sessione ricevo l'id
eseguo la query 
*/
session_start();
$_SESSION['id']=1;
include '../config.php';
if (isset($_SESSION['id'])){
    //upload file e aggiornamento url nel database
    $sql = 'SELECT immagine from utenti where id = '.$_SESSION['id'];
    $result  = $mysqli-> query($sql);
    if($result->num_rows == 1){
        $row = $result->fetch_assoc();
        $ritorno = array();
        //inserisco l'immagine nel primo indice disponibile
        $ritorno [] =  $row['immagine'];
        $json= json_encode($ritorno);
        echo $json;
    }

}

    
?>
