<?php 
session_start();
require '../conecion.php';
require '../Assets/funcion.php';


$idUser = $_SESSION['id'];
$tipoUsuario = $_SESSION['tipo'];
if (empty($_SESSION['tipo'])) {
   echo "<script>window.location.href='../index.php'; </script>";  
}

 ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width ">
	<title>Lista de Unidades</title>
  <link rel="icon" type="image/png" sizes="16x16" href="../situ.png">
<link rel="stylesheet" type="text/css" href="../estilos.css">
  <link rel="stylesheet" type="text/css" href="../Assets/fonts/style.css">
  <link rel="stylesheet" type="text/css" href="../Assets/bootstrap-4.3.1-dist/css/bootstrap.min.css">
<link rel="icon" type="image/png" sizes="16x16" href="../situ.png">
  
  <link rel="stylesheet" type="text/css" href="../css/sweetalert.css">
<script type="text/javascript" src="../js/sweetalert.js"></script>

  
</head>
<body class="bg-white">

<header class="topbar">
<?php include '../navAdmi.php'; ?>
</header>
<?php include '../navegacion.php'; ?>
<br>


<div id="respuesta"></div>

<div id="app">
  <div>
<?php
      $registrosIN="SELECT COUNT(*) AS totalRegistros FROM unidad WHERE estado = 0";
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
if($idUser==1){
 $registros="SELECT COUNT(*) AS totalRegistros FROM unidad";
}else{
   $registros="SELECT COUNT(*) AS totalRegistros FROM unidad WHERE estado=1";
}   
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
 if ($idUser==1) {
     $sql = "SELECT * FROM unidad LIMIT $desde,$canPagina"; 
  
    }else{
      $sql = "SELECT * FROM unidad WHERE estado = 1 LIMIT $desde,$canPagina";
    }
     
if( $conectarBD->query($sql)->num_rows > 0){
?>
 
  <div  style="margin-top: 2px; margin-left: 120px;">
 <a href="registrarUnidad.php" class="btn btn-success font-weight-bold" title="Crear Unidad"><span class="icon-plus1"></span> Unidades</a>
</div>
  <h1 align="center" class="font-weight-bold" style="margin-top: -3%;">  Listar Unidades </h1>
    <div>
    <form class="form-inline float-right" action="buscarUnidad.php" method="get" style="margin-top: -40px; margin-right: 110px;" >
          <input class="form-control mr-sm-2 border border-dark" type="text" name="busqueda" id="busqueda" placeholder="Buscar">
         
        </form>
   </div>               
   <br>
<div style="margin-left: 112px; margin-top: -40px;">

<a  onclick="exportarPdf()" title="Exportar a PDF" class="btn"  style="font-size: 40px; cursor: pointer; " >
  <span class="icon-file-pdf text-danger"></span></a>

<a  onclick="exportarExcel()"  title="Exportar a EXCEL" class="btn"  id="excel" style="font-size: 40px; margin-left: -20px; cursor: pointer; " >
  <span class="icon-file-excel text-success"></span></a>

</div>


<div align="right" style="margin-top: -50px; margin-right: 115px;">
  <h5>Total Unidades:
<span class="text-primary font-weight-bold">
  <?php 
echo $totalRegistros;
  ?>
  </span>
</h5>
</div>

<?php 
if($idUser==1){
?>
<div align="right" style="margin-top: -15px; margin-right: 115px;">
  <h5> Registros Inactivos:
<span class="text-danger font-weight-bold">
  <?php 
echo $registrosI;
  ?>
  </span>
</h5>
</div>
<?php
}
  ?>

<br>
<div class="container" align="center" >

<table class='table table-hover '>
  <tr align='center' class='bg-primary text-light'>
    <th>Codigo Unidad</th>
    <th>Nombre Unidad</th>
    <th>Area</th>
    <th>Tipo Turno</th>
    <th colspan="2">Hora Mañana</th>
    <th>Cantidad Aprendices</th>
    <?php if ($idUser==1) {?>
    <th>Estado</th>
    <?php } ?>
    <th>Acciones</th></tr>
 <?php
   

   foreach ($conectarBD->query($sql) as $fila){
 
    ?>
      
     
  <tr  align='center' class='font-weight-bold ' scope='row'>
    <td><?php echo $fila['codigoUnidad'] ;?></td>
    <td><?php echo $fila['nombreUnidad'] ;?></td>
    <td><?php
  $sqlA= "SELECT * FROM area WHERE id_area=".$fila['id_area'];
       if ($conectarBD->query($sqlA)->num_rows > 0){

         foreach ($conectarBD->query($sqlA) as $value){
          $nombreArea= $value['nombreArea'];
        }
}
    echo $nombreArea;
  
     ?></td>
     <td><?php echo $fila['tipoTurno'] ;?></td>
     <td><?php echo $fila['horaInicioM'] ;?></td>
     <td><?php echo $fila['horaFinM'] ;?></td>
     <td><?php echo $fila['cantidadAprendices'] ;?></td>
     <?php if ($idUser==1) {?>
     <td><?php 
        switch ($fila['estado']) {
         case '0':
         $fila['estado'] = "Inactivo";
                  
          break;
          case '1':
          $fila['estado'] = "Activo";
              
           break;
          }
          if ($fila['estado']=='Activo') {
          ?>
          <span class="text-success"><?php echo $fila['estado']?></span>
          <?php 
          }else{
          ?>
           <span class="text-danger"><?php echo $fila['estado']?></span>
          <?php
              }
          ?></td>
          <?php } ?>
    <td align='center' class='bg- bg-lg bg-outline col-xs-3'>
      <div class='btn-group' role='group'>

      <a class='btn ' href='./editarUnidad.php?token=<?php echo $fila['token'];?> ' title="Editar Unidad"><i class="icon-edit text-secondary" style="font-size: 25px"></i> </a>
      <?php if ($tipoUsuario=='administrador') {
                       if ($idUser==1) {
                        if ($fila['estado']=='Inactivo') {
              ?> 
         <a class='btn ' title="Activar Unidad" href='./eliminarUnidad.php?token=<?php echo $fila['token'];?>'><span class="icon-cancel text-danger" style="font-size: 25px"></span></a><?php  }else{
          ?>
          <a class='btn ' title="Eliminar Unidad" href='./eliminarUnidad.php?token=<?php echo $fila['token'];?>'><span class="icon-checkmark1 text-success" style="font-size: 25px"></span></a>
          <?php 
         }  
              }else{
                ?>
                <a class='btn btn-danger' title="Eliminar Unidad" href='./eliminarUnidad.php?token=<?php echo $fila['token'];?>'><span class="icon-bin text-light" style="font-size: 25px"></span></a>
                <?php 
              }
            }
               ?>
    </div>
    </td>

    <?php
  if($fila['tipoTurno'] == '15 dias'){   

  $sqlI="SELECT infou15.codigoUnidad, unidad.nombreUnidad, horaInicioT, horaFinT, infou15.token FROM `infou15` INNER JOIN unidad ON infou15.codigoUnidad=unidad.codigoUnidad WHERE infou15.codigoUnidad=".$fila['codigoUnidad'];

$nombreUnidad=$conectarBD->query($sqlI)->fetch_assoc()['nombreUnidad'];  
$horaInicioT=$conectarBD->query($sqlI)->fetch_assoc()['horaInicioT'];
$horaFinT=$conectarBD->query($sqlI)->fetch_assoc()['horaFinT'];

?>
<td id="cambio"><div class="dropleft">
  <button type="button" id="icon"  class="btn icon-circle-down text-primary" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" value="1">
  </button>

  <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
  <button class="dropdown-item" type="button">Nombre Unidad <?php echo $nombreUnidad;?></button>
  <button class="dropdown-item" type="button">Hora Inicio Tarde <?php echo $horaInicioT;?></button>
  <button class="dropdown-item" type="button">Hora Fin Tarde <?php echo $horaFinT;?></button>
  </div>
</div>
</td>
<?php
}
?>  
  </tr>


<?php 
 }  ?>
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
<?php
}else {
echo "<div class='container'>";
    die(include '../errorAlgoSM.php');
    echo "</div>";
}
?>
</div>
     
</div>


</body>
<script type="text/javascript" src="../Assets/Jquery/jQuery_v3.4.1.js"></script> 

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
 <script type="text/javascript" src="../Assets/bootstrap-4.3.1-dist/js/bootstrap.min.js"></script> 

<script type="text/javascript">
  $("#cambio button").on("click",function(){
let valor =$(this).val()
console.log(valor)

if (valor =='1'){
$("#cambio button").val('2')
$(this).removeClass('text-primary icon-circle-down').addClass('text-danger icon-circle-up')
}else{
$("#cambio button").val('1')
$(this).removeClass('text-danger icon-circle-up').addClass('text-primary icon-circle-down')
}

})
</script>

<script type="text/javascript">
  function exportarExcel() {
    swal({
  title: "Advertencia",
  text: "¿Desea Exportar Todas las Unidades a Excel?",
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
    window.location="./pdfUnidad.php?E=1";

  } 
});

}

  function exportarPdf() {
    swal({
  title: "Advertencia",
  text: "¿Desea Exportar Todas las Unidades a PDF?",
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
    window.location="./descargarPDFU.php";
  } 
});

}

</script>

</body>

</html>