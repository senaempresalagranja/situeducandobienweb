<?php
session_start();
require_once '../conecion.php';
require '../Assets/funcion.php';


$idUser= $_SESSION['id'];

$tipoUsuario = $_SESSION['tipo'];

if(empty($_SESSION['tipo'])){

    echo "<script>window.location.href='../index.php'; </script>";  

}

$errors=array();



if (!empty($_POST)) {



    $quienFirma = $conectarBD->real_escape_string( $_POST['quienFirma']);

   

 

    $cargoQF = $conectarBD->real_escape_string($_POST['cargoQF']);

   

 

     

     $token = $_POST['token'];



       

 if(isNullF($quienFirma, $cargoQF, )){



  $errors[]="<h5 class='text-dark'><i class='icon-warning text-warning' style='font-size: 60px;' ></i><br>Debe llenar Todos los Campos</h5>";

  }

  



        

          

      $quienFirma=$_POST['quienFirma'];

   if (!empty($_POST['quienFirma'])) {

      $cargoQF=$_POST['cargoQF'];

    if (!empty($_POST['cargoQF'])) {

 

  if(empty($_FILES['foto']['name'])){ 

 

  $sqlE = "UPDATE firma SET quienFirma='$quienFirma',cargoQF='$cargoQF' WHERE token= '$token'";

  if($conectarBD->query($sqlE) ===TRUE ){



$actualizado="<h2 style='color: black;'><i class='icon-checkmark1 text-success' style='font-size:80px;'></i><br> Actualizado Satisfactoriamente </h2><a class='btn btn-primary type='button' href='./ListarFirmas.php'>Volver </a>";

$errors[]= $actualizado;



   }else{

            

                  }  



     }else{ 

    $fotoName = $_FILES['foto']['name'];



  

   

    if(!is_dir('../Assets/img/')){

          mkdir('../Assets/img/');



        }else{

        }

        if($fotoName && copy($_FILES['foto']['tmp_name'], "../Assets/img/".$fotoName)){



        }else{  



        }

  $fotoUrl = 'http://'.$_SERVER["SERVER_NAME"].'/Situ-v-2-0/Assets/img/'.$fotoName;

$fotoType = $_FILES['foto']['type'];





    $sqlA = "UPDATE firma SET quienFirma = '".$quienFirma."', cargoQF = '".$cargoQF."', fotoName = '".$fotoName."', fotoUrl = '".$fotoUrl."' WHERE token = '".$token."'";



 if($conectarBD->query($sqlA) ===TRUE ){

 $actualizado="<h2 style='color: black;'><i class='icon-checkmark1 text-success' style='font-size:80px;'></i><br> Actualizado Satisfactoriamente </h2><a class='btn btn-primary type='button' href='./ListarFirmas.php'>Volver </a>";

$errors[]= $actualizado;

 }else{

  

}

}

    ?>  

            <?php 

 

 

                } 

              }  

            }   

 

             



if(isset($_GET['token'])){

  if(empty($_GET['token'])){



}else{



$token = $_GET['token'];



if($conectarBD->connect_error){

    

    die("conexion fallida:".$conectarBD->connect_error);

}



$sqlF = "SELECT * FROM firma WHERE token = '$token'";



if ($conectarBD->query($sqlF)-> num_rows >0){

  

  $documento = $conectarBD->query($sqlF)->fetch_assoc()['documento'];

  $quienFirma = $conectarBD->query($sqlF)->fetch_assoc()['quienFirma'];

  $cargoQF = $conectarBD->query($sqlF)->fetch_assoc()['cargoQF'];

  $fotoUrl = $conectarBD->query($sqlF)->fetch_assoc()['fotoUrl'];

  $token = $conectarBD->query($sqlF)->fetch_assoc()['token'];



      }   

    }

}

?>

<!DOCTYPE html>

<html>

<head>

  <title>Editar Firma</title>

      <link rel="icon" type="image/png" sizes="16x16" href="../situ.png">

  <link rel="stylesheet" type="text/css" href="../estilos.css">

  

<link rel="stylesheet" type="text/css" href="../Assets/fonts/style.css">



  <link rel="stylesheet" type="text/css" href="../Assets/bootstrap-4.3.1-dist/css/bootstrap.min.css

">

</head>

<body class=" bg-white">



<?php include '../navAdmi.php';?>

<body class=" bg-light">

<?php require '../navegacion.php';



?>



  <form role="form" action="#>" method="POST" autocomplete="off" enctype="multipart/form-data">

<input type="hidden"  value="<?= $token?> "  class="campos" hidden name="token" >

<input type="hidden"  value="<?= $documento?> "  class="campos" hidden="" name="documento" >

   

    <div align="center" class="container" >

<div style="margin-left: 100px; margin-right: 100px;">

<br>



    <?php



     echo '<br>'.resultBlock($errors);

?>

  <?php



if (empty($errors && $actualizado)>0){





 

?>

</div>



    <h1 class="font-weight-bold"> EDITAR FIRMA</h1>

<br>    



<div class="form-row">

   <div class="form-group col-md-4"> 

      <label  class="font-weight-bold">Documento:</label>

      <input type="text" class="form-control" value="<?=$documento ?>" readonly="readonly">

  </div> 



   <div class="form-group col-md-4"> 

      <label  class="font-weight-bold">Quien firma </label>

      <input type="text" class="form-control " value="<?=$quienFirma ?>"name="quienFirma" id="quienFirma" required="required">

  </div>



<div class="form-group col-md-4">  

    <label  class="font-weight-bold">Cargo  </label>

    <input type="text" class="form-control" value="<?=$cargoQF ?>" name="cargoQF" id="cargoQF"required="required">

  </div>



   

<div class="form-row">

<div style="margin-right: 50%;"> 

      <label class="font-weight-bold" >Firma Actual:</label>

      <div>



      <img src="<?= $fotoUrl ?>"style="width: 150px;"> 

      <div>

        <input type="file" name="foto" >



    </div>

</div>

    </div>

      

</div>

</div>

<br>

  <div class="container">

  <button type="reset" title="Limpiar Registro" class="btn" >

    <i class="icon-loop2 text-secondary" style="font-size: 35px;"></i> 

  </button>



  <button type="button" class="btn" title="Cancelar"  onclick="window.location.href='./ListarFirmas.php'">

      <i class="icon-cancel text-danger" style="font-size: 50px;"> </i>

  </button>

  

  <button type="submit" name="btnEditar" class="btn font-weight-bold "  title="Actualizar Firma">

          <i class="icon-checkmark1 text-success" style="font-size: 50px;"></i>

  </button>

 </div> 



        </form>

   <?php

 }

?>  

<script type="text/javascript" src="../Assets/Jquery/jQuery_v3.4.1.js"></script>

<script type="text/javascript" src="../Assets/bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>

 <script type="text/javascript">

     

    </script>   

</body>



</html>