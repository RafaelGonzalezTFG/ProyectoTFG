<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Validación de Cuenta</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../sass/estiloValidacionCodigo.css">
</head>

<body>
  <!-- Contenedor de errores -->
  <div class="container">
    <?php
    if (isset($_SESSION['error_message'])) {
      echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">'
        . $_SESSION['error_message'] .
        '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>';
      unset($_SESSION['error_message']); // Remove the message after displaying it
    }
    ?>
    <h1>Validación de Cuenta</h1>
    <!-- Formulario para validar -->
    <form action="../controller/activar_codigo_controlador.php" method="post">
      <div class="mb-3">
        <label for="Correo" class="form-label">Correo Electrónico</label>
        <input type="email" class="form-control" id="Correo" name="Correo" placeholder="Ingrese su correo electrónico" required>
      </div>
      <div class="mb-3">
        <label for="CodigoActivacion" class="form-label">Código de Activación</label>
        <input type="text" class="form-control" id="CodigoActivacion" name="CodigoActivacion" placeholder="Ingrese el código de activación" required>
      </div>
      <div class="d-grid">
        <button type="submit" class="btn btn-primary">Validar</button>
      </div>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
