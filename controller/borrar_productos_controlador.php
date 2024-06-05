<?php
// Importamos las clases necesarias
use modelo\Productos;
use modelo\Utils;

//Añadimos el código del modelo
require_once("../model/productos.php");
require_once("../model/utils.php");

$gestorProduct = new Productos();

//Conectamos con la base de datos
$conexPDO = Utils::conectar();

//Comprobamos que el post tiene datos
if (isset($_POST["idProductos"]))
{
    //Eliminamos el producto mediante su id y guardamos el resultado
    $resultado = $gestorProduct->eliminarProducto($_POST["idProductos"],$conexPDO);

    ////En caso de que ocurra un problema a la hora de borrar el producto guardamos un mensaje de error
    if ($resultado==null || $resultado==0)
    {
        $mensaje="Se ha producido un error a la hora de borrar el producto deseado";
    }
    else
    {
        $mensaje="Se ha eliminado el producto con éxito";
    }


}


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
    $datosProductos = $gestorProduct->getProductosPag($conexPDO, true, "idProductos", $paginaActual, $itemsPorPagina);
    include("../views/gestionar_productos_vista.php");
} catch (\Throwable $th) {
    print("Error al pintar los Datos" . $th->getMessage());
}
