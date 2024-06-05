<?php

//Agrupamos todo en modelo
namespace modelo;

//Añadimos las funciones de Utils
require_once("../model/utils.php");

use \PDO;
use \PDOException;

class Productos
{
    // Funcion para añadir productos
    function insertarProducto($producto, $categorias, $proveedores, $conexPDO)
    {
        $result = null;
        if (isset($producto) && isset($categorias) && isset($proveedores) && isset($conexPDO)) {
            try {
                // Iniciar la transacción
                $conexPDO->beginTransaction();

                // Preparamos la sentencia
                $sentencia = $conexPDO->prepare("INSERT INTO quesorpresa.usuarios (Nombre, Apellido, Telefono) VALUES (:Nombre, :Apellido, :Telefono)");

                // Asociamos los valores a los parámetros de la sentencia SQL
                $sentencia->bindParam(":Nombre", $producto["Nombre"]);
                $sentencia->bindParam(":Descripcion", $producto["Descripcion"]);
                $sentencia->bindParam(":Material", $producto["Material"]);
                $sentencia->bindParam(":Precio", $producto["Precio"]);
                $sentencia->bindParam(":Stock", $producto["Stock"]);
                $sentencia->bindParam(":Imagen", $producto["Imagen"]);
                $sentencia->bindParam(":FechaAdquisicion", $producto["FechaAdquisicion"]);
                $sentencia->bindParam(":FechaCaducidad", $producto["FechaCaducidad"]);
                $sentencia->bindParam(":Marca", $producto["Marca"]);
                $sentencia->bindParam(":Peso", $producto["Peso"]);

                // Ejecutamos la sentencia
                $sentencia->execute();

                // Obtener el ID del producto recién insertado
                $idProducto = $conexPDO->lastInsertId();

                // Insertar las categorías asociadas al producto
                $sentenciaCategoria = $conexPDO->prepare("INSERT INTO categorias_has_productos (idCategorias, idProductos) VALUES (:idCategorias, :idProductos)");
                foreach ($categorias as $idCategoria) {
                    $sentenciaCategoria->bindParam(":idCategorias", $idCategoria);
                    $sentenciaCategoria->bindParam(":idProductos", $idProducto);
                    $sentenciaCategoria->execute();
                }

                // Insertar los proveedores asociados al producto
                $sentenciaProveedor = $conexPDO->prepare("INSERT INTO productos_has_proveedores (idProductos, idProveedores) VALUES (:idProductos, :idProveedores)");
                foreach ($proveedores as $idProveedor) {
                    $sentenciaProveedor->bindParam(":idProductos", $idProducto);
                    $sentenciaProveedor->bindParam(":idProveedores", $idProveedor);
                    $sentenciaProveedor->execute();
                }

                // Comprobamos y realizamos la transacción
                $result = $conexPDO->commit();
            } catch (PDOException $e) {
                // En caso de error, revertir la transacción
                $conexPDO->rollBack();
                print("Error al acceder a BD: " . $e->getMessage());
            }
        }

        return $result;
    }

    //Funcion para modificar productos
    function modificarProducto($producto, $categorias, $proveedores, $conexPDO)
    {
        $result = null;
        if (isset($producto) && is_numeric($producto["idProductos"]) && isset($categorias) && is_numeric($categorias["idCategorias"]) && isset($proveedores) && is_numeric($proveedores["idProveedores"]) && $conexPDO != null) {
            try {
                // Iniciar la transacción
                $conexPDO->beginTransaction();

                // Preparamos la sentencia
                $sentencia = $conexPDO->prepare("UPDATE quesorpresa.productos SET Nombre = :Nombre, Descripcion = :Descripcion, Material = :Material, Precio = :Precio, Stock = :Stock, Imagen = :Imagen, FechaAdquisicion = :FechaAdquisicion, FechaCaducidad = :FechaCaducidad, Marca = :Marca, Peso = :Peso;  WHERE idProductos = :idProductos");

                // Asociamos los valores a los parámetros de la sentencia SQL
                $sentencia->bindParam(":Nombre", $producto["Nombre"]);
                $sentencia->bindParam(":Descripcion", $producto["Descripcion"]);
                $sentencia->bindParam(":Material", $producto["Material"]);
                $sentencia->bindParam(":Precio", $producto["Precio"]);
                $sentencia->bindParam(":Stock", $producto["Stock"]);
                $sentencia->bindParam(":Imagen", $producto["Imagen"]);
                $sentencia->bindParam(":FechaAdquisicion", $producto["FechaAdquisicion"]);
                $sentencia->bindParam(":FechaCaducidad", $producto["FechaCaducidad"]);
                $sentencia->bindParam(":Marca", $producto["Marca"]);
                $sentencia->bindParam(":Peso", $producto["Peso"]);

                // Ejecutamos la sentencia
                $sentencia->execute();

                $idProducto = $producto["idProductos"];

                // Eliminar las categorías existentes del producto
                $sentenciaBorrarCategorias = $conexPDO->prepare("DELETE FROM categorias_has_productos WHERE idProductos = :idProductos");
                $sentenciaBorrarCategorias->bindParam(":idProductos", $idProducto);
                $sentenciaBorrarCategorias->execute();

                // Insertar las nuevas categorías asociadas al producto
                $sentenciaCategoria = $conexPDO->prepare("INSERT INTO categorias_has_productos (idCategorias, idProductos) VALUES (:idCategorias, :idProductos)");
                foreach ($categorias as $idCategoria) {
                    $sentenciaCategoria->bindParam(":idCategorias", $idCategoria);
                    $sentenciaCategoria->bindParam(":idProductos", $idProducto);
                    $sentenciaCategoria->execute();
                }

                // Eliminar los proveedores existentes del producto
                $sentenciaBorrarProveedores = $conexPDO->prepare("DELETE FROM productos_has_proveedores WHERE idProductos = :idProductos");
                $sentenciaBorrarProveedores->bindParam(":idProductos", $idProducto);
                $sentenciaBorrarProveedores->execute();

                // Insertar los nuevos proveedores asociados al producto
                $sentenciaProveedor = $conexPDO->prepare("INSERT INTO productos_has_proveedores (idProductos, idProveedores) VALUES (:idProductos, :idProveedores)");
                foreach ($proveedores as $idProveedor) {
                    $sentenciaProveedor->bindParam(":idProductos", $idProducto);
                    $sentenciaProveedor->bindParam(":idProveedores", $idProveedor);
                    $sentenciaProveedor->execute();
                }

                // Comprobamos y realizamos la transacción
                $result = $conexPDO->commit();
            } catch (PDOException $e) {
                // En caso de error, revertir la transacción
                $conexPDO->rollBack();
                print("Error al acceder a BD" . $e->getMessage());
            }
        }

        return $result;
    }

    //Funcion para borrar productos
    function eliminarProducto($idProducto, $conexPDO)
    {
        $result = null;

        if (isset($idProducto) && is_numeric($idProducto) && $conexPDO != null) {


            if ($conexPDO != null) {
                try {
                    // Iniciar una transacción
                    $conexPDO->beginTransaction();

                    // Eliminar las asociaciones de categorías
                    $sentenciaBorrarCategorias = $conexPDO->prepare("DELETE FROM categorias_has_productos WHERE idProductos = :idProductos");
                    $sentenciaBorrarCategorias->bindParam(":idProductos", $idProducto);
                    $sentenciaBorrarCategorias->execute();

                    // Eliminar las asociaciones de proveedores
                    $sentenciaBorrarProveedores = $conexPDO->prepare("DELETE FROM productos_has_proveedores WHERE idProductos = :idProductos");
                    $sentenciaBorrarProveedores->bindParam(":idProductos", $idProducto);
                    $sentenciaBorrarProveedores->execute();

                    // Eliminar el producto
                    $sentenciaBorrarProducto = $conexPDO->prepare("DELETE FROM productos WHERE idProductos = :idProductos");
                    $sentenciaBorrarProducto->bindParam(":idProductos", $idProducto);
                    $sentenciaBorrarProducto->execute();

                    // Comprobamos y realizamos la transacción
                    $result = $conexPDO->commit();
                } catch (PDOException $e) {
                    // En caso de error, revertir la transacción
                    $conexPDO->rollBack();
                    print("Error al borrar" . $e->getMessage());
                }
            }
        }

        return $result;
    }

    //Funcion para devolver todos los productos de la base de datos
    public function obtenerTodosProductos($conexPDO)
    {
        //Comprobamos que la variable está definida y no es null
        if (isset($conexPDO)) {

            try {
                // Preparamos la sentencia que recogerá todos los datos de las tablas productos, proveedores y categorías
                $sentencia = $conexPDO->prepare("
                SELECT p.*, 
                    GROUP_CONCAT(DISTINCT pr.nombre SEPARATOR ', ') AS Proveedores,
                    GROUP_CONCAT(DISTINCT pr.idProveedores SEPARATOR ', ') AS idProveedores,
                    GROUP_CONCAT(DISTINCT c.nombre SEPARATOR ', ') AS Categorias,
                    GROUP_CONCAT(DISTINCT c.idCategorias SEPARATOR ', ') AS idCategorias
                FROM quesorpresa.productos p
                LEFT JOIN quesorpresa.productos_has_proveedores pp ON p.idProductos = pp.idProductos
                LEFT JOIN quesorpresa.proveedores pr ON pp.idProveedores = pr.idProveedores
                LEFT JOIN quesorpresa.categorias_has_productos pc ON p.idProductos = pc.idProductos
                LEFT JOIN quesorpresa.categorias c ON pc.idCategorias = c.idCategorias
                 GROUP BY p.idProductos            ");
                // Ejecutamos la sentencia
                $sentencia->execute();
                // Devolvemos un listado con todos los productos, incluyendo sus proveedores y categorías
                return $sentencia->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $th) {
                // Mostramos mensaje en caso de error
                print "¡Error al realizar la consulta!: " . $th->getMessage() . "<br/>";
            }
        }
    }

    public function getProductosPag($conexPDO, $ordAsc, string $campoOrd, int $numPag, int $cantElem)
    {
        if ($conexPDO != null) {
            try {
                // Prepara la consulta SQL básica
                $query = "SELECT * FROM quesorpresa.productos ORDER BY $campoOrd ";

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
