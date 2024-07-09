<?php 
session_start();
require '../conecion.php';
require '../Assets/funcion.php';

$idUser=$_SESSION['id'];
if ($idUser!=1) {
    echo "<script>window.location.href='../administrador/paginaPrincipal.php'; </script>";  
}

$tipoUsuario = $_SESSION['tipo'];

if(empty($_SESSION['tipo'])) {

    echo "<script>window.location.href='../index.php'; </script>";  
}
?>

<!DOCTYPE html>

<html>

<head>

	<?php require '../navAdmi.php'; ?>

	<title>Editar Memorando</title>

      <link rel="icon" type="image/png" sizes="16x16" href="../situ.png">

	<meta charset="utf-8">

  <link rel="stylesheet" type="text/css" href="../Assets/fonts/style.css">

  <link rel="stylesheet" type="text/css" href="../Assets/bootstrap-4.3.1-dist/css/bootstrap.min.css

">

</head>

<body class="bg-white">

	<?php include '../navegacion.php'; 

	if($conectarBD->connect_error){

    	die( require '../errorAlgoSM.php');

    }



	$sqlI='SELECT * from memorandopdf WHERE id_memorando =1';



    if($conectarBD->query($sqlI)->num_rows > 0){

	$id_memorando =$conectarBD->query($sqlI)->fetch_assoc()['id_memorando'];

	$tituloM =$conectarBD->query($sqlI)->fetch_assoc()['tituloM'];

	$ciudadDepartamento =$conectarBD->query($sqlI)->fetch_assoc()['ciudadDepartamento'];

	$asuntoM =$conectarBD->query($sqlI)->fetch_assoc()['asuntoM'];

	$cabezaM =$conectarBD->query($sqlI)->fetch_assoc()['cabezaM'];

	$cuerpoM =$conectarBD->query($sqlI)->fetch_assoc()['cuerpoM'];

	$notaM =$conectarBD->query($sqlI)->fetch_assoc()['notaM'];

	$tituloF =$conectarBD->query($sqlI)->fetch_assoc()['tituloFirmas'];

	$token =$conectarBD->query($sqlI)->fetch_assoc()['token'];



	}    



$errors = array();

    

      

      if(!empty($_POST)) {

    

        $tituloMBD       = $conectarBD->real_escape_string($_POST['tituloM']);

        $ciudadDepartamentoBD     = $conectarBD->real_escape_string($_POST['ciudadDepartamento']);

        $asuntoMBD     = $conectarBD->real_escape_string($_POST['asuntoM']);

        $cabezaMBD   = $conectarBD->real_escape_string($_POST['cabezaM']);

        $cuerpoMBD      = $conectarBD->real_escape_string($_POST['cuerpoM']);

        $notaMBD   = $conectarBD->real_escape_string($_POST['notaM']);

        $tituloFBD   = $conectarBD->real_escape_string($_POST['tituloF']);

        $tokenBD   = $conectarBD->real_escape_string($_POST['token']);

     









        if (!empty($tituloMBD)){          

          if (!empty($ciudadDepartamentoBD)) {          

          if (!empty($asuntoMBD)) {

          if (!empty($cabezaMBD)) {

          if (!empty($cuerpoMBD)) {

          if (!empty($notaMBD)) {

          if (!empty($tituloFBD)) {



            $sql="UPDATE memorandopdf SET tituloM='$tituloMBD', ciudadDepartamento='$ciudadDepartamentoBD', asuntoM='$asuntoMBD',cabezaM='$cabezaMBD',cuerpoM='$cuerpoMBD',notaM='$notaMBD',tituloFirmas='$tituloFBD' WHERE token ='$tokenBD'";

                  

         

  

        if($conectarBD->query($sql)==TRUE){

          $errors[]=die("<div align='center' style='margin-top:5%;'><i class='icon-checkmark1 text-success' style='font-size: 70px'></i><br><h5 class='font-weight-bold text-dark'>Actualizado Con Exito</h5><br>

            <a class='btn btn-warning font-weight-bold' href='verMemorando.php'>Ver Memorando</a></div>");

                  }else{

                    $errors[]= die(require '../errorAlgoSM.php');

                  

                 }

            

          }else{

            $errors[]="<h5 class='text-dark'>Debe llenar El Campo de La Nota de la Firma</h5>";

          }

          }else{

            $errors[]="<h5 class='text-dark'>La Nota del del Memorando Esta vacia</h5>";

          

          }

          }else{

               $errors[]="<h5 class='text-dark'>Debe llenar El Campo de la Estructura del Memorando</h5>";

          

          }



          }else{

             $errors[]="<h5 class='text-dark'>Debe llenar El Campo de Cabeza del Memorando</h5>";

  

          }

        }else{

            $errors[]="<h5 class='text-dark'>Debe llenar El Campo del Asunto del Memorando</h5>";

          

        }

      }else{

        $errors[]="<h5 class='text-dark'>Debe llenar El Campo de Cuidad & Departamento</h5>";

      }

    }else{

       $errors[]="<h5 class='text-dark'>Debe llenar El Campo del Titulo del Memorando</h5>";

    }



  }

   

	if(!empty($errors)) {

	?>

 <div class="alert-danger"  style="margin-left: 350px; margin-right: 350px; margin-top: 3%;">

         <br><?php echo resultBlock($errors);?><br>         

       </div>

       

<?php } ?>

		<div align="center" class="container" style="margin-top: 3%;">

		<h2 class="font-weight-bold">EDITAR MEMORANDO</h2>

        <br>

            <div class="form-row">

       <div class="form-group col-md-4">

            

                <form method="post" action="#">

              <input type="hidden" name="token" value="<?php echo $token; ?>">

            <label class="font-weight-bold">Titulo:</label>

            <input type="text" class="form-control " name="tituloM" placeholder="MEMORANDO" required="" id="tituloM" value="<?php if(isset($tituloMBD)){echo $tituloMBD;}else{ echo $tituloM;} ?>"  >

            </div>

            <div class="form-group col-md-4">      

            <label class="font-weight-bold">Ciudad & Departamento:</label>

            <input type="text"  class="form-control "name="ciudadDepartamento" required="" id="ciudadDepartamento" placeholder="Espinal-Tolima" value="<?php if(isset($ciudadDepartamentoBD)){echo $ciudadDepartamentoBD;}else{ echo $ciudadDepartamento; }?>" >

            </div>

            <div class="form-group col-md-4">

            <label class="font-weight-bold">Asunto:</label>

            <input type="text" class="form-control " name="asuntoM" required="" id="asuntoM" placeholder="Memorando por..." value="<?php if(isset($asuntoMBD)){echo $asuntoMBD;}else{ echo $asuntoM;} ?>" >

             </div>

            </div>

            <div class="form-row">

              <div class="form-group col-md-4">           

            <label class="font-weight-bold">Cabeza De Memorando:</label>

            <textarea type="text" class="form-control " name="cabezaM"  required="" id="cabezaM"  placeholder="Me permito notificarle que por incumplimiento...." ><?php if(isset($cabezaMBD)){ echo $cabezaMBD; }else{echo $cabezaM;}?></textarea>

            </div>

            <div class="form-group col-md-4"> 

            <label class="font-weight-bold">Estructura Del Memorando:</label>

            <textarea type="text" class="form-control " name="cuerpoM" required="" id="cuerpoM" placeholder="Usted no ha asistio al Turno Especial..." ><?php if(isset($cuerpoMBD)){ echo $cuerpoM;}else{echo $cuerpoM;} ?></textarea>

            </div>

            <div class="form-group col-md-4"> 

            <label class="font-weight-bold">Nota Del Memorando:</label>

            <textarea type="" class="form-control " name="notaM" required="" id="notaM" placeholder="Este correctivo se realizará de acuerdo a la norma..." ><?php if(isset($notaMBD)){ echo $notaMBD;}else{ echo $notaM;} ?></textarea>

            </div>

        </div>

            <div class="form-row">

            <div class="form-group col-md-4">               

            <label class="font-weight-bold">Escribe Una Nota antes De Agregar Firmas:</label>  

            <input type="text" name="tituloF" id="tituloF" placeholder="Para Constancia de lo anterios Firma" required="" class="form-control " value="<?php if(isset($tituloFBD)){ echo $tituloF;}else{echo $tituloF;} ?>" >

            </div>

            </div>         

            <div>



  <button type="reset" title="Limpiar Registro" class="btn" >

    <i class="icon-loop2 text-secondary" style="font-size: 35px;"></i> 

  </button>



    <button type="button" class="btn" title="Cancelar"  onclick="window.location.href='./verMemorando.php'">

          <i class="icon-cancel text-danger" style="font-size: 50px;"> </i>

    </button>

    



  <button type="submit"  class="btn font-weight-bold "  title="Actualizar Memorando">

  <i class="icon-checkmark1 text-success" style="font-size: 50px;"></i>

  </button>

 </div> 

                    </form>  

        

	</div>







<script type="text/javascript" src="../Assets/Jquery/jQuery_v3.4.1.js"></script>

<script type="text/javascript" src="../Assets/bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>

<script type="text/javascript" src="../Assets/Js/vue.js"></script>

<script type="text/javascript" src="../Assets/sweetalert2/sweetalert2.all.min.js"></script>

</body>

</html>