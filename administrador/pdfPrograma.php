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

$sql="SELECT programas.id_programaF, programas.nombreP, area.nombreArea, programas.id_area, programas.estado, programas.token FROM programas INNER JOIN area ON programas.id_area=area.id_area WHERE ( id_programaF LIKE '%$busqueda%' OR nombreP LIKE '%$busqueda%' OR area.nombreArea LIKE '%$busqueda%' ) AND programas.estado=1 ";                            
}else{
 $sql = "SELECT programas.id_programaF, programas.nombreP, area.nombreArea, programas.id_area, programas.estado, programas.token FROM programas INNER JOIN area ON programas.id_area=area.id_area WHERE programas.estado=1 ";      
}

if(isset($_REQUEST['E'])){
   $E=$_REQUEST['E'];
  if(isset($busqueda)){
  header('content-type:aplication/xls');
  header('Content-Disposition: attachment; filename=busquedaProgramas.xls');


}else{
  header('content-type:aplication/xls');
  header('Content-Disposition: attachment;filename=lista_Programas.xls');

}
}
    ?>

<br>
<?php 
if(!isset($E)){
  ?>
<img src="../situ.png" width="100" height="100">
<?php
}
 ?>
      <div style="margin-left: 10px;"><h3 > <?php  echo date("d-m-Y");?> </h3></div>

<div style="margin-top:-100px;">

<h1 align="center" style="font-weight: bold;text-transform: uppercase;"><?php if(isset($busqueda)){ echo "Busqueda"; }else{ echo "Lista";} ?> de Programas</h1>
<table  width="500" class="" style=" margin-top: 60px;" align="center" >
  <tr align='center' style="background-color: #0b56a0;  font-size: 16px; color: white;" >
    <th align='center'style="border: black; width: 170px;height: 30px; text-transform: uppercase;">Id Programa</th>
    <th align='center'style="border: black; width: 270px;height: 30px; text-transform: uppercase;">Nombre Programa</th>
    <th align='center'style="border: black; width: 170px;height: 30px; text-transform: uppercase;">Area</th>

</tr>
 <?php
    
     
if( $conectarBD->query($sql)->num_rows > 0){

   foreach ($conectarBD->query($sql) as $fila){
    ?>
           
  <tr  align='center' class='font-weight-bold' scope='row'>
    <td style="font-size: 20px;height: 25px; border:solid 1px; width: 20px;text-transform: uppercase;"><?php echo $fila['id_programaF'] ;?></td>
    <td style="font-size: 20px;height: 50px; border:solid 1px; width: 70px;text-transform: uppercase;"><?php if(isset($E)){ echo utf8_decode($fila['nombreP']);}else{echo $fila['nombreP'];}?></td>
    <td style="font-size: 20px;height: 25px; border:solid 1px; width: 20px;text-transform: uppercase;"><?php if(isset($E)){ echo utf8_decode($fila['nombreArea']);}else{ echo $fila['nombreArea'];}?></td>

   </tr>
     <?php 

}
}

     ?>

   </table>
   </div>
