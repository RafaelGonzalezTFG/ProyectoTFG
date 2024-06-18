<?php

//Agrupamos todo en modelo
namespace modelo;

//Añadimos las funciones de Utils
require_once("../model/utils.php");

use \PDO;
use \PDOException;

class Usuarios
{
    //Funcion para registrar un usuario en la base de datos
    function registrarUsuario($conexPDO, $nombre, $apellido, $telefono, $correo, $contrasena)
    {

        try {
            if (isset($conexPDO) && isset($nombre) && isset($apellido) && isset($telefono) && isset($correo) && isset($contrasena)) {

                //Iniciamos la transacción
                $conexPDO->beginTransaction();

                //Encriptamos la contraseña
                $contrasenaEncriptada = password_hash($contrasena, PASSWORD_BCRYPT);

                $rol = "Usuario";
                $estado = "Inactivo";

                //Generamos el código de activación
                $codigoActivacion = generarCodigoActivacion();

                $activado = 0;

                //Insertamos los datos en la base de datos
                $sentenciaUsuario = $conexPDO->prepare("INSERT INTO quesorpresa.usuarios (Nombre, Apellido, Telefono) VALUES (:Nombre, :Apellido, :Telefono)");
                $sentenciaUsuario->bindParam(":Nombre", $nombre);
                $sentenciaUsuario->bindParam(":Apellido", $apellido);
                $sentenciaUsuario->bindParam(":Telefono", $telefono);
                $sentenciaUsuario->execute();

                //Obtenemos el ultimo id introducido
                $idUsuarios = $conexPDO->lastInsertId();

                //Insertamos de nuevo los datos en la base de datos
                $sentenciaCuenta = $conexPDO->prepare("INSERT INTO quesorpresa.cuentas (Contrasena, Correo, Rol, Estado, CodigoActivacion, Activado, idUsuarios) VALUES (:Contrasena, :Correo, :Rol, :Estado, :CodigoActivacion, :Activado, :idUsuarios)");
                $sentenciaCuenta->bindParam(":Contrasena", $contrasenaEncriptada);
                $sentenciaCuenta->bindParam(":Correo", $correo);
                $sentenciaCuenta->bindParam(":Rol", $rol);
                $sentenciaCuenta->bindParam(":Estado", $estado);
                $sentenciaCuenta->bindParam(":CodigoActivacion", $codigoActivacion);
                $sentenciaCuenta->bindParam(":Activado", $activado);
                $sentenciaCuenta->bindParam(":idUsuarios", $idUsuarios);
                $sentenciaCuenta->execute();

                //Comprobamos y realizamos la transacción
                $conexPDO->commit();

                return true;
            }
        } catch (PDOException $e) {
            //Manejo de excepciones
            echo "Error al registrar el usuario: " . $e->getMessage();
            return 0; //Código de resultado para fallo en el registro
        }
    }

    //Funcion para comprobar si el correo esta duplicado
    function verificarEmail($conexPDO, $correo)
    {
        try {
            if (isset($conexPDO)) {
                //Preparamos la consulta
                $sentencia = $conexPDO->prepare("SELECT COUNT(*) FROM quesorpresa.cuentas WHERE Correo = :Correo");

                //Asignamos el valor al marcador de posición
                $sentencia->bindParam(":Correo", $correo);

                //Ejecutamos la consulta
                $sentencia->execute();

                //Obtenemos el resultado
                $cantidad = $sentencia->fetchColumn();

                //Verificamos si el correo electrónico existe
                if ($cantidad > 0) {
                    //El correo electrónico ya está registrado
                    return true;
                } else {
                    //El correo electrónico no está registrado
                    return false;
                }
            }
        } catch (PDOException $e) {
            // Manejo de excepciones
            echo "Error al verificar el correo electrónico: " . $e->getMessage();
            return false;
        }
    }
    
}
