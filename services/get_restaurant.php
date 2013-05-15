<?php
include 'config.php';
include 'functions.php';

header ('Content-type: text/html; charset=ISO-8859-1');

$sql = "SELECT `Restaurant`.`id`, `Restaurant`.`nombre`, `Restaurant`.`horario_atencion`, `Restaurant`.`email_contacto`, `Restaurant`.`serializado`, `Restaurant`.`fechahora` FROM `restaurants` AS `Restaurant` WHERE `Restaurant`.`id` =:restaurant_id LIMIT 1";

try {
	$dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$stmt = $dbh->prepare($sql);
	$stmt->bindParam("restaurant_id", $_GET['restaurant_id']);
	$stmt->execute();
	$restaurant = $stmt->fetchObject();
    
    if(!empty($restaurant)){
        $restaurant->serializado = deserializar($restaurant->serializado);
        $restaurant->horario = $restaurant->serializado;
    }
    
	$dbh = null;
	echo '{"item":'. json_encode($restaurant) .'}';
} catch(PDOException $e) {
	echo '{"error":{"text":'. $e->getMessage() .'}}';
}

?>