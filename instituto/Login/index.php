<?php
session_start();
if (!empty($_SESSION['active'])) {
    header('Location:/instituto/Adman/index.php');
} else if (!empty($_SESSION['activeP'])) {
    header('Location:/instituto/profesor/index.php');
} else if (!empty($_SESSION['activea'])) {
    header('Location:/instituto/Alumno/index.php');
}

$pageTitle = "Ingreso al Sistema"; // Define el título de la página
include '../Includes/header.php';

?>


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
                        include "../Includes/login.php";
                        ?>
                        <label id="labelUsuario" for="usuario">Usuario</label>
                        <input type="text" class="input" name="usuario" id="usuario" placeholder="Nombre de usuario">
                        <label id="labelPassword" for="password">Contraseña</label>
                        <input type="password" name="pass" id="pass" placeholder="Contraseña">
                        <div id="messageUsuario"></div>
                        <div class="view">
                            <div class="fas fa-eye verPassword" onclick="vista()" id="verPassword"></div>
                        </div>
                        <button class="clave" type="button" onclick="location.href='/instituto/Login/RecuperoClave.php'">
                            ¿Olvidaste la clave?</button>
                        <!--<input name="btningresar" id="btningresar" type="submit" class="btn" value="Iniciar Sesión">-->
                        <button id="loginUsuario" type="submit" name="btningresar">Iniciar Sesión</button>
                    </form>
                </div>
                <div class="text-center">



                    <h6>¿Desea inscribirse a una carrea?</h6>
                    <a class="buttons button-large button-rounded botonfooter" id=""
                        href="/instituto/Login/registro.php">Inscripción</a>



                </div>
            </div>


        </div>

  
</body>

