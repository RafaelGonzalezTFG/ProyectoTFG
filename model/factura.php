<?php

//Agrupamos todo en modelo
namespace modelo;

//Añadimos las funciones de Utils
require_once("../model/utils.php");

use \PDO;
use \PDOException;

//Funcion para añadir productos
class Factura
{
    //Funcion para crear la factura
    function crearFactura($conexPDO, $metodoPago, $fechaActual, $totalFactura, $idPedido)
    {
        $result = null;
        if ($conexPDO != null) {
            try {
                //Iniciar la transacción
                $conexPDO->beginTransaction();

                //Preparamos la sentencia
                $sentencia = $conexPDO->prepare("INSERT INTO quesorpresa.factura (MetodoPago, FechaFactura, TotalFactura, idPedido) VALUES (:MetodoPago, :FechaFactura, :TotalFactura, :idPedido)");

                //Asociamos los valores a los parámetros de la sentencia SQL
                $sentencia->bindParam(":MetodoPago", $metodoPago);
                $sentencia->bindParam(":FechaFactura", $fechaActual);
                $sentencia->bindParam(":TotalFactura", $totalFactura);
                $sentencia->bindParam(":idPedido", $idPedido);

                //Ejecutamos la sentencia
                $sentencia->execute();

                //Comprobamos y realizamos la transacción
                $result = $conexPDO->commit();
            } catch (PDOException $e) {
                //En caso de error, revertir la transacción
                $conexPDO->rollBack();
                print("Error al acceder a BD: " . $e->getMessage());
            }
        }

        return $result;
    }
}
?>
