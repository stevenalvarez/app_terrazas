<?php
include 'config.php';
include 'functions.php';

error_reporting(E_ALL);
ini_set("display_errors", 0);

//Enviamos el mail
$_POST['comentario'] = substr($_POST['comentario'], 0, strlen($_POST['comentario'])- 1);
$_POST['comentario'] = nl2br($_POST['comentario']);
$envio = enviar_mail($_POST['name'], $_POST['email'], "Invitación", $_POST['comentario']);

if($envio === true){
    echo "Se ha enviado con exito la invitacion!!!";
}else{
    echo "Ha ocurrido un error no se ha podido enviar la invitacion, intentelo de nuevo por favor!!!.";
}

?>