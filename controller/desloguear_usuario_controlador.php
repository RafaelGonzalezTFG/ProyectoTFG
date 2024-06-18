<?php
//Creamos session si no esta creada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

session_unset(); //Libera todas las variables de sesión
session_destroy(); //Destruye la sesión
//Devolvemos a la pagina principal
include("../controller/main_controlador.php");