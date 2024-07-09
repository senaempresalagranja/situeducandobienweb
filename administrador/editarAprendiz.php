<?php
session_start();

require_once '../conecion.php';
require '../Assets/funcion.php';


$idUser=$_SESSION['id'];
$tipoUsuario = $_SESSION['tipo'];
if(empty($_SESSION['tipo'])) {
  echo "<script>window.location.href='../index.php'; </script>";  
}

 $errors=array();
if (!empty($_POST)) {

$tipo=$conectarBD->real_escape_string($_POST['tipoDocumento']);
$nombres =$conectarBD->real_escape_string($_POST['nombres']);
$apellidos =$conectarBD->real_escape_string($_POST['apellidos']);
$telefono = $conectarBD->real_escape_string($_POST['telefono']);
$ficha  =$conectarBD->real_escape_string($_POST['id_ficha']);
$sexo  = $conectarBD->real_escape_string($_POST['sexo']);
$email  =$conectarBD->real_escape_string($_POST['correo']);
$token = $_POST['token'];

 $estado = 1;
if(isNullAP($tipo, $nombres, $apellidos, $telefono, $ficha, $sexo, $email)){

if(empty($tipo)){
  $errors[]='<div class="alert alert-danger"><h4>El tipo de Documento es Obligatorio</h4> </div>';
}
      
if(empty($nombres)){
 $errors[]='<div class="alert alert-danger"><h4>El campo nombre está vacío</h4> </div>';
 }           
  if(empty($apellidos)){
 $errors[]='<div class="alert alert-danger"><h4>El campo apellidos es Obligatorio</h4> </div>';
}
if(empty($telefono)){
  $errors[]='<div class="alert alert-danger"><h4>El campo telefono es Obligatorio</h4> </div>';
}           

if(empty($ficha)){
      $errors[]='<div class="alert alert-danger"><h4>El campo Ficha es Obligatorio</h4> </div>';
}               
if(empty($sexo)){
   $errors[]='<div class="alert alert-danger"><h4>Seleccione Un tipo de Sexo</h4> </div>'; 
} 
if(empty($email)){
  $errors[]='<div class="alert alert-danger"><h4>El campo Email es Obligatorio</h4> </div>';
   }              
}

if(count($errors)==0){
  if ($tipo >0){
    if($tipo <=2){  
        if(is_numeric($telefono)){

      $sqlF="SELECT * FROM ficha WHERE id_ficha='$ficha'";
    $fichaBD= $conectarBD->query($sqlF)->fetch_assoc()['id_ficha'];
            if($ficha == $fichaBD){
            
      if ($sexo >0) {
        if($sexo <=2){
 
            if (strlen(stristr($email,'@misena.edu.co'))>0) {          

                $sql = "UPDATE aprendiz SET tipoDocumento='$tipo', nombres ='$nombres',apellidos='$apellidos',telefono ='$telefono',id_ficha ='$ficha',sexo ='$sexo',correo ='$email' WHERE token ='$token'";

  if($conectarBD->query($sql) === TRUE ){
 
     $actualizado= "<div class='alert alert-success'><i class='icon-checkmark1' style='font-size: 80px;'> </i><h4 style='color: black;'class='font-weight-bold'>Aprendiz Actualizado Correctamente</h4> 
  <a class='btn btn-primary' role='button' href='./listarAprendices.php'>Volver</a>
</div>   
";      
 }else{ 
?>
<br>
<div class="container">
<?php
        die(require '../errorAlgoSM.php');
    }
?>
</div>
<?php             
        
        }else{
               $errors[]='<div class="alert alert-danger"><h4>El Correo no es misena</h4></div>';
        }  

        }else{
          $errors[]='<div class="alert alert-danger"><h4>El Tipo de sexo no es correcto </h4> </div>';
        }
        
        }else{
           $errors[]='<div class="alert alert-danger"><h4>El Tipo de sexo no es correcto </h4> </div>';
        }    

        }else{
            $errors[]='<div class="alert alert-danger"><h4 style="color:black;"><i class="icon-warning text-warning" style="font-size:80px;"></i><br>Seleccione una Ficha Existente</h4></div>';
        } 
        
        }else{
            $errors[]='<div class="alert alert-danger"><h4>El campo Telefono no es Numerico </h4> </div>';
        }

              

        }else{
              $errors[]='<div class="alert alert-danger"><h4>El tipo de Documento no es valido</h4> </div>';
        }
        
        }else{
             $errors[]='<div class="alert alert-danger"><h4>El tipo de Documento ingresado no es valido</h4> </div>';
        }
  }
}

if(isset($_GET['token'])){
  if(empty($_GET['token'])){
    echo "<script>window.location.href='./listarAprendices.php'; </script>";  
   
}else{

  $id = $_GET['id'];
$token = $_GET['token'];

if($conectarBD->connect_error){
    die("Conexión fallida: ".$conectarBD->conect_error);
}

$sql = "SELECT * FROM aprendiz WHERE token ='$token'";
 
if($conectarBD->query($sql)-> num_rows > 0){
    
       $id_aprendiz = $conectarBD->query($sql)->fetch_assoc()['id_aprendiz'];
       $tipo= $conectarBD->query($sql)->fetch_assoc()['tipoDocumento'];
       $nombres = $conectarBD->query($sql)->fetch_assoc()['nombres'];
       $apellidos = $conectarBD->query($sql)->fetch_assoc()['apellidos'];
       $telefono = $conectarBD->query($sql)->fetch_assoc()['telefono'];    
       $ficha = $conectarBD->query($sql)->fetch_assoc()['id_ficha'];
       $sexo = $conectarBD->query($sql)->fetch_assoc()['sexo'];
       $correo = $conectarBD->query($sql)->fetch_assoc()['correo'];
       $tokenBD = $conectarBD->query($sql)->fetch_assoc()['token'];
   }
  }
}  
?>
<!DOCTYPE html>
<html>
<head>
      <?php require '../navAdmi.php'; ?>
    <title>Editar Aprendiz</title>
    <link rel="icon" type="image/png" sizes="16x16" href="../situ.png">
   <meta charset="utf-8">
   <link rel="stylesheet" type="text/css" href="../estilos.css">
  <link rel="stylesheet" type="text/css" href="../Assets/fonts/style.css">
  <link rel="stylesheet" type="text/css" href="../Assets/bootstrap-4.3.1-dist/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="../css/sweetalert.css">
<script type="text/javascript" src="../js/sweetalert.js"></script>

</head>
<body class=" bg-white">

<?php require"../navegacion.php";?>
    
          <div align="center" class="container">
   <div style="margin-left: 100px; margin-right: 100px;">
<br>

    <?php

     echo '<br>'.resultBlock($errors);
?>
  <?php

if (isset($tokenBD)){
  if (!empty($tokenBD)){
if (!isset($actualizado)){


 
?>
</div>

        <h1 class="font-weight-bold">EDITAR APRENDIZ</h1>
 <br>    
   <form role="form" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" autocomplete="off">
   <input type="hidden"  value="<?= $token?> "  class="campos" hidden name="token" >  

<div class="form-row">
       <div class="form-group col-md-4">        
        <label class="font-weight-bold">Documento:</label>
        <input type="text" value='<?= $id_aprendiz?>' name="id_aprendiz" class="form-control font-weight-bold " readonly="readonly" require="">
      </div>
        
      <div class="form-group col-md-4">
         <label class="font-weight-bold">Tipo Documento:</label>
      <select  class="form-control"  name="tipoDocumento" id="tipoDocumento">    
        <option class="font-weight-bold"  value="0">Seleccione un Tipo</option>
          <option value="1">Tarjeta de Identidad </option>
            <option value="2">Cédula de Ciudadanía</option>
      </select>
      </div>
  
         <div class="form-group col-md-4">
            <label class="font-weight-bold">Nombres:</label>
            <input type="text" value='<?= $nombres?>' name="nombres" id="" class="form-control font-weight-bold " require="">
         </div>  
</div>      

<div class="form-row">
   <div class="form-group col-md-4">
      <label class="font-weight-bold">Apellidos:</label>
     <input type="text" value='<?= $apellidos ?>' name="apellidos" id="" class="form-control font-weight-bold " require="">
   </div>
    
    <div class="form-group col-md-4"> 
      <label class="font-weight-bold">Telefono:</label>
      <input type="text" value='<?= $telefono?>'name="telefono" id="" class="form-control font-weight-bold " require="">
    </div>
    
    <div class="form-group col-md-4"> 
 
    <?php
      $sql2="SELECT * FROM ficha ORDER BY id_ficha ASC";
      if($conectarBD->query($sql2)-> num_rows > 0) {
    ?>

      <label  class="font-weight-bold">Numero Ficha:</label>
      <select type="text" class="form-control" name="id_ficha" id="id_ficha" required="" class="campos">
      <option value="0">Selecciona uno </option>
      <?php
        foreach($conectarBD->query($sql2) as $ficha) {
      ?>
      <option value="<?php  echo $ficha['id_ficha']; ?>">
    <?php echo $ficha['id_ficha']; ?>
    </option>
    <?php
        }
      }   
    ?>
      </select>
      </div> 
</div>
      
          <div class="form-row">  
            <div class="form-group col-md-4">
            <label class="font-weight-bold">Sexo:</label>
            <input type="text" value='<?= $sexo?>' name="sexo" id="" class="form-control font-weight-bold " readonly="readonly" require="" >
          </div>
        
          <div class="form-group col-md-4">
            <label class="font-weight-bold">Sexo:</label>
            <select id="sexo" name="sexo"  class="form-control " require="">
                <option value="0">Seleccione...</option>
                <option value="1">Masculino</option>
                <option value="2">Femenino</option>
            </select>
          </div>
  
           <div class="form-group col-md-4">
            <label class="font-weight-bold">Correo:</label>
            <br>
            <input type="email"value='<?= $correo?>' name="correo" id="" class="form-control font-weight-bold " require="">
            </div>
          </div>
            <br>

          <div align="center">
                <button type="reset" title="Limpiar Registro" class="btn" >
                  <i class="icon-loop2 text-secondary" style="font-size: 35px;"></i> 
                </button>

                <button type="button" class="btn" title="Cancelar Registro"  onclick="window.location.href='./listarAprendices.php'">
                    <i class="icon-cancel text-danger" style="font-size: 50px;"> </i>
                </button>

                <button type="submit"  class="btn font-weight-bold "  title="Actualizar Aprendiz">
                <i class="icon-checkmark1 text-success" style="font-size: 50px;"></i>
                </button>
          </div> 
  
  </form>
   <?php
 }else{
  echo $actualizado;
 }

 }
  
 
}else{
 require '../errorAlgoSM.php';
 }
?>

    </div>     
<script type="text/javascript" src="../Assets/Jquery/jQuery_v3.4.1.js"></script>
<script type="text/javascript" src="../Assets/bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../Assets/Js/vue.js"></script>
<script type="text/javascript" src="../Assets/sweetalert2/sweetalert2.all.min.js"></script>


</body>
</html>