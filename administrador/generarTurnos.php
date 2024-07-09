<?php

require '../conecion.php';

$registros1="SELECT *  FROM ficha WHERE id_area in (1,6) ";


if($conectarBD->query($registros1)->num_rows > 0){

   foreach ($conectarBD->query($registros1) as $valores){

   	$registrosA="SELECT  COUNT(*) AS totalRegistros FROM aprendiz WHERE estado = 1 AND estadoSE = 0 ";
$cant=$conectarBD->query($registrosA)->fetch_assoc()['totalRegistros'];
echo "cantidad de A: ".$cant."<br>";

?>
<td><?php echo "Areas: ".$valores['id_area'] ;?></td>

</table>
<?php


		
}
}

if ($valores['id_area']==1||$valores['id_area']==6) {
echo "funciono";
$sqlU="SELECT * FROM unidad";
foreach ($conectarBD->query($sqlU) as $unidad){
?>
<br>
<span style="color: blue;"><?php echo $unidad['codigoUnidad'];?></span><span style="color: red;"><?php echo $unidad['nombreUnidad'];?></span><br>

		<?php

		
}
}else{
	echo "nada";
	}
?>

