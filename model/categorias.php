<?php

//Agrupamos todo en modelo
namespace modelo;

//Añadimos las funciones de Utils
require_once("../model/utils.php");

use \PDO;
use \PDOException;

class Categorias
{
    //Funcion para obtener todas las categorias
    public function obtenerTodasCategorias($conexPDO)
    {
        //Comprobamos la conexion
        if ($conexPDO != null) {
            try {
                $sentencia = $conexPDO->prepare("SELECT * FROM quesorpresa.categorias");
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