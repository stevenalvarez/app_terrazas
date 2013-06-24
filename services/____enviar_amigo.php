<?php
include 'config.php';
include 'functions.php';

error_reporting(E_ALL);
ini_set("display_errors", 0);

//Enviamos el mail
$envio = enviar_mail($_POST['name'], $_POST['email'], "Ven y conoce el Restaurante las Terrazas", $_POST['comentario']);

if($envio === true){
    echo "Se ha enviado con exito la invitacion!!!";
}else{
    echo "Ha ocurrido un error no se ha podido enviar la invitacion, intentelo de nuevo por favor!!!.";
}

?>