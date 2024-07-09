
  
<?php
session_start();
require '../conecion.php';
require '../Assets/funcion.php';


$idUser = $_SESSION['id'];
$tipoUsuario = $_SESSION['tipo'];
if(empty($_SESSION['tipo'])) {
  header('location: ../index.php');
}
 if (empty($_GET['token'])) {  
            echo "<script>window.location.href='./listarFichas.php'; </script>";  

        }
        
if (isset($_GET['estadoSE'])) {
  if (!empty($_GET['estadoSE'])) {
  $token=$_GET['estadoSE'];
  $sqlF="SELECT * FROM ficha WHERE token = '$token'";
  $id_ficha=$conectarBD->query($sqlF)->fetch_assoc()['id_ficha'];
  $estadoSE=$conectarBD->query($sqlF)->fetch_assoc()['estadoSE'];
  switch ($estadoSE) {
    case '1':
      $estadoSE=0;
      break;
    
    case '0':
      $estadoSE=1;
      break;
    }
  $sql ="UPDATE ficha SET estadoSE = '$estadoSE' WHERE token ='$token'";
  if ($conectarBD->query($sql) == TRUE) {

     
    $sqlA= "UPDATE aprendiz SET estadoSE = '$estadoSE' WHERE id_ficha ='$id_ficha'";
    if ($conectarBD->query($sqlA) == TRUE) {
     echo "<script>window.location.href='./listarFichas.php'; </script>";  
    }
  }else{
    die(require "../errorAlgoSM.php");
  }



  }     



}


  if (isset($_POST['token'])) {
  if (!empty($_POST['token'])) {
     $token = $_POST['token'];   
  $sqlEN="SELECT * FROM ficha WHERE token = '$token'";
  $estado=$conectarBD->query($sqlEN)->fetch_assoc()['estado'];
  
  switch ($estado) {
    case '1':
      $estado=0;
      break;
    
    case '0':
      $estado=1;
      break;
    }
         
         $sqlA ="UPDATE ficha SET estado = '$estado' WHERE token='$token'";
         if ($conectarBD->query($sqlA) == TRUE){
           echo "<script>window.location.href='./listarFichas.php'; </script>";  

      }else{
          echo "Cambiaste Algo en la Direccion URL ";
         }
  }else{
   
  die(include '../errorAlgoSM.php');
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
	<title>Eliminar Ficha</title>	<link rel="icon" type="image/png" sizes="16x16" href="../situ.png">
   <link rel="stylesheet" type="text/css" href="../estilos.css">
  <link rel="stylesheet" type="text/css" href="../Assets/fonts/style.css">
  <link rel="stylesheet" type="text/css" href="
  ../Assets/bootstrap-4.3.1-dist/css/bootstrap.min.css
">
</head>
<body class=" bg-white">



<?php require '../navegacion.php';
$errors= array();

 
      if (!empty($_GET['token'])) {

    $tokenF=$_GET['token'];  

        $sql="SELECT * FROM ficha WHERE token='$tokenF'";
if (!empty($sql)){

 if( $conectarBD->query($sql)->num_rows > 0){

  foreach ($conectarBD->query($sql) as $fila){
 
      $id_ficha=$fila['id_ficha'];
      $id_programaF=$fila['id_programaF'];
      $id_area = $fila['id_area'];
      $tokenBD = $fila['token'];
      $estado=$fila['estado'];
      


          }
       }else{
            $errors[]='<h1 class="text-dark"> Oh! algo salio mal <span class="icon-notification text-warning"></span> </h1> ';
       
        }
        }else{
           echo "<script>window.location.href='./listarFichas.php'; </script>";  
        }
        if (isset($tokenBD)) {
          
        if ($_GET['token']==$tokenBD) {
          
        $token=  $_GET['token'];

?>
<br>
<div align="center">
	<h2 class="font-weight-bold">¿Está Seguro de <?php if ($estado==1){ echo 'Desactivar'; }else{ echo 'Activar'; } ?> La Siguiente Ficha? </h2>
	<br>
  <p class="font-weight-bold">N° Ficha: <span class="text-primary"><?php if (isset($id_ficha)){echo $id_ficha; 
  }else{
    echo "No Existe";
  }
    ?></span></p>
  
	<p class="font-weight-bold">Nombre Programa: <span class="text-primary"><?php
 if (isset($id_programaF)){
 $sqlP= "SELECT * FROM programas WHERE id_programaF=".$id_programaF;
       if ($conectarBD->query($sqlP)->num_rows > 0){

         foreach ($conectarBD->query($sqlP) as $fila){
          $nombreP= $fila['nombreP'];
        }
}
    echo $nombreP; }
      ?></span></p>

  <p class="font-weight-bold">Area: <span class="text-primary">
   
  <?php
  if (isset($id_area)){
 $sqlF= "SELECT * FROM area WHERE id_area=".$id_area;
       if ($conectarBD->query($sqlF)->num_rows > 0){

         foreach ($conectarBD->query($sqlF) as $fila){
          $nombreA= $fila['nombreArea'];
        }
}
    echo $nombreA; }
      ?>
	<form method="post" action="#">
		<input type="hidden" name="token" value="<?php echo $token; ?>">
 
  <button type="button" class="btn " title="Cancelar Eliminar"  onclick="window.location.href='./listarFichas.php'">
 <i class="icon-cancel text-danger" style="font-size: 50px;"> </i>
  </button>
  
   <button type="submit" class="btn font-weight-bold " title="<?php if ($estado==1){echo "Desactivar";}else{ echo "Activar";} ?> Ficha"   ><span class=" icon-checkmark1 text-success" style="font-size: 50px;"></span></button>

</div>
<?php 
   }else{
        $errors[]= "<h1 class='text-dark'>Cambiaste Algo en la Pagina</h1>";
      }
      
    }else{
      echo "<div class='container'><br>";
      die(include '../errorAlgoSM.php');
       echo "</div>";
       }
  }

?>
<div style="margin-top: 60px; margin-right: 400px; margin-left:400px;">
<?php resultBlock($errors);?>
</div>
<script type="text/javascript" src="../Assets/Jquery/jQuery_v3.4.1.js"></script>
<script type="text/javascript" src="../Assets/bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>

</body>    