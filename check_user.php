<?php
session_start();


//credenciales de acceso a la base datos

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

if (!isset($_POST['userx'], $_POST['passx'])) {

    // si no hay datos muestra error y re direccionar

    header('Location: login.php');
}

// evitar inyección sql

if ($stmt = $conexion->prepare('SELECT id,password FROM user WHERE username = ?')) {

    // parámetros de enlace de la cadena s

    $stmt->bind_param('s', $_POST['userx']);
    $stmt->execute();
}


// acá se valida si lo ingresado coincide con la base de datos

$stmt->store_result();
if ($stmt->num_rows > 0) {
    $stmt->bind_result($id, $password);
    $stmt->fetch();

    // se confirma que la cuenta existe ahora validamos la contraseña
    
    if ($_POST['passx'] === $password) {


        // la conexion sería exitosa, se crea la sesión



        session_regenerate_id();
        $_SESSION['loggedin'] = TRUE;
        $_SESSION['name'] = $_POST['username'];
        $_SESSION['id'] = $id;
        header('Location: index.php');
    }
} else {

    // usuario incorrecto
    header('Location: index.php');
}

$stmt->close();