<?php 
require '../conecion.php';
require '../Assets/funcion.php';
date_default_timezone_set('America/Bogota');

session_start();
$idUser = $_SESSION['id'];
$tipoUsuario = $_SESSION['tipo'];
    if (empty($_SESSION['tipo'])) {
        echo "<script>window.location.href='../index.php'; </script>";  
    }



if(isset($_GET['busqueda'])){

$busqueda=$_GET['busqueda'];

$sql="SELECT turnorutinario.id_aprendiz, turnorutinario.id_ficha,turnorutinario.id_Area, area.nombreArea, turnorutinario.codigoUnidad, unidad.nombreUnidad, turnorutinario.tipoTurno, turnorutinario.fechaTurno, unidad.horaInicioM, unidad.horaFinM, infou15.horaInicioT, infou15.horaFinT, turnorutinario.fallas, turnorutinario.estado FROM turnorutinario INNER JOIN area ON turnorutinario.id_area=area.id_area INNER JOIN unidad ON turnorutinario.codigoUnidad=unidad.codigoUnidad LEFT JOIN infou15 ON turnorutinario.codigoUnidad=infou15.codigoUnidad WHERE ( unidad.nombreUnidad LIKE '%$busqueda%' OR
  area.nombreArea LIKE '%$busqueda%' OR
  turnorutinario.id_aprendiz  LIKE '%$busqueda%' OR
  turnorutinario.id_ficha  LIKE '%$busqueda%' OR
  turnorutinario.tipoTurno    LIKE '%$busqueda%' OR
  turnorutinario.fechaTurno    LIKE '%$busqueda%' OR
  unidad.horaInicioM   LIKE '%$busqueda%' OR
  unidad.horaFinM LIKE '%$busqueda%') AND turnorutinario.estado=1";
}

if(isset($_REQUEST['E'])){
   $E=$_REQUEST['E'];
  if(isset($busqueda)){
    header('content-type:aplication/xls');
    header('Content-Disposition: attachment; filename=busquedaTurnoR.xls');


}else{
  header('content-type:aplication/xls'); 
  header('Content-Disposition: attachment;filename=listaTurnosR.xls');


}
}


if(isset($_GET['id_ficha'])){
  $id_ficha=$_GET['id_ficha'];
$sql = "SELECT turnorutinario.codigoTurno,turnorutinario.id_aprendiz,turnorutinario.id_ficha, turnorutinario.id_area, turnorutinario.codigoTurno, turnorutinario.tipoTurno, turnorutinario.fechaTurno,turnorutinario.estado,turnorutinario.fallas,turnorutinario.token, unidad.nombreUnidad, unidad.horaInicioM, unidad.horaFinM,area.nombreArea, infou15.horaInicioT, infou15.horaFinT FROM `turnorutinario`INNER JOIN unidad ON unidad.codigoUnidad=turnorutinario.codigoUnidad INNER JOIN area ON area.id_area=turnorutinario.id_area LEFT JOIN infou15 ON unidad.codigoUnidad=infou15.codigoUnidad AND infou15.estado=1 AND unidad.estado=1 WHERE id_ficha= '$id_ficha'";
}


if(isset($_GET['fechaTurno'])){
              date_default_timezone_set('America/Bogota');

  $ano=date('Y');
  $mes=date('m'); 
  $dias=date('d');
  $dia =date('D');

  $fechaTurno=$_REQUEST['fechaTurno'];

switch ($fechaTurno) {
  case '1':
    $fechaI = $ano.'-01-01';
    $fechaF = $ano.'-03-31';

    
    break;

  case '2':
    $fechaI = $ano.'-04-01';
    $fechaF = $ano.'-06-31';
    
    
    break;
  
  case '3':
    $fechaI = $ano.'-07-01';
    $fechaF = $ano.'-09-31';
    
    
    break;

  case '4':
    $fechaI = $ano.'-10-01';
    $fechaF = $ano.'-12-31';
    
    break;
  
  default:
    echo "Ingrese Una Fecha Correcta";
    break;
}

$sql = "SELECT turnorutinario.id_aprendiz, turnorutinario.id_ficha,turnorutinario.id_Area, area.nombreArea, turnorutinario.codigoUnidad, unidad.nombreUnidad, turnorutinario.tipoTurno, turnorutinario.fechaTurno, unidad.horaInicioM, unidad.horaFinM, turnorutinario.estado, unidad.estado, infou15.horaInicioT, infou15.horaFinT, turnorutinario.fallas FROM turnorutinario INNER JOIN area ON turnorutinario.id_area=area.id_area INNER JOIN unidad ON turnorutinario.codigoUnidad=unidad.codigoUnidad LEFT JOIN infou15 ON turnorutinario.codigoUnidad=infou15.codigoUnidad WHERE turnorutinario.estado=1 AND unidad.estado=1 AND fechaTurno BETWEEN '$fechaI' AND '$fechaF'"; 



}


if(!isset($busqueda)){
  if(!isset($id_ficha)){
    if(!isset($fechaTurno)){

$sql = "SELECT turnorutinario.id_aprendiz, turnorutinario.id_ficha,turnorutinario.id_Area, area.nombreArea, turnorutinario.codigoUnidad, unidad.nombreUnidad, turnorutinario.tipoTurno, turnorutinario.fechaTurno, unidad.horaInicioM, unidad.horaFinM, turnorutinario.fallas, turnorutinario.estado, infou15.horaInicioT, infou15.horaFinT FROM turnorutinario LEFT JOIN infou15 ON turnorutinario.codigoUnidad=infou15.codigoUnidad INNER JOIN area ON turnorutinario.id_area=area.id_area INNER JOIN unidad ON turnorutinario.codigoUnidad=unidad.codigoUnidad WHERE turnorutinario.estado=1"; 

    }
  }
}


?>
<?php 
if(!isset($E)){
  ?>

<img src="../situ.png" width="100" height="100">
   <div style="margin-left: 15px;"><h5> <?php  echo date("d-m-Y");?> </h5></div>

<?php
}

if( $conectarBD->query($sql)->num_rows > 0){
$tipoTurno=$conectarBD->query($sql)->fetch_assoc()['tipoTurno'];
 ?>
     
<div style="margin-top: -100px;">
    
<h1 align="center" style="font-weight: bold;"> <?php if(isset($busqueda)){echo "Busqueda"; }else{ echo "Lista"; } ?> de Turnos Rutinarios</h1>
  <table  width="500" class="" style=" margin-top: 60px;" align="center">
            <tr  align='center' style="background-color: #0b56a0;  font-size: 14px; color: white;" >
            <th align='center'style="border: black; width: 80px;height: 20px;">DOCUMENTO</th>
            <th align='center'style="border: black; width: 80px;height: 20px;">FICHA</th>
            <th align='center'style="border: black; width: 80px;height: 20px;">AREA</th>
            <th align='center'style="border: black; width: 90px;height: 20px;">UNIDAD</th>
            <th align='center'style="border: black; width: 80px;height: 20px;">TIPO DE TURNO</th>
            <th align='center'style="border: black; width: 80px;height: 20px;">FECHA TURNO</th>
            <th align='center'style="border: black; width: 80px;height: 20px;">HORA INICIO M</th>
            <th align='center'style="border: black; width: 80px;height: 20px;">HORA FIN M</th>
            <?php if($tipoTurno == '15 dias'){ ?>
            <th align='center'style="border: black; width: 80px;height: 20px;">HORA FIN T</th>
            <th align='center'style="border: black; width: 80px;height: 20px;">HORA FIN T</th>
            <?php } ?>
            <th align='center'style="border: black; width: 80px;height: 20px;">FALLAS</th>
         </tr>
  <?php

   foreach ($conectarBD->query($sql) as $fila){
 
    ?>
      
     
   <tr  align='center' class='font-weight-bold' scope='row'>
    <td style="border: black;font-size: 14px;height: 25px; width: 20px;"><?php echo $fila['id_aprendiz'] ;?></td>
    <td style="border: black;font-size: 14px;height: 25px; width: 20px;"><?php echo $fila['id_ficha'];?></td>
    <td style="border: black;font-size: 14px;height: 25px; width: 20px;"><?php echo $fila['nombreArea'];?></td>
    <td style="border: black;font-size: 12px;height: 55px; width: 50px;" align="center"><?php echo $fila['nombreUnidad'];?></td>
     <td style="border: black;font-size: 14px;height: 25px; width: 20px;"><?php echo $fila['tipoTurno'];?></td>
    <td style="border: black;font-size: 14px;height: 25px; width: 20px;"><?php echo $fila['fechaTurno'];?></td>
    <td style="border: black;font-size: 14px;height: 25px; width: 20px;"><?php echo $fila['horaInicioM'];?></td>
    <td style="border: black;font-size: 14px;height: 25px; width: 20px;"><?php echo $fila['horaFinM'];?></td>
    <?php if($tipoTurno == '15 dias'){ 
        
      ?>
    <td style="border: black;font-size: 14px;height: 25px; width: 20px;"><?php if(isset($fila['horaInicioT'])){ echo $fila['horaInicioT']; }else{ echo "No tiene Turno en la Tarde"; }?></td>
    <td style="border: black;font-size: 14px;height: 25px; width: 20px;"><?php if(isset($fila['horaFinT'])){ echo $fila['horaFinT']; }else{ echo "No tiene Turno en la Tarde"; }?></td>
  <?php 
  } ?>
    <td style="border: black;font-size: 14px;height: 25px; width: 20px;"><?php echo $fila['fallas'];?></td>
   </tr>
     <?php 
}
     ?>

   </table>
   </div>
<?php 
}
?>