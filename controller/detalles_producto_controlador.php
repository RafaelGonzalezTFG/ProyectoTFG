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

//Comprobamos que la id no este vacia
if (isset($_POST["idProductos"])) {

    //Creamos un objeto y su conexion
    $gestorProducto = new Productos();
    $conexPDO = Utils::conectar();
    //Obtenemos los datos por la id
    $producto = $gestorProducto->obtenerProductoID($conexPDO, $_POST["idProductos"]);
    //Enviamos a la vista
    include("../views/detalles_producto_vista.php");
}