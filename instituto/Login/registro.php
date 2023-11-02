<?php
$pageTitle = "Registro Instituto"; // Define el título de la página
include '../Includes/header.php';
include '../Includes/load.php';



?>

<header class="style-3">
    <div class="top-bar"></div>
    <div class="page-title">
        <div class="container clearfix">
            <div class="sixteen columns">
                <h1>Formulario de inscripción</h1>
            </div>
        </div>
    </div>
</header>
<div id="registroalta" class="registroalta">
    <div class="container main-content clearfix">
        <div class="team">
            <div id="contain">
                <div class="sixteen columns top-1 bottom-3 bordeado">
                    <p>Para iniciar la inscripción de las carreras "Redes en Informatica" y "Analista de Sistema", por
                        favor completá el
                        siguiente formulario. Despues de enviar el mismo, le estaremos notificando para que pueda
                        acercarse y entregar los documentos reuqueridos<br>
                        <!--<a href="">&iquest;Ya sos alumno o egresado UP? Hac&eacute; click ac&aacute;</a>-->
                    </p>

                    <div id="botones">
                        <div class="topbar1">
                            <p>1. Tus datos</p>
                        </div>
                    </div>

                    <form id="signupform" class="form-horizontal" role="form"
                        action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" autocomplete="off">
                        <div class="form-group">
                            <input type="text" name="apellido" id="resgistro_usuario-apellido" placeholder="*Apellido/s"
                                maxlength="29" value="<?php if (isset($apellido)) echo $apellido; ?>" maxlength="30"
                                class="require" required>
                        </div>

                        <div class="form-group">
                            <input type="text" name="nombre" id="resgistro_usuario-nombre"
                                value="<?php if (isset($nombre)) echo $nombre; ?>" placeholder="*Nombre/s"
                                maxlength="30" class="require" required>
                        </div>



                        <div class="form-group">
                            <input type="email" name="email" id="email" value="<?php if (isset($email)) echo $email; ?>"
                                placeholder="*E-mail" maxlength="50" class="require" required>
                        </div>

                        <p class="form-group">Fecha de Nacimiento</p>
                        <div class="form-group">
                            <input type="date" name="fecha_nacimiento" id="fecha_nacimiento"
                                placeholder="*Fecha Nacimiento" maxlength="50" class="require" required>

                        </div>

                        <p class="form-group">Documento de identidad</p>
                        <div class="form-group">
                            <select name="nacionalidad" id="registro_usuario-nacionalidad" class="">
                                <option value="null">*Nacionalidad</option>
                                <option value="1">Argentino</option>
                                <option value="2">Extranjero</option>
                                <option value="3">Naturalizado</option>
                                <option value="4">Otra Opción</option>
                            </select>
                            <select name="resgistro_usuario-tipo_documento" id="resgistro_usuario-tipo_documento"
                                class="">
                                <option value="null">DNI</option>
                                <!-- <option value="3">CUIL/CUIT</option> -->
                                <!-- <option value="0">DNI</option> -->
                            </select>




                            <input type="text" name="usuario" id="resgistro_usuario-dni" placeholder="DNI/CUIT"
                                maxlength="29" value="<?php if (isset($usuario)) echo $usuario; ?>" maxlength="30"
                                class="require" required>



                        </div>

                        <p class="form-group">Teléfono</p>
                        <div class="form-group">
                            <!-- <select name="registro_movil" id="registro_movil" class="registro_movil">
                                <option value="null">Telefono</option>
                               <option value="1">Celular</option>
                                <option value="2">Fijo</option>
                            </select>-->
                            <!-- <input type="tel" name="telefono_area" id="telefono_area" value="" placeholder="*Area"
                                maxlength="4" class="registro_movil">-->
                            <input type="tel" name="telefono" id="telefono" placeholder="*Número"
                                value="<?php if (isset($telefono)) echo $telefono; ?>" class="require"
                                autocomplete="off" maxlength="12">
                        </div>

                        <p class="form-group">Carrera</p>
                        <div class="form-group">
                            <select name="plan" id="plan" class="">
                                <option value="">*Carrea</option>
                                <option title="Redes" value="6164/03">Redes</option>
                                <option title="AnalistadeSistema" value="5817/03">Analista de Sistema</option>
                            </select>

                        </div>
                        <div class="form-group">
                            <label for="captcha" class="col-md-3 control-label"></label>
                            <div class="g-recaptcha col-md-9" data-sitekey="6LciPeAnAAAAAP40vAmm2bCvpYmfc5bIgEBzsbh4">
                            </div>
                        </div>

                        <div class="form-btn">

                            <input id="btn-signup" type="submit" class="bgenerar" value="Generar Inscripción">


                            <input type="button" name="volver" value="Volver" class="bvolver"
                                onclick="window.location.href='/instituto/Login/index.php'">
                        </div>
                        <?php echo resultBlock($errors); ?>

                    </form>

                </div>
            </div>
        </div>

    </div>

</div>

</header>
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

</html>