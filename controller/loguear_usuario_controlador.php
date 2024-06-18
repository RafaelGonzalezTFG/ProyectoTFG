<?php
//Creamos session si no esta creada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
//Importamos las clases necesarias
use modelo\Utils;
use modelo\Cuentas;

//Añadimos el código del modelo
require_once("../model/utils.php");
require_once("../model/cuentas.php");

// Verificar si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['Correo']) && isset($_POST['Contrasena'])) {
        //Creamos un array para la cuenta con los datos limpiados
        $cuenta = array();
        $cuenta['Correo'] = Utils::limpiar_datos($_POST['Correo']);
        $cuenta['Contrasena'] = Utils::limpiar_datos($_POST['Contrasena']);

        //Creamos un objeto cuenta y su conexion
        $gestorCuenta = new Cuentas();
        $conexPDO = Utils::conectar();

        //Obtenemos la contraseña encriptada de la base de datos
        $datosCuenta = $gestorCuenta->obtenerCuentaPorCorreo($conexPDO, $cuenta['Correo']);
        if ($datosCuenta && is_array($datosCuenta)) {
            if (password_verify($cuenta['Contrasena'], $datosCuenta['Contrasena'])) {
                //Controlamos si esta la cuenta activa, incativa o baneada
                switch ($datosCuenta['Estado']) {
                    case "Activo":
                        $_SESSION["idCuentas"] = $datosCuenta["idCuentas"];
                        $_SESSION["Rol"] = $datosCuenta["Rol"];
                        include("../controller/main_controlador.php");
                        break;
                    case "Inactivo":
                        include("../controller/activar_codigo_controlador.php");
                        break;
                    case "Baneado":
                        include("../views/baneado.php");
                        break;
                }
            } else {
                //Errores al verificar
                echo 'Usuario o contraseña incorrectos';
                include '../views/login_vista.php';
                exit;
            }
        } else {
            //Errores al comprobar el array
            echo 'Usuario o contraseña incorrectos';
            include '../views/login_vista.php';
            exit;
        }
    }
} else {
    include "../views/login_vista.php";
}
