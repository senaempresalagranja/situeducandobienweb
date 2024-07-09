<?php 
session_start();
require '../conecion.php';
date_default_timezone_set("America/Bogota");
?>
<!DOCTYPE html>
<html>
<head>
	<?php require '../navAdmi.php'?>
	<title>Turno Manual Rutinario</title>
    <link rel="icon" type="image/png" sizes="16x16" href="../situ.png">
	<link rel="stylesheet" type="text/css" href="../Assets/fonts/style.css">
  <link rel="stylesheet" type="text/css" href="../Assets/bootstrap-4.3.1-dist/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="../css/sweetalert.css">

</head>
<body class="bg-white">
	<?php require '../navegacion.php'?>

<div class="container mt-5" id="re">
	<form id="formulario">
	<div class="form-row" >
  <div class="form-group col-md-4">       
   <?php

$sql="SELECT * FROM area ORDER BY nombreArea ASC";
if ($conectarBD->query($sql)-> num_rows > 0) {
    ?>  
			<label  class="font-weight-bold">Area:</label>
			<br>	
                        
<select class="form-control" value="<?php if(isset($area)) echo $area?>" name="area" id="area" >  
        <option value="">Seleccione un area</option>

      <?php

     foreach($conectarBD->query($sql) as $area){
      ?>
     <option value="<?php echo $area['id_area'];?>"><?php
      echo $area['nombreArea'];?></option>
     <?php
     
   }

     }
      
      ?>

    	</select>
	</div>
	<div class="form-group col-md-4">  
   
    
      <label  class="font-weight-bold">Tipo Turno:</label>
			<br>
    
     <select class="form-control" id="tipoTurno">  
    
   
  </select>
</div>
  <div class="form-group col-md-4">  
   
    
      <label  class="font-weight-bold">Unidades:</label>
      <br>
    
     <select class="form-control" id="unidades">  
    
   
  </select>
</div>
</div>
<div class="form-row" >
  <div class="form-group col-md-4">
    <label  class="font-weight-bold">Fichas:</label>
      <br>
    
     <select class="form-control" name="id_ficha" id="fichas">  
    
   
  </select>
</div>
  <div class="form-group col-md-4">    
          <label  class="font-weight-bold">Aprendiz:</label>
      <br>
    
     <select class="form-control" name="codumento" id="aprendices">  
    
   
  </select>

</div> 
  <div class="form-group col-md-4"> 
      <label class="font-weight-bold">Fecha</label>
      <br>
      <input type="date" class="btn btn-info btn-block form-control " name="fecha" id="fecha" >
    </div>   
  </div>

 <div align="center" class="mt-2">

  <button type="reset" title="Limpiar Registro" class="btn" id="reset">
    <i class="icon-loop2 text-secondary" style="font-size: 35px;"></i> 
  </button>

  <button type="button" class="btn" title="Cancelar Registro"  onclick="window.location.href='./listaTurnosRutinario.php'">
      <i class="icon-cancel text-danger" style="font-size: 50px;"> </i>
  </button>
  

  <button type="submit"  class="btn font-weight-bold " id="registrar"  title="Registrar turno">
  <i class="icon-checkmark1 text-success" style="font-size: 50px; "></i>
  </button>
 </div> 


<div align="center" class="container mt-5" id="respuesta">

</div>
</form>

 <script type="text/javascript" src="../Assets/Jquery/jQuery_v3.4.1.js"></script>
 <script type="text/javascript" src="../js/sweetalert.js"></script>
<script type="text/javascript" src="../Assets/bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>

<script type="text/javascript">
      $(document).ready(function(){
      	
          $("#area").change(function () {
 
          $("#area option:selected").each(function () {
            area = $(this).val();
            $.post("./turnoManualDatos.php", { area }, function(data){
              $("#tipoTurno").html(data);
            });            
          });
        });
          $("#tipoTurno").change(function () {
            tipoTurno = $(this).val();
            let area = $("#area").val();
            $.post("./turnoManualDatos.php", { tipoTurno, area }, function(data){
              $("#unidades").html(data);
            });
          });
          $("#unidades").change(function () {
            codigoUnidad = $(this).val();
             $.post("./turnoManualDatos.php", { codigoUnidad }, function(data){
              $("#fichas").html(data);
            });
          });
          $("#fichas").change(function () {
            id_ficha = $(this).val();
             $.post("./turnoManualDatos.php", { id_ficha }, function(data){
              $("#aprendices").html(data);
            });
          });

 $("#registrar").on("click",function(event){
          event.preventDefault()
          
    if ($("#area").val()) {
            let id_area=$("#area").val();
      if ($("#tipoTurno").val()) {
        let tipoT = $("#tipoTurno").val()
        if ($("#unidades").val()) {
        let unidad = $("#unidades").val()
        if ($("#fichas").val()) {
          let fichaTurno = $("#fichas").val()
          if ($("#aprendices").val()) {
            let idAprendiz = $("#aprendices").val()
            if ($("#fecha").val()) {
                let fecha = $("#fecha").val();
               
              
             
              
                $.post("registrarTurnoManual.php",{id_area,tipoT,unidad,idAprendiz, fichaTurno,fecha},function(data){
                  $("#respuesta").html(data)

                })
             

            }else{
              swal('Error','Selecione Una Fecha', 'error' );
            }

            }else{
            swal('Error','Selecione Un Aprendiz', 'error' );
            }

          }else{
          swal('Error','Selecione Una Ficha', 'error' );
         }
        
        }else{
             swal('Error','Selecione Una Unidad', 'error' );
           }

      }else{
             swal('Error','Selecione Un Tipo De Turno', 'error' );
          }
            
    }else{
          swal('Error','Selecione Un Area', 'error' );
        }
  });
        

$("#reset").on("click",function(){
   $("#respuesta").html('')
});
	
          });



</script>   
</body>
</html>