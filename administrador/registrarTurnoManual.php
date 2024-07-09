<?php
require '../Assets/funcion.php';
require '../conecion.php';
date_default_timezone_set("America/Bogota");
$fechaTurno=$_POST['fecha'];
$id_area=$_POST['id_area'];
$codigoUnidad=$_POST['unidad'];
$ficha=$_POST['fichaTurno'];
$documento=$_POST['idAprendiz'];
$tipoTurno=$_POST['tipoT'];
$fechaHoy= date('d/m/Y');


$arrayFT=explode('-', $fechaTurno);

$diaFT=$arrayFT[0];
$mesFT=$arrayFT[1];
$anoFT=$arrayFT[2];
$FT=$mesFT.$diaFT.$anoFT;
$arrayFH =explode('/', $fechaHoy);
$diaFH=$arrayFH[0];
$mesFH=$arrayFH[1];
$anoFH=$arrayFH[2];
$FH=$mesFH.$diaFH.$anoFH;


if ($FT>$FH) {
			
$token=generateToken();
$sql="INSERT INTO turnorutinario (id_aprendiz, id_ficha, id_area, codigoUnidad, tipoTurno, fechaTurno, token) VALUES ('$documento','$ficha','$id_area','$codigoUnidad','$tipoTurno','$fechaTurno','$token')";
if ($conectarBD->query($sql)) {

$html="<div class='container'>

<table class='table table-hover border'>
<tr class='bg-primary text-center font-weight-bold'>
		<th>Aprendiz</th>
		<th>Unidad</th>
		<th>Area</th>
		<th>Programa</th>
		<th>Fecha</th>
	</tr>";

	$sqlM="SELECT aprendiz.apellidos, aprendiz.nombres, unidad.nombreUnidad, programas.nombreP, area.nombreArea FROM aprendiz INNER JOIN unidad ON unidad.codigoUnidad = '$codigoUnidad' INNER JOIN area ON area.id_area = '$id_area' INNER JOIN ficha ON ficha.id_ficha = '$ficha' INNER JOIN programas ON ficha.id_programaF = programas.id_programaF WHERE aprendiz.id_aprendiz='$documento' AND unidad.estado=1 AND aprendiz.estado=1 AND area.estado=1 AND ficha.estado=1 AND programas.estado=1";

	$nombres=$conectarBD->query($sqlM)->fetch_assoc()['nombres'];
	$apellidos=$conectarBD->query($sqlM)->fetch_assoc()['apellidos'];
	$nombreArea=$conectarBD->query($sqlM)->fetch_assoc()['nombreArea'];
	$nombreUnidad=$conectarBD->query($sqlM)->fetch_assoc()['nombreUnidad'];
	$nombreP=$conectarBD->query($sqlM)->fetch_assoc()['nombreP'];


$html.="<tr class='text-center'>
	<td>".$apellidos." ".$nombres."</td>
	<td>".$nombreUnidad."</td>
	<td>".$nombreArea."</td>
	<td>".$nombreP."</td>
	<td>".$fechaTurno."</td>
</tr>
</table>
</div>
";

echo $html;


     if ($conectarBD->query($sql)==TRUE) {  
      $sqlNA="SELECT * FROM aprendiz WHERE id_aprendiz = '$documento'";
      $nombres=$conectarBD->query($sqlNA)->fetch_assoc()['nombres'];
       $apellidos=$conectarBD->query($sqlNA)->fetch_assoc()['apellidos'];
        $email=$conectarBD->query($sqlNA)->fetch_assoc()['correo'];
     
        $nombre=$nombres." ".$apellidos;
  	
        $asunto =' Notificada Con Un Turno Rutinario';
        $cuerpo="Sen@r ".$nombre." 
        Este Correo Es Para Notificarle Que le fue asignado un turno por parte de Sena Empresa en la unidad de ".$nombreUnidad."<br><br><div align='center'>

<table style='border:  solid 2px grey; text-align: center; border-collapse: collapse; padding: 10px;'>
<tr style='background: #0C70F7; font-weight: bold; font-size: 20px;'>
    <th style='border: solid 1px blue;'>Aprendiz</th>
    <th style='border: solid 1px blue;'>Unidad</th>
    <th style='border: solid 1px blue;'>Area</th>
    <th style='border: solid 1px blue;'>Programa</th>
    <th style='border: solid 1px blue;'>Fecha</th>
  </tr>
  <tr style='border: solid 1px blue;'>
  <td style='border: solid 1px blue; padding: 10px;'>".$apellidos." ".$nombres."</td>
  <td style='border: solid 1px blue; padding: 10px;'>".$nombreUnidad."</td>
  <td style='border: solid 1px blue; padding: 10px;'>".$nombreArea."</td>
  <td style='border: solid 1px blue; padding: 10px;'>".$nombreP."</td>
  <td style='border: solid 1px blue; padding: 10px;'>".$fechaTurno."</td>
</tr>
</table>
</div>"; 
       
         if (enviarEmail($email, $nombre ,$asunto,$cuerpo)) {

          
      

        }

     }else{
       echo "<script type='text/javascript'>
Swal.fire({
  icon: 'error',
  title: 'Oops...',
  text: 'Ha ocurrido un error al enviar el memorando',
  footer: 'Revisa tu conexion a internet o verifica que no hayas enviado ya un memorando'
})
</script>";
}

}else{

	echo $sql."<br>". "1";
}

}else{
	echo "<script> swal('Error','La Fecha Ya Paso', 'error' )</script>";
}
 ?>
