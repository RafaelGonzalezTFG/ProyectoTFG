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
use modelo\Cuentas;

//Añadimos el código del modelo
require_once("../model/cuentas.php");
require_once("../model/utils.php");
//Comprobamos que los datos no esten vacios
if (
    isset($_POST["nombre"]) && isset($_POST["apellido"]) && isset($_POST["telefono"]) && isset($_POST["correo"])
    && isset($_POST["contrasena"]) && isset($_POST["rol"])
) {
    //Creamos un array con los usuarios
    $usuario = [
        "Nombre" => $_POST["nombre"],
        "Apellido" => $_POST["apellido"],
        "Telefono" => $_POST["telefono"]
    ];
    
    //Creamos un array con la cuenta
    $cuenta = [
        "Contrasena" => $_POST["contrasena"],
        "Correo" => $_POST["correo"],
        "Rol" => $_POST["rol"],
        "Estado" => "Activo",
        "CodigoActivacion" => 111111,
        "Activado" => 1,
    ];

    //Mensaje
    $mensaje = "";

    //Creamos un objeto cuenta con su conexion
    $gestorCuenta = new Cuentas();
    $conexPDO = Utils::conectar();

    //Verificamos que el correo no este registrado ya
    if ($gestorCuenta->verificarCorreo($conexPDO, $cuenta["Correo"])) {
        $mensaje = "El correo electrónico que ha introducido ya está registrado";
        include("../views/insertar_usuario_vista.php");
        exit;
    } else {

        //Insertamos la cuenta y al usuario
        $resultado = $gestorCuenta->insertarCuentaUsuario($conexPDO, $usuario, $cuenta);

        //Gestion de mensajes
        if ($resultado) {
            $mensaje = "Se ha añadido el nuevo usuario con éxito";
        } else {
            $mensaje = "Se ha producido un error, se cancela la introducción del nuevo usuario";
        }

        //Recolectamos los datos de las cuentas
        $datosCuentas = $gestorCuenta->obtenerTodasCuentasUsuarios($conexPDO);

        //Paginacion
        $totalProductos = $gestorCuenta->obtenerTodasCuentasUsuarios($conexPDO);
        $itemsPorPagina = 10;
        $totalPaginas = ceil(count($totalProductos) / $itemsPorPagina);


        if (isset($_POST['Pag'])) {
            $paginaActual = $_POST['Pag'];
            if ($paginaActual < 1 || $paginaActual > $totalPaginas) {
                $paginaActual = 1;
            }
        } else {
            $paginaActual = 1;
        }

        try {
            $datosCuentas = $gestorCuenta->getCuentasPag($conexPDO, true, "idCuentas", $paginaActual, $itemsPorPagina);
            include("../views/mostrar_usuarios_vista.php");
        } catch (\Throwable $th) {
            print("Error al pintar los Datos" . $th->getMessage());
        }
    }
}
