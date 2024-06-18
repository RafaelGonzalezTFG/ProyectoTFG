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
//Conexion
$conexPDO = Utils::conectar();
//Objeto que creamos de cuentas
$gestorCuenta = new Cuentas();

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
