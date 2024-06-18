<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subir Imangen</title>
</head>

<body>
    <form action="../controller/subirImagen_c.php" method="POST" enctype="multipart/form-data" />
    Añadir imagen: <input name="archivo" id="archivo" type="file" />
    <input type="submit" name="subir" value="Subir imagen" />
    </form>
</body>

</html>