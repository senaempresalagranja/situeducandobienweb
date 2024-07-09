<?php
session_start();
require '../conecion.php';

$idUser= $_SESSION['id'];

$tipoUsuario = $_SESSION['tipo'];

      if (empty($_SESSION['tipo'])) {

         echo "<script>window.location.href='../index.php'; </script>";  

      }

?><!DOCTYPE html>

<html>

<head>

  <?php include '../navAdmi.php';?>

  <title>Listar Sugerencias</title>

      <link rel="icon" type="image/png" sizes="16x16" href="../situ.png">

<meta charset="utf-8">

<link rel="stylesheet" type="text/css" href="../estilos.css">

<link rel="stylesheet" type="text/css" href="../Assets/iconos/style.css">

<link rel="stylesheet" type="text/css" href="../Assets/bootstrap-4.3.1-dist/css/bootstrap.min.css">



</head>

<body class=" bg-white">

<?php require '../navegacion.php';?>

<br> <br>

<div>

  <h1 align="center" class="font-weight-bold" style="margin-top: -3%;">  Listar Sugerencias </h1>
<?php        

if($conectarBD->connect_error ){
  
    die("conexion fallida".$connetionBD->conect_error);
  }

  $registros="SELECT COUNT(*) AS totalRegistros FROM sugerencias";
  if( $conectarBD->query($registros)->num_rows > 0){

   foreach ($conectarBD->query($registros) as $fila){

  $totalRegistros=$fila['totalRegistros'];
  $canPagina= 5;

  if (empty($_GET['pagina'])) {
    $pagina= 1;
  }else{
    $pagina=$_GET['pagina'];
  }
  $desde=($pagina-1)*$canPagina;

  $totalPaginas=ceil($totalRegistros/$canPagina);
}}

 $sql="SELECT id, sugerencias.id_aprendiz, CONCAT(aprendiz.nombres, ' ', aprendiz.apellidos) AS nombres, tipoSugerencia, comentarioS, correoS, sugerencias.token FROM `sugerencias` LEFT JOIN aprendiz ON sugerencias.id_aprendiz=aprendiz.id_aprendiz LIMIT $desde,$canPagina";
//echo $sql;
?>

<div align="right" style="margin-top: 2px; margin-right: 125px;">
  <h5>Total Sugerencias:
<span class="text-danger font-weight-bold">
  <?php 
echo $totalRegistros;
  ?>
  </span>
</h5>
</div>

<div class="container">
<table class='table table-hover table-light'>
<tr  align='center' class='bg-primary'>
<th  scope='col'>Codigo Sugerencia</th>
<th>Aprendiz</th>
<th>Tipo Sugerencia</th>
<th>Comentario</th>
<th>Correo</th>
</tr>
<?php
if($conectarBD->query($sql)->num_rows > 0 ){
foreach ($conectarBD->query($sql) as $value){
?>

  

<tr align='center' class='font-weight-bold' scope='row'>
  <td><?php echo $value['id'];?></td> 
  <td><?php echo $value['nombres'];?></td>
  <td><?php echo $value['tipoSugerencia'];?> </td>  
   <td><?php echo $value['comentarioS'];?></td>
   <td><?php echo $value['correoS'];?></td>
</tr>

<?php 
  }           
  }
?>
  </table>

</div>

</div>

            <div class="paginador"></div>

            <nav aria-label="Page navigation example">

            <ul class="pagination justify-content-center">

              <?php 

                if ($pagina!=1) {

                

              ?>

              <li class="page-item">

                <a class="page-link font-weight-bold" href="?pagina=<?php echo 1;?>" >INICIO</a>

              </li>

              <li class="page-item">

                <a class="page-link" href="?pagina=<?php echo $pagina -1;?>" ><span class="icon-circle-left text-primary"></span></a>

              </li>

              <?php 

            }

              for ($i=1; $i <= $totalPaginas ; $i++) { 

                if ($i == $pagina) {

                  echo '<li class="page-item page-link bg-success text-light">'.$i.'</li>' ;

                }else{

               echo '<li class="page-item"><a class="page-link" href="?pagina='.$i.'">'.$i.'</a></li>';

              }}



              if ($pagina !=$totalPaginas) {

              

               ?>

              <li class="page-item">

                <a class="page-link" href="?pagina=<?php echo $pagina +1;?>"><span class="icon-circle-right text-primary"></span></a>

              </li>

              <li class="page-item">

                <a class="page-link font-weight-bold" href="?pagina=<?php echo $totalPaginas;?>">FIN</a>

              </li>

              <?php

               } 

              ?>

            </ul>

          </nav>





  </form>



<script type="text/javascript" src="../Assets/Jquery/jQuery_v3.4.1.js"></script>

<script type="text/javascript" src="../Assets/bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>

<script type="text/javascript" src="../Assets/bootstrap-4.3.1-dist/js/bootstrap.bundle.js"></script>

           

</body>

</html>

