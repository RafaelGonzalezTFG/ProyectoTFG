<?php
//Agrupamos todo en modelo
namespace modelo;
//Añadimos las funciones de Utils
require_once("../model/utils.php");

use \PDO;
use \PDOException;

class Direcciones {
    //Funcion para insertar las direcciones
    function insertarDireccion($direccion, $idUsuarios, $conexPDO)
    {
        $result = null;
        if (isset($direccion) && isset($idUsuarios) && isset($conexPDO)) {
            try {
                //Iniciar la transacción
                $conexPDO->beginTransaction();

                //Preparamos la sentencia para insertar en la tabla direcciones
                $sentenciaDireccion = $conexPDO->prepare("INSERT INTO direcciones (Pais, Provincia, Ciudad, Calle, Numero, Piso, Letra, CodigoPostal) 
                                                          VALUES (:Pais, :Provincia, :Ciudad, :Calle, :Numero, :Piso, :Letra, :CodigoPostal)");

                //Asociamos los valores a los parámetros de la sentencia SQL
                $sentenciaDireccion->bindParam(":Pais", $direccion["Pais"]);
                $sentenciaDireccion->bindParam(":Provincia", $direccion["Provincia"]);
                $sentenciaDireccion->bindParam(":Ciudad", $direccion["Ciudad"]);
                $sentenciaDireccion->bindParam(":Calle", $direccion["Calle"]);
                $sentenciaDireccion->bindParam(":Numero", $direccion["Numero"]);
                $sentenciaDireccion->bindParam(":Piso", $direccion["Piso"]);
                $sentenciaDireccion->bindParam(":Letra", $direccion["Letra"]);
                $sentenciaDireccion->bindParam(":CodigoPostal", $direccion["CodigoPostal"]);

                //Ejecutamos la sentencia
                $sentenciaDireccion->execute();

                //Obtenemos la id de la dirección recién insertada
                $idDirecciones = $conexPDO->lastInsertId();

                // Preparamos la sentencia para insertar en la tabla usuarios_has_direcciones
                $sentenciaUsuarioDireccion = $conexPDO->prepare("INSERT INTO usuarios_has_direcciones (idUsuarios, idDirecciones) 
                                                                 VALUES (:idUsuarios, :idDirecciones)");

                // Asociamos los valores a los parámetros de la sentencia SQL
                $sentenciaUsuarioDireccion->bindParam(":idUsuarios", $idUsuarios);
                $sentenciaUsuarioDireccion->bindParam(":idDirecciones", $idDirecciones);

                //Ejecutamos la sentencia
                $sentenciaUsuarioDireccion->execute();

                //Comprobamos y realizamos la transacción
                $result = $conexPDO->commit();
            } catch (PDOException $e) {
                //En caso de error, revertir la transacción
                $conexPDO->rollBack();
                print("Error al acceder a BD: " . $e->getMessage());
            }
        } else {
            print("Datos de entrada inválidos: ");
            var_dump($direccion, $idUsuarios, $conexPDO);
        }

        return $result;
    }
}
