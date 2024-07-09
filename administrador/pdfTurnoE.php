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



if(!isset($_GET['busqueda'])){
  if(!isset($_GET['id_ficha'])){
    $sql="SELECT turnoespecial.idTurnoEspecial, turnoespecial.token, turnoespecial.id_ficha, area.nombreArea, unidad.nombreUnidad, turnoespecial.fechaTurnoEspecial, turnoespecial.horaInicio, turnoespecial.horaFin, turnoespecial.estado FROM turnoespecial INNER JOIN area ON turnoespecial.id_area=area.id_area INNER JOIN unidad ON turnoespecial.codigoUnidad=unidad.codigoUnidad";
  }
}


if(isset($_REQUEST['E'])){
   $E=$_REQUEST['E'];
  if(isset($busqueda)){
    header('content-type:aplication/xls');  
   header('Content-Disposition: attachment; filename=busquedaTurnoE.xls');


}else{
  header('content-type:aplication/xls');  
  header('Content-Disposition: attachment;filename=listaTurnosE.xls');
}
}

if(isset($_GET['busqueda'])){
$busqueda=$_GET['busqueda'];


$sql = "SELECT turnoespecial.idTurnoEspecial, turnoespecial.token, turnoespecial.id_ficha, area.nombreArea, unidad.nombreUnidad, turnoespecial.fechaTurnoEspecial, turnoespecial.horaInicio, turnoespecial.horaFin, turnoespecial.estado FROM turnoespecial INNER JOIN area ON turnoespecial.id_area=area.id_area INNER JOIN unidad ON turnoespecial.codigoUnidad=unidad.codigoUnidad WHERE (turnoespecial.idTurnoEspecial LIKE '%$busqueda%' OR turnoespecial.id_ficha LIKE '%$busqueda%' OR area.nombreArea LIKE '%$busqueda%' OR unidad.codigoUnidad LIKE '%$busqueda%' OR unidad.nombreUnidad LIKE '%$busqueda%' OR turnoespecial.fechaTurnoEspecial LIKE '%$busqueda%' OR turnoespecial.horaInicio LIKE '%$busqueda%' OR turnoespecial.horaFin LIKE '%$busqueda%' ) AND turnoespecial.estado=1"; 
}


if(isset($_GET['id_ficha'])){
	$id_ficha=$_GET['id_ficha'];
$sql = "SELECT turnoespecial.idTurnoEspecial, turnoespecial.token, turnoespecial.id_ficha, area.nombreArea, unidad.nombreUnidad, turnoespecial.fechaTurnoEspecial, turnoespecial.horaInicio, turnoespecial.horaFin, turnoespecial.estado FROM turnoespecial INNER JOIN area ON turnoespecial.id_area=area.id_area INNER JOIN unidad ON turnoespecial.codigoUnidad=unidad.codigoUnidad WHERE turnoespecial.id_ficha='$id_ficha'"; 

}


if(isset($_GET['fechaTurno'])){
$fechaTurno=$_GET['fechaTurno'];

$sql = "SELECT * FROM turnorutinario WHERE estado=1 AND fechaTurno='$fechaTurno'"; 
}

?>
<div>
<?php if(!isset($E)){ ?>
 <div style="margin-left: 10px;">
<img src="../situ.png" width="100" height="100">
  <h3 > <?php  echo date("d-m-Y");?> </h3></div>
  <?php } ?>

<h1 align="center" style="font-weight: bold; margin-top: -80px;"><?php if(isset($busqueda )){ echo "Busqueda"; }else{echo "Lista"; } ?> de Turnos Especiales</h1><br><br><br>

  <table  width="500" class="" style=" margin-top: 0px;" align="center">
            <tr  align='center' style="background-color: #0b56a0;  font-size: 14px; color: white;" >
            <th align='center'style="border: black; width: 100px;height: 40px;">CODIGO ESPECIAL</th>
            <th align='center'style="border: black; width: 100px;height: 30px;"><?php if(isset($E)){ echo utf8_decode("N°");}else{ echo "N°";} ?> FICHA</th>
            <th align='center'style="border: black; width: 100px;height: 30px;">AREA</th>
            <th align='center'style="border: black; width: 100px;height: 30px;">UNIDAD</th>
            <th align='center'style="border: black; width: 100px;height: 30px;">FECHA TURNO</th>
            <th align='center'style="border: black; width: 100px;height: 30px;">HORA INICIO</th>
                  <th align='center'style="border: black; width: 200px;height: 30px;">HORA FIN</th>
         </tr>
  <?php
if( $conectarBD->query($sql)->num_rows > 0){

   foreach ($conectarBD->query($sql) as $fila){
    ?>
     
  <tr  align='center' class='font-weight-bold' scope='row'>
    <td style="border: black;font-size: 14px;height: 25px; width: 20px;"><?php echo $fila['idTurnoEspecial'] ;?></td>
    <td style="border: black;font-size: 14px;height: 25px; width: 20px;"><?php echo $fila['id_ficha'];?></td>
    <td style="border: black;font-size: 14px;height: 25px; width: 20px;"><?php if(isset($E)){ echo utf8_decode($fila['nombreArea']);}else{
     echo $fila['nombreArea'];} ?></td>
    <td style="border: black;font-size: 12px;height: 50px; width: 50px;"><?php if(isset($E)){ echo utf8_decode($fila['nombreUnidad']);}else{
     echo $fila['nombreUnidad'];}?></td>
    <td style="border: black;font-size: 14px;height: 25px; width: 20px;"><?php echo $fila['fechaTurnoEspecial'];?></td>
    <td style="border: black;font-size: 14px;height: 25px; width: 20px;"><?php echo $fila['horaInicio'];?></td>
    <td style="border: black;font-size: 14px;height: 25px; width: 20px;"><?php echo $fila['horaFin'];?></td>
   </tr>
     <?php 
}
}
     ?>

   </table>
   </div>
