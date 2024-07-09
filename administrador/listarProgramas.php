<?php
session_start();
require '../conecion.php';
require '../Assets/funcion.php';

$idUser=$_SESSION['id'];
$tipoUsuario = $_SESSION['tipo'];
if(empty($_SESSION['tipo'])) {
    echo "<script>window.location.href='../index.php'; </script>";  
}
 ?>
<!DOCTYPE html>
<html>
<head>
  <?php include '../navAdmi.php';?>
	<title>Lista de Programas</title>
  <link rel="icon" type="image/png" sizes="16x16" href="../situ.png">
 <meta charset="utf-8">
   <link rel="stylesheet" type="text/css" href="estilos.css">
  <link rel="stylesheet" type="text/css" href="../Assets/fonts/style.css">
  <link rel="stylesheet" type="text/css" href="../Assets/bootstrap-4.3.1-dist/css/bootstrap.min.css">
<link rel="icon" type="image/png" sizes="16x16" href="../situ.png">
  
 
  <link rel="stylesheet" type="text/css" href="../css/sweetalert.css">
  <script type="text/javascript" src="../js/sweetalert.js"></script>
</head>
<body class=" bg-white">
<?php require '../navegacion.php';?>
    <?php


 $registros="SELECT COUNT(*) AS totalRegistros FROM programas WHERE estado = 1 OR estado=0";

          if($conectarBD->query($registros)->num_rows > 0){

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

    if ($idUser==1) {
     $sql = "SELECT id_programaF, nombreP, area.nombreArea, programas.token, programas.estado FROM `programas` INNER JOIN area ON programas.id_area=area.id_area LIMIT $desde,$canPagina"; 
    }else{
      $sql = "SELECT id_programaF, nombreP, area.nombreArea, programas.token FROM `programas` INNER JOIN area ON programas.id_area=area.id_area WHERE  programas.estado=1 LIMIT $desde,$canPagina";
    }     
     if ($conectarBD->query($sql)->num_rows > 0){

?>


<br>
<div>
  <div  style="margin-top: 2px; margin-left: 100px;">
 <a href="registrarPrograma.php" title="Crear Programa" class="btn btn-success font-weight-bold"><span class="icon-plus1"></span>Programa</a>
</div>
  <h1 align="center" class="font-weight-bold" style="margin-top: -3%;">  Listar Programas </h1>
    <form class="form-inline float-right" action="buscarPrograma.php" method="get" style="margin-top: -40px; margin-right: 100px;" >
          <input class="form-control mr-sm-2 border border-dark" type="text" name="busqueda" id="busqueda" placeholder="Buscar">
         
        </form>
   </div> 
 <br>
<div style="margin-left: 112px; margin-top: -40px;">

<a onclick="exportarPdf()" title="Exportar a PDF" class="btn"  style="font-size: 40px; cursor: pointer; " >
  <span class="icon-file-pdf text-danger"></span></a>

<a  onclick="exportarExcel()"  title="Exportar a EXCEL" class="btn"  id="excel" style="font-size: 40px; margin-left: -20px; cursor: pointer; " >
  <span class="icon-file-excel text-success"></span></a>


</div>
<?php

if($conectarBD->connect_error){
    
    die("conexion fallida ".$conectarBD->connect_error);
    }
  ?> 



  <div align="center" class="container">     
    <table class="table  table-light table-hover  font-weight-bold">
      <tr align="center" class='bg-primary'>
        <th>Id Programa</th>
        <th>Programa de Formación</th>
        <th>Area</th>
        <?php if ($idUser==1) {?>
    <th>Estado</th>
    <?php } ?>
        <th>Acciones</th></tr>
<?php
         
         foreach ($conectarBD->query($sql) as $value){
             ?>
             <tr align='center' class='font-weight-bold'  >
              <td><?php echo $value['id_programaF'];?></td>
              <td><?php echo $value['nombreP'];?></td>
              <td><?php echo $value['nombreArea'];?></td>
          <?php if ($tipoUsuario == 'administrador' ) {
                        if ($idUser ==1) {
              ?>
             <td><?php 
                  switch ($value['estado']) {
                    case '1':
                      $value['estado'] = 'Activo';
                      break;
                      case '0':
                      $value['estado'] = 'Inactivo';
                      break;     
                  }
                  if ($value['estado']=='Activo') {
                    echo "<span class='text-success'>".$value['estado']."</span>";
                  }else{
                    echo "<span class='text-danger'>".$value['estado']."</span>";
                  }
                  
             ?></td>
             <?php }
                  }
              ?></td>
              <td align="center">
            <a class='btn btn-secondary' href='./editarPrograma.php?token=<?php echo $value['token'];?> ' style='size: 10px;' title='Editar Programa' ><i class='icon-edit text-light' style="font-size: 20px;"></i></a>
             <?php  
              if ($idUser ==1) {
              if ($value['estado']=='Activo') {
              ?>  
            <a href="./eliminarPrograma.php?token=<?php echo $value['token'];?>" class='btn' style='size: 10px;'  title='Desactivar Programa'><i class='icon-checkmark1 text-success'  style="font-size: 30px;"></i></a>
            <?php }elseif($value['estado']=='Inactivo'){?> 
            <a href="./eliminarPrograma.php?token=<?php echo $value['token'];?>" class='btn' style='size: 10px;' title='Activar Programa'><i class='icon-cancel text-danger'  style="font-size: 30px;"></i></a>
            <?php }}
                if ($idUser!=1) {
                
              if ($tipoUsuario == 'administrador' ) {
             ?>
             <a  href="./eliminarPrograma.php?token=<?php echo $value['token'];?>" class='btn btn-danger' style='size: 10px;' title='Activar Programa'><i class='icon-bin text-light' ></i></a>   <?php 
              }}
               ?> 
                
            </td>
             <?php
              }
                  
              ?>
             
            </tr>     
               <?php                 
          
     
        
     $conectarBD->Close();

?> 
         
         </table>
       </div>
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
              <?php 
                if ($pagina!=1) {
                
              ?>
              <li class="page-item">
                <a  class="page-link font-weight-bold" href="?pagina=<?php echo 1;?>"  >INICIO</a>
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
}else{

  echo "<div class='container'><br>";
     die(include '../errorAlgoSM.php');
               }
  echo "</div>";
?>


<script type="text/javascript" src="../Assets/Jquery/jQuery_v3.4.1.js"></script>
<script type="text/javascript" src="../Assets/bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../Assets/Js/vue.js"></script>

<script type="text/javascript">
  function exportarExcel() {
    swal({
  title: "Advertencia",
  text: "¿Desea Exportar Todas los programas a Excel?",
  type: "warning",
  showCancelButton: true,
  confirmButtonColor: "#28A745",
  confirmButtonText: "Si",
  cancelButtonColor: "#DC3545",
  cancelButtonText: "No",
  closeOnConfirm: true,
  closeOnCancel: true
},
function(isConfirm){
  if (isConfirm) {
    window.location="./pdfPrograma.php?E=1";

  } 
});

}

  function exportarPdf() {
    swal({
  title: "Advertencia",
  text: "¿Desea Exportar Todas los programas a PDF?",
  type: "warning",
  showCancelButton: true,
  confirmButtonColor: "#28A745",
  confirmButtonText: "Si",
  cancelButtonColor: "#DC3545",
  cancelButtonText: "No",
  closeOnConfirm: true,
  closeOnCancel: true
},
function(isConfirm){
  if (isConfirm) {
    window.location="./descargarPDF_P.php";
  } 
});

}
</script>

</body>
</html>