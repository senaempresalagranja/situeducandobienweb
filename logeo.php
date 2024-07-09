<?php
session_start();

require './conecion.php';
require './Assets/funcion.php';
date_default_timezone_set('America/Bogota');


if ($conectarBD->connect_error) {
    die(require './errorAlgoSM.php');
}


$errors = array();

if (!empty($_POST)) {
    $usuario = $conectarBD->real_escape_string($_POST['usuario']);
    $clave = $conectarBD->real_escape_string(sha1(sha1($_POST['clave'])));


    $busq = "SELECT * FROM usuarios WHERE usuario = '$usuario'";


    if ($conectarBD->query($busq)->num_rows > 0) {
        $usuarioB = $conectarBD->query($busq)->fetch_assoc()['usuario'];
        $claveB = $conectarBD->query($busq)->fetch_assoc()['clave'];
        $id = $conectarBD->query($busq)->fetch_assoc()['id'];
        $intentosF = $conectarBD->query($busq)->fetch_assoc()['intentoFallidos'];
        $tipo = $conectarBD->query($busq)->fetch_assoc()['tipo'];

        if ($usuario == $usuarioB) {
            if ($intentosF <= 3) {


                if ($clave == $claveB) {

                    $_SESSION['id'] = $id;
                    $_SESSION['tipo'] = $tipo;

                    echo "<script> window.location.href='administrador/paginaPrincipal.php'</script>";
                } else {
                    $intentosFallidos = $intentosF + 1;
                    $sqlFallidos = "UPDATE usuarios SET intentoFallidos = '$intentosFallidos' WHERE usuario = '$usuarioB'";

                    if ($conectarBD->query($sqlFallidos)) {
                        echo "<script>swal('Error','$intentosFallidos Intento Fallido Contraseña incorrecta', 'error' )</script>";
                    }
                }
            } else {
                echo "<script>swal('Advertencia','Usuario Ha Sido Bloqueado Por Tener Más De: $intentosF, Intentos Fallidos de Inicio de Sesion', 'warning' )</script>";
            }
        } else {
            echo 'La Contraseña no es la correcta' . "<i class='icon-notice1'></i>";
        }
    } else {

        echo "<script>swal('Error','No se encontro ningun usuario: $usuario', 'error' )</script>";
    }
}

$conectarBD->close();
