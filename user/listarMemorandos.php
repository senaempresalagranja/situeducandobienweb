<?php
session_start();
require '../conecion.php';
require '../Assets/funcion.php';

$idUser=$_SESSION['id'];

$tipoUsuario = $_SESSION['tipo'];

    if (empty($_SESSION['tipo'])) {

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

	<title>lista de Memorandos</title>

      <link rel="icon" type="image/png" sizes="16x16" href="../situ.png">

   <link rel="stylesheet" type="text/css" href="./estilos.css">

      <link rel="stylesheet" type="text/css" href="../Assets/fonts/style.css">

          <link rel="stylesheet" type="text/css" href="

          ../Assets/bootstrap-4.3.1-dist/css/bootstrap.min.css">

</head>

<body class="bg-white">

<?php require '../navegacion.php';?>

<br>



<div id="aprendiz">

    <div class="container">

        <div class="row">

                <div style="margin-left: 20% ;">

                 <h1 class="font-weight-bold">Lista De Memorandos</h1>

                 </div>

                    <div style="margin-top: 45px;margin-left: 21%;">

           <form class="form-inline float-right" action="buscarMemorando.php" method="get" style="margin-top: -40px; margin-right: 20px;" >

          <input class="form-control mr-sm-2 border border-dark" type="text" name="busqueda" id="busqueda" placeholder="Buscar" value="<?php if(isset($busqueda))  echo $busqueda ;?>" onchange='this.form.submit()'>

          <noscript><input type="submit" value="Submit"></noscript>

        </form>

            </div>

        </div>

    </div>

  </div>

  



    <br>

<?php





if($conectarBD->connect_error){

    die( require '../errorAlgoSM.php');

    

    

}



         

          $registros="SELECT COUNT(*) AS totalRegistros FROM memorandos";

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



        }}else{

          die( require '../errorAlgoSM.php');

        }





        if ($idUser ==1) {

         

          $sql="SELECT memorandos.id_memorando, memorandos.codigoTurno, memorandos.id_aprendiz, CONCAT(aprendiz.nombres, ' ', aprendiz.apellidos) AS nombres, memorandos.numerosM, memorandos.estado, memorandos.token FROM `memorandos` INNER JOIN aprendiz ON memorandos.id_aprendiz=aprendiz.id_aprendiz WHERE memorandos.estado=1 LIMIT $desde, $canPagina";

        }else{

          

        }

?>

<div class="container">

<table class='table d table-light table-hover '>

  <tr align='center' class='bg-primary '>

    <th>ID MEMORANDO</th>

    <th>CODIGO TURNO</th>

    <th>APRENDIZ</th>

    <th>CANTIDAD MEMORANDO</th>

    <th>VER MEMORANDO</th>

     <?php



      if ($idUser == 1) {

    ?>

    <th>Estado</th>

  <?php }

    if($tipoUsuario=='administrador'){

   ?>

    <th> Acciones</th>

  <?php }?>

  </tr>

  <?php

if( $conectarBD->query($sql)->num_rows > 0){



   foreach ($conectarBD->query($sql) as $fila){

 

    ?>

      

     

  <tr  align='center' class='font-weight-bold' scope='row'>

    <td><?php echo $fila['id_memorando'] ;?></td>

    <td><?php echo $fila['codigoTurno'] ;?></td>

    <td><?php echo $fila['nombres']; ?></td>

    <td><?php echo $fila['numerosM'];?></td>

    <td><a href="./mostrarMemorando.php?codigoTurno=<?php echo $fila['codigoTurno'];?>"><span class="icon-file-pdf text-danger" style="font-size: 30px;" title="Ver Memorando"></span></a></td>

    

    <?php if ($idUser == 1) {

    ?>

    <td><?php 

    if ($tipoUsuario == 'administrador' ) {



  

    

    switch ($fila['estado']) {

      case '1':

        $fila['estado'] = 'Activo';

        break;

        case '0':

        $fila['estado'] = 'Inactivo';

        break;     

    }

    if ($fila['estado']=='Activo') {

      echo "<span class='text-primary' >".$fila['estado']."</span>";

    }else{

      echo "<span class='text-success'>".$fila['estado']."</span>";

    }

    }

    ?></td>

  <?php }?>

    <td align='center' >

      <?php if($idUser == 1){

         if ($fila['estado']=='Activo') {

        ?>

      <a class='btn ' href='./eliminarMemorando.php?token=<?php echo $fila['token'];?>' title="Anular Memorando"><span class="icon-checkmark1 text-success" style="font-size: 30px;"></span></a>

      <?php }else{?>

        <a class='btn ' href='./eliminarMemorando.php?token=<?php echo $fila['token'];?>' title="Activar Memorando"><span class="icon-cancel text-danger" style="font-size: 30px;"></span></a>

      <?php }}

         if ($tipoUsuario=='administrador') {

           if($idUser != 1){

        ?>

      <a class='btn bg-danger ' href='./eliminarMemorando.php?token=<?php echo $fila['token'];?>' title="Anular Memorando"><span class="icon-bin text-light" ></span></a>

      <?php } }

      ?>

    </td>

  </tr>





<?php    

 }

          }else {



 die( require '../errorAlgoSM.php');

}

          ?>

            </table>

          </div>

            <br>

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



            





            <br>

            <br>



<script type="text/javascript" src="../Assets/Jquery/jQuery_v3.4.1.js"></script>

<script type="text/javascript" src="../Assets/bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>

<script type="text/javascript" src="../Assets/bootstrap-4.3.1-dist/js/bootstrap.bundle.js"></script>



</body>

</html> 



 

                

       

        

            