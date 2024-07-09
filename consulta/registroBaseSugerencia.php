
    <!DOCTYPE html>
<html>
<head>
<title>Registro sugerencia</title>
    <link rel="icon" type="image/png" sizes="16x16" href="../situ.png">
    
<link rel="stylesheet" type="text/css" href="../estilos.css">
<link rel="stylesheet" type="text/css" href="../Assets/fonts/style.css">
	<link rel="shortcut icon" href="./Situ.png">
<link rel="stylesheet" type="text/css" href="../Assets/bootstrap-4.3.1-dist/css/bootstrap.min.css
">
</head>

<body class="bg-white" >
<div>
<?php
include './navConsulta.php'

?>

<div align="center" class="container" style="margin-top: -5%;">
    <br>
	<h2 class="font-weight-bold"><i class="icon-checkmark1 text-success" style="font-size: 200px;"></i></h2>
 
  <?php

require_once '../conecion.php';
if ($_SERVER['REQUEST_METHOD']=='POST'){

if($conectarBD->connect_error){
    die("conexion fallida: ".$conectarBD->connect_error);
    
    
}

$idDucumento = $_POST['id_aprendiz'];
$tipoSugerencia = $_POST['tipoSugerencia'];
$comentarioS = $_POST['comentarioS'];
$correoS =$_POST['correoS'];
$token= md5($idDucumento."+".$tipoSugerencia);

$sql = "insert into sugerencias(id_aprendiz, tipoSugerencia, comentarioS, correoS,token)"
       ."values('$idDucumento', '$tipoSugerencia', '$comentarioS','$correoS','$token')";
        
            if ($conectarBD->query($sql)===TRUE){
              echo "<h1 align='center' class=' font-weight-bold'>SUGERENCIA REGISTRADA</h1>";
              

            

            }else{
                echo "Error: ".$sql."<br>".$conectarBD->error;
             
            }
            $conectarBD->close();
          }
           ?> <br>
               <div align="center">
               
               
   	       <a align="center" class="btn btn-warning font-weight-bold" href="sugerencias.php">INGRESAR NUEVA SUGERENCIA </a>
            
                </div>
</div>


</div>

<script type="text/javascript" src="../Assets/Jquery/jQuery_v3.4.1.js"></script>
<script type="text/javascript" src="../Assets/bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>
<script type="text/javascript">
	document.getElementById("idDocumento").focus();

	</script>
</body>


<footer style="margin-top: 14%">
<?php
include './footerConsulta.php';
?>
</footer>
</html>

