<!DOCTYPE html>
<html>
<head>
<title>Información</title>
    <link rel="icon" type="image/png" sizes="16x16" href="../situ.png">
    
<link rel="stylesheet" type="text/css" href="estilos.css" >
<link rel="stylesheet" type="text/css" href="../Assets/iconos/style.css">
<link rel="stylesheet" type="text/css" href="../Assets/bootstrap-4.3.1-dist/css/bootstrap.min.css">

<link rel="stylesheet" type="text/css" href="./css/sweetalert.css">
<script type="text/javascript" src="./js/sweetalert.js"></script>

    <link rel="shortcut icon" href="./situ.png" >
</head>

<body class="bg-white" >
<style>
		#imagen{
		width: 250px;
		height: 320px;
		}
		#imagen:hover{  
		display: block;
		width: 400px;
		height: 500px;
		padding: 0%;
		margin-left: 90px;
		margin-right: 0%;  
		cursor: zoom-in;
		margin: auto;
		}

		table td p {
		width: 250px;
		height: auto;
		text-align: justify;
		text-indent: 0em;
		background: none;
		font-family: Arial, Helvetica, sans-serif;
	
		font-weight: bold;
		}
	
		table th {
			text-align: center;
		}
		ul, ol{
			list-style: none;
		}
		.nav li a:hover{
			background-color: gray;
			color: white;
		}
			.nav li a{
			background-color: silver;
			color: black;
			font-weight: bold;
			text-decoration: none;
			padding: 10px 10px;
			display: block; 
			margin-right: -10%;
			border-radius: 5px; 
		}
			.v-enter-active, .v-leave-active{
			transition: opacity .8s
		}

		.v-enter, .v-leave-to{
			opacity: 0
		}
			.nav{	
			
			margin-right:100px; 
			margin-left: 100px;
		}

		
</style>
<body>
<div>
		<?php
		include './navConsulta.php'
		?>
	

<main id="app">

<br><br>
<ul class="nav nav-pills nav-fill">
  <li class="nav-item">
    <a class="nav-link"v-on:click="ocultarM" style="cursor: pointer; font-size:20px; "><i class="icon-file-pdf text-danger"  ></i> Manual Usuarios</a>
  <li class="nav-item">
    <a class="nav-link" v-on:click="ocultarU" style="cursor: pointer;font-size:20px;"><i class="icon-location text-danger" ></i> Ubicación</a>
  </li>
  <li class="nav-item">
   <a  class="nav-link"v-on:click="ocultarC" style="cursor: pointer;font-size:20px;" ><i class="icon-phone2 text-danger"  ></i> Contactos</a>
  </li>
  <li class="nav-item">
 	<a class="nav-link"v-on:click="ocultarI" style="cursor: pointer;font-size:20px;"><i class="icon-film text-danger" ></i> Instructivos</a>
  </li>
</ul>

<br><br><br>
<transition>
<div  id="ubicacion"  v-show="datos1 =='verdadero'"	>
	<h1 style="margin-left: 39%;" class="font-weight-bold" style="font-family: 'Times New Roman', Times, serif ">Mi Ubicación</h1>
<iframe  src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d11254.971478119907!2d-74.92997705250885!3d4.1744803813770295!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x17c49f902cb02ef7!2sCentro%20Agropecuario%20La%20granja%20Sena!5e0!3m2!1ses!2sco!4v1581600248121!5m2!1ses!2sco" style="margin-left: 27%; height: 290px; width:550px;"></iframe>

<br><br><br><br>
<div class="container" >
<h6 style="margin-left: 36%;"><b>Conectate con Sena Empresa</b></h6>
<div style="margin-left: 25%;">

<button class="btn btn-danger" type="button" onclick="window.location.href = 'https://senaempresalagranja.blogspot.com/';" >
<i class="icon-blogger"></i> Blogger
</button>

<button class="btn btn-primary" type="button" onclick="window.location.href = 'https://www.facebook.com/senaempresa';">
<i class="icon-facebook"></i> Facebook
</button>

<button class="btn btn-ligth border-dark" type="button" onclick="window.location.href = 'https://www.instagram.com/senaempresalagranja/';">
<i class="icon-instagram" style="color:#DA4040;"></i> Instagram
</button>

<button class="btn btn-primary" type="button" onclick="window.location.href = 'https://twitter.com/Sena_Empresa';">
<i class="icon-twitter"></i> Twitter
</button>
</div>
</div>
</div>
</transition>

<transition>
<div align="center" id="mUsuario" v-show="datos2 =='verdadero'">
<br><br>
	<h1 class="font-weight-bold" style="font-family: 'Times New Roman', Times, serif">Manual Usuario</h1>
	<br>
	<embed src="../ejemplo.pdf" type="application/pdf" style="width: 80%; height:900px;">
</div>
</transition>

<transition>
	<div  v-show="datos3 =='verdadero'"> 
	<div class="container " style="width: 40%; height: 50%;">
<div id="carouselExampleIndicators" class="carousel slide " data-ride="carousel">
  <ol class="carousel-indicators" >
    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
  </ol>
  <div class="carousel-inner ">
    <h5>Grupo Los Pingüinos ADSI Ficha N° 1802578</h5>
    <div class="carousel-item active ">
      <img class="d-block w-100" src="../img/bastoOrtiz.jpg" alt="First slide">
      <h5 class="font-weight-bold">Euclides Norbey Basto O.</h5>
      <p>Analista y Desarrollador</p>
          <div class="bg-transparent " >
          <a href="mailto:enbasto@misena.edu.co">
            <i class="icon-mail" style="color: #DA4040; font-size: 26px;"></i></a>
            <a href="https://www.facebook.com/Enbo.Ortiz">
            <i class="icon-facebook2" style=" font-size: 26px;"></i>   </a>
            <a href="https://www.instagram.com/soyenbo/">
            <i class="icon-instagram" style="color: #DA4040;  border-radius:8px; font-size: 26px;"></i></a>
            <a href="https://twitter.com/Soyenbo/">
            <i class="icon-twitter" style="  border-radius:8px; font-size: 26px;"></i></a>
        </div>
    </div>
    <div class="carousel-item">
      <img class="d-block w-100" src="../img/alverniaMurillo.jpg" alt="Second slide">
      <h5 class="font-weight-bold">Johan Camilo Alvernia M.</h5>
      <p>Analista y Desarrollador</p>
      <div >
      <a href="mailto:amjohan4@misena.edu.co">
      <i class="icon-mail" style="color: #DA4040; font-size: 26px;"></i></a>
      <a href="https://www.facebook.com/kmilo.alvernia">
      <i class="icon-facebook2" style=" font-size: 26px;"></i></a>
      </div>
    </div>
    <div class="carousel-item">
      <img class="d-block w-100" src="../img/hernandezRayo.jpg" alt="Third slide">
      <h5 class="font-weight-bold">Jorge Luis Hernández R.</h5>
      <p>Analista y Desarrollador</p>
      <div >
      <a href="mailto:jlhernandez0739@misena.edu.co">
      <i class="icon-mail" style="color: #DA4040; font-size: 26px;"></i></a>
      <a href="https://www.facebook.com/jl17hernandez">
      <i class="icon-facebook2" style=" font-size: 26px;"></i>   </a>
      <a href="https://www.instagram.com/j17hernandez/">
      <i class="icon-instagram" style="color: #DA4040; border-radius:8px; font-size: 26px;"></i>   </a>
      <a href="https://twitter.com/j17_hernandez/">
      <i class="icon-twitter" style="border-radius:8px; font-size: 26px;"></i>   </a>
      </div>
    </div>
    <div class="carousel-item">
      <img class="d-block w-100" src="../img/mesaRincon.jpg" alt="Third slide">
      <h5 class="font-weight-bold">Mary Ley Rincón M.</h5>
      <p>Analista y Desarrollador</p>
      <div >
      <a href="mailto:mlrincon79@misena.edu.co">
      <i class="icon-mail" style="color: #DA4040; font-size: 26px;"></i></a>
      <a href="https://www.facebook.com/mariley.rincon.1">
      <i class="icon-facebook2" style=" font-size: 26px;"></i></a>
      </div>   
           
    </div>
  </div>
  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
    <span class="icon-circle-left text-secondary display-3" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
    <span class="icon-circle-right text-secondary display-3" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>
</div>
	

</div>
</transition>

<br><br>


<transition>
<div class="container" v-show="datos4 =='verdadero'">
<h4>Aquí vendrán los videos</h4>
</div>
</transition>



</main>
<br>
<script type="text/javascript" src="../Assets/Jquery/jQuery_v3.4.1.js"></script>
<script type="text/javascript" src="../Assets/bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>
<script src="../Assets/Js/vue.js"></script>
<script type="text/javascript">
		var prevScrollpos = window.pageYOffset;
		window.onscroll = function(){
			var currentScrollPos = window.pageYOffset;
			if (prevScrollpos > currentScrollPos) {
				document.getElementById('navbar-desktop').style.top = "0";
			}else{
				document.getElementById('navbar-desktop').style.top = "-60px";
			}
			prevScrollpos = currentScrollPos;
		}
	</script>
<script>
const app = new Vue({
	el: "#app",
	data:{
	datos1: '',
	datos2: '',
	datos3: '',
	datos4: '',
	},
	methods:{


		ocultarU: function(){
			if(this.datos1 == 'falso'){
				this.datos1 = 'verdadero';
				this.datos2 = 'falso';
				this.datos3 = 'falso';
				this.datos4 = 'falso';
			}else{
				this.datos1='falso';
				this.datos2 = 'falso';
				this.datos3 = 'falso';
				this.datos4 = 'falso';
			}
		},
		
		ocultarM: function() {
		if(this.datos2 =='falso'){
			this.datos2 = 'verdadero';
			this.datos1 = 'falso';
			this.datos3 = 'falso';
			this.datos4 = 'falso';
		}else{
			this.datos2='falso';
			this.datos1 = 'falso';
			this.datos3 = 'falso';
			this.datos4 = 'falso';
		}
		},

		ocultarC: function(){
			if(this.datos3 == 'falso'){
				this.datos3 = 'verdadero';
				this.datos1 = 'falso';
				this.datos2 = 'falso';
				this.datos4 = 'falso';
			}else{
				this.datos3='falso';
				this.datos1 = 'falso';
				this.datos2 = 'falso';
				this.datos4 = 'falso';
			}
		},


		ocultarI: function(){
			if(this.datos4 == 'falso'){
				this.datos4 = 'verdadero';
				this.datos1 = 'falso';
				this.datos2 = 'falso';
				this.datos3 = 'falso';
			}else{
				this.datos4 = 'falso';
				this.datos1 = 'falso';
				this.datos2 = 'falso';
				this.datos3 = 'falso';
			}
		}


	}
})

</script>
</div>
</body>
</html>