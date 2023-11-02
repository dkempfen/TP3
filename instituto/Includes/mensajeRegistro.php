<?php
include '../Includes/load.php';
$errors = array();

if (!empty($_POST)) 
 {   //Permite que el formulario sea mas seguro
    $apellido = $_POST['apellido'];
    $nombre = $_POST['nombre'];
    $usuario = $_POST['usuario'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];
    $nacionalidad = $_POST['nacionalidad'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $fecha_nacimiento_formateada = date("Y-m-d", strtotime($fecha_nacimiento));

    $captcha = $_POST['g-recaptcha-response'];

    


    $activo = 0; //Cuando se registra el usuario siempre está desactivado
    
    
    //Contraseña para el captcha
    $secret = '6LciPeAnAAAAACPXsWjKVJx6RtQVLuUAuKVkhu2c';
    
    //Validaciones
    if (!$captcha) {
        $errors[] = "Por favor, verifica el captcha";
    }
    
    if (empty($apellido) || empty($nombre) || empty($usuario) ||  empty($telefono) || empty($email) || empty($nacionalidad) || empty($fecha_nacimiento)  ) {
        $errors[] = "Por favor, complete todos los campos";
    }
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Dirección de correo inválida";
    }
    
   
    
    // Asumiendo que tienes funciones llamadas usuarioExiste y emailExiste que verifican si ya existen en la base de datos.
    if (usuarioExiste($usuario)) {
        $errors[] = "El DNI  $usuario ya existe";
    }
    if (emailExiste($email)) {
        $errors[] = "El correo electrónico $email ya existe";
    }
    
 
    if (count($errors) == 0) 
    {   
        $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$captcha");
        $arr = json_decode($response, true);
    
        if ($arr['success']) {
            $token = generateToken();
            $registro = registraUsuario($usuario, $nombre, $apellido, $email, $telefono, $nacionalidad, $fecha_nacimiento, $token, $activo);
        
            if ($registro > 0) {
                // Registro exitoso
                $url = 'http://'. $_SERVER["SERVER_NAME"].
                '/Includes/activar.php?id='.$registro.'&val='.$token;
                $asunto = 'Activar Cuenta - Sistema de Usuarios';
                $cuerpo = "Estimado $nombre: <br /><br />Para continuar con el proceso de registro, haga click en 
                <a href='$url'>Activar Cuenta<a/>";        
                if (enviarEmail($email, $nombre, $asunto, $cuerpo)) {
                    // Mensaje de éxito
                    $successMessage = "Para terminar el proceso de registro, siga las instrucciones que le hemos enviado a su dirección de correo electrónico: $email";
                } else {
                    $errors[] = "Error al enviar Email";
                }
            } else {
                $url = 'http://'. $_SERVER["SERVER_NAME"].
                '/Includes/activar.php?id='.$registro.'&val='.$token;
                $asunto = 'Activar Cuenta - Sistema de Usuarios';
                $cuerpo = "Estimado $nombre: <br /><br />Para continuar con el proceso de registro, haga click en 
                <a href='$url'>Activar Cuenta<a/>";   

                if (enviarEmail($email, $nombre, $asunto, $cuerpo)) {
                    $successMessage = "Para terminar el proceso de registro, siga las instrucciones que le hemos enviado a su dirección de correo electrónico: $email";
                } else {
                    $errors[] = "Error al enviar Email";
                }
            }
        } else {
            $errors[] = 'Error al comprobar Captcha';
        }
        
        // Luego, fuera del bloque if/else
        if (!empty($errors)) {
            // Si hay errores, muestra los mensajes de error.
            foreach ($errors as $error) {
                echo $error . "<br>";
            }
        } elseif (isset($successMessage)) {
            // Si no hay errores y hay un mensaje de éxito, muéstralo.
            echo $successMessage;
            echo "<br><a href='index.php'></a>";
        }
    }
    
    // Mostrar errores si los hay
   
 }
?>