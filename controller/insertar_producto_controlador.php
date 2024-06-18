<?php
// Iniciar la sesión si no ha sido iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Verificar roles y permisos
$idCuentap = isset($_SESSION["idCuentas"]) ? $_SESSION["idCuentas"] : null;
$rolp = isset($_SESSION["Rol"]) ? $_SESSION["Rol"] : null;

// Incluir los modelos necesarios
use modelo\Productos;
use modelo\Utils;
//Añadimos el código del modelo
require_once("../model/productos.php");
require_once("../model/proveedores.php");
require_once("../model/categorias.php");
require_once("../model/utils.php");
//Variable para mensajes
$mensaje = "";

// Conexión con la base de datos
$conexPDO = Utils::conectar();

// Verificar si el formulario ha sido enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Limpiar y sanitizar los datos del formulario
    $nombre = Utils::limpiar_datos($_POST['Nombre']);
    $descripcion = Utils::limpiar_datos($_POST['Descripcion']);
    $peso = Utils::limpiar_datos($_POST['Peso']);
    $material = Utils::limpiar_datos($_POST['Material']);
    $marca = Utils::limpiar_datos($_POST['Marca']);
    $proveedores = $_POST['Proveedores'];
    $categorias = Utils::limpiar_datos($_POST['Categorias']);
    $precio = Utils::limpiar_datos($_POST['Precio']);
    $stock = Utils::limpiar_datos($_POST['Stock']);
    $fechaAdquisicion = Utils::limpiar_datos($_POST['FechaAdquisicion']);
    $fechaCaducidad = Utils::limpiar_datos($_POST['FechaCaducidad']);

    //Controlamos la imagen que nos envia el usuario
    $imagen = $_FILES['Imagen']['name'];
    $target_dir = "../img/imagenesSubidas/";
    $target_file = $target_dir . basename($_FILES['Imagen']['name']);

    //Movemos la imagen a su destino
    if (move_uploaded_file($_FILES['Imagen']['tmp_name'], $target_file)) {
        $imagen = basename($_FILES['Imagen']['name']);
    } else {
        $imagen = null;
    }

    //Creamos un array de los productos
    $producto = [
        "Nombre" => $nombre,
        "Descripcion" => $descripcion,
        "Peso" => $peso,
        "Material" => $material,
        "Marca" => $marca,
        "idCategorias" => $categorias,
        "Precio" => $precio,
        "Stock" => $stock,
        "FechaAdquisicion" => $fechaAdquisicion,
        "FechaCaducidad" => $fechaCaducidad,
        "Imagen" => $imagen
    ];

    //Creamos un objeto de productos
    $gestorProducto = new Productos();

    //Insertamos el producto
    $resultado = $gestorProducto->insertarProducto($producto, $proveedores, $conexPDO);

    //Gestionamos los mensajes
    if ($resultado) {
        $mensaje = "Se ha añadido el nuevo producto con éxito";
    } else {
        $mensaje = "Se ha producido un error, se cancela la introducción del nuevo producto";
    }

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
}
