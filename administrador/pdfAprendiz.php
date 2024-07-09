<?php 
require '../conecion.php';
require '../Assets/funcion.php';


session_start();
$idUser = $_SESSION['id'];
$tipoUsuario = $_SESSION['tipo'];
    if (empty($_SESSION['tipo'])) {
       echo "<script>window.location.href='../index.php'; </script>";  
    }

if(isset($_GET['busqueda'])){
$busqueda=$_GET['busqueda'];

$sql = "SELECT * FROM aprendiz WHERE ( 
          id_aprendiz      LIKE '%$busqueda%' OR
          nombres  LIKE '%$busqueda%' OR
          apellidos LIKE '%$busqueda%' OR
          telefono    LIKE '%$busqueda%' OR
          id_ficha    LIKE '%$busqueda%' OR
          sexo    LIKE '%$busqueda%' OR
          correo   LIKE '%$busqueda%' ) ORDER BY nombres ASC"; 
}else{

$sql = "SELECT * FROM aprendiz ORDER BY nombres ASC"; 
}


if(isset($_REQUEST['E'])){
   $E=$_REQUEST['E'];
  if(isset($busqueda)){
     header('content-type:aplication/xls');   
  header('Content-Disposition: attachment; filename=busquedaAprendices.xls');         


}else{
   header('content-type:aplication/xls');  

  header('Content-Disposition: attachment; filename=listaAprendices.xls');

}
}

if(isset($_GET['id_ficha'])){
  $id_ficha=$_GET['id_ficha'];
$sql="SELECT * FROM aprendiz WHERE id_ficha='$id_ficha' ORDER BY nombres";
}
?>
<?php 
if(!isset($E)){
  ?>
<img src="../situ.png" width="100" height="100">
<?php
}
 ?>
      <div style="margin-left: 10px;"><h3 > <?php  echo date("d-m-Y");?> </h3></div>

<div style="margin-top: -100px;">
<h1 align="center" style="font-weight: bold;"> <?php if(isset($busqueda)){echo "Busqueda";}else{echo "Lista";} ?> de Aprendices</h1>
  <table  width="500" class="" style=" margin-top: 60px;" align="center">
            <tr  align='center' style="background-color: #0b56a0;  font-size: 16px; color: white;" >
            <th align='center'style="border: black; width: 120px;height: 30px;">Documento</th>
            <th align='center'style="border: black; width: 120px;height: 30px;">Tipo Documento</th>
            <th align='center'style="border: black; width: 120px;height: 30px;">Nombres</th>
            <th align='center'style="border: black; width: 120px;height: 30px;">Apellidos</th>
            <th align='center'style="border: black; width: 120px;height: 30px;">Telefono</th>
            <th align='center'style="border: black; width: 120px;height: 30px;">Ficha</th>
            <th align='center'style="border: black; width: 120px;height: 30px;">Sexo</th>
            <th align='center'style="border: black; width: 200px;height: 30px;">Correo</th>
         </tr>
  <?php
if( $conectarBD->query($sql)->num_rows > 0){

   foreach ($conectarBD->query($sql) as $value){
 
    ?>
      
     
  <tr align='center' style ='font-weight: bold' scope='row'>
             <td style="border: black;font-size: 16px;height: 25px; width: 20px;"><?php echo $value['id_aprendiz'];?></td>
             <td style="border: black;font-size: 16px;height: 25px; width: 20px;"><?php echo $value['tipoDocumento'];?></td>
             <td style="border: black;font-size: 16px;height: 50px; width: 50px;"><?php if(isset($E)){ echo utf8_decode($value['nombres']);}else{echo $value['nombres'];}?></td>
             <td style="border: black;font-size: 16px;height: 50px; width: 50px;"><?php if(isset($E)){ echo utf8_decode($value['apellidos']);}else{echo $value['apellidos'];}?></td>
             <td style="border: black;font-size: 16px;height: 25px; width: 20px;"><?php echo $value['telefono'];?></td>
             <td style="border: black;font-size: 16px;height: 25px; width: 20px;"><?php echo $value['id_ficha'];?></td>
             <td style="border: black;font-size: 16px;height: 25px; width: 20px;"><?php echo $value['sexo'];?></td>
             <td style="border: black;font-size: 13px;height: 25px; width: 40px;"><?php echo $value['correo'];?></td>
   </tr>
     <?php 

}
}

     ?>

   </table>
   </div>
