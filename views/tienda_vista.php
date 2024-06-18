<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../sass/generales/estiloNavegacion.css">
    <link rel="stylesheet" href="../sass/generales/estiloFooter.css">
    <link rel="stylesheet" href="../sass/estiloTienda.css">
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
            <nav class="col-md-2 d-md-block bg-light sidebar p-3">
                <div class="position-sticky">
                    <ul class="nav flex-column">
                        <!-- Filtros -->
                        <li class="nav-item">
                            <form method="POST" action="../controller/tienda_controlador.php">
                                <input type="hidden" name="Categoria" value="Todo">
                                <button type="submit" class="nav-link active">Todo</button>
                            </form>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#ovejaSubmenu" data-bs-toggle="collapse" aria-expanded="false" aria-controls="ovejaSubmenu">Leche de Oveja</a>
                            <ul class="collapse list-unstyled submenu" id="ovejaSubmenu">
                                <li class="nav-item">
                                    <form method="POST" action="../controller/tienda_controlador.php">
                                        <input type="hidden" name="Categoria" value="Queso Manchego">
                                        <button type="submit" class="nav-link">Queso Manchego</button>
                                    </form>
                                </li>
                                <li class="nav-item">
                                    <form method="POST" action="../controller/tienda_controlador.php">
                                        <input type="hidden" name="Categoria" value="Idiazábal">
                                        <button type="submit" class="nav-link">Idiazábal</button>
                                    </form>
                                </li>
                                <li class="nav-item">
                                    <form method="POST" action="../controller/tienda_controlador.php">
                                        <input type="hidden" name="Categoria" value="Roncal">
                                        <button type="submit" class="nav-link">Roncal</button>
                                    </form>
                                </li>
                                <li class="nav-item">
                                    <form method="POST" action="../controller/tienda_controlador.php">
                                        <input type="hidden" name="Categoria" value="Zamorano">
                                        <button type="submit" class="nav-link">Zamorano</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#cabraSubmenu" data-bs-toggle="collapse" aria-expanded="false" aria-controls="cabraSubmenu">Leche de Cabra</a>
                            <ul class="collapse list-unstyled submenu" id="cabraSubmenu">
                                <li class="nav-item">
                                    <form method="POST" action="../controller/tienda_controlador.php">
                                        <input type="hidden" name="Categoria" value="Tetilla">
                                        <button type="submit" class="nav-link">Tetilla</button>
                                    </form>
                                </li>
                                <li class="nav-item">
                                    <form method="POST" action="../controller/tienda_controlador.php">
                                        <input type="hidden" name="Categoria" value="Mahón">
                                        <button type="submit" class="nav-link">Mahón</button>
                                    </form>
                                </li>
                                <li class="nav-item">
                                    <form method="POST" action="../controller/tienda_controlador.php">
                                        <input type="hidden" name="Categoria" value="San Simón da Costa">
                                        <button type="submit" class="nav-link">San Simón da Costa</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#vacaSubmenu" data-bs-toggle="collapse" aria-expanded="false" aria-controls="vacaSubmenu">Leche de Vaca</a>
                            <ul class="collapse list-unstyled submenu" id="vacaSubmenu">
                                <li class="nav-item">
                                    <form method="POST" action="../controller/tienda_controlador.php">
                                        <input type="hidden" name="Categoria" value="Murcia al Vino">
                                        <button type="submit" class="nav-link">Murcia al Vino</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#mezclaSubmenu" data-bs-toggle="collapse" aria-expanded="false" aria-controls="mezclaSubmenu">Mezcla de leches</a>
                            <ul class="collapse list-unstyled submenu" id="mezclaSubmenu">
                                <li class="nav-item">
                                    <form method="POST" action="../controller/tienda_controlador.php">
                                        <input type="hidden" name="Categoria" value="Cabrales">
                                        <button type="submit" class="nav-link">Cabrales</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#cortadoresSubmenu" data-bs-toggle="collapse" aria-expanded="false" aria-controls="cortadoresSubmenu">Cortadores de Queso</a>
                            <ul class="collapse list-unstyled submenu" id="cortadoresSubmenu">
                                <li class="nav-item">
                                    <form method="POST" action="../controller/tienda_controlador.php">
                                        <input type="hidden" name="Categoria" value="Guillotina para quesos">
                                        <button type="submit" class="nav-link">Guillotina para quesos</button>
                                    </form>
                                </li>
                                <li class="nav-item">
                                    <form method="POST" action="../controller/tienda_controlador.php">
                                        <input type="hidden" name="Categoria" value="Cortador de Alambre">
                                        <button type="submit" class="nav-link">Cortador de Alambre</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#ralladoresSubmenu" data-bs-toggle="collapse" aria-expanded="false" aria-controls="ralladoresSubmenu">Ralladores de Queso</a>
                            <ul class="collapse list-unstyled submenu" id="ralladoresSubmenu">
                                <li class="nav-item">
                                    <form method="POST" action="../controller/tienda_controlador.php">
                                        <input type="hidden" name="Categoria" value="Rallador de tambor">
                                        <button type="submit" class="nav-link">Rallador de tambor</button>
                                    </form>
                                </li>
                                <li class="nav-item">
                                    <form method="POST" action="../controller/tienda_controlador.php">
                                        <input type="hidden" name="Categoria" value="Rallador plano">
                                        <button type="submit" class="nav-link">Rallador plano</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#tablasSubmenu" data-bs-toggle="collapse" aria-expanded="false" aria-controls="tablasSubmenu">Tabla para cortar Queso</a>
                            <ul class="collapse list-unstyled submenu" id="tablasSubmenu">
                                <li class="nav-item">
                                    <form method="POST" action="../controller/tienda_controlador.php">
                                        <input type="hidden" name="Categoria" value="Tablas de madera">
                                        <button type="submit" class="nav-link">Tablas de madera</button>
                                    </form>
                                </li>
                                <li class="nav-item">
                                    <form method="POST" action="../controller/tienda_controlador.php">
                                        <input type="hidden" name="Categoria" value="Tabla de marmol">
                                        <button type="submit" class="nav-link">Tabla de marmol</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>



            <main class="col-md-10 ms-sm-auto col-lg-10 px-md-4 main-content mt-navbar">
                <div class="row">
                    <?php foreach ($datosProductos as $producto) : ?>
                        <div class="col-md-3">
                            <div class="card product-card">
                                <img src="../img/imagenesSubidas/<?php echo $producto['Imagen']; ?>" class="card-img-top product-img" alt="<?php echo $producto['Nombre']; ?>">
                                <div class="card-body">
                                    <h6 class="card-title"><?php echo $producto['Nombre']; ?></h6>
                                    <p class="card-text"><?php echo number_format($producto['Precio'], 2); ?>€</p>
                                    <form action="../controller/detalles_producto_controlador.php" method="post" style="display:inline;">
                                        <input type="hidden" name="idProductos" value="<?php echo $producto['idProductos']; ?>">
                                        <button type="submit" class="btn btn-secondary btn-custom">Ver Detalles</button>
                                    </form>
                                    <button class="btn btn-warning btn-custom" onclick="addToCart(<?php echo $producto['idProductos']; ?>, '<?php echo $producto['Nombre']; ?>', <?php echo $producto['Precio']; ?>, '<?php echo $producto['Imagen']; ?>')">Añadir al carrito</button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </main>

            <!-- Paginación -->
            <div class="d-flex justify-content-center my-3">
                <form method="POST" action="../controller/tienda_controlador.php">
                    <?php for ($i = 1; $i <= $totalPaginas; $i++) : ?>
                        <button name="Pag" value="<?php echo $i; ?>" class="btn btn-warning mx-1"><?php echo $i; ?></button>
                    <?php endfor; ?>
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

    <script src="../js/tienda.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>