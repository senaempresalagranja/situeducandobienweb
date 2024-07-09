<?php
session_start();

require '../conecion.php';
require '../Assets/funcion.php';



$idUser=$_SESSION['id'];
$tipoUsuario = $_SESSION['tipo'];
if(empty($_SESSION['tipo'])) {
   echo "<script>window.location.href='../index.php'; </script>";  
}

$errors=array();

  if (isset($_POST['tokenAprendiz'])) {
  
  if (!empty($_POST['tokenAprendiz'])) {
  $tokenAprendiz=$_POST['tokenAprendiz'];      

       $sqlE = "SELECT  estado from aprendiz where token = '$tokenAprendiz'";
    $estadoBD = $conectarBD->query($sqlE)->fetch_assoc()['estado'];
    switch ($estadoBD) {
      case '1':
        $query = "UPDATE aprendiz set estado = 0 where token='$tokenAprendiz'";
    if ($conectarBD->query($query)==TRUE){
     

     $eliminado = "<div align='center'><br>
        <i class='icon-cancel text-danger' style='font-size: 70px;'></i>
        <h5 class='font-weight-bold'> Aprendiz Ha sido Desactivado </h5>
        <a class='btn btn-warning font-weight-bold' href='listarAprendices.php'>Ver Aprendices</a></div>";
        $errors[]=$eliminado; 
        
       }
        break;
           case '0':
        $query = "UPDATE aprendiz set estado = 1 where token='$tokenAprendiz'";
    if ($conectarBD->query($query)==TRUE){
      $eliminado = "<div align='center'><br>
        <i class='icon-checkmark1 text-success' style='font-size: 70px;'></i>
        <h5 class='font-weight-bold'> Aprendiz Ha sido Activado </h5>
        <a class='btn btn-warning font-weight-bold' href='listarAprendices.php'>Ver Aprendices</a></div>";
            $errors[]=$eliminado;  
       }else{
?>
 <div class="container" style="margin-left: 10%, margin-right:10%; ">


<?php
    require '../errorAlgoSM.php';
         
?>
</div>
<?php
        break;
      }
      
    }
    
  }else{
     require '../errorAlgoSM.php';
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
	<title>Eliminar Aprendiz</title><link rel="icon" type="image/png" sizes="16x16" href="../situ.png">
   <link rel="stylesheet" type="text/css" href="../estilos.css">
  <link rel="stylesheet" type="text/css" href="../Assets/fonts/style.css">
  <link rel="stylesheet" type="text/css" href="
  ../Assets/bootstrap-4.3.1-dist/css/bootstrap.min.css
">
</head>
<body class=" bg-white">



<?php require '../navegacion.php';

    if (!empty($_GET['id'])) {
      if (!empty($_GET['token'])) {
       
        $sql="SELECT * FROM aprendiz WHERE id_aprendiz=".$_GET['id'];
if (!empty($sql)){

 if( $conectarBD->query($sql)->num_rows > 0){

 
      $documento=$conectarBD->query($sql)->fetch_assoc()['id_aprendiz'];
      $nombres=$conectarBD->query($sql)->fetch_assoc()['nombres'];
      $apellidos = $conectarBD->query($sql)->fetch_assoc()['apellidos'];
       $estado = $conectarBD->query($sql)->fetch_assoc()['estado'];
      $tokenBD = $conectarBD->query($sql)->fetch_assoc()['token'];

       }else{
            $errors[]='<h1 class="text-dark"> Oh! algo salio mal <span class="icon-notification text-warning"></span> </h1> ';
       
        }
        }else{
            echo "<script>window.location.href='./listarAprendices.php'; </script>";  
        }
?>

<div style="margin-right: 350px; margin-left: 350px;">
  <?php
   resultBlock($errors);
   ?>
</div>
<?php
if (empty($errors && $eliminado)>0){



        if (isset($tokenBD)) {
        if ($_GET['token']==$tokenBD) {
          
        $idA=$_GET['id'];
        $token=  $_GET['token'];

?>


<br>


<div align="center">
	<h2>¿ Está Seguro de <?php if ($estado!=1) { echo 'Activar';}else{ echo'Desactivar';} ?> El Siguiente Aprendiz ?</h2>
	<p class="font-weight-bold">Documento: <span class="text-primary"><?php if (isset($documento)){echo $documento; 
  }else{
    echo "No Existe";
  }
    ?></span></p>
  
	<p class="font-weight-bold">Nombres: <span class="text-primary"><?php
  if (isset($nombres)){
   echo $nombres; }?></span></p>
	<p class="font-weight-bold">Apellidos: <span class="text-primary"><?php 
  if (isset($apellidos)){
  echo $apellidos;} ?></span></p>
	<form method="post" action="#">
		<input type="hidden" name="tokenAprendiz" value="<?php echo $token; ?>">
    <input type="hidden" name="idA" value="<?php echo $idA; ?>">
  <button type="button" class="btn " title="Cancelar Eliminar"  onclick="window.location.href='./listarAprendices.php'">
 <i class="icon-cancel text-danger" style="font-size: 50px;"> </i>
  </button>
  
   <button type="submit" class="btn font-weight-bold "  title="<?php if ($estado==1){echo "Desactivar";}else{ echo "Activar";} ?> Aprendiz"  ><span class=" icon-checkmark1 text-success" style="font-size: 50px;"></span>
   </button>

</div>

<br><br>
<?php 
  }else{
?>
<br>
<div class="container" style="margin-left: 10%; margin-right: 10%;">
<?php      
  
       require '../errorAlgoSM.php';
      }
?>
</div>


<?php 
  }else{
?>
<br>
<div class="container" style="margin-left: 10%; margin-right: 10%;">
<?php      
  
       require '../errorAlgoSM.php';
      }
?>
</div>
<?php 
      }

  }
}
?>

<script type="text/javascript" src="../Assets/Jquery/jQuery_v3.4.1.js"></script>
<script type="text/javascript" src="../Assets/bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>

</body>    