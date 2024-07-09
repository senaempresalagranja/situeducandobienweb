<?php
	 require_once"../conecion.php";
	 	$id_area = $_POST['area'];
	
	$sqlU = "SELECT codigoUnidad, nombreUnidad FROM unidad WHERE id_area = '$id_area' ORDER BY nombreUnidad";
	$resultadoU = $conectarBD->query($sqlU);
	
	$html= "<option value='0'>Seleccionar una Unidad</option>";
	
    foreach($conectarBD->query($sqlU) as $unidad){
	
		$html.= "<option value='".$unidad['codigoUnidad']."'>".$unidad['nombreUnidad']."</option>";
	}
	
	echo $html;

?>