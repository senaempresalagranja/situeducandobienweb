<?php
session_start();

require '../conecion.php';

$idUser= $_SESSION['id'];
    $tipoUsuario = $_SESSION['tipo'];
    if(empty($_SESSION['tipo'])) {
       echo "<script>window.location.href='../index.php'; </script>";  
    }
   
    ?>
<!DOCTYPE html>
<html>
<head>
<?php require '../navAdmi.php'; ?>

  <title>Turnos Automaticos</title>
  <link rel="icon" type="image/png" sizes="16x16" href="../situ.png">
  
   <link rel="stylesheet" type="text/css" href="./estilos.css">
  <link rel="stylesheet" type="text/css" href="../Assets/fonts/style.css">
  <link rel="stylesheet" type="text/css" href="../Assets/bootstrap-4.3.1-dist/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="../css/sweetalert.css">
  <script type="text/javascript" src="../js/sweetalert.js"></script>
</head>
<body class=" bg-white">
<?php require '../navegacion.php';?>

<div class="container mt-5">
	<div>
		<h1 class="font-weight-bold text-center">Tipo de Turno</h1>
	</div>
	<div align="center" >
		<button class="btn btn-info font-weight-bold" value="1" id="15D" title="Turno 15 Dias">15 Dias</button>
		<button class="btn btn-primary font-weight-bold" title="Turno Normal">Normal</button>
	</div>
</div>
<div id="m15">
	<?php require './turnoAutomatico15.php' ?>
</div>

<script type="text/javascript" src="../Assets/Jquery/jQuery_v3.4.1.js"></script>
<script type="text/javascript" src="../Assets/bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>
<script type="text/javascript">
	$("#m15").css("display","none")
	$("#15D").on("click",function() {
		let t15 = $(this).val();
		if (t15=="1") {
			$("#15D").val("2")
			$("#m15").css("display","block")
			
		}else{
			$("#15D").val("1")
			$("#m15").css("display","none")
			
		}
	})
</script>
</body>
</html>