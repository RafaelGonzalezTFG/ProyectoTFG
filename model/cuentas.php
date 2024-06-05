<?php

//Agrupamos todo en modelo
namespace modelo;

//Añadimos las funciones de Utils
require_once("../model/utils.php");

use \PDO;
use \PDOException;

class Cuentas
{
    //Funcion para comprobar el email
    function verificarCorreo($conexPDO, $correo)
    {
        try {
            if (isset($conexPDO)) {
                // Preparar la consulta
                $sentencia = $conexPDO->prepare("SELECT COUNT(*) FROM quesorpresa.cuentas WHERE Correo = :Correo");

                // Asignar el valor al marcador de posición
                $sentencia->bindParam(":Correo", $correo);

                // Ejecutar la consulta
                $sentencia->execute();

                // Obtener el resultado
                $cantidad = $sentencia->fetchColumn();

                // Verificar si el correo electrónico existe
                if ($cantidad > 0) {
                    // El correo electrónico ya está registrado
                    return true;
                } else {
                    // El correo electrónico no está registrado
                    return false;
                }
            }
        } catch (PDOException $e) {
            // Manejo de excepciones
            echo "Error al verificar el correo electrónico: " . $e->getMessage();
            return false;
        }
    }

    //Funcion para obtener nuestro codigo de activacion
    function obtenerCodigoActivacion($conexPDO, $correo)
    {
        // Preparar la consulta para obtener el código de activación
        $sentencia = $conexPDO->prepare("SELECT CodigoActivacion FROM quesorpresa.cuentas WHERE Correo = :Correo");
        $sentencia->bindParam(":Correo", $correo);
        $sentencia->execute();

        // Obtener el resultado de la consulta
        $resultado = $sentencia->fetch(PDO::FETCH_ASSOC);

        // Verificar si se encontró el código de activación
        if ($resultado && isset($resultado['CodigoActivacion'])) {
            return $resultado['CodigoActivacion'];
        } else {
            return null; // Código de activación no encontrado
        }
    }
}
