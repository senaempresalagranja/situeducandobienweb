<?php 
session_start();
require '../conecion.php';
require '../Assets/funcion.php';

$tipoUsuario = $_SESSION['tipo'];
if(empty($_SESSION['tipo'])) {
    echo "<script>window.location.href='../index.php'; </script>";  
}

?>

<!DOCTYPE html>
<html>
<head>
  <?php require '../navAdmi.php';?>
  <title>Registrar Programa</title>
  <link rel="icon" type="image/png" sizes="16x16" href="../situ.png">
  <meta charset="utf-8">
   <link rel="stylesheet" type="text/css" href="../estilos.css">
  <link rel="stylesheet" type="text/css" href="../Assets/fonts/style.css">
  <link rel="stylesheet" type="text/css" href="../Assets/bootstrap-4.3.1-dist/css/bootstrap.min.css">
  <link rel="icon" type="image/png" sizes="16x16" href="../situ.png">
  
 <?php require'../navegacion.php'; ?>
</head>
<body class=" bg-white">

<?php

$errors=array();


 if (!empty($_POST)) {
  
        $id_programaF = $conectarBD->real_escape_string($_POST['id_programaF']);
        $nombreP = $conectarBD->real_escape_string($_POST['nombreP']);
        $id_area = $conectarBD->real_escape_string($_POST['id_area']);

    if(isNullP($id_programaF, $nombreP, $id_area)){
     $errors[]="<h4 align='center' class='alert alert-danger alert-dismissible fade show text-dark'>
  <i class='icon-notification text-warning' style='font-size: 60px;' ></i> <br>
          Error Los campos estan vacíos
   <button type='button' class='close' value='cerrar' data-dismiss='alert' aria-label='close'>
  <span aria-hidden='true'>&times; </span>
   </button>
  </h4>";

    if(empty($id_programaF)){
         $errors[]="<h4 align='center' class='alert alert-danger alert-dismissible fade show text-dark'>
  <i class='icon-notification text-warning' style='font-size: 60px;' ></i> <br>
          Error el campo está vacío, Digite un ID de programa
   <button type='button' class='close' value='cerrar' data-dismiss='alert' aria-label='close'>
  <span aria-hidden='true'>&times; </span>
   </button>
  </h4>";
    }

    if(empty($nombreP)){
         $errors[]="<h4 align='center' class='alert alert-danger alert-dismissible fade show text-dark'>
  <i class='icon-notification text-warning' style='font-size: 60px;' ></i> <br>
          Error el campo está vacío, Escriba un nombre de Programa
   <button type='button' class='close' value='cerrar' data-dismiss='alert' aria-label='close'>
  <span aria-hidden='true'>&times; </span>
   </button>
  </h4>";
    }

    if(empty($id_area)){
        $errors[]="<h4 align='center' class='alert alert-danger alert-dismissible fade show text-dark'>
  <i class='icon-notification text-warning' style='font-size: 60px;' ></i> <br>
          Error el campo está vacío, Escriba un nombre de área
   <button type='button' class='close' value='cerrar' data-dismiss='alert' aria-label='close'>
  <span aria-hidden='true'>&times; </span>
   </button>
  </h4>";
    }

}    

  if (count($errors) == 0) {

    $token   = generateToken();

    if (is_numeric($id_programaF)) {

 $sqlA="SELECT * FROM area WHERE id_area='$id_area'";
 $areaBD= $conectarBD->query($sqlA)->fetch_assoc()['id_area'];
    if($id_area == $areaBD){
     
        $sqlA = "INSERT INTO programas(id_programaF, nombreP, id_area, token)VALUES('$id_programaF', '$nombreP', '$id_area', '$token')";
      if ($conectarBD->query($sqlA) === TRUE) {
       echo "<script>swal('Excelente', 'El registro fue ingresado Corectamente', 'success')</script>";   
      }else{
       echo "<script>swal('Error', 'El registro no fue insertado', 'error')</script>";
        die(include '../errorAlgoSM.php');
      }
          }else{
                 $errors[]="<h4 align='center' class='alert alert-danger alert-dismissible fade show text-dark' role='alert'>
  <i class='icon-warning text-danger' style='font-size: 80px;' ></i> <br>
  Selecciona Un Area Existente
  <button type='button' class='close' value='cerrar' data-dismiss='alert' aria-label='close'>
  <span aria-hidden='true'>&times; </span>
   </button>
  </h4>";
          }
      }else{
        $errors[]="<h5 class='alert alert-danger alert-dismissible fade show text-dark'>Debe ser un valor númerico
         <button type='button' class='close' value='cerrar' data-dismiss='alert' aria-label='close'>
  <span aria-hidden='true'>&times; </span>
   </button>
        </h5>";
      }
          }
     
}
 
     ?>

<br>

  <div class="container" align="center">
    <div  style="margin-left: 30%; margin-right: 30%;">
    <?php echo resultBlock($errors); ?>
  </div>
</div>
<script type="text/javascript" src="../assets/JQuery/jquery-3.3.1.slim.min.js"></Script>
<script type="text/javascript" src="../assets/bootstrap-4.3.1-dist/js/bootstrap.min.js"></Script>
  <br><div class="container" align="center">
    <?php// if (empty($sqlA)) {  ?>

  <h1 class="font-weight-bold">Registrar Programa</h1>
  <br>
  <form method="post" action="#">
  <div class="form-group">
<label class="font-weight-bold">ID Programa</label>
<br>
<input type="number" name="id_programaF" id="id_programaF" required=""  value="<?php if(isset($_POST['id_programaF'])){ echo $_POST['id_programaF']; } ?>" placeholder="SOLO NÚMEROS" class="form-control col-3">
<br>
<label class="font-weight-bold">Programa de Formación</label>
<br>
<input type="text" name="nombreP" id="nombreP" required="" value="<?php if(isset($_POST['nombreP'])){echo $_POST['nombreP'];} ?>" placeholder="SOLO LETRAS" class="form-control col-3">
<br>  
   <?php
$sql="SELECT * FROM area ORDER BY nombreArea ASC";
if ($conectarBD->query($sql)-> num_rows > 0) {
    ?>  
      <label class="font-weight-bold">Area:</label>
      <br>                 
<select class="form-control col-3" name="id_area" id="id_area" >  
        <option value="">Seleccione un Área</option>
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
<div>
<button type="reset" title="Limpiar" class="btn" >
    <i class="icon-loop2 text-secondary" style="font-size: 35px;"></i> 
  </button>
  <button type="button" class="btn" title="Cancelar"  onclick="window.location.href='./listarProgramas.php'">
      <i class="icon-cancel text-danger" style="font-size: 50px;"> </i>
  </button>
  <button type="submit"  class="btn font-weight-bold "  title="Registrar">
  <i class="icon-checkmark1 text-success" style="font-size: 50px;"></i>
  </button>
 </div> 
  </form>
  </div>
<?php //} ?>
<script type="text/javascript" src="../Assets/Jquery/jQuery_v3.4.1.js"></script>
<script type="text/javascript" src="../Assets/bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>
<script type="text/javascript">
document.getElementById("id_programa").focus();
</script>
</body>
</html>