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

//Conexion
$conexPDO = Utils::conectar();
//Objeto productos
$gestorProducto = new Productos();

//Recolectamos los datos de los Productos y si lo llamamos con el filtro hacemos una consulta por categoria
if (isset($_POST['Categoria']) && $_POST['Categoria'] != "Todo") {
    $categoria = $_POST['Categoria'];
    $datosProductos = $gestorProducto->obtenerProductosPorCategoria($conexPDO, $categoria);
    // Paginación
    $totalProductos = $gestorProducto->obtenerProductosPorCategoria($conexPDO, $categoria);
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
        $datosProductos = $gestorProducto->getProductosCategoriasPag($conexPDO, $categoria, true, "idProductos", $paginaActual, $itemsPorPagina);
        include("../views/tienda_vista.php");
    } catch (\Throwable $th) {
        print("Error al pintar los Datos" . $th->getMessage());
    }
} else {
    $datosProductos = $gestorProducto->obtenerTodosProductos($conexPDO);
    // Paginación
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
        include("../views/tienda_vista.php");
    } catch (\Throwable $th) {
        print("Error al pintar los Datos" . $th->getMessage());
    }
}
