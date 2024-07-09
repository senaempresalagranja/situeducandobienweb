<?php

require_once '../conecion.php';
require '../Assets/funcion.php';
session_start();
$idUser=$_SESION['id'];

if($conectarBD->connect_error){
	 echo "error en la consulta: ".$conectarBD->connect_error;
    header('location: ./listaUsuarios.php');
}
$token=$_POST['token'];
$usuario = $_POST['usuario'];
$tipoUser = $_POST['tipoUser'];
$email = $_POST['correo'];
$contraNueva = hashPassword($_POST['contraNueva']);
$sql = "update usuarios set usuario ='".$usuario."',tipo ='".$tipoUser."',email='".$email."',clave='".$contraNueva."'where token ='$token'";

if($conectarBD->query($sql)===TRUE){
	echo"<script type='text/javascript'>
	alert('Usuario Actualizado Con Exito');
	window.location.href='./listaUsuarios.php';
</script>";
}else{
	echo"<script type='text/javascript'>
	alert('Revisa Los Datos Algo Salio Mal');
	window.location.href='./editarUsuario.php?token=".$token."';
</script>";
}
$conectarBD->Close();