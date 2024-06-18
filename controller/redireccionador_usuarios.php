<?php
//Creamos session si no esta creada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
//Se guardan en variables en caso de ser necesarias
$idCuentap = isset($_SESSION["idCuentas"]) ? $_SESSION["idCuentas"] : null;
$rolp = isset($_SESSION["Rol"]) ? $_SESSION["Rol"] : null;
//Importamos las clases necesarias
use \modelo\Cuentas;
use \modelo\Utils;
//Añadimos el código del modelo
require_once("../model/cuentas.php");
require_once("../model/utils.php");
//Comprobamos si llamamos para insertar o modificar
if (isset($_POST["insertar"]) && $_POST["insertar"] == "true") {
    include("../views/insertar_usuario_vista.php");
} elseif (isset($_POST["modificar"]) && $_POST["modificar"] == "true") {
    //Conexion y obejto cuenta
    $conexPDO = Utils::conectar();
    $gestorCuenta = new Cuentas();

    //Obtenemos los datos de la cuenta en caso de que el id sea correcto
    if (isset($_POST["idCuentas"]) && !empty($_POST["idCuentas"])) {
        $datosCuenta = $gestorCuenta->obtenerCuentaUsuario($conexPDO, $_POST["idCuentas"]);

        if ($datosCuenta) {
            include("../views/modificar_usuario_vista.php");
        } else {
            echo "Error: No se encontraron datos para el ID de cuenta proporcionado.";
        }
    } else {
        echo "Error: El ID de cuenta es obligatorio para modificar.";
    }
}
?>
