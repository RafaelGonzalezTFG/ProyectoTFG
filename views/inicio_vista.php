<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido a Quesorpresa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../sass/paginas/estiloInicio.css">
    <link rel="stylesheet" href="../sass/generales/estiloNavegacion.css">
    <link rel="stylesheet" href="../sass/generales/estiloFooter.css">

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

    <div class="container py-5 mt-navbar">
        <!-- Título y bienvenida -->
        <div class="text-center mb-4">
            <h1>Bienvenido a Quesorpresa</h1>
            <p>De tu tienda a la mesa</p>
        </div>

        <!-- Imagen grande de quesos -->
        <div class="mb-4">
            <img src="../img/TiendaQuesos1.jpg" class="img-fluid" alt="Quesos variados">
        </div>

        <!-- Tipos de Quesos por Leche -->
        <h2>Tipos de Quesos por Leche</h2>
        <hr>
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="card">
                    <img src="../img/Inicio1.jpg" class="card-img-top" alt="Queso de Oveja">
                    <a href="../controller/tienda_controlador.php">
                        <div class="card-body">
                            <h5 class="card-title">Leche de Oveja</h5>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <img src="../img/Inicio2.jpg" class="card-img-top" alt="Queso de Cabra">
                    <a href="../controller/tienda_controlador.php">
                        <div class="card-body">
                            <h5 class="card-title">Leche de Cabra</h5>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <img src="../img/Inicio3.jpg" class="card-img-top" alt="Queso de Vaca">
                    <a href="../controller/tienda_controlador.php">
                        <div class="card-body">
                            <h5 class="card-title">Leche de Vaca</h5>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <!-- Utensilios -->
        <h2>Utensilios</h2>
        <hr>
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="card">
                    <img src="../img/Inicio4.jpg" class="card-img-top" alt="Utensilio 1">
                    <a href="../controller/tienda_controlador.php">
                        <div class="card-body">
                            <h5 class="card-title">Cortador para Queso</h5>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <img src="../img/Inicio5.jpg" class="card-img-top" alt="Utensilio 2">
                    <a href="../controller/tienda_controlador.php">
                        <div class="card-body">
                            <h5 class="card-title">Rallador de Queso</h5>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <img src="../img/Inicio6.jpg" class="card-img-top" alt="Utensilio 3">
                    <a href="../controller/tienda_controlador.php">
                        <div class="card-body">
                            <h5 class="card-title">Tabla para Queso</h5>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <hr>

        <!-- Contacto -->
        <div class="contact-btn-container mt-5">
            <p>Para cualquier problema, revise el apartado de preguntas frecuentes. En caso de no encontrar una solución satisfactoria, póngase en contacto con nosotros.</p>
            <a href="../controller/contactos_controlador.php" class="btn btn-warning">Contactos</a>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>