<?php
include 'config.php';
include 'functions.php';

header ('Content-type: text/html; charset=ISO-8859-1');

$sql = "SELECT `CategoriaVinos`.`id`, `CategoriaVinos`.`nombre` FROM `categorias` AS `CategoriaVinos`";

try {
	$dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$stmt = $dbh->query($sql);  
	$categorias_vinos = $stmt->fetchAll(PDO::FETCH_OBJ);
    
    if(!empty($categorias_vinos)){
        foreach($categorias_vinos as $key => $categoria_vino){
            $categorias_vinos[$key]->nombre = htmlentities($categoria_vino->nombre);
        }
    }
    
	$dbh = null;
	echo '{"items":'. json_encode($categorias_vinos) .'}'; 
} catch(PDOException $e) {
	echo '{"error":{"text":'. $e->getMessage() .'}}'; 
}


?>