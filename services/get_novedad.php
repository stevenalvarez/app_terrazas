<?php
include 'config.php';
include 'functions.php';

header ('Content-type: text/html; charset=ISO-8859-1');

$sql = "SELECT `Novedad`.`nombre`, `Novedad`.`descripcion`, `Novedad`.`imagen`, `Novedad`.`pdf`, `Novedad`.`fechahora` FROM `novedades` AS `Novedad` WHERE `Novedad`.`id` =:id LIMIT 1";

try {
	$dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);	
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$stmt = $dbh->prepare($sql);
	$stmt->bindParam("id", $_GET['id']);
	$stmt->execute();
	$novedad = $stmt->fetchObject();
    
    if(!empty($novedad)){
        $novedad->nombre = htmlentities($novedad->nombre);
        $novedad->descripcion = htmlentities(str_replace("&nbsp;", "",$novedad->descripcion));
    }
    
	$dbh = null;
	echo '{"item":'. json_encode($novedad) .'}';
} catch(PDOException $e) {
	echo '{"error":{"text":'. $e->getMessage() .'}}'; 
}

?>