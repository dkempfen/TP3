<?php
	use PHPMailer\PHPMailer\PHPMailer;

	require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/PHPMailer/src/PHPMailer.php';

    
	use PHPMailer\PHPMailer\SMTP;
	
  //Valida si los  campos son nulo
	function isNull($apellido,$nombre, $usuario, $email,$nacionalidad,$telefono,$fecha_nacimiento,$plan){
		if(strlen(trim($apellido)) < 1 || strlen(trim($nombre)) < 1 || strlen(trim($usuario)) < 1  || strlen(trim($email))
		|| strlen(trim($nacionalidad)) < 1 || strlen(trim($telefono)) < 1|| strlen(trim($fecha_nacimiento)) < 1 || strlen(trim($plan)) < 1)
		{
			return true;
			} else {
			return false;
		}		
	}
	//Valida el correo 
	function isEmail($email)
	{
		if (filter_var($email, FILTER_VALIDATE_EMAIL)){
			return true;
			} else {
			return false;
		}
	}

	//Limites para los elementos
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
	
	function usuarioExiste($usuario)
	{
		global $pdo;
		
		$stmt = $pdo->prepare("SELECT DNI FROM Persona WHERE DNI = :DNI LIMIT 1");
		$stmt->bindParam(':DNI', $usuario, PDO::PARAM_STR);
		$stmt->execute();
		
		if ($stmt->rowCount() > 0) {
			return true;
		} else {
			return false;
		}
	}

	function emailExiste($email)
	{
		global $pdo;
		
		$stmt = $pdo->prepare("SELECT DNI FROM Persona p INNER JOIN Usuario u
		ON u.fk_DNI = p.DNI 
		WHERE Email = :email LIMIT 1");
		$stmt->bindParam(':email', $email, PDO::PARAM_STR);
		$stmt->execute();
		
		if ($stmt->rowCount() > 0) {
			return true;
		} else {
			return false;
		}
	}
		
	
	//recibe los errores
	function resultBlock($errors){ 
		if(count($errors) > 0)
		
		
		{
			echo "<div id='error' class='alert alert-danger' role='alert'>
			<a href='#' onclick=\"showHide('error');\">[X]</a>
			<ul>";
			foreach($errors as $error)//muestra todos los erroress
			{
				echo "<li>".$error."</li>";
			}
			echo "</ul>";
			echo "</div>";
		}
	}
	function registraUsuario($usuario, $nombre, $apellido, $email, $telefono, $nacionalidad, $fecha_nacimiento, $token, $plan) {
		global $pdo;
	
		// Aquí insertamos los datos en la tabla 'Persona'
		$stmtPersona = $pdo->prepare("INSERT INTO Persona (DNI, Apellido, Nombre, Email, Telefono, Nacionalidad, Fechanacimiento, token, Inscripto)
			VALUES (:usuario, :apellido, :nombre, :email, :telefono, :nacionalidad, :fecha_nacimiento, :token, 1 )");
		$stmtPersona->bindParam(':usuario', $usuario, PDO::PARAM_STR);
		$stmtPersona->bindParam(':apellido', $apellido, PDO::PARAM_STR);
		$stmtPersona->bindParam(':nombre', $nombre, PDO::PARAM_STR);
		$stmtPersona->bindParam(':email', $email, PDO::PARAM_STR);
		$stmtPersona->bindParam(':telefono', $telefono, PDO::PARAM_STR);
		$stmtPersona->bindParam(':nacionalidad', $nacionalidad, PDO::PARAM_STR);
		$stmtPersona->bindParam(':fecha_nacimiento', $fecha_nacimiento, PDO::PARAM_STR);
		$stmtPersona->bindParam(':token', $token, PDO::PARAM_STR);
		
	
		if ($stmtPersona->execute()) {
			$idPersona = $pdo->lastInsertId();
	
			// Aquí insertamos los datos en la tabla 'Usuario'
			$legajo = $usuario; // Asigna el valor del DNI al legajo
			$password = password_hash('tu_contrasena_generica', PASSWORD_DEFAULT);
			$estadoUsuario = 2; // Reemplaza con el estado deseado (por ejemplo, activo)
			$rol = 1; // Reemplaza con el rol deseado
			$documento = $usuario;
	
			$stmtUsuario = $pdo->prepare("INSERT INTO Usuario (Legajo, User, Password, fk_Plan, fk_Estado_Usuario, fk_Rol, fk_DNI)
				VALUES (:legajo, :usuario, :password, :plan, :estado, :rol, :dni)");
	
			$stmtUsuario->bindParam(':legajo', $legajo);
			$stmtUsuario->bindParam(':usuario', $usuario);
			$stmtUsuario->bindParam(':password', $password);
			$stmtUsuario->bindParam(':plan', $plan);
			$stmtUsuario->bindParam(':estado', $estadoUsuario);
			$stmtUsuario->bindParam(':rol', $rol);
			$stmtUsuario->bindParam(':dni', $documento);
	
			if ($stmtUsuario->execute()) {
				return $idPersona; // Devuelve el ID de la persona registrada
			} else {
				echo "Error al insertar datos en la tabla 'Usuario': " . implode(", ", $stmtUsuario->errorInfo());
				return 0;
			}
		} else {
			echo "Error al insertar datos en la tabla 'Persona': " . implode(", ", $stmtPersona->errorInfo());
			return 0;
		}
	}

	function enviarEmail($email, $nombre, $asunto, $cuerpo){
	
		require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/PHPMailer/src/Exception.php';
		require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/PHPMailer/src/PHPMailer.php';

		require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/PHPMailer/src/SMTP.php';

		require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/PHPMailer/src/PHPMailerAutoload.php';

		$mail= new PHPMailer();

		 $mail->isSMTP();
		 $mail->SMTPDebug = 2;// Desactiva la depuración o el registro
         $mail->SMTPAuth = true;
         $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
         $mail->Host = 'smtp.gmail.com';
         $mail->Port = 465;
     
      

         $mail->Username = 'd.kempfen@gmail.com'; //Correo de donde enviaremos los correos
         $mail->Password = 'vioaqiubxyagfpny'; // Password de la cuenta de envío
        
         $mail->setFrom('d.kempfen@gmail.com', 'Sistema de Usuarios');
		 $mail->addAddress($email,$nombre);
        
         $mail->Subject = $asunto;
         $mail->Body    = $cuerpo;
	     $mail->isHTML(true);
        
        if($mail->send()) 
           return true;
		   else
		   return false;
        
	}
	
	function activarUsuario($id) {
		global $pdo;
	
		$stmt = $pdo->prepare("UPDATE Persona SET Inscripto = 1 WHERE DNI = :id");
		$stmt->bindParam(':id', $id, PDO::PARAM_STR);
		$result = $stmt->execute();
	
		return $result;
	}
	
	function isActivo($usuario) {
		global $pdo;
	
		$stmt = $pdo->prepare("SELECT Inscripto FROM Persona WHERE DNI = :usuario OR Email = :email LIMIT 1");
		$stmt->bindParam(':usuario', $usuario, PDO::PARAM_STR);
		$stmt->bindParam(':email', $usuario, PDO::PARAM_STR);
		$stmt->execute();
		$activacion = $stmt->fetchColumn();
	
		return $activacion == 1;
	}

	function generateToken()
	{
		$gen = md5(uniqid(mt_rand(), false));	
		return $gen;
	}//Genera un token unico para cada usuario


	
	function validaIdToken($id, $token){
		global $pdo;
	
		$stmt = $pdo->prepare("SELECT Inscripto FROM Persona WHERE DNI = :id AND token = :token LIMIT 1");
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		$stmt->bindParam(':token', $token, PDO::PARAM_STR);
		$stmt->execute();
	
		if ($stmt->rowCount() > 0) {
			$row = $stmt->fetch();
			$activacion = $row['Inscripto'];
	
			if ($activacion == 1) {
				$msg = "La cuenta ya se activó anteriormente.";
			} else {
				if (activarUsuario($id)) {
					$msg = 'Cuenta Activada.';
				} else {
					$msg = 'Error al Activar Cuenta';
				}
			}
		} else {
			$msg = 'No existe el registro para activar.';
		}
	
		return $msg;
	}
	
////Funciones de recupero clave///

function generaTokenPass($user_id)
{
    global $pdo;

    $token = generateToken();

    try {
        $stmt = $pdo->prepare("UPDATE Usuario SET token_password=:token, password_request=1 WHERE Id_Usuario = :user_id");
        $stmt->bindParam(':token', $token, PDO::PARAM_STR);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        return $token;
    } catch (PDOException $e) {
        // Manejo de errores de PDO
        return null;
    }
}

function getValor($campo, $campoWhere, $valor)
{
    global $pdo;

    try {
        $stmt = $pdo->prepare("SELECT $campo FROM Usuario u INNER JOIN Persona p
		ON u.fk_DNI = p.DNI 
		WHERE $campoWhere = :valor LIMIT 1");
        $stmt->bindParam(':valor', $valor, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            return $result[$campo];
        } else {
            return null;
        }
    } catch (PDOException $e) {
        // Manejo de errores de PDO
        return null;
    }
}

function getPasswordRequest($id)
{
    global $pdo;

    try {
        $stmt = $pdo->prepare("SELECT password_request FROM Usuario WHERE Id_Usuario = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result && $result['password_request'] == 1) {
            return true;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        // Manejo de errores de PDO
        return false;
    }
}

function verificaTokenPass($user_id, $token)
{
    global $pdo;

    try {
        $stmt = $pdo->prepare("SELECT fk_Estado_Usuario FROM usuarios WHERE Id_Usuario = :user_id AND token_password = :token AND password_request = 1 LIMIT 1");
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':token', $token, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result && $result['fk_Estado_Usuario'] == 1) {
            return true;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        // Manejo de errores de PDO
        return false;
    }
}

function cambiaPassword($password, $user_id, $token)
{
    global $pdo;

    try {
        $stmt = $pdo->prepare("UPDATE Usuario SET Password = :password, token_password='', password_request=0 WHERE Id_Usuario = :user_id AND token_password = :token");
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':token', $token, PDO::PARAM_STR);

        return $stmt->execute();
    } catch (PDOException $e) {
        // Manejo de errores de PDO
        return false;
    }
}



//Valida que las contraseñas sean iguales
function validaPassword($var1, $var2)
{
	if (strcmp($var1, $var2) !== 0){
		return false;
		} else {
		return true;
	}
}



function hashPassword($password) 
	{
		$hash = password_hash($password, PASSWORD_DEFAULT);
		return $hash;
	}