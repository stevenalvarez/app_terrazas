<?php
include 'config.php';
include 'functions.php';

header ('Content-type: text/html; charset=ISO-8859-1');

$sql = "SELECT `Foto`.`nombre`, `Foto`.`url` FROM `fotos` AS `Foto` WHERE `Foto`.`id` =:id LIMIT 1";

try {
	$dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);	
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$stmt = $dbh->prepare($sql);
	$stmt->bindParam("id", $_GET['id']);
	$stmt->execute();
	$foto = $stmt->fetchObject();
    
	$dbh = null;
	echo '{"item":'. json_encode($foto) .'}';
} catch(PDOException $e) {
	echo '{"error":{"text":'. $e->getMessage() .'}}'; 
}

?>