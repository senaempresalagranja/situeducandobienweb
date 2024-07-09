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

    $errors = array();

    

      

      if(!empty($_POST)) {

    

      $tituloM       = $conectarBD->real_escape_string($_POST['tituloM']);

      $ciudadDepartamento     = $conectarBD->real_escape_string($_POST['ciudadDepartamento']);

        $asuntoM     = $conectarBD->real_escape_string($_POST['asuntoM']);

        $cabezaM   = $conectarBD->real_escape_string($_POST['cabezaM']);

        $cuerpoM      = $conectarBD->real_escape_string($_POST['cuerpoM']);

        $notaM   = $conectarBD->real_escape_string($_POST['notaM']);

        $tituloF   = $conectarBD->real_escape_string($_POST['tituloF']);



         if (isNullM($tituloM, $ciudadDepartamento, $asuntoM, $cabezaM, $cuerpoM,$notaM,$tituloF)) {

          $errors[]="<h5 class='text-dark'>Debe llenar Todos los Campos <i class='icon-warning text-warning ' style='margin-left:40px; font-size:50px;'></i></h5>";

         

        }

         if (!empty($tituloM)){          

          if (!empty($ciudadDepartamento)) {          

          if (!empty($asuntoM)) {

          if (!empty($cabezaM)) {

          if (!empty($cuerpoM)) {

          if (!empty($notaM)) {

          if (!empty($tituloF)) {

            $token= md5($tituloM.'+'.$tituloF);

                  $sql="INSERT INTO memorandoPDF (tituloM,ciudadDepartamento,asuntoM,cabezaM,cuerpoM,notaM,tituloFirmas,token)

              VALUES('$tituloM','$ciudadDepartamento','$asuntoM','$cabezaM','$cuerpoM','$notaM','$tituloF','$token')";

  

        if($conectarBD->query($sql)==TRUE){

          $errors[]="<i class='icon-checkmark1 text-success' style='font-size: 40px'></i><br><h5 class='font-weight-bold text-dark'>Memorando Creado</h5><br>

            <a class='btn btn-warning font-weight-bold' href='verMemorando.php'>Ver Memorando</a>";

                  }else{

                    $errors[]= "<h5> oh! Algo salio Mal<i ></h5>";

                  

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



  







?>

<!DOCTYPE html>

<html>

    <head>

        <?php require '../navAdmi.php'; ?>

        <title>Registrar Memorando</title>

            <link rel="icon" type="image/png" sizes="16x16" href="../situ.png">

         <meta charset="utf-8">

   <link rel="stylesheet" type="text/css" href="../estilos.css">

  <link rel="stylesheet" type="text/css" href="../Assets/fonts/style.css">

  <link rel="stylesheet" type="text/css" href="../Assets/bootstrap-4.3.1-dist/css/bootstrap.min.css

">

    </head>

    <body class="bg-white">

   <?php include '../navegacion.php';?>

    <br> <br>

    

      <?php 

        $sqlM='SELECT * from memorandoPDF WHERE id_memorando =1';

    if (empty(!$sqlM)) {

    if( $conectarBD->query($sqlM)->num_rows > 0){

      $id_memorando =$conectarBD->query($sqlM)->fetch_assoc()['id_memorando'];

      if ($id_memorando==1) {

        die('

        

        

        <div align="center">

          <i class="icon-cancel text-danger" style="font-size: 100px;"></i>

          <h1 class="font-weight-bold">Ya Existe Un Memorando Creado <br> Solo Puedes Registrar Uno</h1><br>

          <a class="btn btn-warning font-weight-bold text-light" href="verMemorando.php">Ver El Memorando</a>

        </div>

     <?php

   ');

      }

    }}



       ?>

    

    <div style="margin-left: 350px; margin-right: 350px;">

         <?php echo resultBlock($errors);?>

       </div>

       <?php 

              if (empty($sql)) {

              

          ?>

 	<div align="center" class="container" >

		<h2 class="font-weight-bold">REGISTRAR MEMORANDO</h2>

        <br>

            <div class="form-row">

       <div class="form-group col-md-4">

            

                <form method="post" action="#">

            <label class="font-weight-bold">Titulo:</label>

            <input type="text" class="form-control " name="tituloM" placeholder="MEMORANDO" required="" id="tituloM" value="<?php if(isset($tituloM)) echo $tituloM; ?>"  >

            </div>

            <div class="form-group col-md-4">      

            <label class="font-weight-bold">Ciudad & Departamento:</label>

            <input type="text"  class="form-control "name="ciudadDepartamento" required="" id="ciudadDepartamento" placeholder="Espinal-Tolima" value="<?php if(isset($ciudadDepartamento)) echo $ciudadDepartamento; ?>" >

            </div>

            <div class="form-group col-md-4">

            <label class="font-weight-bold">Asunto:</label>

            <input type="text" class="form-control " name="asuntoM" required="" id="asuntoM" placeholder="Memorando por..." value="<?php if(isset($asuntoM)) echo $asuntoM; ?>" >

             </div>

            </div>

            <div class="form-row">

              <div class="form-group col-md-4">           

            <label class="font-weight-bold">Cabeza De Memorando:</label>

            <textarea type="text" class="form-control " name="cabezaM"  required="" id="cabezaM"  placeholder="Me permito notificarle que por incumplimiento...." value="<?php if(isset($cabezaM)) echo $cabezaM; ?>" ><?php if(isset($cabezaM)) echo $cabezaM; ?></textarea>

            </div>

            <div class="form-group col-md-4"> 

            <label class="font-weight-bold">Estructura Del Memorando:</label>

            <textarea type="text" class="form-control " name="cuerpoM" required="" id="cuerpoM" placeholder="Usted no ha asistio al Turno Especial..." value="<?php if(isset($cuerpoM)) echo $cuerpoM; ?>" ><?php if(isset($cuerpoM)) echo $cuerpoM; ?></textarea>

            </div>

            <div class="form-group col-md-4"> 

            <label class="font-weight-bold">Nota Del Memorando:</label>

            <textarea type="" class="form-control " name="notaM" required="" id="notaM" placeholder="Este correctivo se realizará de acuerdo a la norma..." value="<?php if(isset($notaM)) echo $notaM; ?>" ><?php if(isset($notaM)) echo $notaM; ?></textarea>

            </div>

        </div>

            <div class="form-row">

            <div class="form-group col-md-4">               

            <label class="font-weight-bold">Escribe Una Nota antes De Agregar Firmas:</label>  

            <input type="text" name="tituloF" id="tituloF" placeholder="Para Constancia de lo anterios Firma" required="" class="form-control " value="<?php if(isset($tituloF)) echo $tituloF; ?>" >

            </div>

            </div>         

            <div>



  <button type="reset" title="Limpiar Registro" class="btn" >

    <i class="icon-loop2 text-secondary" style="font-size: 35px;"></i> 

  </button>



    <button type="button" class="btn" title="Cancelar Registro"  onclick="window.location.href='../administrador/paginaPrincipal.php'">

          <i class="icon-cancel text-danger" style="font-size: 50px;"> </i>

    </button>

    



  <button type="submit"  class="btn font-weight-bold "  title="Registrar Aprendiz">

  <i class="icon-checkmark1 text-success" style="font-size: 50px;"></i>

  </button>

 </div> 

                    </form>  

        

	</div>

      <?php  

       }

     

       ?> 

	<script type="text/javascript" src="../Assets/Jquery/jQuery_v3.4.1.js"></script>

<script type="text/javascript" src="../Assets/bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>

<script type="text/javascript" src="../Assets/Js/vue.js"></script>

<script type="text/javascript" src="../Assets/sweetalert2/sweetalert2.all.min.js"></script>

    

    </body>

</html>

