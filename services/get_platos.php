<?php
include 'config.php';
include 'functions.php';

header ('Content-type: text/html; charset=ISO-8859-1');

$sql = "SELECT `Plato`.`id`, `Plato`.`nombre`, `Plato`.`nombre_eng`, `Plato`.`tipo_plato`, `Plato`.`descripcion`, `Plato`.`descripcion_eng`, `Plato`.`precio` FROM `platos` AS `Plato` WHERE `Plato`.`tipo_plato` =:tipo_plato";

try {
	$dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$stmt = $dbh->prepare($sql);
	$stmt->bindParam("tipo_plato", $_GET['tipo_plato']);
	$stmt->execute();
    
	$platos = $stmt->fetchAll(PDO::FETCH_OBJ);
    $tipo_plato = $_GET['tipo_plato'];
    $tipo_plato_text = obtener_plato($tipo_plato);
    
    if(!empty($platos) && is_array($platos)){
        foreach($platos as $key => $plato){
            $platos[$key]->nombre = htmlentities($plato->nombre);
            $platos[$key]->nombre_eng = htmlentities($plato->nombre_eng);
            $platos[$key]->descripcion = htmlentities(str_replace("&nbsp;", "",$plato->descripcion));
            $platos[$key]->descripcion_eng = htmlentities(str_replace("&nbsp;", "",$plato->descripcion_eng));
        }
    }
    
	$dbh = null;
	echo '{"items":'. json_encode($platos) .',"tipo_plato":'.json_encode($tipo_plato).',"tipo_plato_text":'.json_encode($tipo_plato_text).'}';
} catch(PDOException $e) {
	echo '{"error":{"text":'. $e->getMessage() .'}}';
}

?>