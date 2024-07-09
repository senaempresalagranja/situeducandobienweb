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

  <title>Listar Firmas</title>

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

  <div  style="margin-top: 2px; margin-left: 100px;">

    <br>

 <a href="registrarFirma.php" title="Nueva Firma" class="btn btn-success"><span class="icon-plus1"></span>firmas</a><div style="margin-left: 110px;">







</div>

</div>

  <h1 align="center" class="font-weight-bold" style="margin-top: -3%;">  Listar Firmas </h1>

   

       

        </form></h1>

   </div>                

<br><br>



<form name="formulario" method="post" action="editarFirma.php"   enctype="multipart/form-data">



<?php        





if($conectarBD->connect_error ){

    

    die("conexion fallida".$connetionBD->conect_error);



  }

   

          $registros="SELECT COUNT(*) AS totalRegistros FROM firma WHERE estado = 1";

          if( $conectarBD->query($registros)->num_rows > 0){



           foreach ($conectarBD->query($registros) as $value){



          $totalRegistros=$value['totalRegistros'];

          $canPagina= 5;



          if (empty($_GET['pagina'])) {

            $pagina= 1;

          }else{

            $pagina=$_GET['pagina'];

          }

          $desde=($pagina-1)*$canPagina;



          $totalPaginas=ceil($totalRegistros/$canPagina);



        }}

       if ($idUser==1) {

 $sql = "SELECT * FROM firma LIMIT $desde,$canPagina";

}else{

  $sql = "SELECT * FROM firma where estado = 1 LIMIT $desde,$canPagina";

}



?>

<div class="container"  >

<table class='table table-striped table-light'>

<tr  align='center' class='bg-primary'>

<th>Quien Firma</th>

<th>Documento</th>

<th>Cargo</th>

<th>Firma</th>

 <?php if ($idUser==1) { ?>

    <th>Estado</th>

    <?php } ?>

<th>Acciones</th>





</tr>



<?php





if($conectarBD->query($sql)->num_rows > 0 ){

    

foreach ($conectarBD->query($sql) as $value){

?>

  

<tr align='center' class='font-weight-bold' scope='row'>

  <td><?php echo $value['quienFirma'];?></td>   

  <td><?php echo $value['documento'];?></td>

  <td><?php echo $value['cargoQF'];?></td>

  <td>

     <img src="<?= $value['fotoUrl'] ?>"style="width: 150px;"> 

   

  </td>

     <?php if ($idUser==1) { ?>

  <td>

  <?php

    switch ($value['estado']) {

      case '1':

        $value['estado']="Activo";

        ?>

        <span class="text-success"><?php echo $value['estado'];?></span>

        <?php break;

      

        case '0':

        $value['estado']="Inactivo";

         ?>

        <span class="text-danger"><?php echo $value['estado'];?></span>

        <?php

        break;

    }

  ?>

   </td>  

   <?php } ?> 



    <?





    ?> 

    <td align='center'>

 <div class='btn-group' role='group'>



  <a class='btn btn-secondary' href ='./editarFirma.php?token=<?php echo $value["token"];?>'title="Editar"><span class="icon-edit"></span></a>

   <?php if ($tipoUsuario=='administrador') {

   if ($idUser==1) {

         if ($value['estado']=='Activo') {

           ?>

            <a  class='btn ' href ="./eliminarFirma.php?token=<?php  echo $value['token'];?>"  title="Eliminar Firma"><span class="icon-checkmark1 text-success" style="font-size: 25px;" ></span></a>

           <?php

         }else{

          ?>

           <a  class='btn' href ="./eliminarFirma.php?token=<?php echo $value['token'];?>"  title="Activar Firma"><span class="icon-cancel text-danger" style="font-size: 25px;"></span></a>

          <?php

         }

  }else{?>

     <a  class='btn btn-danger' href ="./eliminarFirma.php?token=<?php echo $value['token'];?>"   title="Eliminar Firma"><span class="icon-bin text-light" style="font-size: 20px;"></span></a>

    <?php

      }}

      ?>

    </div>   

      

    </td>

  </tr>



<?php 

            }

             

             }



           ?>



  </table>

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

