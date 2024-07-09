<?php
session_start();
require_once '../conecion.php';
require '../Assets/funcion.php';


$tipoUsuario = $_SESSION['tipo'];
if(empty($_SESSION['tipo'])){
  echo "<script>window.location.href='../index.php'; </script>";  
}
if(isset($_GET['token'])){
  if(empty($_GET['token'])){

  echo "<script>window.location.href='./listarFichas.php'; </script>";  
   
}else{

$token = $_GET['token'];

if($conectarBD->connect_error){
    
    die("conexion fallida:".$conectarBD->connect_error);
}

$sqlS = "SELECT * FROM ficha WHERE token = '$token'";

if($conectarBD->query($sqlS)->num_rows > 0){

       $tokenBD = $conectarBD->query($sqlS)->fetch_assoc()['token'];
       $id_ficha= $conectarBD->query($sqlS)->fetch_assoc()['id_ficha'];
       $id_programaF = $conectarBD->query($sqlS)->fetch_assoc()['id_programaF'];
       $id_area = $conectarBD->query($sqlS)->fetch_assoc()['id_area'];
       $cantidad_aprendices = $conectarBD->query($sqlS)->fetch_assoc()['cantidad_aprendices'];
       $inicio_formacion = $conectarBD->query($sqlS)->fetch_assoc()['inicio_formacion'];
       $fin_formacion = $conectarBD->query($sqlS)->fetch_assoc()['fin_formacion'];
       
       $sqlN = "SELECT * FROM programas WHERE id_programaF = '$id_programaF'";

        if($conectarBD->query($sqlN)->num_rows > 0){
          $nombre = $conectarBD->query($sqlN)->fetch_assoc()['nombreP'];

          }
        $sqlAR = "SELECT * FROM area WHERE id_area = '$id_area'";

        if($conectarBD->query($sqlAR)->num_rows > 0){
          $nombreAR = $conectarBD->query($sqlAR)->fetch_assoc()['nombreArea'];

          }

      }
  }
}
$errors=array();

if (isset($_POST)) {
if (!empty($_POST)) {
  $area = ($_POST['area']);
    $tokenBD = $conectarBD->real_escape_string( $_POST['tokenBD']);
    $id_ficha = $conectarBD->real_escape_string($_POST['id_ficha']);
    $id_programaF = $conectarBD->real_escape_string( $_POST['id_programaF']);
    $id_area = $conectarBD->real_escape_string( $_POST['area']);
    $cantidad_aprendices = $conectarBD->real_escape_string( $_POST['cantidad_aprendices']);
    $inicio_formacion = $conectarBD->real_escape_string($_POST['inicio_formacion']);
    $fin_formacion = $conectarBD->real_escape_string($_POST['fin_formacion']);

     
if($id_ficha==""){
  $errors[]= "<h4 align='center' class='text-dark'>
  <i class='icon-notification text-warning' style='font-size: 80px;' ></i> <br>
  No Ingresaste Una ficha
  </h4>";

}
if($id_programaF==""){
  $errors[]= "<h4 align='center' class='text-dark'>
  <i class='icon-notification text-warning' style='font-size: 80px;' ></i> <br>
  No Ingresaste Un programa de formacion
  </h4>";
 
  }
if(!validarEnteroA($id_ficha)) {
   $errors[] = "<h4 align='center' class='text-dark'>
  <i class='icon-notification text-warning' style='font-size: 80px;' ></i> <br>
  Ingresaste Un Codigo Incorrecto
  </h4>";
  
}
if($id_area==""){
  $errors[]= "<h4 align='center' class='text-dark'>
  <i class='icon-notification text-warning' style='font-size: 80px;' ></i> <br>
  No Ingresaste El Campo Area
  </h4>";
 
}
$sqlP="SELECT * FROM programas WHERE id_programaF='$id_programaF'";
        $programaBD= $conectarBD->query($sqlP)->fetch_assoc()['id_programaF'];
        if($id_programaF !=$programaBD){
          $errors[]="<h4 align='center' class='text-dark'>
  <i class='icon-notification text-warning' style='font-size: 80px;' ></i> <br>
  Selecciona Un programa Existente
  </h4>";
}     
  if($cantidad_aprendices==""){
  $errors[]= "<h4 align='center' class='text-dark'>
  <i class='icon-notification text-warning' style='font-size: 80px;' ></i> <br>
  ingresa una cantidad valida
  </h4>";
  
  }
if(!validarEntero($cantidad_aprendices)) {
   $errors[] = "<h4 align='center' class='text-dark'>
  <i class='icon-notification text-warning' style='font-size: 80px;' ></i> <br>
  Ingresa Un numero correcto de Aprendices
  </h4>";
   
}
if($inicio_formacion==""){
  $errors[]= "<h4 align='center' class='text-dark'>
  <i class='icon-notification text-warning' style='font-size: 80px;' ></i> <br>
  No Ingresaste Una fecha correcta
  </h4>";
 
}if($fin_formacion==""){
  $errors[]= "<h4 align='center' class='text-dark'>
  <i class='icon-notification text-warning' style='font-size: 80px;' ></i> <br>
  No Ingresaste Una fecha correcta
  </h4>";
 
   
}else{
if (count($errors)==0) {

$sql= "UPDATE ficha SET id_ficha='$id_ficha', id_programaF ='$id_programaF', id_area='$area', cantidad_aprendices='$cantidad_aprendices', inicio_formacion='$inicio_formacion', fin_formacion='$fin_formacion' WHERE token ='$tokenBD'";

if($conectarBD->query($sql) == TRUE ){  
$actualizado="<h2 class='alert alert-success' style='color: black;'><i class='icon-checkmark1 text-success' style='font-size:80px;'></i><br> Actualizado Satisfactoriamente </h2>
<a class='btn btn-primary type='button' href='./ListarFichas.php'>Volver </a>
";
   }else{
             $errors[]='Error al Actualizar';
                  } 
                }
              }
            }
          }
?>
</div>
<!DOCTYPE html>
<html>
<head>
  <title>Editar Ficha</title>	<link rel="icon" type="image/png" sizes="16x16" href="../situ.png">
  <link rel="stylesheet" type="text/css" href="../estilos.css">
  <link rel="stylesheet" type="text/css" href="../Assets/fonts/style.css">
  <link rel="stylesheet" type="text/css" href="../Assets/bootstrap-4.3.1-dist/css/bootstrap.min.css
">
</head>
<?php include '../navAdmi.php';?>
<body class=" bg-white">
<?php require '../navegacion.php';
?>
<br>
  <div align="center" class="container font-weight-bold ">
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
    
    <br>
    <div align="center" class="container">
        
        <h1 class="font-weight-bold">EDITAR FICHA</h1>
       <br>
    <div class="form-group">
    
                    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" autocomplete="off" >
  <div class="form-row">

<input type="text"  value="<?= $token ?> "  class="campos" hidden="" name="tokenBD" >

  <div class="form-group col-md-4">  
  <label class="font-weight-bold">Numero De Ficha Actual: </label>
    <br>
     <input type="text" value='<?=$id_ficha?>'  name="id_ficha" id="" class="form-control font-weight-bold " >
</div>

  <div class="form-group col-md-4">  
  <label class="font-weight-bold">Programa Actual</label>
    <input type="text" value='<?= $nombre?>' readonly="readonly" name="id_programaF" id="" class="form-control font-weight-bold ">  
  </div>
  


  <?php
$sqlF="SELECT * FROM programas ORDER BY nombreP ASC";
if ($conectarBD->query($sqlF)-> num_rows > 0) {
    ?>  
    <div class="form-group col-md-4">  
    <label  class="font-weight-bold">  Programa Nuevo </label>
    
<select class="form-control" name="id_programaF" id="id_programaF" >  
        <option value="">Seleccione un Programa</option>

      <?php

     foreach($conectarBD->query($sqlF) as $programa){
      ?>
     <option value="<?php echo $programa['id_programaF'];?>"><?php
      echo $programa['nombreP'];?></option>
     <?php
     
   }

     }
      
      ?>

      </select>
    </div>
</div>
  <div class="form-row">
    <div class="form-group col-md-4">  
    <label  class="font-weight-bold">Area Actual</label>
    <input type="text"  value='<?= $nombreAR?>' readonly="readonly"  id="" class="form-control font-weight-bold">
    </div>
    <br>
    <div class="form-group col-md-4"> 

 <?php

$sql="SELECT * FROM area ORDER BY nombreArea ASC";
if ($conectarBD->query($sql)-> num_rows > 0) {
    ?>  
      <label  class="font-weight-bold">Area:</label>
      <br>  
                        
<select class="form-control" name="area" id="area" >  
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
    <label class="font-weight-bold">Cantidad De Aprendices:</label>
    <br>
                <input type="text" value='<?= $cantidad_aprendices?>'name="cantidad_aprendices" id="" class="form-control font-weight-bold">
    </div>
  </div>

<div class="form-row" style="margin-left: 25%;">
    <div class="form-group col-md-4">  
       <label class="font-weight-bold">Inicio de la Formacion:</label>
      <input type="date" value='<?= $inicio_formacion?>' name="inicio_formacion" id="" class="form-control font-weight-bold">
    </div>
    
    <div class="form-group col-md-4">  
    <label class="font-weight-bold">Fin de la Formacion:</label>
    <input type="date"value='<?= $fin_formacion?>' name="fin_formacion" id="" class="form-control font-weight-bold">
</div>
      </div>
<br><br><br>
<div>

  <button type="reset" title="Limpiar Registro" class="btn" >
    <i class="icon-loop2 text-secondary" style="font-size: 35px;"></i> 
  </button>

  <button type="button" class="btn" title="Cancelar Registro"  onclick="window.location.href='./listarFichas.php'">
      <i class="icon-cancel text-danger" style="font-size: 50px;"> </i>
  </button>
  

  <button type="submit"  class="btn font-weight-bold "  title="Actualizar Ficha">
  <i class="icon-checkmark1 text-success" style="font-size: 50px;"></i>
  </button>
 </div> 

                        
</form>
 </div>
</div>
<?php
}else{
  echo $actualizado;
}

}
}else{

  die(require '../errorAlgoSM.php');
}



?>
<script type="text/javascript" src="../Assets/Jquery/jQuery_v3.4.1.js"></script>
<script type="text/javascript" src="../Assets/bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>
<script type="text/javascript">
  document.getElementById("codigoUnidad").focus();

  </script> </body>
</html>
