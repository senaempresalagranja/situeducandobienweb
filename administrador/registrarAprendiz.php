<?php
session_start();
require '../conecion.php';
require '../Assets/funcion.php';




$idUser = $_SESSION['id'];
$tipoUsuario = $_SESSION['tipo'];
if (empty($_SESSION['tipo'])) {
    echo "<script>window.location.href='../index.php'; </script>";
}
?>
<!DOCTYPE html>
<html>

<head>
    <?php require '../navAdmi.php'; ?>
    <title>Registrar Aprendiz</title>
    <link rel="icon" type="image/png" sizes="16x16" href="../situ.png">
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="../estilos.css">
    <link rel="stylesheet" type="text/css" href="../Assets/fonts/style.css">
    <link rel="stylesheet" type="text/css" href="../Assets/bootstrap-4.3.1-dist/css/bootstrap.min.css">
    <link rel="icon" type="image/png" sizes="16x16" href="../situ.png">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
</head>

<body class=" bg-white">
    <?php
    include '../navegacion.php';
    ?>
    <?php
    if ($conectarBD->connect_error) {
        die(require '../errorAlgoSM.php');
    }
    ?>
    <?php

    $errors = array();

    if (!empty($_POST)) {
        $tipo =  $conectarBD->real_escape_string($_POST['tipoDocumento']);
        $documento = $conectarBD->real_escape_string($_POST['documento']);
        $nombres = $conectarBD->real_escape_string($_POST['nombres']);
        $apellidos = $conectarBD->real_escape_string($_POST['apellidos']);
        $telefono = $conectarBD->real_escape_string($_POST['telefono']);
        $ficha = $conectarBD->real_escape_string($_POST['id_ficha']);
        $sexo = $conectarBD->real_escape_string($_POST['sexo']);
        $email = $conectarBD->real_escape_string($_POST['email']);



        if (isNullA($tipo, $documento, $nombres, $apellidos, $telefono, $ficha, $sexo, $email)) {

            if (empty($tipo)) {
                $errors[] = '<div class="alert alert-danger"><h4>El tipo de Documento es Obligatorio</h4> </div>';
            }

            if (empty($documento)) {
                $errors[] = '<div class="alert alert-danger"><h4>El tipo Número de Documento es Obligatorio</h4> </div>';
            }
            if (empty($nombres)) {
                $errors[] = '<div class="alert alert-danger"><h4>El campo nombre está vacío</h4> </div>';
            }
            if (empty($apellidos)) {
                $errors[] = '<div class="alert alert-danger"><h4>El campo apellidos es Obligatorio</h4> </div>';
            }
            if (empty($telefono)) {
                $errors[] = '<div class="alert alert-danger"><h4>El campo telefono es Obligatorio</h4> </div>';
            }

            if (empty($ficha)) {
                $errors[] = '<div class="alert alert-danger"><h4>El campo Ficha es Obligatorio</h4> </div>';
            }
            if (empty($sexo)) {
                $errors[] = '<div class="alert alert-danger"><h4>Seleccione Un tipo de Sexo</h4> </div>';
            }
            if (empty($email)) {
                $errors[] = '<div class="alert alert-danger"><h4>El campo Email es Obligatorio</h4> </div>';
            }
        }

        if (count($errors) == 0) {
            $token = generateToken();
            if ($tipo > 0) {
                if ($tipo <= 2) {
                    if (is_numeric($documento)) {
                        if (is_numeric($telefono)) {
                            $sqlF = "SELECT * FROM ficha WHERE id_ficha='$ficha'";
                            $fichaBD = $conectarBD->query($sqlF)->fetch_assoc()['id_ficha'];
                            if ($ficha == $fichaBD) {

                                if ($sexo > 0) {
                                    if ($sexo <= 2) {

                                        if (strlen(stristr($email, '@misena.edu.co')) > 0) {


                                            $sql = "INSERT into aprendiz ( id_aprendiz, tipoDocumento, nombres, apellidos, telefono, id_ficha, sexo, correo, token)values ( '$documento', '$tipo', '$nombres' ,'$apellidos' ,'$telefono', '$ficha','$sexo','$email','$token')";


                                            if ($conectarBD->query($sql) === TRUE) {

                                                $registrado = "<div class='container alert alert-success' align='center'><i class='icon-checkmark1' style='font-size: 80px;'> </i><h4 style='color: black;'class='font-weight-bold'>Aprendiz creado Correctamente</h4> 
   <a class='btn btn-primary' role='button' href='./registrarAprendiz.php'>Nuevo Aprendiz</a>
  <a class='btn btn-primary' role='button' href='./listarAprendices.php'>Volver</a>
</div>";
                                            } else {
    ?>
    <br>
    <div class="container">
        <?php
                                                die(require '../errorAlgoSM.php');
                                            }
                                                ?>
    </div>
    <?php

                                        } else {
                                            $errors[] = '<div class="alert alert-danger"><h4>El Correo no es misena</h4></div>';
                                        }
                                    } else {
                                        $errors[] = '<div class="alert alert-danger"><h4>El Tipo de sexo no es correcto </h4> </div>';
                                    }
                                } else {
                                    $errors[] = '<div class="alert alert-danger"><h4>El Tipo de sexo no es correcto o está vacío </h4> </div>';
                                }
                            } else {
                                $errors[] = '<div class="alert alert-danger"><h4 style="color:black;"><i class="icon-warning text-warning" style="font-size:80px;"></i><br>Seleccione una Ficha Existente</h4></div>';
                            }
                        } else {
                            $errors[] = '<div class="alert alert-danger"><h4>El campo Telefono no es Numerico </h4> </div>';
                        }
                    } else {
                        $errors[] = '<div class="alert alert-danger"><h4>El  Documento no es numerico </h4> </div>';
                    }
                } else {
                    $errors[] = '<div class="alert alert-danger"><h4>El tipo de Documento no es valido</h4> </div>';
                }
            } else {
                $errors[] = '<div class="alert alert-danger"><h4>El tipo de Documento ingresado no es valido</h4> </div>';
            }
        }
    }
        ?>
    <br>
    <div style="margin-left: 100px; margin-right: 100px;">

        <?php

            echo '<br>' . resultBlock($errors);
            ?>
    </div>
    <?php
        if (!isset($registrado)) {
        ?>
    <br> <br>
    <div align="center" class="container">

        <h2 class="font-weight-bold">REGISTRAR APRENDIZ</h2>
        <br>


        <form role="form" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" autocomplete="off">

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label class="font-weight-bold">Documento:</label>
                    <input type="number" class="form-control " value="<?php if (isset($documento)) {
                                                                                    echo $documento;
                                                                                } ?>" name="documento" maxlength="10"
                        required id="documento" class="">
                </div>

                <div class="form-group col-md-4">

                    <label class="font-weight-bold">Tipo Documento:</label>
                    <select class="form-control" required name="tipoDocumento" id="tipoDocumento">
                        <option value="0">Seleccione un Tipo</option>
                        <option value="1">Tarjeta de Identidad </option>
                        <option value="2">Cédula de Ciudadanía</option>
                    </select>

                </div>

                <div class="form-group col-md-4">
                    <label class="font-weight-bold">Nombres:</label>
                    <input type="text" class="form-control" value="<?php if (isset($nombres)) {
                                                                                echo $nombres;
                                                                            } ?>" name="nombres" required id="nombres">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label class="font-weight-bold">Apellidos:</label>
                    <input type="text" class="form-control" name="apellidos" value="<?php if (isset($apellidos)) {
                                                                                                echo $apellidos;
                                                                                            } ?>" required
                        id="apellidos">
                </div>


                <div class="form-group col-md-4">
                    <label class="font-weight-bold">Telefono:</label>
                    <input type="number" class="form-control " name="telefono" value="<?php if (isset($telefono)) {
                                                                                                    echo $telefono;
                                                                                                } ?>" required=""
                        id="telefono" class="campos">
                </div>
                <div class="form-group col-md-4">

                    <?php
                            $sql2 = "SELECT * FROM ficha ORDER BY id_ficha ASC";
                            if ($conectarBD->query($sql2)->num_rows > 0) {
                            ?>
                    <label class="font-weight-bold">Numero Ficha:</label>
                    <br>
                    <select type="text" class="form-control" name="id_ficha" id="id_ficha" required="" class="campos">
                        <option value="0">Selecciona uno </option>
                        <?php
                                    foreach ($conectarBD->query($sql2) as $ficha) {
                                    ?>
                        <option value="<?php echo $ficha['id_ficha']; ?>">
                            <?php echo $ficha['id_ficha']; ?>
                        </option>
                        <?php
                                    }
                                }
                                ?>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label class="font-weight-bold">Sexo:</label>
                    <select id="sexo" name="sexo" class="form-control ">
                        <option value="0">Seleccione...</option>
                        <option value="1">Masculino</option>
                        <option value="2">Femenino</option>
                    </select>
                </div>

                <div class="form-group col-md-4">
                    <label class="font-weight-bold">Correo Institucional:</label>
                    <input type="email" name="email" value="<?php if (isset($email)) {
                                                                        echo $email;
                                                                    } ?>" id="correo" placeholder="@misena.edu.co"
                        required class="form-control ">
                </div>
            </div>

            <div class="form-group">

                <button type="reset" title="Limpiar Registro" class="btn">
                    <i class="icon-loop2 text-secondary" style="font-size: 35px;"></i>
                </button>

                <button type="button" class="btn" title="Cancelar Registro"
                    onclick="window.location.href='./listarAprendices.php'">
                    <i class="icon-cancel text-danger" style="font-size: 50px;"> </i>
                </button>


                <button type="submit" class="btn font-weight-bold " title="Registrar Aprendiz">
                    <i class="icon-checkmark1 text-success" style="font-size: 50px;"></i>
                </button>
            </div>
        </form>
        <?php
        } else {
            echo $registrado;
        }
            ?>
    </div>

    <script type="text/javascript" src="../Assets/Jquery/jQuery_v3.4.1.js"></script>
    <script type="text/javascript" src="../Assets/bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../Assets/Js/vue.js"></script>
    <script type="text/javascript" src="../Assets/sweetalert2/sweetalert2.all.min.js"></script>

</body>

</html>