<?php
session_start();
require '../conecion.php';
require '../Assets/funcion.php';

$idUser= $_SESSION['id'];
$tipoUsuario = $_SESSION['tipo'];
    if (empty($_SESSION['tipo'])) {
       echo "<script>window.location.href='../index.php'; </script>";  
    } 


?>  
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="../estilos.css">
  <link rel="stylesheet" type="text/css" href="../Assets/bootstrap-4.3.1-dist/css/bootstrap.min.css
">
<?php require '../navAdmi.php';?>
  <title>Lista de Turnos especiales</title>
  <link rel="icon" type="image/png" sizes="16x16" href="../situ.png">
   <link rel="stylesheet" type="text/css" href="./estilos.css">
  <link rel="stylesheet" type="text/css" href="../Assets/fonts/style.css">
  <link rel="stylesheet" type="text/css" href="../Assets/bootstrap-4.3.1-dist/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="../Assets/sweetalert2/sweetalert2.min.css">
 
</head>
<body class=" bg-white">
<?php require '../navegacion.php';


require_once '../conecion.php';

if($conectarBD->connect_error){
    die( require '../errorAlgoSM.php');
}
  $registros="SELECT COUNT(*) AS totalRegistros FROM turnoespecial WHERE estado = 1";
          if( $conectarBD->query($registros)){

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

        }
      }else{
          die( require '../errorAlgoSM.php');
        }


   if ($idUser==1) {
 $sql = "SELECT * FROM turnoespecial LIMIT $desde,$canPagina";
}else{
  $sql = "SELECT * FROM turnoespecial where estado = 1 LIMIT $desde,$canPagina";
}

     $sqlFicha = "SELECT * FROM ficha ORDER BY id_ficha ASC";

?>



<?php
if( $conectarBD->query($sql)){
  ?>
  <br><br>

  <div  style="margin-top: 2px; margin-left: 120px;">
 <a href="registrarTurnoEspecial.php" class="btn btn-success font-weight-bold" title="Crear Turno"><span class="icon-plus1"></span> Turnos Especiales</a>
</div>
  <h1 align="center" class="font-weight-bold" style="margin-top: -3%; ">  Listar Turnos Especiales </h1>
    <form class="form-inline float-right" action="buscarTurno.php" method="get" style="margin-top: -40px; margin-right: 110px;" >
          <input class="form-control mr-sm-2 border border-dark" type="text" name="busqueda" id="busqueda" placeholder="Buscar">
         
        </form></h1>
   </div>               
     <div  style="margin-left: 70px;">
       <form  action="buscarTurno.php" method="post"  >
                
        <select  class="form-control  col-md-2 border border-dark" style="margin-left: 50px;"  name="id_ficha" id="id_ficha" onchange='this.form.submit()'>
                       
        <option class="font-weight-bold"  value="0">Buscar Ficha</option>

                                <?php

                               foreach($conectarBD->query($sqlFicha) as $ficha){
                                ?>
                               <option  class="font-weight-bold "  value="<?php echo $ficha['id_ficha'];?>" ><?php
                                echo $ficha['id_ficha'];?></option>
                               <?php
                               }
                                
                                ?>
                          </select>
                          <noscript><input type="submit" value="Submit"></noscript>
                          
                      </form>
                  </div>
   

<div style="margin-left: 105px; margin-top: 5px;">

<a href="descargarPDFTE.php" title="Exportar a PDF" class="btn"  style="font-size: 40px;" >
  <i class="icon-file-pdf text-danger"></i> <span></span></a>

  <a href="pdfTurnoE.php?E=1"  title="Exportar a EXCEL" class="btn"  id="pdf" style="font-size: 40px; margin-left: -20px " >
  <span class="icon-file-excel text-success"></span></a>

</div>


 
 <?php


if($conectarBD->connect_error){
    die("conexion fallida: ".$conectarBD->connect_error);
    
    
}
?>
<div align="right" style="margin-top: -80px; margin-right: 10%; ">
  <h5>Total Turnos Activos :
<span class="text-primary font-weight-bold">
  <?php 
echo $totalRegistros;
  ?>
  </span>
</h5>
</div>

<br><br>
<div class="container">
<table class='table table-light table-hover'>
    <tr align='center' class='bg-primary'>
    <th>Codigo Turno Especial</th>
    <th>N° Ficha</th>
    <th>Area</th>
    <th>Unidad</th>
    <th>Fecha Turno</th>
    <th>Hora Inicio</th>
    <th>Hora Fin</th>
 <?php if ($idUser==1) { ?>
    <th>ESTADO</th>
    <?php } ?>
    <th> ACCIONES</th>
  </tr>
</tr>
<?php

   foreach ($conectarBD->query($sql) as $value){
 
    ?>


     <tr align='center' class='font-weight-bold' scope='row'>
    <td> <?php echo $value['idTurnoEspecial']; ?> </td>
    <td><?php echo $value['id_ficha'];?></td>
    <td><?php 


  $sqlA= "SELECT * FROM area WHERE id_area=".$value['id_area'];
       if ($conectarBD->query($sqlA)->num_rows > 0){

         foreach ($conectarBD->query($sqlA) as $fila){
          $nombreArea= $fila['nombreArea'];
        }
}
    echo $nombreArea;?>
      
    </td>
    <td><?php

    
  $sqlU= "SELECT * FROM unidad WHERE codigoUnidad=".$value['codigoUnidad'];
       if ($conectarBD->query($sqlU)->num_rows > 0){

         foreach ($conectarBD->query($sqlU) as $unidad){
          $nombreUnidad= $unidad['nombreUnidad'];
        }
}
     echo $nombreUnidad;?></td>
    <td><?php echo $value['fechaTurnoEspecial']; ?></td>
    <td><?php echo $value['horaInicio'];?></td>
    <td><?php echo $value['horaFin'];?></td>
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

      <a class='btn btn-secondary' href='./editarTurnoEspecial.php?token=<?php echo $value['token'];?>' title="Editar Turno"><span class="icon-edit"></span> </a>

 <?php if ($tipoUsuario=='administrador') {
   if ($idUser==1) {
         if ($value['estado']=='Activo') {
           ?>
            <a  class='btn ' href ="./eliminarTurnoEspecial.php?token=<?php echo $value['token'];?>" title="Desactivar Turno"><span class="icon-checkmark1 text-success" style="font-size: 25px;" ></span></a>
           <?php
         }else{
          ?>
           <a  class='btn' href ="./eliminarTurnoEspecial.php?token=<?php echo $value['token'];?>" title="Activar Turno"><span class="icon-cancel text-danger" style="font-size: 25px;"></span></a>
          <?php
         }
  }else{?>
     <a  class='btn btn-danger' href ="./eliminarTurnoEspecial.php?token=<?php echo $value['token'];?>" title="Eliminar Turno"><span class="icon-bin text-light" style="font-size: 20px;"></span></a>
    <?php
      }}
      ?>
    </div>   
      
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

 <?php 

 $conectarBD->close(); 
?>
 
<script type="text/javascript" src="../Assets/Jquery/jQuery_v3.4.1.js"></script>
<script type="text/javascript" src="../Assets/bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>
           
</body>
</html>