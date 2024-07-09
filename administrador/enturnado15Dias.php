<?php
session_start();
require '../conecion.php';
require '../Assets/funcion.php';
$token = $_POST['token'];



$sqlI = "SELECT unidad.codigoUnidad,unidad.nombreUnidad,unidad.id_area,unidad.tipoTurno ,unidad.cantidadRQ,ficha.id_ficha,unidad.cantidadAprendices,ficha.cantidad_aprendices,ficha.cantEF, ficha.todosT FROM unidad INNER JOIN ficha ON unidad.id_area = ficha.id_area WHERE unidad.token = '$token' AND unidad.estado='1' AND unidad.estadoT='0' AND ficha.cantidad_aprendices!=ficha.cantEF AND ficha.estado='1' AND ficha.todosT='0' LIMIT 1";

$resultado = $conectarBD->query($sqlI);
if (!empty($resultado)) {
	$codigoUnidad = $conectarBD->query($sqlI)->fetch_assoc()['codigoUnidad'];
	$totalRU = $conectarBD->query($sqlI)->fetch_assoc()['cantidadRQ'];
	$cantidadAP = $conectarBD->query($sqlI)->fetch_assoc()['cantidadAprendices'];
	$ficha = $conectarBD->query($sqlI)->fetch_assoc()['id_ficha'];
	$area = $conectarBD->query($sqlI)->fetch_assoc()['id_area'];
	$tipoTurno = $conectarBD->query($sqlI)->fetch_assoc()['tipoTurno'];
	$sqlF = "SELECT fechaTurno FROM turnorutinario WHERE codigoUnidad='$codigoUnidad' AND estado ='1'";

	if (!empty($conectarBD->query($sqlF))) {
		$fechaTA = $conectarBD->query($sqlF)->fetch_assoc()['fechaTurno'];
		$arrayFecha = explode('-', $fechaTA);
		$dia = $arrayFecha[2];
		$mes = $arrayFecha[1];
		$ano = $arrayFecha[0];
		$fechaTurno = $ano . "-" . $mes . "-" . ($dia + 1);
	} else {
		date_default_timezone_set("America/Bogota");
		$fechaTurno = date('Y-m-d');
	}

	while ($totalRU <= $cantidadAP) {
		$cantEF = $conectarBD->query($sqlI)->fetch_assoc()['cantEF'];
		$cantidadAF = $conectarBD->query($sqlI)->fetch_assoc()['cantidad_aprendices'];
		$nToken = generateToken();

		if ($totalRU == $cantidadAP) {
			break;
		}
		$sqlA = "SELECT aprendiz.id_aprendiz, aprendiz.nombres, aprendiz.apellidos, aprendiz.id_ficha FROM aprendiz INNER JOIN ficha ON aprendiz.id_ficha=ficha.id_ficha INNER JOIN unidad ON unidad.id_area=ficha.id_area WHERE unidad.codigoUnidad ='$codigoUnidad' AND aprendiz.estado='1' AND aprendiz.estadoSE='0' AND aprendiz.estadoT='0' ORDER BY RAND() LIMIT 1";

		$aprendiz = $conectarBD->query($sqlA)->fetch_assoc()['id_aprendiz'];
		$sqlT = "INSERT INTO turnorutinario( id_aprendiz, id_ficha, id_area, codigoUnidad, tipoTurno, fechaTurno, token) VALUES ('$aprendiz','$ficha','$area','$codigoUnidad','$tipoTurno','$fechaTurno','$nToken')";

		if ($conectarBD->query($sqlT)) {

			$sqlE = "UPDATE aprendiz,ficha, unidad SET aprendiz.estadoT ='1',ficha.cantEF=('$cantEF'+1),unidad.cantidadRQ=('$totalRU'+1) WHERE id_aprendiz='$aprendiz' AND ficha.id_ficha='$ficha' AND unidad.codigoUnidad='$codigoUnidad'";
			if ($conectarBD->query($sqlE)) {
				echo '<div class="container">
				<table class="table table-hover ">
					<thead class="bg-primary">
						<tr>
							<th>Aprendiz</th>
							<th>Ficha</th>
							<th>Area</th>
							<th>Unidad</th>
							<th>Fecha</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>' . $aprendiz . '</td>
							<td>' . $ficha . '</td>
							<td>' . $area . '</td>
							<td>' . $codigoUnidad . '</td>
							<td>' . $fechaTurno . '</td>
						</tr>
					</tbody>
				</table>
			</div>';
			} else {
				echo "aprendiz no actualiza";
			}
		} else {
			echo "no inserto el turno";
		}
		$totalRU++;
		$sql = "UPDATE ficha SET todosT='1' WHERE id_ficha='$ficha'";
		if ($cantEF == $cantidadAF) {

			$resul = $conectarBD->query($sql);
		}
	}
} else {
	echo "Nose Encontraron Datos";
}
