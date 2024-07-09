
  
<?php 
session_start();
require '../conecion.php';
require '../Assets/funcion.php';



$idUser=$_SESSION['id'];
$tipoUsuario = $_SESSION['tipo'];
if(empty($_SESSION['tipo'])) {
    echo "<script>window.location.href='../index.php'; </script>";  
}
 ?>
 <?php
$errors= array();
if (!empty($_POST)) {
$id_ficha = $_POST['id_ficha'];
$id_programaF = $_POST['id_programaF'];
$id_area = $_POST['area'];
$cantidad_aprendices =$_POST['cantidad_aprendices'];
$inicio_formacion = $_POST['inicio_formacion'];
$fin_formacion = $_POST['fin_formacion'];
$programa = $_POST['id_programaF'];


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


if ($_SERVER['REQUEST_METHOD']=='POST'){

if($conectarBD->connect_error){
    die("conexion fallida: ".$conectarBD->connect_error);
    
    
}

$id_ficha = $_POST['id_ficha'];
$id_programaF = $_POST['id_programaF'];
$id_area = $_POST['area'];
$cantidad_aprendices =$_POST['cantidad_aprendices'];
$inicio_formacion = $_POST['inicio_formacion'];
$fin_formacion = $_POST['fin_formacion'];
$programa = $_POST['id_programaF'];
$token= md5($id_ficha."+".$id_programaF);

$sql = "INSERT INTO ficha(id_ficha,token, id_programaF, id_area, cantidad_aprendices, inicio_formacion,fin_formacion) VALUES ('$id_ficha','$token', '$id_programaF', '$id_area','$cantidad_aprendices', '$inicio_formacion', '$fin_formacion')";
            
          if(count($errors)==0) {
           if($conectarBD->query($sql) == TRUE ){

             die("<div align='center'><span class='icon-checkmark1' style='font-size:50px;'></span><h4>Registro creado con exito</h4>
                    <a class='btn btn-warning' href='./ListarFichas.php'>Ver Registros</a></div>");
    }
  }
?>
<?php
    }
  }
}
?>

<!DOCTYPE html>
<html>
<head>
<?php include '../navAdmi.php';?>

  <title>Registrar Ficha</title><link rel="icon" type="image/png" sizes="16x16" href="../situ.png">
 <link rel="stylesheet" type="text/css" href="../estilos.css">
  <link rel="stylesheet" type="text/css" href="../Assets/fonts/style.css">
  <link rel="stylesheet" type="text/css" href="../Assets/bootstrap-4.3.1-dist/css/bootstrap.min.css
">
</head>
<body class=" bg-white">
<?php require '../navegacion.php';?>

    <br>
    <br>

    <div align="center" class="container">
      
        <h1>Registrar Ficha</h1>
      <div align="center">
               <div style="margin-left: 350px; margin-right: 350px;">
                <?php  echo resultBlock($errors);?>
                </div> 
  <br>
    
                    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" autocomplete="off">
<div class="form-row"> 
  <div class="form-group col-md-4">
  
  <label  class="font-weight-bold">Numero De Ficha:</label> 
    <input type="number"  name="id_ficha" id="id_ficha" required  placeholder="1802578"  class="form-control" >
  </div>          
    
  <div class="form-group col-md-4">               
 <?php

$sqlF="SELECT * FROM programas ORDER BY nombreP ASC";
if ($conectarBD->query($sqlF)->num_rows > 0) {
    ?>  

    <label  class="font-weight-bold">Nombre programa de formacion:</label>
    

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
   
 <div class="form-group col-md-4">  
   <?php

$sql="SELECT * FROM area ORDER BY nombreArea ASC";
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
      
      ?>

    </select>
  </div>
</div>  
<br>  
<br>

<div class="form-row">
<div class="form-group col-md-4">
    <label  class="font-weight-bold">Cantidad De Aprendices:</label>
    <br>
    <input type="number" name="cantidad_aprendices" id="cantidad_aprendices"  required="required"  placeholder="28" class="form-control">
</div>
    <br>
<div class="form-group col-md-4">   
      <label  class="font-weight-bold">Inicio de la Formacion:</label>
      <br>
      <input type="date" name="inicio_formacion" id="inicio_formacion" required="required" placeholder=" 01/05/2019" class="form-control ">
</div>
  <div class="form-group col-md-4">
      <label  class="font-weight-bold">Fin de la Formacion:</label>
      <br>
      <input type="date" name="fin_formacion" id="fin_formacion"   required="required" placeholder=" 02/05/2021"  class="form-control">
</div>
      <
</div>    
<br>
<div>

  <button type="reset" title="Limpiar Registro" class="btn" >
    <i class="icon-loop2 text-secondary" style="font-size: 35px;"></i> 
  </button>

  <button type="button" class="btn" title="Cancelar Registro"  onclick="window.location.href='./listarFichas.php'">
      <i class="icon-cancel text-danger" style="font-size: 50px;"> </i>
  </button>
  

  <button type="submit"  class="btn font-weight-bold "  title="Registrar Unidad">
  <i class="icon-checkmark1 text-success" style="font-size: 50px;"></i>
  </button>
 </div> 
</form>  
</div>
<script type="text/javascript" src="../Assets/Jquery/jQuery_v3.4.1.js"></script>
<script type="text/javascript" src="../Assets/bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>
</body>
</html>