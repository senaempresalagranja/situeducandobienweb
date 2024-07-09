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

<!DOCTYPE html>

<html>

<head>

  <meta charset="utf-8"><style type="text/css">

        .confi{

    height: 30px;

    }

      </style>

     <?php include '../navAdmi.php';?>

  <title>Eliminar Memorando</title>

      <link rel="icon" type="image/png" sizes="16x16" href="../situ.png">

   <link rel="stylesheet" type="text/css" href="../estilos.css">

  <link rel="stylesheet" type="text/css" href="../Assets/fonts/style.css">

  <link rel="stylesheet" type="text/css" href="

  ../Assets/bootstrap-4.3.1-dist/css/bootstrap.min.css

">

</head>

<body class=" bg-white">







<?php require '../navegacion.php';







  if (isset($_POST['tokenM'])) {

  

  if (!empty($_POST['tokenM'])) {

       $tokenM= $_POST['tokenM'];

      

         $sqlD ="UPDATE memorandos SET estado = 0 WHERE token='$tokenM'";

         if ($conectarBD->query($sqlD) ===TRUE){



      

      }else{

          die(require '../errorAlgoSM.php');

         }

  }else{

   

    $errors[]='<h1 class="text-dark"> Oh! algo salio mal <span class="icon-notification text-warning"></span> </h1> ';

  }

}

?>  



<?php

$errors= array();



    

      if (!empty($_GET['token'])) {

       $token = $_GET['token'];

        $sql="SELECT * FROM memorandos WHERE token ='$token' AND estado = 1";

if (!empty($sql)){



 if($conectarBD->query($sql)->num_rows > 0){



  

 

      $codigoTurno=$conectarBD->query($sql)->fetch_assoc()['codigoTurno'];

      $id_memorando=$conectarBD->query($sql)->fetch_assoc()['id_memorando'];

      $tokenBD=$conectarBD->query($sql)->fetch_assoc()['token'];

     





       

$sqlA="SELECT * FROM turnorutinario WHERE codigoTurno ='$codigoTurno'";





if($conectarBD->query($sqlA)->num_rows > 0){



      $documento=$conectarBD->query($sqlA)->fetch_assoc()['id_aprendiz'];



      }



$sqlN="SELECT * FROM aprendiz WHERE id_aprendiz ='$documento'";





if($conectarBD->query($sqlN)->num_rows > 0){



      $nombres=$conectarBD->query($sqlN)->fetch_assoc()['nombres'];

      $apellidos=$conectarBD->query($sqlN)->fetch_assoc()['apellidos'];



      }



   }

       }else{

            $errors[]='<h1 class="text-dark"> Oh! algo salio mal <span class="icon-notification text-warning"></span> </h1> ';

       

        }

        

        if (isset($tokenBD)) {

          

        if ($_GET['token']==$tokenBD) {

          

      

        $token=  $_GET['token'];



?>

<br>

<div align="center">

	<h2>¿ Está Seguro de Eliminar El Siguiente Memorando ?</h2>

	<p class="font-weight-bold">Codigo Memorando: <span class="text-primary"><?php if (isset($id_memorando)){echo $id_memorando; 

  }

    ?></span></p>

  

	<p class="font-weight-bold">Codigo Turno: <span class="text-primary"><?php

  if (isset($codigoTurno)){

   echo $codigoTurno; }?></span></p>

	<p class="font-weight-bold">Aprendiz: <span class="text-primary"><?php 

  if (isset($nombres,$apellidos)){

  echo $nombres." ". $apellidos;} ?></span></p>

	<form method="post" action="#">

		<input type="hidden" name="tokenM" value="<?php echo $token; ?>">

  <button type="button" class="btn " title="Cancelar Eliminar"  onclick="window.location.href='./listarMemorandos.php'">

 <i class="icon-cancel text-danger" style="font-size: 50px;"> </i>

  </button>

  

   <button type="submit" class="btn font-weight-bold "  title="Aceptar"><span class=" icon-checkmark1 text-success" style="font-size: 50px;"></span></button>



</div>

<?php 

   }else{

        $errors[]= "<h1 class='text-dark'>Cambiaste Algo en la Pagina</h1>";

      }

      

    }else{

       $errors[]="<h1 class='font-weight-bold'>El Memorando Ya Hasido Eliminado</h1><a class='btn btn-warning font-weight-bold text-light' href='listarMemorandos.php'>Volver</a>";

      }

  }else{

    die(require '../errorAlgoSM.php');

  }



?>

<div style="margin-top: 60px; margin-right: 400px; margin-left:400px;">

<?php resultBlock($errors);



?>

</div>

<script type="text/javascript" src="../Assets/Jquery/jQuery_v3.4.1.js"></script>

<script type="text/javascript" src="../Assets/bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>



</body>    