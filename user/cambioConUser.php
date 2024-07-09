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

<html>

	<head>



<?php include '../navAdmi.php';?>

	

		<title> Actualizar Contraseña</title>

		    <link rel="icon" type="image/png" sizes="16x16" href="../situ.png">

		<link rel="stylesheet" type="text/css" href="estilos.css">

<link rel="stylesheet" type="text/css" href="../Assets/fonts/style.css">

<link rel="stylesheet" type="text/css" href="../Assets/bootstrap-4.3.1-dist/css/bootstrap.min.css">

	</head>

	

	<body class="bg-white">

	<?php require '../navegacion.php';?>	

<?php



$busq = ("SELECT * FROM usuarios WHERE id = ".$idUser);

    if ($conectarBD->query($busq)->num_rows >0){

     $claveB = $conectarBD->query($busq)->fetch_assoc()['clave'];

     }



$errors = array();



if (!empty($_POST)) {

if(isset($_POST['clave'])){

  

  $pass=$conectarBD->real_escape_string($_POST['clave'] );

  $clave = sha1(sha1($pass));

	if ($clave == $claveB) {

	$confir="<script>swal('Excelente', 'Confirmación Correcta', 'success')</script>";

	echo $confir;



}else{

		echo "<script>swal('Error', 'En la Confirmación de la Contraseña', 'error')</script>";

		  

	}

  }

	



if (isset($_POST['confi1'])) {

	if (isset($_POST['confi2'])) {

	

    $confi1 = $conectarBD->real_escape_string( $_POST['confi1']);

    $confi2 = $conectarBD->real_escape_string( $_POST['confi2']);

  if ($confi1==$confi2) {

  

  	

  	$sql = "UPDATE usuarios SET clave ='".sha1(sha1($confi2))."'WHERE id=".$idUser;

if($conectarBD->query($sql)==TRUE){

	$actualizado="<script>swal('Excelente', 'La Contraseña Fue Actualizada con exito', 'success')</script>";

	echo $actualizado;

		   

}

  }else{

  	$error="<script>swal('Error', 'En la Confirmación de la Contraseña de Actualizar', 'error')</script>";

  	echo $error;

  }

	

 }

}





if(isset($confir)){

?>

		<div align="center" class="container">

				<br>

				<h2 class="font-weight-bold text-dark"> Actualiza Tu Contraseña</h2>

				<br>

					<div id="signupbox" style="margin-top:-10px" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">		

			<br>		

					<form id="signupform" class="form-horizontal" role="form" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" autocomplete="off">

							

   		<div class="form-group" style="">

						<label for="usuario" class="font-weight-bold text-dark">Nueva Contraseña</label>

				<div class="input-group-append" style="margin-left: 25%;">

                     <input type="password"  name="confi1" value="<?php if(isset($_POST['confi1'])){echo $confi1;} ?>" class="form-control col-md-6" id="inputPassword" placeholder="Contraseña" required>

                    	<button type="button" class="btn btn-primary" onclick="mostrarPassword()" >

                    	 <i class="icon-eye-blocked icon"></i>

                  	 	</button>

                </div>

		</div>

						

							<div class="form-group">

								<label for="con_password" class="font-weight-bold text-dark ">Confirmar Contraseña</label>

								

						<div class="input-group-append" style="margin-left: 25%;">

                     <input type="password"  name="confi2" value="<?php if(isset($_POST['confi2'])){echo $confi2;} ?>" class="form-control col-md-6" id="inputPassword2" placeholder="Contraseña" required>

                    	<button type="button" class="btn btn-primary" onclick="mostrarPassword2()" >

                    	 <i class="icon-eye-blocked ico"></i>

                  	 	</button>

                </div>				

<br>

					<div>

					 <button type="button" class="btn " title="Cancelar Eliminar"  onclick="window.location.href='../administrador/paginaPrincipal.php'">

					 <i class="icon-cancel text-danger" style="font-size: 50px;"> </i>

					  </button>

						

						 <button type="submit" class="btn font-weight-bold " title="Aceptar" ><span class=" icon-checkmark1 text-success" style="font-size: 50px;"></span>



					</button>

					</div>	

                       

							</div>

						

							</form>

				</div>

		</div>





<?php

	}

}



if(empty($confir)){



?>	





		<div align="center" class="container">



			<div class=" col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2" style="margin-top: 3%;">

<div style="margin-left: 15%; margin-right: 10%; margin-top: 4%;">

	<?php 

    echo resultBlock($errors);

	?>

</div>

				<br>

				<h2 class="font-weight-bold text-dark"> Confirma Tú Identidad</h2>

				<br>

				</div>

			<div id="signupbox" style="margin-top:-10px" class="mainbox  col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">				

					<form id="signupform" class="form-horizontal" role="form" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST"  autocomplete="off">

							

							<div style="display:none" class="alert alert-danger">

							

							</div>

  							

<br>

	<h5 class="font-weight-bold">Confirmar Contraseña</h5>

			<div class="input-group" style="margin-left: 25%;">

                <div class="input-group-append">

                     <input type="password"  name="clave"  class="form-control" id="inputPassword2" placeholder="Contraseña" required>

                    	<button type="button" class="btn btn-primary" onclick="mostrarPass()" >

                    	 <i class="icon-eye-blocked icon"></i>

                  	 	</button>

                </div>

            </div>		





<br>

<div>

 <button type="button" class="btn " title="Cancelar Eliminar"  onclick="window.location.href='../administrador/paginaPrincipal.php'">

 <i class="icon-cancel text-danger" style="font-size: 50px;"> </i>

  </button>

	

	 <button type="submit" class="btn font-weight-bold "  ><span class=" icon-checkmark1 text-success" style="font-size: 50px;"></span>



</button>

</div>

	<br><br>							

							</div>

							</div>

<?php

	}

?>							

		<script type="text/javascript" src="../Assets/Jquery/jQuery_v3.4.1.js"></script>

<script type="text/javascript" src="../Assets/bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>

<script type="text/javascript">

	document.getElementById("clave").focus();



    function mostrarPass(){

              var cambio = document.getElementById("inputPassword2");

              if(cambio.type == "password"){

                cambio.type = "text";

                $('.icon').removeClass('icon-eye-blocked').addClass('icon-eye');

              }else{

                cambio.type = "password";

                $('.icon').removeClass('icon-eye').addClass('icon-eye-blocked');

              }

            } 

    </script>



	<script type="text/javascript">

	function mostrarPassword(){

              var cambio = document.getElementById("inputPassword");

              if(cambio.type == "password"){

                cambio.type = "text";

                $('.icon').removeClass('icon-eye-blocked').addClass('icon-eye');

              }else{

                cambio.type = "password";

                $('.icon').removeClass('icon-eye').addClass('icon-eye-blocked');

              }

            } 



	function mostrarPassword2(){

              var cambio = document.getElementById("inputPassword2");

              if(cambio.type == "password"){

                cambio.type = "text";

                $('.ico').removeClass('icon-eye-blocked').addClass('icon-eye');

              }else{

                cambio.type = "password";

                $('.ico').removeClass('icon-eye').addClass('icon-eye-blocked');

              }

            }           



	</script>

	</body>

</html>													