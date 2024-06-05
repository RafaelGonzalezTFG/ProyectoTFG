<?php
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
$gestorProduct = new Productos();

//Recolectamos los datos de los Productos
$datosProductos = $gestorProduct -> obtenerTodosProductos($conexPDO);

//Paginacion
$totalProductos = $gestorProduct->obtenerTodosProductos($conexPDO);
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
    $datosProductos = $gestorProduct->getProductosPag($conexPDO, true,"idProductos", $paginaActual, $itemsPorPagina);
    var_dump($datosProductos);
    include("../views/gestionar_productos_vista.php");
} catch (\Throwable $th) {
    print("Error al pintar los Datos" . $th->getMessage());
}