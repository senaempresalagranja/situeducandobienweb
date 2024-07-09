
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
      <html>
<head>
  <meta charset="utf-8"><style type="text/css">
        .confi{
    height: 30px;

  }
      </style>
    <?php require '../navAdmi.php'; ?>
<title>Busqueda de Turno Especial</title>
<link rel="icon" type="image/png" sizes="16x16" href="../situ.png">
  
   <link rel="stylesheet" type="text/css" href="./estilos.css">
  <link rel="stylesheet" type="text/css" href="../Assets/fonts/style.css">
  <link rel="stylesheet" type="text/css" href="
  ../Assets/bootstrap-4.3.1-dist/css/bootstrap.min.css
">
</head>
<body class=" bg-white">
<?php require '../navegacion.php';
   $sqlFicha = "SELECT * FROM ficha ORDER BY id_ficha ASC";

?>
<br><br>

    <div  style="margin-top: 2px; margin-left: 140px;">
 <a href="listarTurnosEspeciales.php" class="btn btn-warning text-light font-weight-bold">Todos los Turnos</a>
</div>

  <h1 align="center" class="font-weight-bold" style="margin-top: -3%; ">  Listar Turnos Especiales </h1>
    <form class="form-inline float-right" action="buscarTurno.php" method="get" style="margin-top: -40px; margin-right: 131px;" >
          <input class="form-control mr-sm-2 border border-dark" type="text" value="<?php if(isset($_REQUEST['busqueda'])){echo $_REQUEST['busqueda'];} ?>" name="busqueda" id="busqueda" placeholder="Buscar">
         
        </form></h1>


     <div  style="margin-left: 140px; margin-top: -10px;">
       <form  action="buscarTurno.php" method="get"  >
                
                          <select  class="form-control  col-md-2 border border-dark"  name="id_ficha" id="id_ficha" onchange='this.form.submit()'>
                          
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
<br>
<div style="margin-left: 140px; margin-top: -40px;">

<a onclick="exportarPdf()" title="Exportar a PDF" class="btn"  style="font-size: 40px; " >
  <span class="icon-file-pdf text-danger"></span></a>
  <a  onclick="exportarExcel()" title="Exportar a EXCEL" class="btn"  id="pdf" style="font-size: 40px; margin-left: -20px " >
  <span class="icon-file-excel text-success"></span></a>

</div>


<?php
            if (isset($_REQUEST['id_ficha'])) {
              
          if (!empty($_REQUEST['id_ficha'])) {
             $id_ficha=$_REQUEST['id_ficha'];
                $registros="SELECT COUNT(*) AS totalRegistros FROM turnoespecial WHERE id_ficha= '$id_ficha'";
            if (!empty($registros)) {
              
          if( $conectarBD->query($registros)->num_rows > 0){

           foreach ($conectarBD->query($registros) as $fila){
            if (!empty($fila['totalRegistros'])) {
             
          $totalRegistros=$fila['totalRegistros'];
          $canPagina= 5;

          if (empty($_GET['pagina'])) {
            $pagina= 1;
          }else{
            $pagina=$_GET['pagina'];
          }
          $desde=($pagina-1)*$canPagina;

          $totalPaginas=ceil($totalRegistros/$canPagina);

        }}}
          if (isset($desde)) {
            if (isset($canPagina)) {
            
          
$sql = "SELECT turnoespecial.idTurnoEspecial, turnoespecial.token, turnoespecial.id_ficha, area.nombreArea, unidad.nombreUnidad, turnoespecial.fechaTurnoEspecial, turnoespecial.horaInicio, turnoespecial.horaFin, turnoespecial.estado FROM turnoespecial INNER JOIN area ON turnoespecial.id_area=area.id_area INNER JOIN unidad ON turnoespecial.codigoUnidad=unidad.codigoUnidad WHERE turnoespecial.id_ficha='$id_ficha'
       LIMIT $desde,$canPagina"; 

?>



<div class="container">
  <br>
<div align="right" style="margin-top: -40px; margin-right: 13px;">
  <h5>Total Busqueda:
<span class="text-primary font-weight-bold">
  <?php 
echo $totalRegistros;
  ?>
  </span>
</h5>
</div>

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
if( $conectarBD->query($sql)->num_rows > 0){

   foreach ($conectarBD->query($sql) as $value){
 
    ?>


     <tr align='center' class='font-weight-bold' scope='row'>
    <td> <?php echo $value['idTurnoEspecial']; ?> </td>
    <td><?php echo $value['id_ficha'];?></td>
    <td><?php echo $value['nombreArea'];?></td>
    <td><?php echo $value['nombreUnidad'];?></td>
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

      <a class='btn btn-secondary' href='./editarTurnoEspecial.php?token=<?php echo $value['token'];?>' title="Editar Turno Rutinario"><span class="icon-edit"></span> </a>

 <?php if ($tipoUsuario=='administrador') {
   if ($idUser==1) {
         if ($value['estado']=='Activo') {
           ?>
            <a  class='btn ' href ="./eliminarTurnoEspecial.php?token=<?php echo $value['token'];?>"><span class="icon-checkmark1 text-success" style="font-size: 25px;" ></span></a>
           <?php
         }else{
          ?>
           <a  class='btn' href ="./eliminarTurnoEspecial.php?token=<?php echo $value['token'];?>"><span class="icon-cancel text-danger" style="font-size: 25px;"></span></a>
          <?php
         }
  }else{?>
     <a  class='btn btn-danger' href ="./eliminarTurnoEspecial.php?token=<?php echo $value['token'];?>"><span class="icon-bin text-light" style="font-size: 20px;"></span></a>
    <?php
      }}
      ?>
    </div>   
      
    </td>
  </tr>
<?php 
              }
            } 
           }
          }
         }  
           ?>

            </table>
</div>
            <br>
            <?php 

            if (!empty($totalRegistros)) {
          
            if ($totalRegistros!=0)
             {
  
             ?>
            <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
              <?php 
                if ($pagina!=1) {
                
              ?>
              <li class="page-item">
                <a class="page-link font-weight-bold" href="?pagina=<?php echo 1;?>&id_ficha=<?php echo $id_ficha; ?>" >INICIO</a>
              </li>
              <li class="page-item">
                <a class="page-link" href="?pagina=<?php echo $pagina -1;?>&id_ficha=<?php echo $id_ficha; ?>" ><span class="icon-circle-left text-primary"></span></a>
              </li>
              <?php 
            }
              for ($i=1; $i <= $totalPaginas ; $i++) { 
                if ($i == $pagina) {
                  echo '<li class="page-item page-link bg-success text-light">'.$i.'</li>' ;
                }else{
               echo '<li class="page-item"><a class="page-link" href="?pagina='.$i.'&id_ficha='.$id_ficha.'">'.$i.'</a></li>';
              }}

              if ($pagina !=$totalPaginas) {
              
               ?>
              <li class="page-item">
                <a class="page-link" href="?pagina=<?php echo $pagina +1;?>&id_ficha=<?php echo $id_ficha; ?>"><span class="icon-circle-right text-primary"></span></a>
              </li>
              <li class="page-item">
                <a class="page-link font-weight-bold" href="?pagina=<?php echo $totalPaginas;?>&id_ficha=<?php echo $id_ficha; ?>">FIN</a>
              </li>
              <?php
               } 
              ?>
            </ul>
          </nav>
        <?php
         } } else{
              echo '<h1 align="center">No se ha Encontrado Ningun Resultado</h1><br>
              <div align="center"></div>';

          }
          ?>
            

<?php 

 }
        }else{?>


            <br>
            <br>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8"><style type="text/css">
        .confi{
    height: 30px;

  }
      </style>
   
  <title>lista de Usuarios</title>
   <link rel="stylesheet" type="text/css" href="./estilos.css">
  <link rel="stylesheet" type="text/css" href="../Assets/fonts/style.css">
  <link rel="stylesheet" type="text/css" href="
  ../Assets/bootstrap-4.3.1-dist/css/bootstrap.min.css
">
</head>
<body class=" bg-light">
<?php


require_once '../conecion.php';
    if (isset($_REQUEST['busqueda'])) {
      
    
    $busqueda=strtolower($_REQUEST['busqueda']);
    if (empty($busqueda)){
     
    }
}


          if (isset($busqueda)) {
            
         
          $registros="SELECT COUNT(*) AS totalRegistros FROM turnoespecial INNER JOIN area ON turnoespecial.id_area=area.id_area INNER JOIN unidad ON turnoespecial.codigoUnidad=unidad.codigoUnidad WHERE (turnoespecial.idTurnoEspecial LIKE '%$busqueda%' OR turnoespecial.id_ficha LIKE '%$busqueda%' OR area.nombreArea LIKE '%$busqueda%' OR unidad.codigoUnidad LIKE '%$busqueda%' OR unidad.nombreUnidad LIKE '%$busqueda%' OR turnoespecial.fechaTurnoEspecial LIKE '%$busqueda%' OR turnoespecial.horaInicio LIKE '%$busqueda%' OR turnoespecial.horaFin LIKE '%$busqueda%' )
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

$sql = "SELECT turnoespecial.idTurnoEspecial, turnoespecial.token, turnoespecial.id_ficha, area.nombreArea, unidad.nombreUnidad, turnoespecial.fechaTurnoEspecial, turnoespecial.horaInicio, turnoespecial.horaFin, turnoespecial.estado FROM turnoespecial INNER JOIN area ON turnoespecial.id_area=area.id_area INNER JOIN unidad ON turnoespecial.codigoUnidad=unidad.codigoUnidad WHERE (turnoespecial.idTurnoEspecial LIKE '%$busqueda%' OR turnoespecial.id_ficha LIKE '%$busqueda%' OR area.nombreArea LIKE '%$busqueda%' OR unidad.codigoUnidad LIKE '%$busqueda%' OR unidad.nombreUnidad LIKE '%$busqueda%' OR turnoespecial.fechaTurnoEspecial LIKE '%$busqueda%' OR turnoespecial.horaInicio LIKE '%$busqueda%' OR turnoespecial.horaFin LIKE '%$busqueda%' ) LIMIT $desde, $canPagina"; 

?>
<div class="container">
    <br>
<div align="right" style="margin-top: -90px; margin-right: 13px;">
  <h5>Total Busqueda:
<span class="text-primary font-weight-bold">
  <?php 
echo $totalRegistros;
  ?>
  </span>
</h5>
</div>
 

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
if( $conectarBD->query($sql)->num_rows > 0){

   foreach ($conectarBD->query($sql) as $value){
 
    ?>


     <tr align='center' class='font-weight-bold' scope='row'>
    <td> <?php echo $value['idTurnoEspecial']; ?> </td>
    <td><?php echo $value['id_ficha'];?></td>
    <td><?php echo $value['nombreArea'];?></td>
    <td><?php echo $value['nombreUnidad'];?></td>
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

      <a class='btn btn-secondary' href='./editarTurnoEspecial.php?token=<?php echo $value['token'];?>' title="Editar Turno Rutinario"><span class="icon-edit"></span> </a>

 <?php if ($tipoUsuario=='administrador') {
   if ($idUser==1) {
         if ($value['estado']=='Activo') {
           ?>
            <a  class='btn ' href ="./eliminarTurnoEspecial.php?token=<?php echo $value['token'];?>"><span class="icon-checkmark1 text-success" style="font-size: 25px;" ></span></a>
           <?php
         }else{
          ?>
           <a  class='btn' href ="./eliminarTurnoEspecial.php?token=<?php echo $value['token'];?>"><span class="icon-cancel text-danger" style="font-size: 25px;"></span></a>
          <?php
         }
  }else{?>
     <a  class='btn btn-danger' href ="./eliminarTurnoEspecial.php?token=<?php echo $value['token'];?>"><span class="icon-bin text-light" style="font-size: 20px;"></span></a>
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
                <a class="page-link font-weight-bold" href="?pagina=<?php echo 1;?>&busqueda=<?php echo $busqueda; ?>" >INICIO</a>
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
              echo '<h1 align="center">No se ha Encontrado Ningun Resultado</h1><br></div>';

          }
        }}
          ?>
            


            <br>
            <br>

<script type="text/javascript" src="../Assets/Jquery/jQuery_v3.4.1.js"></script>
<script type="text/javascript" src="../Assets/bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>

<script type="text/javascript">
  function exportarExcel() {
    
    swal({
  title: "Advertencia",
  text: "¿Está Seguro de exportar <?php echo $totalRegistros; ?> Registros de la busqueda de Turnos Especiales a Excel?",
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
    window.location.href="./pdfTurnoE.php?E=1&<?php if(isset($_REQUEST['busqueda'])){?>busqueda=<?php echo $_REQUEST['busqueda'];} if(isset($id_ficha)){?>id_ficha=<?php echo $_REQUEST['id_ficha'];} ?>";
  } 
});

}

  function exportarPdf() {
    swal({
  title: "Advertencia",
  text: "¿Está Seguro de exportar <?php echo $totalRegistros; ?> Registros de la busqueda de Turnos Especiales a PDF?",
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
   
    window.location.href="./descargarPDFTE.php?<?php if(isset($_REQUEST['busqueda'])){?>busqueda=<?php echo $_REQUEST['busqueda'];} if(isset($id_ficha)){?>id_ficha=<?php echo $_REQUEST['id_ficha'];} ?>";
  } 
});

}
</script>
</body>
    
</html>     