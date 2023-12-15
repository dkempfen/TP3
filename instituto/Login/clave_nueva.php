<?php
// Establecer el título de la página
$pageTitle = "Cambio Clave";

// Incluir los archivos necesarios
require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Includes/header.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Includes/load.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Includes/funcs.php';
$user_id = filter_input(INPUT_GET, 'User', FILTER_VALIDATE_INT);
$token = filter_input(INPUT_GET, 'token_password', FILTER_SANITIZE_STRING);

// Decodificar el token



?>

<body>

    <div class="container-clave">
        <div id="" style="margin-top:50px;" class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
            <div class="panel-recupero caudro-recupero">
                <div class="recupero-heading">
                    <div class="recupero-title">Cambiar Contraseña</div>
                    <div style="float:right; font-size: 80%; position: relative; top:-20px">
                        <a class="Iniciar-clave" href="index.php">Iniciar Sesión</a>
                    </div>
                </div>

                <!-- Cuerpo del panel con el formulario de cambio de clave -->
                <div style="padding-top:30px" class="panel-recupero">
                    <!-- Div para mostrar mensajes de alerta -->
                    <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>

                    <!-- Formulario de cambio de clave -->
                    <form id="form-cambio-clave" class="form-horizontal" role="form" action="/instituto/Login/guarda_pass.php"
                        method="POST" autocomplete="off">
                        <!-- Campos ocultos para user_id y token -->
                        <input type="text" name="user_id" value="<?php echo $user_id; ?>" />
                        <input type="text" name="token" value="<?php echo $token; ?>" />

                        <!-- Campo para la nueva contraseña -->
                        <div style="margin-bottom: 25px" class="input-group">
                            <label class="form-group" for="pass">Nueva Contraseña</label>
                            <input type="password" name="password" id="pass" class="form-clave" placeholder="Contraseña"
                                required>
                        </div>

                        <!-- ... Otros campos del formulario ... -->

                        <!-- Botón para enviar el formulario -->
                        <div style="margin-top:10px" class="form-group">
                            <div class="col-sm-12 controls">
                                <button id="btn-cambio-clave" type="submit"
                                    class="btn-enviar-recupero">Modificar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Incluir scripts JavaScript necesarios -->
    <script src="/instituto/js/jquery-3.3.1.min.js"></script>
    <script src="/instituto/js/plugins/login.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"
        integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous">
    </script>
</body>