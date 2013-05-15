<?php
include 'config.php';
include 'functions.php';

header ('Content-type: text/html; charset=ISO-8859-1');

$sql = "SELECT `Vino`.`id`, `Vino`.`nombre`, `Vino`.`precio`, `Categoria`.`id` as categoria_id, `Categoria`.`nombre` as categoria_nombre FROM `vinos` AS `Vino` LEFT JOIN `categorias` AS `Categoria` ON (`Vino`.`categoria_id` = `Categoria`.`id`) WHERE `Vino`.`categoria_id`=:id";

try {
	$dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$stmt = $dbh->prepare($sql);
	$stmt->bindParam("id", $_GET['id']);
	$stmt->execute();
    
	$vinos = $stmt->fetchAll(PDO::FETCH_OBJ);
    if(!empty($vinos) && is_array($vinos)){
        foreach($vinos as $key => $vino){
            $vinos[$key]->nombre = htmlentities($vino->nombre);
            $vinos[$key]->categoria_nombre = htmlentities($vino->categoria_nombre);
        }
    }
    
    $categoria_nombre = ucfirst(strtolower($vinos[0]->categoria_nombre));
    $clase = str_replace(" ", "_",strtolower($vinos[0]->categoria_nombre));
    
	$dbh = null;
	echo '{"items":'. json_encode($vinos) .',"categoria_nombre":'.json_encode($categoria_nombre).',"clase":'.json_encode($clase).'}';
} catch(PDOException $e) {
	echo '{"error":{"text":'. $e->getMessage() .'}}';
}

?>