<?php

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

if (!isset($_POST['usery'], $_POST['passy'],$_POST['emaily'])) {

    // si no hay datos muestra error y re direccionar

    header('Location: sign-in.php');
}else {
    $sql = "INSERT INTO user (username, password, email)
    VALUES ('$_POST[usery]', '$_POST[passy]', '$_POST[emaily]')";
    if ($conexion->query($sql) === TRUE) {
        header('Location: index.php');
    }
    
    $conexion->close();
    header('Location: sign-in.php'); 
}
