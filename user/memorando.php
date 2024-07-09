<?php
session_start();

$idUser=$_SESSION['id'];
$tipoUsuario = $_SESSION['tipo'];
    if (empty($_SESSION['tipo'])) {
        echo "<script>window.location.href='../index.php'; </script>";  
    } 

if ($tipoUsuario !='administrador') {  
    echo "<script>window.location.href='../administrador/paginaPrincipal.php'; </script>";  
}
?>

	<title>MEMORANDO</title>

<link rel="icon" type="image/png" sizes="16x16" href="../situ.png">
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
<link rel="stylesheet" type="text/css" href="../estilos.css">
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

	<?php



	require_once '../conecion.php';

	

date_default_timezone_set('America/Bogota');

$codigoTurno=$_GET['codigoTurno'];

$sqlT="SELECT * FROM Turnorutinario WHERE codigoTurno = '$codigoTurno'";

if ($conectarBD->query($sqlT)==TRUE) {

	$documento = $conectarBD->query($sqlT)->fetch_assoc()['id_aprendiz'];

	$ficha = $conectarBD->query($sqlT)->fetch_assoc()['id_ficha'];

	$codigoUnidad = $conectarBD->query($sqlT)->fetch_assoc()['codigoUnidad'];

	$fechaTurno = $conectarBD->query($sqlT)->fetch_assoc()['fechaTurno'];

}



 $valores = explode('-', $fechaTurno);

  if(count($valores) == 3 && checkdate($valores[1], $valores[2], $valores[0])){

    $anoT=$valores[0];

    $mesT=$valores[1];

    $diaT=$valores[2];

    

   

     } 

switch ($mesT) {

	case '01':

		$mesT ='Enero';

		break;

		case '02':

		$mesT ='Febrero';

		break;

		case '03':

		$mesT ='Marzo';

		break;

	

	case '04':

		$mesT ='Abril';

		break;

		case '05':

		$mesT ='Mayo';

		break;

		case '06':

		$mesT ='Junio';

		break;

	case '07':

		$mesT ='Julio';

		break;

		case '08':

		$mesT ='Agosto';

		break;

		case '09':

		$mesT ='Septiembre';

		break;

	

	case '10':

		$mesT ='Octubre';

		break;

		case '11':

		$mesT ='Noviembre';

		break;

		case '12':

		$mesT ='Diciembre';

		break;

}





 $fechaT ="el dia ".$diaT." de ".$mesT." del ".$anoT ;





$sqlA="SELECT * FROM aprendiz WHERE id_aprendiz ='$documento'";

if ($conectarBD->query($sqlA)==TRUE) {

	$nombres = $conectarBD->query($sqlA)->fetch_assoc()['nombres'];

	$apellidos = $conectarBD->query($sqlA)->fetch_assoc()['apellidos'];

	

}

$sqlU="SELECT * FROM unidad WHERE codigoUnidad ='$codigoUnidad' ";

if ($conectarBD->query($sqlU)==TRUE) {

	$nombreUnidad = $conectarBD->query($sqlU)->fetch_assoc()['nombreUnidad'];

}



$sqlF="SELECT * FROM ficha WHERE id_ficha = '$ficha'";

if ($conectarBD->query($sqlU)==TRUE) {

	$id_programaF = $conectarBD->query($sqlF)->fetch_assoc()['id_programaF'];

}

$sqlP="SELECT * FROM programas WHERE id_programaF = '$id_programaF'";

if ($conectarBD->query($sqlP)==TRUE) {

	$nombreP = $conectarBD->query($sqlP)->fetch_assoc()['nombreP'];

}





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



$sql='SELECT * from memorandoPDF WHERE id_memorando =1';

$id_memorando =$conectarBD->query($sql)->fetch_assoc()['id_memorando'];

if (empty(!$sql)) {

    if( $conectarBD->query($sql)->num_rows > 0){

    	

    



   foreach ($conectarBD->query($sql) as $fila){

    

    

	

?>

<div class="container " >

	

		

	<br><br>

	<div style="margin-left: 10%; margin-right: 20%; margin-top: -20px; color: black;" >



<br>

		<div style="margin-top:3%; ">

		<h2 align="center" class="date"> <?php echo $fila['tituloM'];?></h2>

		

		<h3 class="cuidad date"><span class="date"><?php  echo "Espinal ".$dia." de ".$m." del ".$ano;?></span></h3>

		<h3 align="right" class="cuidad date" style="margin-top: -30px;">N° <span ><?php echo $trimestre; ?></span></h3>

		<h4  style="font-weight: bold;">Aprendiz</h4>

		<h4 style="margin-top: -20px;"><span><?php echo $nombres." ".$apellidos; ?></span></h4>

		<h4 style="margin-top: -20px;"><span style="font-weight: bold; "><?php echo $nombreP; ?></span></h4>

		<h4 style="margin-top: -18px; font-weight: bold; ">Ficha:<span  style="font-weight: none; "><?php echo $ficha; ?></span></h4>

		<h4 style="margin-top: -18px; font-weight: bold; ">Unidad:<span style="font-weight: none; " ><?php echo $nombreUnidad; ?></span></h4>

		<h3 align="center" class="date cuidad">Asunto: <?php echo $fila['asuntoM'];?></h3>

		<h4 style="margin-top: 20px;" > <?php echo $fila['cabezaM'];?></h4>

		<h4 style="margin-top: 10px;"><b style="font-weight: bold; ">El aprendiz no cumple con el Turno que sena empresa le asigno,  <?php echo $fechaT; ?></b><br> <?php echo $fila['cuerpoM'];?> </h4> 

		<h4 style="margin-top: 10px;"><b style="font-weight: bold; ">NOTA:</b> <?php echo $fila['notaM'];?></h4>

		<h4 style="margin-top: 20px;"> <?php echo $fila['tituloFirmas'];?></h4>

	</div>

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

   

			<div style="margin-top: 40px;">

				<div >

					<div>

					<img src="<?php echo $fotoUrl1; ?>" style=" width:150px; height: 100px; "/>

					</div>

					<div style="margin-top: -20px;">

					<h1>__________</h1>

					<h5 style="font-weight: bold;margin-top: -25px;"><?php echo $quienFirma1;?></h5>

					<h5 style="font-weight: bold; margin-top: -15px;">Cargo: <?php echo $cargoQF1;?></h5>

					</div>

				</div>

				<div style="margin-left: 40px;">

				<div align="right" style="margin-top: -145px; margin-right: 40px;">

				<img src="<?php echo $fotoUrl2; ?>" style=" width:150px; height: 100px; "/>

				<h1 style="margin-top: -20px;">__________</h1>

				<h5 style="font-weight: bold;margin-top: -25px;"><?php echo $quienFirma2;?></h5>

				<h5 style="font-weight: bold; margin-top: -15px;">Cargo: <?php echo $cargoQF2;?></h5>

				</div>

			</div>

			</div>

					

				

			

		<br><br><br>

		<?php 

				

				

			}

		}

	}

	

	

		?>

	</div>

</div>



</body>

	<script type="text/javascript" src="../Assets/Jquery/jQuery_v3.4.1.js"></script>

<script type="text/javascript" src="../Assets/bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>

<script type="text/javascript" src="../Assets/Js/vue.js"></script>

<script type="text/javascript" src="../Assets/sweetalert2/sweetalert2.all.min.js"></script>

    

</html>