<?php


// confirmar sesion

session_start();


if (!isset($_SESSION['loggedin'])) {

    header('Location: login.php');
    exit;
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="Ansonika">
  <title>Reporte de gastos</title>
	
  <!-- Favicons-->
  <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
  <link rel="apple-touch-icon" type="image/x-icon" href="img/apple-touch-icon-57x57-precomposed.png">
  <link rel="apple-touch-icon" type="image/x-icon" sizes="72x72" href="img/apple-touch-icon-72x72-precomposed.png">
  <link rel="apple-touch-icon" type="image/x-icon" sizes="114x114" href="img/apple-touch-icon-114x114-precomposed.png">
  <link rel="apple-touch-icon" type="image/x-icon" sizes="144x144" href="img/apple-touch-icon-144x144-precomposed.png">

  <!-- GOOGLE WEB FONT -->
  <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800" rel="stylesheet">
	
  <!-- Bootstrap core CSS-->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Main styles -->
  <link href="css/admin.css" rel="stylesheet">
  <!-- Icon fonts-->
  <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- Plugin styles -->
  <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
  <!-- Your custom styles -->
  <link href="css/custom.css" rel="stylesheet">
	
</head>

<body class="fixed-nav sticky-footer" id="page-top">
  <!-- Navigation-->
  <nav class="navbar navbar-expand-lg navbar-dark bg-default fixed-top" id="mainNav">
    <a class="navbar-brand" href="index.php"><img src="img/logo.png" data-retina="true" alt="" width="163" height="36"></a>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Dashboard">
          <a class="nav-link" href="index.php">
            <i class="fa fa-fw fa-dashboard"></i>
            <span class="nav-link-text">Inventario</span>
          </a>
        </li>
		<li class="nav-item" data-toggle="tooltip" data-placement="right" title="Messages">
          <a class="nav-link" href="reporte_gastos.php">
            <i class="fa fa-fw fa-envelope-open"></i>
            <span class="nav-link-text">Reporte</span>
          </a>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="My profile">
          <a class="nav-link" href="profile.php">
            <i class="fa fa-fw fa-wrench"></i>
            <span class="nav-link-text">Mi perfil</span>
          </a>
        </li>
		  </ul>
      <ul class="navbar-nav sidenav-toggler">
        <li class="nav-item">
          <a class="nav-link text-center" id="sidenavToggler">
            <i class="fa fa-fw fa-angle-left"></i>
          </a>
        </li>
      </ul>
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" data-toggle="modal" data-target="#exampleModal">
            <i class="fa fa-fw fa-sign-out"></i>Cerrar sesion</a>
        </li>
      </ul>
    </div>
  </nav>
  <!-- /Navigation-->
  <div class="content-wrapper">
    <div class="container-fluid">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Gastos por Mes</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h2 {
            text-align: center;
            color: #4a148c;
        }

        form {
            max-width: 400px;
            margin: 20px auto;
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }

        select, input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="submit"] {
            background-color: #6a1b9a;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 10px 15px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #4a148c;
        }

        canvas {
            display: block;
            max-width: 90%;
            margin: 20px auto;
        }

        .total-gasto {
            max-width: 400px;
            margin: 20px auto;
            padding: 10px;
            text-align: center;
            background-color: #e1bee7;
            border: 1px solid #ab47bc;
            border-radius: 5px;
            font-size: 18px;
            font-weight: bold;
            color: #4a148c;
        }
    </style>
</head>
<body>

<?php


if (isset($_POST['generar_reporte'])) {
    $user_id = $_SESSION['id']; // Obtener el ID del usuario desde la sesión
    $anio = isset($_POST['anio']) ? intval($_POST['anio']) : null;

    // Conectar a la base de datos
    $link = mysqli_connect("localhost", "root", "", "gestion_inventario");

    // Preparar la consulta para ejecutar el procedimiento almacenado
    if ($anio) {
        $stmt = $link->prepare("CALL GastosPorAnioDetalle(?, ?)");
        $stmt->bind_param("ii", $user_id, $anio);
        $stmt->execute();

        $resultado = $stmt->get_result();

        // Preparar datos para la gráfica y calcular el gasto total
        $labels = [];
        $data = [];
        $total_gasto = 0;

        while ($fila = $resultado->fetch_assoc()) {
            $labels[] = $fila['mes'];
            $data[] = $fila['total_gastos'];
            $total_gasto += $fila['total_gastos'];
        }

        $labels_js = json_encode($labels);
        $data_js = json_encode($data);
        $total_gasto_js = json_encode($total_gasto);

        // Cerrar la consulta
        $stmt->close();
    }

    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Gastos por Año</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h2 {
            text-align: center;
            color: #4a148c;
        }

        form {
            max-width: 400px;
            margin: 20px auto;
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }

        select, input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="submit"] {
            background-color: #6a1b9a;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 10px 15px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #4a148c;
        }

        canvas {
            display: block;
            max-width: 90%;
            margin: 20px auto;
        }

        .total-gasto {
            max-width: 400px;
            margin: 20px auto;
            padding: 10px;
            text-align: center;
            background-color: #e1bee7;
            border: 1px solid #ab47bc;
            border-radius: 5px;
            font-size: 18px;
            font-weight: bold;
            color: #4a148c;
        }
    </style>
</head>

<body>
    <h2>Reporte de Gastos por Año</h2>
    <hr>
    <form action="" method="POST">

        <label for="anio">Ingrese Año:</label>
        <input type="number" name="anio" id="anio" min="2000" max="2100" required>

        <input type="submit" name="generar_reporte" value="Generar Reporte">
    </form>
    <hr>

    <!-- Contenedor de la gráfica -->
    <canvas id="gastosChart" width="800" height="400"></canvas>

    <!-- Recuadro del gasto total -->
    <?php if (isset($total_gasto)) : ?>
        <div class="total-gasto">
            Gasto Total del Año: $<?= number_format($total_gasto, 2) ?>
        </div>
    <?php endif; ?>

    <script>
        const labels = <?= $labels_js ?? '[]' ?>;
        const data = <?= $data_js ?? '[]' ?>;

        const ctx = document.getElementById('gastosChart').getContext('2d');
        const gastosChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Gastos Totales ($)',
                    data: data,
                    backgroundColor: 'rgba(103, 58, 183, 0.6)',
                    borderColor: 'rgba(63, 81, 181, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Gastos Mensuales del Año',
                        font: {
                            size: 20
                        }
                    }
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Meses',
                            font: {
                                size: 14
                            }
                        }
                    },
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Monto ($)',
                            font: {
                                size: 14
                            }
                        }
                    }
                }
            }
        });
    </script>
</body>

</html>




    
          <!-- Example Bar Chart Card-->
          </div>
        </div>
        <div class="col-lg-4">
          <!-- Example Pie Chart Card-->

          </div>
        </div>
		</div>
	  </div>
	  <!-- /container-fluid-->
   	</div>
    <!-- /container-wrapper-->
    <footer class="sticky-footer">
      <div class="container">
        <div class="text-center">
          <small>Copyright © UDEMA 2022</small>
        </div>
      </div>
    </footer>
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fa fa-angle-up"></i>
    </a>
    <!-- Logout Modal-->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">¿Quieres cerrar sesión?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">Selecciona "Cerrar sesión" si estas seguro de que quieres cerrar sesión.</div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
            <a class="btn btn-primary" href="close_session.php">Cerrar sesión</a>
          </div>
        </div>
      </div>
    </div>
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Page level plugin JavaScript-->
    <script src="vendor/chart.js/Chart.min.js"></script>
    <script src="vendor/datatables/jquery.dataTables.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.js"></script>
	<script src="vendor/jquery.selectbox-0.2.js"></script>
	<script src="vendor/retina-replace.min.js"></script>
	<script src="vendor/jquery.magnific-popup.min.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="js/admin.js"></script>
	<!-- Custom scripts for this page-->
    <script src="js/admin-charts-all.js"></script>
	
</body>
</html>