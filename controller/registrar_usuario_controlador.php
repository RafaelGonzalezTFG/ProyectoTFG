<?php
session_start();

//Se guardan en variables en caso de ser necesarias
$idCuentap = isset($_SESSION["idCuentas"]) ? $_SESSION["idCuentas"] : null;
$rolp = isset($_SESSION["Rol"]) ? $_SESSION["Rol"] : null;

// Importamos las clases necesarias
use modelo\Usuarios;
use modelo\Utils;
use modelo\Cuentas;

use function Composer\Autoload\includeFile;

// Añadimos el código del modelo
require_once("../model/usuarios.php");
require_once("../model/utils.php");
require_once("../model/cuentas.php");

//Comprobamos los datos que provienen del formulario
if (isset($_POST["Nombre"]) && isset($_POST["Apellido"]) && isset($_POST["Telefono"]) && isset($_POST["Correo"]) && isset($_POST["Contrasena"])) {
    //Creamos un array de usuario y cuenta
    $usuario = array();
    $cuenta = array();

    //Limpiamos los datos
    $usuario["Nombre"] = Utils::limpiar_datos($_POST['Nombre']);
    $usuario["Apellido"] = Utils::limpiar_datos($_POST['Apellido']);
    $usuario["Telefono"] = Utils::limpiar_datos($_POST['Telefono']);

    $cuenta["Correo"] = Utils::limpiar_datos($_POST['Correo']);
    $cuenta["Contrasena"] = Utils::limpiar_datos($_POST['Contrasena']); // Limpieza de datos sin encriptar aquí

    //Creamos los objetos que necesitamos
    $gestorUsuarios = new Usuarios();
    $gestorCuentas = new Cuentas();
    $conexPDO = Utils::conectar();

    //Comprobamos que si el correo ya estaba registrado
    if ($gestorCuentas->verificarCorreo($conexPDO, $cuenta["Correo"])) {
        $_SESSION['message'] = "El correo electrónico que ha introducido ya está registrado";
        $_SESSION['message_type'] = "danger";
        include("../views/registro_vista.php");
        exit;
    }

    //Registramos al usuario
    $resultado = $gestorUsuarios->registrarUsuario($conexPDO, $usuario["Nombre"], $usuario["Apellido"], $usuario["Telefono"], $cuenta["Correo"], $cuenta["Contrasena"]);

    //Si se ha registrado, obtenemos el codigo que le hemos creado aleatoriamente y se lo enviamos a su correo
    if ($resultado === true) {
        $codigoActivacion = $gestorCuentas->obtenerCodigoActivacion($conexPDO, $cuenta["Correo"]);
        $envioCorreo = Utils::enviarCorreoActivacion($cuenta["Correo"], $codigoActivacion);
        if ($envioCorreo) {
            $_SESSION['message'] = "Registro exitoso. Se ha enviado un correo de activación a tu dirección de email.";
            $_SESSION['message_type'] = "success";
        } else {
            $_SESSION['message'] = "Ocurrió un error al enviar el correo de activación.";
            $_SESSION['message_type'] = "danger";
        }
    } else {
        $_SESSION['message'] = "Ocurrió un error durante el registro. Por favor, inténtalo de nuevo.";
        $_SESSION['message_type'] = "danger";
    }

    include("../views/registro_vista.php");
    exit;
} else {
    include("../views/registro_vista.php");
}
