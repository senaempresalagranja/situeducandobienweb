<?php
session_start();
require_once '../conecion.php';
require '../Assets/funcion.php';

$idUser=$_SESSION['id'];
$tipoUsuario = $_SESSION['tipo'];

if(empty($_SESSION['tipo'])) {
  echo "<script>window.location.href='../index.php'; </script>";  
} 

if ($tipoUsuario !='administrador') {  
          echo "<script>window.location.href='../administrador/paginaPrincipal.php'; </script>";  
        }

$errors=array();
?>

<!DOCTYPE html>

<html>

<head>

<?php

include '../navAdmi.php';

 ?>	

	<title>Editar Usuario</title>

	    <link rel="icon" type="image/png" sizes="16x16" href="../situ.png">

	<link rel="stylesheet" type="text/css" href="../estilos.css">

	<link rel="stylesheet" type="text/css" href="../Assets/bootstrap-4.3.1-dist/css/bootstrap.min.css">

  	<link rel="stylesheet" type="text/css" href="../Assets/fonts/style.css">

</head>

<body class=" bg-white" >

<?php

include '../navegacion.php';

 ?>



<?php 



	$token = $_REQUEST['token'];

$sql = "SELECT * FROM usuarios WHERE token = '$token'";

if($conectarBD->query($sql)-> num_rows > 0){

		$idUser = $conectarBD->query($sql)->fetch_assoc()['id'];

		$usuario = $conectarBD->query($sql)->fetch_assoc()['usuario'];

		$tipoUsuario = $conectarBD->query($sql)->fetch_assoc()['tipo'];

		$email = $conectarBD->query($sql)->fetch_assoc()['email'];

		$nombre = $conectarBD->query($sql)->fetch_assoc()['nombre'];

    

       

}else{

	die( require '../errorAlgoSM.php');



		

	}

	 ?>

<br>

<div>

	<?php 

	echo resultBlock($errors);

	?>

</div>

	<div align="center" class="container">

	<h2 class="font-weight-bold">Actualizar Usuario</h2>

	

	<br>

	 <form method="post" action='actualizarUser.php' autocomplete='off'>

<div class="form-row">

    <div class="form-goup col-md-4">             

      <input type="hidden"  value="<?= $token ?> "   name="token" >

	

		<label class="font-weight-bold">Nombres:</label>

		<br>

		<input type="text" name="nombre" id="nombre" class="form-control" value="<?= $nombre ?> " required="" >

	</div>

	<div class="form-goup col-md-4"> 

		<label class="font-weight-bold">Usuario:</label>

		<br>

		<input type="text" name="usuario" id="usuario" class="form-control" value="<?= $usuario ?> " required="" >

	</div>

	<div class="form-goup col-md-4"> 	

		<label class="font-weight-bold">Tipo Usuario:</label>

		

		<input type="text"   class="form-control font-weight-bold" readonly="readonly" value="<?= $tipoUsuario ?> "  >

	</div>

</div>



<div class="form-row">

    <div class="form-goup col-md-4"> 

		<label class="font-weight-bold">Nuevo tipo de usuario:</label>

		  <select name="tipoUser" id="tipoUser" class="form-control" required=""  >

		  <option value="senaEmpresa">SENA Empresa</option>

		  <option value="administrador">Administrador</option>

		</select>

	</div>

	<div class="form-goup col-md-4"> 

		<label class="font-weight-bold">Email</label>

		<input type="email"   class="form-control"  name="correo" value="<?= $email ?> " placeholder="@misena.edu.co"  required="">

	</div>

	<div class="form-goup col-md-4"> 

		<label class="font-weight-bold">Nueva Contraseña:</label>

		<input type="password"   class="form-control font-weight-bold" name="contraNueva" placeholder="******" required="" >

	</div>

</div>	

<br><br>	

	<div>





	<button type="button" class="btn" title="Cancelar Actualización"  onclick="window.location.href='./listaUsuarios.php'">

		  <i class="icon-cancel text-danger" style="font-size: 50px;"> </i>

	</button>

	



  <button type="submit"  class="btn font-weight-bold "  title="Actualizar Usuario">

  <i class="icon-checkmark1 text-success" style="font-size: 50px;"></i>

  </button>

 </div> 

		

	    

</div>



<?php 



		?>

<script type="text/javascript" src="../Assets/Jquery/jQuery_v3.4.1.js"></script>

<script type="text/javascript" src="../Assets/bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>





</body>

</html>













