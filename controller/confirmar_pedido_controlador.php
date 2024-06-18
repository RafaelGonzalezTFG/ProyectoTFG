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
use \modelo\Productos;
use \modelo\Utils;

//Añadimos el código del modelo
require_once("../model/productos.php");
require_once("../model/utils.php");
require_once("../model/cuentas.php");
//Objeto PDO de conexión
$conexPDO = Utils::conectar();
//Objeto llamamos a los metodos necesarios para operar 
$gestorProducto = new Productos();
$gestorCuenta = new Cuentas();
//Comprobacion basica de que se llama con POST y que se rrecibe el carrito lleno
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cartData'])) {
    //Recogemos los datos del carrito en formato JSON
    $cartData = json_decode($_POST['cartData'], true);
    if (is_array($cartData)) {
        //Creamos las variables para pasar el carrito a PHP
        $productosCompra = [];
        $totalAmount = 0;

        //Obtenemos los datos de la cuenta del usuario comprando actualmente
        $datosCuenta = $gestorCuenta->obtenerCuentaUsuario($conexPDO, $idCuentap);
        //Recorremos el JSON para obtener los datos necesarios
        foreach ($cartData as $item) {
            //Obtenemos el producto real de la base de datos
            $productoReal = $gestorProducto->obtenerProductoID($conexPDO, $item['id']);
            
            //Verificamos el producto y tambien los datos obtenidos del carrito
            if ($productoReal) {
                if (
                    isset($item['id'], $item['name'], $item['price'], $item['quantity']) &&
                    is_numeric($item['id']) && is_numeric($item['price']) && is_numeric($item['quantity'])
                ) {
                    //Guardamos el valor de todos los productos
                    $subtotal = $productoReal["Precio"] * $item['quantity'];
                    //Metemos todo en un array
                    $productosCompra[] = [
                        'idProductos' => $productoReal["idProductos"],
                        'nombre' => $productoReal["Nombre"],
                        'precio' => $productoReal["Precio"],
                        'imagen' => $productoReal["Imagen"],
                        'cantidad' => $item['quantity'],
                        'subtotal' => $subtotal
                    ];

                    //Calculamos el dinero total de la compra
                    $totalAmount += $subtotal;
                } else {
                    //Si los datos no son válidos, redirige con un mensaje de error
                    header('Location: ../views/carrito_vista.php?error=Datos del carrito inválidos');
                    exit;
                }
            } else {
                //Si el precio no coincide, redirige con un mensaje de error
                header('Location: ../views/carrito_vista.php?error=Precio del producto no coincide con el precio actual');
                exit;
            }
        }

        //Redirige a una página de confirmación de pedido o procesa el pago
        include('../views/confirmar_pedido_vista.php');
        exit;
    } else {
        header('Location: ../views/carrito_vista.php?error=Datos del carrito inválidos');
        exit;
    }
} else {
    header('Location: ../views/carrito_vista.php?error=Acceso no autorizado');
    exit;
}
