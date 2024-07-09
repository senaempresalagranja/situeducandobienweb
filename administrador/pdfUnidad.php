<?php 
session_start();
require '../conecion.php';

require '../Assets/funcion.php';

date_default_timezone_set('America/Bogota');







$idUser = $_SESSION['id'];

$tipoUsuario = $_SESSION['tipo'];

    if (empty($_SESSION['tipo'])) {

echo "<script>window.location.href='../index.php'; </script>";   

    }

if(isset($_GET['busqueda'])){

$busqueda=$_GET['busqueda'];

 $sql="SELECT unidad.codigoUnidad, unidad.nombreUnidad, unidad.id_area, area.nombreArea, unidad.horaInicioM, unidad.horaFinM, unidad.tipoTurno, unidad.cantidadAprendices, unidad.estado FROM `unidad` INNER JOIN area ON unidad.id_area=area.id_area WHERE ( 

    area.nombreArea LIKE '%$busqueda%' OR

    unidad.codigoUnidad  LIKE '%$busqueda%' OR

    unidad.nombreUnidad  LIKE '%$busqueda%' OR  

    unidad.horaInicioM LIKE '%$busqueda%' OR

    unidad.horaFinM LIKE '%$busqueda%' OR

    unidad.tipoTurno LIKE '%$busqueda%' OR

    unidad.cantidadAprendices LIKE '%$busqueda%')

  AND unidad.estado=1  ORDER BY `unidad`.`codigoUnidad` ASC";

}



if(isset($_REQUEST['E'])){

   $E=$_REQUEST['E'];

  if(isset($busqueda)){

 header ('content-type:aplication/xls');  

  header ('Content-Disposition: attachment; filename=busquedaUnidades.xls'); 





}else{

header ('content-type:aplication/xls');  

  header ('Content-Disposition: attachment; filename=listaUnidades.xls'); 



}

}



if(!isset($_GET['busqueda'])){

$sql="SELECT unidad.codigoUnidad, unidad.nombreUnidad, unidad.id_area, area.nombreArea, unidad.horaInicioM, unidad.horaFinM, unidad.tipoTurno, unidad.cantidadAprendices, unidad.estado FROM `unidad` INNER JOIN area ON unidad.id_area=area.id_area WHERE unidad.estado=1 ORDER BY `unidad`.`codigoUnidad` ASC";

  

}



    ?>



<?php if(!isset($E)){ ?>

<div class="container"> <div style="margin-left: 10px;">

<img src="../situ.png" width="100" height="100">

  <h3 > <?php  echo date("d-m-Y");?> </h3></div>

  <?php } ?>



<h1 align="center" style="font-weight: bold; text-transform: uppercase;"> <?php if(isset($busqueda)){ echo "Busqueda"; }else{ echo "Lista"; } ?>  de Unidades</h1>





<table  width="500" class="" style="background: ; margin-top: 60px;" align="center" >

  <tr align='center' style="background-color: #0b56a0;  font-size: 16px; color: white; text-transform: uppercase;" >

    <th align='center'style="border: black; width: 170px;height: 25px;">Codigo Unidad</th>

    <th align='center'style="border: black; width: 170px;height: 25px;">Nombre Unidad</th>

    <th align='center'style="border: black; width: 170px;height: 25px;">Area</th>

    <th align='center'style="border: black; width: 170px;height: 25px;">Tipo Turno</th>

    <th align='center'style="border: black; width: 170px;height: 25px;">Cantidad Aprendices</th>

    <th align='center'style="border: black; width: 170px;height: 25px;" colspan="2">Hora Turno</th>



</tr>

 <?php

    

     

if( $conectarBD->query($sql)->num_rows > 0){



   foreach ($conectarBD->query($sql) as $fila){

 

    ?>

      

     

  <tr  align='center' style="text-transform: uppercase;" scope='row'>

    <td style="border:  1px;font-size: 20px;height: 25px; width: 20px;"><?php echo $fila['codigoUnidad'];?></td>

    <td style="border:  1px;font-size: 20px;height: 50px; width: 60px;">

      <?php if(isset($E)){  echo utf8_decode($fila['nombreUnidad']);}else{ echo $fila['nombreUnidad'];}?>

    </td>



    <td style="border:  1px;font-size: 20px;height: 25px; width: 20px;">

      <?php  if(isset($E)){  echo utf8_decode($fila['nombreArea']);}else{ echo $fila['nombreArea'];}?>

    </td>

    <td style="border:  1px;font-size: 20px;height: 15px; width: 10px;"><?php echo $fila['tipoTurno'];?></td>

    <td style="border:  1px;font-size: 20px;height: 15px; width: 10px;"><?php echo $fila['cantidadAprendices'] ;?></td>

    <td style="border:  1px;font-size: 20px;height: 15px; width: 10px;"><?php echo $fila['horaInicioM'];?></td>

    <td style="border:  1px;font-size: 20px;height: 15px; width: 10px;"><?php echo $fila['horaFinM'];?></td> 

   </tr>

     <?php 



}

}

     ?>   

   </table>

<br>

   <?php   

if(isset($busqueda)){

  $sqlI="SELECT * FROM infou15 INNER JOIN unidad ON infou15.codigoUnidad=unidad.codigoUnidad INNER JOIN area ON unidad.id_area= area.id_area WHERE area.nombreArea LIKE '%$busqueda%' OR unidad.nombreUnidad LIKE '%$busqueda%' OR infou15.horaInicioT LIKE '%$busqueda%' OR infou15.horaFinT LIKE '%$busqueda%' ";



}else{

   $sqlI="SELECT * FROM infou15 INNER JOIN unidad ON infou15.codigoUnidad=unidad.codigoUnidad";

}         

  if($conectarBD->query($sqlI)->num_rows > 0){

?>

<h1 align="center" style="text-transform: uppercase; height: 40px; width: 40px;"><?php if(isset($E)){ echo utf8_decode('Información');}else{echo "Información";}  ?> de Unidades 15 Dias</h1>

<table  width="500" class="" style="background: ; margin-top: 60px;" align="center" >

  <tr align='center' style="background-color: #0b56a0;  font-size: 16px; color: white; text-transform: uppercase;" >

    <th align='center'style="border: black; width: 170px;height: 30px;">Nombre Unidad</th>

    <th align='center'style="border: black; width: 170px;height: 30px;">Hora Inicio T</th>

    <th align='center'style="border: black; width: 170px;height: 30px;">Hora Fin T</th>

</tr>





<?php

    foreach ($conectarBD->query($sqlI) as $info15) {



?>           

  <tr  align='center' style="text-transform: uppercase;" scope='row'>

    <td style="border:  1px;font-size: 20px;height: 50px; width: 60px;">

      <?php if(isset($E)){  echo utf8_decode($info15['nombreUnidad']);}else{ echo $info15['nombreUnidad'];}?>

    </td>

   <td style="border:  1px;font-size: 20px;height: 25px; width: 20px;"> <?php echo $info15['horaInicioT']; ?> </td>

   <td style="border:  1px;font-size: 20px;height: 25px; width: 20px;"> <?php echo $info15['horaFinT']; ?> </td>

  

      

</tr>

 <?php  

    } 

?>

</table>



 <?php  

    } 

?>

</div>