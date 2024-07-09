
<?php 
session_start(); ?>
<!DOCTYPE html>
<html>
<head>
<title>Registro Sugerencia</title>
<link rel="icon" type="image/png" sizes="16x16" href="../situ.png">
<link rel="stylesheet" type="text/css" href="estilos.css">
<link rel="stylesheet" type="text/css" href="../Assets/bootstrap-4.3.1-dist/css/bootstrap.min.css">
</head>

<body class="bg-white" >
<nav class="navbar navbar-expand-lg navbar-light bg-dark dropdown-menu-right">
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
    <li class="nav-item">
      <a class="btn  bg-light font-weight-bold" href="./consulta/paginaConsulta.php" role="button" >
      Usuario Invitado<span class="sr-only">(current)</span></a>
      </li>
    </ul>
    <form class="form-inline my-2 my-lg-0">
       <ul class="navbar-nav mr-auto">
    <li class="nav-item">
      <a class="btn  bg-light font-weight-bold" href="https://senaempresalagranja.blogspot.com/" role="button" >
      Volver al Blog <span class="sr-only">(current)</span></a>
      </li>
</ul>
    </form>
  </div>
</nav>

<div align="center" class="container">
    <br>
	<h2>REGISTRO DE SUGERENCIAS</h2>
 
  <?php

require_once './conecion.php';
if ($_SERVER['REQUEST_METHOD']=='POST'){

if($conectarBD->connect_error){
    die("conexion fallida: ".$conectarBD->connect_error);
    
    
}

$idDucumento = $_POST['idDucumento'];
$tipoSugerencia = $_POST['tipoSugerencia'];
$comentarioS = $_POST['comentarioS'];
$correoS =$_POST['correoS'];
$token= md5($idDucumento."+".$tipoSugerencia);

$sql = "insert into sugerencias(idDucumento, tipoSugerencia, comentarioS, correoS,token)"
       ."values('$idDucumento', '$tipoSugerencia', '$comentarioS','$correoS','$token')";
        
            if ($conectarBD->query($sql)===TRUE){
              echo "<h1 align='center'>SUGERENCIA REGISTRADA</h1><br><br><h1 align='center'>CREADA EXITOSAMENTE</h1>";
              

            

            }else{
                echo "Error: ".$sql."<br>".$conectarBD->error;
             
            }
            $conectarBD->close();
          }
           ?> <br>
               <div align="center">
               
               
   	       <a align="center" class="btn btn-warning" href="sugerencias.php">INGRESAR NUEVA SUGERENCIA </a>
            
                </div>
<br><br>
<div class="clearfix ">
  <b-spinner type="grow" class="float-right "  label="Spinning"><a  href="sugerencias.php"  ><button class="btn btn-info text-nowrap" type="button" label="Floated Right">
  <span class="spinner-grow spinner-grow-sm  font-weight-bold mr-2" variant="dark" label="Spinning" ></span>
 
 Sugerencias..
</button></a></b-spinner>
</div>


<script type="text/javascript" src="../Assets/Jquery/jQuery_v3.4.1.js"></script>
<script type="text/javascript" src="../Assets/bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>
<script type="text/javascript">
	document.getElementById("idDocumento").focus();

	</script>
</body>
</html>

