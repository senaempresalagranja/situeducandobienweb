<?php
 date_default_timezone_set('America/Bogota'); ?>
<!DOCTYPE html>
<html>
<head>

  <link rel="icon" type="image/png" sizes="16x16" href="../situ.png">
<link rel="stylesheet" type="text/css" href="../css/spinners.css">

<link rel="stylesheet" type="text/css" href="../css/animate.css">
<link rel="stylesheet" type="text/css" href="../css/sweetalert.css">
<script type="text/javascript" src="../js/sweetalert.js"></script>
</head>


<style type="text/css">

	nav{
		height: 30px;
	}

  .opciones{
   right: 330px;
  }

.notify {

  position: relative;

  top: -28px;

  right: -7px; }

  .notify .heartbit {

    position: absolute;

    top: -20px;

    right: -4px;

    height: 25px;

    width: 25px;

    z-index: 10;

    border: 5px solid #ef5350;

    border-radius: 70px;

    -moz-animation: heartbit 1s ease-out;

    -moz-animation-iteration-count: infinite;

    -o-animation: heartbit 1s ease-out;

    -o-animation-iteration-count: infinite;

    -webkit-animation: heartbit 1s ease-out;

    -webkit-animation-iteration-count: infinite;

    animation-iteration-count: infinite; }

  .notify .point {

    width: 6px;

    height: 6px;

    -webkit-border-radius: 30px;

    -moz-border-radius: 30px;

    border-radius: 30px;

    background-color: #ef5350;

    position: absolute;

    right: 6px;

    top: -10px; }



@-moz-keyframes heartbit {

  0% {

    -moz-transform: scale(0);

    opacity: 0.0; }

  25% {

    -moz-transform: scale(0.1);

    opacity: 0.1; }

  50% {

    -moz-transform: scale(0.5);

    opacity: 0.3; }

  75% {

    -moz-transform: scale(0.8);

    opacity: 0.5; }

  100% {

    -moz-transform: scale(1);

    opacity: 0.0; } }



@-webkit-keyframes heartbit {

  0% {

    -webkit-transform: scale(0);

    opacity: 0.0; }

  25% {

    -webkit-transform: scale(0.1);

    opacity: 0.1; }

  50% {

    -webkit-transform: scale(0.5);

    opacity: 0.3; }

  75% {

    -webkit-transform: scale(0.8);

    opacity: 0.5; }

  100% {

    -webkit-transform: scale(1);

    opacity: 0.0; } }



</style>



<body>

     



      <nav class="confi navbar navbar-expand-lg  bg-info dropdown-menu-right" style="/*background-color: #1976d2;*/">



  <h3 class=" situ font-weight-bold text-light"  >SITU</h3>



  <div class="collapse navbar-collapse" id="navbarSupportedContent">

    <ul class="navbar-nav mr-auto">



    </ul>



   <form class="form-inline my-2 my-lg-0" label="Floated Right">

      <h3 class="fecha font-weight-bold text-light" >SENA <?php  echo date("d-m-Y");?> | </h3>





<?php

   $sql="SELECT COUNT(*) total FROM sugerencias";

   $total=$conectarBD->query($sql)->fetch_assoc()['total'];

  

       ?>



  <ul class="navbar-nav mr-auto">



      <li class="nav-item dropdown">

        <a class="nav-link" data-toggle="dropdown" href="#">

          <i class="icon-alarm1 text-light" title="Notificación de Sugerencias" style="font-size: 30px;"></i>

          <span class="badge badge-danger navbar-badge" style="margin-top: -10px;"><?php echo $total; ?></span>

        </a> 

        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right animated bounceInDown">

          <span class="dropdown-item dropdown-header">Notificación de Sugerencias</span>

          <div class="dropdown-divider"></div>

          <a href="../consulta/ListarSugerencias.php" title="Lista de Sugerencias" class="dropdown-item">

           <span class="btn btn-circle btn-danger"><i class="icon-envelope mr-2 text-light" style="font-size: 20px;"></i></span>  Ver sugerencias

          </a>

      </div>

    

  



<li class="nav-item dropdown">

        <a class="nav-link" data-toggle="dropdown" href="#">

          <i class="icon-cog1 text-light" title="Configuración de Cuenta" style="font-size: 30px;"></i>

        </a><div class="notify" style="margin-top: 4px;"> <span class="heartbit"></span> <span class="point"></span> </div>

                           



        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right animated flipInY">

          <span class="dropdown-item dropdown-header">Configuraciones</span>

          <div class="dropdown-divider"></div>

          

          <a href="../user/cambioConUser.php" title="Actualizar Contraseña" class="dropdown-item">

            <i class="icon-loop2 text-primary mr-2"></i> Contraseña

          </a>

          <div class="dropdown-divider"></div>

          

           <?php  if ($tipoUsuario == "administrador") { ?>

          <a href="../user/listaUsuarios.php" title="Lista Usuarios" class="dropdown-item">

          <i class="icon-users text-success mr-2"></i> Usuarios

          </a>

          <div class="dropdown-divider"></div>

          

           <?php if ($idUser ==1) {?>

           <a href="../user/registrarMemorando.php" title="Crear Memorandos" class="dropdown-item">

            <i class="icon-file text-dark mr-2"></i> Memorandos

          </a>

          <div class="dropdown-divider"></div>

          <?php } }?>

          

          <a href="../user/actualizarInfo.php" title="Actualizar Información" class="dropdown-item">

            <i class="icon-cog text-dark mr-2"></i> Información

          </a>

          <div class="dropdown-divider"></div>



            <a href="../cerrarSesion.php" title="Cerrar Sesion" class="dropdown-item">

            <i class="icon-switch2 text-danger mr-2"></i> Salir

          </a>

          

        </div>

      </li>

</li>

  </form>    



  

  

</div>

</nav>





</body>

</html>

