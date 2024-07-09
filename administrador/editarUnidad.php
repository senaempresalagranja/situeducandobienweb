<?php
session_start();
require_once '../conecion.php';
require '../Assets/funcion.php';


$tipoUsuario = $_SESSION['tipo'];
if(empty($_SESSION['tipo'])){
echo "<script>window.location.href='../index.php'; </script>";
}

?>
<!DOCTYPE html>
<html>
<head>
      
  <title>Editar Unidad</title>
  <link rel="icon" type="image/png" sizes="16x16" href="../situ.png">
   <link rel="stylesheet" type="text/css" href="../estilos.css">
     <link rel="stylesheet" type="text/css" href="../Assets/fonts/style.css">
      <link rel="stylesheet" type="text/css" href="../Assets/bootstrap-4.3.1-dist/css/bootstrap.min.css">

</head>
<body class="bg-white">


<?php include '../navAdmi.php'; ?>
<?php include '../navegacion.php'; ?>

  <div>
<?php

if(isset($_GET['token'])){
  if(empty($_GET['token'])){

echo "<script>window.location.href='./listarUnidades.php'; </script>";
 
}else{

$token = $_GET['token'];

$sqlI="SELECT * FROM infou15 WHERE token = '$token'";
if($conectarBD->query($sqlI)){ 
$horaInicioT=$conectarBD->query($sqlI)->fetch_assoc()['horaInicioT'];
$horaFinT=$conectarBD->query($sqlI)->fetch_assoc()['horaFinT'];
$token15=$conectarBD->query($sqlI)->fetch_assoc()['token'];
}

if($conectarBD->connect_error){
    
    die("conexion fallida:".$conectarBD->connect_error);
}

$sqlS = "SELECT * FROM unidad INNER JOIN area ON unidad.id_area=area.id_area WHERE unidad.token = '$token'";

if($conectarBD->query($sqlS)->num_rows > 0){

    $id_Unidad = $conectarBD->query($sqlS)->fetch_assoc()['id_Unidad'];
    $codigoUnidad = $conectarBD->query($sqlS)->fetch_assoc()['codigoUnidad'];
    $nombreUnidad = $conectarBD->query($sqlS)->fetch_assoc()['nombreUnidad'];
    $tipoTurno = $conectarBD->query($sqlS)->fetch_assoc()['tipoTurno'];
    $horaInicioM = $conectarBD->query($sqlS)->fetch_assoc()['horaInicioM'];
    $horaFinM = $conectarBD->query($sqlS)->fetch_assoc()['horaFinM'];
    $cantidadAprendices = $conectarBD->query($sqlS)->fetch_assoc()['cantidadAprendices'];
    $area = $conectarBD->query($sqlS)->fetch_assoc()['id_area'];
    $nombreArea=$conectarBD->query($sqlS)->fetch_assoc()['nombreArea'];
    $tokenBD=$conectarBD->query($sqlS)->fetch_assoc()['token'];  
      }
    }
} 

$errors=array();

if (isset($_POST)) {
if (!empty($_POST)) {
$area = ($_POST['area']);
    $codigoUnidad = $conectarBD->real_escape_string( $_POST['codigoUnidad']);
    $nombreUnidad = $conectarBD->real_escape_string($_POST['nombreUnidad']);
    $tipoTurno = $conectarBD->real_escape_string( $_POST['tipoTurno']);
    $horaInicioM = $conectarBD->real_escape_string( $_POST['horaInicioM']);
    $horaFinM = $conectarBD->real_escape_string( $_POST['horaFinM']);
    $cantidadAprendices = $conectarBD->real_escape_string( $_POST['cantidadAprendices']);
    $area = $conectarBD->real_escape_string($_POST['area']);
    $token = $conectarBD->real_escape_string($_POST['tokenBD']);

if(isset($_POST['horaInicioT'])){
  $horaIT=$_POST['horaInicioT'];
}

if(isset($_POST['horaFinT'])){
  $horaFT=$_POST['horaFinT'];
}
     
 if($nombreUnidad==""){
  


  $errors[]= "<h4 align='center' class='alert alert-danger alert-dismissible fade show text-dark'>
  <i class='icon-notification text-warning' style='font-size: 80px;' ></i> <br>
  No Ingresaste Un Nombre De Unidad
   <button type='button' class='close' value='cerrar' data-dismiss='alert' aria-label='close'>
  <span aria-hidden='true'>&times; </span>
   </button>
  </h4>";

}
if($codigoUnidad==""){
  $errors[]= "<h4 align='center' class='alert alert-danger alert-dismissible fade show text-dark'>
  <i class='icon-notification text-warning' style='font-size: 80px;' ></i> <br>
  No Ingresaste Un Codigo En El Campo Codigo
   <button type='button' class='close' value='cerrar' data-dismiss='alert' aria-label='close'>
  <span aria-hidden='true'>&times; </span>
   </button>
  </h4>";


  }
if(!validarEntero($codigoUnidad)) {
   $errors[] = "<h4 align='center' class='alert alert-danger alert-dismissible fade show text-dark'>
  <i class='icon-notification text-warning' style='font-size: 80px;' ></i> <br>
  Ingresaste Un Codigo Incorrecto
   <button type='button' class='close' value='cerrar' data-dismiss='alert' aria-label='close'>
  <span aria-hidden='true'>&times; </span>
   </button>
  </h4>";
 ;
}
if($area==""){
  $errors[]="<h4 align='center' class='alert alert-danger alert-dismissible fade show text-dark'>
  <i class='icon-notification text-warning' style='font-size: 80px;' ></i> <br>
  No Ingresaste El Campo Area
   <button type='button' class='close' value='cerrar' data-dismiss='alert' aria-label='close'>
  <span aria-hidden='true'>&times; </span>
   </button>
  </h4>";
  
}
if(empty($tipoTurno)){
  $errors[]= "<h4 align='center' class='alert alert-danger alert-dismissible fade show text-dark'>
  <i class='icon-notification text-warning' style='font-size: 80px;' ></i> <br>
  Seleccione un tipo de turno
   <button type='button' class='close' value='cerrar' data-dismiss='alert' aria-label='close'>
  <span aria-hidden='true'>&times; </span>
   </button>
  </h4>";
  
  }
  if(empty($horaInicioM)){
  $errors[]= "<h4 align='center' class='alert alert-danger alert-dismissible fade show text-dark'>
  <i class='icon-notification text-warning' style='font-size: 80px;' ></i> <br>
Ingresa una hora de turno
   <button type='button' class='close' value='cerrar' data-dismiss='alert' aria-label='close'>
  <span aria-hidden='true'>&times; </span>
   </button>
  </h4>";
 
  }
  if($cantidadAprendices==""){
  $errors[]= "<h4 align='center' class='alert alert-danger alert-dismissible fade show text-dark'>
  <i class='icon-notification text-warning' style='font-size: 80px;' ></i> <br>
    No Ingresaste una cantidad de aprendices
   <button type='button' class='close' value='cerrar' data-dismiss='alert' aria-label='close'>
  <span aria-hidden='true'>&times; </span>
   </button>
  </h4>";
  }
  if(!validarEnteroC($cantidadAprendices)) {
   $errors[] = "<h4 align='center' class='alert alert-danger alert-dismissible fade show text-dark'>
  <i class='icon-notification text-warning' style='font-size: 80px;' ></i> <br>
    Ingresaste una cantidad incorrecta
   <button type='button' class='close' value='cerrar' data-dismiss='alert' aria-label='close'>
  <span aria-hidden='true'>&times; </span>
   </button>
  </h4>";
}
$sqlA="SELECT * FROM area WHERE id_area='$area'";
        $areaBD= $conectarBD->query($sqlA)->fetch_assoc()['id_area'];
        if($area !=$areaBD){
          $errors[]="<h4 align='center' class='alert alert-danger alert-dismissible fade show text-dark'>
  <i class='icon-notification text-warning' style='font-size: 80px;' ></i> <br>
  Selecciona Un Area Existente
   <button type='button' class='close' value='cerrar' data-dismiss='alert' aria-label='close'>
  <span aria-hidden='true'>&times; </span>
   </button>
  </h4>";
        
      }else{

if(count($errors)==0){

if(isset($token15)) {
    $sqlU="UPDATE infou15 SET codigoUnidad='$codigoUnidad', horaInicioT='$horaIT', horaFinT='$horaFT' WHERE token='$token'";

    if($conectarBD->query($sqlU) == TRUE){
    $sql = "UPDATE unidad SET codigoUnidad ='$codigoUnidad',nombreUnidad ='$nombreUnidad', id_area='$area', tipoTurno='$tipoTurno', horaInicioM='$horaInicioM', horaFinM='$horaFinM', cantidadAprendices='$cantidadAprendices' WHERE token='$token'";
    }

  }else{

$sql = "UPDATE unidad SET codigoUnidad ='$codigoUnidad',nombreUnidad ='$nombreUnidad', id_area='$area', tipoTurno='$tipoTurno', horaInicioM='$horaInicioM', horaFinM='$horaFinM', cantidadAprendices='$cantidadAprendices' WHERE token='$token'";

}

if($conectarBD->query($sql) == TRUE ){

$actualizado="<h4 align='center' class='alert alert-success alert-dismissible fade show text-dark'>

   <button type='button' class='close' value='cerrar' data-dismiss='alert' aria-label='close'>
  <span aria-hidden='true'>&times; </span>
   </button>

  <i class='icon-checkmark1 text-success' style='font-size:80px;'></i><br> Actualizado Satisfactoriamente </h2>
<a class='btn btn-primary type='button' href='./listarUnidades.php'>Volver </a>


  </h4>";

   }else{
             $errors[]='Error al Actualizar';
                  }  
                } 
              }
            }  
        }
?>
</div>


<br>
  <div align="center" class="container font-weight-bold ">
    <div style="margin-left: 100px; margin-right: 100px;">
<br>

    <?php

     echo '<br>'.resultBlock($errors);
?>
  <?php
if(isset($tokenBD)){
if (empty($actualizado )){
 
?>
  <h2 class="font-weight-bold">ACTUALIZAR UNIDAD</h2>
  
  <br>
    <div class="form-group">
                    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" autocomplete="off">
                      <input type="text"  value="<?= $tokenBD ?> "  class="campos" hidden="" name="tokenBD" >
    <div class="form-row">
      <div class="form-group col-md-4">
    <label  class="font-weight-bold">Codigo de la Unidad:</label>
    <input type="number" name="codigoUnidad" id="codigoUnidad"  value="<?= $codigoUnidad ?>" class="form-control" placeholder="2343245"  required="" >
    </div>
    
     <?php
    $sqlA = "SELECT * FROM area ORDER BY nombreArea ASC";
   
    ?>
     <div class="form-group col-md-4">
    <label class="font-weight-bold">Area:</label>
    <select  class="form-control"   name="area" id="area"  >
          <option><?php echo $nombreArea; ?></option>
        <option class="font-weight-bold"  value="">Seleccione un area</option>
      <?php
     foreach($conectarBD->query($sqlA) as $area){
      ?>
     <option class="font-weight-bold " value="<?php echo $area['id_area'];?>"><?php
      echo $area['nombreArea'];?></option>
     <?php
  
     }
      ?>
      
    </select>
  </div>


     <div class="form-group col-md-4">
    <label class="font-weight-bold">Nombre Unidad:</label>
    <input type="text" name="nombreUnidad" value="<?= $nombreUnidad ?>" id="nombreUnidad" class="form-control " placeholder="porcinos"   required="" >
    </div>
    
</div>
  <div class="form-row">
   
       <div class="form-group col-md-4">
    <label  class="font-weight-bold">Tipo Turno:</label>
      <select  class="form-control "  name="tipoTurno" id="tipoTurno"  >
        <option><?php echo $tipoTurno; ?></option>
    <option class="font-weight-bold"  value="">Seleccione Tipo Turno</option>
    <option class="font-weight-bold"  value="1">normal</option>
    <option class="font-weight-bold"  value="2">15 dias</option>
  </select>
   </div>
  
  <div class="form-group col-md-4">
    <label  class="font-weight-bold">Cantidad De Aprendices:</label>
      <input class="form-control" type="number"  value="<?= $cantidadAprendices ?>" name="cantidadAprendices" id="cantidadAprendices"  required="required"  placeholder="28">
      </div>
 
<div class="form-group col-md-4">
    <label class="font-weight-bold">Hora Inicio</label>
        <input class="form-control" type="time" name="horaInicioM" value="<?php echo $horaInicioM; ?>">
    </div>

  </div>

<div class="form-row">
  <div class="form-group col-md-4">
    <label class="font-weight-bold">Hora Fin Turno</label>
        <input class="form-control" type="time" name="horaFinM" value="<?php echo $horaFinM; ?>">
    </div>

<?php 

if(isset($horaInicioT)){
?>
<div class="form-group col-md-4">
    <label class="font-weight-bold">Hora Inicio Turno Tarde</label>
        <input class="form-control" type="time" name="horaInicioT" value="<?php echo $horaInicioT; ?>">
    </div>


<div class="form-group col-md-4">
    <label class="font-weight-bold">Hora Fin Turno Tarde</label>
        <input class="form-control" type="time" name="horaFinT" value="<?php echo $horaFinT; ?>">
    </div>
<?php
    }

?>
</div>

<br>    
<div>

  <button type="button" class="btn" title="Cancelar"  onclick="window.location.href='./listarUnidades.php'">
      <i class="icon-cancel text-danger" style="font-size: 50px;"> </i>
  </button>
  

  <button type="submit"  class="btn font-weight-bold "  title="Actualizar Unidad">
  <i class="icon-checkmark1 text-success" style="font-size: 50px;"></i>
  </button>
 </div> 

</form>
      </div>
</div>
</div>

<?php
}else{
echo $actualizado;
}
?>

<?php
}else{
  echo "<div class='container'>";
  die(include '../errorAlgoSM.php');
  echo "</div>";
}
?>
 
<script type="text/javascript" src="../Assets/Jquery/jQuery_v3.4.1.js"></script>
<script type="text/javascript" src="../Assets/bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>

</body>
</html>






