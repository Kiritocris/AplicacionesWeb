<?php
session_start();

// Conexión a la base de datos
$link = mysqli_connect("localhost", "root", "", "gestion_inventario");

if (!$link) {
    die("Error de conexión: " . mysqli_connect_error());
}

$nombre = mysqli_real_escape_string($link, $_POST['userp']);
$descripcion = mysqli_real_escape_string($link, $_POST['passp']);


// Actualizar el registro en la base de datos
$sql = "UPDATE user SET 
            username = '$nombre',
            password = '$descripcion'
        WHERE id = '$_SESSION[id]'";

if (mysqli_query($link, $sql)) {
    // Redireccionar después de actualizar
    header('Location: close_session.php');
} else {
    echo "Error al actualizar el artículo: " . mysqli_error($link);
}

// Cerrar la conexión
mysqli_close($link);
?>