<?php 
require '../conecion.php';
require '../Assets/funcion.php';


session_start();
$idUser = $_SESSION['id'];
$tipoUsuario = $_SESSION['tipo'];
    if (empty($_SESSION['tipo'])) {
       echo "<script>window.location.href='../index.php'; </script>";  
    }

if(isset($_REQUEST['E'])){
   $E=$_REQUEST['E'];
  if(isset($busqueda)){
  header('content-type:aplication/xls');  
  header('Content-Disposition: attachment; filename=busquedaFicha.xls');


}else{
 header('content-type:aplication/xls');  
  header('Content-Disposition: attachment; filename=listaFichas.xls'); 


}
}

if(isset($_GET['busqueda'])){
$busqueda=$_GET['busqueda'];



     $sql = "SELECT ficha.id_ficha, ficha.token, programas.nombreP, area.nombreArea, ficha.cantidad_aprendices, ficha.inicio_formacion, ficha.fin_formacion, ficha.estado, ficha.estadoSE FROM `ficha` INNER JOIN programas ON ficha.id_programaF=programas.id_programaF INNER JOIN area ON ficha.id_area=area.id_area  WHERE( ficha.id_ficha LIKE '%$busqueda%' OR 
                                    programas.nombreP  LIKE '%$busqueda%'OR 
                                   area.nombreArea LIKE '%$busqueda%' OR
                                   ficha.cantidad_aprendices LIKE '%$busqueda%' OR
                                   ficha.inicio_formacion LIKE '%busqueda%' OR
                                   ficha.fin_formacion LIKE '%$busqueda%' )
                                  AND ficha.estado = 1 "; 
}else{
  $sql="SELECT ficha.id_ficha, ficha.token, programas.nombreP, area.nombreArea, ficha.cantidad_aprendices, ficha.inicio_formacion, ficha.fin_formacion, ficha.estado, ficha.estadoSE FROM `ficha` INNER JOIN programas ON ficha.id_programaF=programas.id_programaF INNER JOIN area ON ficha.id_area=area.id_area";
}

?>

<?php 
if(!isset($E)){
  ?>
<img src="../situ.png" width="100" height="100">
<?php
}
 ?>
<div style="margin-left: 10px;">
    <h3> <?php  echo date("d-m-Y");?> </h3>
</div>

<div style="margin-top: -100px;">
    <h1 align="center" style="font-weight: bold;"><?php if(isset($busqueda)){ echo "Busqueda";}else{echo "Lista";} ?> de
        Fichas</h1>
    <table width="500" class="" style=" margin-top: 60px;" align="center">
        <tr align='center' style="background-color: #0b56a0;  font-size: 16px; color: white;">
            <th align='center' style="border: black; width: 120px;height: 50px;">
                <?php if(isset($E)){ echo utf8_decode("N°");} else{ echo "N°";}?>Ficha</th>
            <th align='center' style="border: black; width: 140px;height: 60px;">
                <?php if(isset($E)){echo utf8_decode("Nombre Programa de Formación");}else{echo "Nombre Programa de Formación"; } ?>
            </th>
            <th align='center' style="border: black; width: 120px;height: 50px;">Area</th>
            <th align='center' style="border: black; width: 120px;height: 50px;">Cantidad Aprendices</th>
            <th align='center' style="border: black; width: 120px;height: 50px;">Inicio
                <?php if(isset($E)){echo utf8_decode("Formación");}else{ echo "Formación";} ?></th>
            <th align='center' style="border: black; width: 120px;height: 50px;">Fin Formacion</th>
            <th align='center' style="border: black; width: 200px;height: 50px;">Sena Empresa</th>
        </tr>
        <?php
if( $conectarBD->query($sql)->num_rows > 0){

   foreach ($conectarBD->query($sql) as $value){
 
    ?>


        <tr align='center' style='font-weight: bold' scope='row'>
            <td style="border: black;font-size: 16px;height: 25px; width: 20px;"><?php echo $value['id_ficha'];?></td>
            <td style="border: black;font-size: 16px;height: 70px; width: 170px;">
                <?php if(isset($E)){ echo utf8_decode($value['nombreP']);}else{echo $value['nombreP'];}?>
            </td>
            <td style="border: black;font-size: 16px;height: 25px; width: 20px;">
                <?php if(isset($E)){ echo utf8_decode($value['nombreArea']);}else{ echo $value['nombreArea'];}?>
            </td>
            <!--   <td style="border: black;font-size: 16px;height: 25px; width: 20px;"><?php //echo $value['cantidad_aprendices'];?></td> -->
            <td style="border: black;font-size: 16px;height: 25px; width: 20px;"><?php
               $sqlA="SELECT COUNT(*) as totalAprendices FROM `aprendiz` INNER JOIN ficha ON aprendiz.id_ficha=ficha.id_ficha WHERE ficha.id_ficha='".$value['id_ficha']."' AND aprendiz.estado=1";
               foreach ($conectarBD->query($sqlA) as $aprendiz) {
                 $totalAprendices=$aprendiz['totalAprendices'];
                echo $totalAprendices;
}
                ?></td>
            <td style="border: black;font-size: 16px;height: 25px; width: 20px;">
                <?php echo $value['inicio_formacion'];?></td>
            <td style="border: black;font-size: 16px;height: 25px; width: 20px;"><?php echo $value['fin_formacion'];?>
            </td>
            <td style="border: black;font-size: 16px;height: 25px; width: 40px;"><?php 
   switch ($value['estadoSE'] ) {
                case '0':
                  $value['estadoSE'] = "No";
                  echo $value['estadoSE'];
                  break;
                case '1':
                $value['estadoSE'] = "Si";
          		 echo   $value['estadoSE'];
                  break;
              }
             ?></td>
        </tr>
        <?php 

}
}

     ?>

    </table>
</div>