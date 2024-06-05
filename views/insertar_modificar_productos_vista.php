<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insertar/Modificar Productos</title>
    <link rel="icon" href="../img/Quesorpresa.png" type="image/x-icon">


    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../sass/estilo.css">

</head>

<body>
    <!-- PHP para diferenciar entre insertar o modificar productos -->
    <?php
    // Mediante la accion sabremos a cual de los controladores deberemos llamar
    switch ($accion) {
        case "modificar":
            $url = "../controller/modificar_producto_controlador.php";
            break;
        case "insertar":
            $url = "../controller/insertar_producto_controlador.php";
            break;
        default:
            $url = "../views/gestionar_productos_vista.php";
    }
    ?>
    
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
                Productos
            </h1>
        </div>

        <!-- Formulario con todos los campos del producto -->
        <form method="POST" action="<?= $url ?>">

            <div class="container">

                <div class="row">


                    <div class="col-lg-9 col-sm-9">

                        <!-- Margenes con mb mr ml mt -sm-distancia-->
                        <!-- Misma linea -->
                        <div class="form-group row mb-sm-2 mt-sm-2">
                            <label for="Nombre" class="col-lg-3 col-form-label">Nombre del producto:</label>
                            <div class="col-lg-6">
                                <input type="text" class="form-control" id="Nombre" name="Nombre" value='<?= (isset($producto) ? $producto["Nombre"] : "") ?>' placeholder= "Introduzca el Nombre"/>
                            </div>
                        </div>

                        <div class="form-group row mb-sm-2 mt-sm-2">
                            <label for="Descripcion" class="col-lg-3 col-form-label">Descripci&oacute;n:</label>
                            <div class="col-lg-6">
                                <textarea class="form-control" id="Descripcion" name="Descripcion" placeholder="Introduzca la descripci&oacute;n"><?php echo (isset($producto) ? $producto["Descripcion"] : "") ?></textarea>
                            </div>
                        </div>

                        <div class="form-group row mb-sm-2 mt-sm-2">
                            <label for="Peso" class="col-lg-3 col-form-label">Peso:</label>
                            <div class="col-lg-6">
                                <input type="number" class="form-control" id="Peso" name="Peso" value='<?php echo (isset($producto) ? $producto["Peso"] : "") ?>' placeholder="Introduzca el peso en gramos" />
                            </div>
                        </div>

                        <div class="form-group row mb-sm-2 mt-sm-2">
                            <label for="Material" class="col-lg-3 col-form-label">Material:</label>
                            <div class="col-lg-6">
                                <input type="text" class="form-control" id="Material" name="Material" value='<?php echo (isset($producto) ? $producto["Material"] : "") ?>' placeholder="Introduzca el material" />
                            </div>
                        </div>

                        <div class="form-group row mb-sm-2 mt-sm-2">
                            <label for="Marca" class="col-lg-3 col-form-label">Marca:</label>
                            <div class="col-lg-6">
                                <input type="text" class="form-control" id="Marca" name="Marca" value='<?php echo (isset($producto) ? $producto["Marca"] : "") ?>' placeholder="Introduzca la marca" />
                            </div>
                        </div>

                        <div class="form-group row mb-sm-2 mt-sm-2">
                            <label for="Proveedores" class="col-lg-3 col-form-label">Proveedores:</label>
                            <div class="col-lg-6">
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

                        <div class="form-group row mb-sm-2 mt-sm-2">
                            <label for="Categorias" class="col-lg-3 col-form-label">Categorias:</label>
                            <div class="col-lg-6">
                                <select name="Categorias" id="Categorias" class="form-control">
                                    <?php
                                    if (empty($datosCategorias)) {
                                        echo "<option>No se encontraron proveedores</option>";
                                    } else {
                                        foreach ($datosCategorias as $categorias) {
                                            echo "<option value='" . htmlspecialchars($categorias["idCategorias"], ENT_QUOTES, 'UTF-8') . "'>" . htmlspecialchars($categorias["Nombre"], ENT_QUOTES, 'UTF-8') . "</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row mb-sm-2 mt-sm-2">
                            <label for="Precio" class="col-lg-3 col-form-label">Precio:</label>
                            <div class="col-lg-6">
                                <input type="number" class="form-control" id="Precio" name="Precio" value='<?php echo (isset($producto) ? $producto["Precio"] : "") ?>' placeholder="Introduzca el precio" />
                            </div>
                        </div>

                        <div class="form-group row mb-sm-2 mt-sm-2">
                            <label for="Stock" class="col-lg-3 col-form-label">Stock:</label>
                            <div class="col-lg-6">
                                <input type="number" class="form-control" id="Stock" name="Stock" value='<?php echo (isset($producto) ? $producto["Stock"] : "") ?>' placeholder="Introduzca el stock disponible" />
                            </div>
                        </div>

                        <div class="form-group row mb-sm-2 mt-sm-2">
                            <label for="FechaAdquisicion" class="col-lg-3 col-form-label">FechaAdquisicion:</label>
                            <div class="col-lg-6">
                                <input type="date" class="form-control" id="FechaAdquisicion" name="FechaAdquisicion" value='<?php echo (isset($producto) ? $producto["FechaAdquisicion"] : "") ?>' placeholder="Introduzca el precio" />
                            </div>
                        </div>

                        <div class="form-group row mb-sm-2 mt-sm-2">
                            <label for="FechaCaducidad" class="col-lg-3 col-form-label">FechaCaducidad:</label>
                            <div class="col-lg-6">
                                <input type="date" class="form-control" id="FechaCaducidad" name="FechaCaducidad" value='<?php echo (isset($producto) ? $producto["FechaCaducidad"] : "") ?>' placeholder="Introduzca el precio" />
                            </div>
                        </div>

                        <div class="form-group row mb-sm-2 mt-sm-2">
                            <label for="Imagen" class="col-lg-3 col-form-label">Imagen:</label>
                            <div class="col-lg-6">
                                <input type="text" class="form-control" id="Imagen" name="Imagen" value='<?php echo (isset($producto) ? $producto["Imagen"] : "") ?>' placeholder="Introduzca una imagen" />
                            </div>
                        </div>

                        <br>
                        <!-- Este campo estará oculto y se usará para cuando necesitemos modificar un producto de la base de datos -->
                        <input type="hidden" name="idProductos" value='<?= (isset($producto) ? $producto["idProductos"] : "") ?>' />
                        <button type="submit" name="modificar" value="false" class="btn btn-default mb-sm-2 shadow p-3 mb-5 bg-body rounded px-3 py-2">Enviar</button>

                    </div>
                </div>
            </div>
        </form>

        <!-- Volver a la página anterior -->
        <form action="../controller/gestionar_productos_controlador.php" method="POST">
            <div class="d-flex justify-content-center">
                <button class="btn " type="submit">
                    Volver Atr&aacute;s
                </button>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>

</html>