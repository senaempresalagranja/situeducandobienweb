
  
<?php
session_start();

require_once '../conecion.php';
require '../Assets/funcion.php';


$idUser=$_SESSION['id'];
$tipoUsuario = $_SESSION['tipo'];
if(empty($_SESSION['tipo'])){  
 echo "<script>window.location.href='../index.php'; </script>";  
}


$errors=array();

if (!empty($_POST)){ 

    $nombreArea= $conectarBD->real_escape_string( $_POST['nombreArea']);                
     $token = $_POST['tokenBD'];                                                        
                                                                                        
          if(empty($nombreArea)){ 
            $errors[]="<h4 align='center' class='alert alert-danger alert-dismissible fade show text-dark'>
  <i class='icon-notification text-warning' style='font-size: 60px;' ></i> <br>
          Error el campo está vacío, Escriba un nombre de área
   <button type='button' class='close' value='cerrar' data-dismiss='alert' aria-label='close'>
  <span aria-hidden='true'>&times; </span>
   </button>
  </h4>";  
}else{
       
$sqlA = "UPDATE area SET nombreArea='$nombreArea' WHERE token= '$token'"; 
  
if($conectarBD->query($sqlA) == TRUE ){ 

$actualizado="<h2 class='alert alert-success alert-dismissible fade show text-dark' style='color: black;'><i class='icon-checkmark1 text-success' style='font-size:80px;'></i><br> Actualizado Satisfactoriamente
 <button type='button' class='close' value='cerrar' data-dismiss='alert' aria-label='close'>
  <span aria-hidden='true'>&times; </span>
   </button>
 </h2>
<a class='btn btn-primary type='button' href='./listarAreas.php'>Volver </a>
";


    }else{ 
?>
<br>
<div class="container">
<?php
        die(require '../errorAlgoSM.php');
    }
                } 
              }  
if(isset($_GET['token'])){
  if(empty($_GET['token'])){
    echo "<script>window.location.href='./listarAreas.php'; </script>";  
}else{

$token = $_GET['token'];

if($conectarBD->connect_error){
    
    die("conexion fallida:".$conectarBD->connect_error);
}

$sql = "SELECT * FROM Area WHERE token = '$token'";

if ($conectarBD->query($sql)->num_rows >0){
  
        
        $id_area = $conectarBD->query($sql)->fetch_assoc()['id_area'];
         $nombreArea = $conectarBD->query($sql)->fetch_assoc()['nombreArea'];
        $tokenBD= $conectarBD->query($sql)->fetch_assoc()['token'];
      }   
    }
}

?>
<!DOCTYPE html>
<html>
<head>
  <?php include '../navAdmi.php';?>
	<title>Editar Area</title><link rel="icon" type="image/png" sizes="16x16" href="../situ.png">
<link rel="stylesheet" type="text/css" href="../estilos.css">
  <link rel="stylesheet" type="text/css" href="../Assets/fonts/style.css">
  <link rel="stylesheet" type="text/css" href="../Assets/bootstrap-4.3.1-dist/css/bootstrap.min.css">
</head>
<?php require '../navegacion.php';?>
<br>

</head>
<body class=" bg-white">
 

   
    <div align="center" class="container" >
<div style="margin-left: 100px; margin-right: 100px;">
<br>

    <?php

     echo '<br>'.resultBlock($errors);
?>
  <?php
if (isset($tokenBD)){
  if (!empty($tokenBD)){
 if (!isset($actualizado)) {

?>
</div>
        <h1>Editar Area</h1>
       
		<div class="form-group">
    
    <form  method="post" action="#">
    <input type="hidden" name="tokenBD" value="<?= $tokenBD?>">
		  <label  class="font-weight-bold">Codigo de Area</label>
      <input type="text" class="form-control font-weight-bold col-3" value="<?=$id_area ?>" readonly="readonly">
  </div>
  
<div class="form-group col-md-6"> 
		<label class="font-weight-bold">Nombre Actual de Area:</label>
    <br>
		<input type="text" value='<?= $nombreArea?>' name="nombreArea" id="" class="form-control font-weight-bold col-6" readonly="readonly">	
  </div>
  <div class="form-group col-md-9"> 
   <label  class="font-weight-bold">Nuevo nombre del area </label>
      <input type="text" class="form-control font-weight-bold col-4" name="nombreArea" id="nombreArea">
  </div>
    <div>

  <button type="reset" title="Limpiar Registro" class="btn" >
    <i class="icon-loop2 text-secondary" style="font-size: 35px;"></i> 
  </button>

  <button type="button" class="btn" title="Cancelar Registro"  onclick="window.location.href='./listarAreas.php'">
      <i class="icon-cancel text-danger" style="font-size: 50px;"> </i>
  </button>
  

  <button type="submit"   class="btn font-weight-bold "  title="Actualizar Area">
  <i class="icon-checkmark1 text-success" style="font-size: 50px;"></i>
  </button>
 </div> 
                        
    </form>
  <?php
}else{
  echo $actualizado;
}

}
}else{
  echo "<script> swal('Error', 'Algo Salió Mal', 'error') </script>";
  die(require '../errorAlgoSM.php');
}

?>  
 </div>
</div>
<script type="text/javascript" src="../Assets/Jquery/jQuery_v3.4.1.js"></script>
<script type="text/javascript" src="../Assets/bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>

</body>
</html>






