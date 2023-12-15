<?php
// Título de la página
$pageTitle = "Cambio Clave";

// Incluir archivos necesarios
require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Includes/header.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Includes/load.php';

// Array para almacenar errores
$errors = array();

// Verificar si se envió el formulario (POST no está vacío)
if (!empty($_POST)) {
    // Filtrar y obtener el correo electrónico enviado
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

    // Validar la dirección de correo electrónico
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Por favor, ingrese una dirección de correo electrónico válida.';
    }

    // Verificar si el correo electrónico existe en la base de datos
    if (emailExiste($email)) {
        $user_id = getValor('User', 'Email', $email);
        $nombre = getValor('Nombre', 'Email', $email);
        $token = generaTokenPass($user_id);

        // Construir la URL para el cambio de contraseña
        $url = '';
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
        $url = $protocol . '://' . $_SERVER['HTTP_HOST'] . '/instituto/Login/clave_nueva.php?User=' . $user_id . '&token_password=' . $token;

        // Construir el asunto y cuerpo del correo electrónico
        $asunto = "Sistema de Usuarios";
        $cuerpo = "Hola $nombre: <br /><br />Se ha solicitado un reinicio de contraseña. <br/><br/>
                    Para restaurar la Contraseña, visita la siguiente dirección: 
                    <a href='$url'> Cambiar Contraseña</a><br /><br />Si no has sido tú, ignora este mensaje.";

        // Enviar el correo electrónico usando PDO
        if (enviarEmail($email, $nombre, $asunto, $cuerpo)) {
            echo "<div class='alert alert-success text-center' role='alert' style='padding: 20px; margin-top: 20px; border: 2px solid #28a745; color: #000; background-color: #fff;'>";
            echo "<p class='mb-3'>Hemos enviado un correo electrónico a la dirección $email para restablecer tu contraseña.</p>";
            echo "<a href='index.php' class='btn btn-success'>Iniciar Sesión</a>";
            echo "</div>";

            exit;
        } else {
            $errors[] = "Error al enviar Email";
        }
    } else {
        $errors[] = "No existe el correo electrónico";
    }
}

?>

<!-- Cuerpo HTML de la página -->

<body>
    <div class="container-clave">
        <!-- Div principal del formulario -->
        <div id="" style="margin-top:50px;" class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
            <div class="panel-recupero caudro-recupero">
                <!-- Encabezado del panel -->
                <div class="recupero-heading">
                    <div style=" font-size: 70%; position: relative;"><a href="index.php">Iniciar Sesión</a></div>
                </div>

                <!-- Cuerpo del panel con el formulario de recuperación de contraseña -->
                <div style="padding-top:20px" class="panel-recupero">
                    <!-- Div para mostrar mensajes de alerta -->
                    <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>

                    <!-- Formulario de recuperación de contraseña -->
                    <form id="" class="form-horizontal" role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>"
                        method="POST" autocomplete="off">

                        <!-- Campo para ingresar el correo electrónico -->
                        <div style="margin-bottom: 25px" class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                            <input id="email" type="email" class="form-control" name="email" placeholder="email"
                                required="">
                        </div>

                        <!-- Botón para enviar el formulario -->
                        <div style="margin-top:10px" class="form-group">
                            <div class="col-sm-12 controls">
                                <button id="btn-login" type="submit" class="btn-enviar-recupero ">Enviar</button>
                            </div>
                        </div>

                        <!-- Enlace para registrarse si no tiene acceso -->
                        <div class="form-group">
                            <div class="col-md-12 control">
                                <div style="border-top: 1px solid#8888 1px; padding-top:15px; font-size:85%">
                                    No tiene acceso? <a href="registro.php">Inscribirse aquí</a>
                                </div>
                            </div>
                        </div>
                    </form>

                    <?php
                    // Mostrar mensajes de error si hay alguno
                    if (!empty($errors)) {
                        echo "<div class='alert alert-danger'>";
                        foreach ($errors as $error) {
                            echo $error . "<br>";
                        }
                        echo "</div>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Incluir scripts JavaScript necesarios -->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/plugins/login.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"
        integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous">
    </script>
</body>

<!-- Cierre de la etiqueta HTML -->

</html>