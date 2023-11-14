<?php


$pageTitle = "Cambio Clave"; // Define el título de la página

require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Includes/header.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Includes/load.php';

        $errors = array();

        if (!empty($_POST)) {
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Por favor, ingrese una dirección de correo electrónico válida.';
            }

            if (emailExiste($email)) {
                // Obtener datos del usuario mediante PDO
                $user_id = getValor('Id_Usuario', 'Email', $email);
                $nombre = getValor('User', 'Email', $email);
                $token = generaTokenPass($user_id);

                $url = 'http://' . $_SERVER["SERVER_NAME"] . '/instituto/Login/clave_nueva.php.php?Id_Usuario=' . $user_id . '&val=' . $token;

                $asunto = "Activación de Cuenta";
                $cuerpo = "Hola $nombre: <br /><br />Se ha solicitado un reinicio 
                    de contraseña. <br/><br/>Para restaurar la
                    Contraseña, visita la siguiente dirección: <a href='$url'> Cambiar
                    Contraseña</a><br /><br />Si no has sido tú, ignora este mensaje.";

                // Enviar el correo electrónico usando PDO
                if (enviarEmail($email, $nombre, $asunto, $cuerpo)) {
                    echo "Hemos enviado un correo electrónico a la dirección $email para restablecer tu contraseña. <br />";
                    echo "<a href='index.php' class='btn btn-success'>Iniciar Sesión</a>";
                    exit;
                } else {
                    $errors[] = "Error al enviar Email";
                }
            } else {
                $errors[] = "No existe el correo electrónico";
            }
        }

        // Manejo de errores (puedes ajustar según tus necesidades)
        if (!empty($errors)) {
            foreach ($errors as $error) {
                echo $error . "<br>";
            }
        }
?>

<body>

    <div class="container-clave">
        <div id="" style="margin-top:50px;" class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
            <div class="panel-recupero caudro-recupero">
                <div class="recupero-heading">
                    <div class="recupero-title">Recuperar Password</div>
                    <div style="float:right; font-size: 80%; position: relative; top:-20px"><a href="index.php">Iniciar
                            Sesión</a></div>
                </div>

                <div style="padding-top:30px" class="panel-recupero">

                    <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>

                    <form id="" class="form-horizontal" role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>"
                        method="POST" autocomplete="off">

                        <div style="margin-bottom: 25px" class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                            <input id="email" type="email" class="form-control" name="email" placeholder="email"
                                required="">
                        </div>

                        <div style="margin-top:10px" class="form-group">
                            <div class="col-sm-12 controls">
                                <button id="btn-login" type="submit" class="btn-enviar-recupero ">Enviar
                                </button>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12 control">
                                <div style="border-top: 1px solid#888; padding-top:15px; font-size:85%">
                                    No tiene acceso? <a href="registro.php">Inscribirse aquí</a>
                                </div>
                            </div>
                        </div>
                    </form>
                    <?php
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

</body>

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

</html>