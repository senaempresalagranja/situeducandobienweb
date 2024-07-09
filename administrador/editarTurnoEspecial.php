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

if (!empty($_POST)) {

    $idTurnoEspecial = $conectarBD->real_escape_string($_POST['idTurnoEspecial']);
    $area = $conectarBD->real_escape_string( $_POST['area']);
    $codigoUnidad = $conectarBD->real_escape_string( $_POST['codigoUnidad']);
    $fechaTurnoE = $conectarBD->real_escape_string($_POST['fechaTurno']);
    $horaInicio = $conectarBD->real_escape_string( $_POST['horaInicio']);
    $horaFin = $conectarBD->real_escape_string( $_POST['horaFin']);
    

     $token = $_POST['token'];
     if (empty($token)) {
       
  echo "<script>window.location.href='./listarTurnosEspeciales.php'; </script>";  
     }
 

 $estado = 1;
        if (isNullTE( $area, $codigoUnidad, $fechaTurnoE, $horaInicio, $horaFin)) {
          $errors[]='<div class="alert alert-danger"><i class="icon-warning text-warning" style="font-size:70px; margin-left:10px;"></i><h5 class="text-dark">Debe llenar Todos los Campos </h5> </div>';

          if(empty($area)){
            $errors[]='<h6 class="alert alert-danger text-dark">Error Seleccione un area</h6>';
          }
          if(empty($codigoUnidad)){
            $errors[]='<h6 class="alert alert-danger text-dark">Error Seleccione una Unidad</h6>';
          }
         
          if (empty($fechaTurnoE)) {
                $errors[]='<h6 class="alert alert-danger text-dark">Error Seleccione una Fecha</h6>';
          }
          if (empty($horaInicio)) {
                 $errors[]='<h6 class="alert alert-danger text-dark">Error Escriba una Hora Especifica</h6>';
          }
          if (empty($horaFin)) {
                 $errors[]='<h6 class="alert alert-danger text-dark">Error Escriba la Hora final del turno</h6>';
          }
         
        }
   
  if (count($errors) == 0) {


 $sqlA="SELECT * FROM area WHERE id_area='$area'";
 $areaBD= $conectarBD->query($sqlA)->fetch_assoc()['id_area'];
    if($area != $areaBD){
      $errors[]='<div class="alert alert-danger"> <h4 style="color:black;"><i class="icon-warning text-warning" style="font-size:80px;"></i><br>Seleccione un Area Existente</h4> </div>';
         }else {

    $sqlU="SELECT * FROM unidad WHERE codigoUnidad='$codigoUnidad'";
    $unidadDB= $conectarBD->query($sqlU)->fetch_assoc()['codigoUnidad'];
    if($codigoUnidad != $unidadDB){
       $errors[]='<h6>Seleccione Unidad Existente</h6>';
    }else{


if(!validarFecha($fechaTurnoE)){
   $errors[]='<div class="alert alert-danger"> <h4 style="color:black;"><i class="icon-warning text-warning" style="font-size:80px;"></i><br>La Fecha Enviada no tiene la Estructura AAAA/MM/DD</h4></div>';
}else {


if(!validarHora($horaInicio)){
  $errors[]='<div class="alert alert-danger"> <h4 style="color:black;"><i class="icon-warning text-warning" style="font-size:80px;"></i><br>La Hora de Inicio no corresponde a una correcta</h4></div>';
}else{
 
if(!validarHora($horaFin)){
  $errors[]='<div class="alert alert-danger"> <h4 style="color:black;"><i class="icon-warning text-warning" style="font-size:80px;"></i><br>La Hora Fin no corresponde a una correcta</h4></div>';
}else{

          
$sqlE = "UPDATE turnoespecial SET idTurnoEspecial='$idTurnoEspecial',id_area='$area',codigoUnidad='$codigoUnidad',fechaTurnoEspecial='$fechaTurnoE',horaInicio='$horaInicio',horaFin='$horaFin' WHERE token= '$token'";

  
if($conectarBD->query($sqlE) == TRUE ){

$actualizado="<h2 class='alert alert-success' style='color: black;'><i class='icon-checkmark1 text-success' style='font-size:80px;'></i><br> Actualizado Satisfactoriamente </h2>
<a class='btn btn-primary type='button' href='./ListarTurnosEspeciales.php'>Volver </a>
";

$errors[]= $actualizado;

   }else{
             die(require '../errorAlgoSM.php');
                  }  
                } 
              }  
            }  
        }     
      }      
    }       

}

if(isset($_GET['token'])){
  if(empty($_GET['token'])){
    echo "<script>window.location.href='./listarTurnosEspeciales.php'; </script>"; 
}else{

$token = $_GET['token'];

if($conectarBD->connect_error){
    
        die( require '../errorAlgoSM.php');
}

$sql = "SELECT * FROM turnoespecials WHERE token = '$token'";

if ($conectarBD->query($sql)){
	
        $idTurnoEspecial = $conectarBD->query($sql)->fetch_assoc()['idTurnoEspecial'];
        $id_ficha = $conectarBD->query($sql)->fetch_assoc()['id_ficha'];
        $id_area = $conectarBD->query($sql)->fetch_assoc()['id_area'];
        $codigoUnidad = $conectarBD->query($sql)->fetch_assoc()['codigoUnidad'];
	     	$fechaTurnoEspecial = $conectarBD->query($sql)->fetch_assoc()['fechaTurnoEspecial'];
        $horaInicio= $conectarBD->query($sql)->fetch_assoc()['horaInicio'];
        $horaFin = $conectarBD->query($sql)->fetch_assoc()['horaFin'];
	     	$tokenBD= $conectarBD->query($sql)->fetch_assoc()['token'];
      }   
    }
}
 

        
?>
<!DOCTYPE html>
<html>
<head>
	<title>Editar Turno Especial</title>
  <link rel="icon" type="image/png" sizes="16x16" href="../situ.png">
  <link rel="stylesheet" type="text/css" href="../estilos.css">
  
<link rel="stylesheet" type="text/css" href="../Assets/fonts/style.css">

	<link rel="stylesheet" type="text/css" href="../Assets/bootstrap-4.3.1-dist/css/bootstrap.min.css
">
</head>
<body class=" bg-white">

<?php include '../navAdmi.php';?>
<body class=" bg-light">
<?php require '../navegacion.php';

?>

  <form role="form" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" autocomplete="off">
<input type="hidden"  value="<?= $token?> "  class="campos" hidden name="token" >
<input type="hidden"  value="<?= $idTurnoEspecial?> "  class="campos" hidden="" name="idTurnoEspecial" >
   
    <div align="center" class="container" >
<div style="margin-left: 100px; margin-right: 100px;">
<br>

    <?php

     echo '<br>'.resultBlock($errors);
?>
  <?php
if (isset($tokenBD)){
  if (!empty($tokenBD)){
if (empty($errors && $actualizado)>0){


?>
</div>

	  <h1 class="font-weight-bold">TURNO ESPECIAL</h1>
<br>	  

<div class="form-row">
  <div class="form-group col-md-4"> 
<?php
  $sqlArea="SELECT * FROM area WHERE id_area='$id_area'";
  $nomArea=$conectarBD->query($sqlArea)->fetch_assoc()['nombreArea'];
?>
			<label  class="font-weight-bold">Area Actual</label>
			<input type="text" class="form-control " value="<?=$nomArea ?>" readonly="readonly">
	</div>

      <?php

  $query="SELECT * FROM area ORDER BY nombreArea ASC";
  if ($conectarBD->query($query)-> num_rows > 0) {
    ?>  

    <div class="form-group col-md-4">  
     <label class="font-weight-bold"> Nueva Area </label>
			<select name="area" class="form-control" id="area" required class="campos">
				<option value="0">Seleccione uno...</option>
         
   <?php 
   foreach($conectarBD->query($query) as $area) {
     ?>
   
   <option value="<?php echo $area['id_area']; ?>">
   <?php echo $area['nombreArea']; ?>
   </option>
   
   <?php
   }
  }
   ?>
</select>
</div>
   <br>

    <div class="form-group col-md-4">     
<?php
  $sqlUnidad="SELECT * FROM unidad WHERE codigoUnidad='$codigoUnidad'";
  $nomUnidad=$conectarBD->query($sqlUnidad)->fetch_assoc()['nombreUnidad'];
?>
	     <label  class="font-weight-bold">Unidad Actual</label>
	     <input type="text" class="form-control " value="<?=$nomUnidad ?>" readonly="readonly">
	  </div>
</div>		  

<div class="form-row">
  <div class="form-group col-md-4"> 
  <label  class="font-weight-bold">Nueva Unidad</label>
  <select class="form-control" name="codigoUnidad" id="codigoUnidad">  
    
   
  </select>
</div>

  <div class="form-group col-md-4"> 
			<label  class="font-weight-bold">Numero Ficha:</label>
			<input type="text" class="form-control" value="<?=$id_ficha ?>" readonly="readonly">
	</div>		


	<div class="form-group col-md-4">  
	  <label  class="font-weight-bold">Fecha de Turno Especial</label>
    <input type="date" class="form-control" value="<?= $fechaTurnoEspecial?>"  name="fechaTurno" id="fechaTurno"  >
      <br>
	</div>      
</div>
<div class="form-row">

  <div class="form-group col-md-4"> 
        <label  class="font-weight-bold" >Hora Inicio:</label>
       <input type="time" class="form-control" value="<?=$horaInicio ?>"   min="07:00" max="16:00" name="horaInicio" id="horaInico" >
	</div>
  	          

  <div class="form-group col-md-4">   
      <label  class="font-weight-bold"> Hora Fin:</label> 
      <input type="time" name="horaFin" value="<?=$horaFin?>" min="07:00"  max="16:00" class="form-control " id="horaFin"   >
  </div>
</div>
<br>
	<div class="container">
  <button type="reset" title="Limpiar Registro" class="btn" >
    <i class="icon-loop2 text-secondary" style="font-size: 35px;"></i> 
  </button>

  <button type="button" class="btn" title="Cancelar"  onclick="window.location.href='./listarTurnosEspeciales.php'">
      <i class="icon-cancel text-danger" style="font-size: 50px;"> </i>
  </button>
  
  <button type="submit" name="btnEditar" class="btn font-weight-bold "  title="Actualizar Turno">
          <i class="icon-checkmark1 text-success" style="font-size: 50px;"></i>
  </button>
 </div> 

        </form>
   <?php
 }
?>

<?php
 }
  
 
}else{
 require '../errorAlgoSM.php';
 }
?>

</div>
<script type="text/javascript" src="../Assets/Jquery/jQuery_v3.4.1.js"></script>
<script type="text/javascript" src="../Assets/bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>
 <script type="text/javascript">
      $(document).ready(function(){
        $("#area").change(function () {
 
          $("#area option:selected").each(function () {
            area = $(this).val();
            $.post("./datosUnidad.php", { area: area }, function(data){
              $("#codigoUnidad").html(data);
            });            
          });
        })
      });
    </script>   
</body>

</html>
