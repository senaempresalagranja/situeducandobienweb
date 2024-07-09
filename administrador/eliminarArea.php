
  
<?php
session_start();

require '../conecion.php';
require '../Assets/funcion.php';


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
  <title>Eliminar Area</title><link rel="icon" type="image/png" sizes="16x16" href="../situ.png">
   <link rel="stylesheet" type="text/css" href="../estilos.css">
  <link rel="stylesheet" type="text/css" href="../Assets/fonts/style.css">
  <link rel="stylesheet" type="text/css" href="../Assets/bootstrap-4.3.1-dist/css/bootstrap.min.css">

<link rel="stylesheet" type="text/css" href="../css/sweetalert.css">
<script type="text/javascript" src="../js/sweetalert.js"></script>
  
</head>
<body class=" bg-white">

<?php require '../navegacion.php';?>

<?php
$idUser= $_SESSION['id'];
    $tipoUsuario = $_SESSION['tipo'];
    if(empty($_SESSION['tipo'])) {          
       echo "<script>window.location.href='../index.php'; </script>";      
    }



if (isset($_REQUEST['tokenBD'])) { 
 if (!empty($_REQUEST['tokenBD'])) { 

 	$tokenBD=$_POST['tokenBD'];   

  $sqlE="SELECT* FROM area WHERE token='$tokenBD'";
  $estado=$conectarBD->query($sqlE)->fetch_assoc()['estado'];

  switch ($estado) {      
    case '1':
      $estado=0; 
      break;   
  
    case '0':
      $estado=1;
      break;
  }
 	 $sqlA = "UPDATE area SET estado = '$estado' WHERE token= '$tokenBD'";
 
   if ($conectarBD->query($sqlA)=== TRUE){ 
     echo "<script> swal('Exito', 'El proceso fue Exitoso', 'success') </script>";  
   
 	 }else{
    echo "<script> swal('Error al Eliminar', 'Revisar la sentencia SQL o la tabla en la BD', 'error') </script>";
    echo "<div class='container'><br>";
    die(include '../errorAlgoSM.php');
    echo "</div>";
 	 
 	 }

}
 } 


if(isset($_GET['token'])){
  if(empty($_GET['token'])){
     echo "<script>window.location.href='./listarAreas.php'; </script>";  
}else{
$token=$_REQUEST['token'];

  $sql ="SELECT * FROM area WHERE token= '$token'";
  if ($conectarBD->query($sql)->num_rows > 0 ){
    $tokenBD =$conectarBD->query($sql)->fetch_assoc()['token']; 
    $idA = $conectarBD->query($sql)->fetch_assoc()['id_area'];
    $estadoBD = $conectarBD->query($sql)->fetch_assoc()['estado'];
    $nombreArea = $conectarBD->query($sql)->fetch_assoc()['nombreArea'];
  } 
  }
}


if (isset($tokenBD)){
  if (!empty($tokenBD)){
?>
<br>
<div align="center" class="form bg-transparent border-transparent">
	<h2 class="font-weight-bold">¿ Está Seguro de <?php if ($estadoBD==1){echo "Desactivar";}else{ echo "Activar";} ?> la Siguiente Area ?</h2>
  
	<br>
	<p class="font-weight-bold">Codigo Area: <span style="color: purple"><?php echo $idA ; ?></span></p>
	<p class="font-weight-bold">Nombre Area: <span style="color: purple"><?php echo $nombreArea ; ?></span></p>
		<form method="post" action="#">
    <input type="hidden" name="tokenBD" value="<?php echo $token; ?>">
  <button type="button" class="btn " title="Cancelar Eliminar"  onclick="window.location.href='./listarAreas.php'">
 <i class="icon-cancel text-danger" style="font-size: 50px;"> </i>
  </button>
	
	 <button type="submit" class="btn font-weight-bold" title="<?php if ($estadoBD==1){echo "Desactivar";}else{ echo "Activar";} ?> Area" ><span class=" icon-checkmark1 text-success" style="font-size: 50px;"></span></button>

<?php
}
}else{
  echo "<div class='container'><br>";
  die(include '../errorAlgoSM.php');
  echo "</div>";
}

 ?>

<script type="text/javascript" src="../Assets/Jquery/jQuery_v3.4.1.js"></script>
<script type="text/javascript" src="../Assets/bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>



</body>
</html>    