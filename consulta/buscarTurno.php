<?php
require '../conecion.php';
require '../Assets/funcion.php';

session_start();

 if (isset($_REQUEST['busqueda'])) {      
   $busqueda=strtolower($_REQUEST['busqueda']);

if(!empty($busqueda)){

$sql="SELECT turnorutinario.codigoTurno, turnorutinario.codigoUnidad, turnorutinario.id_aprendiz, aprendiz.nombres, aprendiz.apellidos, turnorutinario.id_ficha, area.nombreArea, unidad.nombreUnidad, turnorutinario.tipoTurno, turnorutinario.fechaTurno, unidad.horaInicioM, unidad.horaFinM, unidad.token, turnorutinario.estado FROM turnorutinario INNER JOIN area ON turnorutinario.id_area=area.id_area INNER JOIN unidad ON turnorutinario.codigoUnidad=unidad.codigoUnidad INNER JOIN aprendiz ON turnorutinario.id_aprendiz=aprendiz.id_aprendiz WHERE turnorutinario.id_aprendiz = '$busqueda' OR turnorutinario.id_ficha = '$busqueda' ORDER BY fechaTurno DESC";
$id_aprendiz=$conectarBD->query($sql)->fetch_assoc()['id_aprendiz'];
$nombre=$conectarBD->query($sql)->fetch_assoc()['nombres'];
$apellidos=$conectarBD->query($sql)->fetch_assoc()['apellidos'];
$nombres=$nombre." ".$apellidos;
$id_ficha=$conectarBD->query($sql)->fetch_assoc()['id_ficha'];
$codigoU=$conectarBD->query($sql)->fetch_assoc()['codigoUnidad'];
$token=$conectarBD->query($sql)->fetch_assoc()['token'];

?>
<br>


<main id="app">


<div class="container" style="margin-top: 70px; margin-left: -16px;">
<button  class="btn btn-success font-weight-bold" onclick="window.location.reload();">Consulta</button>
</div>
<?php 
if( $conectarBD->query($sql)->num_rows >0){

 echo"<script>swal('Excelente','La busqueda de: $busqueda fue correcta', 'success' )</script>"; 
$sqlI="SELECT * FROM infou15 WHERE codigoUnidad='$codigoU' AND token='$token'";
//echo $sqlI;
$horaIT=$conectarBD->query($sqlI)->fetch_assoc()['horaInicioT'];
$horaFT=$conectarBD->query($sqlI)->fetch_assoc()['horaFinT'];

?>
<div class="" v-show="datos1=='verdadero'" style="margin-top: -135px;">
<div class='container text-center mt-2'><h1 class="font-weight-bold">Turno Rutinario</h1></div>
    <div id="contenedor">
      <div style="margin-top: 90px;" id="dispositivo"></div>
    </div>      

      <div class="table-responsive">
      <table class='table table-hover '  style="margin-top: 80px;">
        <thead>
          <tr class='bg-primary text-light' align='center' class='bg-primary'>
            <th class="th-sm">Documento</th>
            <th class="th-sm">Nombres Aprendiz</th>
            <th class="th-sm">Ficha</th>
            <th class="th-sm">Area</th>
            <th class="th-sm">Unidad</th>
            <th class="th-sm">Tipo Turno</th>
            <th class="th-sm">Fecha Turno</th>
            <th class="th-sm" colspan="2">Hora Mañana</th>  
          <?php
             if(isset($horaIT)){
?>
            <th class="th-sm" colspan="2">Hora Tarde</th> 
<?php
}
?>  
            <th class="th-sm">Memorandos</th>
         </tr>
         </thead>
         <tbody>
  <?php
   foreach ($conectarBD->query($sql) as $turno){
    ?>
  <tr align='center' class='font-weight-bold'>
            <td><?php echo $turno['id_aprendiz'];?></td>
            <td><?php echo $turno['nombres']." ".$turno['apellidos']; ?></td>
            <td><?php echo $turno['id_ficha'];?></td>
            <td><?php echo $turno['nombreArea']; ?></td>
            <td><?php echo $turno['nombreUnidad']; ?></td>
            <td><?php echo $turno['tipoTurno'];?></td>
            <td><?php echo $turno['fechaTurno'];?></td>
            <td><?php echo $turno['horaInicioM'];?></td>
            <td><?php echo $turno['horaFinM'];?></td>
            <?php
            if($turno['tipoTurno'] == '15 dias'){
              if(isset($horaIT)){
?>
            <td><?php echo $horaIT;?></td>
            <td><?php echo $horaFT;?></td>
        <?php
          }}
          ?>
  <td>
      <?php
$sqlM="SELECT COUNT(*) AS numeroM FROM memorandos WHERE memorandos.codigoTurno='".$turno['codigoTurno']."' AND memorandos.id_aprendiz = ".$turno['id_aprendiz'];
//echo $sqlM;
$numerosM=$conectarBD->query($sqlM)->fetch_assoc()['numeroM'];
//echo $numerosM;
if($numerosM >= 1){
              ?>
           <span onclick="exportarPdf(<?php echo $turno['codigoTurno'].','.$turno['id_aprendiz'];?>)" class="icon-file-pdf text-danger" style="font-size: 30px; cursor: pointer;" title="Ver Memorando"></span>
<?php 
}else{
echo "NO";
}
 ?>
  </td>
</tr>     

<?php    
 }
  
  }else{
 	  echo "<script>$('#contenedor').css('display', 'block'); </script>";
    echo"<script>swal('Advertencia','No se encontró Ningún Resultado de la busqueda ', 'warning' )</script>"; 
    echo "<script>$('#app').css('display', 'none'); </script>";
             }
?>
  </tbody>
          </table>
</div>

<?php
$sqlE="SELECT programas.nombreP, turnoespecial.id_ficha, area.nombreArea, unidad.nombreUnidad, turnoespecial.fechaTurnoEspecial, turnoespecial.horaInicio, turnoespecial.horaFin, turnoespecial.estado FROM turnoespecial INNER JOIN ficha ON turnoespecial.id_ficha=ficha.id_ficha INNER JOIN programas ON ficha.id_programaF=programas.id_programaF INNER JOIN area ON turnoespecial.id_area=area.id_area INNER JOIN unidad ON turnoespecial.codigoUnidad=unidad.codigoUnidad WHERE turnoespecial.id_ficha='$id_ficha' AND turnoespecial.estado=1 ORDER BY turnoespecial.fechaTurnoEspecial DESC";

if( $conectarBD->query($sqlE)->num_rows >0){
?>
<br>
<div class="" v-show="datos=='verdadero'" style="margin-top: -10px;"> 
<div class='container text-center mt-2'><h1 class="font-weight-bold">Turno Especial</h1></div>
      <table class='table table-hover table-responsive ' style="margin-top: 40px;">
         <thead>
            <tr class='bg-primary text-light' align='center' class='bg-primary'>
            <th>Nombre Programa Formación</th>
            <th>Ficha</th>
            <th>Area</th>
            <th>Unidad</th>
            <th>Fecha Turno</th>
            <th>Hora Inicio</th>
            <th>Hora Fin</th>
         </tr>
      </thead>
      <tbody>
  <?php
   foreach ($conectarBD->query($sqlE) as $turnoE){    
    ?>
      
          <tr align='center' class='font-weight-bold' >
            <td style="text-transform: uppercase;"><?php echo $turnoE['nombreP'];?></td>
            <td><?php echo $turnoE['id_ficha'];?></td>
            <td style="text-transform: uppercase;"><?php echo $turnoE['nombreArea']; ?></td>
            <td style="text-transform: uppercase;"><?php echo $turnoE['nombreUnidad']; ?></td>
            <td><?php echo $turnoE['fechaTurnoEspecial'];?></td>
            <td><?php echo $turnoE['horaInicio'];?></td>
            <td><?php echo $turnoE['horaFin'];?></td>
          </tr>     
<?php    
 }
?>
</tbody>
          </table>
 
   </div>  
<?php
}else{
//  echo "No tienes Turno Especial";
  //echo"<script>swal('Advertencia','El Aprendiz $nombres con Documento $busqueda no tiene turno Especial  ', 'warning' )</script>"; 
          }
?>
</main>


<?php
}

}      

?>
 
 <script type="text/javascript">

function exportarPdf(codigoTurno, id_aprendiz) {

swal('Advertencia', '¿Qué Desea hacer con el PDF ?', 'warning',  {
  buttons: {
    cancel: "Cancelar",
    catch: {
      text: "DESCARGAR",
      value: "catch",
    },
    defeat: {
      text: 'VER',
    }
  },
})
.then((value) => {
  switch (value) {
 
    case "defeat":
    //console.log(codigoTurno, id_aprendiz);
    window.location.href="../user/mostrarMemorando.php?codigoTurno="+codigoTurno+"&id_aprendiz="+id_aprendiz;
    break;
 
    case "catch":
    swal("Excelente", "El archivo está Descargado Correctamente", "success");
    window.location.href="../user/mostrarMemorando.php?D=1&codigoTurno="+codigoTurno+"&id_aprendiz="+id_aprendiz;
    break;

    default:
    swal("Advertencia", "Fue cancelado", "error");
  }
});
}
 </script>
