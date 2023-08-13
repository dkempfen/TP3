<?php


$pageTitle = "Cambio Clave"; // Define el título de la página
include '../Includes/header.php';

?>
    <div class="container-clave">
        <div id="" style="margin-top:50px;" class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
            <div class="panel-recupero caudro-recupero">
                <div class="recupero-heading">
                    <div class="recupero-title">Cambiar Contraseña</div>
                    <div style="float:right; font-size: 80%; position: relative; top:-20px"><a class="Iniciar-clave" href="index.php">Iniciar
                            Sesión</a></div>
                </div>

                <div style="padding-top:30px" class="panel-recupero">

                    <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>

                    <form id="" class="form-horizontal" role="form" action="" method="POST" autocomplete="off">

                        <div style="margin-bottom: 25px" class="input-group">
                        <label class="form-group" for="password">Nueva Contraseña</label>
                        <input type="password" name="pass" id="pass" class="form-clave" placeholder="Contraseña">
                       
                    </div>
                        
                        <div style="margin-bottom: 25px" class="input-group">
                        <label class="form-group" for="password">Confirmar Contraseña</label>
                        <input type="password" name="pass" id="pass" class="form-clave"  placeholder="Confirmar Contraseña">
                        </div>

                        <div style="margin-top:10px" class="form-group">
                            <div class="col-sm-12 controls">
                                <button id="btn-login" type="submit" class="btn-enviar-recupero">Modificar
                                </button>
                            </div>
                        </div>

                      
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>

