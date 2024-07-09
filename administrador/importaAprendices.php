<?php
session_start();
require '../conecion.php';

require '../Assets/funcion.php';


?>

<!DOCTYPE html>

<html>

    <head>

        <?php require '../navAdmi.php'; ?>

        <title>importar Aprendiz</title>

        <link rel="icon" type="image/png" sizes="16x16" href="../situ.png">

         <meta charset="utf-8">

<link rel="stylesheet" type="text/css" href="../estilos.css">

<link rel="stylesheet" type="text/css" href="../Assets/fonts/style.css">

<link rel="stylesheet" type="text/css" href="../Assets/bootstrap-4.3.1-dist/css/bootstrap.min.css">

<link rel="stylesheet" type="text/css" href="../css/sweetalert.css">

<script type="text/javascript" src="../js/sweetalert.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

    </head>



    <body class=" bg-white">

<?php

   include '../navegacion.php';

   ?>



<h2 align="center">Importar aprendices desde un archivo de excel</h2>

<br> 

<div class="container mt-3 py-5 col-xl-4 col-md-5 col-sm-3">

<form action="importaAprendices.php" method="post" enctype="multipart/form-data">

    <div class="custom-file mb-3">

      <input type="file" class="custom-file-input" name="archivo" id="archivo">

      <label class="custom-file-label" for="customFile">Choose file</label>

      <input type="submit" name="enviar" value="Subir Archivo" id="subir" class="form-control-file" href ='#' onclick="confirmar()">

      </div>

</form>

</div>

<script>



$(".custom-file-input").on("change", function() {

  var fileName = $(this).val().split("\\").pop();

  $(this).siblings(".custom-file-label").addClass("selected").html(fileName);

});

</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

<?php 



if (isset($_POST["enviar"])){

  require_once("importarAprendices.php"); 



  $archivo = $_FILES["archivo"]["name"];

  $archivoCopiado = $_FILES["archivo"]["tmp_name"];

  $archivoGuardado = "copia_".$archivo;

 



  if(copy($archivoCopiado , $archivoGuardado)) {

    

  }else{

    echo "Hubo un error";

  }

  if (file_exists($archivoGuardado)) {

    

    $fp = fopen($archivoGuardado,"r");

    while ($datos = fgetcsv($fp , 1000, ";")) {

         

   $resultado = insertar($datos[0],$datos[1],$datos[2],$datos[3],$datos[4],$datos[5],$datos[6],$datos[7]);

   ?>

<br><br>

<div class="container" style="margin-left: 50px;">

         <table class="table table-hover table-light" style="margin-top: 30px;">

            <tr class="bg-primary text-light" align="center">

            <th>N° Documento</th>

            <th>Tipo Documento</th>

            <th>Nombres</th>

            <th>Apellidos</th>

            <th>Telefono</th>

            <th>Ficha</th>

            <th>Sexo</th>

            <th>Correo</th>

            </tr>

            <tr align='center' class='font-weight-bold' scope='row'>

 <td><?php echo $datos[0]?></td><td><?php echo $datos[1]?></td><td><?php echo $datos[2]?></td><td><?php echo $datos[3]?></td><td><?php echo $datos[4]?></td><td><?php echo $datos[5]?></td><td><?php echo $datos[6]?></td><td><?php echo $datos[7]?></td></tr>       

      



      <?php

      if ($resultado) {

         echo"<script type='text/javascript'>

Swal.fire(

  'Buena trabajo!',

  'Se han subido los datos correctamente',

  'success'

)



</script>";

      }else{

        echo "<script type='text/javascript'>

Swal.fire({

  icon: 'error',

  title: 'Oops...',

  text: 'Ha ocurrido un error al subir el archivo',

  footer: 'Ingresaste un dato duplicado o una ficha que no existe'

})

</script>";

      }

      }



  }else{

    echo "no existe";

  }

}



$idUser=$_SESSION['id'];

$tipoUsuario = $_SESSION['tipo'];

if(empty($_SESSION['tipo'])) {

    echo "<script>window.location.href='../index.php'; </script>";  

}



?>

</body>

</html>

