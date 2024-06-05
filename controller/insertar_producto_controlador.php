<?php
// Importamos las clases necesarias

use modelo\Categorias;
use modelo\Productos;
use modelo\Proveedores;
use modelo\Utils;

//Añadimos el código del modelo
require_once("../model/productos.php");
require_once("../model/proveedores.php");
require_once("../model/categorias.php");
require_once("../model/utils.php");


// Inicialización de variables para controlar el flujo
$accion = "";  // 'insertar' es el valor predeterminado si 'accion' no está definido
$url = "../views/gestionar_productos_vista.php"; // URL predeterminada
$mensaje = "";

// Conexión con la base de datos
$gestorProveedor = new Proveedores();
$gestorCategoria = new Categorias();
$conexPDO = Utils::conectar();

if (!$conexPDO) {
    echo "Error al conectar con la base de datos.";
    $datosProveedores = []; // Asegura que la variable está definida incluso en caso de error
} else {
    // Recolectamos los datos de los proveedores
    $datosProveedores = $gestorProveedor->obtenerTodosProveedores($conexPDO);
}

if (!$conexPDO) {
    echo "Error al conectar con la base de datos.";
    $datosCategorias = []; // Asegura que la variable está definida incluso en caso de error
} else {
    // Recolectamos los datos de los proveedores
    $datosCategorias = $gestorCategoria->obtenerTodasCategorias($conexPDO);
}

if (
    isset($_POST["idProductos"]) && isset($_POST["Nombre"]) && isset($_POST["Descripcion"]) &&
    isset($_POST["Material"]) && isset($_POST["Precio"]) && isset($_POST["Stock"]) && isset($_POST["Imagen"])
    && isset($_POST["FechaAdquisicion"]) && isset($_POST["FechaCaducidad"]) && isset($_POST["Marca"]) && isset($_POST["Peso"])
    && isset($_POST["Proveedores"]) && isset($_POST["Categorias"])
) {
    $producto = array();
    $producto["idProductos"] = $_POST["idProductos"];
    $producto["Nombre"] = $_POST["Nombre"];
    $producto["Descripcion"] = $_POST["Descripcion"];
    $producto["Material"] = $_POST["Material"];
    $producto["Precio"] = $_POST["Precio"];
    $producto["Stock"] = $_POST["Stock"];
    $producto["Imagen"] = $_POST["Imagen"];
    $producto["FechaAdquisicion"] = $_POST["FechaAdquisicion"];
    $producto["FechaCaducidad"] = $_POST["FechaCaducidad"];
    $producto["Marca"] = $_POST["Marca"];
    $producto["Peso"] = $_POST["Peso"];

    $categorias = array();
    $categorias["idCategorias"] = $_POST["Categorias"];
    $proveedores = array();
    $proveedores["idProveedores"] = $_POST["Proveedores"];

    $gestorProduct = new Productos();
    $resultado = $gestorProduct->insertarProducto($producto, $categorias, $proveedores, $conexPDO);

    if ($resultado) {
        $mensaje = "Se ha añadido el nuevo producto con éxito";
    } else {
        $mensaje = "Se ha producido un error, se cancela la introducción del nuevo producto";
    }

    //Recolectamos los datos de los Productos
    $datosProductos = $gestorProduct->obtenerTodosProductos($conexPDO);

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
} else {
    //Sin datos cargados, cargamos la vista
    $accion = "insertar";
    include("../views/insertar_modificar_productos_vista.php");
}
