<?php 
session_start();
require '../conecion.php';
require '../Assets/funcion.php';
$errors=array();

if (!empty($_POST)) {

$conNueva=$conectarBD->real_escape_string($_POST['conNueva']);

$confirmar=$conectarBD->real_escape_string($_POST['confirmar']);

$token=$_POST['token'];



		if(!empty($conNueva)){

		if(!empty($confirmar)){		



	if($conNueva == $confirmar){

		$sql="UPDATE usuarios SET clave='".sha1(sha1($confirmar))."' WHERE token='$token' AND cambioContrasena=1";

		

		if($conectarBD->query($sql) == TRUE ){

			$sqlC="UPDATE usuarios SET cambioContrasena=0 WHERE token='$token'";

			if($conectarBD->query($sqlC) == TRUE ){

			$cambio="<div class='alert alert-success container' align='center'><i class='icon icon-checkmark1 text-success' style='font-size: 80px; '></i><br><h2 class='font-weight-bold text-dark'>Se ha Actualizado correctamente su contraseña </h2></div>";

			

		}

		}else{



			$errors[]="Error";

		}

	

	}else{

		$errors[]="<div class='alert alert-danger'> Las contraseñas no coinciden</div>";

	}



		}else{

			$errors[]="<div class='alert alert-danger'><i class='icon icon-warning text-warning' style='font-size: 80px; '></i><br><h2 class='font-weight-bold text-dark'>Campo de confirmación está vacío</h2></div>";

		}



		}else{

			$errors[]="<div class='alert alert-danger'><i class='icon icon-warning text-warning' style='font-size: 80px; '></i><br><h2 class='font-weight-bold text-dark'>Campo de contraseña vacío</h2></div>";

		}





}

?>

 <!DOCTYPE html>

<html>

<head>

<style type="text/css">

		#menu{

			background-color: #0b56a0;

			height: 55px;

			margin-left:  -10px;

			margin-top: -18px;

		}

		ul, ol{

			list-style: none;

		}

		.navi{

			margin-right: 20px;

		}

		.navi li a{

			background-color: #0b56a0;

			color: white;

			text-decoration: none;

			padding: 15px 50px;

			display: block; 

		}

		.navi li a:hover{

			background-color: #CACACA;

			color: black;

		}

		.navi > li{

			float: left;

			margin-left: 10px;

		}

		.navi li ul{

			display:none ;

			position: absolute;

			min-width: 100px;

		}

		.navi li:hover > ul{

			display: block;

		}

		.navi li ul li{

			position: relative;

		}

	</style>    						

	

	<title>Cambiar Contraseña</title>

	    <link rel="icon" type="image/png" sizes="16x16" href="../situ.png">

	<link rel="stylesheet" type="text/css" href="../Assets/fonts/style.css">

	<link rel="stylesheet" type="text/css" href="../Assets/bootstrap-4.3.1-dist/css/bootstrap.min.css">

</head>

		<body class="bg-white" >

   

<nav id="menu" class="font-weight-bold">

	<ul class="navi"> 

		<li>

			<a  href="../consulta/paginaConsulta.php" role="button" > <i class="icon-home"> </i>

			  INICIO</a>

		</li>

	

		

		<li style="margin-left: 68%;">

		<a href="../index.php" role="button"><i class="icon-user" ></i> Inicar Sesión</a>			

		</li>

	</ul> 

</nav>

<div class='container' style='margin-top:10px;'>



 <?php 

    echo "<br>". resultBlock($errors);

?>                      



</div>



<?php	



	$idUser = $_REQUEST['id'];

	$token =$_REQUEST['token'];

	$sqlCambio ="SELECT * FROM usuarios WHERE id= '$idUser'";

	if ($conectarBD->query($sqlCambio)->num_rows >0){

	 	 $id = $conectarBD->query($sqlCambio)->fetch_assoc()['id'];

	 	 $tokenBD = $conectarBD->query($sqlCambio)->fetch_assoc()['token'];

	 	 if ($idUser==$id) {

	 	 	if ($token==$tokenBD) {

	 if (empty($cambio)){

	 	 		?>

	 	 

	 	 		   



<div align="center" class="form-group mx-sm-3 mb-2">

 <form role="form" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" autocomplete="off">

	<div class="container" style="margin-top: 30px;" class="font-weight-bold">

	<input hidden="" name="token" value="<?php echo $token ?>">

		

		<h1 class="font-weight-bold">Cambia Tu Contraseña</h1>

<br>

  		<div class="form-group" >

			<label for="usuario" class="font-weight-bold text-dark">Nueva Contraseña</label>

				<div class="input-group-append"  style="margin-left: 40%;" >

                     <input type="password"  name="conNueva"  class="form-control col-md-4" id="inputPassword" placeholder="Contraseña" required>

                	<button type="button" class="btn btn-primary" onclick="mostrarPassword()" >

                  	 <i class="icon-eye-blocked icon"></i>

            	 	</button>

                </div>

		</div>



		<div class="form-group">

			<label for="con_password" class="font-weight-bold text-dark ">Confirmar Contraseña</label>

				<div class="input-group-append" style="margin-left: 40%;">

                    <input type="password"  name="confirmar"  class="form-control col-md-4" id="inputPassword2" placeholder="Contraseña" required>

	                   	<button type="button" class="btn btn-primary" onclick="mostrarPassword2()" >

                    	 <i class="icon-eye-blocked ico"></i>

                  	 	</button>

                </div>

        </div>

<br>

		<div class="container">

  <button type="reset" title="Limpiar Registro" class="btn" >

    <i class="icon-loop2 text-secondary" style="font-size: 35px;"></i> 

  </button>



  <button type="button" class="btn" title="Cancelar"  onclick="window.location.href='../index.php'">

      <i class="icon-cancel text-danger" style="font-size: 50px;"> </i>

  </button>

  

  <button type="submit" name="btnEditar" class="btn font-weight-bold "  title="Actualizar Contraseña">

          <i class="icon-checkmark1 text-success" style="font-size: 50px;"></i>

  </button>

 </div> 

		 

	</div>		

</form>

</div>

				

	<?php

	 	}else{

	 		echo $cambio;

	 	} 		

	 	 	}else{

?>

<div class="container">

<br><br>

<?php

    	die(

    		require '../errorAlgoSM.php');

    }

?>

</div>

<?php	 

	 	 }     

    }else{

    	echo "Error no se puede cambiar la contraseña ";

    }



?>



	<script type="text/javascript" src="../Assets/Jquery/jQuery_v3.4.1.js"></script>

		<script type="text/javascript" src="../Assets/bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>

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

