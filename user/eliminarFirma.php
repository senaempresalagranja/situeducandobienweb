<?php
session_start();
require '../conecion.php';
require '../Assets/funcion.php';

$idUser= $_SESSION['id'];

    $tipoUsuario = $_SESSION['tipo'];

    if(empty($_SESSION['tipo'])) {

        echo "<script>window.location.href='../index.php'; </script>";  

    }

$token=$_REQUEST['token'];

	$sql ="SELECT * FROM firma WHERE token = '$token'";

	if ($conectarBD->query($sql)->num_rows > 0 ){

	 $quienFirma = $conectarBD->query($sql)->fetch_assoc()['quienFirma'];

	$documento = $conectarBD->query($sql)->fetch_assoc()['documento'];

  $cargoQF = $conectarBD->query($sql)->fetch_assoc()['cargoQF'];

  $tokenBD = $conectarBD->query($sql)->fetch_assoc()['token'];

    $estado = $conectarBD->query($sql)->fetch_assoc()['estado']; 

      $fotoUrl = $conectarBD->query($sql)->fetch_assoc()['fotoUrl'];

	}	 switch ($estado) {

    case '1':

      $estado=0;

      break;

    

  

    case '0':

      $estado=1;

      break;

  }

if (isset($_POST['tokenBD'])) {

 if (!empty($_POST['tokenBD'])) {

  $tokenBD=$_POST['tokenBD'];

 	 $sqlA = "UPDATE firma SET estado = '$estado' WHERE token= '$tokenBD'";

 	 if ($conectarBD->query($sqlA)=== TRUE){

 header('location: ./ListarFirmas.php');

 	 }

 	 }





 }



?>

<!DOCTYPE html>

<html>

<head>

  <meta charset="utf-8"><style type="text/css">

        .confi{

    height: 30px;



  }

      </style>

     <?php include '../navAdmi.php';?>

	<title>Eliminar Firma</title>

      <link rel="icon" type="image/png" sizes="16x16" href="../situ.png">

   <link rel="stylesheet" type="text/css" href="../estilos.css">

  <link rel="stylesheet" type="text/css" href="../Assets/fonts/style.css">

  <link rel="stylesheet" type="text/css" href="

  ../Assets/bootstrap-4.3.1-dist/css/bootstrap.min.css

">

</head>

<body class=" bg-white">







<?php require '../navegacion.php';?>

<br>

<div align="center" class="form bg-transparent border-transparent">

  <?php



if ($estado==0) {

  ?>

  <h2>¿ Está Seguro de  Desactivar La Siguiente firma ?</h2>

  <br>

  <p class="font-weight-bold">Quién Firma: <span style="color: purple"><?php echo $quienFirma; ?></span></p>

  <p class="font-weight-bold">documento: <span style="color: purple"><?php echo $documento; ?></span></p>

  <p class="font-weight-bold">cargo: <span style="color: purple"><?php echo $cargoQF; ?></span></p>

   <p class="font-weight-bold">Firma: <img src="<?= $fotoUrl ?>"style="width: 120px;"></p>

    <form method="post" action="#">

    <input type="hidden" name="tokenBD" value="<?php echo $token; ?>">

  <button type="button" class="btn " title="Cancelar Eliminar"  onclick="window.location.href='./listarFirmas.php'">

 <i class="icon-cancel text-danger" style="font-size: 50px;"> </i>

  </button>

  

   <button type="submit" class="btn font-weight-bold "  ><span class=" icon-checkmark1 text-success" style="font-size: 50px;"></span></button>

   <?php  

}if($estado==1) {







  $sqlFBD="SELECT COUNT(*) AS totalRegistros FROM firma WHERE estado = 1";

 if ($conectarBD->query($sqlFBD)->num_rows >0) {

  $cant=$conectarBD->query($sqlFBD)->fetch_assoc()['totalRegistros'];

  

   

 if ($cant==2) {

  die("<div ><div align='center' style='margin-top:60px;'><h2  class='font-weight-bold'>Apreciado usuario ya existen dos firmas activas <br>

    Debes desactivar una para activar otra.<br><span class='icon-warning' font-size:200px;></span></h2><div align='center'style='margin-top:30px;'>



  <a  class='btn btn-success' href='listarFirmas.php' title='Listar firmas' ><i icon-warning></i>Aceptar</a>

  </div></div><div>");



  } else{

     ?>

  <h2>¿ Está Seguro de  Desactivar La Siguiente firma ?</h2>

  <br>

  <p class="font-weight-bold">Quién Firma: <span style="color: purple"><?php echo $quienFirma; ?></span></p>

  <p class="font-weight-bold">documento: <span style="color: purple"><?php echo $documento; ?></span></p>

  <p class="font-weight-bold">cargo: <span style="color: purple"><?php echo $cargoQF; ?></span></p>

   <p class="font-weight-bold">Firma: <img src="<?= $fotoUrl ?>"style="width: 120px;"></p>

    <form method="post" action="#">

    <input type="hidden" name="tokenBD" value="<?php echo $token; ?>">

  <button type="button" class="btn " title="Cancelar Eliminar"  onclick="window.location.href='./listarFirmas.php'">

 <i class="icon-cancel text-danger" style="font-size: 50px;"> </i>

  </button>

  

   <button type="submit" class="btn font-weight-bold "   title="Aceptar" ><span class=" icon-checkmark1 text-success" style="font-size: 50px;"></span></button>

<?php

}

  }

}

  

 





?>





<script type="text/javascript" src="../Assets/Jquery/jQuery_v3.4.1.js"></script>

<script type="text/javascript" src="../Assets/bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>



</body>

</html>    