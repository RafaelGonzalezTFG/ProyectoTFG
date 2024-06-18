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
            //Comprobamos las variables de la conexion y el correo
            if (isset($conexPDO) && isset($correo)) {
                //Preparamos la consulta para obtener cuantas cuentas hay con el correo enviado
                $sentencia = $conexPDO->prepare("SELECT COUNT(*) FROM quesorpresa.cuentas WHERE Correo = :Correo");

                //Asignamos los valores a sus correspondientes lugares
                $sentencia->bindParam(":Correo", $correo);

                //Ejecutamos la sentencia
                $sentencia->execute();

                //Guardamos el resultado en una variable nueva
                $cantidad = $sentencia->fetchColumn();

                //Comprobamos la nueva variable
                if ($cantidad > 0) {
                    //Enviamos true si el correo no esta siendo usado en ninguna cuenta
                    return true;
                } else {
                    //Devolvemos false si el correo ya se esta usando en otra cuenta
                    return false;
                }
            }
        } catch (PDOException $e) {
            // Manejo de excepciones
            echo "Error al verificar el correo electrónico: " . $e->getMessage();
            return false;
        }
    }

    //Funcion para obtener nuestro codigo de activacion de la base de datos
    function obtenerCodigoActivacion($conexPDO, $correo)
    {
        try { //Comprobamos que nos llegue la conexion y el correo
            if ($conexPDO != null && isset($correo)) {
                //Preparar la consulta para obtener el código de activación
                $sentencia = $conexPDO->prepare("SELECT CodigoActivacion FROM quesorpresa.cuentas WHERE Correo = :Correo");
                $sentencia->bindParam(":Correo", $correo);
                $sentencia->execute();

                //Obtener el resultado de la consulta
                $resultado = $sentencia->fetch(PDO::FETCH_ASSOC);

                //Verificamos que se ha encontrado el codigo de activación y lo devolvemos
                if ($resultado && isset($resultado['CodigoActivacion'])) {
                    return $resultado['CodigoActivacion'];
                } else {
                    return null; //No se encontro el codigo de activacion
                }
            }
        } catch (PDOException $e) {
            echo "Ha ocurrido un error a la hora de obtener el codigo de activacion: " . $e->getMessage();
            return false;
        }
    }

    //Funcion para verificar el codigo de activacion
    function verificarCodigoActivacion($conexPDO, $correo, $CodigoActivacion)
    {
        try { //Comprobamos que nos llegue la conexion, el correo y el codigo de activacion
            if ($conexPDO != null && isset($correo) && isset($CodigoActivacion)) {

                //Creamos nueva variable para cambiar el estado de la cuenta
                $nuevoEstado = "Activo";

                //Preparamos la consulta para obtener el codigo de activacion a traves del correo
                $sentencia = $conexPDO->prepare("SELECT CodigoActivacion FROM quesorpresa.cuentas WHERE Correo = :Correo");
                $sentencia->bindParam(":Correo", $correo);
                $sentencia->execute();

                //Obtenemos el resultado
                $resultado = $sentencia->fetch(PDO::FETCH_ASSOC);

                //Comprobamos que hemos obtenido el codigo
                if ($resultado && isset($resultado['CodigoActivacion'])) {
                    //Lo guardamos en una nueva variable
                    $codigoAlmacenado = $resultado['CodigoActivacion'];

                    //Comprobamos que el codigo almacenado y el que ha introducido el usuario son el mismo
                    if ($CodigoActivacion === $codigoAlmacenado) {

                        //Actualizamos el Estado de la cuenta del usuario
                        $sentencia = $conexPDO->prepare("UPDATE quesorpresa.cuentas SET Activado = 1, Estado = :Estado WHERE Correo = :Correo");
                        $sentencia->bindParam(":Estado", $nuevoEstado);
                        $sentencia->bindParam(":Correo", $correo);
                        $sentencia->execute();

                        return true; //Se ha realizado todo correctamente
                    }
                }

                return false; //El codigo de activación no es válido
            }
        } catch (PDOException $e) {
            echo "Ha ocurrido un error a la hora de verificar el codigo de activacion: " . $e->getMessage();
            return false;
        }
    }

    //Funcion para obtener la contraseña encriptada
    function obtenerContraseñaEncriptada($conexPDO, $correo)
    {

        try { //Comprobamos que nos llegue la conexion y el correo
            if ($conexPDO != null && isset($correo)) {
                //Obtenemos la contraseña encriptada en la base de datos
                $sentencia = $conexPDO->prepare("SELECT Contrasena FROM quesorpresa.cuentas WHERE Correo = :Correo");
                $sentencia->bindParam(":Correo", $correo);
                $sentencia->execute();
                $resultado = $sentencia->fetch(PDO::FETCH_ASSOC);

                //Deolvemos true en caso de obtener la contraseña
                if (isset($resultado)) {
                    return true;
                }
                //La sentecia ha llegado vacia
                return false;
            }
        } catch (PDOException $e) {
            echo "Ha ocurrido un error a la hora de obtener el codigo de activacion: " . $e->getMessage();
            return false;
        }
    }

    //Obtenemos los datos por el correo
    public function obtenerCuentaPorCorreo($conexPDO, $correo)
    {

        try { //Comprobamos que nos llegue la conexion y el correo
            if ($conexPDO != null && isset($correo)) {
                //Preparamos la sentencia para obtener todos los datos por el correo
                $sentencia = $conexPDO->prepare("SELECT * FROM quesorpresa.cuentas WHERE Correo = :Correo");
                $sentencia->bindParam(":Correo", $correo);
                $sentencia->execute();
                $resultado = $sentencia->fetch(PDO::FETCH_ASSOC);

                if ($resultado) {
                    return $resultado; // Devuelve el array de datos si encuentra un resultado.
                }

                return false; // Devuelve false si no hay resultados.
            }
        } catch (PDOException $e) {
            echo "Ha ocurrido un error a la hora de obtener el codigo de activacion: " . $e->getMessage();
            return false;
        }
    }

    //Funcion para obtener los datos de la cuenta y usuario 
    public function obtenerCuentaUsuario($conexPDO, $idCuenta)
    {
        try { //Comprobamos que nos llegue la conexion y el id de la cuenta
            if ($conexPDO != null && isset($idCuenta)) {
                //Preparamos la sentencia para obtener todos los datos por el correo
                $sentencia = $conexPDO->prepare("SELECT c.*, u.* FROM cuentas c INNER JOIN usuarios u ON c.idUsuarios = u.idUsuarios WHERE   c.idCuentas = :idCuentas");
                $sentencia->bindParam(":idCuentas", $idCuenta);
                $sentencia->execute();
                $resultado = $sentencia->fetch(PDO::FETCH_ASSOC);

                if ($resultado) {
                    return $resultado; // Devuelve el array de datos si encuentra un resultado.
                }

                return false; // Devuelve false si no hay resultados.
            }
        } catch (PDOException $e) {
            echo "Ha ocurrido un error a la hora de obtener el codigo de activacion: " . $e->getMessage();
            return false;
        }
    }

    //Funcion para obtener todas las cuentas y sus respectivos usuarios
    public function obtenerTodasCuentasUsuarios($conexPDO)
    {
        try { //Comprobamos que nos llegue la conexion y el id de la cuenta
            if ($conexPDO != null) {
                //Preparamos la sentencia para obtener todos los datos por el correo
                $sentencia = $conexPDO->prepare("SELECT c.*, u.* FROM cuentas c INNER JOIN usuarios u ON c.idUsuarios = u.idUsuarios");

                $sentencia->execute();
                $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);

                if ($resultado) {
                    return $resultado; // Devuelve el array de datos si encuentra un resultado.
                }

                return false; // Devuelve false si no hay resultados.
            }
        } catch (PDOException $e) {
            echo "Ha ocurrido un error a la hora de obtener el codigo de activacion: " . $e->getMessage();
            return false;
        }
    }

    //Funcion para eliminar un usuario y su cuenta
    public function eliminarCuenta($conexPDO, $idCuentas)
    {
        try { //Comprobamos que nos llegue la conexion y el id de la cuenta
            if ($conexPDO != null && isset($idCuentas)) {
                // Eliminar las asociaciones de proveedores
                $sentencia = $conexPDO->prepare("DELETE FROM quesorpresa.cuentas WHERE idCuentas = :idCuentas");
                $sentencia->bindParam(":idCuentas", $idCuentas);
                $sentencia->execute();

                return true;
            }
        } catch (PDOException $e) {
            echo "Ha ocurrido un error a la hora de obtener el codigo de activacion: " . $e->getMessage();
            return false;
        }
    }

    //Funcion para insertar una cuenta y su usuario
    public function insertarCuentaUsuario($conexPDO, $usuario, $cuenta)
    {
        try {
            if ($conexPDO != null && isset($usuario) && isset($cuenta)) {
                $conexPDO->beginTransaction();

                // Preparar y ejecutar la sentencia para insertar en usuarios
                $sentenciaUsuario = $conexPDO->prepare("INSERT INTO quesorpresa.usuarios (Nombre, Apellido, Telefono) VALUES (:Nombre, :Apellido, :Telefono)");
                $sentenciaUsuario->bindParam(":Nombre", $usuario["Nombre"]);
                $sentenciaUsuario->bindParam(":Apellido", $usuario["Apellido"]);
                $sentenciaUsuario->bindParam(":Telefono", $usuario["Telefono"]);
                $sentenciaUsuario->execute();

                // Obtener el último ID insertado
                $idUsuarios = $conexPDO->lastInsertId();

                // Encriptar la contraseña
                $contrasenaEncriptada = password_hash($cuenta["Contrasena"], PASSWORD_BCRYPT);

                // Preparar y ejecutar la sentencia para insertar en cuentas
                $sentenciaCuenta = $conexPDO->prepare("INSERT INTO quesorpresa.cuentas (Contrasena, Correo, Rol, Estado, CodigoActivacion, Activado, idUsuarios) VALUES (:Contrasena, :Correo, :Rol, :Estado, :CodigoActivacion, :Activado, :idUsuarios)");
                $sentenciaCuenta->bindParam(":Contrasena", $contrasenaEncriptada);
                $sentenciaCuenta->bindParam(":Correo", $cuenta["Correo"]);
                $sentenciaCuenta->bindParam(":Rol", $cuenta["Rol"]);
                $sentenciaCuenta->bindParam(":Estado", $cuenta["Estado"]);
                $sentenciaCuenta->bindParam(":CodigoActivacion", $cuenta["CodigoActivacion"]);
                $sentenciaCuenta->bindParam(":Activado", $cuenta["Activado"]);
                $sentenciaCuenta->bindParam(":idUsuarios", $idUsuarios);
                $sentenciaCuenta->execute();

                $conexPDO->commit();
                return true;
            }
        } catch (PDOException $e) {
            $conexPDO->rollBack();
            echo "Ha ocurrido un error a la hora de insertar la cuenta: " . $e->getMessage();
            return false;
        }
    }

    //Funcion para modificar al usuario y su cuenta
    public function modificarCuentaUsuario($conexPDO, $usuario, $cuenta)
    {
        try {
            if ($conexPDO != null && isset($usuario) && isset($cuenta)) {
                $conexPDO->beginTransaction();

                // Preparar y ejecutar la sentencia para actualizar en usuarios
                $sentenciaUsuario = $conexPDO->prepare(
                    "UPDATE quesorpresa.usuarios 
                SET Nombre = :Nombre, Apellido = :Apellido, Telefono = :Telefono 
                WHERE idUsuarios = :idUsuarios"
                );
                $sentenciaUsuario->bindParam(":Nombre", $usuario["Nombre"]);
                $sentenciaUsuario->bindParam(":Apellido", $usuario["Apellido"]);
                $sentenciaUsuario->bindParam(":Telefono", $usuario["Telefono"]);
                $sentenciaUsuario->bindParam(":idUsuarios", $usuario["idUsuarios"]);
                $resultadoUsuario = $sentenciaUsuario->execute();

                // Preparar y ejecutar la sentencia para actualizar en cuentas
                $sentenciaCuenta = $conexPDO->prepare(
                    "UPDATE quesorpresa.cuentas 
                SET Correo = :Correo, Rol = :Rol, Estado = :Estado 
                WHERE idCuentas = :idCuentas"
                );
                $sentenciaCuenta->bindParam(":Correo", $cuenta["Correo"]);
                $sentenciaCuenta->bindParam(":Rol", $cuenta["Rol"]);
                $sentenciaCuenta->bindParam(":Estado", $cuenta["Estado"]);
                $sentenciaCuenta->bindParam(":idCuentas", $cuenta["idCuentas"]);
                $resultadoCuenta = $sentenciaCuenta->execute();

                if ($resultadoUsuario && $resultadoCuenta) {
                    $conexPDO->commit();
                    return true;
                } else {
                    $conexPDO->rollBack();
                    return false;
                }
            }
        } catch (PDOException $e) {
            $conexPDO->rollBack();
            echo "Ha ocurrido un error a la hora de modificar la cuenta: " . $e->getMessage();
            return false;
        }
    }


    //Funcion para la paginacion de las cuentas
    public function getCuentasPag($conexPDO, $ordAsc, string $campoOrd, int $numPag, int $cantElem)
    {
        if ($conexPDO != null) {
            try {
                // Prepara la consulta SQL básica
                $query = "SELECT c.*, u.* FROM cuentas c INNER JOIN usuarios u ON c.idUsuarios = u.idUsuarios ORDER BY $campoOrd ";

                // Agrega DESC si se requiere orden descendente
                if (!$ordAsc) {
                    $query .= "DESC ";
                }

                // Agrega LIMIT y OFFSET para la paginación
                $query .= "LIMIT ? OFFSET ?";

                // Prepara la sentencia
                $sentencia = $conexPDO->prepare($query);

                // Define la cantidad de elementos por página
                $sentencia->bindParam(1, $cantElem, PDO::PARAM_INT);

                // Calcula el OFFSET basado en el número de página
                $offset = ($numPag - 1) * $cantElem;
                $sentencia->bindParam(2, $offset, PDO::PARAM_INT);

                // Ejecuta la sentencia
                $sentencia->execute();

                // Devuelve los resultados
                return $sentencia->fetchAll();
            } catch (PDOException $e) {
                print("Error al acceder a BD: " . $e->getMessage());
            }
        }
    }
}
