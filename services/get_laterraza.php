<?php
include 'config.php';
include 'functions.php';

header ('Content-type: text/html; charset=ISO-8859-1');

$sql = "SELECT `Foto`.`id`, `Foto`.`nombre`, `Foto`.`descripcion`, `Foto`.`url`, `Foto`.`fechahora` FROM `fotos` AS `Foto` WHERE `Foto`.`fotos_galeria_id` = 2 ORDER BY `Foto`.`id` desc LIMIT 1";

try {
	$dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$stmt = $dbh->prepare($sql);
	$stmt->execute();
	$la_terraza = $stmt->fetchObject();
    $la_terraza->descripcion = htmlentities(str_replace("&nbsp;", "",$la_terraza->descripcion));
    $dbh = null;
	echo '{"item":'. json_encode($la_terraza) .'}';
} catch(PDOException $e) {
	echo '{"error":{"text":'. $e->getMessage() .'}}';
}

?>