
  
<?php
session_start();
require_once '../conecion.php';

$tipoUsuario = $_SESSION['tipo'];
if(empty($_SESSION['tipo'])) {

  echo "<script>window.location.href='../index.php'; </script>";  
}
$errors=array();
 


if(isset($_GET['token'])){
  if(empty($_GET['token'])){
  
  echo "<script>window.location.href='./listarProgramas.php'; </script>";  
}else{
$token = $_GET['token'];

if($conectarBD->connect_error){
    die("Conexión fallida: ".$conectarBD->conect_error);
}

$sql = "SELECT * FROM programas WHERE token ='$token'";
 
if($conectarBD->query($sql)->num_rows > 0){
    
       $id_programa = $conectarBD->query($sql)->fetch_assoc()['id_programaF'];
       $nombre_programa = $conectarBD->query($sql)->fetch_assoc()['nombreP'];
       $id_area = $conectarBD->query($sql)->fetch_assoc()['id_area'];
       $sqlA="SELECT * FROM area WHERE id_area='$id_area'";
       $nombreA=$conectarBD->query($sqlA)->fetch_assoc()['nombreArea'];
       $tokenBD = $conectarBD->query($sql)->fetch_assoc()['token'];
    }
  }
}
$errors=array();
if (!empty($_POST)) {
   if (isset($_POST['id_programaF'])) {
     if (isset($_POST['nombreP'])) {
       if (isset($_POST['id_area'])) {
        $id_programaF = $conectarBD->real_escape_string($_POST['id_programaF']);
        $nombreP = $conectarBD->real_escape_string($_POST['nombreP']);
        $id_area = $conectarBD->real_escape_string($_POST['id_area']);
        $token = $conectarBD->real_escape_string($_POST['tokenBD']);

    if ($id_programaF == "" || $nombreP == "" || $id_area == "") {
      echo "<h5 class='text-dark'>Debe llenar Todos los campos</h5>";
      }elseif (is_numeric($id_programaF)) {
        $sql = "UPDATE programas SET id_programaF='$id_programa', nombreP='$nombreP', id_area='$id_area' WHERE token='$token'";
        if($conectarBD->query($sql) == TRUE ){
            header('location:./listarProgramas.php');
        }
      }else{
        echo "<h5 class='text-dark'><h2>ID PROGRAMA</h2>Debe ser un valor numérico</h5>";
        }
      }
      }
    }
  }
?>
<!DOCTYPE html>
<html>
<head>
      <?php require '../navAdmi.php'; ?>
    <title>Editar Programa</title>
   <meta charset="utf-8">    <link rel="icon" type="image/png" sizes="16x16" href="../situ.png">
   <link rel="stylesheet" type="text/css" href="../estilos.css">
  <link rel="stylesheet" type="text/css" href="../Assets/fonts/style.css">
  <link rel="stylesheet" type="text/css" href="../Assets/bootstrap-4.3.1-dist/css/bootstrap.min.css
">
</head>
<body class=" bg-white">

<?php require"../navegacion.php";?>
<br><br>

<?php

if (isset($tokenBD)){
  if (!empty($tokenBD)){

 ?>

<div align="center" class="container">
        <h1 class="font-weight-bold">EDITAR PROGRAMA</h1>
        <form  action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" autocomplete="off"x  >
        <input type="text"  value="<?= $token ?> "  class="campos" hidden="" name="tokenBD" >
            <input type="hidden" name="id" value="<?= $id ?>">
       <br>
    <div class="form-group">
<label class="font-weight-bold">ID Programa</label>
<br>
<input type="number" name="id_programaF" id="id_programaF" placeholder="SOLO NÚMEROS" class="form-control col-3" value='<?=$id_programa?>' readonly="readonly">
<br>
<label class="font-weight-bold">Programa de Formación</label>
<br>
<input type="text" name="nombreP" id="nombreP" required="" class="form-control col-3" value='<?php echo $nombre_programa?>'>
<br>  
   <?php
$sql="SELECT * FROM area ORDER BY nombreArea ASC";
if ($conectarBD->query($sql)->num_rows > 0) {
    ?>  
      <label class="font-weight-bold">Area:</label>
      <br>                  
<select class="form-control col-3" name="id_area" id="id_4area" >  
        <option value=""><?php echo $nombreA?></option> 
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
<br>
<div>
<button type="reset" title="Limpiar" class="btn" >
    <i class="icon-loop2 text-secondary" style="font-size: 35px;"></i> 
  </button>
  <button type="button" class="btn" title="Cancelar"  onclick="window.location.href='./listarProgramas.php'">
      <i class="icon-cancel text-danger" style="font-size: 50px;"> </i>
  </button>
  <button type="submit"  class="btn font-weight-bold "  title="Actualizar Programa">
  <i class="icon-checkmark1 text-success" style="font-size: 50px;"></i>
  </button>
 </div>                         
</form>
 </div> 


<script type="text/javascript" src="../Assets/Jquery/jQuery_v3.4.1.js"></script>
<script type="text/javascript" src="../Assets/bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../Assets/Js/vue.js"></script>
<script type="text/javascript" src="../Assets/sweetalert2/sweetalert2.all.min.js"></script>

<?php 
}

}else{
  
  echo "<div class='container'>";
  die(include '../errorAlgoSM.php');
  echo "</div>";
}

?>

</body>
</html>