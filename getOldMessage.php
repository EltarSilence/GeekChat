<?php
header("Content-type: application/json");
$mysqli = new mysqli("localhost", "root", "", "geekchat");
if($mysqli->connect_errno){
	die();
}
$id = isset($_GET['id']) ? $_GET['id'] : 0;

$result = $mysqli->query("SELECT m.id, m.testo, m.dataOraInvio, m.idReply, u.id AS idUtente, u.username, mi.url AS immagine, ma.url AS audio, ml.url AS link, md.url AS documento, mp.lat, mp.lon
FROM messaggi AS m
	INNER JOIN utenti AS u ON u.id = m.idUtente
	LEFT JOIN immagini AS mi ON mi.idMessaggio = m.id
	LEFT JOIN audio AS ma ON ma.idMessaggio = m.id
	LEFT JOIN posizioni AS mp ON mp.idMessaggio = m.id
	LEFT JOIN links AS ml ON ml.idMessaggio = m.id
	LEFT JOIN documenti AS md ON md.idMessaggio = m.id
WHERE m.id >= ".$id);
$ret = [];
while($row = $result->fetch_assoc()){
	$a = [];
	$a['id'] = $row['id'];
	$a['testo'] = $row['testo'];
	$a['dataOraInvio'] = $row['dataOraInvio'];
	$a['idUtente'] = $row['idUtente'];
	$a['username'] = $row['username'];
	$b = [];
	$b['type'] = isset($row['immagine']) ? "immagine" :
		isset($row['audio']) ? "audio" :
		isset($row['link']) ? "link" :
		isset($row['documento']) ? "documento" :
		isset($row['lat'], $row['lon']) ? "posizione" : null;

	if(isset($b['type'])){
		switch($b['type']){
			case "immagine":
			case "audio":
			case "link":
			case "documento":
				$b['url'] = $row[$b['type']];
				break;
			case "posizione":
				$b['lat'] = $row['lat'];
				$b['lon'] = $row['lon'];
				break;
		}
	}
	$a['content'] = $b;

	$c = [];
	if(isset($row['idReply'])){
		$res =$mysqli->query("SELECT m.id, m.testo, u.username, mi.url AS immagine, ma.url AS audio, ml.url AS link, md.url AS documento, mp.lat, mp.lon
			FROM messaggi AS m
				INNER JOIN utenti AS u ON u.id = m.idUtente
				LEFT JOIN immagini AS mi ON mi.idMessaggio = m.id
				LEFT JOIN audio AS ma ON ma.idMessaggio = m.id
				LEFT JOIN posizioni AS mp ON mp.idMessaggio = m.id
				LEFT JOIN links AS ml ON ml.idMessaggio = m.id
				LEFT JOIN documenti AS md ON md.idMessaggio = m.id
			WHERE m.id >= ".$row['idReply']);
		$r = $res->fetch_assoc();

		$c['id'] = $r['id'];
		$c['testo'] = $r['testo'];
		$c['username'] = $r['username'];

		$b = [];
		$b['type'] = isset($r['immagine']) ? "immagine" :
			isset($r['audio']) ? "audio" :
			isset($r['link']) ? "link" :
			isset($r['documento']) ? "documento" :
			isset($r['lat'], $r['lon']) ? "posizione" : null;

		if(isset($b['type'])){
			switch($b['type']){
				case "immagine":
				case "audio":
				case "link":
				case "documento":
					$b['url'] = $r[$b['type']];
					break;
				case "posizione":
					$b['lat'] = $r['lat'];
					$b['lon'] = $r['lon'];
					break;
			}
		}
		$c['content'] = $b;
	}
	if(sizeof($c) == 0){
		$c = null;
	}
	$a['reply'] = $c;
	$ret[] = $a;
}
echo json_encode($ret, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
?>
