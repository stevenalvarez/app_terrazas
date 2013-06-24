<?php
include 'config.php';
include 'functions.php';

header ('Content-type: text/html; charset=ISO-8859-1');

$sql = "SELECT Menu.tipo_menu, Menu.para_la_fecha, Menu.serializado, DAYNAME(Menu.para_la_fecha) as dia, MONTHNAME(Menu.para_la_fecha) as mes, curdate() as curdate FROM `menus` AS `Menu` LEFT JOIN `restaurants` AS `Restaurant` ON (`Menu`.`restaurant_id` = `Restaurant`.`id`) GROUP BY `Menu`.`id` HAVING curdate() = `Menu`.`para_la_fecha` LIMIT 1";

try {
	$dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$stmt = $dbh->prepare($sql);
	$stmt->execute();
	$menu_diario = $stmt->fetchObject();
    
    //Verificamos que tenga resultados
    $primeros = $segundos = $precio_descripcion = "";
    
    if(!empty($menu_diario)){
        
        $serializado = deserializar($menu_diario->serializado);
        
        if($menu_diario->tipo_menu == "diario"){
            
            $primeros = isset($serializado['primeros']) && !empty($serializado['primeros']) ? $serializado['primeros'] : "";
            $segundos = isset($serializado['segundos']) && !empty($serializado['segundos']) ? $serializado['segundos'] : "";
            $precio_descripcion = $serializado['precio_descripcion'];
            
            //Agregamos lo que estuvo en el serializado
            $menu_diario->primeros = htmlentities(str_replace("&nbsp;", "",strip_tags($primeros, "<p>")));
            $menu_diario->segundos = htmlentities(str_replace("&nbsp;", "",strip_tags($segundos, "<p>")));
            $menu_diario->precio_descripcion = $precio_descripcion;
        
        }else if($menu_diario->tipo_menu == "festivo"){
            $especialidades = isset($serializado['especialidades']) && !empty($serializado['especialidades']) ? $serializado['especialidades'] : "";
            $menu_diario->especialidades = $especialidades;
        }
        
        //Traducimos el dia
        $menu_diario->dia_spanish = htmlentities(obtener_dia($menu_diario->dia));
        $menu_diario->dia_numerico = date("d", strtotime($menu_diario->curdate));
        $menu_diario->mes_spanish = htmlentities(obtener_mes($menu_diario->mes));
    }
    
	$dbh = null;
	echo '{"item":'. json_encode($menu_diario) .'}'; 
} catch(PDOException $e) {
	echo '{"error":{"text":'. $e->getMessage() .'}}'; 
}

?>