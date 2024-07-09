<?php
session_start();

require '../conecion.php';
require '../Assets/funcion.php';

$idUser=$_SESSION['id'];

if ($idUser != 1) {
    echo "<script>window.location.href='./listaUsuarios.php'; </script>";  
}


$tipoUsuario = $_SESSION['tipo'];

    if (empty($_SESSION['tipo'])) {
        echo "<script>window.location.href='../index.php'; </script>";  
    } 

         if ($tipoUsuario !='administrador') {  
          echo "<script>window.location.href='../administrador/paginaPrincipal.php'; </script>";  
        }

		$errors = array();

	if (!empty($_POST)) {

    if ($_POST['idUsuario']==1) {

       echo "<script>window.location.href='./listaUsuarios.php'; </script>";  

      exit;

    }

    if (isset($_POST['tokenUser'])) {

      

    

		$tokenUser = $_POST['tokenUser'];

    $sqlE = "SELECT  estado from usuarios where token = '$tokenUser'";

    $estadoBD = $conectarBD->query($sqlE)->fetch_assoc()['estado'];

    switch ($estadoBD) {

      case '1':

        $query = "UPDATE usuarios set estado = 0 where token='$tokenUser'";

    if ($conectarBD->query($query)==TRUE){

      $errors[] = "<div align='center'><br>

        <i class='icon-cancel text-danger' style='font-size: 70px;'></i>

        <h5 class='font-weight-bold'> Usuario Ha sido Desactivado </h5>

        <a class='btn btn-warning font-weight-bold' href='listaUsuarios.php'>Ver Usuarios</a></div>";

          

       }

        break;

           case '0':

        $query = "UPDATE usuarios set estado = 1 where token='$tokenUser'";

    if ($conectarBD->query($query)==TRUE){

      $errors[] = "<div align='center'><br>

        <i class='icon-checkmark1 text-success' style='font-size: 70px;'></i>

        <h5 class='font-weight-bold'> Usuario Ha sido Activado </h5>

        <a class='btn btn-warning font-weight-bold' href='listaUsuarios.php'>Ver Usuarios</a></div>";

          

       }

        break;

      

      

    }

    

	}

}

if (empty($_REQUEST['id'])||$_REQUEST['id']==1) {

	

	  echo "<script>window.location.href='./listaUsuarios.php'; </script>";  

}else{

 $token= $_REQUEST['token'];

 $idU =$_REQUEST['id'];

 

 	$sql = "SELECT * from usuarios where token = '$token'";



if($conectarBD->query($sql)-> num_rows > 0){



		$usuario = $conectarBD->query($sql)->fetch_assoc()['usuario'];

		$typeUser = $conectarBD->query($sql)->fetch_assoc()['tipo'];

		$email = $conectarBD->query($sql)->fetch_assoc()['email'];

    $estado = $conectarBD->query($sql)->fetch_assoc()['estado'];



    

       

}else{

  echo "<script>window.location.href='./listaUsuarios.php'; </script>";  

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

	<title>Eliminar Usuario</title>

      <link rel="icon" type="image/png" sizes="16x16" href="../situ.png">

   <link rel="stylesheet" type="text/css" href="../estilos.css">

  <link rel="stylesheet" type="text/css" href="../Assets/fonts/style.css">

  <link rel="stylesheet" type="text/css" href="

  ../Assets/bootstrap-4.3.1-dist/css/bootstrap.min.css

">

</head>

<body class=" bg-white">







<?php require '../navegacion.php';



  ?>

<br><?php if (isset($errors)) {

          if (!empty($errors)) {

          

 

?>

<div style="margin-right: 350px; margin-left: 350px;">

  <?php

   resultBlock($errors);

   ?>

</div>

<?php

}else{

  

?>

<div align="center" class="form bg-transparent border-transparent">

	<h2>¿ Está Seguro de <?php if ($estado!=1) { echo 'Activar';}else{ echo'Desactivar';} ?>  El Siguiente Usuario ?</h2>

	<p class="font-weight-bold">Usuario: <span class="text-primary"><?php echo $usuario ; ?></span></p>

	<p class="font-weight-bold">Tipo de Usuario: <span class="text-primary"><?php echo $typeUser ; ?></span></p>

	<p class="font-weight-bold">Email: <span class="text-primary"><?php echo $email ; ?></span></p>

	<form method="post" action="#">

		<input type="hidden" name="tokenUser" value="<?php echo $token; ?>">

    <input type="hidden" name="idUsuario" value="<?php echo $idU; ?>">

		  <button type="button" class="btn " title="Cancelar Eliminar"  onclick="window.location.href='./listaUsuarios.php'">

     <i class="icon-cancel text-danger" style="font-size: 50px;"> </i>

      </button>

      

       <button type="submit" class="btn font-weight-bold "  title="<?php if ($estado==1){echo "Desactivar";}else{ echo "Activar";} ?> Usuario"  ><span class=" icon-checkmark1 text-success" style="font-size: 50px;"></span></button>

 

</div>

<?php } } ?>



<script type="text/javascript" src="../Assets/Jquery/jQuery_v3.4.1.js"></script>

<script type="text/javascript" src="../Assets/bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>



</body>

    



 

                

       

        

            