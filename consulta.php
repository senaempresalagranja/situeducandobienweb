<?php
include './conecion.php';

/* where token ='33de39aeb7dc5b4f15ee341185bcf069' */
$sql="SELECT * FROM usuarios ";
?>

<table class='table table-hover '>
  <tr align='center' class='bg-primary '>
    <th>NOMBRE</th>
    <th>USUARIO</th>
    <th>TIPO DE USUARIO</th>
    <th>EMAIL</th>
  </tr>

  <?php
if( $conectarBD->query($sql)->num_rows > 0){

   foreach ($conectarBD->query($sql) as $fila){
 
    ?>
      
     
  <tr  align='center' class='font-weight-bold' scope='row'>
   
    <td><?php echo $fila['token'] ;?></td>
    
    <td><?php echo $fila['nombre'] ;?></td>
    <td><?php echo $fila['usuario'];?></td>
    <td><?php echo $fila['tipo'];?></td>
    <td><?php echo $fila['email'];?></td>
 
    <?php  
}
}else{
    echo "NO SIRVE";
}

$sqlU="UPDATE usuarios SET intentoFallidos=0  ";
if( $conectarBD->query($sqlU)== TRUE){
echo "Se cambio";
}else{
  echo "No Se pudo";
}

?>