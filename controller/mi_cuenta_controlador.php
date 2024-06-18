<?php
//Creamos session si no esta creada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

//Importamos las clases necesarias
use modelo\Utils;
use modelo\Cuentas;
//Se guardan en variables en caso de ser necesarias
$idCuentap = isset($_SESSION["idCuentas"]) ? $_SESSION["idCuentas"] : null;
$rolp = isset($_SESSION["Rol"]) ? $_SESSION["Rol"] : null;
//Comprobamos la id, si esta vacio o es null, enviara directamente al loguin
if (isset($idCuentap) && $idCuentap != null) {
    //Añadimos el código del modelo
    require_once("../model/utils.php");
    require_once("../model/cuentas.php");

    //Objeto cuenta
    $gestorCuenta = new Cuentas();
    $conexPDO = Utils::conectar();

    //Obtenemos los datos del usuario
    $datosCuenta = $gestorCuenta->obtenerCuentaUsuario($conexPDO, $idCuentap);

    //Enviamos a mi cuenta
    include("../views/mi_cuenta_vista.php");
} else {
    //Enviamos al loguin
    include("../controller/loguear_usuario_controlador.php");
}
