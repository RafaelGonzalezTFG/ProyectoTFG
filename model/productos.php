<?php

//Agrupamos todo en modelo
namespace modelo;

//Añadimos las funciones de Utils
require_once("../model/utils.php");

use \PDO;
use \PDOException;

class Productos
{
    //Funcion para añadir productos
    function insertarProducto($producto, $proveedores, $conexPDO)
    {
        $result = null;
        if (isset($producto) && isset($proveedores) && isset($conexPDO)) {
            try {
                //Iniciar la transacción
                $conexPDO->beginTransaction();

                //Preparamos la sentencia
                $sentencia = $conexPDO->prepare("INSERT INTO quesorpresa.productos (Nombre, Descripcion, Material, Precio, Stock, Imagen, FechaAdquisicion, FechaCaducidad, Marca, Peso, idCategorias) VALUES (:Nombre, :Descripcion, :Material, :Precio, :Stock, :Imagen, :FechaAdquisicion, :FechaCaducidad, :Marca, :Peso, :idCategorias)");

                //Asociamos los valores a los parámetros de la sentencia SQL
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
                $sentencia->bindParam(":idCategorias", $producto["idCategorias"]);

                //Ejecutamos la sentencia
                $sentencia->execute();

                //Obtener el ID del producto recién insertado
                $idProducto = $conexPDO->lastInsertId();

                //Insertamos los productos y proveedores
                $sentenciaProveedor = $conexPDO->prepare("INSERT INTO productos_has_proveedores (idProductos, idProveedores) VALUES (:idProductos, :idProveedores)");
                $sentenciaProveedor->bindParam(":idProductos", $idProducto);
                $sentenciaProveedor->bindParam(":idProveedores", $proveedores);
                $sentenciaProveedor->execute();


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

    //Funcion para modificar los productos
    public function modificarProducto($producto, $proveedores, $conexPDO)
    {
        $result = null;
        if (isset($producto) && is_numeric($producto["idProductos"]) && isset($proveedores) && $conexPDO != null) {
            try {
                //Iniciar la transacción
                $conexPDO->beginTransaction();

                //Preparamos la sentencia
                $sentencia = $conexPDO->prepare("UPDATE quesorpresa.productos SET Nombre = :Nombre, Descripcion = :Descripcion, Material = :Material, Precio = :Precio, Stock = :Stock, FechaAdquisicion = :FechaAdquisicion, FechaCaducidad = :FechaCaducidad, Marca = :Marca, Peso = :Peso, idCategorias = :idCategorias, Imagen = :Imagen WHERE idProductos = :idProductos");

                //Asociamos los valores a los parámetros de la sentencia SQL
                $sentencia->bindParam(":idProductos", $producto["idProductos"]);
                $sentencia->bindParam(":Nombre", $producto["Nombre"]);
                $sentencia->bindParam(":Descripcion", $producto["Descripcion"]);
                $sentencia->bindParam(":Material", $producto["Material"]);
                $sentencia->bindParam(":Precio", $producto["Precio"]);
                $sentencia->bindParam(":Stock", $producto["Stock"]);
                $sentencia->bindParam(":FechaAdquisicion", $producto["FechaAdquisicion"]);
                $sentencia->bindParam(":FechaCaducidad", $producto["FechaCaducidad"]);
                $sentencia->bindParam(":Marca", $producto["Marca"]);
                $sentencia->bindParam(":Peso", $producto["Peso"]);
                $sentencia->bindParam(":idCategorias", $producto["idCategorias"]);
                $sentencia->bindParam(":Imagen", $producto["Imagen"]);

                //Ejecutamos la sentencia
                $sentencia->execute();

                $idProducto = $producto["idProductos"];

                //Eliminamos los proveedores existentes del producto
                $sentenciaBorrarProveedores = $conexPDO->prepare("DELETE FROM productos_has_proveedores WHERE idProductos = :idProductos");
                $sentenciaBorrarProveedores->bindParam(":idProductos", $idProducto);
                $sentenciaBorrarProveedores->execute();

                //Insertamos el nuevo proveedor asociado al producto
                $sentenciaProveedor = $conexPDO->prepare("INSERT INTO productos_has_proveedores (idProductos, idProveedores) VALUES (:idProductos, :idProveedores)");
                $sentenciaProveedor->bindParam(":idProductos", $idProducto);
                $sentenciaProveedor->bindParam(":idProveedores", $proveedores);
                $sentenciaProveedor->execute();

                //Comprobamos y realizamos la transacción
                $conexPDO->commit();
                $result = true;
            } catch (PDOException $e) {
                //En caso de error, revertir la transacción
                $conexPDO->rollBack();
                print("Error al acceder a BD: " . $e->getMessage());
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
                    //Iniciamos una transacción
                    $conexPDO->beginTransaction();

                    //Eliminamos las asociaciones de proveedores
                    $sentenciaBorrarProveedores = $conexPDO->prepare("DELETE FROM productos_has_proveedores WHERE idProductos = :idProductos");
                    $sentenciaBorrarProveedores->bindParam(":idProductos", $idProducto);
                    $sentenciaBorrarProveedores->execute();

                    //Eliminamos el producto
                    $sentenciaBorrarProducto = $conexPDO->prepare("DELETE FROM productos WHERE idProductos = :idProductos");
                    $sentenciaBorrarProducto->bindParam(":idProductos", $idProducto);
                    $sentenciaBorrarProducto->execute();

                    //Comprobamos y realizamos la transacción
                    $result = $conexPDO->commit();
                } catch (PDOException $e) {
                    //En caso de error, revertir la transacción
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
                //Preparamos la sentencia que recogerá todos los datos de las tablas productos, proveedores y categorías
                $sentencia = $conexPDO->prepare("SELECT p.*, c.Nombre as NombreCategoria, c.idSuperCategoria FROM productos p INNER JOIN categorias c ON p.idCategorias = c.idCategorias");
                //Ejecutamos la sentencia
                $sentencia->execute();
                //Devolvemos un listado con todos los productos, incluyendo sus proveedores y categorías
                return $sentencia->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $th) {
                //Mostramos mensaje en caso de error
                print "¡Error al realizar la consulta!: " . $th->getMessage() . "<br/>";
            }
        }
    }

    //Funcion para filtrar por las distintas categorias
    public function obtenerProductosPorCategoria($conexPDO, $categoria)
    {
        if (isset($conexPDO)) {
            try {
                $sentencia = $conexPDO->prepare("SELECT p.*, c.Nombre as NombreCategoria, c.idSuperCategoria FROM productos p INNER JOIN categorias c ON p.idCategorias = c.idCategorias WHERE c.Nombre = ?");
                $sentencia->bindParam(1, $categoria, PDO::PARAM_STR);
                $sentencia->execute();
                return $sentencia->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $th) {
                print "¡Error al realizar la consulta!: " . $th->getMessage() . "<br/>";
            }
        }
    }

    //Paginacion para los filtros de la tienda
    public function getProductosCategoriasPag($conexPDO, $categoria, $ordAsc, string $campoOrd, int $numPag, int $cantElem)
    {
        if ($conexPDO != null) {
            try {
                //Prepara la consulta SQL básica
                $query = "SELECT p.*, c.Nombre as NombreCategoria, c.idSuperCategoria FROM productos p INNER JOIN categorias c ON p.idCategorias = c.idCategorias WHERE c.Nombre = :categoria ORDER BY $campoOrd ";

                //Agrega DESC si se requiere orden descendente
                if (!$ordAsc) {
                    $query .= "DESC ";
                }

                //Agrega LIMIT y OFFSET para la paginación
                $query .= "LIMIT :limit OFFSET :offset";

                //Prepara la sentencia
                $sentencia = $conexPDO->prepare($query);

                //BindParam para la categoría
                $sentencia->bindParam(':categoria', $categoria, PDO::PARAM_STR);

                //Define la cantidad de elementos por página
                $sentencia->bindParam(':limit', $cantElem, PDO::PARAM_INT);

                //Calcula el OFFSET basado en el número de página
                $offset = ($numPag - 1) * $cantElem;
                $sentencia->bindParam(':offset', $offset, PDO::PARAM_INT);

                //Ejecuta la sentencia
                $sentencia->execute();

                //Devuelve los resultados
                return $sentencia->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                print("Error al acceder a BD: " . $e->getMessage());
            }
        }
    }
    //Paginacion normal
    public function getProductosPag($conexPDO, $ordAsc, string $campoOrd, int $numPag, int $cantElem)
    {
        if ($conexPDO != null) {
            try {
                //Prepara la consulta SQL básica
                $query = "SELECT p.*, c.Nombre as NombreCategoria, c.idSuperCategoria FROM productos p INNER JOIN categorias c ON p.idCategorias = c.idCategorias ORDER BY $campoOrd ";

                //Agrega DESC si se requiere orden descendente
                if (!$ordAsc) {
                    $query .= "DESC ";
                }

                //Agrega LIMIT y OFFSET para la paginación
                $query .= "LIMIT ? OFFSET ?";

                //Prepara la sentencia
                $sentencia = $conexPDO->prepare($query);

                //Define la cantidad de elementos por página
                $sentencia->bindParam(1, $cantElem, PDO::PARAM_INT);

                //Calcula el OFFSET basado en el número de página
                $offset = ($numPag - 1) * $cantElem;
                $sentencia->bindParam(2, $offset, PDO::PARAM_INT);

                //Ejecuta la sentencia
                $sentencia->execute();

                //Devuelve los resultados
                return $sentencia->fetchAll();
            } catch (PDOException $e) {
                print("Error al acceder a BD: " . $e->getMessage());
            }
        }
    }

    //Funcion para obtener el producto por el id
    public function obtenerProductoID($conexPDO, $idProductos)
    {
        if ($conexPDO != null && isset($idProductos)) {
            try {
                //Preparamos la consulta para verificar el código de activación
                $sentencia = $conexPDO->prepare("SELECT p.*, c.Nombre as NombreCategoria, c.idSuperCategoria FROM productos p INNER JOIN categorias c ON p.idCategorias = c.idCategorias WHERE idProductos = :idProductos");
                $sentencia->bindParam(":idProductos", $idProductos);
                $sentencia->execute();
                $resultado = $sentencia->fetch(PDO::FETCH_ASSOC);

                return $resultado;
            } catch (PDOException $e) {
                print("Error al acceder a BD: " . $e->getMessage());
            }
        }
    }
}
