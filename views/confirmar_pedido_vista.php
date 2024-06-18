<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Compra</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../sass/generales/estiloNavegacion.css">
    <link rel="stylesheet" href="../sass/generales/estiloFooter.css">
    <link rel="stylesheet" href="../sass/estiloConfirmarPedido.css">
    
</head>

<body>
<nav class="navbar navbar-expand-md fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="../controller/main_controlador.php">
                <img src="../img/Quesorpresa.png" alt="Logo" class="img-fluid">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav ms-auto">
                    <?php if (isset($rolp) && $rolp == "Admin") : ?>
                        <li class='nav-item'>
                            <!-- Cambiar ruta al pasarlo a los otros archivos ../controller/gestionar_productos_controlador.php-->
                            <a class='nav-link' href='../controller/mostrar_producto_controlador.php'>
                                <img src='../img/Editar.png' alt='Editar' class='img-fluid'>
                            </a>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <a class="nav-link" href="../views/contactos_vista.php">
                            <img src="../img/Correo.png" alt="Correo" class="img-fluid">
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../controller/mi_cuenta_controlador.php">
                            <img src="../img/MiCuenta.png" alt="Mi Cuenta" class="img-fluid">
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../views/carrito_vista.php">
                            <img src="../img/Carrito.png" alt="Carrito" class="img-fluid">
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container containerFormulario mt-navbar">
        <h2 class="text-center">Detalle de Compra</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Imagen</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <!-- Aquí puedes agregar los productos comprados mediante JavaScript o servidor -->
                <?php foreach ($productosCompra as $producto) {
                    echo "<tr>\n";
                    echo "<td><img src='../img/imagenesSubidas/" . htmlspecialchars($producto["imagen"]) . "' class='cart-img'></td>\n";
                    echo "<td>" . htmlspecialchars($producto["nombre"]) . "</td>\n";
                    echo "<td>" . htmlspecialchars($producto["precio"]) . "€</td>\n";
                    echo "<td>" . htmlspecialchars($producto["cantidad"]) . "</td>\n";
                    echo "<td>" . htmlspecialchars($producto["subtotal"]) . "€</td>\n";
                    echo "<input type='hidden' name='idProductos[]' value='" . htmlspecialchars($producto["idProductos"]) . "' />\n";
                    echo "<input type='hidden' name='cantidades[]' value='" . htmlspecialchars($producto["cantidad"]) . "' />\n";
                    echo "</tr>\n";
                }
                ?>
            </tbody>
        </table>
        <div class="d-flex justify-content-end align-items-center mt-3">
            <h5>Total: <span id="totalAmount"><?php echo ($totalAmount) ?></span>€</h5>
        </div>
        <hr>
        <h2 class="text-center">Datos de Envío</h2>
        <form id="purchaseForm" action="../controller/enviar_compra_controlador.php" method="POST">
            <div class="row">
                <div class="col-md-6">
                    <label for="nombre" class="form-label">Nombre:</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" value="<?php echo htmlspecialchars($datosCuenta["Nombre"]); ?>" required>
                </div>
                <div class="col-md-6">
                    <label for="apellido" class="form-label">Apellido:</label>
                    <input type="text" class="form-control" id="apellido" name="apellido" placeholder="Apellido" value="<?php echo htmlspecialchars($datosCuenta["Apellido"]); ?>" required>
                </div>
                <div class="col-md-6">
                    <label for="correo" class="form-label">Correo:</label>
                    <input type="email" class="form-control" id="correo" name="correo" placeholder="ejemplo@gmail.com" value="<?php echo htmlspecialchars($datosCuenta["Correo"]); ?>" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="pais" class="form-label">País:</label>
                    <input type="text" class="form-control" id="pais" name="pais" placeholder="País" required>
                </div>
                <div class="col-md-6">
                    <label for="provincia" class="form-label">Provincia:</label>
                    <input type="text" class="form-control" id="provincia" name="provincia" placeholder="Provincia" required>
                </div>
                <div class="col-md-6">
                    <label for="ciudad" class="form-label">Ciudad:</label>
                    <input type="text" class="form-control" id="ciudad" name="ciudad" placeholder="Ciudad" required>
                </div>
                <div class="col-md-6">
                    <label for="calle" class="form-label">Calle:</label>
                    <input type="text" class="form-control" id="calle" name="calle" placeholder="Calle" required>
                </div>
                <div class="col-md-2">
                    <label for="numero" class="form-label">Número:</label>
                    <input type="text" class="form-control" id="numero" name="numero" placeholder="Número" required>
                </div>
                <div class="col-md-2">
                    <label for="piso" class="form-label">Piso (Opcional):</label>
                    <input type="text" class="form-control" id="piso" name="piso" placeholder="Piso">
                </div>
                <div class="col-md-2">
                    <label for="letra" class="form-label">Letra (Opcional):</label>
                    <input type="text" class="form-control" id="letra" name="letra" placeholder="Letra">
                </div>
                <div class="col-md-6">
                    <label for="codigoPostal" class="form-label">Código Postal:</label>
                    <input type="text" class="form-control" id="codigoPostal" name="codigoPostal" placeholder="Código Postal" required>
                </div>
                <div class="col-md-6">
                    <label for="metodoPago" class="form-label">Método de Pago:</label>
                    <select class="form-control" id="metodoPago" name="metodoPago" required>
                        <option value="PayPal">PayPal</option>
                        <option value="Tarjeta de Crédito">Tarjeta de Crédito</option>
                        <option value="Bizum">Bizum</option>
                    </select>
                </div>
            </div>
            <!-- Campos ocultos para almacenar los IDs y las cantidades de los productos -->
            <input type="hidden" id="productIds" name="productIds">
            <input type="hidden" id="productQuantities" name="productQuantities">
            <input type="hidden" id="totalFactura" name="totalFactura" value="<?php echo ($totalAmount) ?>">
            <div class="text-center mt-3">
                <button type="submit" class="btn btn-custom btn-full-width">Enviar</button>
            </div>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/confirmarPedido.js"></script>
</body>

</html>
