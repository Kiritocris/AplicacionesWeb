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
  <title>Inventario</title>
	
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
		<!-- Example DataTables Card-->
      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-table"></i> Inventario</div>
        <div class="card-body">
            <p><a class="btn_1 small nav-link" data-toggle="modal" data-target="#createModal" href="">Añadir articulo</a></p>
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Nombre</th>
                  <th>Descripcion</th>
                  <th>Categoria</th>
                  <th>Cantidad</th>
                  <th>Precio</th>
                  <th>Factura</th>
                  <th>Opciones</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th>Nombre</th>
                  <th>Descripcion</th>
                  <th>Categoria</th>
                  <th>Cantidad</th>
                  <th>Precio</th>
                  <th>Factura</th>
                  <th>Opciones</th>
                </tr>
              </tfoot>
              <tbody>
                <?php
                $link = mysqli_connect("localhost","root","");
                mysqli_select_db($link,"gestion_inventario");
                $resultado = mysqli_query($link,"select * from articulo where user_id = '$_SESSION[id]'");
                while($ren = mysqli_fetch_array($resultado)){
                    $id  = $ren['nombre'];
                    $ti  = $ren['descripcion'];
                    $di  = $ren['categoria'];
                    $ac  = $ren['cantidad'];
                    $im  = $ren['precio'];
                    $fa  = $ren['imgFactura'];
                    $identify = $ren['id'];
                    
                    echo "<tr><th>$id</th> <TH> $ti </TH> <TH> $di </TH><TH> $ac </TH><TH> $im </TH>";
                    echo "<th><img src='MisFacturas/$fa' width='80' height='40'></a></th>";
                    echo "<th>
        <a class='btn_1 small nav-link' data-toggle='modal' data-target='#deleteModal$identify' href=''>X</a>
        <a class='btn_1 small nav-link' data-toggle='modal' data-target='#updateModal$identify' href=''>Editar</a>
      </th>";

// Crear una modal específica para cada elemento
echo "
<div class='modal fade' id='deleteModal$identify' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
  <div class='modal-dialog' role='document'>
    <div class='modal-content'>
      <div class='modal-header'>
        <h5 class='modal-title' id='exampleModalLabel'>¿Quieres eliminar este artículo?</h5>
        <button class='close' type='button' data-dismiss='modal' aria-label='Close'>
          <span aria-hidden='true'>×</span>
        </button>
      </div>
      <div class='modal-body'>Selecciona \"Eliminar\" si estás seguro de que quieres eliminar este artículo.</div>
      <div class='modal-footer'>
        <button class='btn btn-secondary' type='button' data-dismiss='modal'>Cancelar</button>
        <a class='btn btn-primary' href='delete_obj.php?id=" . urlencode($identify) . "'>Eliminar</a>
      </div>
    </div>
  </div>
</div>";

echo "
    <div class='modal fade' id='updateModal$identify' tabindex='-1' role='dialog' aria-labelledby='updateModalLabel$identify' aria-hidden='true'>
      <div class='modal-dialog' role='document'>
        <div class='modal-content'>
          <div class='modal-header'>
            <h5 class='modal-title' id='updateModalLabel$identify'>Actualizar Artículo</h5>
            <button class='close' type='button' data-dismiss='modal' aria-label='Close'>
              <span aria-hidden='true'>&times;</span>
            </button>
          </div>
          <div class='modal-body'>
            <form action='edit_obj.php' method='POST'>
              <input type='hidden' name='id' value='$identify'>
              <div class='form-group'>
                <label for='nombre$identify'>Nombre del artículo</label>
                <input type='text' class='form-control' id='nombre$identify' name='nombre' value='$id' required>
              </div>
              <div class='form-group'>
                <label for='descripcion$identify'>Descripción</label>
                <input type='text' class='form-control' id='descripcion$identify' name='descripcion' value='$ti' required>
              </div>
              <div class='form-group'>
                <label for='categoria$identify'>Categoría</label>
                <input type='text' class='form-control' id='categoria$identify' name='categoria' value='$di' required>
              </div>
              <div class='form-group'>
                <label for='cantidad$identify'>Cantidad</label>
                <input type='number' class='form-control' id='cantidad$identify' name='cantidad' value='$ac' required>
              </div>
              <div class='form-group'>
                <label for='precio$identify'>Precio</label>
                <input type='number' class='form-control' id='precio$identify' name='precio' value='$im' required>
              </div>
                <div class='form-group'>
                <label for='precio$identify'>Precio</label>
                <input type='file' class='form-control' id='imgFactura$identify' name='factura' value='$fa' required>
              </div>
              <div class='modal-footer'>
                <button class='btn btn-secondary' type='button' data-dismiss='modal'>Cancelar</button>
                <button type='submit' class='btn btn-primary'>Actualizar</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>";
                }
                mysqli_close($link); 
                ?>
              </tbody>
            </table>
          </div>
        </div>
        <div class="card-footer small text-muted">Inventario Activo</div>
      </div>
	  <!-- /tables-->
	  </div>
	  <!-- /container-fluid-->
   	</div>
    <!-- /container-wrapper-->
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

    <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Añadir un objeto</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
          <form action="add_obj.php" method="POST">
          <p>
            <label>Nombre del articulo</label>
            <input type="text" name="articuloz" required>
          </p>
          <p>
            <label>Categoria</label>
            <input type="text" name="categoriaz">
          </p>
          <p>
            <label>Cantidad</label>
            <input type="number" name="cantidadz" required>
          </p>
          <p>
            <label>Precio</label>
            <input type="number" name="precioz" required>
          </p>
          <p class="full">
            <label>Descripcion</label>
            <textarea name="descripcionz" required></textarea>
          </p>
        
          <p class="full">
              <label for="Factura">Factura (PDF)</label>
              <input type="file" name="facturaz" id="Factura" accept="application/pdf">
              <small>Selecciona un archivo PDF para cargar</small>
          </p>

                  </div>
          <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <input class="btn btn-primary" type="submit" value="Añadir">
          </div>
          </form>
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
    <script src="js/admin-datatables.js"></script>
	
</body>
</html>
