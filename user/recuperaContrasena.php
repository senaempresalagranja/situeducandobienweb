<?php
session_start();
require '../conecion.php';
require '../Assets/funcion.php';
?>
<!DOCTYPE html>
<html>
<head>
     <link rel="stylesheet" type="text/css" href="../css/sweetalert.css">
  <link rel="icon" type="image/png" sizes="16x16" href="../situ.png">
    <title>Recupera Contraseña</title>
    
<link rel="stylesheet" type="text/css" href="estilos.css">
<link rel="stylesheet" type="text/css" href="../Assets/fonts/style.css">
<link rel="stylesheet" type="text/css" href="../Assets/bootstrap-4.3.1-dist/css/bootstrap.min.css
">

</head>
<body class="bg-white">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<?php 

$errors = array();

if (!empty($_POST)) {
    $email = $conectarBD->real_escape_string( $_POST['usuario']);
    if (!isEmail($email)) {
         
         $errors[] = 'Ingrese Un Correo Valido';
     }
        if( emailExiste($email))
    {
        $idUsuario = getValor('id','email',$email);
        $nombre = getValor('usuario','email',$email);

        $token= md5($idUsuario."+".$email);
        $sql = "UPDATE usuarios SET token ='$token' WHERE id =$idUsuario";
    
        if($conectarBD->query($sql)==TRUE){
           
            
        $url = 'http://'.$_SERVER["SERVER_NAME"].'/user/cambiaContrasena.php?id='.$idUsuario.'&token='.$token;
 


        $asunto ='Recuperacion de contraseña de SITU';
        $cuerpo="Hola $nombre: <br/> <br/> se ha solicitado un Cambio de Contraseña
        <br/> <br/> Para Cambiar tu Contraseña dale Click aqui
        <a href='$url'>Cambiar Contraseña</a>"; 
        
         if (enviarEmail($email, $nombre ,$asunto,$cuerpo)) {
          //echo "<br>". $url;
           $sqlCambioCon="UPDATE usuarios SET cambioContrasena= 1 WHERE token='$token'";
           if ($conectarBD->query($sqlCambioCon) == TRUE) {
             
                         echo"<script type='text/javascript'>
Swal.fire(
  'Correo Enviado!',
  'Se ha enviado un correo para que actualize su contraseña',
  'success'
)

</script>";
              } 
        }
    }else{
    echo "<script type='text/javascript'>
Swal.fire({
  icon: 'error',
  title: 'Oops...',
  text: 'Ha ocurrido un error al enviar el correo',
  footer: 'Revisa tu conexion a internet o verifica que este bien escrito el'
})
</script>";
        }
    }else{
    echo "<script type='text/javascript'>
Swal.fire({
  icon: 'error',
  title: 'Oops...',
  text: 'Ha ocurrido un error al enviar el correo',
  footer: 'Revisa tu conexion a internet o verifica que este bien escrito el correo'
})
</script>";
        }
}
?>
  
 <h1  align="center" class="text-info"><a class="font-weight-bold"  >Recupera Tú Contraseña</a></h1> 
<main role="main" class="container my-auto">
            <div class="row">

            
                <div id="login" class="col-lg-4 offset-lg-4 col-md-6 offset-md-3
                    col-12">
                   
                   
                        <form method='post' action='<?php $_SERVER["PHP_SELF"]; ?>' autocomplete='off' >
                    <br>
                   
                    <div class="input-group">
                <div class="input-group-append ">
                       <button class="btn btn-light">  <i class="icon-mail" style="color:red; font-size:23px;"></i></button>       
                        <input type="Email"  name="usuario" id="usuario"  class="form-control" required="" placeholder="@misena.edu.co">
                        </div>
                    </div>  
                        <br>
                        <div class="form-group mx-sm-3 mb-2">
                        <button type="submit"  class="btn btn-warning form-control font-weight-bold"><i class="icon-unlocked1 text-primary"></i> Recuperar</button>
                        </div>                       
                    </form>
                
                      <?php 
                      echo resultBlock($errors);
          
          ?>
                    <a  class="font-weight-bold" href="../index.php" ><span class="icon-user text-danger"></span> Iniciar Sessión</a>
                </div>
        
        </main>
</div>
<br><br>


<script type="text/javascript" src="../Assets/Jquery/jQuery_v3.4.1.js"></script>
<script type="text/javascript" src="../Assets/bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>
<script type="text/javascript">
	document.getElementById("usuario").focus();
</script>
</body>
</html>

