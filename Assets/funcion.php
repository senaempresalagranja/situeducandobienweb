<?php

	

	function isNull($nombre, $user, $pass, $pass_con, $email){

		if(strlen(trim($nombre)) < 1 || strlen(trim($user)) < 1 || strlen(trim($pass)) < 1 || strlen(trim($pass_con)) < 1 || strlen(trim($email)) < 1)

		{

			return true;

			} else {

			return false;

		}		

	}



function validarEntero($codigoUnidad){

   if(filter_var($codigoUnidad, FILTER_VALIDATE_INT) === FALSE){

      return false;

   }else{

      return true;

   }

}

function validarEnteroC($cantidadAprendices){

   if(filter_var($cantidadAprendices, FILTER_VALIDATE_INT) === FALSE){

      return false;

   }else{

      return true;

   }

}

function validarEnteroA($cantidad_aprendices){

   if(filter_var($cantidad_aprendices, FILTER_VALIDATE_INT) === FALSE){

      return false;

   }else{

      return true;

   }

}



	function isNullF( $quienFirma,  $cargoQF ){

		if(strlen(trim($cargoQF)) < 1 ||  strlen(trim($quienFirma)) < 1)

		{

			return true;

			} else {

			return false;

		}		

	}



function isNullFI( $quienFirma,  $cargoQF, $documento ){

		if(strlen(trim($cargoQF)) < 1 ||  strlen(trim($quienFirma)) < 1||  strlen(trim($documento)) < 1)

		{

			return true;

			} else {

			return false;

		}		

	}



	function isNullAR($id_area, $nombreArea){

	if(strlen(trim($id_area)) < 1 || strlen(trim($nombreArea)) < 1)

		{

			return true;

			} else {

			return false;

		}		

	}





	function isNullA($tipo, $documento, $nombres, $apellidos, $telefono, $ficha, $sexo, $email){

		if(strlen(trim($tipo)) < 1 || strlen(trim($documento)) < 1 || strlen(trim($nombres)) < 1 || strlen(trim($apellidos)) < 1 || strlen(trim($telefono)) < 1 || strlen(trim($ficha)) < 1 || strlen(trim($sexo)) < 1 || strlen(trim($email)) < 1)

		{

			return true;

			} else {

			return false;

		}		

	}

	function isNullAP($tipo,  $nombres, $apellidos, $telefono, $ficha, $sexo, $email){

		if(strlen(trim($tipo)) < 1 || strlen(trim($nombres)) < 1 || strlen(trim($apellidos)) < 1 || strlen(trim($telefono)) < 1 || strlen(trim($ficha)) < 1 || strlen(trim($sexo)) < 1 || strlen(trim($email)) < 1)

		{

			return true;

			} else {

			return false;

		}		

	}







	function isNullP($id_programaF, $nombreP, $id_area){

		if(strlen(trim($id_programaF)) < 1 || strlen(trim($nombreP)) < 1 || strlen(trim($id_area)) < 1 ){

			return true;

			} else {

			return false;

		}		

	}







	function isNullTE($area, $codigoUnidad, $fechaTurnoEspecial, $horaInicio, $horaFin){

	if(strlen(trim($area)) < 1 || strlen(trim($codigoUnidad)) < 1 || strlen(trim($fechaTurnoEspecial)) < 1 || strlen(trim($horaInicio)) < 1 || strlen(trim($horaFin)) < 1  )

		{

			return true;

			} else {

			return false;

		}		

	}



	 

	function isNullTR($id_area, $codigoUnidad,$tipoTurno, $fechaTurno,$horaInicio, $horaFin){

		if(strlen(trim($id_area)) < 1 || strlen(trim($codigoUnidad)) < 1|| strlen(trim($tipoTurno)) < 1 || strlen(trim($fechaTurno)) < 1 ||strlen(trim($horaInicio)) < 1 || strlen(trim($horaFin)) < 1)

		{

			

			return true;



			} else {

				

			return false;

		}		

	}



	

	function isEmail($email)

	{

		if (filter_var($email, FILTER_VALIDATE_EMAIL)){

			return true;

			} else {

			return false;

		}

	}

	

	function validaPassword($var1, $var2)

	{

		if (strcmp($var1, $var2) !== 0){

			return false;

			} else {

			return true;

		}

	}

	

	function minMax($min, $max, $valor){

		if(strlen(trim($valor)) < $min)

		{

			return true;

		}

		else if(strlen(trim($valor)) > $max)

		{

			return true;

		}

		else

		{

			return false;

		}

	}

	

	function usuarioExiste($user)

	{

		global $conectarBD;

		

		$stmt = $conectarBD->prepare("SELECT id FROM usuarios WHERE usuario = ? LIMIT 1");

		$stmt->bind_param("s", $user);

		$stmt->execute();

		$stmt->store_result();

		$num = $stmt->num_rows;

		$stmt->close();

		

		if ($num > 0){

			return true;

			} else {

			return false;

		}

	}

	

	function emailExiste($email)

	{

		global $conectarBD;

		

		$stmt = $conectarBD->prepare("SELECT id FROM usuarios WHERE email = ? LIMIT 1");

		$stmt->bind_param("s", $email);

		$stmt->execute();

		$stmt->store_result();

		$num = $stmt->num_rows;

		$stmt->close();

		

		if ($num > 0){

			return true;

			} else {

			return false;	

		}

	}

	

	function generateToken()

	{

		$gen = md5(uniqid(mt_rand(), false));	

		return $gen;

	}

	

	function hashPassword($password) 

	{

		$hash = password_hash($password, PASSWORD_DEFAULT);

		return $hash;

	}

	

	function resultBlock($errors){

		if(count($errors) > 0)

		{

			echo "<div align='center' style='margin-left: -30px; margin-rigth: 20px' id='error'  role='alert'>

			

			<ul>";

			foreach($errors as $error)

			{

				echo "<li>".$error."</li>";

			}

			echo "</ul>";

			echo "</div>";

		}

	}

	

	function registraUsuario($nombre , $user,  $password, $tipo, $email, $token, $estado){

		

		global $conectarBD;

		

		$stmt = $conectarBD->prepare("INSERT INTO usuarios (nombre, usuario, clave, tipo, email, token, estado  ) VALUES(?,?,?,?,?,?,?)");

		$stmt->bind_param('ssssssi', $nombre , $user,  $password, $tipoUser, $email, $token, $estado);

		

		if ($stmt->execute()){

			return $conectarBD->insert_id;

			} else {

			return 0;	

		}		

	}

	function actualizarUsuario($nombre , $user,  $password, $tipo, $email, $token, $id){

		

		global $conectarBD;

		

		$stmt = $conectarBD->prepare("UPDATE usuarios (nombre, usuario, clave, tipo, email, token ) VALUES(?,?,?,?,?,?)WHERE id = $id");

		$stmt->bind_param('ssssss', $nombre , $user,  $password, $tipoUser, $email, $token );

		

		if ($stmt->execute()){

			return $conectarBD->insert_id;

			} else {

			return 0;	

		}		

	}

	
	function enviarEmail($email, $nombre, $asunto, $cuerpo){
		
			
		require 'PHPMailer/PHPMailerAutoload.php';
		

		require 'PHPMailer/src/Exception.php';
		require 'PHPMailer/src/PHPMailer.php';
		require 'PHPMailer/src/SMTP.php';
		//require 'PHPMAILER/class.phpmailer.php';
		//require 'PHPMAILER/class.smtp.php';
		//require_once('../Assets/PHPMAILER/PHPMailerAutoload.php');
		//require_once('../Assets/PHPMAILER/class.phpmailer.php');
		//require_once('../Assets/PHPMAILER/class.smtp.php');
		
		$mail = new PHPMailer();
		$mail->isSMTP();
		$mail->SMTPAuth = true;
		$mail->SMTPSecure = 'ssl';
		$mail->Host = 'situ.educandobien.com';
		$mail->Port = '465';
		$mail->CharSet = 'UTF-8';
		$mail->Username = 'situadsi@situ.educandobien.com';
		$mail->Password = 'SituLoQuieres001';
		
		$mail->setFrom('situadsi@situ.educandobien.com', 'Sistema SITU');
		$mail->addAddress($email, $nombre);
		
		$mail->Subject = $asunto;
		$mail->Body    = $cuerpo;
		$mail->IsHTML(true);
		
		if($mail->send())
		return true;
		else
		return false;
	}
	

	

	function validaIdToken($id, $token){

		global $conectarBD;

		

		$stmt = $conectarBD->prepare("SELECT activacion FROM usuarios WHERE id = ? AND token = ? LIMIT 1");

		$stmt->bind_param("is", $id, $token);

		$stmt->execute();

		$stmt->store_result();

		$rows = $stmt->num_rows;

		

		if($rows > 0) {

			$stmt->bind_result($activacion);

			$stmt->fetch();

			

			if($activacion == 1){

				$msg = "La cuenta ya se activo anteriormente.";

				} else {

				if(activarUsuario($id)){

					$msg = 'Cuenta activada.';

					} else {

					$msg = 'Error al Activar Cuenta';

				}

			}

			} else {

			$msg = 'No existe el registro para activar.';

		}

		return $msg;

	}

	

	function activarUsuario($id)

	{

		global $conectarBD;

		

		$stmt = $conectarBD->prepare("UPDATE usuarios SET activacion=1 WHERE id = ?");

		$stmt->bind_param('s', $id);

		$result = $stmt->execute();

		$stmt->close();

		return $result;

	}

	

	function isNullLogin($usuario, $password){

		if(strlen(trim($usuario)) < 1 || strlen(trim($password)) < 1)

		{

			return true;

		}

		else

		{

			return false;

		}		

	}

	

	function login($usuario, $password)

	{

		global $conectarBD;

		

		$stmt = $conectarBD->prepare("SELECT id, id_tipo, password FROM usuarios WHERE usuario = ? || correo = ? LIMIT 1");

		$stmt->bind_param("ss", $usuario, $usuario);

		$stmt->execute();

		$stmt->store_result();

		$rows = $stmt->num_rows;

		

		if($rows > 0) {

			

			if(isActivo($usuario)){

				

				$stmt->bind_result($id, $id_tipo, $passwd);

				$stmt->fetch();

				

				$validaPassw = password_verify($password, $passwd);

				

				if($validaPassw){

					

					lastSession($id);

					$_SESSION['id_usuario'] = $id;

					$_SESSION['tipo_usuario'] = $id_tipo;

					

					header("location: welcome.php");

					} else {

					

					$errors = "La contrase&ntilde;a es incorrecta";

				}

				} else {

				$errors = 'El usuario no esta activo';

			}

			} else {

			$errors = "El nombre de usuario o correo electr&oacute;nico no existe";

		}

		return $errors;

	}

	

	function lastSession($id)

	{

		global $mysqli;

		

		$stmt = $mysqli->prepare("UPDATE usuarios SET last_session=NOW(), token_password='', password_request=1 WHERE id = ?");

		$stmt->bind_param('s', $id);

		$stmt->execute();

		$stmt->close();

	}

	

	function isActivo($usuario)

	{

		global $mysqli;

		

		$stmt = $mysqli->prepare("SELECT activacion FROM usuarios WHERE usuario = ? || correo = ? LIMIT 1");

		$stmt->bind_param('ss', $usuario, $usuario);

		$stmt->execute();

		$stmt->bind_result($activacion);

		$stmt->fetch();

		

		if ($activacion == 1)

		{

			return true;

		}

		else

		{

			return false;	

		}

	}	

	

	function generaTokenPass($email)

	{

		global $conectarBD;

		

		$token = generateToken();

		

		$stmt = $conectarBD->prepare("UPDATE usuarios SET token=?, cambioContrasena=1 WHERE email = ?");

		$stmt->conectarBD('ss', $token, $email);

		$stmt->execute();

		$stmt->close();

		

		return $token;

	}

	

	function getValor($campo, $campoWhere, $valor)

	{

		global $conectarBD;

		

		$stmt = $conectarBD->prepare("SELECT $campo FROM usuarios WHERE $campoWhere = ? LIMIT 1");

		$stmt->bind_param('s', $valor);

		$stmt->execute();

		$stmt->store_result();

		$num = $stmt->num_rows;

		

		if ($num > 0)

		{

			$stmt->bind_result($_campo);

			$stmt->fetch();

			return $_campo;

		}

		else

		{

			return null;	

		}

	}

	

	function getPasswordRequest($id)

	{

		global $mysqli;

		

		$stmt = $mysqli->prepare("SELECT password_request FROM usuarios WHERE id = ?");

		$stmt->bind_param('i', $id);

		$stmt->execute();

		$stmt->bind_result($_id);

		$stmt->fetch();

		

		if ($_id == 1)

		{

			return true;

		}

		else

		{

			return null;	

		}

	}

	

	function verificaTokenPass($user_id, $token){

		

		global $mysqli;

		

		$stmt = $mysqli->prepare("SELECT activacion FROM usuarios WHERE id = ? AND token_password = ? AND password_request = 1 LIMIT 1");

		$stmt->bind_param('is', $user_id, $token);

		$stmt->execute();

		$stmt->store_result();

		$num = $stmt->num_rows;

		

		if ($num > 0)

		{

			$stmt->bind_result($activacion);

			$stmt->fetch();

			if($activacion == 1)

			{

				return true;

			}

			else 

			{

				return false;

			}

		}

		else

		{

			return false;	

		}

	}

	

	function cambiaPassword($password, $user_id, $token){

		

		global $mysqli;

		

		$stmt = $mysqli->prepare("UPDATE usuarios SET password = ?, token_password='', password_request=0 WHERE id = ? AND token_password = ?");

		$stmt->bind_param('sis', $password, $user_id, $token);

		

		if($stmt->execute()){

			return true;

			} else {

			return false;		

		}

	}



function validarFecha($fecha){

 	$valores = explode('-', $fecha);

 	if(count($valores) == 3 && checkdate($valores[1], $valores[2], $valores[0])){

 		return true;

     } else {

      return false;

 }



}



function validarHora($hora)

{

    $pattern="/^([0-1][0-9]|[2][0-3])[\:]([0-5][0-9])$/";

    if(preg_match($pattern,$hora)){

    	return true;

    }else{

    	return false;

    }



}





?>

