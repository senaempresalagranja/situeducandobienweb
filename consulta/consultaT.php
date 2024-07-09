  <!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
     <!-- <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">  -->
	<title>Pagina Principal</title>
	<link rel="stylesheet" type="text/css" href="../estilos.css">
	<link rel="stylesheet" type="text/css" href="../Assets/fonts/style.css"> 
	<link rel="stylesheet" type="text/css" href="../Assets/bootstrap-4.3.1-dist/css/bootstrap.min.css">
	<!-- <link rel="stylesheet" type="text/css" href="../css/sweetalert.css"> -->
    <link rel="shortcut icon" href="../situ.png" >
    <style type="text/css">
   	@media screen and (max-width: 600px) {
       table {
           width:100%;
       }
       thead {
           display: none;
       }
       tr:nth-of-type(2n) {
           background-color: inherit;
       }
       tr td:first-child {
           background: #f0f0f0;
           font-weight:bold;
           font-size:1.3em;
       }
       tbody td {
           display: block;
           text-align:center;
       }
       tbody td:before {
           content: attr(data-th);
           display: block;
           text-align:center;
       }
}

@media screen and (min-width: 780px) and (max-width: 1024px){

}

@media screen and (min-width: 480px) and (max-width: 780px){

}
@media screen and (max-width: 480px)and (orientation:portrait){
      #dispositivo:after{ 
          content: 'Tu Telefono está situado de forma vertical, para tener mayor comodidad gira la pantalla Horizontal'; 
      
      }
}

/*
@media screen and (max-device-width: 320px) 
              and (orientation:portrait){

      #dispositivo:after{ 
          content: 'Tu Iphone está situado de forma vertical o Portrait'; 
      }
}*/
</style>
</head>
<body>
<?php include './navConsulta.php'?>

<div align="center" class="container" style="margin-top: 90px;" id="contenedor">
<h1 class=" font-weight-bold"><span >CONSULTAR TURNO</span></h1>                    

<form>
<div class="form-group">
	<label  class="font-weight-bold">Documento:</label>
	<input class="form-control col-3 border border-dark" type="number" name="busqueda" id="busqueda" placeholder="Buscar" >
 
  	<input class="btn btn-success mt-3" type="submit" id="enviar" value="Consultar">
   </div>
</form>
	</div>

<div id="respuesta" class="container"> </div>


<script type="text/javascript" src="../Assets/Jquery/jQuery_v3.4.1.js"></script>
<script type="text/javascript" src="../Assets/bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>
 <!-- <script type="text/javascript" src="../js/sweetalert.js"></script>  -->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="../Assets/Js/vue.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$("#buscador").css("display", "none");
		
		$("#enviar").on("click", function(event) {
			event.preventDefault();
			let busqueda= $("#busqueda").val();
		//	console.log(busqueda);
    if(busqueda > 0){		
    	$.post("./buscarTurno.php", {busqueda}, function(data){
			$("#contenedor").css("display","none");
			$("#respuesta").html(data);
			$("#buscador").css("display", "block");
			
			})
  }else{
     swal('Error','La consulta no puede ir vacía ', 'error' )   
  }

		})

	});
</script>
</body>
<br>
<footer style="margin-top: 16%;" id="footer">	
<?php
include './footerConsulta.php'
?>
</footer>

</html>
<style type="text/css">
	
	#buscador{
		display: block;
	}
</style>