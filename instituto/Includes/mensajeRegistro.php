<?php
function processRegistration()
{
    $errors = array();

    if (!empty($_POST)) {
        $apellido = isset($_POST['apellido']) ? $_POST['apellido'] : "";
        $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : "";
        $usuario = isset($_POST['usuario']) ? $_POST['usuario'] : "";
        $telefono = isset($_POST['telefono']) ? $_POST['telefono'] : "";
        $email = isset($_POST['email']) ? $_POST['email'] : "";
        $nacionalidad = isset($_POST['nacionalidad']) ? $_POST['nacionalidad'] : "";

        $fecha_nacimiento = isset($_POST['fecha_nacimiento']) ? $_POST['fecha_nacimiento'] : "";
        $fecha_nacimiento_formateada = date("Y-m-d", strtotime($fecha_nacimiento));

        $plan = isset($_POST['plan']) ? $_POST['plan'] : "";

        $captcha = isset($_POST['g-recaptcha-response']) ? $_POST['g-recaptcha-response'] : "";

        $activo = 0; // Cuando se registra el usuario siempre está desactivado

        $secret = '6LciPeAnAAAAACPXsWjKVJx6RtQVLuUAuKVkhu2c';

        if (!$captcha) {
            $errors[] = "Por favor, verifica el captcha";
        }

        if (empty($apellido) || empty($nombre) || empty($usuario) ||  empty($telefono) || empty($email) || empty($nacionalidad) || empty($fecha_nacimiento) || empty($plan)) {
            $errors[] = "Por favor, complete todos los campos";
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Dirección de correo inválida";
        }

        if (usuarioExiste($usuario)) {
            $errors[] = "El DNI  $usuario ya existe";
        }
        if (emailExiste($email)) {
            $errors[] = "El correo electrónico $email ya existe";
        }

        if (count($errors) == 0) {
            $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$captcha");
            $arr = json_decode($response, true);

            if ($arr['success']) {
                $token = generateToken();
                $registro = registraUsuario($usuario, $nombre, $apellido, $email, $telefono, $nacionalidad, $fecha_nacimiento, $token, $plan);

                if ($registro > 0) {
                    $url = 'http://' . $_SERVER["SERVER_NAME"] . '/Includes/activar.php?id=' . $registro . '&val=' . $token;
                    $asunto = 'Activar Cuenta - Sistema de Usuarios';
                    $cuerpo = "Estimado $nombre: <br /><br />Para continuar con el proceso de registro, haga click en 
                        <a href='$url'>Activar Cuenta<a/>";
                    if (enviarEmail($email, $nombre, $asunto, $cuerpo)) {
                        $successMessage = "Para terminar el proceso de registro, siga las instrucciones que le hemos enviado a su dirección de correo electrónico: $email";
                    } else {
                        $errors[] = "Error al enviar Email";
                    }
                } else {
                    $url = 'http://' . $_SERVER["SERVER_NAME"] . '/Includes/activar.php?id=' . $registro . '&val=' . $token;
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

            if (!empty($errors)) {
                foreach ($errors as $error) {
                    echo $error . "<br>";
                }
            } elseif (isset($successMessage)) {
                echo $successMessage;
                echo "<br><a href='index.php'></a>";
            }
        }
    }
}
?>
