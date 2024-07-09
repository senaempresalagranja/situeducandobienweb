
  
<?php 
session_start();
require '../conecion.php';
require '../Assets/funcion.php';



$tipoUsuario = $_SESSION['tipo'];
if(empty($_SESSION['tipo'])) {
   echo "<script>window.location.href='../index.php'; </script>";  
}

 $errors = array();
       if (!empty($_POST)) {
        if (isset($_POST['id_area'])) {
          if (isset($_POST['nombreArea'])) {
         

        $id_area    = $conectarBD->real_escape_string($_POST['id_area']);
        $nombreArea   = $conectarBD->real_escape_string($_POST['nombreArea']);
        $token=md5($id_area. '+' .$nombreArea);
      

 if(isNullAR($id_area, $nombreArea)){
  $errors[]="<h5 class='text-dark'><i class='icon-warning text-warning' style='font-size: 60px;' ></i><br>Debe llenar Todos los Campos</h5>";
        }
      }}

         if (!empty($_POST['id_area'])) {
          if (is_numeric($id_area)) {
   if (!empty($_POST['nombreArea'])) {


        $sql="INSERT INTO area ( id_area, nombreArea, token)values ('$id_area','$nombreArea','$token')";
        
         if($conectarBD->query($sql) === TRUE){ 
      $registrado='
       <div align="center" >
       <i class="icon-checkmark1 text-success" style="font-size: 40px"></i><br><h5 class="font-weight-bold  text-dark " align="center" >Area Creada</h5><br>
       <a class="btn btn-success font-weight-bold" href="registrarArea.php">Registrar Nuevo</a>
       <form action="#" method="post">
        <input type="hidden" name="id" value="'.$id_area.'">
        <button type="submit" name="ver" class="btn btn-warning font-weight-bold text-light">ver area creada</button></form>
     </div>';

}else{
  $errors[]="<h5>Se produjo un error</h5>";
}
}else{$errors[]="<h5 class='text-dark'>Debe llenar el campo Nombre Area</h5>";

}
}else{
   $errors[]="<h5 class='text-dark'>El campo id area es numerico</h5>";
}
}else{
  $errors[]="<h5 class='text-dark'>Debe llenar el campo codigo Area</h5>";
}
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Registrar Area</title>
  <link rel="icon" type="image/png" sizes="16x16" href="../situ.png">
	<link rel="stylesheet" type="text/css" href="../estilos.css">
	<link rel="stylesheet" type="text/css" href="../Assets/bootstrap-4.3.1-dist/css/bootstrap.min.css">
</head>
<body class=" bg-white">
<?php include '../navAdmi.php';?>
<link rel="stylesheet" type="text/css" href="../estilos.css">
  <link rel="stylesheet" type="text/css" href="../Assets/fonts/style.css">
  <link rel="stylesheet" type="text/css" href="../Assets/bootstrap-4.3.1-dist/css/bootstrap.min.css">
</head>


              

<body class=" bg-white">
<?php require '../navegacion.php';?>
 <?php
   if ($conectarBD->connect_error) {
    die(require '../errorAlgoSM.php');
   }
?>
<br>
<?php
if (isset($_POST['ver'])) {
  if (isset($_POST['id'])) {
    $id_areaT =$_POST['id'];

  $sqlA="SELECT * FROM area WHERE id_area='$id_areaT'";
  if ($conectarBD->query($sqlA)->num_rows > 0) {
    $id_areaTM = $conectarBD->query($sqlA)->fetch_assoc()['id_area'];
    $nombreAreaTM = $conectarBD->query($sqlA)->fetch_assoc()['nombreArea'];
    $token = $conectarBD->query($sqlA)->fetch_assoc()['token'];
    die('<div align="center" style="margin-left: 300px; margin-right:300px;"><h5>AREA CREADA</h5>
      <div align="left">

  <a  class="btn btn-success" href="registrarArea.php" title="Nueva Area" ><i class="icon-plus1"></i> Area</a>
  </div>
   <br>
  <table class="table table-striped table-light table-hover  font-weight-bold">
    <tr align="center" class="bg-primary col-3">
      <th>Codigo Area</th>
      <th>Nombre Area</th>
      <th>Acciones</th>
    </tr>
    <tr align="center">
      <td>'.  $id_areaTM. '</td>
      <td>'. $nombreAreaTM.' </td>
      <td><div class="btn-group" role="group">
            <a href="./editarArea.php?token='.$token.'"  class="btn btn-secondary" title="Editar" ><i class="icon-edit text-light"></i></a>    
            <a href="./eliminarArea.php?token='.$token.'" class="btn btn-danger" title="Eliminar"><i class="icon-bin text-light"></i></a>      
                </div>
            </td>
    </tr>
  </table>
  </div>
 ');

}
}
}

?>
<div class="container" align="center">
    <div  style="margin-left: 30%; margin-right: 30%;">
    <?php echo resultBlock($errors);?>
  </div>
</div>
<script type="text/javascript" src="../assets/JQuery/jquery-3.3.1.slim.min.js"></Script>
<script type="text/javascript" src="../assets/bootstrap-4.3.1-dist/js/bootstrap.min.js"></Script>

<br>
    <div align="center" class="container">
 
  <?php
          if (!isset($registrado)) {
          
  ?>      
        <h1 class="font-weight-bold">Registrar Area</h1>
       <br>
		<div class="form-group">
    
                    <form method="post" action="#">
  
		<label  class="font-weight-bold">Numero De Area:</label>
		<br>
     <input type="number"  name="id_area"  required="required" class="form-control col-3" placeholder="401" >
                
		<br>
                
		<label  class="font-weight-bold">Nombre Area:</label>
		<br>
		<input type="text" name="nombreArea" required="required" class="form-control col-3" placeholder="Gestion">
    		<br>
       
	<div>
<button type="reset" title="Limpiar Registro" class="btn" >
    <i class="icon-loop2 text-secondary" style="font-size: 35px;"></i> 
  </button>


  <button type="button" class="btn" title="Cancelar Registro"  onclick="window.location.href='./listarAreas.php'">
      <i class="icon-cancel text-danger" style="font-size: 50px;"> </i>
  </button>
  

  <button type="submit"  class="btn font-weight-bold "  title="Registrar Area">
  <i class="icon-checkmark1 text-success" style="font-size: 50px;"></i>
  </button>
 </div>   
                    </form>
 </div>
</div>
 <?php
      }else{
        echo $registrado;
      }
      
      ?>
<script type="text/javascript" src="../Assets/Jquery/jQuery_v3.4.1.js"></script>
<script type="text/javascript" src="../Assets/bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>
<script type="text/javascript">
	document.getElementById("id_area").focus();

	</script>
</body>
</html>









