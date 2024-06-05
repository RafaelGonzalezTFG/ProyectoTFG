<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Productos</title>
    <link rel="icon" href="../img/Quesorpresa.png" type="image/x-icon">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../sass/estilo.css">
</head>

<body>
    <!-- Barra de Navegacion -->
    <nav class="navbar navbar-expand-md fixed-top navegacionTienda">
        <div class="container-fluid">
            <!-- Lugar del logo de la tienda -->
            <a class="navbar-brand" href="../controller/main_controlador.php">
                <img src="../img/Quesorpresa.png" alt="Logo de la tienda de quesos online Quesorpresa" class="img-fluid">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <!-- Buscador -->
                <form class="d-md-flex mx-auto">
                    <input class="form-control me-2" type="search" placeholder="Buscar Quesorpresa.es" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">
                        <img src="../img/Lupa.png" alt="Buscar" class="img-fluid iconoBuscador">
                    </button>
                </form>
                <!-- Iconos de las paginas -->
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <img src="../img/Editar.png" alt="Editar" class="img-fluid iconosPaginas">
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <img src="../img/Correo.png" alt="Correo" class="img-fluid iconosPaginas">
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <img src="../img/MiCuenta.png" alt="Mi Cuenta" class="img-fluid iconosPaginas">
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <img src="../img/Carrito.png" alt="Carrito" class="img-fluid iconosPaginas">
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Contenido principal de la pagina principal-->
    <main class="contenidoPrincipal">
        <!-- Titulo de la pagina -->
        <div class="d-flex justify-content-center">
            <h1>
                Productos
            </h1>
        </div>

        <!-- Listado de los productos-->
        <form method="POST" action="#">

            <div class="container">

                <div class="row">
                    <div class="col-lg-9 col-sm-9">
                        <table class="table">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Precio</th>
                                    <th scope="col">Stock</th>
                                    <th scope="col"></th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                // ...
                                var_dump($datosProductos);
                                foreach ($datosProductos as $producto) {
                                    // Comienzo de fila
                                    print("<tr>\n");

                                    // Nombre
                                    print("<td scope='row'>" . $producto["Nombre"] . "</td>\n");

                                    // Precio
                                    print("<td>" . $producto["Precio"] . "</td>\n");

                                    // Stock
                                    print("<td>" . $producto["Stock"] . "</td>\n");


                                    //Boton para eliminar un producto
                                    print("<td>\n");
                                    print("<form method='POST' action='../controller/borrar_productos_controlador.php'>");
                                    print("<input type='hidden' name='idProductos' value='" . $producto["idProductos"] . "' />");
                                    print("<button class='btn btn-danger'>Eliminar</button>");
                                    print("</form>");
                                    print("</td>\n");

                                    //Boton para modificar un producto
                                    print("<td>\n");
                                    print("<form method='POST' action='../controller/modificar_producto_controlador.php'>");
                                    print("<input type='hidden' name='idProductos' value='" . $producto["idProductos"] . "' />");
                                    print("<input type='hidden' name='Nombre' value='" . $producto["Nombre"] . "' />");
                                    print("<input type='hidden' name='Descripcion' value='" . $producto["Descripcion"] . "' />");
                                    print("<input type='hidden' name='Material' value='" . $producto["Material"] . "' />");
                                    print("<input type='hidden' name='Precio' value='" . $producto["Precio"] . "' />");
                                    print("<input type='hidden' name='Stock' value='" . $producto["Stock"] . "' />");
                                    print("<input type='hidden' name='Imagen' value='" . $producto["Imagen"] . "' />");
                                    print("<input type='hidden' name='FechaAdquisicion' value='" . $producto["FechaAdquisicion"] . "' />");
                                    print("<input type='hidden' name='FechaCaducidad' value='" . $producto["FechaCaducidad"] . "' />");
                                    print("<input type='hidden' name='Marca' value='" . $producto["Marca"] . "' />");
                                    print("<input type='hidden' name='Peso' value='" . $producto["Peso"] . "' />");
                                    

                                    print("<button name='modificar' value='false' class='btn btn-primary'>Modificar</button>");
                                    print("</form>");
                                    print("</td>\n");
                                    // Final de fila
                                    print("</tr>\n");
                                }

                                ?>


                            </tbody>
                        </table>
                    </div>

                    <div>
                        <input type="text" placeholder="<?php var_dump($totalPaginas);
                                                        var_dump($totalPaginas);
                                                        var_dump($itemsPorPagina);
                                                        var_dump($paginaActual); ?>">
                    </div>
                    <div class="col-lg-3 col-sm-3 text-end">
                        <?php
                        print("<form method='POST' action='../controller/insertar_producto_controlador.php'>");
                        print("<button class='btn btn-success'>Insertar un nuevo Producto</button>");
                        print("</form>");
                        ?>
                    </div>
                </div>

                <form method="POST" action="../controller/gestionar_productos_controlador.php">
                    <?php
                    for ($i = 1; $i <= $totalPaginas; $i++) {
                        echo "<button name='Pag' value='$i' class='btn btn-primary'>$i</button>";
                    }
                    ?>
                </form>

            </div>
        </form>
    </main>

    <!-- Pie de pagina -->
    <footer class="footer piePagina">
        <div class="container text-center">
            <div class="row">
                <!-- Logo de la tienda en el pie de la pagina -->
                <div class="col-md-4">
                    <h2>Quesorpresa</h2>
                    <hr>
                </div>
                <!-- Listado de las ocasiones especiales -->
                <div class="col-md-4">
                    <h5>Ocasiones</h5>
                    <hr>
                    <ul class="list-unstyled">
                        <li>Black Friday 2024</li>
                        <li>Cyber Monday 2024</li>
                        <li>Día de la Madre</li>
                        <li>Día del Padre</li>
                    </ul>
                </div>
                <!-- Listado de Atencion al cliente -->
                <div class="col-md-4">
                    <h5>Atención al cliente</h5>
                    <hr>
                    <ul class="list-unstyled">
                        <li>Envíos</li>
                        <li>Devoluciones</li>
                        <li>Condiciones de oferta</li>
                        <li>Preguntas Frecuentes</li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <!-- Modal -->
    <div class="modal fade" id="aviso" tabindex="-1" aria-labelledby="avisoLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="avisoLabel">Aviso</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php echo $mensaje; ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <?php
    if ($mensaje != null && isset($mensaje)) {
        echo "<script>
        $(document).ready(function(){
            $('#aviso').modal('show');
            $('#aviso .btn-close, #aviso .btn-secondary').click(function() {
                $('#aviso').modal('hide');
            });
        });
        </script>";
    }
    ?>
</body>

</html>
