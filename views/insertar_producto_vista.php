<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insertar Productos</title>
    <link rel="icon" href="../img/Quesorpresa.png" type="image/x-icon">

    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../sass/paginas/estiloInicio.css">
    <link rel="stylesheet" href="../sass/generales/estiloNavegacion.css">
    <link rel="stylesheet" href="../sass/generales/estiloFooter.css">

</head>

<body>
    <!-- Barra de Navegacion -->
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

    <!-- Contenido principal de la pagina principal-->
    <main class="contenidoPrincipal py-5">
        <div class="container">

            <!-- Volver a la página anterior -->
            <div class="d-flex justify-content-start mb-4">
                <form action="../controller/mostrar_producto_controlador.php" method="POST">
                    <button class="btn btn-secondary" type="submit">
                        Volver Atr&aacute;s
                    </button>
                </form>
            </div>

            <!-- Titulo de la pagina -->
            <div class="d-flex justify-content-center">
                <h1>Productos</h1>
            </div>

            <!-- Formulario con todos los campos del producto -->
            <div class="d-flex justify-content-center">
                <form method="POST" action="../controller/insertar_producto_controlador.php" class="w-75" enctype="multipart/form-data">
                    <div class="form-group row mb-3">
                        <label for="Nombre" class="col-lg-3 col-form-label">Nombre del producto:</label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control" id="Nombre" name="Nombre" placeholder="Introduzca el Nombre" />
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="Descripcion" class="col-lg-3 col-form-label">Descripci&oacute;n:</label>
                        <div class="col-lg-9">
                            <textarea class="form-control" id="Descripcion" name="Descripcion" placeholder="Introduzca la descripci&oacute;n"></textarea>
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="Peso" class="col-lg-3 col-form-label">Peso:</label>
                        <div class="col-lg-9">
                            <input type="number" class="form-control" id="Peso" name="Peso" placeholder="Introduzca el peso en gramos" />
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="Material" class="col-lg-3 col-form-label">Material:</label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control" id="Material" name="Material" placeholder="Introduzca el material" />
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="Marca" class="col-lg-3 col-form-label">Marca:</label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control" id="Marca" name="Marca" placeholder="Introduzca la marca" />
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="Proveedores" class="col-lg-3 col-form-label">Proveedores:</label>
                        <div class="col-lg-9">
                            <select name="Proveedores" id="Proveedores" class="form-control">
                                <?php
                                if (empty($datosProveedores)) {
                                    echo "<option>No se encontraron proveedores</option>";
                                } else {
                                    foreach ($datosProveedores as $proveedor) {
                                        echo "<option value='" . htmlspecialchars($proveedor["idProveedores"], ENT_QUOTES, 'UTF-8') . "'>" . htmlspecialchars($proveedor["Nombre"], ENT_QUOTES, 'UTF-8') . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="Categorias" class="col-lg-3 col-form-label">Categorias:</label>
                        <div class="col-lg-9">
                            <select name="Categorias" id="Categorias" class="form-control">
                                <?php
                                if (empty($datosCategorias)) {
                                    echo "<option>No se encontraron proveedores</option>";
                                } else {
                                    foreach ($datosCategorias as $categorias) {
                                        if ($categorias["idCategorias"] > 16) {
                                            echo "<option value='" . htmlspecialchars($categorias["idCategorias"], ENT_QUOTES, 'UTF-8') . "'>" . htmlspecialchars($categorias["Nombre"], ENT_QUOTES, 'UTF-8') . "</option>";
                                        }
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="Precio" class="col-lg-3 col-form-label">Precio:</label>
                        <div class="col-lg-9">
                            <input type="number" class="form-control" id="Precio" name="Precio" placeholder="Introduzca el precio" step="0.01" />
                        </div>
                    </div>


                    <div class="form-group row mb-3">
                        <label for="Stock" class="col-lg-3 col-form-label">Stock:</label>
                        <div class="col-lg-9">
                            <input type="number" class="form-control" id="Stock" name="Stock" placeholder="Introduzca el stock disponible" />
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="FechaAdquisicion" class="col-lg-3 col-form-label">Fecha Adquisición:</label>
                        <div class="col-lg-9">
                            <input type="date" class="form-control" id="FechaAdquisicion" name="FechaAdquisicion" />
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="FechaCaducidad" class="col-lg-3 col-form-label">Fecha Caducidad:</label>
                        <div class="col-lg-9">
                            <input type="date" class="form-control" id="FechaCaducidad" name="FechaCaducidad" />
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="Imagen" class="col-lg-3 col-form-label">Imagen:</label>
                        <div class="col-lg-9">
                            <input type="file" class="form-control" id="Imagen" name="Imagen" accept=".jpg, .jpeg, .png" />
                        </div>
                    </div>

                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-warning">Añadir</button>
                    </div>
                </form>
            </div>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>

</html>