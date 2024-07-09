<link rel="icon" type="image/png" sizes="16x16" href="../situ.png">
<?php 
require '../conecion.php';
function insertar($id_aprendiz,$tipoDocumento,$nombres,$apellidos,$telefono,$sexo,$correo,$id_ficha){
    
  global $conectarBD;
  
  $sentencia = "INSERT INTO aprendiz (id_aprendiz,tipoDocumento,nombres,apellidos,telefono,sexo,correo,id_ficha) VALUES ('$id_aprendiz','$tipoDocumento','$nombres','$apellidos','$telefono','$sexo','$correo','$id_ficha')";
  
  $ejecutar = $conectarBD->query($sentencia);
  return $ejecutar;
}
?>
