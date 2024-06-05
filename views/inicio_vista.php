<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link rel="icon" href="../img/Quesorpresa.png" type="image/x-icon">


    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../bootstrap/css/bootstrap.css" rel="stylesheet">
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
                        <a class="nav-link" href="../controller/gestionar_productos_controlador.php">
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
                Bienvenido a Quesorpresa
            </h1>
        </div>
        <!-- Eslogan de la pagina -->
        <div class="d-flex justify-content-center">
            <h2>
                De tu tienda a la mesa
            </h2>
        </div>

        <!-- Imagen general de la tienda -->
        <div class="d-flex justify-content-center mt-3 px-4 px-lg-5 my-5">
            <img src="../img/TiendaQuesos1.jpg" alt="Primera imagen de quesos en la tienda" class="imagenReducida ">
        </div>

        <!-- Titulo -->
        <div class="d-flex justify-content-center">
            <h2>
                Nuestros Productos
            </h2>
        </div>

        <!-- Imagenes de los tipos de productos de la tienda -->
        <div class="d-flex justify-content-center row g-4">
            <div class="col-md-3">
                <div class="card">
                    <img src="../img/TiendaQuesos1.jpg" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <a href="#" class="btn btn-primary">Go somewhere</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <img src="../img/TiendaQuesos1.jpg" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <a href="#" class="btn btn-primary">Go somewhere</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <img src="../img/TiendaQuesos1.jpg" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <a href="#" class="btn btn-primary">Go somewhere</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Apartado para ir a contactos -->
        <div class="d-flex text-center mt-5">
            <p>Para cualquier problema, revise el apartado de preguntas frecuentes. En caso de no encontrar una solución satisfactoria, póngase en contacto con nosotros</p>
        </div>
        <div class="d-flex text-center">
            <a href="#" class="btn btn-warning">Contactos</a>
        </div>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>