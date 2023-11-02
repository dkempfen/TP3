<?php
	use PHPMailer\PHPMailer\PHPMailer;
    
	use PHPMailer\PHPMailer\SMTP;
	
  //Valida si los  campos son nulo
	function isNull($apellido,$nombre, $usuario, $email,$nacionalidad,$telefono,$fecha_nacimiento){
		if(strlen(trim($apellido)) < 1 || strlen(trim($nombre)) < 1 || strlen(trim($usuario)) < 1  || strlen(trim($email))
		|| strlen(trim($nacionalidad)) < 1 || strlen(trim($telefono)) < 1|| strlen(trim($fecha_nacimiento)) < 1)
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
		
		$stmt = $pdo->prepare("SELECT DNI FROM Persona WHERE Email = :email LIMIT 1");
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
	function registraUsuario($usuario, $nombre, $apellido, $email, $telefono,$nacionalidad,$fecha_nacimiento,$token,$activo) {
		global $pdo;
	
		$stmt = $pdo->prepare("INSERT INTO Persona (DNI,Apellido, Nombre, Email, Telefono,Nacionalidad,Fechanacimiento,token,Inscripto)
		 VALUES (:usuario,:apellido, :nombre, :email, :telefono, :nacionalidad,:fecha_nacimiento,:token,:activo)");
		$stmt->bindParam(':usuario', $usuario, PDO::PARAM_STR);
		$stmt->bindParam(':apellido', $apellido, PDO::PARAM_STR);
		$stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
		$stmt->bindParam(':email', $email, PDO::PARAM_STR); 
		$stmt->bindParam(':telefono', $telefono, PDO::PARAM_STR); 
		$stmt->bindParam(':nacionalidad', $nacionalidad, PDO::PARAM_STR); 
		$stmt->bindParam(':fecha_nacimiento', $fecha_nacimiento, PDO::PARAM_STR); 
		$stmt->bindParam(':token', $token, PDO::PARAM_STR); 
		$stmt->bindParam(':activo', $activo, PDO::PARAM_INT);
	
		if ($stmt->execute()) {
			return $pdo->lastInsertId();
		} else {
			// Agrega un mensaje de error para la depuración
			echo "Error en la ejecución de la consulta: " . implode(", ", $stmt->errorInfo());
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
     
      

         $mail->Username = 'buenviajelujan@gmail.com'; //Correo de donde enviaremos los correos
         $mail->Password = 'kzthntenhbubpzgp'; // Password de la cuenta de envío
        
         $mail->setFrom('buenviajelujan@gmail.com', 'Sistema de Usuarios');
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
	