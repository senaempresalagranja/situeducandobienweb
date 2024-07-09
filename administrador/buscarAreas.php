
<?php
session_start();
require '../conecion.php';

$idUser= $_SESSION['id'];
    $tipoUsuario = $_SESSION['tipo'];
    if(empty($_SESSION['tipo'])) {
         echo "<script>window.location.href='../index.php'; </script>";  
    }
    $busqueda=strtolower($_REQUEST['busqueda']);
    if (empty($busqueda)){
      echo "<script>window.location.href='./ListarAreas.php'</script>";
  
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
<?php require '../navAdmi.php'; ?>

  <title>Busqueda de Areas</title>
  <link rel="icon" type="image/png" sizes="16x16" href="../situ.png">
  
   <link rel="stylesheet" type="text/css" href="./estilos.css">
  <link rel="stylesheet" type="text/css" href="../Assets/fonts/style.css">
  <link rel="stylesheet" type="text/css" href="../Assets/bootstrap-4.3.1-dist/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="../css/sweetalert.css">
  <script type="text/javascript" src="../js/sweetalert.js"></script>
</head>
<body class=" bg-white">
<?php require '../navegacion.php';?>
<br>
<?php

if($conectarBD->connect_error){
    die("conexion fallida: ".$conectarBD->connect_error);
    
}    
        

          $registros="SELECT COUNT(*) AS totalRegistros FROM area WHERE(id_area LIKE '%$busqueda%'                                                                     OR
                                                                              nombreArea  LIKE '%$busqueda%')";
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

$sql = "SELECT * FROM area where ( id_area LIKE '%$busqueda%' OR
                                      nombreArea LIKE '%$busqueda%')
                                       LIMIT $desde,$canPagina"; 
?>
<?php 
            if ($totalRegistros!=0)
             {
  
             ?>

<div>
  <div  style="margin-top: 2px; margin-left: 120px;">
 <a href="ListarAreas.php" class="btn btn-warning font-weight-bold text-light">Todas las Areas</a>
</div>
  <h1 align="center" class="font-weight-bold" style="margin-top: -3%;"> Busqueda Areas </h1>
    <form class="form-inline float-right" action="buscarAreas.php" method="get" style="margin-top: -40px; margin-right:110px;" >
          <input class="form-control mr-sm-2 border border-dark" type="text" value="<?php if(isset($busqueda)){ echo $busqueda;} ?>" name="busqueda" id="busqueda" placeholder="Buscar">
       
        </form></h1>
   </div>                
   <br>
<div style="margin-left: 112px; margin-top: -40px;">


<a onclick="exportarPdf('<?php echo $busqueda ?>')" title="Exportar a PDF" class="btn"  style="font-size: 40px; cursor: pointer; " >
  <span class="icon-file-pdf text-danger"></span></a>

<a  onclick="exportarExcel('<?php echo $busqueda ?>')" title="Exportar a EXCEL" class="btn" id="excel" style="font-size: 40px; margin-left:-20px; cursor: pointer; " >
  <span class="icon-file-excel text-success"></span></a>
</div>
<div class="container">
<table class='table table-hover table-light'>
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
  <a class='btn btn-secondary' href ='./editarArea.php?token=<?php echo $value["token"];?>'title="Editar"><span class="icon-edit" style="font-size: 20px;"></span></a>

  <?php if ($tipoUsuario=='administrador') {
   if ($idUser==1) {
         if ($value['estado']=='Activo') {
           ?>
            <a  class='btn ' href ="./eliminarArea.php?token=<?php echo $value['token'];?>"><span class="icon-checkmark1 text-success" style="font-size: 25px;" ></span></a>
           <?php
         }else{
          ?>
           <a  class='btn' href ="./eliminarArea.php?token=<?php echo $value['token'];?>"><span class="icon-cancel text-danger" style="font-size: 25px;"></span></a>
          <?php
         }
  }else{?>
     <a  class='btn btn-danger' href ="./eliminarArea.php?token=<?php echo $value['token'];?>"><span class="icon-bin text-light" style="font-size: 20px;"></span></a>
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
                <a class="page-link" href="?pagina=<?php echo $pagina -1;?>&busqueda=<?php echo $busqueda; ?>" ><span class="icon-circle-left text-primary"></span></a>
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
                <a class="page-link" href="?pagina=<?php echo $pagina +1;?>&busqueda=<?php echo $busqueda; ?>"><span class="icon-circle-right text-primary"></span></a>
              </li>
              <li class="page-item">
                <a class="page-link font-weight-bold" href="?pagina=<?php echo $totalPaginas;?>&busqueda=<?php echo $busqueda; ?>">FIN</a>
              </li>
              <?php
               } 
              ?>
            </ul>
          </nav>
        <?php
          } else{
              echo "<div class='container'><br>";
       die(include '../errorAlgoSM.php');
       echo "</div>";

          }
          ?>
            


            <br>
            <br>

<script type="text/javascript" src="../Assets/Jquery/jQuery_v3.4.1.js"></script>
<script type="text/javascript" src="../Assets/bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>

<script type="text/javascript">
  function exportarExcel(busqueda) {
    
    swal({
  title: "Advertencia",
  text: "¿Está Seguro de exportar <?php echo $totalRegistros; ?> Registro (s) de la busqueda de Areas a Excel?",
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
    window.location.href="./pdfArea.php?E=1&busqueda="+busqueda;
  } 
});

}

  function exportarPdf(busqueda) { 
    swal({
  title: "Advertencia",
  text: "¿Está Seguro de exportar <?php echo $totalRegistros; ?> Registro (s) de la busqueda de Areas a PDF?",
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
    window.location.href="./descargarPDFA.php?busqueda="+busqueda;
  } 
});

}
</script>
</body>
</html>
    

 
                
       
        
            