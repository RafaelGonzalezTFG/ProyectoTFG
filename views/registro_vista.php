<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link rel="icon" href="../img/Quesorpresa.png" type="image/x-icon">
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../sass/generales/estiloNavegacion.css">
    <link rel="stylesheet" href="../sass/generales/estiloFooter.css">
    <link rel="stylesheet" href="../sass/estiloRegistro.css">
    <link rel="stylesheet" href="../sass/paginas/estiloInicio.css">
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
    <main class="contenidoRegistro">
        <div class="container mt-navbar">
            <div class="login-container">
                <h2 class="text-center">CREAR CUENTA</h2>
                <hr>
                <?php
                if (session_status() == PHP_SESSION_NONE) {
                    session_start();
                }
                if (isset($_SESSION['message'])) {
                    echo '<div class="alert alert-' . $_SESSION['message_type'] . '">' . $_SESSION['message'] . '</div>';
                    unset($_SESSION['message']);
                    unset($_SESSION['message_type']);
                }
                ?>
                <div id="alertContainer" class="alert-container"></div>
                <form id="registroForm" action="../controllers/controlador_registro.php" method="post">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="Nombre" class="form-label">Nombre:</label>
                            <input type="text" class="form-control" id="Nombre" name="Nombre" placeholder="Introduzca su nombre" required>
                            <div class="error" id="errorNombre"></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="Apellido" class="form-label">Apellido:</label>
                            <input type="text" class="form-control" id="Apellido" name="Apellido" placeholder="Introduzca su apellido" required>
                            <div class="error" id="errorApellido"></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="Telefono" class="form-label">Teléfono:</label>
                        <input type="number" class="form-control" id="Telefono" name="Telefono" placeholder="Introduzca su teléfono" required>
                        <div class="error" id="errorTelefono"></div>
                    </div>
                    <div class="mb-3">
                        <label for="Correo" class="form-label">Correo Electrónico:</label>
                        <input type="email" class="form-control" id="Correo" name="Correo" placeholder="Introduzca su correo electrónico" required>
                        <div class="error" id="errorCorreo"></div>
                    </div>
                    <div class="mb-3">
                        <label for="Contrasena" class="form-label">Contraseña:</label>
                        <input type="password" class="form-control" id="Contrasena" name="Contrasena" placeholder="Introduzca su contraseña" required>
                        <div class="error" id="errorContrasena"></div>
                    </div>
                    <button type="submit" class="btn btn-custom w-100">Crear Cuenta</button>
                </form>
                <hr>
                <div class="text-center mt-3">
                    <p>¿Tienes una cuenta ya? Logueate:</p>
                    <a href="#" class="btn btn-custom w-100">Iniciar Sesión</a>
                </div>
            </div>
        </div>
    </main>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/registro.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css" rel="stylesheet">
</body>

</html>