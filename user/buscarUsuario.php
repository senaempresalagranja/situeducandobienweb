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

    $busqueda=strtolower($_REQUEST['busqueda']);

    if (empty($busqueda)){

        echo "<script>window.location.href='./listaUsuarios'; </script>";  

    }

    ?>

<!DOCTYPE html>

<html>

<head>

    <meta charset="utf-8">
    <style type="text/css">
    .confi {

        height: 30px;



    }
    </style>

    <?php require '../navAdmi.php'; ?>

    <title>Buscar Usuarios</title>

    <link rel="icon" type="image/png" sizes="16x16" href="../situ.png">

    <link rel="stylesheet" type="text/css" href="./estilos.css">

    <link rel="stylesheet" type="text/css" href="../Assets/fonts/style.css">

    <link rel="stylesheet" type="text/css" href="

  ../Assets/bootstrap-4.3.1-dist/css/bootstrap.min.css

">

</head>

<body class=" bg-white">

    <?php require '../navegacion.php';?>

    <br><br>



    <div class="container">

        <div class="row">

            <div class="col">

                <a class="btn btn-warning font-weight-bold text-light" href="listaUsuarios.php">Todos los Usuarios</a>

            </div>



            <div style="margin-left: 20px;">

                <h1 class="font-weight-bold">LISTA DE USUARIOS</h1>

            </div>

            <div style="margin-top: 45px;margin-left: 70px;">

                <form class="form-inline float-right" action="buscarUsuario.php" method="get"
                    style="margin-top: -40px; margin-right: 20px;">

                    <input class="form-control mr-sm-2 border border-dark

          " type="text" name="busqueda" id="busqueda" placeholder="Buscar"
                        value="<?php if(isset($_GET['busqueda']))  echo $_GET['busqueda'] ;?>"
                        onchange='this.form.submit()'>

                    <noscript><input type="submit" value="Submit"></noscript>

                </form>

            </div>

        </div>

    </div>



    <br>



    <br>

    <?php







require_once '../conecion.php';



if($conectarBD->connect_error){

    die("conexion fallida: ".$conectarBD->connect_error);

    

    

}



         

          $registros="SELECT COUNT(*) AS totalRegistros FROM usuarios WHERE ( id      LIKE '%$busqueda%'                                                                     OR

                                                                              nombre  LIKE '%$busqueda%' OR

                                                                              usuario LIKE '%$busqueda%' OR

                                                                              tipo    LIKE '%$busqueda%' OR

                                                                              email   LIKE '%$busqueda%' )

                                                                              ";

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

if ($idUser ==1) {

          $sql = "SELECT * FROM usuarios where ( id      LIKE '%$busqueda%' OR

                                      nombre   LIKE '%$busqueda%' OR

                                      usuario LIKE '%$busqueda%' OR

                                       tipo    LIKE '%$busqueda%' OR

                                       email   LIKE '%$busqueda%' )

                                        LIMIT $desde,$canPagina";

        }else{

          $sql = "SELECT * FROM usuarios where ( id      LIKE '%$busqueda%' OR

                                      nombre   LIKE '%$busqueda%' OR

                                      usuario LIKE '%$busqueda%' OR

                                       tipo    LIKE '%$busqueda%' OR

                                       email   LIKE '%$busqueda%' )

                                       AND estado = 1 LIMIT $desde,$canPagina";

        }





?>

    <div class="container">

        <table class='table table-hover'>

            <tr align='center' class='bg-primary'>

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





            <tr align='center' class='font-weight-bold' scope='row'>



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

                <td align='center'>



                    <a class='btn btn-secondary' href='./editarUsuario.php?&token=<?php echo $fila['token'];?> '
                        title="Editar Usuario"><span class="icon-edit"></span></a>

                    <?php if($fila['id'] != 1){

        if ($fila['estado']=='Activo') {

        ?>

                    <a class='btn '
                        href='./eliminarUser.php?token=<?php echo $fila['token'];?>&id=<?php echo hashPassword($fila['id']); ?>'
                        title="Desacticar Este Usuario"><span class="icon-checkmark1 text-success"
                            style="font-size: 30px;"></span></a>

                    <?php }else{?>

                    <a class='btn '
                        href='./eliminarUser.php?token=<?php echo $fila['token'];?>&id=<?php echo hashPassword($fila['id']); ?>'
                        title="Activar Este Usuario"><span class="icon-cancel text-danger"
                            style="font-size: 30px;"></span></a>

                    <?php } }?>

                </td>

            </tr>





            <?php    

 }

          }

          ?>

        </table>

    </div>

    <br>

    <?php 

            if ($totalRegistros!=0)

             {

  

             ?>

    <nav aria-label="Page navigation example">

        <ul class="pagination justify-content-center">

            <?php 

                if ($pagina!=1) {

                

              ?>

            <li class="page-item">

                <a class="page-link font-weight-bold"
                    href="?pagina=<?php echo 1;?>&busqueda=<?php echo $busqueda; ?>">INICIO</a>

            </li>

            <li class="page-item">

                <a class="page-link" href="?pagina=<?php echo $pagina -1;?>&busqueda=<?php echo $busqueda; ?>"><span
                        class="icon-circle-left text-primary"></span></a>

            </li>

            <?php 

            }

              for ($i=1; $i <= $totalPaginas ; $i++) { 

                if ($i == $pagina) {

                  echo '<li class="page-item page-link bg-dark text-light">'.$i.'</li>' ;

                }else{

               echo '<li class="page-item"><a class="page-link" href="?pagina='.$i.'&busqueda='.$busqueda.'">'.$i.'</a></li>';

              }}



              if ($pagina !=$totalPaginas) {

              

               ?>

            <li class="page-item">

                <a class="page-link" href="?pagina=<?php echo $pagina +1;?>&busqueda=<?php echo $busqueda; ?>"><span
                        class="icon-circle-right text-primary"></span></a>

            </li>

            <li class="page-item">

                <a class="page-link font-weight-bold"
                    href="?pagina=<?php echo $totalPaginas;?>&busqueda=<?php echo $busqueda; ?>">FIN</a>

            </li>

            <?php

               } 

              ?>

        </ul>

    </nav>

    <?php

          } else{

              echo '<h1 align="center">No se ha Encontrado Ningun Resultado</h1><br>

              <div align="center">

              

              

           <a align="center" class="btn btn-warning" href="listaUsuarios.php"><h5>Realiza Una Nueva Consulta</h5> </a>

           

               </div>';



          }

          ?>







    <br>

    <br>



    <script type="text/javascript" src="../Assets/Jquery/jQuery_v3.4.1.js"></script>

    <script type="text/javascript" src="../Assets/bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>



</body>