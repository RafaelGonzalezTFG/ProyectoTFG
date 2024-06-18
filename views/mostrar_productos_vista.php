<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Productos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../sass/generales/estiloNavegacion.css">
    <link rel="stylesheet" href="../sass/generales/estiloFooter.css">
    <link rel="stylesheet" href="../sass/estiloMostrarProductos.css">
</head>

<body>
    <nav class="navbar navbar-expand-md fixed-top">
        <div class="container-fluid">
            <!-- Logo de la tienda-->
            <a class="navbar-brand" href="../controller/main_controlador.php">
                <img src="../img/Quesorpresa.png" alt="Logo" class="img-fluid">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- Lista de pestañas para navegar por la aplicación -->
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav ms-auto">
                    <!-- Comprobamos con las session que sea un administrador -->
                    <?php if (isset($rolp) && $rolp == "Admin") : ?>
                        <li class='nav-item'>
                            <a class='nav-link' href='../controller/mostrar_producto_controlador.php'>
                                <img src='../img/Editar.png' alt='Editar' class='img-fluid'>
                            </a>
                        </li>
                    <?php endif; ?>
                    <!-- Redireccion a contactos -->
                    <li class="nav-item">
                        <a class="nav-link" href="../controller/contactos_controlador.php">
                            <img src="../img/Correo.png" alt="Correo" class="img-fluid">
                        </a>
                    </li>
                    <!-- Redireccion a mi cuenta -->
                    <li class="nav-item">
                        <a class="nav-link" href="../controller/mi_cuenta_controlador.php">
                            <img src="../img/MiCuenta.png" alt="Mi Cuenta" class="img-fluid">
                        </a>
                    </li>
                    <!-- Redireccion a carrito -->
                    <li class="nav-item">
                        <a class="nav-link" href="../controller/carrito_controlador.php">
                            <img src="../img/Carrito.png" alt="Carrito" class="img-fluid">
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container-fluid mt-navbar">
        <div class="row">
            <!-- Sidebar -->
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar">
                <div class="position-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item  active">
                            <a class="nav-link" href="../controller/mostrar_producto_controlador.php">
                                <span data-feather="box"></span>
                                Productos
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../controller/mostrar_usuario_controlador.php">
                                <span data-feather="user"></span>
                                Usuarios
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 mt-navbar">

                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Gestión de los Productos</h1>
                </div>

                <div class="w-100 d-flex justify-content-start mb-2">
                    <form method="POST" action="../controller/redireccionador_productos.php">
                        <button class="btn btn-warning" name="insertar" value="true">Insertar un nuevo Producto</button>
                    </form>
                </div>
                <!-- Product Management Table -->
                <div class="table-responsive">
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Precio</th>
                                <th>Stock</th>
                                <th>FechaAdquisicion</th>
                                <th>FechaCaducidad</th>
                                <th>Categoria</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (!empty($datosProductos)) {
                                foreach ($datosProductos as $producto) {
                                    echo "<tr>\n";
                                    echo "<td>" . htmlspecialchars($producto["Nombre"]) . "</td>\n";
                                    echo "<td>" . htmlspecialchars($producto["Precio"]) . "</td>\n";
                                    echo "<td>" . htmlspecialchars($producto["Stock"]) . "</td>\n";
                                    echo "<td>" . htmlspecialchars($producto["FechaAdquisicion"]) . "</td>\n";
                                    echo "<td>" . htmlspecialchars($producto["FechaCaducidad"]) . "</td>\n";
                                    echo "<td>" . htmlspecialchars($producto["NombreCategoria"]) . "</td>\n";
                                    //Comienzo Botones
                                    echo "<td class='d-flex justify-content-around'>\n";
                                    //Boton Editar
                                    echo "<form method='POST' action='../controller/redireccionador_productos.php' class='d-inline'>\n";
                                    echo "<input type='hidden' name='idProductos' value='" . $producto["idProductos"] . "' />\n";
                                    echo "<button name='modificar' value='true' class='btn btn-success btn-sm'>Modificar</button>\n";
                                    echo "</form>\n";
                                    //Boton Eliminar
                                    echo "<form method='POST' action='../controller/borrar_productos_controlador.php' class='d-inline'>\n";
                                    echo "<input type='hidden' name='idProductos' value='" . $producto["idProductos"] . "' />\n";
                                    echo "<button class='btn btn-danger btn-sm'>Eliminar</button>\n";
                                    echo "</form>\n";
                                    //Fin Botones
                                    echo "</td>\n";
                                    echo "</tr>\n";
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <!-- Paginación -->
                <div class="d-flex justify-content-center my-3">
                    <form method="POST" action="../controller/mostrar_usuario_controlador.php">
                        <?php
                        for ($i = 1; $i <= $totalPaginas; $i++) {
                            echo "<button name='Pag' value='$i' class='btn btn-warning mx-1'>$i</button>";
                        }
                        ?>
                    </form>
                </div>
            </main>
        </div>
    </div>
    <footer class="py-3">
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
                    <ul class="nav flex-column list-unstyled">
                        <li class="nav-item mb-2">Black Friday 2024</li>
                        <li class="nav-item mb-2">Cyber Monday 2024</li>
                        <li class="nav-item mb-2">Día de la Madre</li>
                        <li class="nav-item mb-2">Día del Padre</li>
                    </ul>
                </div>
                <!-- Listado de Atencion al cliente -->
                <div class="col-md-4">
                    <h5>Atención al cliente</h5>
                    <hr>
                    <ul class="list-unstyled">
                        <li class="nav-item mb-2">Envíos</li>
                        <li class="nav-item mb-2">Devoluciones</li>
                        <li class="nav-item mb-2">Condiciones de oferta</li>
                        <li class="nav-item mb-2">Preguntas Frecuentes</li>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <script>
        feather.replace()
    </script>
</body>

</html>