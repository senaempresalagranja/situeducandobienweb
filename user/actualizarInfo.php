<?php
session_start();
require_once '../conecion.php';
require '../Assets/funcion.php';


$idUser=$_SESSION['id'];

$tipoUsuario = $_SESSION['tipo'];

    if (empty($_SESSION['tipo'])) {

    echo "<script>window.location.href='../index.php'; </script>";  

    } 





$sql = "SELECT * from usuarios where id = $idUser";



if($conectarBD->query($sql)-> num_rows > 0){



		$nombre = $conectarBD->query($sql)->fetch_assoc()['nombre'];

		$usuario = $conectarBD->query($sql)->fetch_assoc()['usuario'];

		$tipoUsuario = $conectarBD->query($sql)->fetch_assoc()['tipo'];

		$correo = $conectarBD->query($sql)->fetch_assoc()['email'];

		$nombre = $conectarBD->query($sql)->fetch_assoc()['nombre'];

    $clave = $conectarBD->query($sql)->fetch_assoc()['clave'];

    $token = $conectarBD->query($sql)->fetch_assoc()['token'];

    

       

}else{

    echo "<script>window.location.href='../administrador/paginaPrincipal.php'; </script>";  

	

	}





 $errors = array();

      



       		

	

?>

<!DOCTYPE html>

<html>

<head>

  <?php

include '../navAdmi.php';



     if (!empty($_POST)) {



        $nombreUser       = $conectarBD->real_escape_string($_POST['nombre']);

        $pass_con   = $conectarBD->real_escape_string($_POST['confi']);

        $email      = $conectarBD->real_escape_string($_POST['correo']);

        



        if (!empty($nombre)) {

        if (!empty($email)) {

        if (isEmail($email)){



      if ($correo==$email) {

              $actualizar =  "UPDATE usuarios set nombre = '$nombreUser' WHERE token = '$token'";

            }else{

            $actualizar =  "UPDATE usuarios set nombre = '$nombreUser' , email= '$email' WHERE token = '$token'";

          }

        if ($clave==$pass_con) {

        if($conectarBD->query($actualizar)==true){

          $errors[]='

          <script type="text/javascript" src="../js/sweetalert.js"></script>

          <script type="text/javascript">

              swal({

                title: "Advertencia",

                text: "Información Actualizada Con Exito",

                type: "success",

                showCancelButton: true,

                confirmButtonColor: "#28A745",

                confirmButtonText: "OK",

                cancelButtonColor: "#DC3545",

                cancelButtonText: "X",

                closeOnConfirm: true,

                closeOnCancel: true

              },

              function(isConfirm){

                if (isConfirm) {

                  window.location="../administrador/paginaPrincipal.php";

                } 

              });



        </script>';

          

          }else{

           die(require'../errorAlgoSM.php');

          }

        }else{

          $errors[]='<div class="alert alert-danger text-dark font-weight-bold">Confirmacion De Contraseña Incorrecta</div>';

        }

        }else{

          $errors[]='<div class="alert alert-danger text-dark font-weight-bold">Ingrese Una Direccion De Correo Valida</div>';

        }

        }else{

          $errors[]='<div class="alert alert-danger text-dark font-weight-bold">Direccion De Correo No Puede Ir Vacia</div>';

        }



        }else{

          $errors[]='<div class="alert alert-danger text-dark font-weight-bold">El Nombre No Puede Ir Vacio</div>';

        }

          

    }









   ?>

	<title>Actualizar informacion</title>

      <link rel="icon" type="image/png" sizes="16x16" href="../situ.png">

	<link rel="stylesheet" type="text/css" href="../estilos.css">

<link rel="stylesheet" type="text/css" href="../Assets/fonts/style.css">

	<link rel="stylesheet" type="text/css" href="../Assets/bootstrap-4.3.1-dist/css/bootstrap.min.css

">

<link rel="stylesheet" type="text/css" href="../css/sweetalert.css">

</head>

<body class=" bg-white">

<?php

include '../navegacion.php';





if($conectarBD->connect_error){

    die( require '../errorAlgoSM.php');

    

    

}

?>

<br>

<form method="post" action='#' autocomplete='off'>

	<div align="center" class="container">

      <h2 class="font-weight-bold">ACTUALIZAR INFORMACION</h2>

  <br>

<div class="form-row">               

  

  <input type="hidden"   value="<?php $correo?>"  >

	

  <div class="form-group col-md-4">

		<label class="font-weight-bold">Nombre:</label>

		<input type="text" name="nombre" id="nombre" class="form-control" value="<?php if(isset($nombreUser)){echo $nombreUser;}else{echo $nombre; }?> " required="" >

  </div>



  <div class="form-group col-md-4">

		<label class="font-weight-bold">Usuario:</label>

			<input type="text" name="usuario" id="usuario" class="form-control " style="cursor: no-drop;" readonly="readonly" value="<?= $usuario ?> " required="" >

	</div>

  

    <div class="form-group col-md-4">	

		<label class="font-weight-bold">Tipo Usuario:</label>

		<input type="text"   class="form-control font-weight-bold " style="cursor: no-drop;"  readonly="readonly" value="<?= $tipoUsuario ?> "  >

  </div>

</div>

<div class="form-row">

	<div class="form-group col-md-4">	

    <label class="font-weight-bold">Email</label>

		<input type="email"   class="form-control"  name="correo" value="<?php if(isset($email)){echo $email;}else{echo $correo;} ?> " placeholder="@misena.edu.co"  required="">

  </div>

 

	<div class="form-group col-md-4"> 	

   <h5 class="font-weight-bold">Confirmar Identidad</h5>

      <div class="input-group" >

               

            <input type="password"  name="confi"  class="form-control" id="inputPassword" placeholder="Contraseña" required>

            <button type="button" class="btn btn-primary" onclick="mostrarPassword()" >

                <i class="icon-eye-blocked icon"></i>

            </button>

                

      </div>    

  </div>

</div>

	<div>

 <button type="button" class="btn " title="Cancelar"  onclick="window.location.href='../administrador/paginaPrincipal.php'">

 <i class="icon-cancel text-danger" style="font-size: 50px;"> </i>

  </button>

  

   <button type="submit" class="btn font-weight-bold" title="Actualizar"><span class=" icon-checkmark1 text-success" style="font-size: 50px;"></span>



</button>

</div>

	    </div>

	</form>

  <div style="margin-left: 350px;margin-right: 350px; color:black;">

						<?php

             echo resultBlock($errors);

							

						 ?>

</div>





<script type="text/javascript" src="../Assets/Jquery/jQuery_v3.4.1.js"></script>

<script type="text/javascript" src="../Assets/bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>

<script type="text/javascript" src="../js/sweetalert.js"></script>

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





</script>



</body>

</html>













