
<?php 
session_start();
require '../conecion.php';
require '../Assets/funcion.php'; 

$idUser=$_SESSION['id'];
$tipoUsuario = $_SESSION['tipo'];
    if (empty($_SESSION['tipo'])) {
           echo "<script>window.location.href='../index.php'; </script>";  
    } 
     $busqueda=strtolower($_REQUEST['busqueda']);
    if (empty($busqueda)){
       echo "<script>window.location.href='./listarProgramas.php'</script>";
    }

 ?>
<!DOCTYPE html>
<html>
<head>
  <?php include '../navAdmi.php';?>
	<title>Buscar Programas</title>
  <link rel="icon" type="image/png" sizes="16x16" href="../situ.png">
  
<link rel="stylesheet" type="text/css" href="../estilos.css">
  <link rel="stylesheet" type="text/css" href="../Assets/fonts/style.css">
  <link rel="stylesheet" type="text/css" href="../Assets/bootstrap-4.3.1-dist/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="../css/sweetalert.css">
  <script type="text/javascript" src="../js/sweetalert.js"></script>
</head>
<body class=" bg-white">
<?php require '../navegacion.php';?>
<?php 

$registros="SELECT COUNT(*) AS totalRegistros FROM programas INNER JOIN area ON programas.id_area=area.id_area WHERE ( id_programaF LIKE '%$busqueda%' OR nombreP LIKE '%$busqueda%' OR area.nombreArea LIKE '%$busqueda%' ) AND programas.estado=1";

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


$sql="SELECT programas.id_programaF, programas.nombreP, area.nombreArea, programas.id_area, programas.estado, programas.token FROM programas INNER JOIN area ON programas.id_area=area.id_area WHERE ( id_programaF LIKE '%$busqueda%' OR nombreP LIKE '%$busqueda%' OR area.nombreArea LIKE '%$busqueda%' ) AND programas.estado LIMIT $desde,$canPagina";


if( $conectarBD->query($sql)->num_rows > 0){
?>

<br>
  <div  style="margin-top: 2px; margin-left: 127px;">
 <a href="listarProgramas.php" class="btn btn-warning font-weight-bold text-light">Todos los programas</a>
</div>
  <h1 align="center" class="font-weight-bold" style="margin-top: -3%;">  Busqueda de Programas </h1>
    <form class="form-inline float-right" action="buscarPrograma.php" method="get" style="margin-top: -40px; margin-right: 120px;" >
          <input class="form-control mr-sm-2 border border-dark" type="text" name="busqueda" id="busqueda" value="<?php if(isset($_GET['busqueda'])){ echo $_GET['busqueda'];} ?>" placeholder="Buscar">
         
        </form>
   </div> 
                     
<br>
<div style="margin-left: 112px; margin-top: -40px;">


<a onclick="exportarPdf()" title="Exportar a PDF" class="btn"  style="font-size: 40px; cursor: pointer; " >
  <span class="icon-file-pdf text-danger"></span></a>

<a onclick="exportarExcel()" title="Exportar a EXCEL" class="btn"  id="excel" style="font-size: 40px; margin-left: -20px; cursor: pointer;" >
  <span class="icon-file-excel text-success"></span></a>
</div>


<?php
if($conectarBD->connect_error){
  die("Conexión Fallida: ".$conectarBD->connect_error);
}

?>

<div align="right" style="margin-top: -10px; margin-right: 125px;">
  <h5>Total Busqueda:
<span class="text-primary font-weight-bold">
  <?php 
echo $totalRegistros;
  ?>
  </span>
</h5>
</div>



<div class="container">
<table class='table table-hover table-light'>
  <tr align='center' class='bg-primary '>
    <th>ID Programa</th>
    <th>Programa de Formación</th>
    <th>AREA</th>
  <?php if ($idUser==1) {?>
    <th>Estado</th>
    <?php } ?>
    <th>ACCIONES</th>
  </tr>
<?php

   foreach ($conectarBD->query($sql) as $fila){
 
    ?>
      
     
  <tr  align='center' class='font-weight-bold' scope='row'>
    <td><?php echo $fila['id_programaF'] ;?></td>
    <td><?php echo $fila['nombreP'];
     ?>
      </td>
      <td><?php echo $fila['nombreArea'];?></td> <?php if ($tipoUsuario == 'administrador') {
                        if ($idUser == 1) {
                          ?>                          
      <td><?php 
                  switch ($fila['estado']) {
                    case '1':
                      $fila['estado'] = 'Activo';
                      break;
                      case '0':
                      $fila['estado'] = 'Inactivo';
                      break;     
                  }
                  if ($fila['estado']=='Activo') {
                    echo "<span class='text-success'>".$fila['estado']."</span>";
                  }else{
                    echo "<span class='text-danger'>".$fila['estado']."</span>";
                  }
                  
             ?></td>
                          <?php
                        }
     }

     ?>
      <td align="center">
            <a class='btn btn-secondary' href='./editarPrograma.php?token=<?php echo $fila['token'];?> ' style='size: 10px;' title='Editar' ><i class='icon-edit text-light' style="font-size: 20px;"></i></a>
             <?php  
              if ($idUser ==1) {
              if ($fila['estado']=='Activo') {
              ?>  
            <a href="./eliminarPrograma.php?token=<?php echo $fila['token'];?>" class='btn' style='size: 10px;'  title='Desactivar Programa'><i class='icon-checkmark1 text-success'  style="font-size: 30px;"></i></a>
            <?php }elseif($fila['estado']=='Inactivo'){?> 
            <a href="./eliminarPrograma.php?token=<?php echo $fila['token'];?>" class='btn' style='size: 10px;' title='Activar Programa'><i class='icon-cancel text-danger'  style="font-size: 30px;"></i></a>
            <?php }}
                if ($idUser!=1) {
                
              if ($tipoUsuario == 'administrador' ) {
             ?>
             <a  href="./eliminarPrograma.php?token=<?php echo $fila['token'];?>" class='btn btn-danger' style='size: 10px;' title='Activar Programa'><i class='icon-bin text-light' ></i></a>   <?php 
              }}
               ?> 
                
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
                <a class="page-link font-weight-bold" href="?pagina=<?php echo 1;?>&busqueda=<?php echo $busqueda;?>" >INICIO</a>
              </li>
              <li class="page-item">
                <a class="page-link" href="?pagina=<?php echo $pagina -1;?>&busqueda=<?php $busqueda; ?>" ><span class="icon-circle-left text-primary"></span></a>
              </li>
              <?php 
            }
              for ($i=1; $i <= $totalPaginas ; $i++) { 
                if ($i == $pagina) {
                  echo '<li class="page-item page-link bg-success text-light">'.$i.'</li>' ;
                }else{
               echo '<li class="page-item"><a class="page-link" href="?pagina='.$i.'&busqueda='.$busqueda.'">'.$i.'</a></li>';
              }}

              if ($pagina !=$totalPaginas) {
              
               ?>
              <li class="page-item">
                <a class="page-link" href="?pagina=<?php echo $pagina +1;?>&busqueda=<?php echo $busqueda;?>"><span class="icon-circle-right text-primary"></span></a>
              </li>
              <li class="page-item">
                <a class="page-link font-weight-bold" href="?pagina=<?php echo $totalPaginas;?>&busqueda=<?php echo $busqueda;?>">FIN</a>
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

            <br>
            <br>
  <script type="text/javascript" src="../Assets/Jquery/jQuery_v3.4.1.js"></script>
<script type="text/javascript" src="../Assets/bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../Assets/bootstrap-4.3.1-dist/js/bootstrap.bundle.js"></script>

<script type="text/javascript">
  function exportarExcel() {
    
    swal({
  title: "Advertencia",
  text: "¿Está Seguro de exportar <?php echo $totalRegistros; ?> Registros de la busqueda de Programas a Excel?",
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
    window.location.href="./pdfPrograma.php?E=1&<?php if(isset($_REQUEST['busqueda'])){?>busqueda=<?php echo $_REQUEST['busqueda'];}?>";
  } 
});

}

  function exportarPdf() {
    swal({
  title: "Advertencia",
  text: "¿Está Seguro de exportar <?php echo $totalRegistros; ?> Registros de la busqueda de Programas a PDF?",
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
    window.location.href="./descargarPDF_P.php?<?php if(isset($_REQUEST['busqueda'])){?>busqueda=<?php echo $_REQUEST['busqueda'];}?>";
  } 
});

}
</script>
</body>
</html>
