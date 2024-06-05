<?php

//Agrupamos todo en modelo
namespace modelo;

//Añadimos las funciones de Utils
require_once("../model/utils.php");

use \PDO;
use \PDOException;

class Categorias
{
    public function obtenerTodasCategorias($conexPDO)
    {
        if (isset($conexPDO)) {
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