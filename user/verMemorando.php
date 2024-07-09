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

	<title>VER MEMORANDO</title>

	    <link rel="icon" type="image/png" sizes="16x16" href="../situ.png">

         <meta charset="utf-8">

  <link rel="stylesheet" type="text/css" href="../Assets/fonts/style.css">

  <link rel="stylesheet" type="text/css" href="../Assets/bootstrap-4.3.1-dist/css/bootstrap.min.css

">

</head>

		<style type="text/css">

			.firmas{

				font-size: 20px;

				margin-right: -100px;

			}

			.cuidad{

				font-size: 15px;

			}

			.fecha{

				font-size: 18px;

			}

			.date{

				font-weight: bold;

			}

			.cabezaM{

				font-size: 18px;

			}

			

		</style>

<body class="bg-white">

	<?php include '../navegacion.php';





if($conectarBD->connect_error){

    die( require '../errorAlgoSM.php');

    

    

}

date_default_timezone_set('America/Bogota');



$ano=date('Y');

$mes=date('m'); 

$dia =date('d');

$t =0;





if ($mes<='03') {

	$t =1;

	

} if ($mes>'03') {

	if ($mes<='06') {

	$t=2;

	

}

}

if ($mes>'06') {

	if ($mes<='09') {	

	$t=3;

	

}

}

if ($mes>'09') {

	if ($mes<='12') {

	$t=4;

	

}

}



switch ($t) {

	case '1':

		$numeroM='00';

		$numeroM=$numeroM+'01';



		break;

	case '2':

		$numeroM='00';

		$numeroM=$numeroM+'01';



		break;

	case '3':

		$numeroM='00';

		$numeroM=$numeroM+'01';



		break;

	case '4':

		$numeroM='00';

		$numeroM=$numeroM+'01';



		break;

	

	}



$trimestre='T'.$t.$ano.' - '.$numeroM;

$m="";

switch ($mes) {

	case '01':

		$m ='Enero';

		break;

		case '02':

		$m ='Febrero';

		break;

		case '03':

		$m ='Marzo';

		break;

	

	case '04':

		$m ='Abril';

		break;

		case '05':

		$m ='Mayo';

		break;

		case '06':

		$m ='Junio';

		break;

	case '07':

		$m ='Julio';

		break;

		case '08':

		$m ='Agosto';

		break;

		case '09':

		$m ='Septiembre';

		break;

	

	case '10':

		$m ='Octubre';

		break;

		case '11':

		$m ='Noviembre';

		break;

		case '12':

		$m ='Diciembre';

		break;

}



$sql='SELECT * from memorandopdf WHERE id_memorando =1';

$id_memorando =$conectarBD->query($sql)->fetch_assoc()['id_memorando'];

if (empty(!$sql)) {

    if( $conectarBD->query($sql)->num_rows > 0){

    

   foreach ($conectarBD->query($sql) as $fila){

    

?>

<div style="margin-left: 120px; margin-top: 4%;"> 

<a href="./listarFirmas.php" class="btn btn-success font-weight-bold">Ver Firmas</a>

</div>

<div  style="margin-left:  80%; margin-top: -3%;"> 

<a href="./editarMemorando.php" class="btn btn-secondary font-weight-bold"><i class="icon-edit" style="font-size: 20px;"></i>Editar Memorando</a>



</div>

<div align="center">

	<h2 class="font-weight-bold">Esta Es la Plantilla del Memorando<br> que Se Envia al Aprendiz </h2>

</div>



<div class="container " style="margin-top: 20px; height: 150%; width: 60%; border: solid 1px; background-color: white; ">

	<br><br>

	<div style="margin-top:3%; margin-right: 70px; margin-left: 70px;">

		<h2 align="center" class="date"> <?php echo $fila['tituloM'];?></h2>

		<br><br>

		<h4 class="cuidad date"><span class="date"><?php  echo "Espinal ".$dia." de ".$m." del ".$ano;?></span></h4>

		<h4 align="right" class="cuidad date" style="margin-top: -30px;">N° <span ><?php echo $trimestre; ?></span></h4>

		<h6 class="cuidad date" style="font-weight: bold;">Aprendiz</h6>

		<h6 class="cuidad date"	 style="margin-top: 20px;"><span><?php if (isset($nombres,$apellidos)) { echo $nombres." ".$apellidos;} ?></span></h6>

		<h4 class="cuidad date" style="margin-top: 20px;"><span style="font-weight: bold; "><?php if (isset($nombresP)) { echo $nombreP; }?></span></h4>

		<h4 class="cuidad date" style="margin-top: -18px; font-weight: bold; ">Ficha:<span  style="font-weight: none; "><?php if (isset($ficha)) { echo $ficha; }?></span></h4>

		<h4 class="cuidad date" style="margin-top: -10px; font-weight: bold; ">Unidad:<span style="font-weight: none; " ><?php if (isset($nombreUnidad)) { echo $nombreUnidad; }?></span></h4>

		<h3 align="center" class="date cuidad">Asunto: <?php echo $fila['asuntoM'];?></h3>

		<h6  style="margin-top: 20px;" > <?php echo $fila['cabezaM'];?></h6>

		<h6 style="margin-top: 10px;"><b style="font-weight: bold; ">El aprendiz no cumple con el Turno que sena empresa le asigno,  <?php if (isset($fechaT)) {echo $fechaT; }?></b><br> <?php echo $fila['cuerpoM'];?> </h6>

		<br> 

		<h6 style="margin-top: 10px;"><b style="font-weight: bold; ">NOTA:</b> <?php echo $fila['notaM'];?></h6>

		<h6 style="margin-top: 20px;"> <?php echo $fila['tituloFirmas'];?></h6>

	

		<?php 

		



		require_once '../conecion.php';

	$sqlFirmas1 = "SELECT * FROM firma where estado = 1 ORDER BY  id_firma ASC";

	if ($conectarBD->query($sqlFirmas1)->num_rows > 0 ){

		$id =$conectarBD->query($sqlFirmas1)->fetch_assoc()['id_firma'];

		

		

		$fotoUrl1=$conectarBD->query($sqlFirmas1)->fetch_assoc()['fotoUrl'];

		$quienFirma1=$conectarBD->query($sqlFirmas1)->fetch_assoc()['quienFirma'];

		$cargoQF1=$conectarBD->query($sqlFirmas1)->fetch_assoc()['cargoQF'];

	}

		$sqlFirmas2 = "SELECT * FROM firma where estado = 1 ORDER BY  id_firma DESC";

	if ($conectarBD->query($sqlFirmas2)->num_rows > 0 ){

		$id2 =$conectarBD->query($sqlFirmas2)->fetch_assoc()['id_firma'];

		

		

		$fotoUrl2=$conectarBD->query($sqlFirmas2)->fetch_assoc()['fotoUrl'];

		$quienFirma2=$conectarBD->query($sqlFirmas2)->fetch_assoc()['quienFirma'];

		$cargoQF2=$conectarBD->query($sqlFirmas2)->fetch_assoc()['cargoQF'];

	}

	 

	 

?>

   

			<div style="margin-top: 80px;">

				<div style="margin-left: 70px;">

					<div>

					<img src="<?php echo $fotoUrl1; ?>" style=" width:120px; height: 80px; "/>

					</div>

					<div style="margin-top: -10px;">

					<h1>__________</h1>

					<h6 style="font-weight: bold;margin-top: -10px;"><?php echo $quienFirma1;?></h6>

					<h6 style="font-weight: bold; margin-top: -10px;">Cargo: <?php echo $cargoQF1;?></h6>

					</div>

				</div>

				<div style="margin-left: 80px;">

				<div align="right" style="margin-top: -165px; margin-right: 70px;">

				<img src="<?php echo $fotoUrl2; ?>" style=" width:120px; height: 80px; "/>

				<h1 style="margin-top: -2px;">__________</h1>

				<h6 style="font-weight: bold;margin-top: -10px;"><?php echo $quienFirma2;?></h6>

				<h6 style="font-weight: bold; margin-top: -10px;">Cargo: <?php echo $cargoQF2;?></h6>

				</div>

			</div>

			</div>

			</div>

		<br><br><br><br><br>

		</div>

</div>

	<div align="center" style="margin-top: 10%;">

		<h3 class="font-weight-bold text-secondary">Este Formato Sera Enviado al Aprendiz Por Medio Del<br>Correo Institusional con Dominio <span class="text-dark">@misena.edu.co</span> Que el SENA le Suministro</h3>

	</div>

	<br>

		<?php 

			}

		}

	}else{

		header('location: ./registrarMemorando.php');

	}

	?>

	

	<?php

	if ($id_memorando!=1){ 

						?>

		<div style="margin-top: 40px; margin-left: 10%;">

		<a class="btn btn-success font-weight-bold" href="registrarMemorando.php"><span class="icon-plus1">

		</span> Crear Memorando</a>

		<br>

		<h1 align="center">No hay Ningun Memorando Creado <br>

		 Debes Crearlo Para Visualizarlo</h1>

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