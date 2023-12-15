<?php

$errors = array();

if (!empty($_POST)) {   
    //Permite que el formulario sea más seguro
    $apellido = isset($_POST['apellido']) ? $_POST['apellido'] : "";
    $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : "";
    $usuario = isset($_POST['usuario']) ? $_POST['usuario'] : "";
    $telefono = isset($_POST['telefono']) ? $_POST['telefono'] : "";
    $email = isset($_POST['email']) ? $_POST['email'] : "";
    $nacionalidad = isset($_POST['nacionalidad']) ? $_POST['nacionalidad'] : "";

    $fecha_nacimiento = isset($_POST['fecha_nacimiento']) ? $_POST['fecha_nacimiento'] : "";
    $fecha_nacimiento_formateada = date("Y-m-d", strtotime($fecha_nacimiento));

    $plan = isset($_POST['plan']) ? $_POST['plan'] : "";

    $activo = 0; //Cuando se registra el usuario siempre está desactivado
    
    //Validaciones
    if (empty($apellido) || empty($nombre) || empty($usuario) ||  empty($telefono) || empty($email) || empty($nacionalidad) || empty($fecha_nacimiento) 
        || empty($plan)) {
        $errors[] = "Por favor, complete todos los campos";
    }
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Dirección de correo inválida";
    }
    
    // Asumiendo que tienes funciones llamadas usuarioExiste y emailExiste que verifican si ya existen en la base de datos.
    if (usuarioExiste($usuario)) {
        $errors[] = "El DNI $usuario ya existe";
    }
    if (emailExiste($email)) {
        $errors[] = "El correo electrónico $email ya existe";
    }
    
    if (count($errors) == 0) {   
        $token = generateToken();
        $registro = registraUsuario($usuario, $nombre, $apellido, $email, $telefono, $nacionalidad, $fecha_nacimiento, $token, $plan);
    
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
            $cuerpo = "Estimado $nombre: <br /><br />Ha realizado la Pre-Inscripcion correctamente.Para continuar debe presentarse en administración con los siguiente:<br />
            • Fotocopia del título que certifique que está habilitado para el nivel en caso de no tenerlo presentarse con el certificado de título en trámite <br />
            • Fotocopia del DNI <br />
            • Dos fotos 4×4 <br />
            • Fotocopia del certificado/partida de Nacimiento (No es necesario que sea actualizada) <br />
            • Acreditar aptitud psicofísica";   
            
            if (enviarEmail($email, $nombre, $asunto, $cuerpo)) {
                $successMessage = "Para terminar el proceso de registro, siga las instrucciones que le hemos enviado a su dirección de correo electrónico: $email";
            } else {
                $errors[] = "Error al enviar Email";
            }
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