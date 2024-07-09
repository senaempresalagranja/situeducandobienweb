<?php
session_start();  
require '../conecion.php';
require '../Assets/funcion.php';


    
$idUser= $_SESSION["id"];
$tipoUsuario = $_SESSION["tipo"];
//echo 'sesion tipo '.$tipoUsuario;
    if (empty($_SESSION['tipo'])) {
        echo "<script>window.location.href='../index.php'; </script>";  
    } 
date_default_timezone_set('America/Bogota');
?>	
<!DOCTYPE html>
<html lang="en">
  <title>Pagina Principal</title>
  <link rel="icon" type="image/png" sizes="16x16" href="../situ.png">
<head>	<meta charset='utf-8'>    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
  <link rel="stylesheet" type="text/css" href="../estilos.css">
  <link rel="stylesheet" type="text/css" href="../Assets/fonts/style.css"> 
  <link rel="stylesheet" type="text/css" href="../Assets/bootstrap-4.3.1-dist/css/bootstrap.min.css">
  <link rel="shortcut icon" type="img/icon" href="../situ.png">

  
</head>
<body class="bg-white">
    

    <div id="main-wrapper">
    <header class="topbar">
        <?php include '../navAdmi.php'; ?>
    </header>

        <?php include '../navegacion.php';  ?>

        <div class="page-wrapper">
            
            <div class="container-fluid">
            <br>
<?php include '../situ.php'; ?>
<br>
<br>
    <h2 align="center" class="font-weight-bold " style="color: #616161;"> SISTEMA DE INFORMACIÓN DE TURNOS PARA LAS  UNIDADES<br> DEL CENTRO AGROPECUARIO LA GRANJA</h2>




  </div>
</div>

  <footer class="main-footer">

  </footer>
</div>

  <script type="text/javascript" src="../Assets/Jquery/jQuery_v3.4.1.js"></script>
<script type="text/javascript" src="../Assets/bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../Assets/bootstrap-4.3.1-dist/js/bootstrap.bundle.js"></script>

</body>
</html>