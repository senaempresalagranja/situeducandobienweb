<?php
session_start();
require '../Assets/funcion.php';
require_once '../conecion.php';

   
$idUser=$_SESSION['id'];
    $tipoUsuario = $_SESSION['tipo'];
    if(empty($_SESSION['tipo'])) {
        echo "<script>window.location.href='../index.php'; </script>";  
    }


if (isset ($_POST['tokenBD'])) {  
  $tokenBD = $_POST['tokenBD'];
     if (empty($token)) {
         echo "<script>window.location.href='./ListarTurnosEspeciales.php'; </script>";  
     }
 
$sqlE="SELECT estado FROM turnoespecial WHERE token='$tokenBD'";

$estadoBD=$conectarBD->query($sqlE)->fetch_assoc()['estado'];
    switch ($estadoBD) {
    case '1':
      $estadoBD=0;
      break;
    
  
    case '0':
      $estadoBD=1;
      break;
  }

  $query = "UPDATE turnoespecial SET estado = '$estadoBD' WHERE token='$tokenBD'";
  if ($conectarBD->query($query)==TRUE){
    
   echo "<script>window.location.href='./ListarTurnosEspeciales.php'; </script>";           
   }else{
     echo "Error".$query."<br>".$conectarBD->error;
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
<title>Eliminar Turno Especial</title>
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
<?php

if (!empty($_REQUEST['token'])) {

$token= $_REQUEST['token'];

 $sql = "SELECT * FROM turnoespecial WHERE token = '$token'";

if($conectarBD->query($sql)->num_rows > 0){

  $tokenBD = $conectarBD->query($sql)->fetch_assoc()['token'];
  $id_ficha = $conectarBD->query($sql)->fetch_assoc()['id_ficha'];
  $area = $conectarBD->query($sql)->fetch_assoc()['id_area'];
  $codigoUnidad = $conectarBD->query($sql)->fetch_assoc()['codigoUnidad'];
  $estado=$conectarBD->query($sql)->fetch_assoc()['estado'];
}else{
?>
<div class="container">
<?php
die(require '../errorAlgoSM.php');
?>
</div>
<?php
}   


}

if(isset($token)){
  if(!empty($token)){


?>
<div align="center" class="form bg-transparent border-transparent">
<h2 class="font-weight-bold">¿Está Seguro de <?php if ($estado==1) { echo 'Desactivar';}else{ echo'Activar';} ?> El Siguiente Turno?</h2>

<p class="font-weight-bold">Numero Ficha: <span style="color: purple;"><?php echo $id_ficha ; ?></span></p>

<p class="font-weight-bold">Area: <span style="color: purple;">
  <?php
 $sqlA= "SELECT * FROM area WHERE id_area=".$area;
       if ($conectarBD->query($sqlA)->num_rows > 0){

         foreach ($conectarBD->query($sqlA) as $fila){
          $nombreArea= $fila['nombreArea'];
        }
}
    echo $nombreArea;

   ?>
    
</span></p>
<p class="font-weight-bold">Unidad: <span style="color: purple;">
  <?php
  $sqlU= "SELECT * FROM unidad WHERE codigoUnidad=".$codigoUnidad;
       if ($conectarBD->query($sqlU)->num_rows > 0){

         foreach ($conectarBD->query($sqlU) as $fila){
          $nombreUnidad= $fila['nombreUnidad'];
        }
}
     echo $nombreUnidad;

  ?>
    
  </span></p>


<form method="post" action="#">
  <input type="hidden" name="tokenBD" value="<?php echo $token; ?>">

  <button type="button" class="btn " title="Cancelar"  onclick="window.location.href='./ListarTurnosEspeciales.php'">
 <i class="icon-cancel text-danger"  style="font-size: 50px;"> </i>
  </button>
  
   <button type="submit" class="btn font-weight-bold " title="<?php if ($estado==1){echo "Desactivar";}else{ echo "Activar";} ?> Turno Especial" ><span class=" icon-checkmark1 text-success" style="font-size: 50px;"></span></button> 
</div>
<?php 
}
}else{
?>
<div class="container" style="margin-left: 10%; margin-right: 10%;">

<?php
 die(include '../errorAlgoSM.php'); 
?>

</div>
<?php 
}
?>
<script type="text/javascript" src="../Assets/Jquery/jQuery_v3.4.1.js"></script>
<script type="text/javascript" src="../Assets/bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>