<?php

require '../conecion.php';
require '../Assets/funcion.php';

session_start();
$idUser=$_SESSION['id'];
$tipoUsuario = $_SESSION['tipo'];
    if (empty($_SESSION['tipo'])) {
        echo "<script>window.location.href='../index.php'; </script>";  
    } 


?>  
<!DOCTYPE html>
<html>
<head>
  <title>Lista de Asistencia T. Rutinario</title>
  <link rel="icon" type="image/png" sizes="16x16" href="../situ.png">
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="../estilos.css">
  
<script type="text/javascript" src="../Assets/Jquery/jQuery_v3.4.1.js"></script>
<script type="text/javascript" src="../Assets/bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../Assets/Js/vue.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script type="text/javascript" src="../Assets/sweetalert2/sweetalert2.all.min.js"></script>


<?php include '../navAdmi.php';?>     
<link rel="stylesheet" type="text/css" href="../estilos.css">
<link rel="stylesheet" type="text/css" href="../Assets/bootstrap-4.3.1-dist/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="../Assets/iconos/style.css">
<link rel="stylesheet" type="text/css" href="../Assets/sweetalert2/sweetalert2.min.css">
</head>
<body class="bg-white">
<?php require '../navegacion.php';?>
<br>

  <h1 align="center" class="font-weight-bold" style="margin-top: 2%;">Asistencia Turnos Rutinarios  </h1>
    <form class="form-inline float-right" action="buscarTurnosR.php" method="get" style="margin-top: -40px; margin-right: 100px;" >
          <input class="form-control mr-sm-2 border border-dark" type="text" name="busqueda" id="busqueda" placeholder="Buscar">
         
        </form></h1>
   </div>  
<?php


if($conectarBD->connect_error){
    die(require '../errorAlgoSM.php');
    
    
}

  
          $registros="SELECT COUNT(*) AS totalRegistros FROM turnorutinario WHERE estado = 1";
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

$sql = "SELECT * FROM turnorutinario where estado = 1 LIMIT $desde,$canPagina";


?>
<br><br>
<div class="container">
<table class='table table-hover table-light'>
  <tr align='center' class='bg-primary '>
    <th>CODIGO TURNO</th>
    <th>DOCUMENTO</th>
    <th>FICHA</th>
    <th>AREA</th>
    <th>UNIDAD</th>
    <th>FECHA TURNO</th>
    <th>HORA INICIO</th>
    <th>HORA FIN</th>
    <th>Fallas</th>
    <th>Asistencia</th>
  </tr>
  <?php

if($conectarBD->query($sql)->num_rows > 0){

   foreach ($conectarBD->query($sql) as $fila){
 
    ?>
      
     
  <tr  align='center' class='font-weight-bold' scope='row'>
    <td><?php echo $fila['codigoTurno'];?></td>
    <td><?php echo $fila['id_aprendiz'] ;?></td>
    <td><?php echo $fila['id_ficha'];?></td>
    <td><?php  
    $sqlArea = "SELECT nombreArea FROM area WHERE id_area =".$fila['id_area'];
    if( $conectarBD->query($sqlArea)->num_rows > 0){

           foreach ($conectarBD->query($sqlArea) as $area){

          $nombArea=$area['nombreArea'];
        }
      }
    echo $nombArea;?>
      



    </td>
    <td><?php
        $sqlUnidad = "SELECT nombreUnidad FROM unidad WHERE codigoUnidad =".$fila['codigoUnidad'];
        if( $conectarBD->query($sqlUnidad)->num_rows > 0){

           foreach ($conectarBD->query($sqlUnidad) as $unidad){

          $nombUnidad=$unidad['nombreUnidad'];
        }
      }

     echo $nombUnidad;?></td>
    <td><?php echo $fila['fechaTurno'];?></td>
    <td><?php echo $fila['horaInicio'];?></td>
    <td><?php echo $fila['horaFin'];?></td>
    <td><?php echo $fila['fallas'];?></td>
    <td  align='center' class='font-weight-bold'>   
  <i class='btn icon-checkmark1 text-success' style="font-size: 20px;" href ='#' onclick='confirmar1(<?php echo $fila['codigoTurno'];?>)' onclick='this.disabled="disabled"'></i></td>
  


   
      <?php }?>
    </td>
  </tr>


<?php    
 
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

            

<script type="text/javascript" src="../Assets/Jquery/jQuery_v3.4.1.js"></script>
<script type="text/javascript" src="../Assets/bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../Assets/bootstrap-4.3.1-dist/js/bootstrap.bundle.js"></script>


<script type="text/javascript">
  $('i').click(function() {
  $(this).toggleClass('icon-checkmark1').toggleClass('icon-cancel text-danger');
});
</script>
<script type="text/javascript">
function confirmar1(codigoTurno){

const swalWithBootstrapButtons = Swal.mixin({
  customClass: {
    confirmButton: 'btn btn-success',

    cancelButton: 'btn btn-danger'
  },
  buttonsStyling: false
})


swalWithBootstrapButtons.fire({
  title: 'Estas seguro de agregar una falla al aprendiz?',
  text: "Esta operacion no se puede revertir! Con esto enviara un memorando",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonText: 'Si, agrega la falla! ',
  cancelButtonText: 'No, cancelalo! ',
  reverseButtons: true
}).then((result) => {
  if (result.value) {
    window.location.href="agregarFallaRutinario.php?codigoTurno="+codigoTurno;
}else if (
    
    result.dismiss === Swal.DismissReason.cancel
  ) {
    swalWithBootstrapButtons.fire(
      'Cancelado',
      'Tu falla no a sido agregada :)',
      'error'
    )
  }
})
}
</script>
</body>
</html>