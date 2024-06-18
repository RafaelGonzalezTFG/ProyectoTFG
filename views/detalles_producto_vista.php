<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../sass/generales/estiloNavegacion.css">
    <link rel="stylesheet" href="../sass/generales/estiloFooter.css">
    <link rel="stylesheet" href="../sass/estiloDetallesProducto.css">
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
    <div class="container my-5 mt-navbar">
        <div class="card product-card">
            <div class="row g-0">
                <div class="col-md-4">
                    <img src="../img/imagenesSubidas/<?php echo $producto['Imagen']; ?>" class="img-fluid rounded-start product-img" alt="Imagen del producto">
                </div>
                <div class="col-md-8">
                    <div class="card-body product-info">
                        <h5 class="card-title"><?php echo $producto['Nombre']; ?></h5>
                        <p class="card-text"><?php echo $producto['Descripcion']; ?></p>
                        <p class="card-text">Categoría: <?php echo $producto['NombreCategoria']; ?></p>
                        <p class="card-text">Peso: <?php echo $producto['Peso']; ?> gr</p>
                        <h5 class="card-text"><?php echo $producto['Precio']; ?>€</h5>
                        <div class="d-flex align-items-center">
                            <div class="d-flex justify-content-center align-items-center">
                                <button type="button" class="btn btn-warning btn-sm" onclick="decrement()">-</button>
                                <input type="number" id="quantity" value="1" class="form-control text-center mx-2 quantity-input" min="1" max="<?php echo $producto['Stock']; ?>">
                                <button type="button" class="btn btn-warning btn-sm" onclick="increment()">+</button>
                            </div>
                        </div>
                        <button class="btn btn-warning mt-3" onclick="addToCart(<?php echo $producto['idProductos']; ?>, '<?php echo $producto['Nombre']; ?>', <?php echo $producto['Precio']; ?>, '<?php echo $producto['Imagen']; ?>')">Añadir al carrito</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Volver a la página anterior -->
    <div class="d-flex justify-content-start mb-4">
        <form action="../controller/tienda_controlador.php" method="POST">
            <button class="btn btn-warning" type="submit">
                Volver Atr&aacute;s
            </button>
        </form>
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

    <script src="../js/detallesProducto.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>