<!DOCTYPE html>
<html>

<head>
    <title>Registro de usuario</title>

</head>

<body>
    <h2>Registro de usuario</h2>
    <form action="../controller/registrar_usuario_controlador.php" method="post">

        <label for="Nombre">Nombre:</label>
        <input type="text" id="Nombre" name="Nombre" required><br>

        <label for="Apellido">Apellido:</label>
        <input type="text" id="Apellido" name="Apellido" required><br>

        <label for="Telefono">Telefono:</label>
        <input type="number" id="Telefono" name="Telefono" required><br>
        
        <label for="Correo">Correo:</label>
        <input type="email" id="Correo" name="Correo" required><br>

        <label for="Contrasena">Contrasena:</label>
        <input type="password" id="Contrasena" name="Contrasena" required><br>

        <input type="submit" value="Registrarse">
    </form>

</body>

</html>