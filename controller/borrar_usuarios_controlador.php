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

//Variables
$mensaje = null;
//Objeto PDO de conexion
$conexPDO = Utils::conectar();
//Objeto que gestionara los metodos del Producto_Model.php
$gestorCuenta = new Cuentas();

if (isset($_POST["idCuentas"])) {
    //Eliminamos el producto mediante su id y guardamos el resultado
    $resultado = $gestorCuenta->eliminarCuenta($conexPDO, $_POST["idCuentas"]);

    ////En caso de que ocurra un problema a la hora de borrar el al usuario y su cuenta
    if ($resultado == null || $resultado == 0) {
        $mensaje = "Se ha producido un error a la hora de borrar al usuario y su cuenta";
    } else {
        $mensaje = "Se ha eliminado al usuario y su cuenta con exito";
    }
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
    $datosCuentas = $gestorCuenta->getCuentasPag($conexPDO, true,"idCuentas", $paginaActual, $itemsPorPagina);
    include("../views/mostrar_usuarios_vista.php");
} catch (\Throwable $th) {
    print("Error al pintar los Datos" . $th->getMessage());
}
