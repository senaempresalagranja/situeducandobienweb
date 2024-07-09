<!DOCTYPE html>
<html>
<head>
  <title></title>
  <link rel="stylesheet" type="text/css" href="../css/sweetalert.css">
  <link rel="icon" type="image/png" sizes="16x16" href="../situ.png">
</head>
<body>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<?php

require_once '../conecion.php';
require '../Assets/funcion.php';
date_default_timezone_set('America/Bogota');
session_start();



if($conectarBD->connect_error){
    die("Conexión fallida: ".$conectarBD->connect_error);
}

$codigoTurno = $_GET['codigoTurno'];

$sqlFallas="SELECT * FROM turnorutinario  WHERE codigoTurno='$codigoTurno'";
 if($conectarBD->query($sqlFallas)->num_rows > 0) {
                $Fallas = $conectarBD->query($sqlFallas)->fetch_assoc()['fallas'];
         
             }
$Fallas= $Fallas+1;
  $sqlF="UPDATE turnorutinario SET fallas='$Fallas' WHERE codigoTurno='$codigoTurno'";
if($conectarBD->query($sqlF)=== TRUE) {
          
$sqlC = "SELECT * FROM memorandos ORDER BY id_memorando DESC";

  $tokenMBD=$conectarBD->query($sqlC)->fetch_assoc()['token'];
  $idM=$conectarBD->query($sqlC)->fetch_assoc()['id_memorando'];

  $ano=date('Y');
  $mes=date('m'); 

  $dia =date('d');
  $t =0;

  if ($mes<='03') {
  $t ='1';
  
} if ($mes>'03') {
  if ($mes<='06') {
  $t='2';
  
}
}
if ($mes>'06') {
  if ($mes<='09') { 
  $t='3';
  
}
}
if ($mes>'09') {
  if ($mes<='12') {
  $t='4';
  
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

 $sqlT="SELECT * FROM turnorutinario WHERE codigoTurno ='$codigoTurno' ";
  if($conectarBD->query($sqlT)->num_rows > 0) {
  $codigoTurnos = $conectarBD->query($sqlT)->fetch_assoc()['codigoTurno'];
  $id_aprendiz = $conectarBD->query($sqlT)->fetch_assoc()['id_aprendiz'];           
              }else{
                echo "MAMELO2";
              }

    if(empty($idM)){
$id_memorando='T'.$t.$ano.' - '.'01';

}else{

   $valor = explode('-', $idM);
   
    $cDT=$valor[0];
    $cDTN=$valor[1];
  
    $cDTN = $cDTN+1;
  echo $id_memorando ='T'.$t.$ano.' - '.$cDTN;
}
    $tokenN=generateToken();
    $sqlME ="INSERT INTO  memorandos (id_memorando, codigoTurno, id_aprendiz, numerosM,token) VALUES ($id_memorando,'$codigoTurnos','$id_aprendiz','$numeroM','$tokenN')";
    echo $sqlME;
     if ($conectarBD->query($sqlME)==TRUE) {  
      $sqlNA="SELECT * FROM aprendiz WHERE id_aprendiz = '$id_aprendiz'";
      $nombres=$conectarBD->query($sqlNA)->fetch_assoc()['nombres'];
       $apellidos=$conectarBD->query($sqlNA)->fetch_assoc()['apellidos'];
        $email=$conectarBD->query($sqlNA)->fetch_assoc()['correo'];
   
        $nombre=$nombres." ".$apellidos;
   
       $url = 'http://'.$_SERVER["SERVER_NAME"].'/user/descargarMemorando.php?codigoTurno='.$codigoTurno;
 



      
        $asunto =' Notificada Con Un Memorando';
      
        $cuerpo="Sen@r ".$nombre." 
        Este Correo Es Para Notificarle Que A Su Hoja de Vida Le Ha sido Anexado 
        Un Memorando
        <a href='$url'>Ver Memorando</a>"; 
   
         if (enviarEmail($email, $nombre ,$asunto,$cuerpo)) {

        header('Refresh: 3; URL=listaTurnosRutinario.php');



      echo"<script type='text/javascript'>
Swal.fire(
  'Memorando Enviado!',
  'Se ha enviado el memorando correctamente',
  'success'
)

</script>";
        }

     }else{
      
       echo "<script type='text/javascript'>
Swal.fire({
  icon: 'error',
  title: 'Oops...',
  text: 'Ha ocurrido un error al enviar el memorando',
  footer: 'Revisa tu conexion a internet o verifica que no hayas enviado ya un memorando'
})
</script>";
     }

     
}
             $conectarBD->Close();

?>
</body>
</html>