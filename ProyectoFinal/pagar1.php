<?php
session_start();

// Verificar si se recibieron parámetros en la URL
if (isset($_GET['id']) && isset($_GET['nombre']) && isset($_GET['precio'])) {
    $idProducto = $_GET['id'];
    $nombreProducto = $_GET['nombre'];
    $precioProducto = $_GET['precio'];

    // Inicializar el carrito si aún no existe en la sesión
    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = array();
    }

    // Agregar el producto al carrito
    $producto = array(
        'id' => $idProducto,
        'nombre' => $nombreProducto,
        'precio' => $precioProducto
    );

    $_SESSION['carrito'][] = $producto;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito</title>
    <!-- LINKS -->
    <link rel="shortcut icon" href="img/Favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/formularios.css">
    <!-- CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- Agregar un estilo CSS para la tabla -->
    <style>
        table {
            width: 50%;
            margin: 20px;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <?php include 'nav.php'; ?>
    <div class="pt1">
    <h1>Metodo de Pago</h1>
    <h2>Ingresa los datos de tu tarjeta de crédito</h2>
    <form action="" method="post">
        <label for="titular">Titular de la tarjeta:</label>
        <input type="text" id="titular" name="titular" required><br><br>

        <label for="numero">Número de tarjeta:</label>
        <input type="number" id="numero" name="numero" required><br><br>

        <label for="caducidad">Fecha de caducidad (MM/AA):</label>
        <input type="text" id="caducidad" name="caducidad" required><br><br>

        <label for="cvv">CVV/CVC:</label>
        <input type="number" id="cvv" name="cvv" required><br><br>

        <button type="submit"><a href="pagar2.php" class="link-nav">Continuar</a></button>
    </form>

    </div>
    <?php
    include 'footer.php';
    ?>
</body>
</html>
<!-- SCRITPS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>