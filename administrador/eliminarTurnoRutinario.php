<?php
session_start();
require '../conecion.php';
require '../Assets/funcion.php';

$idUser= $_SESSION['id'];
    $tipoUsuario = $_SESSION['tipo'];
    if(empty($_SESSION['tipo'])) {
        echo "<script>window.location.href='../index.php'; </script>";  
    }
$token=$_REQUEST['token'];

  $sql ="SELECT * FROM turnorutinario WHERE token= '$token'";
  if ($conectarBD->query($sql)->num_rows > 0 ){
    $tokenBD =$conectarBD->query($sql)->fetch_assoc()['token']; 
    $codigoTurno = $conectarBD->query($sql)->fetch_assoc()['codigoTurno'];
    $id_aprendiz = $conectarBD->query($sql)->fetch_assoc()['id_aprendiz'];
    $id_area = $conectarBD->query($sql)->fetch_assoc()['id_area'];
    $codigoUnidad = $conectarBD->query($sql)->fetch_assoc()['codigoUnidad'];
    $estado = $conectarBD->query($sql)->fetch_assoc()['estado'];
   
  }
    switch ($estado) {
    case '1':
      $estado=0;
      break;
    
  
    case '0':
      $estado=1;
      break;
  }


if (isset($_POST['tokenBD'])) {
 if (!empty($_POST['tokenBD'])) {
  $tokenBD=$_POST['tokenBD'];
 
 $sqlA = "UPDATE turnorutinario SET estado = '$estado' WHERE token= '$tokenBD'";

   if ($conectarBD->query($sqlA)=== TRUE){
       echo "<script>window.location.href='./listaTurnosRutinario.php'; </script>";  
   }

}
 }



	
  


?>  
<!DOCTYPE html>
<html>
<head>
  <?php require '../navAdmi.php';?>
<title> Eliminar Turnos Rutinarios</title>
<link rel="icon" type="image/png" sizes="16x16" href="../situ.png">
   <link rel="stylesheet" type="text/css" href="../estilos.css">
  <link rel="stylesheet" type="text/css" href="../Assets/fonts/style.css">
  <link rel="stylesheet" type="text/css" href="
  ../Assets/bootstrap-4.3.1-dist/css/bootstrap.min.css
">
</head>
<body class=" bg-white">
<?php require '../navegacion.php';?>

<br><br>
<div align="center" class="form bg-transparent border-transparent">
	<h2>¿ Está Seguro de  <?php if ($estado==1) { echo 'Activar';}else{ echo'Desactivar';} ?> El Siguiente Turno Rutinario ?</h2>
  <br>
  <p class="font-weight-bold">Codigo Turno: <span style="color: purple;"><?php echo $codigoTurno ; ?></span></p>
	<p class="font-weight-bold">Documento: <span style="color: purple;"><?php echo $id_aprendiz ; ?></span></p>

<p class="font-weight-bold">Area: <span style="color: purple;">
  <?php
 $sqlA= "SELECT * FROM area WHERE id_area=".$id_area;
       if ($conectarBD->query($sqlA)->num_rows > 0){

         foreach ($conectarBD->query($sqlA) as $fila){
          $nombreArea= $fila['nombreArea'];
        }
}
    echo $nombreArea;

   ?>
    
</span></p>
<p class="font-weight-bold">Unidad: <span style="color: purple;">
  <?php
  $sqlU= "SELECT * FROM unidad WHERE codigoUnidad=".$codigoUnidad;
       if ($conectarBD->query($sqlU)->num_rows > 0){

         foreach ($conectarBD->query($sqlU) as $fila){
          $nombreUnidad= $fila['nombreUnidad'];
        }
}
     echo $nombreUnidad;

  ?>
    
  </span></p>

 
	<form method="post" action="#">
  <input type="hidden" name="tokenBD" value="<?php echo $token; ?>">
 <button type="button" class="btn " title="Cancelar Eliminar"  onclick="window.location.href='./listaTurnosRutinario.php'">
 <i class="icon-cancel text-danger" style="font-size: 50px;"> </i>
  </button>
  
   <button type="submit" class="btn font-weight-bold "  title="<?php if ($estado==1){echo "Activar";}else{ echo "Desactivar";} ?> Turno Rutinario" ><span class=" icon-checkmark1 text-success" style="font-size: 50px;"></span>
   </button>
 
</div>

<div>
 
</div>

<script type="text/javascript" src="../Assets/Jquery/jQuery_v3.4.1.js"></script>
<script type="text/javascript" src="../Assets/bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>

</body>
    

 
                
       
        
            