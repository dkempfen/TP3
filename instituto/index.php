<?php
session_start();
if (!empty($_SESSION['active'])) {
    header('Location:/instituto/Adman/index.php');
} else if (!empty($_SESSION['activeP'])) {
    header('Location:/instituto/profesor/index.php');
}else if (!empty($_SESSION['activea'])) {
    header('Location:/instituto/Alumno/index.php');
}



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="viewport" content="width-device-width, initial-scale-1.0">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <title>Ingreso al Sistema</title>
</head>

<body>
    <header class="main-header">
        <div class="main-cont">
            <div class="desc-header">
                <img src="/instituto/Imagenes/lOGO.gif" alt="image instituto">
                <p>Instituto Nuestra Señora De Lujan Del Buen Viaje</p>
            </div>
        </div>
        <div class="cont-header">
            <h1>Bienvenid@s</h1> 

            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <form action="" method='post' onsubmit="return validar()">
                        <?php

                        /*include "includes/conexion.php";*/
                        include "includes/loginAdman.php";
                        ?>
                        <label for="usuario">Usuario</label>
                        <input type="text" class="input" name="usuario" id="usuario" placeholder="Nombre de usuario">
                        <label for="password">Contraseña</label>
                        <input type="password" name="pass" id="pass" placeholder="Contraseña">
                        <div id="messageUsuario"></div>
                        <div class="view">
                            <div class="fas fa-eye verPassword" onclick="vista()" id="verPassword"></div>
                        </div>
                        <button class="clave" type="button"  onclick="location.href='/instituto/RecuperoClave.php'">
                        ¿Olvidaste la clave?</button>
                        <!--<input name="btningresar" id="btningresar" type="submit" class="btn" value="Iniciar Sesión">-->
                        <button id="loginUsuario" type="submit" name="btningresar">Iniciar Sesión</button>
                    </form>
                </div>
                <div class="text-center">



                    <h6>¿Desea inscribirse a una carrea?</h6>
                    <a class="buttons button-large button-rounded botonfooter" id=""
                        href="/instituto/registro.php">Inscripción</a>



                </div>
            </div>


        </div>

    </header>
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

</html>