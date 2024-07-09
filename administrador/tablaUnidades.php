<?php 
require '../conecion.php';
 date_default_timezone_set('America/Bogota');
if($conectarBD->connect_error){
    die("conexion fallida: ".$conectarBD->connect_error);
    
    
}
 ?>
<!DOCTYPE html>
<html>
<head>

	<title>Listar Unidades</title>
  <link rel="icon" type="image/png" sizes="16x16" href="../situ.png">

</head>
<body class="bg-white" >
  <div align="right"> <?php  echo date("d-m-Y");?></div>
<br>

  <h1 align="center"  style="margin-top: -3%;">  Listar Unidades </h1>
  <?php 
     $sql = "SELECT * FROM unidad WHERE estado=1"; 
  ?>

<div >
<table   width="500" class="" style="background: ; margin-top: 60px;" align="center">
  <tr align='center' style="background-color: #0b56a0;  font-size: 16px; color: white;">
    <th align='center'style="border: black; width: 170px;height: 30px;">Codigo Unidad</th>
    <th align='center'style="border: black; width: 170px;height: 30px;">Nombre Unidad</th>
    <th align='center'style="border: black; width: 170px;height: 30px;">Area</th>
    <th align='center'style="border: black; width: 170px;height: 30px;">Tipo Turno</th>
    <th align='center'style="border: black; width: 170px;height: 30px;">Hora Turno</th>
    <th align='center'style="border: black; width: 170px;height: 30px;">Cantidad Aprendices</th>
    </tr>
 <?php
 
     
if( $conectarBD->query($sql)->num_rows > 0){

   foreach ($conectarBD->query($sql) as $fila){
 
    ?>
      
     
  <tr  align='center' class='font-weight-bold' scope='row'>
    <td style="border: black;font-size: 20px;height: 25px; width: 20px;"><?php echo $fila['codigoUnidad'] ;?></td>
    <td style="border: black;font-size: 20px;height: 25px; width: 20px;"><?php echo $fila['nombreUnidad'] ;?></td>
    <td style="border: black;font-size: 20px;height: 25px; width: 20px;"><?php
  $sqlA= "SELECT * FROM area WHERE id_area=".$fila['id_area'];
       if ($conectarBD->query($sqlA)->num_rows > 0){

         foreach ($conectarBD->query($sqlA) as $value){
          $nombreArea= $value['nombreArea'];
        }
}
    echo $nombreArea;
  
     ?></td>
     <td style="border: black;font-size: 20px;height: 25px; width: 20px;"><?php echo $fila['tipoTurno'] ;?></td>
     <td style="border: black;font-size: 20px;height: 25px; width: 20px;"><?php echo $fila['horaT'] ;?></td>
     <td style="border: black;font-size: 20px;height: 25px; width: 20px;"><?php echo $fila['cantidadAprendices'] ;?></td>
   </tr>

  <?php
  }
}
 ?>        </table>
       </div>

</body>

</html>