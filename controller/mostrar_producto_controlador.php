<?php
//Creamos session si no esta creada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
//Se guardan en variables en caso de ser necesarias
$idCuentap = isset($_SESSION["idCuentas"]) ? $_SESSION["idCuentas"] : null;
$rolp = isset($_SESSION["Rol"]) ? $_SESSION["Rol"] : null;

//Importamos las clases necesarias
use \modelo\Productos;
use \modelo\Utils;

//Añadimos el código del modelo
require_once("../model/productos.php");
require_once("../model/utils.php");

//Variables
$mensaje = null;
//Objeto PDO de conexion
$conexPDO = Utils::conectar();
//Objeto que gestionara los metodos del Producto_Model.php
$gestorProducto = new Productos();

//Recolectamos los datos de los Productos
$datosProductos = $gestorProducto->obtenerTodosProductos($conexPDO);

//Paginacion
$totalProductos = $gestorProducto->obtenerTodosProductos($conexPDO);
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
    $datosProductos = $gestorProducto->getProductosPag($conexPDO, true, "idProductos", $paginaActual, $itemsPorPagina);
    include("../views/mostrar_productos_vista.php");
} catch (\Throwable $th) {
    print("Error al pintar los Datos" . $th->getMessage());
}
