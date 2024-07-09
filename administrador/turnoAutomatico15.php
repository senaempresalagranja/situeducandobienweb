<?php 
session_start();
require '../conecion.php';

?>

<!DOCTYPE html>
<html>
<head>
	<title>Turno Automatico 15 Dias</title>
	<link rel="icon" type="image/png" sizes="16x16" href="../situ.png">
	<link rel="stylesheet" type="text/css" href="../Assets/bootstrap-4.3.1-dist/css/bootstrap.min.css
">

</head>
<body class="bg-white">
	<?php
		$sql="SELECT unidad.codigoUnidad, unidad.nombreUnidad, unidad.cantidadAprendices,
		 unidad.tipoTurno, unidad.token, area.nombreArea FROM unidad INNER JOIN area 
			ON unidad.id_area = area.id_area WHERE unidad.tipoTurno='15 dias'
			 AND unidad.estado='1' ORDER BY unidad.nombreUnidad ASC";
	?>
	<div align="center" class="mt-5">
			<div  class="col-md-5">
				<table class="table table-hover table-white table-sm border">
					<tr class="bg-primary text-center">
						<th>Codigo</th>
						<th>Nombre</th>
						<th>Cantidad Aprendices</th>
						<th>Area</th>
						<th>Acciones</th>
					</tr>
					<?php
					foreach ($conectarBD->query($sql) as $value) {		
					?>
					<tr class="text-center font-weight-bold">
						<td><?php echo $value['codigoUnidad']; ?></td>
						<td><?php echo $value['nombreUnidad']; ?></td>
						<td><?php echo $value['cantidadAprendices']; ?></td>
						<td><?php echo $value['nombreArea']; ?></td>
						<td id="evaluate"><button class="btn btn-outline-dark font-weight-bold btn-sm" value="<?php echo $value['token'];?>">Enturnar</button></td>
					</tr>
					<?php
					}
					?>
				</table>
				<button class="btn btn-warning btn-block font-weight-bold" >Enturnar Todas</button>
			</div>
	</div>
	<div id="datos" class="mt-5">
		
	</div>




<script type="text/javascript" src="../Assets/bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../Assets/Jquery/jQuery_v3.4.1.js"></script>
<script type="text/javascript">

	 $("#evaluate button").click(function(){

        let token =$(this).val();
        
        $.post("../administrador/enturnado15Dias.php", { token }, function(data){
        	
        	$("#datos").html(data);
             
            }); 

   })

</script>
</body>
</html>