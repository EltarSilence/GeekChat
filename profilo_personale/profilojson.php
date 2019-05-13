<?php
	if (isset ($_GET['utente'])){
		require "config.php";
		$sql = "select bio, username, immagine, password, isAdmin from utenti where id=".$_GET['utente'];
		$result=$conn->query($sql);
		$row = $result->fetch_assoc();
		$output['username']=$row['username'];
		$output['biografia']=$row['bio'];
		$output['img']=$row['immagine'];
		$output['password']=$row['password'];
		$output['isAdmin']=$row['isAdmin'];
		echo json_encode([$output]);
	}
?>