<?php

	//ricezione in GET -> ?user_id=1

	$j = array(); //array associativo di risposta

	if (isset($_GET['user_id']) && !empty($_GET['user_id'])){
		//parametro arrivato
		$id = $_GET['user_id']; //input ID
		$conn = new mysqli('localhost', 'root', '', 'geekchat'); //connessione DB
		$sql = "SELECT * FROM utenti WHERE id = $id"; //query selezione utente

		$result = $conn->query($sql); //esecuzione query
		$data = $result->fetch_assoc(); //da obj a arr associativo
		if($result->num_rows == 0){
			//no user found
			$j['error'] = true;
			$j['errorMSG'] = "Non esistono utenti con questo ID";
		}
		else {
			//utente trovato -> assegnazione dati
			$j['username'] = $data['username'];
			$j['isAdmin'] = $data['isAdmin'];
			$j['bio'] = $data['bio'];
			$j['immagine'] = $data['immagine'];
			$j['lastAccess'] = $data['lastAccess'];
			$j['error'] = false;
		}
	}
	else {
		//manca il parametro
		$j['error'] = true;
		$j['errorMSG'] = "Nessun ID rilevato";
	}

	$j = json_encode($j); //da array a JSON
	echo $j; //ggwp ez

?>