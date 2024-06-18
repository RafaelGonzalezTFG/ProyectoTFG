<?php

//Agrupamos todo en modelo
namespace modelo;

//Añadimos las funciones de Utils
require_once("../model/utils.php");

use \PDO;
use \PDOException;

class Proveedores
{
    //Funciones para obtener todos los proveedores
    public function obtenerTodosProveedores($conexPDO)
    {
        //Comprobamos la conexion
        if ($conexPDO != null) {
            try {
                $sentencia = $conexPDO->prepare("SELECT * FROM quesorpresa.proveedores");
                $sentencia->execute();
                $resultado = $sentencia->fetchAll();
                return $resultado;
            } catch (PDOException $th) {
                echo "¡Error al realizar la consulta!: " . $th->getMessage();
                return [];
            }
        } else {
            echo "Conexión no definida.";
            return [];
        }
    }
}
