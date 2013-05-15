<?php
include 'config.php';
include 'functions.php';

header ('Content-type: text/html; charset=ISO-8859-1');

$sql = "SELECT `Novedade`.`id`, `Novedade`.`nombre`, `Novedade`.`descripcion`, `Novedade`.`imagen`, DATE_FORMAT(`Novedade`.`fechahora`,'%d/%m/%Y') as fecha FROM `novedades` AS `Novedade` LEFT JOIN `restaurants` AS `Restaurant` ON (`Novedade`.`restaurant_id` = `Restaurant`.`id`) ORDER BY `Novedade`.`fechahora` desc LIMIT 20";

try {
	$dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);	
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$stmt = $dbh->query($sql);  
	$novedades = $stmt->fetchAll(PDO::FETCH_OBJ);
    
    if(!empty($novedades)){
        foreach($novedades as $key => $novedad){
            $descripcion = $novedad->descripcion;
            $novedades[$key]->descripcion = htmlentities($descripcion);
            $descripcion = str_replace("&nbsp;", "",strip_tags($descripcion, '<em>'));
            $novedades[$key]->descripcion_cut =  strlen($descripcion) > 120? htmlentities(substr($descripcion,0,strrpos(substr($descripcion,0,120)," "))) ." ..." : htmlentities($descripcion);
        }
    }
    
	$dbh = null;
	echo '{"items":'. json_encode($novedades) .'}'; 
} catch(PDOException $e) {
	echo '{"error":{"text":'. $e->getMessage() .'}}'; 
}


?>