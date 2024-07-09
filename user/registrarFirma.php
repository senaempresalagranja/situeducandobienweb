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

        if (isset($_POST['quienFirma'])) {

          if (isset($_POST['documento'])) {

            if (isset($_POST['cargoQF'])) {

              if (isset($_FILES['foto']['tmp_name'])) {

            

              

        $quienFirma   = $conectarBD->real_escape_string($_POST['quienFirma']);

        $documento  = $conectarBD->real_escape_string($_POST['documento']);

        $cargoQF   = $conectarBD->real_escape_string($_POST['cargoQF']);

        

        $fotoName = $_FILES['foto']['name'];

        $fotoData = mysqli_real_escape_string($conectarBD, file_get_contents($_FILES['foto']['tmp_name']));

        $fotoType = $_FILES['foto']['type'];



        if(!is_dir('../Assets/img/')){

          mkdir('../Assets/img/');



        }else{



        }



        if($fotoName && copy($_FILES['foto']['tmp_name'], "../Assets/img/".$fotoName)){ 



        }else{



        }



 if(isNullFI($quienFirma, $documento, $cargoQF)){



  $errors[]="<h5 class='text-dark'><i class='icon-warning text-warning' style='font-size: 60px;' ></i><br>Debe llenar Todos los Campos</h5>";

  }

  }}}}



         if (!empty($_POST['documento'])) {

          $documento=$_POST['documento'];

          if (is_numeric($documento)) {

              $quienFirma=$_POST['quienFirma'];

   if (!empty($_POST['quienFirma'])) {

      $cargoQF=$_POST['cargoQF'];

    if (!empty($_POST['cargoQF'])) {

      

       

      $token=md5($quienFirma. '+' .$documento. '+' .$cargoQF);



       if (substr($fotoType, 0, 5) == "image" ) {

        

         $fotoUrl = 'http://'.$_SERVER["SERVER_NAME"].'/Situ-v-2-0/Assets/img/'.$fotoName;





        $sql="INSERT INTO firma (quienFirma, documento, cargoQF, fotoName, fotoData, token, fotoUrl) values('$quienFirma', '$documento', '$cargoQF', '$fotoName', '$fotoData', '$token', '$fotoUrl')";

       if($conectarBD->query($sql) === TRUE){ 

          $errors[]='

       <div align="center" >

       <i class="icon-checkmark1 text-success" style="font-size: 40px"></i><br><h5 class="font-weight-bold  text-dark " align="center" >Firma Creada</h5><br>

       <a class="btn btn-success font-weight-bold" href="registrarFirma.php">Registrar Nueva Firma</a>

       <form action="#" method="post">

        <input type="hidden" name="id" value="'.$documento.'">

        <button type="submit" name="ver" class="btn btn-warning font-weight-bold text-light">ver Firma creada</button></form>

     </div>';



}else{

  $errors[]="<h5>Se produjo un error</h5>";

}

}else{ $errors[]="<h5>Debes insertar una imagen</h5>";



}

}else{$errors[]="<h5 class='text-dark'>Debe llenar el campo Cargo de quien firma</h5>";





}

}else{$errors[]="<h5 class='text-dark'>Debe llenar el campo Nombre de quien firma</h5>";



}

}else{

   $errors[]="<h5 class='text-dark'>El campo documento es numerico</h5>";

}

}else{

  $errors[]="<h5 class='text-dark'>Debe llenar el campo documento</h5>";

}

}



?>

<!DOCTYPE html>

<html>

<head>

  <title>Registrar Firma</title>

      <link rel="icon" type="image/png" sizes="16x16" href="../situ.png">

  <link rel="stylesheet" type="text/css" href="../estilos.css">

  <link rel="stylesheet" type="text/css" href="../Assets/bootstrap-4.3.1-dist/css/bootstrap.min.css">

</head>

<body class=" bg-white">

<?php include '../navAdmi.php';?>

<link rel="stylesheet" type="text/css" href="../estilos.css">

  <link rel="stylesheet" type="text/css" href="../Assets/fonts/style.css">

  <link rel="stylesheet" type="text/css" href="../Assets/bootstrap-4.3.1-dist/css/bootstrap.min.css">

</head>

<body class=" bg-light"> 



  <?php require '../navegacion.php'; 

$sqlFBD="SELECT COUNT(*) AS totalRegistros FROM firma WHERE estado = 1";

 if ($conectarBD->query($sqlFBD)->num_rows >0) {

  $cant=$conectarBD->query($sqlFBD)->fetch_assoc()['totalRegistros'];

  

   

 if ($cant==2) {

  die("<div ><div align='center' style='margin-top:60px;'><h2  class='font-weight-bold'>Ya se encuentran dos firmas activas <br>

    Debes desactivar una firma para activar otra.<br><span class='icon-warning' font-size:100px;></span></h2><div align='center'style='margin-top:30px;'>



  <a  class='btn btn-warning' href='listarFirmas.php' title='Listar firmas' ><i icon-warning></i>Aceptar</a>

  </div></div><div>");



  } 

  

 }

?>

<div class="container" align="center">

    <div  style="margin-left: 30%; margin-right: 30%;">

    <?php echo resultBlock($errors);?>

  </div>

</div>

<link rel="stylesheet" type="text/css" href="../estilos.css">

  <link rel="stylesheet" type="text/css" href="../Assets/fonts/style.css">

  <link rel="stylesheet" type="text/css" href="../Assets/bootstrap-4.3.1-dist/css/bootstrap.min.css">

</head>

<body class=" bg-light">



<script type="text/javascript" src="../assets/JQuery/jquery-3.3.1.slim.min.js"></Script>

<script type="text/javascript" src="../assets/bootstrap-4.3.1-dist/js/bootstrap.min.js"></Script>





<br>

    <div align="center" class="container">

      <div style="margin-left: 100px; margin-right: 100px;">

         

  

  </div>  

        <h1 class="font-weight-bold">Registrar Firma</h1>

       <br>

    <div class="form-group">

    

                    <form method="post" action="#" enctype="multipart/form-data" >



    <div class="form-row">

    <div class="form-group col-md-4"> 

    <label  class="font-weight-bold">Quién firma:</label>

    <br>

     <input type="text"  name="quienFirma" id="quienFirma" required="required" class="form-control " placeholder="Mariley" >

   </div>

     <br>





     <div class="form-group col-md-4">             

    <label  class="font-weight-bold">N°  Documento:</label>

    <br>

    <input type="number" name="documento" id="documento" required="required" class="form-control" placeholder="10063633982">

  </div>

    <br>

     

    <div class="form-group col-md-4"> 

     <label class="font-weight-bold">Cargo de quien firma</label>

     <input type="text"  name="cargoQF" id="cargoQF" required="required" class="form-control" >

     </div>

      </div>

      <br>

      <div>

       <label  class="font-weight-bold">Firma:</label>

       <input type="file" name="foto" >

   </div>

     <br>

     </div>

     

<button type="reset" title="Limpiar Registro" class="btn" >

    <i class="icon-loop2 text-secondary" style="font-size: 35px;"></i> 

  </button>





  <button type="button" class="btn" title="Cancelar Registro"  onclick="window.location.href='./listarFirmas.php'">

      <i class="icon-cancel text-danger" style="font-size: 50px;"> </i>

  </button>

  



  <button type="submit"  class="btn font-weight-bold "  title="Registrar Firma">

  <i class="icon-checkmark1 text-success" style="font-size: 50px;"></i>

  </button>

 </div>   

                    </form>

 </div>

</div>



<script type="text/javascript" src="../Assets/Jquery/jQuery_v3.4.1.js"></script>

<script type="text/javascript" src="../Assets/bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>

<script type="text/javascript">



  document.getElementById("documento").focus();

  </script>

</body>

</html>

