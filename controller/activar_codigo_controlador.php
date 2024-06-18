<?php
//Creamos session si no esta creada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
//Se guardan en variables en caso de ser necesarias
$idCuentap = isset($_SESSION["idCuentas"]) ? $_SESSION["idCuentas"] : null;
$rolp = isset($_SESSION["Rol"]) ? $_SESSION["Rol"] : null;

//Importamos las clases necesarias
use \modelo\Utils;
use \modelo\Cuentas;

//Añadimos el código del modelo
require_once("../model/utils.php");
require_once("../model/cuentas.php");

//Comprobamos que el correo y el codigo vienen llenos
if (isset($_POST["Correo"]) && isset($_POST["CodigoActivacion"])) {
    //Creamos un array para la cuenta
    $cuenta = array();

    $cuenta["Correo"] = Utils::limpiar_datos($_POST['Correo']);
    $cuenta["CodigoActivacion"] = Utils::limpiar_datos($_POST['CodigoActivacion']);
    
    //Creamos un objeto
    $gestorCuenta = new Cuentas();

    //Nos conectamos a la Base de Datos
    $conexPDO = Utils::conectar();
    //Activamos nuestra cuenta
    $resultado = $gestorCuenta->verificarCodigoActivacion($conexPDO, $cuenta["Correo"], $cuenta["CodigoActivacion"]);
    // Verificar el código de activación
    if ($resultado === true) {
        // Código de activación válido
        include("../controller/loguear_usuario_controlador.php");
    } else {
        //En caso de meter un codigo de activacion erroneo, salta el mensaje
        $_SESSION['error_message'] = "Se ha introducido un código de activación invalida, por favor compruebe nuevamente su correo";
    }
} else {
    //Incluimos la vista en caso de que no sea el formulario el que llame al controlador
    include("../views/activar_codigo_vista.php");
}