<?php
//Creamos session si no esta creada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
//Se guardan en variables en caso de ser necesarias
$idCuentap = isset($_SESSION["idCuentas"]) ? $_SESSION["idCuentas"] : null;
$rolp = isset($_SESSION["Rol"]) ? $_SESSION["Rol"] : null;
//Importamos las clases necesarias
use modelo\Utils;
//Añadimos el código del modelo
require_once("../model/utils.php");

//Comprobamos los datos que nos envia el formulario
if(isset($_POST["nombre"]) && isset($_POST["apellido"]) && isset($_POST["correo"]) && isset($_POST["motivo"])){
    //Los guardamos en un array
    $contactos = [
        "nombre" => $_POST["nombre"],
        "apellido" => $_POST["apellido"],
        "correo" => $_POST["correo"],
        "motivo" => $_POST["motivo"]
    ];

    //Conexion
    $conexPDO = Utils::conectar();

    //Enviamos el correo al dueño de la pagina
    $envioCorreo = Utils::enviarContactos($contactos);
        //Comprobamos que se ha enviado y enviamos un mensaje en consecuencia
        if ($envioCorreo) {
            $_SESSION["mensaje"] = "Se ha enviado el mensaje, recibirá una respuesta en unos días, gracias por su tiempo.";
            include("../views/contactos_vista.php");
        } else {
            $_SESSION["mensaje"] = "Se produjo un error a la hora de enviar el mensaje, intentelo más tarde";
            include("../views/contactos_vista.php");
        }

} else {
    include("../views/contactos_vista.php");
}