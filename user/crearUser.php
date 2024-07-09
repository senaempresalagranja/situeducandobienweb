<?php
session_start();
require '../conecion.php';
require '../Assets/funcion.php';
$idUser=$_SESSION['id'];
$tipoUsuario = $_SESSION['tipo'];

if(empty($_SESSION['tipo'])) {
  echo "<script>window.location.href='../index.php'; </script>";  
} 

if ($tipoUsuario !='administrador') {  
            echo "<script>window.location.href='../administrador/paginaPrincipal.php'; </script>";  
}
?>

<html>

	<head>

<?php 

include '../navAdmi.php';

?>		

		<title>Registrar Usuario</title>

		    <link rel="icon" type="image/png" sizes="16x16" href="../situ.png">

		 <link rel="stylesheet" type="text/css" href="../estilos.css">

		  <link rel="stylesheet" type="text/css" href="../Assets/fonts/style.css">

			  <link rel="stylesheet" type="text/css" href="

			  ../Assets/bootstrap-4.3.1-dist/css/bootstrap.min.css

			">

		

	</head>

	

	<body class="bg-white">

<?php 

include '../navegacion.php';

?>		

<?php 



  $errors = array();

       if (!empty($_POST)) {



       	$nombre   		= $conectarBD->real_escape_string($_POST['nombre']);

       	$user  		= $conectarBD->real_escape_string($_POST['usuario']);

       	$pass 		= $conectarBD->real_escape_string($_POST['password']);

       	$pass_con   = $conectarBD->real_escape_string($_POST['con_password']);

       	$email 			= $conectarBD->real_escape_string($_POST['email']);

       	$tipoUser		= $conectarBD->real_escape_string($_POST['tipoUser']);

  



       	

       	if (isNull($nombre, $user, $pass, $pass_con, $email)) {

       		$errors[]="<div class='alert alert-danger'><h5 class='text-dark font-weight-bold'>Debe llenar Todos los Campos</h5></div>";

       	}

     if (!empty($nombre)) {



       	if (!empty($email)) {

       	if (isEmail($email)) {

       		if(preg_match('/^([a-z0-9_\.-]+)@misena.edu\.co$/', $email) ){

				if (!emailExiste($email)){

					if (!empty($pass)){

					if (!empty($pass_con)){

					if (validaPassword($pass, $pass_con)) {

      		 			if (!usuarioExiste($user)){

      		 				if (!empty($tipoUser)){

                    $password= sha1(sha1($pass)); 

       							$token   = generateToken();

      		 						switch ($tipoUser) {

      		 							case 'senaEmpresa':

      		 								$tipoUser ="senaEmpresa";

      		 									$registro = "INSERT INTO usuarios ( nombre, usuario, clave , tipo, email, token)VALUES ( '$nombre', '$user' ,'$password' ,'$tipoUser','$email','$token' )";

      		 									if($conectarBD->query($registro)==TRUE){

														die( "<br><div align='center'  class='alert alert-success'  style='margin-right: 350px; margin-left: 350px; margin-top:40px;'><span class='icon-checkmark1 text-success' style='font-size: 50px;'></span>

															<br>

															<h5 class='text-dark font-weight-bold'>Usuario Ha sido Creado Con Exito</h5><br>

															<a class='btn btn-warning font-weight-bold' href='listaUsuarios.php '>lista de Usuarios</a></div>");

									       		}else{

									       			$errors[]="<div class='alert alert-danger'><h5 class='text-dark font-weight-bold'>Error al Crear EL Usuario</h5></div>";

									       		}	

      		 								break;

      		 							case 'administrador':

      		 								$tipoUser= "administrador";

      		 									$registro = "INSERT INTO usuarios ( nombre, usuario, clave , tipo, email, token)VALUES ( '$nombre', '$user' ,'$password' ,'$tipoUser','$email','$token' )";

      		 									if($conectarBD->query($registro)==TRUE){

														die( "<br><div align='center'  class='alert alert-success'  style='margin-right: 350px; margin-left: 350px; margin-top:40px;'><span class='icon-checkmark1 text-success' style='font-size: 50px;'></span>

															<br>

															<h5 class='text-dark font-weight-bold'>Usuario Ha sido Creado Con Exito</h5><a class='btn btn-warning' href='ListaUsuarios'></div>");

									       		}else{

									       			$errors[]="<div class='alert alert-danger'><h5 class='text-dark font-weight-bold'>Error al Crear EL Usuario</h5></div>";

									       		}	

      		 								break;

      		 							default:

      		 								$errors[]="<div class='alert alert-danger'><h5 class='text-dark font-weight-bold'>El Tipo de Usuario que Estas Intentando Usar No Existe</h5></div>";

      		 								break;

      		 						}

      		 					



       		



       	



       		

       									}else{

       										$errors[]="<div class='alert alert-danger'><h5 class='text-dark font-weight-bold'>Seleccione Un Tipo de Usuario</h5></div>";

       									}

      				 				}else{

						       		$errors[]="<div class='alert alert-danger'><h5 class='text-dark font-weight-bold'>El Usuario ".$user ." Ya existe </h5></div>";

							       	}

						       	}else{

       							$errors[]="<div class='alert alert-danger'><h5 class='text-dark font-weight-bold'>Las Contraseñas no Coinciden</h5></div>";

       							}

       							}else{

       								$errors[]="<div class='alert alert-danger'><h5 class='text-dark font-weight-bold'>Debes Llenar El Campo de Confirmacion de Contraseña</h5></div>";

       							}

       							}else{

       								$errors[]="<div class='alert alert-danger'><h5 class='text-dark font-weight-bold'>Debes llenar El campo de Contraseña</h5></div>";

       							}

       						}else{

							$errors[]="<div class='alert alert-danger'><h5 class='text-dark font-weight-bold'>El Correo <span style='color: cyan;'>". $email."</span> Ya existe </h5></div>";

							}

       					}else{

						$errors[]="<div class='alert alert-danger'><h5 class='text-dark font-weight-bold'>Correo No es Dominio @misena.edu.co Inválido <span style='color: teal;'>".$email."</span></h5></div>";

						}

			       	}else{

       				$errors[]="<div class='alert alert-danger'><h5 class='text-dark font-weight-bold'>Debe Llenar el Campo Email con un Correo Valido</h5></div>";

       				}

       				}else{

       					$errors[]="<div class='alert alert-danger'><h5 class='text-dark font-weight-bold'>El Campo Email No Puede ir vacio</h5></div>";

       				}

       			}else{

    			 	$errors[]="<div class='alert alert-danger'><h5 class='text-dark font-weight-bold'>El Nombre del Usuario No  Puede Ir vacio</h5></div>";

    			 }

       		}













?>

		<br><br>

			<div  style="margin-right: 350px; margin-left: 350px; ">

					<?php

					 echo resultBlock($errors);

					 if (isset($errors)) {

				

					 

					 	

						 ?>

			</div>

<div  class="container font-weight-bold ">

	<div align="center">

		<h2 class="font-weight-bold" ><span  class=" text-dark "> Registrar Usuario </span> </h2>

	

	<br>

		<form id="signupform" class="form-vertical" role="form" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" autocomplete="off">

	  <div class="form-row" >

		    <div class="form-group col-md-4 text-dark ">

		      <label for="inputEmail4">Nombres:</label>

		      <input type="text" name="nombre" maxlength="40" minlength="10" autofocus="" class="form-control" id="nombre" required="" value="<?php if(isset($nombre)) echo $nombre; ?>"  placeholder="Nombre">

		    </div>

		    <div class="form-group col-md-4">

		      <label for="inputPassword4">Usuario:</label>

		      <input type="text" name="usuario" maxlength="15" minlength="10"  class="form-control" id="inputPassword4" required="" value="<?php if(isset($user)) echo $user; ?>"   placeholder="Usuario">

		    </div>

		     <div class="form-group col-md-4">

		      <label for="inputPassword4">Tipo Usuario:</label>

		      <select name="tipoUser" id="tipoUser" class="form-control " required=""  >						  <option value="senaEmpresa">SENA Empresa</option>

				<option value="administrador">Administrador</option>

				</select>

		    </div>

  		</div>

  <div class="form-row">

   		<div class="form-group col-md-4">

						<label for="usuario" class="font-weight-bold text-dark"> Contraseña</label>

				<div class="input-group-append" >

                     <input type="password"  name="password"  class="form-control" id="inputPassword" placeholder="Contraseña" required>

                    	<button type="button" class="btn btn-primary" onclick="mostrarPassword()" >

                    	 <i class="icon-eye-blocked icon"></i>

                  	 	</button>

                </div>

		</div>

						

							<div class="form-group col-md-4">

								<label for="con_password" class="font-weight-bold text-dark ">Confirmar Contraseña</label>

								

			<div class="input-group-append">

              <input type="password"  name="con_password"  class="form-control" id="inputPassword2" placeholder="Contraseña" required>

               	<button type="button" class="btn btn-primary" onclick="mostrarPassword2()" >

                  	 <i class="icon-eye-blocked ico"></i>

                	 	</button>

                </div>

             </div>   



		  <div class="form-group col-md-4  ">

		      <label for="inputEmail4">Email:</label>

		      <input type="email" class="form-control" name="email" minlength="20" autocomplete="@misena.edu.co" id="inputEmail4" value="<?php if(isset($email)) echo $email; ?>" required=""  placeholder="@misena.edu.co">

		    </div>

</div>

</div>

<br>

<div align="center"> 



  <button type="reset" title="Limpiar Registro" class="btn" >

    <i class="icon-loop2 text-secondary" style="font-size: 35px;"></i> 

  </button>



	<button type="button" class="btn" title="Cancelar Registro"  onclick="window.location.href='./listaUsuarios.php'">

		  <i class="icon-cancel text-danger" style="font-size: 50px;"> </i>

	</button>

	



  <button type="submit"  class="btn font-weight-bold "  title="Registrar Usuario">

  <i class="icon-checkmark1 text-success" style="font-size: 50px;"></i>

  </button>

 </div> 

							

							

						

</form>



</div>

<br>

<?php  }

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