<?php
session_start();
	 require_once"../conecion.php";
	 	

	 	
			if (isset($_POST['area'])) {
				$id_area = $_POST['area'];
	 	$sql="SELECT DISTINCT tipoTurno FROM unidad ";

	 	$html= "<option value=''>Seleccione alguna </option>";
			
		    foreach($conectarBD->query($sql) as $tipo){
			
				$html.= "<option value='".$tipo['tipoTurno']."'>".$tipo['tipoTurno']."</option>";
			}
		}

		if (isset($_POST['tipoTurno'])&& isset($_POST['area'])) {

			$tipoTurno=$_POST['tipoTurno'];
			$area=$_POST['area'];
			$sql = "SELECT codigoUnidad, nombreUnidad FROM unidad WHERE tipoTurno ='$tipoTurno' AND id_area = '$area' ORDER BY nombreUnidad";
					
			
			if ($conectarBD->query($sql)->num_rows>0) {
				$html= "<option value=''>Seleccione alguna </option>";
		    foreach($conectarBD->query($sql) as $unidad){
			
				$html.= "<option value='".$unidad['codigoUnidad']."'>".$unidad['nombreUnidad']."</option>";
			}
		}else{
		$html="<option value=''>Seleccione un Nuevo Tipo</option>";
		}
	}
		if (isset($_POST['codigoUnidad'])) {
			$codigoUnidad = $_POST['codigoUnidad'];

			$sql="SELECT * FROM unidad INNER JOIN ficha ON unidad.id_area = ficha.id_area INNER JOIN programas ON ficha.id_programaF = programas.id_programaF WHERE unidad.codigoUnidad='$codigoUnidad' AND unidad.estado=1 AND ficha.estado=1 AND programas.estado=1";

		$html= "<option value=''>Seleccionar una ficha</option>";

		foreach($conectarBD->query($sql)as $value){
			
				$html.= "<option value='".$value['id_ficha']."'>".$value['nombreP']."</option>";
			}

		}
		if (isset($_POST['id_ficha'])) {

		$id_ficha=$_POST['id_ficha'];

		$sql="SELECT * FROM aprendiz WHERE id_ficha='$id_ficha' AND estado= '1' AND estadoT='0'";

		$html= "<option value=''>Seleccione alguna </option>";
		foreach($conectarBD->query($sql) as $value){
			
				$html.= "<option value='".$value['id_aprendiz']."'>".$value['apellidos']." ".$value['nombres']."</option>";
			}

}

			echo $html;

?>