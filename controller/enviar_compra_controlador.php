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
use \modelo\Pedidos;
use \modelo\Factura;
use \modelo\Direcciones;
//Añadimos el código del modelo
require_once("../model/utils.php");
require_once("../model/cuentas.php");
require_once("../model/productos.php");
require_once("../model/pedidos.php");
require_once("../model/factura.php");
require_once("../model/direcciones.php");
//Metemos los datos conseguidos a traves de un array en JavaScrip a un array en PHP
$productIdsString = isset($_POST['productIds']) ? $_POST['productIds'] : '';
$productQuantitiesString = isset($_POST['productQuantities']) ? $_POST['productQuantities'] : '';
//Separamos cada dato con una coma
$productIds = explode(',', $productIdsString);
$productQuantities = explode(',', $productQuantitiesString);
//Comprobamos todos los datos necesarios
if (
    isset($_POST['nombre']) && isset($_POST['apellido']) && isset($_POST['correo'])
    && isset($_POST['pais']) && isset($_POST['provincia']) && isset($_POST['ciudad'])
    && isset($_POST['calle']) && isset($_POST['numero']) && isset($_POST['codigoPostal'])
    && isset($_POST['metodoPago']) && isset($_POST['totalFactura'])
) {
    //Los limpiamos
    $nombre = Utils::limpiar_datos($_POST['nombre']);
    $apellido = Utils::limpiar_datos($_POST['apellido']);
    $correo = Utils::limpiar_datos($_POST['correo']);
    $pais = Utils::limpiar_datos($_POST['pais']);
    $provincia = Utils::limpiar_datos($_POST['provincia']);
    $ciudad = Utils::limpiar_datos($_POST['ciudad']);
    $calle = Utils::limpiar_datos($_POST['calle']);
    $numero = Utils::limpiar_datos($_POST['numero']);
    $piso = isset($_POST['piso']) ? Utils::limpiar_datos($_POST['piso']) : null;
    $letra = isset($_POST['letra']) ? Utils::limpiar_datos($_POST['letra']) : null;
    $codigoPostal = Utils::limpiar_datos($_POST['codigoPostal']);
    $metodoPago = Utils::limpiar_datos($_POST['metodoPago']);
    $totalFactura = Utils::limpiar_datos($_POST['totalFactura']);

    //Creamos un objeto cuenta y su conexion
    $gestorCuenta = new Cuentas();
    $conexPDO = Utils::conectar();

    //Obtenemos los datos de la cuenta de la sesion actual
    $datosCuenta = $gestorCuenta->obtenerCuentaUsuario($conexPDO, $idCuentap);
    //Guardamos la id de usuario
    $idUsuarios = $datosCuenta["idUsuarios"];

    //Array con las direciones
    $direccion = [
        "Pais" => $pais,
        "Provincia" => $provincia,
        "Ciudad" => $ciudad,
        "Calle" => $calle,
        "Numero" => $numero,
        "Piso" => $piso,
        "Letra" => $letra,
        "CodigoPostal" => $codigoPostal
    ];

    //Creamos un objeto direcciones para insertar la direccion del usuario
    $gestorDirecciones = new Direcciones();
    $resultadoDireccion = $gestorDirecciones->insertarDireccion($direccion, $idUsuarios, $conexPDO);

    //Si se ha guardado la direccion procedemos a crear el envio
    if ($resultadoDireccion) {
        $gestorPedido = new Pedidos();
        $datosPedido = $gestorPedido->crearPedido($conexPDO, $idUsuarios);
        $idPedidoArray = $gestorPedido->obtenerPedidosID($conexPDO, $idUsuarios);

        //Comprobamos que tenemos los datos necesarios
        if ($idPedidoArray && isset($idPedidoArray['idPedido'])) {
            $idPedido = $idPedidoArray['idPedido'];
        } else {
            echo "Error: No se pudo obtener el ID del pedido.";
            exit;
        }

        if (!$idPedido) {
            echo "Error: No se pudo obtener el ID del pedido.";
            exit;
        }

        //Obtenemos la fecha actual
        $fechaActual = date("Y-m-d");

        //Creamos la factura
        $gestorFactura = new Factura();
        $datosFactura = $gestorFactura->crearFactura($conexPDO, $metodoPago, $fechaActual, $totalFactura, $idPedido);

        //Si tenemos la factura creada, insertamos el carrito dentro de la base de datos
        if ($datosFactura) {
            $gestorPedido->insertarProductosPedido($conexPDO, $idPedido, $productIds, $productQuantities);

            //Enviamos al usuario que se ha realizado su compra
            $envioCorreo = Utils::enviarFactura($datosCuenta["Correo"], $totalFactura);
            if ($envioCorreo) {
                include("../controller/main_controlador.php");
            }
        } else {
            echo "Error al crear la factura.";
        }
    } else {
        echo "Error al insertar la dirección.";
    }
} else {
    echo "Faltan datos en el formulario.";
}

