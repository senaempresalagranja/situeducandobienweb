<?php
session_start();
require '../conecion.php';
require '../Assets/funcion.php';
$idUser=$_SESSION['id'];

$tipoUsuario = $_SESSION['tipo'];

    if (empty($_SESSION['tipo'])) {
        echo "<script>window.location.href='../index.php'; </script>";  
    } 

    if ($tipoUsuario !='administrador') {  
        echo "<script>window.location.href='../administrador/paginaPrincipal.php'; </script>";  
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

	<title>lista de Usuarios</title>

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

    <div class="container mt-5">

        <div class="row">

            <div class="col">        

                    <a class="btn btn-success font-weight-bold" href="crearUser.php" title="Nuevo Usuario" ><i class="icon-plus1"></i> Usuario</a>

                </div>

               

                <div style="margin-right:  15%;">

                 <h1 class="font-weight-bold">Lista De Usuarios</h1>

                 </div>

                    <div style="margin-top: 45px;margin-left: 70px;">

           <form class="form-inline float-right" action="buscarUsuario.php" method="get" style="margin-top: -40px; margin-right: 20px;" >

          <input class="form-control mr-sm-2 border border-dark" type="text" name="busqueda" id="busqueda" placeholder="Buscar" value="<?php if(isset($busqueda))  echo $busqueda ;?>" onchange='this.form.submit()'>

          <noscript><input type="submit" value="Submit"></noscript>

        </form>

            </div>

        </div>

    </div>

  </div>

  



    <br>

<?php





require_once '../conecion.php';



if($conectarBD->connect_error){

    die( require '../errorAlgoSM.php');

    

    

}



     

          $registros="SELECT COUNT(*) AS totalRegistros FROM usuarios";

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

          $sql = "SELECT * FROM usuarios LIMIT $desde,$canPagina";

        }else{

          $sql = "SELECT * FROM usuarios WHERE estado = 1 LIMIT $desde,$canPagina";

        }

?>

<div class="container">

<table class='table table-hover '>

  <tr align='center' class='bg-primary '>

    <th>NOMBRE</th>

    <th>USUARIO</th>

    <th>TIPO DE USUARIO</th>

    <th>EMAIL</th>

     <?php if ($idUser == 1) {

    ?>

    <th>Estado</th>

  <?php } ?>

    <th> Acciones</th>

  </tr>

  <?php

if( $conectarBD->query($sql)->num_rows > 0){



   foreach ($conectarBD->query($sql) as $fila){

 

    ?>

      

     

  <tr  align='center' class='font-weight-bold' scope='row'>

   

    <td><?php echo $fila['nombre'] ;?></td>

    <td><?php echo $fila['usuario'];?></td>

    <td><?php echo $fila['tipo'];?></td>

    <td><?php echo $fila['email'];?></td>

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



      <a class='btn ' href='./editarUsuario.php?&token=<?php echo $fila['token'];?> ' title="Editar Usuario"><span class="icon-edit text-secondary " style="font-size: 30px;"></span></a>

      <?php if($idUser == 1){

        if ($fila['id']!=1) {

          

        if ($fila['estado']=='Activo') {

        ?>

      <a class='btn ' href='./eliminarUser.php?token=<?php echo $fila['token'];?>&id=<?php echo hashPassword($fila['id']); ?>' title="Desacticar Este Usuario"><span class="icon-checkmark1 text-success" style="font-size: 30px;"></span></a>

      <?php }else{?>

        <a class='btn ' href='./eliminarUser.php?token=<?php echo $fila['token'];?>&id=<?php echo hashPassword($fila['id']); ?>' title="Activar Este Usuario"><span class="icon-cancel text-danger" style="font-size: 30px;"></span></a>

      <?php } }}?>

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

      

<script type="text/javascript" src="../Assets/Jquery/jQuery_v3.4.1.js"></script>

<script type="text/javascript" src="../Assets/bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>

<script type="text/javascript" src="../Assets/bootstrap-4.3.1-dist/js/bootstrap.bundle.js"></script>



</body>

</html> 



 

                

       

        

            