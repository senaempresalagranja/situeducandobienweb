
  
<?php
session_start();
require '../conecion.php';
require '../Assets/funcion.php';


$tipoUsuario = $_SESSION['tipo'];
$idUser = $_SESSION['id'];
if(empty($_SESSION['tipo'])) {
    echo "<script>window.location.href='../index.php'; </script>";  
}
  if (isset($_POST['tokenBD'])) {
      if (!empty($_POST['tokenBD'])) {
           $token=$_POST['tokenBD'];

      $sqlP="SELECT * FROM programas WHERE token ='$token'";
      $estado=$conectarBD->query($sqlP)->fetch_assoc()['estado'];

      switch ($estado) {
      	case '1':
      		$estado=0;
      		break;
      		case '0':
      			$estado=1;
      			break;
      	
         }  
         $sql = "UPDATE programas SET estado = '$estado' WHERE token='$token'";
         	if ($conectarBD->query($sql) == TRUE) {
         		  echo "<script>window.location.href='./listarProgramas.php'; </script>";  
         	}else{
         		 echo "Cambiaste Algo en la Direccion URL ";
         	}
    }else{
    	$errors[]='<h1 class="text-dark"> Oh! algo salio mal <span class="icon-notification text-warning"></span> </h1> ';
    }  
}

if(isset($_GET['token'])){
  if(empty($_GET['token'])){
    echo "<script>window.location.href='./listarProgramas.php'; </script>";  
}else{
	$tokenR=$_REQUEST['token'];
	$sqlF = "SELECT * FROM programas WHERE token = '$tokenR'";
	if ($conectarBD->query($sqlF)->num_rows > 0) {
		$id_programa = $conectarBD->query($sqlF)->fetch_assoc()['id_programaF'];
		$nombre_programa = $conectarBD->query($sqlF)->fetch_assoc()['nombreP'];
		$area = $conectarBD->query($sqlF)->fetch_assoc()['id_area'];
    	$estadoBD= $conectarBD->query($sqlF)->fetch_assoc()['estado'];
    	$tokenBD= $conectarBD->query($sqlF)->fetch_assoc()['token'];
	   }
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
	<title>Eliminar Programa</title>	<link rel="icon" type="image/png" sizes="16x16" href="../situ.png">
	<link rel="stylesheet" type="text/css" href="../estilos.css">
  <link rel="stylesheet" type="text/css" href="../Assets/fonts/style.css">
  <link rel="stylesheet" type="text/css" href="../Assets/bootstrap-4.3.1-dist/css/bootstrap.min.css">
</head>
<body class=" bg-white">
<?php require '../navegacion.php';?>

<?php 
if (isset($tokenBD)){
  if (!empty($tokenBD)){

?>
<div align="center" class="form bg-transparent border-transparent">
	<br>
<h2 class="font-weight-bold">¿Está Seguro de <?php if ($estadoBD==1){ echo 'Desactivar'; }else{ echo 'Activar'; } ?> El Siguiente Programa? </h2>
  <br>
  <p class="font-weight-bold">ID Programa: <span style="color: purple"><?php echo $id_programa; ?></span></p>
  <p class="font-weight-bold">Programa de Formación: <span style="color: purple"><?php echo $nombre_programa; ?></span></p>
	<p class="font-weight-bold">Area: <span style="color: purple">
   
  <?php
 $sqlF= "SELECT * FROM area WHERE id_area=".$area;
       if ($conectarBD->query($sqlF)->num_rows > 0){

         foreach ($conectarBD->query($sqlF) as $fila){
          $nombreA= $fila['nombreArea'];
        }
}
    echo $nombreA;    
      ?>
  </span></p>
  <form method="post" action="#">
  	<input type="hidden" name="tokenBD" value="<?php echo $tokenBD; ?>">

  <button type="button" class="btn " title="Cancelar"  onclick="window.location.href='./listarProgramas.php'">
 <i class="icon-cancel text-danger" style="font-size: 50px;"> </i>
  </button>
  <button type="submit" class="btn font-weight-bold" title="<?php if ($estadoBD==1){echo "Desactivar";}else{ echo "Activar";} ?> Programa"><span class=" icon-checkmark1 text-success" style="font-size: 50px;"></span></button>
  </form>
</div>

<?php
}
}else{

echo "<div class='container'><br>";
die(include '../errorAlgoSM.php');
echo "</div>";
}

 ?>

<script type="text/javascript" src="../Assets/Jquery/jQuery_v3.4.1.js"></script>
<script type="text/javascript" src="../Assets/bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>
</body>
</html>