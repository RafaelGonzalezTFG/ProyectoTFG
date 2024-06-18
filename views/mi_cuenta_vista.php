<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi cuenta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../sass/generales/estiloNavegacion.css">
    <link rel="stylesheet" href="../sass/generales/estiloFooter.css">
    <link rel="stylesheet" href="../sass/estiloMiCuenta.css">
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
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-center">
                        <h2>Mi cuenta</h2>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <strong>Nombre:</strong> <?php echo $datosCuenta["Nombre"] ?>
                            </li>
                            <li class="list-group-item">
                                <strong>Apellido:</strong> <?php echo $datosCuenta["Apellido"] ?>
                            </li>
                            <li class="list-group-item">
                                <strong>Telefono:</strong> <?php echo $datosCuenta["Telefono"] ?>

                            </li>
                            <li class="list-group-item">
                                <strong>Correo:</strong> <?php echo $datosCuenta["Correo"] ?>
                            </li>
                        </ul>
                        <form action="../controller/desloguear_usuario_controlador.php" method="post" class="mt-3">
                            <button type="submit" class="btn btn-danger">Cerrar sesión</button>
                        </form>
                    </div>
                </div>
            </div>
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