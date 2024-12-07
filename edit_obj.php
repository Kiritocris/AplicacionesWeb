<?php
session_start();

// Conexión a la base de datos
$link = mysqli_connect("localhost", "root", "", "gestion_inventario");

if (!$link) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Obtener datos del formulario
$id = $_POST['id'];
$nombre = mysqli_real_escape_string($link, $_POST['nombre']);
$descripcion = mysqli_real_escape_string($link, $_POST['descripcion']);
$categoria = mysqli_real_escape_string($link, $_POST['categoria']);
$cantidad = intval($_POST['cantidad']);
$precio = floatval($_POST['precio']);
$factura = mysqli_real_escape_string($link, $_POST['factura']);


// Actualizar el registro en la base de datos
$sql = "UPDATE articulo SET 
            nombre = '$nombre',
            descripcion = '$descripcion',
            categoria = '$categoria',
            cantidad = '$cantidad',
            precio = '$precio',
            imgFactura = '$factura'
        WHERE id = '$id'";

if (mysqli_query($link, $sql)) {
    // Redireccionar después de actualizar
    header('Location: index.php');
} else {
    echo "Error al actualizar el artículo: " . mysqli_error($link);
}

// Cerrar la conexión
mysqli_close($link);
?>