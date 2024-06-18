<?php
//Creamos session si no esta creada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

///Se guardan en variables en caso de ser necesarias
$idCuentap = isset($_SESSION["idCuentas"]) ? $_SESSION["idCuentas"] : null;
$rolp = isset($_SESSION["Rol"]) ? $_SESSION["Rol"] : null;

//Importamos las clases necesarias
use modelo\Productos;
use modelo\Utils;
//Añadimos el código del modelo
require_once("../model/productos.php");
require_once("../model/proveedores.php");
require_once("../model/categorias.php");
require_once("../model/utils.php");
//Mensajes
$mensaje = "";

//Conectamos a la base de datos
$conexPDO = Utils::conectar();

//Verificamos si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['idProductos']) && isset($_POST['Nombre']) && isset($_POST['Descripcion'])
&& isset($_POST['Peso']) && isset($_POST['Material']) && isset($_POST['Marca']) && isset($_POST['Proveedores'])
&& isset($_POST['Categorias']) && isset($_POST['Precio']) && isset($_POST['Stock']) && isset($_POST['FechaAdquisicion']) && isset($_POST['FechaCaducidad'])) {
    //Limpiamos datos
    $idProductos = Utils::limpiar_datos($_POST['idProductos']);
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

    //Si se ha subido una nueva imagen, moverla a la carpeta de destino
    if (!empty($_FILES['Imagen']['tmp_name']) && move_uploaded_file($_FILES['Imagen']['tmp_name'], $target_file)) {
        $imagen = basename($_FILES['Imagen']['name']);
    } else {
        $imagen = $_POST["ImagenActual"];
    }

    //Array de productos
    $producto = [
        "idProductos" => $idProductos,
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

    //Creamos objeto de productos
    $gestorProducto = new Productos();

    //Modificamos el producto
    $resultado = $gestorProducto->modificarProducto($producto, $proveedores, $conexPDO);

    //Gestion de mensajes
    if ($resultado) {
        $mensaje = "Se ha modificado el producto con éxito";
    } else {
        $mensaje = "Se ha producido un error, se cancela la modificación del producto";
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
