<?php
session_start();

require '../conecion.php';
require '../Assets/funcion.php';

$idUser = $_SESSION['id'];
    $tipoUsuario = $_SESSION['tipo'];
    if(empty($_SESSION['tipo'])) {
       echo "<script>window.location.href='../index.php'; </script>";  
    }
     if ($tipoUsuario !='administrador') {  
            echo "<script>window.location.href='./paginaPrincipal.php'; </script>";  
  }

if (empty($_GET['token'])) {
echo "<script> window.location.href='./listarUnidades.php';</script>";
}else{
 $token= $_REQUEST['token'];
$sqlI="SELECT * FROM infou15 WHERE token='$token'";
 if ($conectarBD->query($sqlI) == TRUE){
$token15=$conectarBD->query($sqlI)->fetch_assoc()['token'];
 }

  $sql = "SELECT * FROM unidad where token = '$token'";

if($conectarBD->query($sql)-> num_rows > 0){

    $id_Unidad = $conectarBD->query($sql)->fetch_assoc()['id_Unidad'];
    $codigoUnidad = $conectarBD->query($sql)->fetch_assoc()['codigoUnidad'];
    $nombreUnidad = $conectarBD->query($sql)->fetch_assoc()['nombreUnidad'];
    $area = $conectarBD->query($sql)->fetch_assoc()['id_area'];
    $tipoTurno = $conectarBD->query($sql)->fetch_assoc()['tipoTurno'];
    $horaT = $conectarBD->query($sql)->fetch_assoc()['horaInicioM'];
    $cantidadAprendices = $conectarBD->query($sql)->fetch_assoc()['cantidadAprendices'];
    $tokenBD= $conectarBD->query($sql)->fetch_assoc()['token'];
    $estadoBD= $conectarBD->query($sql)->fetch_assoc()['estado'];
       
}
}
  

    if (isset($_POST['token'])) {
  if (!empty($_POST['token'])) {
     $token = $_POST['token'];   
  $sqlEN="SELECT * FROM unidad WHERE token = '$token'";
  $estado=$conectarBD->query($sqlEN)->fetch_assoc()['estado'];
  
  switch ($estado) {
    case '1':
      $estado=0;
      break;
    
    case '0':
      $estado=1;
      break;
    }
     
if(isset($token15)){
  $sqlUI="UPDATE infou15 SET estado='$estado' WHERE token='$token'";
  if($conectarBD->query($sqlUI) == TRUE){
         $sqlA ="UPDATE unidad SET estado = '$estado' WHERE token='$token'";
     }

     }else{
         $sqlA ="UPDATE unidad SET estado = '$estado' WHERE token='$token'";
         }
   if ($conectarBD->query($sqlA) == TRUE){
  echo "<script>window.location.href='./listarUnidades.php'</script>";      
      }else{
          echo "Cambiaste Algo en la Direccion URL ";
         }
  }else{
   
    $errors[]='<h1 class="text-dark"> Oh! algo salio mal <span class="icon-notification text-warning"></span> </h1> ';
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
   
	<title>lista de Usuarios</title>	<link rel="icon" type="image/png" sizes="16x16" href="../situ.png">
   <link rel="stylesheet" type="text/css" href="../estilos.css">
  <link rel="stylesheet" type="text/css" href="../Assets/fonts/style.css">
  <link rel="stylesheet" type="text/css" href="../Assets/bootstrap-4.3.1-dist/css/bootstrap.min.css">
  
</head>
<body class="bg_white">

<?php include '../navAdmi.php'; ?>
<?php include '../navegacion.php'; ?>
<br>
<div class="container">

<?php if(isset($tokenBD)){ ?>
 <div class="content-wrapper">

<br>
<div align="center" class="form bg-transparent border-transparent">
	<h2 class="font-weight-bold">¿Está Seguro de <?php if ($estadoBD==1){ echo 'Desactivar'; }else{ echo 'Activar'; } ?> La Siguiente Unidad? </h2>
  <br>
	<p class="font-weight-bold">Codigo Unidad: <span style="color: purple"><?php echo $codigoUnidad; ?></span></p>
	<p class="font-weight-bold">Nombre Unidad: <span style="color: purple">
	<?php
    echo $nombreUnidad;    
      ?>
</span></p>
	<p class="font-weight-bold">Area: <span style="color: purple">
   
  <?php
 $sqlF= "SELECT * FROM area WHERE id_area=".$area;
       if ($conectarBD->query($sqlF)->num_rows > 0){

         foreach ($conectarBD->query($sqlF) as $fila){
          $nombreA= $fila['nombreArea'];
        }
}
    echo $nombreA;    
      ?>
  </span></p>
	<form method="post" action="#">
	<input type="hidden" name="token" value="<?php echo $token; ?>">

  <button type="button" class="btn " title="Cancelar Eliminar"  onclick="window.location.href='./listarUnidades.php'">
 <i class="icon-cancel text-danger" style="font-size: 50px;"> </i>
  </button>
	
	 <button type="submit" class="btn font-weight-bold " title="<?php if ($estadoBD==1){echo "Desactivar";}else{ echo "Activar";} ?> Unidad"  ><span class=" icon-checkmark1 text-success" style="font-size: 50px;"></span></button> 
</form>
</div>

</div>

<?php }else{
  die(include '../errorAlgoSM.php');
} ?>

</div>

<script type="text/javascript" src="../Assets/Jquery/jQuery_v3.4.1.js"></script>
<script type="text/javascript" src="../Assets/bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>

</body>

            