<?php 
session_start();
require_once '../conecion.php';

$idUser=$_SESSION['id'];
$tipoUsuario = $_SESSION['tipo'];
if(empty($_SESSION['tipo'])) {
    echo "<script>window.location.href='../index.php'; </script>";  
}
?>
<!DOCTYPE html>
<html>
<head>
    <?php require '../navAdmi.php'; ?>
	<title>Lista de Aprendices</title>

	 <meta charset="utf-8">	<link rel="icon" type="image/png" sizes="16x16" href="../situ.png">
   <link rel="stylesheet" type="text/css" href="../estilos.css">
  <link rel="stylesheet" type="text/css" href="../Assets/fonts/style.css">
  <link rel="stylesheet" type="text/css" href="../Assets/bootstrap-4.3.1-dist/css/bootstrap.min.css">

    <link rel="stylesheet" type="text/css" href="../css/sweetalert.css">
<script type="text/javascript" src="../js/sweetalert.js"></script>

</head>
<body class=" bg-white">
  
<?php
 if (isset($_POST['id_ficha'])) {
   echo "funciona";
 }


 ?>
<?php
    require"../navegacion.php";
        $sqlFicha = "SELECT * FROM ficha ORDER BY id_ficha ASC";
    
    $registrosIN="SELECT COUNT(*) AS totalRegistros FROM aprendiz WHERE estado = 0";
          if( $conectarBD->query($registrosIN)->num_rows > 0){

           foreach ($conectarBD->query($registrosIN) as $fila){

          $registrosI=$fila['totalRegistros'];
          $canPagina= 5;

          if (empty($_GET['pagina'])) {
            $pagina= 1;
          }else{
            $pagina=$_GET['pagina'];
          }
          $desde=($pagina-1)*$canPagina;

          $totalPaginas=ceil($registrosI/$canPagina);

        }}
        
      $registros="SELECT COUNT(*) AS totalRegistros FROM aprendiz WHERE estado = 1";
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
       
     if ($idUser ==1) {
          $sql = "SELECT * FROM aprendiz ORDER BY nombres ASC  LIMIT $desde,$canPagina";
        }else{
          $sql = "SELECT * FROM aprendiz WHERE estado = 1  ORDER BY nombres ASC LIMIT  $desde,$canPagina";
        }

     if ($conectarBD->query($sql)->num_rows > 0){
    ?>




<br>
     <div  style="margin-top: 2px; margin-left: 65px;">
 <a href="registrarAprendiz.php" class="btn btn-success" title="Crear Aprendiz"><span class="icon-plus1"></span>Aprendiz</a>

 <a href="importaAprendices.php" class="btn btn-success" title="Importar Aprendiz"><span class="icon-plus1"></span>Importar</a></div>
  <h1 align="center" class="font-weight-bold" style="margin-top: -3%; ">Lista de Aprendices </h1>
    <form class="form-inline float-right" action="buscarAprendices.php" method="get" style="margin-top: -50px; margin-right: 35px;" >
          <input class="form-control mr-sm-2 border border-dark" type="text" name="busqueda" id="busqueda" placeholder="Buscar">
         
        </form></h1>
   </div>               
     <div  style="margin-left:15px;">
       <form  action="buscarAprendices.php" method="get"  >
                
        <select  class="form-control  col-md-2 border border-dark" style="margin-left: 50px;"  name="id_ficha" id="id_ficha" onchange='this.form.submit()'>
                       
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
    
<div style="margin-left: 50px; margin-top: -6px;">
<a  onclick="exportarPdf()" title="Exportar a PDF" class="btn"  style="font-size: 40px; cursor: pointer; " >
  <span class="icon-file-pdf text-danger"></span></a>

<a  onclick="exportarExcel()"  title="Exportar a EXCEL" class="btn"  id="excel" style="font-size: 40px; margin-left: -20px; cursor: pointer; " >
  <span class="icon-file-excel text-success"></span></a>
</div>

    <?php

if($conectarBD->connect_error){
    die(require '../errorAlgoSM.php');
    }

      
        
     ?>
   
    <br>
<div align="right" style="margin-top: -20px; margin-right: 45px;">
  <h5>Total Activos:
<span class="text-success font-weight-bold">
  <?php 
echo $totalRegistros;
  ?>
  </span>
</h5>
</div>

<?php 
if($idUser==1){
?>
<div align="right" style="margin-top: -60px; margin-right: 45px;">
  <h5> Registros Inactivos:
<span class="text-danger font-weight-bold">
  <?php 
echo $registrosI;
  }
  ?>
  </span>
</h5>
</div>

<div class="container" style="margin-left: 50px;">
         <table class='table table-hover table-light' style="margin-top: 30px;">
            <tr class='bg-primary text-light' align='center'>
            <th>N° Documento</th>
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
             <td align="center"> <div class='btn-group' role='group'>
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
                </div>
            </td>
            </tr>     
               <?php                 
         } 
      
        
     $conectarBD->Close();

?>  
</table>
</div>
            <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
              <?php 
                
              //if(!empty($pagina)){
                if ($pagina!=1) {
                
              ?>
              <li class="page-item">
                <a  class="page-link font-weight-bold" href="?pagina=<?php echo 1;?>"  >INICIO</a>
              </li>
              <li class="page-item">
                <a class="page-link" href="?pagina=<?php echo $pagina -1;?>" ><span class="icon-circle-left text-primary"></span></a>
              </li>
              <?php 
            }
              for ($i=1; $i <= $totalPaginas ; $i++) { 
                if ($i == $pagina) {
                  echo '<li class="page-item page-link bg-success text-light">'.$i.'</li>' ;
                }else{
               echo '<li class="page-item"><a class="page-link" href="?pagina='.$i.'">'.$i.'</a></li>';
              }}

              if ($pagina !=$totalPaginas) {
              
               ?>
              <li class="page-item">
                <a class="page-link" href="?pagina=<?php echo $pagina +1;?>"><span class="icon-circle-right text-primary"></span></a>
              </li>
              <li class="page-item">
                <a class="page-link font-weight-bold" href="?pagina=<?php echo $totalPaginas;?>">FIN</a>
              </li>
              <?php
               }

         
              ?>
            </ul>
          </nav>
<?php 
}else{
 
  echo "<div class='container'><br>";
     die(include '../errorAlgoSM.php');
               }
  echo "</div>";
?>

<script type="text/javascript" src="../Assets/Jquery/jQuery_v3.4.1.js"></script>
<script type="text/javascript" src="../Assets/bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../Assets/Js/vue.js"></script>



<script type="text/javascript">
  function exportarExcel() {
    swal({
  title: "Advertencia",
  text: "¿Desea Exportar Todas los Aprendices a Excel?",
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
    window.location="./pdfAprendiz.php?E=1";

  } 
});

}

  function exportarPdf() {
    swal({
  title: "Advertencia",
  text: "¿Desea Exportar Todas los Aprendices a PDF?",
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
    window.location="./descargarPDFAP.php";
  } 
});

}
</script>
</body>
</html>

