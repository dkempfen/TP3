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

                    <form class="form-inline" role="form">
                        <div class="form-group">
                            <input type="text" name="resgistro_usuario-apellido" id="resgistro_usuario-apellido"
                                placeholder="*Apellido/s" maxlength="29" value="" maxlength="30" class="require">
                        </div>
                        <div class="form-group">
                            <input type="text" name="resgistro_usuario-nombre" id="resgistro_usuario-nombre" value=""
                                placeholder="*Nombre/s" maxlength="30" class="require">
                        </div>
                        <div class="form-group">
                            <input type="email" name="email" id="email" value="" placeholder="*E-mail" maxlength="50"
                                class="require">
                        </div>

                        <p class="form-group">Documento de identidad</p>
                        <div class="form-group">
                            <select name="registro_usuario-nacionalidad" id="registro_usuario-nacionalidad"
                                class="require">
                                <option value="null">*Nacionalidad</option>
                                <option value="1">Argentino</option>
                                <option value="2">Extranjero</option>
                                <option value="3">Naturalizado</option>
                                <option value="4">Por Opción</option>
                            </select>
                            <select name="resgistro_usuario-tipo_documento" id="resgistro_usuario-tipo_documento"
                                class="require">
                                <option value="null">*Tipo de Documento</option>
                                <option value="3">CUIL/CUIT</option>
                                <option value="0">Documento Nacional de Identidad</option>
                            </select>

                            <div class="">
                                <input type="text" name="registro_usuario-nro_documento"
                                    id="registro_usuario-nro_documento" value="" placeholder="*DNI/CUIT" maxlength="20"
                                    class=" require">
                            </div>

                        </div>

                        <p class="form-group">Teléfono</p>
                        <div class="form-group">
                            <select name="registro_movil" id="registro_movil" class="registro_movil">
                                <option value="null">Telefono</option>
                                <option value="1">Celular</option>
                                <option value="2">Fijo</option>
                            </select>
                            <input type="tel" name="telefono_area" id="telefono_area" value="" placeholder="*Area"
                                maxlength="4" class="registro_movil">

                            <input type="tel" name="telefono_numero" id="telefono_numero" placeholder="*Número" value=""
                                class="require" autocomplete="off" maxlength="12">

                        </div>

                        <p class="form-group">Carrera</p>
                        <div class="form-group">
                            <select name="registro_carrera" id="registro_carrera" class="require">
                                <option value="">*Carrea</option>
                                <option title="Redes" value="RS">Redes</option>
                                <option title="AnalistadeSistema" value="AS">Analista de Sistema</option>
                            </select>

                        </div>

                        <div class="form-btn">
                            <input id="continuar" name="continuar" type="button" class="bgenerar" value="Generar
                            Inscripción">
                            <input type="button" name="volver" value="Volver" class="bvolver"
                                onclick="window.location.href='/instituto/Login/index.php'">
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Fin Contenido -->

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