<?php
include 'config.php';
include 'functions.php';

header ('Content-type: text/html; charset=ISO-8859-1');

$sql = "SELECT `Menu`.`id`, `Menu`.`categoria_menu`, `Menu`.`nombre`, `Menu`.`precio`, `Menu`.`descripcion`, `Menu`.`pdf` FROM `menus` AS `Menu` WHERE `Menu`.`tipo_menu` = 'grupo' AND `Menu`.`categoria_menu` =:categoria_menu";

try {
	$dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$stmt = $dbh->prepare($sql);
	$stmt->bindParam("categoria_menu", $_GET['categoria_menu']);
	$stmt->execute();
    
	$menus = $stmt->fetchAll(PDO::FETCH_OBJ);
    if(!empty($menus) && is_array($menus)){
        foreach($menus as $key => $menu){
            $menus[$key]->nombre = htmlentities($menu->nombre);
            $menus[$key]->descripcion = htmlentities($menu->descripcion);
        }
    }
    
    $categoria_nombre = ucfirst($_GET['categoria_menu']);
    
	$dbh = null;
	echo '{"items":'. json_encode($menus) .',"categoria_nombre":'.json_encode($categoria_nombre).'}';
} catch(PDOException $e) {
	echo '{"error":{"text":'. $e->getMessage() .'}}';
}

?>