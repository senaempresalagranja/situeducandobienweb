<!DOCTYPE html>
<html>
<head>
<title>Index</title>
 <link rel="icon" type="image/png" sizes="16x16" href="../situ.png">
<link rel="stylesheet" type="text/css" href="./Assets/iconos/style.css">
<link rel="stylesheet" type="text/css" href="./Assets/bootstrap-4.3.1-dist/css/bootstrap.min.css">

<link rel="stylesheet" type="text/css" href="./css/sweetalert.css">
<script type="text/javascript" src="./js/sweetalert.js"></script>

    <link rel="shortcut icon" href="./situ.png" >
</head>

<body class="bg-white" >

<?php require './Assets/funcion.php'; ?>

 <nav class="navbar " style="background:#0b56a0 ">
          
    <ul class="navbar-nav mr-auto">
  <li class="nav-item">
            <a class="btn btn-light font-weight-bold text-dark "  href="./consulta/paginaConsulta.php"  > <i class="icon-user-tie"> </i>
              Usuario Invitado</a>
        </li>
    </ul>
    <form class="form-inline my-2 my-lg-0" label="Floated Right">
   <ul class="navbar-nav mr-auto">
  <li class="nav-item">
        <a class="btn btn-light font-weight-bold text-dark border-white" href="https://senaempresalagranja.blogspot.com/" ><i class="icon-spinner11"  ></i> Volver al Blog </a>         
        </li>
    </ul> 
</form>
</nav>

  

<main role="main" class="container my-auto">
            <div class="row">
            
                <div id="login" class="col-lg-4 offset-lg-4 col-md-6 offset-md-3
                    col-12">
                    <div  class="btn btn- outline" >
                    <h2 class="text-center">Bienvenido a SITU</h2>
                    <div class="login100-form-avatar">
						
                    <img class="img-fluid mx-auto d-block rounded-circle" src="./user.png">
                        
			            		</div>
                        
                        <form action="./z1.php" method="post">
                    <br>
                          
                        
                <div class="input-group">
                <div class="input-group-append">
                       <input type="text"  name="usuario" id="usuario"  class="form-control"  placeholder="@misena.edu.co" required>
                       <button class="btn btn-primary"> <i class="icon-user"></i> </button>
                </div>
                </div>


                   <br>
                <div class="input-group">
                <div class="input-group-append">
                        <input type="password"  name="clave"  class="form-control" id="clave" placeholder="Contrase単a" required>
                    <button type="button" class="btn btn-primary" onclick="mostrarPassword()" > <i class="icon-eye-blocked icon"></i> </button>
                </div>
                </div>
<br>
                <div class="form-group mx-sm-3 mb-2">
                        <button type="submit" class="btn btn-block bg-warning form-control font-weight-bold" id="logeo"><span class="icon-enter text-light"></span> Ingresar</button>
                        </div>
                       
                        
                        
                    </form>
                   <a class="font-weight-bold" href="./user/recuperaContrasena.php" ><i class="icon-key text-dark"></i> Olvide Mi Contrase単a</a>
                </div>
                        

              
            </div>
        </main>
</div>
<div id="respuesta">
  
</div>


<script type="text/javascript" src="./Assets/Jquery/jQuery_v3.4.1.js"></script>
<script type="text/javascript" src="./Assets/bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>
<!-- <script type="text/javascript" src="./Assets/sweetalert2/sweetalert2.all.min.js"></script> -->


</body>

</html>

