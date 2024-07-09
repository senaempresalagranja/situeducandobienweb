<?php
session_start();
require '../conecion.php';
require '../Assets/funcion.php';



$idUser = $_SESSION['id'];
$tipoUsuario = $_SESSION['tipo'];
if (empty($_SESSION['tipo'])) {
  echo "<script>window.location.href='../index.php'; </script>";
}
$errors = array();

?>
<!DOCTYPE html>
<html>


<head>

  <title>Registrar Unidad</title>
  <link rel="icon" type="image/png" sizes="16x16" href="../situ.png">
  <link rel="stylesheet" type="text/css" href="../estilos.css">
  <link rel="stylesheet" type="text/css" href="../Assets/fonts/style.css">
  <link rel="stylesheet" type="text/css" href="../Assets/bootstrap-4.3.1-dist/css/bootstrap.min.css">
  <link rel="icon" type="image/png" sizes="16x16" href="../situ.png">

</head>

<body class="bg-white">
  <div class="wrapper">

    <?php include '../navAdmi.php'; ?>
    <?php include '../navegacion.php'; ?>

    <br>

    <?php

    $errors = array();
    if (!empty($_POST)) {
      $nombreUnidad = $conectarBD->real_escape_string($_POST['nombreUnidad']);
      $codigoUnidad = $conectarBD->real_escape_string($_POST['codigoUnidad']);
      $area = $conectarBD->real_escape_string($_POST['id_area']);
      $tipoTurno = $conectarBD->real_escape_string($_POST['tipoTurno']);
      $cantidadAprendices = $conectarBD->real_escape_string($_POST['cantidadAprendices']);
      $horaInicioM = $conectarBD->real_escape_string($_POST['horaInicioM']);
      $horaFinM = $conectarBD->real_escape_string($_POST['horaFinM']);

      if (isset($_POST['horaInicioT'])) {
        $horaInicioT = $conectarBD->real_escape_string($_POST['horaInicioT']);

        if ($horaInicioT == "") {
        }
      }
      if (isset($_POST['horaFinT'])) {
        $horaFinT = $conectarBD->real_escape_string($_POST['horaFinT']);

        if ($horaFinT == "") {
        }
      }


      if ($nombreUnidad == "") {
        $errors[] = "<h4 align='center' class='alert alert-danger alert-dismissible fade show text-dark'>
  <i class='icon-notification text-warning' style='font-size: 80px;' ></i> <br>
  No Ingresaste Un Nombre De Unidad
   <button type='button' class='close' value='cerrar' data-dismiss='alert' aria-label='close'>
  <span aria-hidden='true'>&times; </span>
   </button>
  </h4>";
      }
      if ($codigoUnidad == "") {
        $errors[] = "<h4 align='center' class='alert alert-danger alert-dismissible fade show text-dark'>
  <i class='icon-notification text-warning' style='font-size: 80px;' ></i> <br>
  No Ingresaste Un Codigo En El Campo Codigo
    <button type='button' class='close' value='cerrar' data-dismiss='alert' aria-label='close'>
  <span aria-hidden='true'>&times; </span>
   </button>
  </h4>";
      }
      if (!is_numeric($codigoUnidad)) {
        $errors[] = "<h4 align='center' class='alert alert-danger alert-dismissible fade show  text-dark'>
  <i class='icon-notification text-warning' style='font-size: 80px;' ></i> <br>
  Ingresaste Un Codigo Incorrecto
  <button type='button' class='close' value='cerrar' data-dismiss='alert' aria-label='close'>
  <span aria-hidden='true'>&times; </span>
   </button>
  </h4>";
      }
      if ($area == "") {
        $errors[] = "<h4 align='center' class='alert alert-danger alert-dismissible fade show text-dark'>
  <i class='icon-notification text-warning' style='font-size: 80px;' ></i> <br>
  No Ingresaste El Campo Area
  <button type='button' class='close' value='cerrar' data-dismiss='alert' aria-label='close'>
  <span aria-hidden='true'>&times; </span>
   </button>
  </h4>";
      }
      if ($tipoTurno == "") {
        $errors[] = "<h4 align='center' class='alert alert-danger alert-dismissible fade show text-dark'>
  <i class='icon-notification text-warning' style='font-size: 80px;' ></i> <br>
  Seleccionaun tipo de turno
    <button type='button' class='close' value='cerrar' data-dismiss='alert' aria-label='close'>
  <span aria-hidden='true'>&times; </span>
   </button>
  </h4>";
      }
      if ($horaInicioM == "") {
        if (!validarHora($horaInicioM)) {
          $errors[] = "<h4 align='center' class='alert alert-danger alert-dismissible fade show text-dark'>
  <i class='icon-notification text-warning' style='font-size: 80px;' ></i> <br>
  Ingresa una hora de turno Valida
    <button type='button' class='close' value='cerrar' data-dismiss='alert' aria-label='close'>
  <span aria-hidden='true'>&times; </span>
   </button>
  </h4>";
        }
      }
      if ($horaFinM == "") {
        if (!validarHora($horaFinM)) {
          $errors[] = "<h4 align='center' class='alert alert-danger alert-dismissible fade show text-dark'>
  <i class='icon-notification text-warning' style='font-size: 80px;' ></i> <br>
    Ingresa una hora de fin valida
    <button type='button' class='close' value='cerrar' data-dismiss='alert' aria-label='close'>
  <span aria-hidden='true'>&times; </span>
   </button>
  </h4>";
        }
      }
      if ($cantidadAprendices == "") {
        $errors[] = "<h4 align='center' class='alert alert-danger alert-dismissible fade show text-dark'>
  <i class='icon-notification text-warning' style='font-size: 80px;' ></i> <br>
  No Ingresaste una cantidad de aprendices
   <button type='button' class='close' value='cerrar' data-dismiss='alert' aria-label='close'>
  <span aria-hidden='true'>&times; </span>
   </button>
  </h4>";
      }
      if (!validarEnteroC($cantidadAprendices)) {
        $errors[] = "<h4 align='center' class='alert alert-danger alert-dismissible fade show text-dark'>
  <i class='icon-notification text-warning' style='font-size: 80px;' ></i> <br>
  Ingresaste una cantidad incorrecta
   <button type='button' class='close' value='cerrar' data-dismiss='alert' aria-label='close'>
  <span aria-hidden='true'>&times; </span>
   </button>
  </h4>";
      }
      $sqlA = "SELECT * FROM area WHERE id_area='$area'";
      $areaBD = $conectarBD->query($sqlA)->fetch_assoc()['id_area'];
      if ($area != $areaBD) {
        $errors[] = "<h4 align='center' class='alert alert-danger alert-dismissible fade show text-dark'>
  <i class='icon-notification text-warning' style='font-size: 80px;' ></i> <br>
  Selecciona Un Area Existente
   <button type='button' class='close' value='cerrar' data-dismiss='alert' aria-label='close'>
  <span aria-hidden='true'>&times; </span>
   </button>
  </h4>";
      } else {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

          if ($conectarBD->connect_error) {

            die("Conexion Fallida:" . $conectarBD->connect_error);
          }

          $token = md5($codigoUnidad . "+" . $nombreUnidad);

    ?>
          <br><br>

          <?php
          if (!empty($_POST['horaInicioT'])) {
            if (!empty($_POST['horaFinT'])) {
              $sql1 = "INSERT INTO unidad ( token, codigoUnidad, nombreUnidad, id_area, tipoTurno, horaInicioM, horaFinM, cantidadAprendices) VALUES ( '$token', '$codigoUnidad', '$nombreUnidad', '$area', '$tipoTurno', '$horaInicioM', '$horaFinM', '$cantidadAprendices')";

              if ($conectarBD->query($sql1) == TRUE) {

                $sql = " INSERT INTO infou15 (codigoUnidad, horaInicioT, horaFinT, token) VALUES ('$codigoUnidad', '$horaInicioT', '$horaFinT', '$token')";
              }
            }
          } else {


            $sql = "INSERT INTO unidad ( token, codigoUnidad, nombreUnidad, id_area, tipoTurno, horaInicioM, horaFinM, cantidadAprendices)
      VALUES ( '$token', '$codigoUnidad' ,'$nombreUnidad' ,'$area', '$tipoTurno', '$horaInicioM', '$horaFinM', '$cantidadAprendices')";
          }

          if (count($errors) == 0) {
            if ($conectarBD->query($sql) == TRUE) {

              $registrado = "<div align='center' class='alert alert-success alert-dismissible fade show'><span class='icon-checkmark1 text-success' style='font-size:50px;'></span><h4>Registro creado con exito</h4>
   <a class='btn btn-warning' href='./listarUnidades.php'>Ver Registros</a>
  <button type='button' class='close' value='cerrar' data-dismiss='alert' aria-label='close'>
  <span aria-hidden='true'>&times; </span>
   </button>
</div>";
            } else {
              echo "<div class='container'>";
              die(include '../errorAlgoSM.php');
              echo "</div>";
            }
          }
          ?>


    <?php

        }
      }
    }
    ?>

    <div align="center" style="margin-left: 350px; margin-right: 350px;">
      <?php echo resultBlock($errors); ?>
    </div>


    <div align="center" class="container">
      <?php
      if (empty($registrado)) {
      ?>
        <h2 class="font-weight-bold">REGISTRAR UNIDAD</h2>
        <br>

        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" autocomplete="off">
          <div class="form-row">
            <div class="form-group col-md-4">
              <label class="font-weight-bold">Codigo de la Unidad:</label>
              <input type="number" name="codigoUnidad" id="codigoUnidad" class="form-control" placeholder="00034" required="">
            </div>
            <?php
            $sqlA = "SELECT * FROM area ORDER BY nombreArea ASC";
            ?>
            <div class="form-group col-md-4">
              <label class="font-weight-bold">Area:</label>
              <select class="form-control" name="id_area" id="id_area">

                <option class="font-weight-bold" value="">Seleccione un area</option>

                <?php
                foreach ($conectarBD->query($sqlA) as $area) {
                ?>
                  <option class="font-weight-bold " value="<?php echo $area['id_area']; ?>"><?php
                                                                                            echo $area['nombreArea']; ?></option>
                <?php

                }
                ?>

              </select>
            </div>
            <div class="form-group col-md-4">
              <label class="font-weight-bold">Nombre Unidad:</label>
              <input type="text" name="nombreUnidad" id="nombreUnidad" class="form-control " placeholder="porcinos" required="">
            </div>
          </div>
          <div class="form-row">

            <div class="form-group col-md-4">
              <label class="font-weight-bold">Tipo Turno:</label>
              <select class="form-control " name="tipoTurno" id="tipoTurno">
                <option class="font-weight-bold" value="">Seleccione Tipo Turno</option>
                <option class="font-weight-bold" value="1">normal</option>
                <option class="font-weight-bold" value="2">15 dias</option>
              </select>
            </div>

            <div class="form-group col-md-4">
              <label class="font-weight-bold">Cantidad De Aprendices:</label>
              <input class="form-control" type="number" name="cantidadAprendices" id="cantidadAprendices" required="required" placeholder="2">
            </div>

            <div class="form-group col-md-4">
              <label class="font-weight-bold">Hora Inicio Mañana</label>
              <input type="time" class="form-control" name="horaInicioM" id="horaInicioM">
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-4">
              <label class="font-weight-bold">Hora Fin Mañana</label>
              <input type="time" class="form-control" name="horaFinM" id="horaFinM">
            </div>


            <div class="form-group col-md-4" id="horaInicioT">
              <label class="font-weight-bold ">Hora Inicio Tarde</label>
              <input class="form-control" type="time" name="horaInicioT">
            </div>


            <div class="form-group col-md-4" id="horaFinT">
              <label class="font-weight-bold">Hora Fin Tarde</label>
              <input class="form-control" type="time" name="horaFinT">
            </div>

          </div>
          <br>

          <div class="btn-group">

            <button type="reset" title="Limpiar Registro" class="btn">
              <i class="icon-loop2 text-secondary" style="font-size: 35px;"></i>
            </button>

            <button type="button" class="btn" title="Cancelar Registro" onclick="window.location.href='./listarUnidades.php'">
              <i class="icon-cancel text-danger" style="font-size: 50px;"> </i>
            </button>


            <button type="submit" class="btn font-weight-bold " title="Registrar Unidad">
              <i class="icon-checkmark1 text-success" style="font-size: 50px;"></i>
            </button>
          </div>


        <?php } else {
        echo $registrado;
      } ?>
        </form>

    </div>


    <script type="text/javascript" src="../Assets/Jquery/jQuery_v3.4.1.js"></script>
    <script type="text/javascript" src="../Assets/bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../Assets/Js/vue.js"></script>
    <script type="text/javascript" src="../Assets/sweetalert2/sweetalert2.all.min.js"></script>

    <script type="text/javascript">
      $(document).ready(function() {
        $("#horaInicioT").addClass('invisible');
        $("#horaFinT").addClass('invisible');

        $("#tipoTurno").on("change", function() {

          let tipoTurno = $(this).val();

          switch (tipoTurno) {
            case '0':
              $("#horaInicioT").addClass('invisible');
              $("#horaFinT").addClass('invisible');
              break;

            case '1':
              $("#horaInicioT").addClass('invisible');
              $("#horaFinT").addClass('invisible');
              break;

            case '2':
              $("#horaInicioT").removeClass('invisible').addClass('visible');
              $("#horaFinT").removeClass('invisible').addClass('visible');
              break;

            default:
              $("#horaInicioT").addClass('invisible');
              $("#horaFinT").addClass('invisible');
              break;
          }

        })
      });
    </script>

</body>

</html>