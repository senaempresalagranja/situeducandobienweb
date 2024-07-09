<?php
session_start();
require '../conecion.php';
require '../Assets/funcion.php';



$idUser = $_SESSION['id'];
$tipoUsuario = $_SESSION['tipo'];
if (empty($_SESSION['tipo'])) {
  echo "<script>window.location.href='../index.php'; </script>";
}

if (empty($_REQUEST['busqueda'])) {
  if (empty($_REQUEST['id_ficha'])) {
    if (empty($_REQUEST['fechaTurno'])) {
      echo "<script>window.location.href='./listaTurnosRutinario.php'</script>";
    }
  }
}

?>
<html>

<head>
  <meta charset="utf-8">
  <style type="text/css">
    .confi {
      height: 30px;

    }
  </style>
  <?php require '../navAdmi.php'; ?>
  <title>Busqueda de Turno Rutinario </title>
  <link rel="icon" type="image/png" sizes="16x16" href="../situ.png">

  <link rel="stylesheet" type="text/css" href="./estilos.css">
  <link rel="stylesheet" type="text/css" href="../Assets/fonts/style.css">
  <link rel="stylesheet" type="text/css" href="../Assets/bootstrap-4.3.1-dist/css/bootstrap.min.css">

  <link rel="stylesheet" type="text/css" href="../Assets/sweetalert2/sweetalert2.min.css">
  <script type="text/javascript" src="../Assets/sweetalert2/sweetalert2.all.min.js"></script>
</head>

<body class=" bg-white">
  <?php require '../navegacion.php';
  $sqlFicha = "SELECT * FROM Ficha ORDER BY id_ficha ASC";

  ?>
  <main id="app">
    <br><br>

    <div class="container">
      <div class="row">
        <div class="col">
          <a class="btn btn-warning font-weight-bold text-light" href="listaTurnosRutinario.php">Todos los
            Turnos</a>
        </div>

        <div style="margin-left: 0px;">
          <h1 class="font-weight-bold" style="text-transform: uppercase;">Busqueda de Turnos R</h1>
        </div>
        <div style="margin-top: 45px;margin-left: 70px;">
          <form class="form-inline float-right" action="buscarTurnosRuti.php" method="get" style="margin-top: -40px; margin-right: 20px;">
            <input class="form-control mr-sm-2 border border-dark
          " type="text" name="busqueda" id="busqueda" placeholder="Buscar" value="<?php if (isset($_GET['busqueda']))  echo $_GET['busqueda']; ?>" onchange='this.form.submit()'>
            <noscript><input type="submit" value="Submit"></noscript>
          </form>
        </div>
      </div>
    </div>

    <div style="margin-left: 120px; margin-top: -10px;">
      <form action="buscarTurnosRuti.php" method="get">

        <select class="form-control  col-md-2 border border-dark" name="fechaTurno" id="fechaTurno" onchange='this.form.submit()'>
          <option value="0"> Seleccionar Trimestre</option>
          <option value="1">1 Trimestre</option>
          <option value="2">2 Trimestre</option>
          <option value="3">3 trimestre</option>
          <option value="4">4 trimestre</option>
        </select>
        <noscript><input type="submit" value="Submit"></noscript>
      </form>
    </div>
    <div style="margin-left: 120px; margin-top: -10px;">
      <form action="buscarTurnosRuti.php" method="get">

        <select class="form-control  col-md-2 border border-dark" name="id_ficha" id="id_ficha" onchange='this.form.submit()'>

          <option class="font-weight-bold" value="0">Buscar Ficha</option>

          <?php

          foreach ($conectarBD->query($sqlFicha) as $ficha) {
          ?>
            <option class="font-weight-bold " value="<?php echo $ficha['id_ficha']; ?>"><?php
                                                                                        echo $ficha['id_ficha']; ?></option>
          <?php
          }

          ?>
        </select>
        <noscript><input type="submit" value="Submit"></noscript>

      </form>
    </div>

    <br>
    <div style="margin-left: 112px; margin-top: -40px;">

      <a onclick="exportarPdf()" title="Exportar a PDF" class="btn" style="font-size: 40px; cursor: pointer;">
        <span class="icon-file-pdf text-danger"></span> </a>

      <a onclick="exportarExcel()" title="Exportar a EXCEL" class="btn" id="pdf" style="font-size: 40px; cursor: pointer; margin-left: -20px;">
        <span class="icon-file-excel text-success"></span></a>

    </div>



    <?php
    if (isset($_REQUEST['id_ficha'])) {

      if (!empty($_REQUEST['id_ficha'])) {
        $id_ficha = $_REQUEST['id_ficha'];


        $registros = "SELECT COUNT(*) totalRegistros FROM `turnorutinario`INNER JOIN unidad ON unidad.codigoUnidad=turnorutinario.codigoUnidad INNER JOIN area ON area.id_area=turnorutinario.id_area LEFT JOIN infou15 ON unidad.codigoUnidad=infou15.codigoUnidad AND infou15.estado=1 AND unidad.estado=1 WHERE id_ficha= '$id_ficha'";
        if (!empty($registros)) {

          if ($conectarBD->query($registros)->num_rows > 0) {

            foreach ($conectarBD->query($registros) as $fila) {
              if (!empty($fila['totalRegistros'])) {

                $totalRegistros = $fila['totalRegistros'];
                $canPagina = 5;

                if (empty($_GET['pagina'])) {
                  $pagina = 1;
                } else {
                  $pagina = $_GET['pagina'];
                }
                $desde = ($pagina - 1) * $canPagina;

                $totalPaginas = ceil($totalRegistros / $canPagina);
              }
            }
          }
          if (isset($desde)) {
            if (isset($canPagina)) {


              if ($idUser == 1) {
                $sqlSE = "SELECT turnorutinario.codigoTurno,turnorutinario.id_aprendiz,turnorutinario.id_ficha, turnorutinario.id_area, turnorutinario.codigoUnidad, turnorutinario.tipoTurno, turnorutinario.fechaTurno,turnorutinario.estado,turnorutinario.fallas,turnorutinario.token, unidad.nombreUnidad, unidad.horaInicioM, unidad.horaFinM,area.nombreArea FROM `turnorutinario`INNER JOIN unidad ON unidad.codigoUnidad=turnorutinario.codigoUnidad INNER JOIN area ON area.id_area=turnorutinario.id_area WHERE id_ficha= '$id_ficha' LIMIT $desde,$canPagina";
              } else {
                $sqlSE = "SELECT turnorutinario.codigoTurno,turnorutinario.id_aprendiz,turnorutinario.id_ficha, turnorutinario.id_area, turnorutinario.codigoTurno, turnorutinario.tipoTurno, turnorutinario.fechaTurno,turnorutinario.estado,turnorutinario.fallas,turnorutinario.token, unidad.nombreUnidad, unidad.horaInicioM, unidad.horaFinM,area.nombreArea FROM `turnorutinario`INNER JOIN unidad ON unidad.codigoUnidad=turnorutinario.codigoUnidad INNER JOIN area ON area.id_area=turnorutinario.id_area WHERE id_ficha= '$id_ficha' AND turnorutinario.estado=1 AND unidad.estado=1 LIMIT $desde,$canPagina";
              }

    ?>

              <div align="right" style="margin-top: -120px; margin-right: 123px;">
                <h5>Total Busqueda:
                  <span class="text-primary font-weight-bold">
                    <?php
                    echo $totalRegistros;
                    ?>
                  </span>
                </h5>
              </div>
              <br><br>
              <br>

              <div class="container">
                <table class='table table-hover' style="margin-top: 30px;">
                  <tr align='center' class='bg-primary '>
                    <th>DOCUMENTO</th>
                    <th>FICHA</th>
                    <th>AREA</th>
                    <th>UNIDAD</th>
                    <th>TIPO DE TURNO</th>
                    <th>FECHA TURNO</th>
                    <th>HORA INICIO</th>
                    <th>HORA FIN</th>
                    <th>Fallas</th>
                    <th>ASISTENCIAS</th>
                    <?php if ($idUser == 1) { ?>
                      <th>ESTADO</th>
                    <?php } ?>
                    <th> ACCIONES</th>

                  </tr>
                  <?php
                  if ($conectarBD->query($sqlSE)->num_rows > 0) {

                    foreach ($conectarBD->query($sqlSE) as $ficha) {

                  ?>
                      <tr align='center' class='font-weight-bold' scope='row'>
                        <td><?php echo $ficha['id_aprendiz']; ?></td>
                        <td><?php echo $ficha['id_ficha']; ?></td>
                        <td><?php echo $ficha['nombreArea'] ?></td>
                        <td><?php echo $ficha['nombreUnidad'] ?></td>
                        <td><?php echo $ficha['tipoTurno']; ?></td>
                        <td><?php echo $ficha['fechaTurno']; ?></td>
                        <td><?php echo $ficha['horaInicioM']; ?></td>
                        <td><?php echo $ficha['horaFinM']; ?></td>
                        <td><?php echo $ficha['fallas']; ?></td>
                        <td align='center' class='font-weight-bold'>
                          <i class='btn icon-checkmark1 text-success' style="font-size: 20px;" href='#' onclick='confirmar1(<?php echo $ficha['codigoTurno']; ?>)' onclick='this.disabled="disabled"'></i>
                        </td>
                        <?php if ($idUser == 1) { ?>
                          <td>
                            <?php
                            switch ($ficha['estado']) {
                              case '1':
                                $ficha['estado'] = "Activo";
                            ?>
                                <span class="text-success"><?php echo $ficha['estado']; ?></span>
                              <?php break;

                              case '0':
                                $ficha['estado'] = "Inactivo";
                              ?>
                                <span class="text-danger"><?php echo $ficha['estado']; ?></span>
                            <?php
                                break;
                            }
                            ?>
                          </td>
                        <?php } ?>

                        <?


                        ?>
                        <td align='center'>
                          <div class='btn-group' role='group'>

                            <a class='btn btn-secondary' href='./turnoManualE.php?token=<?php echo $ficha['token']; ?>' title="Editar Turno Rutinario"><span class="icon-edit"></span> </a>

                            <?php if ($tipoUsuario == 'administrador') {
                              if ($idUser == 1) {
                                if ($ficha['estado'] == 'Activo') {
                            ?>
                                  <a class='btn ' href="./eliminarTurnoRutinario.php?token=<?php echo $ficha['token']; ?>"><span class="icon-checkmark1 text-success" style="font-size: 25px;"></span></a>
                                <?php
                                } else {
                                ?>
                                  <a class='btn' href="./eliminarTurnoRutinario.php?token=<?php echo $ficha['token']; ?>"><span class="icon-cancel text-danger" style="font-size: 25px;"></span></a>
                                <?php
                                }
                              } else { ?>
                                <a class='btn btn-danger' href="./eliminarTurnoRutinario.php?token=<?php echo $ficha['token']; ?>"><span class="icon-bin text-light" style="font-size: 20px;"></span></a>
                            <?php
                              }
                            }
                            ?>
                          </div>

                        </td>
                        <?php
                        if ($ficha['tipoTurno'] == '15 dias') {
                          $sqlI = "SELECT * FROM infou15 INNER JOIN unidad ON infou15.codigoUnidad=unidad.codigoUnidad WHERE infou15.codigoUnidad=" . $ficha['codigoUnidad'];

                          if ($conectarBD->query($sqlI)) {

                        ?>
                            <td id="cambio">
                              <div class="dropleft">
                                <button type="button" id="icon" class="btn icon-circle-down text-primary" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" value="1">
                                </button>
                                <?php

                                $horaInicioT = $conectarBD->query($sqlI)->fetch_assoc()['horaInicioT'];
                                $horaFinT = $conectarBD->query($sqlI)->fetch_assoc()['horaFinT'];
                                ?>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                  <button class="dropdown-item" type="button">Nombre Unidad
                                    <?php echo $ficha['nombreUnidad']; ?></button>
                                  <button class="dropdown-item" type="button">Hora Inicio Tarde
                                    <?php echo $horaInicioT; ?></button>
                                  <button class="dropdown-item" type="button">Hora Fin Tarde
                                    <?php echo $horaFinT; ?></button>
                                </div>
                              </div>
                            </td>
                        <?php
                          }
                        }
                        ?>
                      </tr>
            <?php
                    }
                  }
                }
              }
            }
            ?>

                </table>
              </div>

              <?php

              if (!empty($totalRegistros)) {

                if ($totalRegistros != 0) {

              ?>
                  <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center">
                      <?php
                      if ($pagina != 1) {

                      ?>
                        <li class="page-item">
                          <a class="page-link font-weight-bold" href="?pagina=<?php echo 1; ?>&id_ficha=<?php echo $id_ficha; ?>">INICIO</a>
                        </li>
                        <li class="page-item">
                          <a class="page-link" href="?pagina=<?php echo $pagina - 1; ?>&id_ficha=<?php echo $id_ficha; ?>"><span class="icon-circle-left text-primary"></span></a>
                        </li>
                      <?php
                      }
                      for ($i = 1; $i <= $totalPaginas; $i++) {
                        if ($i == $pagina) {
                          echo '<li class="page-item page-link bg-success text-light">' . $i . '</li>';
                        } else {
                          echo '<li class="page-item"><a class="page-link" href="?pagina=' . $i . '&id_ficha=' . $id_ficha . '">' . $i . '</a></li>';
                        }
                      }

                      if ($pagina != $totalPaginas) {

                      ?>
                        <li class="page-item">
                          <a class="page-link" href="?pagina=<?php echo $pagina + 1; ?>&id_ficha=<?php echo $id_ficha; ?>"><span class="icon-circle-right text-primary"></span></a>
                        </li>
                        <li class="page-item">
                          <a class="page-link font-weight-bold" href="?pagina=<?php echo $totalPaginas; ?>&id_ficha=<?php echo $id_ficha; ?>">FIN</a>
                        </li>
                      <?php
                      }
                      ?>
                    </ul>
                  </nav>
              <?php
                }
              } else {
                echo '<h1 align="center">No se ha Encontrado Ningun Resultado</h1><br>
              <div align="center"></div>';
              }
              ?>
          <?php

        }
      }

          ?>



          <?php
          if (isset($_REQUEST['fechaTurno'])) {
            if (!empty($_REQUEST['fechaTurno'])) {
              date_default_timezone_set('America/Bogota');

              $ano = date('Y');
              $mes = date('m');
              $dias = date('d');
              $dia = date('D');

              $fechaT = $_REQUEST['fechaTurno'];

              switch ($fechaT) {
                case '1':
                  $fechaI = $ano . '-01-01';
                  $fechaF = $ano . '-03-31';


                  break;

                case '2':
                  $fechaI = $ano . '-04-01';
                  $fechaF = $ano . '-06-31';


                  break;

                case '3':
                  $fechaI = $ano . '-07-01';
                  $fechaF = $ano . '-09-31';


                  break;

                case '4':
                  $fechaI = $ano . '-10-01';
                  $fechaF = $ano . '-12-31';


                  break;

                default:
                  echo "Ingrese Una Fecha Correcta";
                  break;
              }

              $registros = "SELECT COUNT(*) AS totalRegistros FROM  turnorutinario INNER JOIN unidad ON turnorutinario.codigoUnidad=unidad.codigoUnidad INNER JOIN area ON turnorutinario.id_area=area.id_area WHERE fechaTurno BETWEEN '$fechaI' AND '$fechaF'";
              if (!empty($registros)) {

                if ($conectarBD->query($registros)->num_rows > 0) {

                  foreach ($conectarBD->query($registros) as $fila) {
                    if (!empty($fila['totalRegistros'])) {

                      $totalRegistros = $fila['totalRegistros'];
                      $canPagina = 5;

                      if (empty($_GET['pagina'])) {
                        $pagina = 1;
                      } else {
                        $pagina = $_GET['pagina'];
                      }
                      $desde = ($pagina - 1) * $canPagina;

                      $totalPaginas = ceil($totalRegistros / $canPagina);
                    }
                  }
                }
                if (isset($desde)) {
                  if (isset($canPagina)) {


                    $sql = "SELECT turnorutinario.id_aprendiz, turnorutinario.codigoTurno, turnorutinario.codigoUnidad, turnorutinario.id_ficha, area.nombreArea, unidad.nombreUnidad, turnorutinario.tipoTurno, turnorutinario.fechaTurno, unidad.horaInicioM, unidad.horaFinM, turnorutinario.estado, turnorutinario.fallas, turnorutinario.token  FROM turnorutinario INNER JOIN unidad ON turnorutinario.codigoUnidad=unidad.codigoUnidad INNER JOIN area ON turnorutinario.id_area=area.id_area  WHERE fechaTurno BETWEEN '$fechaI' AND '$fechaF' LIMIT $desde,$canPagina";
          ?>


                    <div align="right" style="margin-top: -120px; margin-right: 123px;">
                      <h5>Total Busqueda:
                        <span class="text-primary font-weight-bold">
                          <?php
                          echo $totalRegistros;
                          ?>
                        </span>
                      </h5>
                    </div>
                    <br><br>
                    <div class="container">
                      <table class='table table-hover' style="margin-top: 60px;">
                        <tr align='center' class='bg-primary '>
                          <th>DOCUMENTO</th>
                          <th>FICHA</th>
                          <th>AREA</th>
                          <th>UNIDAD</th>
                          <th>TIPO DE TURNO</th>
                          <th>FECHA TURNO</th>
                          <th>HORA INICIO</th>
                          <th>HORA FIN</th>
                          <th>FALLAS</th>
                          <th>ASISTENCIAS</th>
                          <?php if ($idUser == 1) { ?>
                            <th>ESTADO</th>
                          <?php } ?>
                          <th> ACCIONES</th>

                        </tr>
                        <?php
                        if ($conectarBD->query($sql)->num_rows > 0) {

                          foreach ($conectarBD->query($sql) as $fila) {

                        ?>
                            <tr align='center' class='font-weight-bold' scope='row'>
                              <td><?php echo $fila['id_aprendiz']; ?></td>
                              <td><?php echo $fila['id_ficha']; ?></td>
                              <td><?php echo $fila['nombreArea']; ?></td>
                              <td><?php echo $fila['nombreUnidad']; ?></td>
                              <td><?php echo $fila['tipoTurno']; ?></td>
                              <td><?php echo $fila['fechaTurno']; ?></td>
                              <td><?php echo $fila['horaInicioM']; ?></td>
                              <td><?php echo $fila['horaFinM']; ?></td>
                              <td><?php echo $fila['fallas']; ?></td>

                              <td align='center' class='font-weight-bold'>
                                <i class='btn icon-checkmark1 text-success' style="font-size: 20px;" href='#' onclick='confirmar1(<?php echo $fila['codigoTurno']; ?>)' onclick='this.disabled="disabled"'></i>
                              </td>

                              <?php if ($idUser == 1) { ?>
                                <td>
                                  <?php

                                  switch ($fila['estado']) {
                                    case '1':
                                      $fila['estado'] = 'Activo';
                                      break;
                                    case '0':
                                      $fila['estado'] = 'Inactivo';
                                      break;
                                  }

                                  if ($fila['estado'] == 'Activo') {
                                    echo "<span class='text-success' href=''>" . $fila['estado'] . "</span>";
                                  } else {
                                    echo "<span class='text-danger'>" . $fila['estado'] . "</span>";
                                  }

                                  ?>
                                </td>
                              <?php } ?>

                              <?


                              ?>
                              <td align='center'>
                                <div class='btn-group' role='group'>

                                  <a class='btn btn-secondary' href='./turnoManualE.php?token=<?php echo $fila['token']; ?>' title="Editar Turno Rutinario"><span class="icon-edit"></span> </a>

                                  <?php if ($tipoUsuario == 'administrador') {
                                    if ($idUser == 1) {
                                      if ($fila['estado'] == 'Activo') {
                                  ?>
                                        <a class='btn ' href="./eliminarTurnoRutinario.php?token=<?php echo $fila['token']; ?>"><span class="icon-checkmark1 text-success" style="font-size: 25px;"></span></a>
                                      <?php
                                      } else {
                                      ?>
                                        <a class='btn' href="./eliminarTurnoRutinario.php?token=<?php echo $fila['token']; ?>"><span class="icon-cancel text-danger" style="font-size: 25px;"></span></a>
                                      <?php
                                      }
                                    } else { ?>
                                      <a class='btn btn-danger' href="./eliminarTurnoRutinario.php?token=<?php echo $fila['token']; ?>"><span class="icon-bin text-light" style="font-size: 20px;"></span></a>
                                  <?php
                                    }
                                  }
                                  ?>
                                </div>

                              </td>
                              <?php
                              if ($fila['tipoTurno'] == '15 dias') {
                                $sqlI = "SELECT * FROM infou15 INNER JOIN unidad ON infou15.codigoUnidad=unidad.codigoUnidad WHERE infou15.codigoUnidad=" . $fila['codigoUnidad'];

                                if ($conectarBD->query($sqlI)) {

                              ?>
                                  <td id="cambio">
                                    <div class="dropleft">
                                      <button type="button" id="icon" class="btn icon-circle-down text-primary" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" value="1">
                                      </button>
                                      <?php

                                      $horaInicioT = $conectarBD->query($sqlI)->fetch_assoc()['horaInicioT'];
                                      $horaFinT = $conectarBD->query($sqlI)->fetch_assoc()['horaFinT'];
                                      ?>
                                      <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                        <button class="dropdown-item" type="button">Nombre Unidad
                                          <?php echo $fila['nombreUnidad']; ?></button>
                                        <button class="dropdown-item" type="button">Hora Inicio Tarde
                                          <?php echo $horaInicioT; ?></button>
                                        <button class="dropdown-item" type="button">Hora Fin Tarde
                                          <?php echo $horaFinT; ?></button>
                                      </div>
                                    </div>
                                  </td>
                              <?php
                                }
                              }
                              ?>

                            </tr>
                  <?php
                          }
                        }
                      }
                    }
                  }
                  ?>

                      </table>
                    </div>
                    <br>
                    <?php

                    if (!empty($totalRegistros)) {

                      if ($totalRegistros != 0) {

                    ?>
                        <nav aria-label="Page navigation example">
                          <ul class="pagination justify-content-center">
                            <?php
                            if ($pagina != 1) {

                            ?>
                              <li class="page-item">
                                <a class="page-link font-weight-bold" href="?pagina=<?php echo 1; ?>&fechaTurno=<?php echo $fechaT; ?>">INICIO</a>
                              </li>
                              <li class="page-item">
                                <a class="page-link" href="?pagina=<?php echo $pagina - 1; ?>&fechaTurno=<?php echo $fechaT; ?>"><span class="icon-circle-left text-primary"></span></a>
                              </li>
                            <?php
                            }


                            if ($pagina != $totalPaginas) {

                            ?>
                              <li class="page-item">
                                <a class="page-link" href="?pagina=<?php echo $pagina + 1; ?>&fechaTurno=<?php echo $fechaT; ?>"><span class="icon-circle-right text-primary"></span></a>
                              </li>
                              <li class="page-item">
                                <a class="page-link font-weight-bold" href="?pagina=<?php echo $totalPaginas; ?>&fechaTurno=<?php echo $fechaT; ?>">FIN</a>
                              </li>
                            <?php
                            }
                            ?>
                          </ul>
                        </nav>
                    <?php
                      }
                    } else {
                      echo '<h1 align="center">No se ha Encontrado Ningun Resultado</h1><br>
              <div align="center"></div>';
                    }

                    ?>


                  <?php

                }
              } else { ?>


                  <br>
                  <br>

                  <!DOCTYPE html>
                  <html>

                  <head>
                    <meta charset="utf-8">
                    <style type="text/css">
                      .confi {
                        height: 30px;

                      }
                    </style>

                    <title>lista de Turnos</title>
                    <link rel="stylesheet" type="text/css" href="./estilos.css">
                    <link rel="stylesheet" type="text/css" href="../Assets/fonts/style.css">
                    <link rel="stylesheet" type="text/css" href="
  ../Assets/bootstrap-4.3.1-dist/css/bootstrap.min.css
">
                  </head>

                  <body class=" bg-light">
                    <?php

                    if (isset($_REQUEST['busqueda'])) {

                      $busqueda = strtolower($_REQUEST['busqueda']);
                      if (empty($busqueda)) {
                        header("location: ./listaTurnosRutinario.php");
                      }
                    }


                    if (isset($busqueda)) {


                      $registros = "SELECT COUNT(*) as totalRegistros FROM turnorutinario INNER JOIN unidad ON turnorutinario.codigoUnidad=unidad.codigoUnidad INNER JOIN area ON turnorutinario.id_area=area.id_area INNER JOIN infou15 ON turnorutinario.codigoUnidad=infou15.codigoUnidad WHERE turnorutinario.codigoTurno LIKE '%$busqueda%' OR turnorutinario.id_aprendiz LIKE '%$busqueda%' OR turnorutinario.id_ficha LIKE '%$busqueda%' OR turnorutinario.codigoTurno LIKE '%$busqueda%' OR turnorutinario.tipoTurno LIKE '%$busqueda%' OR turnorutinario.fechaTurno LIKE '%$busqueda%' OR unidad.nombreUnidad LIKE '%$busqueda%' OR unidad.horaInicioM LIKE '%$busqueda%' OR unidad.horaFinM LIKE '%$busqueda%' OR area.nombreArea LIKE '%$busqueda%' OR infou15.horaInicioT LIKE '%$busqueda%' OR infou15.horaFinT LIKE '%$busqueda%' AND infou15.estado=1 AND unidad.estado=1 ";

                      if ($conectarBD->query($registros)->num_rows > 0) {

                        foreach ($conectarBD->query($registros) as $fila) {

                          $totalRegistros = $fila['totalRegistros'];
                          $canPagina = 5;

                          if (empty($_GET['pagina'])) {
                            $pagina = 1;
                          } else {
                            $pagina = $_GET['pagina'];
                          }
                          $desde = ($pagina - 1) * $canPagina;

                          $totalPaginas = ceil($totalRegistros / $canPagina);
                        }
                      }
                      $sqlS = "SELECT turnorutinario.id_aprendiz, turnorutinario.codigoTurno, turnorutinario.codigoUnidad, turnorutinario.id_ficha, area.nombreArea, unidad.nombreUnidad, turnorutinario.tipoTurno, turnorutinario.fechaTurno, unidad.horaInicioM, unidad.horaFinM, turnorutinario.estado, turnorutinario.fallas, turnorutinario.token FROM turnorutinario INNER JOIN unidad ON turnorutinario.codigoUnidad=unidad.codigoUnidad INNER JOIN area ON turnorutinario.id_area=area.id_area  WHERE turnorutinario.codigoTurno LIKE '%$busqueda%' OR turnorutinario.id_aprendiz LIKE '%$busqueda%' OR turnorutinario.id_ficha LIKE '%$busqueda%' OR turnorutinario.codigoTurno LIKE '%$busqueda%' OR turnorutinario.tipoTurno LIKE '%$busqueda%' OR turnorutinario.fechaTurno LIKE '%$busqueda%' OR   unidad.nombreUnidad LIKE '%$busqueda%' OR unidad.horaInicioM LIKE '%$busqueda%' OR unidad.horaFinM LIKE '%$busqueda%' OR area.nombreArea LIKE '%$busqueda%' AND turnorutinario.estado=1 AND unidad.estado=1
 LIMIT $desde, $canPagina";

                    ?>
                      <div class="container">
                        <br>
                        <div align="right" style="margin-top: -100px;">
                          <h5>Total Busqueda:
                            <span class="text-primary font-weight-bold">
                              <?php
                              echo $totalRegistros;
                              ?>
                            </span>
                          </h5>
                        </div>
                        <table class='table table-hover' style="margin-top: 30px;">
                          <tr class='bg-primary text-light' align='center' class='bg-primary'>
                            <th>Documento</th>
                            <th>Ficha</th>
                            <th>Area</th>
                            <th>Unidad</th>
                            <th>Tipo de Turno</th>
                            <th>Fecha Turno</th>
                            <th>Hora Inicio</th>
                            <th>Hora Fin</th>
                            <th>FALLAS</th>
                            <th>ASISTENCIAS</th>
                            <?php if ($idUser == 1) {
                            ?>
                              <th>Estado</th>
                            <?php } ?>
                            <th>Acciones</th>
                          </tr>
                          <?php
                          if ($conectarBD->query($sqlS)->num_rows > 0) {

                            foreach ($conectarBD->query($sqlS) as $turno) {

                          ?>


                              <tr align='center' class='font-weight-bold' scope='row'>
                                <td><?php echo $turno['id_aprendiz']; ?></td>
                                <td><?php echo $turno['id_ficha']; ?></td>
                                <td><?php echo $turno['nombreArea']; ?></td>
                                <td><?php echo $turno['nombreUnidad']; ?></td>
                                <td><?php echo $turno['tipoTurno']; ?></td>
                                <td><?php echo $turno['fechaTurno']; ?></td>
                                <td><?php echo $turno['horaInicioM']; ?></td>
                                <td><?php echo $turno['horaFinM']; ?></td>
                                <td><?php echo $turno['fallas']; ?></td>

                                <td align='center' class='font-weight-bold'>
                                  <i class='btn icon-checkmark1 text-success' style="font-size: 20px;" href='#' onclick='confirmar1(<?php echo $turno['codigoTurno']; ?>)' onclick='this.disabled="disabled"'></i>
                                </td>
                                <?php if ($tipoUsuario == 'administrador') {
                                  if ($idUser == 1) {
                                ?>
                                    <td><?php
                                        switch ($turno['estado']) {
                                          case '1':
                                            $turno['estado'] = 'Activo';
                                            break;
                                          case '0':
                                            $turno['estado'] = 'Inactivo';
                                            break;
                                        }
                                        if ($turno['estado'] == 'Activo') {
                                          echo "<span class='text-success' href=''>" . $turno['estado'] . "</span>";
                                        } else {
                                          echo "<span class='text-danger'>" . $turno['estado'] . "</span>";
                                        }

                                        ?></td>
                                <?php }
                                }
                                ?>
                                <td align='center'>
                                  <div class='btn-group' role='group'>

                                    <a class='btn btn-secondary' href='./turnoManualE.php?token=<?php echo $turno['token']; ?>' title="Editar Turno Rutinario"><span class="icon-edit"></span> </a>

                                    <?php if ($tipoUsuario == 'administrador') {
                                      if ($idUser == 1) {
                                        if ($turno['estado'] == 'Activo') {
                                    ?>
                                          <a class='btn ' href="./eliminarTurnoRutinario.php?token=<?php echo $turno['token']; ?>"><span class="icon-checkmark1 text-success" style="font-size: 25px;"></span></a>
                                        <?php
                                        } else {
                                        ?>
                                          <a class='btn' href="./eliminarTurnoRutinario.php?token=<?php echo $turno['token']; ?>"><span class="icon-cancel text-danger" style="font-size: 25px;"></span></a>
                                        <?php
                                        }
                                      } else { ?>
                                        <a class='btn btn-danger' href="./eliminarTurnoRutinario.php?token=<?php echo $turno['token']; ?>"><span class="icon-bin text-light" style="font-size: 20px;"></span></a>
                                    <?php
                                      }
                                    }
                                    ?>
                                  </div>

                                </td>
                                <?php
                                if ($turno['tipoTurno'] == '15 dias') {
                                  $sqlI = "SELECT * FROM infou15 INNER JOIN unidad ON infou15.codigoUnidad=unidad.codigoUnidad WHERE infou15.codigoUnidad=" . $turno['codigoUnidad'];

                                  if ($conectarBD->query($sqlI)) {

                                ?>
                                    <td id="cambio">
                                      <div class="dropleft">
                                        <button type="button" id="icon" class="btn icon-circle-down text-primary" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" value="1">
                                        </button>
                                        <?php

                                        $horaInicioT = $conectarBD->query($sqlI)->fetch_assoc()['horaInicioT'];
                                        $horaFinT = $conectarBD->query($sqlI)->fetch_assoc()['horaFinT'];
                                        ?>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                          <button class="dropdown-item" type="button">Nombre Unidad
                                            <?php echo $turno['nombreUnidad']; ?></button>
                                          <button class="dropdown-item" type="button">Hora Inicio Tarde
                                            <?php echo $horaInicioT; ?></button>
                                          <button class="dropdown-item" type="button">Hora Fin Tarde
                                            <?php echo $horaFinT; ?></button>
                                        </div>
                                      </div>
                                    </td>
                                <?php
                                  }
                                }
                                ?>
                              </tr>


                          <?php
                            }
                          }
                          ?>
                        </table>
                      </div>
                      <br>
                      <?php
                      if ($totalRegistros != 0) {

                      ?>
                        <nav aria-label="Page navigation example">
                          <ul class="pagination justify-content-center">
                            <?php
                            if ($pagina != 1) {

                            ?>
                              <li class="page-item">
                                <a class="page-link font-weight-bold" href="?pagina=<?php echo 1; ?>&busqueda=<?php echo $busqueda; ?>">INICIO</a>
                              </li>
                              <li class="page-item">
                                <a class="page-link" href="?pagina=<?php echo $pagina - 1; ?>&busqueda=<?php echo $busqueda; ?>"><span class="icon-circle-left text-primary"></span></a>
                              </li>
                            <?php
                            }


                            if ($pagina != $totalPaginas) {

                            ?>
                              <li class="page-item">
                                <a class="page-link" href="?pagina=<?php echo $pagina + 1; ?>&busqueda=<?php echo $busqueda; ?>"><span class="icon-circle-right text-primary"></span></a>
                              </li>
                              <li class="page-item">
                                <a class="page-link font-weight-bold" href="?pagina=<?php echo $totalPaginas; ?>&busqueda=<?php echo $busqueda; ?>">FIN</a>
                              </li>
                            <?php
                            }
                            ?>
                          </ul>
                        </nav>
                  <?php
                      } else {
                        echo '<h1 align="center">No se ha Encontrado Ningun Resultado</h1><br></div>';
                      }
                    }
                  }
                  ?>



                  <br>
                  <br>


                  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
                  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
                  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
                  <script type="text/javascript">
                    $("#cambio button").on("click", function() {
                      let valor = $(this).val()
                      console.log(valor)

                      if (valor == '1') {
                        $("#cambio button").val('2')
                        $(this).removeClass('text-primary icon-circle-down').addClass('text-danger icon-circle-up')
                      } else {
                        $("#cambio button").val('1')
                        $(this).removeClass('text-danger icon-circle-up').addClass('text-primary icon-circle-down')
                      }

                    })


                    function exportarExcel() {

                      const swalWithBootstrapButtons = Swal.mixin({
                        customClass: {
                          confirmButton: 'btn btn-success',

                          cancelButton: 'btn btn-danger'
                        },
                        buttonsStyling: false
                      })


                      swalWithBootstrapButtons.fire({
                        title: "¿Desea Exportar <?php echo $totalRegistros; ?> Registros de la busqueda de los Turnos Rutinarios a Excel?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Si',
                        cancelButtonText: 'No',
                        reverseButtons: true
                      }).then((result) => {
                        if (result.value) {
                          window.location.href =
                            "pdfTurnoR.php?E=1&<?php if (isset($_REQUEST['busqueda'])) { ?>busqueda=<?php echo $_REQUEST['busqueda'];
                                                                                                }
                                                                                                if (isset($_REQUEST['id_ficha'])) { ?>id_ficha=<?php echo $_REQUEST['id_ficha'];
                                                                                                                                                                                }
                                                                                                                                                                                if (isset($_REQUEST['fechaTurno'])) { ?>fechaTurno=<?php echo $_REQUEST['fechaTurno'];
                                                                                                                                                                                                                                                                  } ?>";
                        } else if (

                          result.dismiss === Swal.DismissReason.cancel
                        ) {
                          swalWithBootstrapButtons.fire(
                            'Cancelado',
                            'No será exportado',
                            'error'
                          )
                        }
                      })
                    }

                    function exportarPdf() {

                      const swalWithBootstrapButtons = Swal.mixin({
                        customClass: {
                          confirmButton: 'btn btn-success',

                          cancelButton: 'btn btn-danger'
                        },
                        buttonsStyling: false
                      })


                      swalWithBootstrapButtons.fire({
                        title: "¿Desea Exportar <?php echo $totalRegistros; ?> Registros de la busqueda de los Turnos Rutinarios a PDF?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Si',
                        cancelButtonText: 'No',
                        reverseButtons: true
                      }).then((result) => {
                        if (result.value) {
                          window.location.href =
                            "descargarPDFTR.php?<?php if (isset($_REQUEST['busqueda'])) { ?>busqueda=<?php echo $_REQUEST['busqueda'];
                                                                                                  }
                                                                                                  if (isset($_REQUEST['id_ficha'])) { ?>id_ficha=<?php echo $id_ficha;
                                                                                                                                                                                  }
                                                                                                                                                                                  if (isset($_REQUEST['fechaTurno'])) { ?>fechaTurno=<?php echo $_REQUEST['fechaTurno'];
                                                                                                                                                                                                                                                        } ?>";
                        } else if (

                          result.dismiss === Swal.DismissReason.cancel
                        ) {
                          swalWithBootstrapButtons.fire(
                            'Cancelado',
                            'No será exportado',
                            'error'
                          )
                        }
                      })
                    }
                  </script>

                  <script type="text/javascript">
                    $("#cambio button").on("click", function() {
                      let valor = $(this).val()
                      console.log(valor)

                      if (valor == '1') {
                        $("#cambio button").val('2')
                        $(this).removeClass('text-primary icon-circle-down').addClass('text-danger icon-circle-up')
                      } else {
                        $("#cambio button").val('1')
                        $(this).removeClass('text-danger icon-circle-up').addClass('text-primary icon-circle-down')
                      }

                    })

                    function confirmar1(codigoTurno) {

                      const swalWithBootstrapButtons = Swal.mixin({
                        customClass: {
                          confirmButton: 'btn btn-success',

                          cancelButton: 'btn btn-danger'
                        },
                        buttonsStyling: false
                      })


                      swalWithBootstrapButtons.fire({
                        title: 'Estas seguro de agregar una falla al aprendiz?',
                        text: "Esta operacion no se puede revertir! Con esto enviara un memorando",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Si, agrega la falla! ',
                        cancelButtonText: 'No, cancelalo! ',
                        reverseButtons: true
                      }).then((result) => {
                        if (result.value) {
                          window.location.href = "agregarFallaRutinario.php?codigoTurno=" + codigoTurno;
                        } else if (

                          result.dismiss === Swal.DismissReason.cancel
                        ) {
                          swalWithBootstrapButtons.fire(
                            'Cancelado',
                            'Tu falla no a sido agregada :)',
                            'error'
                          )
                        }
                      })
                    }
                  </script>
                  </body>

                  </html>