<?php

//Agrupamos todo en modelo
namespace modelo;

//Añadimos las funciones de Utils
require_once("../model/utils.php");

use \PDO;
use \PDOException;

class Pedidos
{
    //Funcion para crear los pedidos
    function crearPedido($conexPDO, $idUsuarios)
    {
        $result = false;
        if ($conexPDO != null) {
            try {
                $conexPDO->beginTransaction();
                $sentencia = $conexPDO->prepare("INSERT INTO quesorpresa.pedido (idUsuarios) VALUES (:idUsuarios)");
                $sentencia->bindParam(":idUsuarios", $idUsuarios);
                $sentencia->execute();
                $result = $conexPDO->commit();
            } catch (PDOException $e) {
                $conexPDO->rollBack();
                print("Error al acceder a BD: " . $e->getMessage());
            }
        }
        return $result;
    }

    //Funcion para devolver el id de pedidos
    function obtenerPedidosID($conexPDO, $idUsuarios)
    {
        $result = null;
        if ($conexPDO != null) {
            try {
                $sentencia = $conexPDO->prepare("SELECT idPedido FROM quesorpresa.pedido WHERE idUsuarios = :idUsuarios ORDER BY idPedido DESC LIMIT 1");
                $sentencia->bindParam(":idUsuarios", $idUsuarios);
                $sentencia->execute();
                $result = $sentencia->fetch(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                print("Error al acceder a BD: " . $e->getMessage());
            }
        }
        return $result;
    }
    //Funcion para insertar los datos conjuntos que crearian el respaldo del carrito en nuestra base de datos
    public function insertarProductosPedido($conexPDO, $idPedido, $productIds, $productQuantities)
    {
        try {
            //Recorremos los arrays de productos y cantidades para hacer los inserts
            for ($i = 0; $i < count($productIds); $i++) {
                $idProducto = (int)$productIds[$i];
                $cantidad = (int)$productQuantities[$i];

                //Asegurarse de que ambos valores son válidos antes de insertarlos
                if ($idProducto > 0 && $cantidad > 0) {
                    $stmt = $conexPDO->prepare("INSERT INTO productos_has_pedido (idProductos, idPedido, Cantidad) VALUES (:idProducto, :idPedido, :cantidad)");
                    $stmt->bindParam(':idProducto', $idProducto, PDO::PARAM_INT);
                    $stmt->bindParam(':idPedido', $idPedido, PDO::PARAM_INT);
                    $stmt->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);

                    $stmt->execute();
                }
            }
        } catch (PDOException $e) {
            echo "Ha ocurrido un error a la hora de insertar los productos en el pedido: " . $e->getMessage();
            return false;
        }

        return true;
    }
    
}