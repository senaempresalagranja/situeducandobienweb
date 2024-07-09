<?php 
session_start();
require '../conecion.php';
require '../Assets/funcion.php';




$idUser=$_SESSION['id'];
$tipoUsuario = $_SESSION['tipo'];
if(empty($_SESSION['tipo'])) {
   echo "<script>window.location.href='../index.php'; </script>";  
}


 $errors = array();
  if (!empty($_POST)) {

    $idTurnoEspecial = $conectarBD->real_escape_string($_POST['idTurnoEspecial']);
    $area = $conectarBD->real_escape_string( $_POST['area']);
    $codigoUnidad = $conectarBD->real_escape_string( $_POST['codigoUnidad']);
    $id_ficha = $conectarBD->real_escape_string( $_POST['id_ficha']);
    $fechaTurnoE = $conectarBD->real_escape_string($_POST['fechaTurno']);
    $horaInicio = $conectarBD->real_escape_string( $_POST['horaInicio']);
    $horaFin = $conectarBD->real_escape_string( $_POST['horaFin']);
   
 $fecha=$fechaTurnoE;   
  $estado = 1;
        if (isNullTE( $area, $codigoUnidad, $id_ficha, $fecha, $horaInicio, $horaFin)) {
          $errors[]='<div class="alert alert-danger"><i class="icon-warning text-warning" style="font-size:70px; margin-left:10px;"></i><h5 class="text-dark">Debe llenar Todos los Campos </h5> </div>';

          if(empty($area)){
            $errors[]='<h6 class="alert alert-danger text-dark">Error Seleccione area</h6>';
          }
          if(empty($codigoUnidad)){
            $errors[]='<h6 class="alert alert-danger text-dark">Error Seleccione una Unidad</h6>';
          }
          if (empty($id_ficha)) {
                 $errors[]='<h6 class="alert alert-danger text-dark">Error Seleccione una Ficha</h6>';
          }
          if (empty($fecha)) {
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

    $token   = generateToken();

 $sqlA="SELECT * FROM area WHERE id_area='$area'";
 $areaBD= $conectarBD->query($sqlA)->fetch_assoc()['id_area'];
    if($area != $areaBD){
      $errors[]='<div class="alert alert-danger"> <h4 style="color:black;"><i class="icon-warning text-warning" style="font-size:80px;"></i><br>Seleccione un Area Existente</h4> </div>';
         }else {


    $sqlU="SELECT * FROM unidad WHERE codigoUnidad='$codigoUnidad'";
    $unidadDB= $conectarBD->query($sqlU)->fetch_assoc()['codigoUnidad'];
    if($codigoUnidad != $unidadDB){
       $errors[]='<div class="alert alert-danger"><h6 class="text-dark">Seleccione Unidad Existente</h6></div>';
    }else{


      $sqlF="SELECT * FROM ficha WHERE id_ficha='$id_ficha'";
    $fichaBD= $conectarBD->query($sqlF)->fetch_assoc()['id_ficha'];
    if($id_ficha != $fichaBD){
       $errors[]='<div class="alert alert-danger"><h4 style="color:black;"><i class="icon-warning text-warning" style="font-size:80px;"></i><br>Seleccione una Ficha Existente</h4></div>';
    }else{


if(!validarFecha($fecha)){
   $errors[]='<div class="alert alert-danger"> <h4 style="color:black;"><i class="icon-warning text-warning" style="font-size:80px;"></i><br>La Fecha Enviada no tiene la Estructura AAAA/MM/DD</h4></div>';
}else {

if(!validarHora($horaInicio)){
  $errors[]='<div class="alert alert-danger"> <h4 style="color:black;"><i class="icon-warning text-warning" style="font-size:80px;"></i><br>La Hora Enviada no corresponde a una correcta</h4></div>';
}else{
 
if(!validarHora($horaFin)){
  $errors[]='<div class="alert alert-danger"> <h4 style="color:black;"><i class="icon-warning text-warning" style="font-size:80px;"></i><br>La Hora Enviada no corresponde a una correcta</h4></div>';
}else{
          
  $sql = "INSERT INTO turnoespecial (token, id_ficha, id_area, codigoUnidad, fechaTurnoEspecial, horaInicio, horaFin) 
    VALUES ('$token' ,'$id_ficha' ,'$area' ,'$codigoUnidad' ,'$fecha' ,'$horaInicio' ,'$horaFin')";
  
if($conectarBD->query($sql) == TRUE ){
$errors[]='<h2 class="alert alert-success" style="color: black;"><i class="icon-checkmark1 text-success" style="font-size:80px;"></i><br> Turno Creado Satisfactoriamente </h2>
   <a class="btn btn-primary" role="button" href="./registrarTurnoEspecial.php">Nuevo Turno</a>
  <a class="btn btn-primary" role="button" href="./listarTurnosEspeciales.php">Volver</a>
';
    $errors[]=$actualizado;
   }else{
             $errors[]='Error al Registrar';
        }  
             }
            }
           } 
          }
        } 
      }  
    } 
       
        ?>

<?php
  
}
?>
<html>
<head>
	<title>Registrar Turno Especial</title>
  <link rel="icon" type="image/png" sizes="16x16" href="../situ.png">
  <link rel="stylesheet" type="text/css" href="../estilos.css">
   <link rel="stylesheet" type="text/css" href="../Assets/fonts/style.css">
	<link rel="stylesheet" type="text/css" href="../Assets/bootstrap-4.3.1-dist/css/bootstrap.min.css
">
</head>
<?php include '../navAdmi.php';?>
<body class=" bg-white">
<?php require '../navegacion.php';?>

<?php

   require_once '../conecion.php';

   if( $conectarBD->connect_error){
   	   die("Conexion Fallida:".$conectarBD->connect_error);
     }
  ?>   

    <form role="form" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" autocomplete="off">
    <div align="center" class="container">
<br>	
<div style="margin-left: 100px; margin-right: 100px;">

    <?php

     echo '<br>'.resultBlock($errors);
             ?>
</div>
<?php 
if (empty($errors && $actualizado)>0){


?>  
      <h1 class="font-weight-bold">TURNO ESPECIAL</h1>

<div class="form-row" >
  <div class="form-group col-md-4">    
   <input class="form-control " hidden type="text" name="idTurnoEspecial" id="idTurnoEspecial">
   
   <?php

$sql="SELECT * FROM area ORDER BY nombreArea ASC";
if ($conectarBD->query($sql)-> num_rows > 0) {
    ?>  
			<label  class="font-weight-bold">Area:</label>
			<br>	
                        
<select class="form-control" value="<?php if(isset($area)) echo $area?>" name="area" id="area" >  
        <option value="">Seleccione un area</option>

      <?php

     foreach($conectarBD->query($sql) as $area){
      ?>
     <option value="<?php echo $area['id_area'];?>"><?php
      echo $area['nombreArea'];?></option>
     <?php
     
   }

     }
      
      ?>

    </select>
</div>


 <div class="form-group col-md-4">  
   
    
      <label  class="font-weight-bold">Unidad:</label>
			<br>
    
     <select class="form-control" name="codigoUnidad" id="codigoUnidad">  
    
   
  </select>
</div>

  <div class="form-group col-md-4">  
<?php
           $sql2="SELECT * FROM ficha ORDER BY id_ficha ASC";
          if($conectarBD->query($sql2)-> num_rows > 0) {
?>
			<label  class="font-weight-bold">Numero Ficha:</label>
			<br>
			<select type="text" class="form-control" name="id_ficha" id="id_ficha" required="" class="campos">
			<option value="0">Selecciona uno </option>
      <?php
        foreach($conectarBD->query($sql2) as $ficha) {
      ?>
      <option value="<?php  echo $ficha['id_ficha']; ?>">
    <?php echo $ficha['id_ficha']; ?>
    </option>
    <?php
        }
      }   
    ?>
			</select>
  </div>
</div>
 <br>
<div class="form-row" >
    <div class="form-group col-md-4">
      <label  class="font-weight-bold">Fecha Del Turno Especial</label>
      <br>
      <input type="date" class="form-control" name="fechaTurno" id="fechaTurno" required class="campos">
    </div>
                       
      <div class="form-group col-md-4">                    
        <label  class="font-weight-bold" >Hora Inicio:</label>
        <input type="time" class="form-control" min="07:00" max="16:00" value="<?php if(isset($horaInicio)) echo $horaInicio?>" name="horaInicio" id="horaInicio" required class="campos">
      </div>
         
     <div class="form-group col-md-4">                    
      <label  class="font-weight-bold">Hora Fin:</label>
      <input type="time" name="horaFin" class="form-control" min="07:00" max="16:00" min="07:00" max="16:00" value="<?php if(isset($horaFin)) echo $horaFin?>" id="horaFin" required class="campos">
    </div>

  </div>			
		
</div>

<div align="center">

  <button type="reset" title="Limpiar Registro" class="btn" >
    <i class="icon-loop2 text-secondary" style="font-size: 35px;"></i> 
  </button>

  <button type="button" class="btn" title="Cancelar Registro"  onclick="window.location.href='./listarTurnosEspeciales.php'">
      <i class="icon-cancel text-danger" style="font-size: 50px;"> </i>
  </button>
  

  <button type="submit"  class="btn font-weight-bold "  title="Registrar Unidad">
  <i class="icon-checkmark1 text-success" style="font-size: 50px;"></i>
  </button>
 </div> 

<?php
}

?>
        </form>

 

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
		<br>
</body>
</html>