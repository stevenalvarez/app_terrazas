<?php
include 'config.php';
include 'functions.php';

error_reporting(E_ALL);
ini_set("display_errors", 0);

//Enviamos el mail
$envio = enviar_contacto($_POST['name'], $_POST['phone'], $_POST['email'], $_POST['mensaje']);

if($envio === true){
    echo "Su mensaje se ha enviado con exito, pronto responderemos. Estamos encantados de atenderle!!!";
}else{
    echo "Ha ocurrido un error no se ha podido enviar el formulario, intentelo de nuevo por favor!!!.";
}

?>