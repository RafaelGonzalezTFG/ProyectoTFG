<?php
//Creamos session si no esta creada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
//Se guardan en variables en caso de ser necesarias
$idCuentap = isset($_SESSION["idCuentas"]) ? $_SESSION["idCuentas"] : null;
$rolp = isset($_SESSION["Rol"]) ? $_SESSION["Rol"] : null;

//Importamos las clases necesarias
use modelo\Productos;
use modelo\Categorias;
use modelo\Proveedores;
use modelo\Utils;

//Añadimos el código del modelo
require_once("../model/productos.php");
require_once("../model/proveedores.php");
require_once("../model/categorias.php");
require_once("../model/utils.php");

//Conexión con la base de datos y mas objetos de proveedores y categorias
$gestorProveedor = new Proveedores();
$gestorCategoria = new Categorias();
$conexPDO = Utils::conectar();
//Comprobamos la conexion
if (!$conexPDO) {
    echo "Error al conectar con la base de datos.";
    $datosProveedores = []; // Asegura que la variable está definida incluso en caso de error
} else {
    // Recolectamos los datos de los proveedores
    $datosProveedores = $gestorProveedor->obtenerTodosProveedores($conexPDO);
}
//Comprobamos la conexion
if (!$conexPDO) {
    echo "Error al conectar con la base de datos.";
    $datosCategorias = []; // Asegura que la variable está definida incluso en caso de error
} else {
    // Recolectamos los datos de los proveedores
    $datosCategorias = $gestorCategoria->obtenerTodasCategorias($conexPDO);
}
//Comprobamos si llamamos para insertar o para modificar
if (isset($_POST["insertar"]) && $_POST["insertar"] == "true") {
    include("../views/insertar_producto_vista.php");
} elseif (isset($_POST["modificar"]) && $_POST["modificar"] == "true") {

    //Creamos un objeto producto
    $gestorProducto = new Productos();
    //Comprobamos la id y obtenemos los datos del producto para rellenar los campos
    if (isset($_POST["idProductos"]) && !empty($_POST["idProductos"])) {
        $idProductos = $_POST["idProductos"];
        $datosProducto = $gestorProducto->obtenerProductoID($conexPDO, $idProductos);

        if ($datosProducto) {
            include("../views/modificar_producto_vista.php");
        } else {
            echo "Error: No se encontraron datos para el ID de productos proporcionado.";
        }
    } else {
        echo "Error: El ID de productos es obligatorio para modificar.";
    }
}
