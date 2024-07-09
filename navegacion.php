<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <link rel="icon" type="image/png" sizes="16x16" href="../situ.png">
</head>

<body class="bg-white">
  <header>
    <div>
      <nav class=" navbar navbar-expand-lg navbar-light  py-4 " style="background-color: #e9e9e9;">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav nav mr-auto">

            <li class="font-weight-bold" style="margin-left: 12px;">
              <a class=" nav-link disable " href="../administrador/paginaPrincipal.php" role="button">
                INICIO</a>
            </li>

            <li class="nav-item dropdown" style="margin-left: 110px;">
              <a class="nav-link disable font-weight-bold " data-toggle="dropdown" href="#">
                GESTIONAR UNIDAD
              </a>

              <div class="dropdown-menu dropdown-menu-lg dropdown-menu-left animated flipInY">
                <a href="../administrador/listarUnidades.php" class="dropdown-item  font-weight-bold text-dark">
                  <i class="" style="font-size: 20px;"></i> Listar Unidades
                </a>
                <div class="dropdown-divider"></div>

                <a href="../administrador/listarAreas.php" class="dropdown-item font-weight-bold text-dark">
                  <i class=""></i> Listar Areas
                </a>
              </div>

            </li>

            <li class="nav-item dropdown" style="margin-left: 120px;">
              <a class="nav-link disable font-weight-bold " data-toggle="dropdown" href="#">
                GESTIONAR FICHA
              </a>

              <div class="dropdown-menu dropdown-menu-lg dropdown-menu-left animated flipInY">
                <a href="../administrador/listarAprendices.php" class="dropdown-item font-weight-bold text-dark">
                  <i class=""></i> Listar Aprendices
                </a>
                <div class="dropdown-divider"></div>

                <a href="../administrador/listarFichas.php" class="dropdown-item font-weight-bold text-dark">
                  <i class=""></i> Listar Fichas
                </a>
                <div class="dropdown-divider"></div>
                <a href="../administrador/listarProgramas.php" class="dropdown-item font-weight-bold text-dark">
                  <i class=""></i> Listar Programas
                </a>
              </div>

            </li>

            <li class="nav-item dropdown" style="margin-left: 120px;">
              <a class="nav-link disable font-weight-bold " data-toggle="dropdown" href="#">
                GESTIONAR TURNO
              </a>

              <div class="dropdown-menu dropdown-menu-lg dropdown-menu-left animated flipInY">
                <a href="../administrador/listaTurnosRutinario.php" class="dropdown-item font-weight-bold text-dark">
                  <div class=""><i class="" style="font-size: 20px;"></i></div> Turnos Rutinarios
                </a>
                <div class="dropdown-divider"></div>

                <a href="../administrador/listarTurnosEspeciales.php" class="dropdown-item font-weight-bold text-dark">
                  <i class=""></i> Turnos Especiales
                </a>
                <div class="dropdown-divider"></div>
                <a href="../administrador/TurnosAutomaticos.php" class="dropdown-item font-weight-bold text-dark">
                  <i class=""></i> Turnos Automaticos
                </a>
              </div>
            </li>
            <li class="nav-item dropdown" style="margin-left: 120px;">
              <a class="nav-link disable font-weight-bold " data-toggle="dropdown" href="#">
                GESTIONAR MEMORANDO
              </a>

              <div class="dropdown-menu dropdown-menu-lg dropdown-menu-left animated flipInY">
                <a href="../user/listarMemorandos.php" class="dropdown-item font-weight-bold text-dark">
                  <i class="" style="font-size: 20px;"></i> listar Memorandos
                </a>
              </div>

            </li>
          </ul>


        </div>
      </nav>
    </div>

  </header>
</body>

</html>