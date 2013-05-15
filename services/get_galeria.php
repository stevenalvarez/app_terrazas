<?php
include 'config.php';
include 'functions.php';

header ('Content-type: text/html; charset=ISO-8859-1');

$sql = "SELECT `Foto`.`id`, `Foto`.`url` FROM `fotos` AS `Foto` WHERE `Foto`.`fotos_galeria_id` =:galeria_id ORDER BY `Foto`.`id` desc LIMIT 20";

try {
	$dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);	
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$stmt = $dbh->prepare($sql);
	$stmt->bindParam("galeria_id", $_GET['galeria_id']);
	$stmt->execute();  
	$fotos_galeria = $stmt->fetchAll(PDO::FETCH_OBJ);
	$dbh = null;
	echo '{"items":'. json_encode($fotos_galeria) .'}'; 
} catch(PDOException $e) {
	echo '{"error":{"text":'. $e->getMessage() .'}}'; 
}

?>