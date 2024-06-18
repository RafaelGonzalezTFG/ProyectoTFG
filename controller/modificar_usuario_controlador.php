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

//Comprobamos todos los datos
if (
    isset($_POST["nombre"]) && isset($_POST["apellido"]) && isset($_POST["telefono"]) 
    && isset($_POST["correo"]) && isset($_POST["rol"]) && isset($_POST["estado"])
    && isset($_POST["idUsuarios"]) && !empty($_POST["idUsuarios"])
    && isset($_POST["idCuentas"]) && !empty($_POST["idCuentas"])
) {
    //Array de usuarios
    $usuario = [
        "Nombre" => $_POST["nombre"],
        "Apellido" => $_POST["apellido"],
        "Telefono" => $_POST["telefono"],
        "idUsuarios" => $_POST["idUsuarios"]
    ];

    //Array de cuentas
    $cuenta = [
        "Correo" => $_POST["correo"],
        "Rol" => $_POST["rol"],
        "Estado" => $_POST["estado"],
        "idCuentas" => $_POST["idCuentas"]
    ];

    //Mensajes
    $mensaje = "";

    //Creamos objeto para las cuentas
    $gestorCuenta = new Cuentas();
    $conexPDO = Utils::conectar();

    //Modificamos la cuenta y al usuario
    $resultado = $gestorCuenta->modificarCuentaUsuario($conexPDO, $usuario, $cuenta);

    //Gestinamos los mensajes
    if ($resultado) {
        $mensaje = "Se ha modificado al usuario con éxito";
    } else {
        $mensaje = "Se ha producido un error, se cancela la modificación del usuario";
    }

    // Recolectamos los datos de las cuentas
    $datosCuentas = $gestorCuenta->obtenerTodasCuentasUsuarios($conexPDO);

    // Paginacion
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
} else {
    echo "Error: Todos los campos son obligatorios, incluidas las IDs de usuario y cuenta.";
}
?>


