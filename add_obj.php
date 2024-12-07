<?php


// confirmar sesion

session_start();

$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'gestion_inventario';

// conexion a la base de datos

$conexion = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

if (mysqli_connect_error()) {

    // si se encuentra error en la conexión

    exit('Fallo en la conexión de MySQL:' . mysqli_connect_error());
}

// Se valida si se ha enviado información, con la función isset()

if (!isset($_POST['articuloz'], $_POST['categoriaz'],$_POST['cantidadz'],$_POST['precioz'],$_POST['descripcionz'])) {

    // si no hay datos muestra error y re direccionar

    header('Location: index.php');
}else {
    $timestamp = date('Y-m-d');
    $sql = "INSERT INTO articulo (user_id, nombre, descripcion, categoria, cantidad, precio, fecha_adquisicion)
    VALUES ('$_SESSION[id]', '$_POST[articuloz]','$_POST[descripcionz]','$_POST[categoriaz]','$_POST[cantidadz]','$_POST[precioz]', '$timestamp')";
    if ($conexion->query($sql) === TRUE) {
        header('Location: index.php');
    }
    
    $conexion->close(); 
}


?>