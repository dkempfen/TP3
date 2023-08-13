<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="viewport" content="width-device-width, initial-scale-1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/styleregistro.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <title>Ingreso al Sistema</title>
</head>

<body>
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
    <!--<div id="" class="">
        <div id="form" class="" style="">
            <form id="form_resgistro_usuario" action="" name="" value="" class="">
                <div class="datosUser">
                    <h3>INGRESE LOS SIGUIENTES DATOS</h3>

                    <div class="">
                        <div class="">
                            <dt id="registro_carrea">
                                <label for="registro_carrea" class="obligatorio">Carrera (*)</label>
                            </dt>
                            <select name="registro_carrea" id="registro_carrea" class="">
                                <option value="null">-- Seleccioná --</option>
                                <option value="1">Redes</option>
                                <option value="2">Analista de sistema</option>
                            </select>
                        </div>
                    </div>

                    <div class="">
                        <div class="">
                            <dt id="">
                                <label for="" class="obligatorio">E-mail (*)</label>
                            </dt><input type="text" name="" id="" value="" maxlength="50" class="">
                        </div>

                    </div>
                    <div class="">
                        <div class="">
                            <dt id="resgistro_usuario-apellido">
                                <label for="resgistro_usuario-apellido" class="obligatorio">Apellido (*)</label>
                            </dt>
                            <input type="text" name="resgistro_usuario-apellido" id="resgistro_usuario-apellido"
                                value="" maxlength="30" class=" require">
                        </div>
                        <div class="">
                            <dt id="resgistro_usuario-nombre">
                                <label for="resgistro_usuario-nombre" class="obligatorio">Nombres (*)</label>
                            </dt>
                            <input type="text" name="resgistro_usuario-nombre" id="resgistro_usuario-nombre" value=""
                                maxlength="30" class=" require">
                        </div>
                    </div>
                    <div class="">
                        <div class="">
                            <dt id="registro_usuario-nacionalidad">
                                <label for="registro_usuario-nacionalidad" class="obligatorio">Nacionalidad (*)</label>
                            </dt>
                            <select name="registro_usuario-nacionalidad" id="registro_usuario-nacionalidad" class="">
                                <option value="null">-- Seleccioná --</option>
                                <option value="1">Argentino</option>
                                <option value="2">Extranjero</option>
                                <option value="3">Naturalizado</option>
                                <option value="4">Por Opción</option>
                            </select>
                        </div>
                    </div>
                    <div class="">
                        <div class="">
                            <dt id="resgistro_usuario-tipo_documento">
                                <label for="resgistro_usuario-tipo_documento" class="obligatorio">Tipo de Documento
                                    (*)</label>
                            </dt>
                            <select name="resgistro_usuario-tipo_documento" id="resgistro_usuario-tipo_documento"
                                class="">
                                <option value="null">-- Seleccioná --</option>
                                <option value="3">CUIL/CUIT</option>
                                <option value="0">Documento Nacional de Identidad</option>
                            </select>
                        </div>
                    </div>
                    <div class="">
                        <div class="">
                            <dt id="registro_usuario-nro_documento">
                                <label for="registro_usuario-nro_documento" class="obligatorio">Número de
                                    documento(*)</label>
                            </dt>
                            <input type="text" name="registro_usuario-nro_documento" id="registro_usuario-nro_documento"
                                value="" maxlength="20" class=" require">
                        </div>
                        <div class="">
                            <dt id="registro_usuario-nro_documento">
                                <label for="registro_usuario-nro_documento" class="obligatorio">Repetir el número de
                                    documento (*)</label>
                            </dt><input type="text" name="registro_usuario-nro_documento"
                                id="registro_usuario-nro_documento" value="" maxlength="20" class="" autocomplete="off">
                        </div>
                    </div>
                </div>
                <div class="">
                    <button id="continuar" name="continuar" type="submit" class="btn btn-info">Generar
                        Inscripción</button>
                    <input type="button" name="volver" value="Volver" class="btn btn-info"
                        onclick="window.location.href='/instituto/index.php'">
                </div>
            </form>
        </div>
    </div>
-->
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
                                onclick="window.location.href='/instituto/index.php'">
                        </div>

                    </form>
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