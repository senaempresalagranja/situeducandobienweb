
  
<?php 
session_start();
require '../conecion.php';

$idUser= $_SESSION['id'];
$tipoUsuario = $_SESSION['tipo'];
      if (empty($_SESSION['tipo'])) {
        echo "<script>window.location.href='../index.php'; </script>";  
      
      }
?>
<!DOCTYPE html>
<html>
<head>
  <?php include '../navAdmi.php';?>
  <title>Lista de Areas</title>
<meta charset="utf-8"><link rel="icon" type="image/png" sizes="16x16" href="../situ.png">
<link rel="stylesheet" type="text/css" href="../estilos.css">
<link rel="stylesheet" type="text/css" href="../Assets/iconos/style.css">
<link rel="stylesheet" type="text/css" href="../Assets/bootstrap-4.3.1-dist/css/bootstrap.min.css">

</head>
<body class=" bg-white">
    

<?php require '../navegacion.php';?>

 


<?php        


if($conectarBD->connect_error ){
    
    die(require '../errorAlgoSM.php');

  }

      $registrosIN="SELECT COUNT(*) AS totalRegistros FROM area WHERE estado = 0";
          if( $conectarBD->query($registrosIN)->num_rows > 0){

           foreach ($conectarBD->query($registrosIN) as $fila){

          $registrosI=$fila['totalRegistros'];
          $canPagina= 5;

          if (empty($_GET['pagina'])) {
            $pagina= 1;
          }else{
            $pagina=$_GET['pagina'];
          }
          $desde=($pagina-1)*$canPagina;

          $totalPaginas=ceil($registrosI/$canPagina);

        }}


          $registros="SELECT COUNT(*) AS totalRegistros FROM area WHERE estado = 1";
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
 $sql = "SELECT * FROM area LIMIT $desde,$canPagina";
}else{
  $sql = "SELECT * FROM area where estado = 1 LIMIT $desde,$canPagina";
}
if ($conectarBD->query($sql)->num_rows > 0){
?>
<br> <br>
<div>
  <div  style="margin-top: 2px; margin-left: 120px;">
 <a href="registrarArea.php" class="btn btn-success" title="Crear Area"><span class="icon-plus1"></span> Area</a>
</div>
  <h1 align="center" class="font-weight-bold" style="margin-top: -3%;">  Listar Areas </h1>
    <form class="form-inline float-right" action="buscarAreas.php" method="get" style="margin-top: -40px; margin-right:110px;" >
          <input class="form-control mr-sm-2 border border-dark" type="text" name="busqueda" id="busqueda" placeholder="Buscar">
       
        </form></h1>
   </div>                

<div style="margin-left: 112px; margin-top: -20px;">


<a  onclick="exportarPdf()" title="Exportar a PDF" class="btn"  style="font-size: 40px; cursor: pointer;" >
  <span class="icon-file-pdf text-danger"></span></a>

<a  onclick="exportarExcel()"  title="Exportar a EXCEL" class="btn"  id="excel" style="font-size: 40px; margin-left: -20px; cursor: pointer; " >
  <span class="icon-file-excel text-success"></span></a>
</div>



<div align="right" style="margin-top: 2px; margin-right: 117px;">
  <h5>Total Activos:
<span class="text-success font-weight-bold">
  <?php 
echo $totalRegistros;
  ?>
  </span>
</h5>
</div>

<?php 
if($idUser==1){
?>
<div align="right" style="margin-top: 10px; margin-right: 117px;">
  <h5> Registros Inactivos:
<span class="text-danger font-weight-bold">
  <?php 
echo $registrosI;
  }
  ?>
  </span>
</h5>
</div>

<div class="container">
<table class='table table-hover '>
<tr  align='center' class='bg-primary'>
<th  scope='col'>Codigo Area</th>
<th>Nombre Area</th>
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
  <td><?php echo $value['id_area'];?></td> 
  <td><?php echo $value['nombreArea'];?></td>
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

  <td  align='center' class=' bg-lg bg-outline col-xs-3'> 
                 <div class='btn-group' role='group'>
  <a class='btn btn-secondary' href ='./editarArea.php?token=<?php echo $value["token"];?>'title="Editar Area"><span class="icon-edit" style="font-size: 20px;"></span></a>

  <?php if ($tipoUsuario=='administrador') {
   if ($idUser==1) {
         if ($value['estado']=='Activo') {
           ?>
            <a  class='btn ' href ="./eliminarArea.php?token=<?php echo $value['token'];?>"  title="Desactivar Area"><span class="icon-checkmark1 text-success" style="font-size: 25px;" ></span></a>
           <?php
         }else{
          ?>
           <a  class='btn' href ="./eliminarArea.php?token=<?php echo $value['token'];?>" title="Eliminar Area"><span class="icon-cancel text-danger" style="font-size: 25px;"></span></a>
          <?php
         }
  }else{?>
     <a  class='btn btn-danger' href ="./eliminarArea.php?token=<?php echo $value['token'];?>" title="Eliminar Area"><span class="icon-bin text-light" style="font-size: 20px;"></span></a>
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
<?php 
}else{

  echo "<div class='container'><br>";
     die(include '../errorAlgoSM.php');
               }
  echo "</div>";
?>


<script type="text/javascript" src="../Assets/Jquery/jQuery_v3.4.1.js"></script>
<script type="text/javascript" src="../Assets/bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../Assets/bootstrap-4.3.1-dist/js/bootstrap.bundle.js"></script>
            


<script type="text/javascript">
  function exportarExcel() {
    swal({
  title: "Advertencia",
  text: "¿Desea Exportar Todas las Areas a Excel?",
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
    window.location="./pdfArea.php?E=1";

  } 
});

}

  function exportarPdf() {
    swal({
  title: "Advertencia",
  text: "¿Desea Exportar Todas las Areas a PDF?",
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
    window.location="./descargarPDFA.php";
  } 
});

}
</script>

</body>
</html>
