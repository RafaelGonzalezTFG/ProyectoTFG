<?php
//Importamos las clases necesarias
use \modelo\Usuarios;
use \modelo\Utils;
use \modelo\Cuentas;

//Añadimos el código del modelo
require_once("../model/usuarios.php");
require_once("../model/utils.php");
require_once("../model/cuentas.php");

if (isset($_POST["Nombre"]) && isset($_POST["Apellido"]) && isset($_POST["Telefono"]) && isset($_POST["Correo"]) && isset($_POST["Contrasena"])) {
    //Guardamos los datos que le enviamos para nuestro registro
    // Guardamos los datos que le vamos a pasar a la vista
    $usuario = array();
    $cuenta = array();

    $usuario["Nombre"] = Utils::limpiar_datos($_POST['Nombre']);
    $usuario["Apellido"] = Utils::limpiar_datos($_POST['Apellido']);
    $usuario["Telefono"] = Utils::limpiar_datos($_POST['Telefono']);

    $cuenta["Contrasena"] = Utils::limpiar_datos($_POST['Contrasena']);
    $cuenta["Correo"] = Utils::limpiar_datos($_POST['Correo']);

    //Añadimos un objeto Usuario
    $gestorUsuarios = new Usuarios();
    $gestorCuentas = new Cuentas();

    //Nos conectamos a la Base de Datos
    $conexPDO = Utils::conectar();
    
    //Antes de registrar el correo comprobamos que no existe uno igual en la base de datos
    if ($gestorCuentas->verificarCorreo($conexPDO, $cuenta["Correo"])) {
        echo "El correo electrónico que ha introducido ya está registrado";
        exit;
    }

    //Insertamos al usuario en la base de datos
    $resultado = $gestorUsuarios->registrarUsuario($conexPDO, $usuario["Nombre"], $usuario["Apellido"], $usuario["Telefono"], $cuenta["Correo"], $cuenta["Contrasena"]);

    if ($resultado === true) {
        //Recogemos el codigo de activacion de la cuenta del usuario
        $codigoActivacion = $gestorCuentas->obtenerCodigoActivacion($conexPDO, $cuenta["Correo"]);
        //Le enviamos un correo con la cuenta de el
        $envioCorreo = Utils::enviarCorreoActivacion($cuenta["Correo"], $codigoActivacion);
        if ($envioCorreo) {
            //En caso de ser exitoso en unos segundos le enviara el correo
            echo "Registro exitoso. Se ha enviado un correo de activación a tu dirección de email.";
        } else {
            //Aqui si algun problema ocurre durante el envio del correo de activacion
            echo "Ocurrió un error al enviar el correo de activación.";
        }
    } else {
        //Este mensaje saltara si ocurre un problema durante el registro
        echo "Ocurrió un error durante el registro. Por favor, inténtalo de nuevo.";
    }
}else {
    //Incluimos la vista en caso de que no sea el formulario el que llame al controlador
    include("../views/registrar_usuario_vista.php");
}