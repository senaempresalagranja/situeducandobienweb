
    <!DOCTYPE html>
<html>
<head>
<title>Sugerencias</title>
    <link rel="icon" type="image/png" sizes="16x16" href="../situ.png">
<link rel="stylesheet" type="text/css" href="../estilos.css">
	<link rel="stylesheet" type="text/css" href="../Assets/fonts/style.css">
	<link rel="shortcut icon" href="../Situ.png">
	<link rel="stylesheet" type="text/css" href="../Assets/bootstrap-4.3.1-dist/css/bootstrap.min.css">
</head>

<body class="bg-white" >

<?php
include './navConsulta.php'

?>

<div >
<div align="center" class="container">
    <br>
	<h2 class="font-weight-bold">REGISTRO DE SUGERENCIAS</h2>
<br><br>	
	<form method="post" action="registroBaseSugerencia.php">
<div class="form-row">
	<div class="form-group col-md-5">
		<label  class="font-weight-bold">Documento de Identidad:</label>
		<br>
		<input type="number" name="idDucumento" id="id_aprendiz" class="form-control" placeholder="2343245"  required="" >
    </div>
	<div class="form-group col-md-5">
		<label  class="font-weight-bold">Tipo de Sugerencia:</label>
        <select name="tipoSugerencia" id="tipoSugerencia" class="form-control" required="required">
		  <option class="font-weight-bold" value="">Selecione una Opcion</option>
		  <option class="font-weight-bold" value="Un Error en la pagina">Un Error en la pagina</option>
		  <option class="font-weight-bold" value="Correccion de Escritura">Correccion de Escritura</option>
		  <option class="font-weight-bold" value="Una Mejora a la Pagina">Una Mejora a la Pagina</option>
		  <option class="font-weight-bold" value="Sugerir un Cambio">Sugerir un Cambio</option>
        </select>
    </div>

</div>		
	
	<div class="form-row">
		<div class="form-group col-md-5">
        <label  class="font-weight-bold">Un Correo Para Dar Respuesta:</label>
		<br>
		<input type="email" name="correoS" id="correoS" class="form-control" placeholder="@misena.edu.co"  required="" >
		</div>

        <div class="form-group col-md-5">
        <label  class="font-weight-bold">Comentario:</label>
		<br>
        <textarea type="text" name="comentarioS" id="comentarioS" class="form-control text-justify" placeholder="Corrijan ....."  required="" ></textarea >
   	</div>
</div>
<br>
    <input type="submit" class="btn btn-warning font-weight-bold col-3" value="Enviar Sugerencia"  > 
        
</div>
</div>

<script type="text/javascript" src="../Assets/Jquery/jQuery_v3.4.1.js"></script>
<script type="text/javascript" src="../Assets/bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>
<script type="text/javascript">
	document.getElementById("idDocumento").focus();

	</script>

</body>
<div >
<?php
include './footerConsulta.php'
?>
</div>
</html>

