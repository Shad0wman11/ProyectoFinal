<?php
session_start();
$servidor = 'localhost';
$cuenta = 'root';
$password = '';
$bd = 'deportuaa';

// conexión a la base de datos
$conexion = new mysqli($servidor, $cuenta, $password, $bd);

if ($conexion->connect_errno) {
    die('Error en la conexión');
}

// obtener categorías disponibles (puedes ajustar la consulta según tu estructura de base de datos)
$sql_categorias = 'SELECT DISTINCT categoria FROM productos';
$resultado_categorias = $conexion->query($sql_categorias);

$categoria_seleccionada = isset($_GET['categoria']) ? $_GET['categoria'] : ''; // obtiene la categoría seleccionada

// aplicar el filtro de categoría a la consulta SQL
$sql = "SELECT * FROM productos";
if (!empty($categoria_seleccionada)) {
    $sql .= " WHERE categoria = '$categoria_seleccionada'";
}

$resultado = $conexion->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>
    <!-- LINKS -->
    <link rel="shortcut icon" href="img/Favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="css/productos.css"> <!-- Enlaza directamente a productos.css -->
    <!-- CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
        crossorigin="anonymous">
    <style>
        img.producto-imagen {
    transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out, opacity 0.3s ease-in-out;
}

/* Efecto de sombra y cambio de opacidad al pasar el ratón sobre la imagen */
img.producto-imagen:hover {
    transform: scale(1.1);
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
    opacity: 0.8;
}
        
    </style>
</head>

<body>
    <?php include 'nav.php'; ?>
    <div class="pt1">
        <div class="texto">
            <a href="subirproductos.php"
                class="link-nav <?php echo basename($_SERVER['PHP_SELF']) == 'subirproductos.php' ? 'active' : ''; ?>">Subir
                Productos</a>
            <a href="editarproductos.php"
                class="link-nav <?php echo basename($_SERVER['PHP_SELF']) == 'editarproductos.php' ? 'active' : ''; ?>">Editar
                Productos</a>
        </div>
        <form method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <label for="categoria">Seleccionar Categoría:</label>
            <select name="categoria" id="categoria">
                <option value="" <?php echo empty($categoria_seleccionada) ? 'selected' : ''; ?>>Todas las Categorías</option>
                <?php
                // Imprimir opciones de categoría
                while ($row_categoria = $resultado_categorias->fetch_assoc()) {
                    $categoria_actual = $row_categoria['categoria'];
                    echo "<option value=\"$categoria_actual\" " . ($categoria_actual == $categoria_seleccionada ? 'selected' : '') . ">$categoria_actual</option>";
                }
                ?>
            </select>
            <button type="submit">Filtrar</button>
        </form>
    </div>

    <div class="loader-wrapper">
        <div class="loader"></div>
        <p>Cargando...</p>
    </div>

    <?php
    if ($resultado->num_rows) {
        echo '<div style="margin-left: 20px;">';
        echo '<table class="table table-hover" style="width:50%;">';

        echo '<tr>';
        echo '<th>id</th>';
        echo '<th>nombre</th>';
        echo '<th>descripcion</th>';
        echo '<th>existencia</th>';
        echo '<th>precio</th>';
        echo '<th>imagen</th>';
        echo '<th>categoria</th>';
        echo '<th>descuento</th>';
        echo '<th>desc2</th>';
        echo '<th>Acciones</th>'; // Nueva columna para el enlace al carrito
        echo '</tr>';

        $count = 0; // Contador para limitar a 8 productos
        while ($fila = $resultado->fetch_assoc() and $count < 8) {
            echo '<tr>';
            echo '<td>' . $fila['idp'] . '</td>';
            echo '<td>' . $fila['nomp'] . '</td>';
            echo '<td>' . $fila['descripcion'] . '</td>';
            echo '<td>' . $fila['existencia'] . '</td>';
            echo '<td>' . $fila['precio'] . '</td>';
            echo '<td><img src="productos/' . htmlspecialchars(basename($fila['imagen'])) . '" class="producto-imagen" height="150px" width="150px"></td>';
            echo '<td>' . $fila['categoria'] . '</td>';
            echo '<td>' . $fila['descuento'] . '</td>';
            echo '<td>' . $fila['desc2'] . '</td>';
            echo '<td><a href="carrito.php?id=' . $fila['idp'] . '&nombre=' . $fila['nomp'] . '&precio=' . $fila['precio'] . '" class="link-nav"><img src="img/carrito.png" height="50px" width="50px"></a></td>';
            echo '</tr>';
            $count++;
        }
        echo '</table>';
        echo '</div>';
    } else {
        echo "No hay datos";
    }
    ?>

    <!-- SCRITPS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>

</html>
