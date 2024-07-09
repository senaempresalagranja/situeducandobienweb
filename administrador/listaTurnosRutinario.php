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
<?php require '../navAdmi.php';?>
 <title>lista de Turnos Rutinarios</title>
 <link rel="icon" type="image/png" sizes="16x16" href="../situ.png">
 <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="./estilos.css">
  <link rel="stylesheet" type="text/css" href="../Assets/fonts/style.css">
 
</head>
<body class=" bg-white">
<?php require '../navegacion.php';

  $sqlFecha = "SELECT * FROM turnorutinario ORDER BY fechaTurno DESC";
  $sqlFicha = "SELECT * FROM Ficha ORDER BY id_ficha ASC";
?>
<br>
<div>
  <div  style="margin-top: 2px; margin-left: 120px;">
 <a href="turnoManualR.php" class="btn btn-success font-weight-bold" title="Crear Turno"><span class="icon-plus1"></span> T. Rutinario</a>
</div>
  <h1 align="center" class="font-weight-bold" style="margin-top: -3%;">  Turnos Rutinarios  </h1>
    <form class="form-inline float-right" action="buscarTurnosRuti.php" method="get" style="margin-top: -40px; margin-right: 35px;" >
          <input class="form-control mr-sm-2 border border-dark" type="text" name="busqueda" id="busqueda" placeholder="Buscar">
         
        </form></h1>
   </div>  

     <div  style="margin-left: 120px; margin-top: -10px;">
       <form  action="buscarTurnosRuti.php" method="get"  >     
          <select  class="form-control  col-md-2 border border-dark"  name="fechaTurno" id="fechaTurno" onchange='this.form.submit()'>
                <option value="0"> Seleccionar Trimestre</option>
                <option value="1">1 Trimestre</option>
                <option value="2">2 Trimestre</option>
                <option value="3">3 trimestre</option>
                <option value="4">4 trimestre</option>
          </select>
      <noscript><input type="submit" value="Submit"></noscript>                      
                      </form>
                  </div>
 <div  style="margin-left: 120px; margin-top: 10px;">
       <form  action="buscarTurnosRuti.php" method="get"  >
                
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

<?php


if($conectarBD->connect_error){
    die("conexion fallida: ".$conectarBD->connect_error);
    
    
}

 $registrosIN="SELECT COUNT(*) AS totalRegistros FROM turnorutinario WHERE estado = 0";
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

    if ($idUser==1) {
 $sql = "SELECT turnorutinario.codigoTurno,turnorutinario.id_aprendiz,turnorutinario.id_ficha, turnorutinario.id_area, turnorutinario.codigoTurno, turnorutinario.tipoTurno, turnorutinario.fechaTurno,turnorutinario.estado,turnorutinario.fallas,turnorutinario.token, unidad.nombreUnidad, unidad.horaInicioM, unidad.horaFinM,area.nombreArea, infou15.horaInicioT, infou15.horaFinT FROM `turnorutinario`INNER JOIN unidad ON unidad.codigoUnidad=turnorutinario.codigoUnidad INNER JOIN area ON area.id_area=turnorutinario.id_area LEFT JOIN infou15 ON unidad.codigoUnidad=infou15.codigoUnidad AND infou15.estado=1 AND unidad.estado=1  LIMIT $desde,$canPagina";
}else{
  $sql = "SELECT turnorutinario.codigoTurno,turnorutinario.id_aprendiz,turnorutinario.id_ficha, turnorutinario.id_area, turnorutinario.codigoTurno, turnorutinario.tipoTurno, turnorutinario.fechaTurno,turnorutinario.estado,turnorutinario.fallas,turnorutinario.token, unidad.nombreUnidad, unidad.horaInicioM, unidad.horaFinM,area.nombreArea, infou15.horaInicioT, infou15.horaFinT FROM `turnorutinario`INNER JOIN unidad ON unidad.codigoUnidad=turnorutinario.codigoUnidad INNER JOIN area ON area.id_area=turnorutinario.id_area INNER JOIN infou15 ON unidad.codigoUnidad=infou15.codigoUnidad AND infou15.estado=1 AND turnorutinario.estado=1 AND unidad.estado=1  LIMIT $desde,$canPagina";
}
?>
 
<div align="right" style="margin-top: -60px; margin-right: 48px; ">
  <h5>Total Turnos:
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

<div align="right" style="margin-top: -15px; margin-right: 48px; ">
  <h5> Registros Inactivos:
<span class="text-danger font-weight-bold">
  <?php 
echo $registrosI;
  }
  ?>
  </span>
</h5>
</div>

<div style="margin-left: 105px; margin-top: 20px;">

<a onclick="exportarPdf()" title="Exportar a PDF" class="btn"  style="font-size: 40px; cursor: pointer;" >
  <i class="icon-file-pdf text-danger"></i> <span></span></a>

  <a onclick="exportarExcel()"  title="Exportar a EXCEL" class="btn"  id="pdf" style="font-size: 40px; margin-left: -20px; cursor: pointer; " >
  <span class="icon-file-excel text-success"></span></a>

  <a href="descargarPDF1.php"  title="Imprimir" class="btn"  id="pdf" style="font-size: 30px; margin-left: -20px; cursor: pointer; " >
  <span class="icon-printer text-dark"></span></a>
</div>


<div class="container">
<table class='table table-hover table-light '>
  <tr align='center' class='bg-primary '>
    <th>DOCUMENTO</th>
    <th>FICHA</th>
    <th>AREA</th>
    <th>UNIDAD</th>
     <th>TIPO DE TURNO</th>
    <th>FECHA TURNO</th>
    <th>HORA INICIO</th>
    <th>HORA FIN</th>
      <th>FALLAS</th>
    <th>ASISTENCIAS</th>
    <?php if ($idUser==1) { ?>
    <th>ESTADO</th>
    <?php } ?>
    <th> ACCIONES</th>
  </tr>
  <?php

if($conectarBD->query($sql)->num_rows > 0){

   foreach ($conectarBD->query($sql) as $fila){
 
    ?>      
  <tr  align='center' class='font-weight-bold' scope='row'>
    <td><?php echo $fila['id_aprendiz'] ;?></td>
    <td><?php echo $fila['id_ficha'];?></td>
    <td><?php echo $fila['nombreArea'] ?></td>
    <td><?php echo $fila['nombreUnidad'] ?></td>
    <td><?php echo $fila['tipoTurno'];?></td>
    <td><?php echo $fila['fechaTurno'];?></td>
    <td><?php echo $fila['horaInicioM'];?></td>
    <td><?php echo $fila['horaFinM'];?></td>
    <td><?php echo $fila['fallas'];?></td>
    <td  align='center' class='font-weight-bold'>   
  <i class='btn icon-checkmark1 text-success' style="font-size: 20px;" href ='#' onclick='confirmar1(<?php echo $fila['codigoTurno'];?>)' onclick='this.disabled="disabled"'></i></td>
    
     <?php if ($idUser==1) { ?>
  <td>
  <?php
    switch ($fila['estado']) {
      case '1':
        $fila['estado']="Activo";
        ?>
        <span class="text-success"><?php echo $fila['estado'];?></span>
        <?php break;
      
        case '0':
        $fila['estado']="Inactivo";

         ?>
        <span class="text-danger"><?php echo $fila['estado'];?></span>
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

      <a class='btn ' href='./TurnoManualE.php?token=<?php echo $fila['token'];?>' title="Editar Turno Rutinario"><span class="icon-edit text-secondary" style="font-size: 25px;"></span> </a>

 <?php if ($tipoUsuario=='administrador') {
   if ($idUser==1) {
         if ($fila['estado']=='Activo') {
           ?>
            <a  class='btn '  title="Eliminar Turno Rutinario" href ="./eliminarTurnoRutinario.php?token=<?php echo $fila['token'];?>"><span class="icon-checkmark1 text-success" style="font-size: 25px;" ></span></a>
           <?php
         }else{
          ?>
           <a  class='btn'  title="Activar Turno Rutinario" href ="./eliminarTurnoRutinario.php?token=<?php echo $fila['token'];?>"><span class="icon-cancel text-danger" style="font-size: 25px;"></span></a>
          <?php
         }
  }else{?>
     <a  class='btn btn-danger' title=" Turno Rutinario" href="./eliminarTurnoRutinario.php?token=<?php echo $fila['token'];?>"><span class="icon-bin text-light" style="font-size: 20px;"></span></a>
    <?php
      }}
      ?>
          <?php if ($fila['tipoTurno']=="15 dias") {
      
    ?>
 <div class="dropleft" id="cambio">
  <button type="button" id="icon"  class="btn icon-circle-down text-primary" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" value="1">
  </button>

  <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
  <button class="dropdown-item" type="button">Hora Inicio Tarde <?php echo $fila['horaInicioT'];?></button>
  <button class="dropdown-item" type="button">Hora Fin Tarde <?php echo $fila['horaFinT'];?></button>
  </div>
</div>
<?php }?>
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
                <a class="page-link font-weight-bold" href="?pagina=<?php echo 1;?>" >INICIO</a>
              </li>
              <li class="page-item">
                <a class="page-link" href="?pagina=<?php echo $pagina -1;?>" ><span class="icon-circle-left text-primary"></span></a>
              </li>
              <?php 
            }
              

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

            
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

<script type="text/javascript" src="../Assets/sweetalert2/sweetalert2.all.min.js"></script>

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

<script type="text/javascript">
function exportarExcel() {
 
const swalWithBootstrapButtons = Swal.mixin({
  customClass: {
    confirmButton: 'btn btn-success',

    cancelButton: 'btn btn-danger'
  },
  buttonsStyling: false
})


swalWithBootstrapButtons.fire({
  title: "¿Desea Exportar Todas los Turnos Rutinarios a Excel?",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonText: 'Si',
  cancelButtonText: 'No',
  reverseButtons: true
}).then((result) => {
  if (result.value) {
    window.location.href="pdfTurnoR.php?E=1";
}else if (
    
    result.dismiss === Swal.DismissReason.cancel
  ) {
    swalWithBootstrapButtons.fire(
      'Cancelado',
      'No será exportado',
      'error'
    )
  }
})
}

  function exportarPdf() {
 
const swalWithBootstrapButtons = Swal.mixin({
  customClass: {
    confirmButton: 'btn btn-success',

    cancelButton: 'btn btn-danger'
  },
  buttonsStyling: false
})


swalWithBootstrapButtons.fire({
  title: "¿Desea Exportar Todas los Turnos Rutinarios a PDF?",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonText: 'Si',
  cancelButtonText: 'No',
  reverseButtons: true
}).then((result) => {
  if (result.value) {
    window.location.href="descargarPDFTR.php";
}else if (
    
    result.dismiss === Swal.DismissReason.cancel
  ) {
    swalWithBootstrapButtons.fire(
      'Cancelado',
      'No será exportado',
      'error'
    )
  }
})
}
</script>


</body>
</html>
    

 