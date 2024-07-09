<?php 
session_start();
require '../conecion.php';
if(isset($_GET['token'])){
  if(empty($_GET['token'])){
      echo "<script>window.location.href='../index.php'; </script>";  
}else{

$token = $_GET['token'];

if($conectarBD->connect_error){
    
    die("conexion fallida:".$conectarBD->connect_error);
}

$sql = "SELECT turnorutinario.codigoTurno,turnorutinario.id_aprendiz,turnorutinario.id_ficha, turnorutinario.id_area, turnorutinario.codigoTurno, turnorutinario.tipoTurno, turnorutinario.fechaTurno,turnorutinario.estado,turnorutinario.fallas,turnorutinario.token, unidad.nombreUnidad, unidad.horaInicioM, unidad.horaFinM,area.nombreArea,area.id_area, programas.nombreP,aprendiz.nombres,aprendiz.apellidos FROM `turnorutinario` INNER JOIN unidad ON unidad.codigoUnidad=turnorutinario.codigoUnidad INNER JOIN area ON area.id_area=turnorutinario.id_area INNER JOIN ficha ON ficha.id_ficha = turnorutinario.id_ficha INNER JOIN programas ON programas.id_programaF=ficha.id_programaF INNER JOIN aprendiz ON aprendiz.id_aprendiz=turnorutinario.id_aprendiz AND turnorutinario.estado=1 AND unidad.estado=1 WHERE turnorutinario.token = '$token'";

if ($conectarBD->query($sql)-> num_rows >0){
  
        $nombres = $conectarBD->query($sql)->fetch_assoc()['nombres'];
        $apellidos = $conectarBD->query($sql)->fetch_assoc()['apellidos'];
        $id_ficha = $conectarBD->query($sql)->fetch_assoc()['id_ficha'];
        $area = $conectarBD->query($sql)->fetch_assoc()['nombreArea'];
        $tipoTurno = $conectarBD->query($sql)->fetch_assoc()['tipoTurno'];
        $id_area = $conectarBD->query($sql)->fetch_assoc()['id_area'];
        $nombreUnidad = $conectarBD->query($sql)->fetch_assoc()['nombreUnidad'];
        $fechaTurno = $conectarBD->query($sql)->fetch_assoc()['fechaTurno'];
        $nombreP= $conectarBD->query($sql)->fetch_assoc()['nombreP'];
        $token= $conectarBD->query($sql)->fetch_assoc()['token'];
      }   
    }
}
 

        



?>
<!DOCTYPE html>
<html>
<head>
	<?php require '../navAdmi.php'?>
	<title>Turno Manual Especial</title>
  <link rel="icon" type="image/png" sizes="16x16" href="../situ.png">
	<link rel="stylesheet" type="text/css" href="../Assets/fonts/style.css">
  <link rel="stylesheet" type="text/css" href="../Assets/bootstrap-4.3.1-dist/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="../css/sweetalert.css">

</head>
<body class="bg-white">
	<?php require '../navegacion.php'?>

<div class="container mt-5" id="re">
	<form id="formulario">
    <input type="hidden" id="token" value="<?php echo $token; ?>">
	<div class="form-row" >
  <div class="form-group col-md-4">       
   <?php

$sql="SELECT * FROM area WHERE id_area ='$id_area' ORDER BY nombreArea ASC";
if ($conectarBD->query($sql)-> num_rows > 0) {
    ?>  
			<label  class="font-weight-bold">Area:</label>
			<br>	
                        
<select class="form-control" name="area" id="area" >  
  
        <option value="" id="id_area"><?php if(isset($area)) echo "Area Actual ".$area; ?></option>

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
      <option value=""><?php if(isset($tipoTurno)) echo $tipoTurno; ?></option>
   
  </select>
</div>
  <div class="form-group col-md-4">  
   
    
      <label  class="font-weight-bold">Unidades:</label>
      <br>
    
     <select class="form-control" id="unidades"  >  
      <option value=""><?php if(isset($nombreUnidad)) echo $nombreUnidad; ?></option>
    
   
  </select>
</div>
</div>
<div class="form-row" >
  <div class="form-group col-md-4">
    <label  class="font-weight-bold">Fichas:</label>
      <br>
    
     <input class="form-control" style="cursor: no-drop;" value="<?php if(isset($nombreP)) echo $nombreP; ?>" readonly="readonly" >
</div>
  <div class="form-group col-md-4">    
          <label  class="font-weight-bold">Aprendiz:</label>
      <br>
    
      
    <input class="form-control" style="cursor: no-drop;" value="<?php if(isset($nombres,$apellidos)) echo $nombres." ".$apellidos; ?>" readonly="readonly">
  

</div> 
  <div class="form-group col-md-4"> 
      <label class="font-weight-bold">Fecha</label>
      <br>
      <input type="date" class="btn btn-info btn-block form-control " name="fecha" id="fecha" value="<?php if(isset($fechaTurno)) echo $fechaTurno; ?>" >
    </div>   
  </div>

 <div align="center" class="mt-2">

  <button type="reset" title="Limpiar Registro" class="btn" id="reset" style="font-size: 35px;">
    <i class="icon-loop2 text-secondary" sty le="font-size: 35px;"></i> 
  </button>

  <button type="button" class="btn" title="Cancelar Registro"  onclick="window.location.href='./listaTurnosRutinario.php'">
      <i class="icon-cancel text-danger" style="font-size: 50px;"> </i>
  </button>
  

  <button type="submit"  class="btn font-weight-bold " id="registrar"  title="Registrar turno">
  <i class="icon-checkmark1 text-success" style="font-size: 50px;"></i>
  </button>
 </div> 
</form>

<div align="center" class="container mt-5" id="respuesta">
	
</div>


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
              $("#id_area").html('Selecione Una')
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
        

 $("#registrar").on("click",function(event){
          event.preventDefault()
          
    if ($("#area").val()) {
            let id_area=$("#area").val();
      if ($("#tipoTurno").val()) {
        let tipoT = $("#tipoTurno").val()
        if ($("#unidades").val()) {
        let unidad = $("#unidades").val()
            if ($("#fecha").val()) {
                let fecha = $("#fecha").val();
             
              
                
              
               let token =$("#token").val()
                $.post("actualizarTurnoManual.php",{id_area,tipoT,unidad,fecha,token},function(data){
                  $("#respuesta").html(data)
                })
             

            }else{
              swal('Error','Selecione Una Fecha', 'error' );
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