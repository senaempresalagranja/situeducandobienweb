
<?php 
session_start();
require '../conecion.php';
require '../Assets/funcion.php';



$idUser = $_SESSION['id'];
$tipoUsuario = $_SESSION['tipo'];
    if (empty($_SESSION['tipo'])) {
            echo "<script>window.location.href='../index.php'; </script>";      }

    if (empty($_REQUEST['busqueda'])) {
      if(empty($_REQUEST['id_ficha'])){
         echo "<script>window.location.href='./listarAprendices.php'</script>";
     
    } 
  }
?>
<html>
<head>
  <meta charset="utf-8"><style type="text/css">
        .confi{
    height: 30px;

  }
      </style>
    <?php require '../navAdmi.php'; ?>
  <title>Busqueda de Aprendices</title>
  <link rel="icon" type="image/png" sizes="16x16" href="../situ.png">
  
   <link rel="stylesheet" type="text/css" href="./estilos.css">
  <link rel="stylesheet" type="text/css" href="../Assets/fonts/style.css">
    <link rel="stylesheet" type="text/css" href="../Assets/bootstrap-4.3.1-dist/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="../css/sweetalert.css">
<script type="text/javascript" src="../js/sweetalert.js"></script>

</head>
<body class=" bg-white">
<?php require '../navegacion.php';?>



<?php  
 
  if (isset($_REQUEST['busqueda'])) {
$busqueda=$_GET['busqueda'];
 $registros="SELECT COUNT(*) AS totalRegistros FROM aprendiz WHERE ( 
          id_aprendiz      LIKE '%$busqueda%' OR
          tipoDocumento LIKE '%$busqueda%' OR
          nombres  LIKE '%$busqueda%' OR
          apellidos LIKE '%$busqueda%' OR
          telefono    LIKE '%$busqueda%' OR
          id_ficha    LIKE '%$busqueda%' OR
          sexo    LIKE '%$busqueda%' OR
          correo   LIKE '%$busqueda%' )";

          if( $conectarBD->query($registros)->num_rows > 0){

           foreach ($conectarBD->query($registros) as $fila){

          $totalRegistros=$fila['totalRegistros'];
          $canPagina= 5;

          if (empty($_GET['pagina'])) {
            $pagina= 1;
          }else{
            $pagina=$_GET['pagina'];
          }
          $desde=($pagina-1)*$canPagina;

          $totalPaginas=ceil($totalRegistros/$canPagina);

        }}

$sql = "SELECT * FROM aprendiz WHERE ( 
          id_aprendiz      LIKE '%$busqueda%' OR
          nombres  LIKE '%$busqueda%' OR
          apellidos LIKE '%$busqueda%' OR
          telefono    LIKE '%$busqueda%' OR
          id_ficha    LIKE '%$busqueda%' OR
          sexo    LIKE '%$busqueda%' OR
          correo   LIKE '%$busqueda%' ) ORDER BY nombres ASC LIMIT $desde, $canPagina"; 
}


if(isset($_GET['id_ficha'])){
  $id_ficha=$_GET['id_ficha'];  
          $registros="SELECT COUNT(*) AS totalRegistros FROM aprendiz WHERE id_ficha= '$id_ficha'";
              
          if( $conectarBD->query($registros)->num_rows > 0){

           foreach ($conectarBD->query($registros) as $fila){
             
          $totalRegistros=$fila['totalRegistros'];
          
          $canPagina= 5;

          if (empty($_GET['pagina'])) {
            $pagina= 1;
          }else{
            $pagina=$_GET['pagina'];
          }
          $desde=($pagina-1)*$canPagina;

          $totalPaginas=ceil($totalRegistros/$canPagina);

        }
      }

$sql="SELECT * FROM aprendiz WHERE id_ficha='$id_ficha' ORDER BY nombres LIMIT $desde, $canPagina";
}


if($totalRegistros !=0){

	if($pagina <= $totalPaginas){
	
?>

<?php  
   $sqlFicha = "SELECT * FROM ficha ORDER BY id_ficha ASC";

?>
    <br>
<br>
            <div style="margin-left: 67px; margin-top: -30px;" >        
            	<a class="btn btn-warning font-weight-bold text-light" href="listarAprendices.php">Todos los Arpendices</a>
            </div>
               
            <div align="center" style="margin-top: -50px;">
                <h1 class="font-weight-bold" >Busqueda De Aprendices</h1>
            </div>
<br><br>
       <div>
          <form class="form-inline float-right" action="buscarAprendices.php" method="get" style="margin-top: -30px; margin-right: 70px;" >
          	<input class="form-control mr-sm-2 border border-dark" type="text" name="busqueda" id="busqueda" placeholder="Buscar" value="<?php if(isset($_GET['busqueda']))  echo $_GET['busqueda'] ;?>" onchange='this.form.submit()'>
          		<noscript><input type="submit" value="Submit"></noscript>
          </form>
        </div>
  
    
     <div  style="margin-left: 67px; margin-top: -40px;">
       <form  action="buscarAprendices.php" method="get"  >
                
          <select  class="form-control  col-md-2 border border-dark"  name="id_ficha" id="id_ficha" onchange='this.form.submit()'>            
              <option class="font-weight-bold"  value="0">Buscar Ficha</option>
              <?php
                foreach($conectarBD->query($sqlFicha) as $ficha){
               ?>
               <option  class="font-weight-bold "  value="<?php echo $ficha['id_ficha'];?>" ><?php
                echo $ficha['id_ficha'];?></option>
              <?php
              }                            
              ?> 
          </select>
        <noscript><input type="submit" value="Submit"></noscript>
                          
      	</form>
    </div>
  <br>
  <div style="margin-left: 50px; margin-top: -40px;">

<a onclick="exportarPdf()" title="Exportar a PDF" class="btn"  style="font-size: 40px; cursor: pointer;" >
  <span class="icon-file-pdf text-danger"></span></a>

<a  onclick="exportarExcel()" title="Exportar a EXCEL" class="btn"  id="excel" style="font-size: 40px; margin-left: -20px; cursor: pointer; " >
  <span class="icon-file-excel text-success"></span></a>

</div>                
<br>
<div align="right"  style="margin-top: -50px; margin-right: 75px;">
  <h5>Total Busqueda:
<span class="text-primary font-weight-bold">
  <?php 
if(isset($totalRegistros)>0){ echo $totalRegistros;}else{echo "0";}
  ?>
  </span>
</h5>
</div>

<div class="container">

      <table class='table table-hover table responsive' style="margin-top: 20px; margin-left: -50px;">
            <tr class='bg-primary text-light' align='center' class='bg-primary'>
            <th>Documento</th>
            <th>Tipo Documento</th>
            <th>Nombres</th>
            <th>Apellidos</th>
            <th>Telefono</th>
            <th>Ficha</th>
            <th>Sexo</th>
            <th>Correo</th>
        <?php if ($idUser == 1) {
    ?>
    <th>Estado</th>
  <?php } ?>
            <th colspan="2">Acciones</th>
         </tr>
  <?php
  	if($conectarBD->query($sql)){

   foreach ($conectarBD->query($sql) as $value){
 
    ?>
     
  <tr align='center' class='font-weight-bold' scope='row'>
             <td><?php echo $value['id_aprendiz'];?></td>
             <td><?php echo $value['tipoDocumento'];?></td>
             <td><?php echo $value['nombres'];?></td>
             <td><?php echo $value['apellidos'];?></td>
             <td><?php echo $value['telefono'];?></td>
             <td><?php echo $value['id_ficha'];?></td>
             <td><?php echo $value['sexo'];?></td>
             <td><?php echo $value['correo'];?></td>
             <?php if ($tipoUsuario == 'administrador' ) {
                        if ($idUser ==1) {
              ?>
             <td><?php 
                  switch ($value['estado']) {
                    case '1':
                      $value['estado'] = 'Activo';
                      break;
                      case '0':
                      $value['estado'] = 'Inactivo';
                      break;     
                  }
                  if ($value['estado']=='Activo') {
                    echo "<span class='text-success' href=''>".$value['estado']."</span>";
                  }else{
                    echo "<span class='text-danger'>".$value['estado']."</span>";
                  }
                  
             ?></td>
             <?php }
                  }
              ?>
             <td align="center"><div class='btn-group' role='group'>
            <a href="./editarAprendiz.php?id=<?php echo $value['id_aprendiz'];?>&token=<?php echo $value['token'];?>"  class='btn btn-secondary' style='size: 10px;' title='Editar' ><i class='icon-edit text-light' style="font-size: 20px;"></i></a>
            
             <?php 
              if ($idUser ==1) {
              if ($value['estado']=='Activo') {
              ?>  
            <a href="./eliminarAprendiz.php?id=<?php echo $value['id_aprendiz'];?>&token=<?php echo $value['token'];?>" class='btn' style='size: 10px;'  title='Desactivar Aprendiz'><i class='icon-checkmark1 text-success'  style="font-size: 30px;"></i></a>
            <?php }else{?> 
            <a href="./eliminarAprendiz.php?id=<?php echo $value['id_aprendiz'];?>&token=<?php echo $value['token'];?>" class='btn' style='size: 10px;' title='Activar Aprendiz'><i class='icon-cancel text-danger'  style="font-size: 30px;"></i></a>
            <?php }}
                if ($idUser!=1) {
                
              if ($tipoUsuario == 'administrador' ) {
             ?>
             <a  href="./eliminarAprendiz.php?id=<?php echo $value['id_aprendiz'];?>&token=<?php echo $value['token'];?>" class='btn btn-danger' style='size: 10px;' title='Activar Aprendiz'><i class='icon-bin text-light' ></i></a>   <?php 
              }}
               ?> 
                </td>
            </td>
            </tr>     


<?php    
 	}
}
          ?>
            </table>
   </div>
<?php 
 if(isset($totalRegistros)){
      if ($totalRegistros!=0){
?>
		<nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
              <?php 
           if ($pagina!=1) {        
              ?>
              <li class="page-item">
                <a class="page-link font-weight-bold" href="?pagina=<?php echo 1;?>&<?php if(isset($_REQUEST['busqueda'])){?>busqueda=<?php echo $_REQUEST['busqueda'];} if(isset($_REQUEST['id_ficha'])){?>id_ficha=<?php echo $_REQUEST['id_ficha'];} ?>" >INICIO</a>
              </li>
              <li class="page-item">
                <a class="page-link" href="?pagina=<?php echo $pagina -1;?><?php if(isset($_REQUEST['busqueda'])){?>busqueda=<?php echo $_REQUEST['busqueda'];} if(isset($_REQUEST['id_ficha'])){?>id_ficha=<?php echo $_REQUEST['id_ficha'];} ?>" ><span class="icon-circle-left text-primary"></span></a>
              </li>
              <?php 
            }
              for ($i=1; $i <= $totalPaginas ; $i++) { 
                if ($i == $pagina) {
                  echo '<li class="page-item page-link bg-success text-light">'.$i.'</li>' ;
                }else{
     		?>             
              <li class="page-item"><a class="page-link" href="?pagina=<?php echo $i;?>&<?php  if(isset($_REQUEST['busqueda'])){?>busqueda=<?php echo $_REQUEST['busqueda'];} if(isset($_REQUEST['id_ficha'])){?>id_ficha=<?php echo $_REQUEST['id_ficha'];} ?>"><?php echo $i;?></a></li>
       <?php 
      	}}
      	
       if ($pagina !=$totalPaginas) {      
               ?>
              <li class="page-item">
                <a class="page-link" href="?pagina=<?php echo $pagina +1;?>&<?php if(isset($_REQUEST['busqueda'])){?>busqueda=<?php echo $_REQUEST['busqueda'];} if(isset($_REQUEST['id_ficha'])){?>id_ficha=<?php echo $_REQUEST['id_ficha'];} ?>"><span class="icon-circle-right text-primary"></span></a>
              </li>
              <li class="page-item">
                <a class="page-link font-weight-bold" href="?pagina=<?php echo $totalPaginas;?>&<?php if(isset($_REQUEST['busqueda'])){?>busqueda=<?php echo $_REQUEST['busqueda'];} if(isset($_REQUEST['id_ficha'])){?>id_ficha=<?php echo $_REQUEST['id_ficha'];} ?>">FIN</a>
              </li>
              <?php
               } 
              ?>
            </ul>
          </nav>

<?php 
}
}
?>



<?php 
	}else{

	   echo "<div class='container'><br>";
   	   die(include '../errorAlgoSM.php');
   	   echo "</div>";
	}

}else{
?>
        
<?php
    echo "<div class='container'><br>";
    die(include '../errorAlgoSM.php');
    echo "</div>";
}
?>

<script type="text/javascript" src="../Assets/Jquery/jQuery_v3.4.1.js"></script> 
<script type="text/javascript" src="../Assets/bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>
<script type="text/javascript">
  function exportarExcel() {
    
    swal({
  title: "Advertencia",
  text: "¿Está Seguro de exportar <?php echo $totalRegistros; ?> Registros de la busqueda de Aprendiz a Excel?",
  type: "warning",
  showCancelButton: true,
  confirmButtonColor: "#28A745",
  confirmButtonText: "Si",
  cancelButtonColor: "#DC3545",
  cancelButtonText: "No",
  closeOnConfirm: true,
  closeOnCancel: true
},
function(isConfirm){
  if (isConfirm) {
    window.location.href="./pdfAprendiz.php?E=1&<?php if(isset($_REQUEST['busqueda'])){?>busqueda=<?php echo $_REQUEST['busqueda'];} if(isset($_REQUEST['id_ficha'])){?>id_ficha=<?php echo $_REQUEST['id_ficha'];}?>";
  } 
});

}

  function exportarPdf() {
    swal({
  title: "Advertencia",
  text: "¿Está Seguro de exportar <?php echo $totalRegistros; ?> Registros de la busqueda de Aprendiz a PDF?",
  type: "warning",
  showCancelButton: true,
  confirmButtonColor: "#28A745",
  confirmButtonText: "Si",
  cancelButtonColor: "#DC3545",
  cancelButtonText: "No",
  closeOnConfirm: true,
  closeOnCancel: true
},
function(isConfirm){
  if (isConfirm) {
    window.location.href="./descargarPDFAP.php?<?php if(isset($_REQUEST['busqueda'])){?>busqueda=<?php echo $_REQUEST['busqueda'];} if(isset($_REQUEST['id_ficha'])){?>id_ficha=<?php echo $_REQUEST['id_ficha'];}?>";
  } 
});

}
</script>

</body>
</html>     