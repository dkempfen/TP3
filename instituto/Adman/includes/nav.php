<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Includes/load.php';

?>
<?php

$nueva_foto = cambiarFotoPerfil('cambio_foto_perfil');

?>


<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">
    <div class="app-sidebar__user" style="margin: -4px;">
        <img class="app-sidebar__user-avatar" src="/instituto/Imagenes/profiles/<?php echo $nueva_foto; ?>"
            alt="User Image">
        <div>
            <p class="app-sidebar__user-name"><?= $_SESSION['nombre']?></p>
            <p class="app-sidebar__user-designation"><?= $_SESSION['nombre_rol']?>
            </p>
        </div>
    </div>
    <ul class="app-menu">
        <li><a class="app-menu__item ignore-submenu" href="/instituto/Adman/Pantallas/home.php">
                <i class="app-menu__icon fas fa-home"></i><span class="app-menu__label">Home</span></a></li>
        <li><a class="app-menu__item ignore-submenu" href="/instituto/Adman/Pantallas/lista_personas.php">
                <i class="app-menu__icon fas fa-users"></i><span class="app-menu__label">Personas</span></a></li>
        <li><a class="app-menu__item ignore-submenu" href="/instituto/Adman/Pantallas/pantalla_Usuario.php">
                <i class="app-menu__icon fas fa-users"></i><span class="app-menu__label">Usuarios</span></a></li>
        <li><a class="app-menu__item ignore-submenu" href="/instituto/Adman/Pantallas/carreras.php">
                <i class="app-menu__icon fas fa-graduation-cap"></i><span class="app-menu__label">Carreras</span></a>
        </li>

        <li id="curso-container">
            <a id="curso-link" class="app-menu__item" href="/instituto/Adman/Pantallas/curso.php">
                <i class="app-menu__icon fas fa-pencil-alt"></i>
                <span class="app-menu__label">Cursada</span>
            </a>
        </li>

        <!-- Agrega un identificador único a los enlaces de Redes y Analistas -->
        <li id="redes-seccion" style="padding-left: 2px;">
            <a id="redes-link" class="app-menu__item" href="#">
                <i class="app-menu__icon fas fa-network-wired"></i>
                <span class="app-menu__label">Redes</span>
            </a>
            <ul id="redes-modules" class="app-menu__submenu" style="padding-left: 25px;">
                <li style="margin-bottom: 15px;">
                    <a href="/instituto/Adman/subPantallas/CursadaRedes.php">
                        <i class="fas fa-globe"></i> <!-- Icono de redes para representar el primer año -->
                        <span>Nivel 1</span>
                    </a>
                </li>
                <li style="margin-bottom: 15px;">
                    <a href="#">
                        <i class="fas fa-server"></i> <!-- Icono de servidor para representar el segundo año -->
                        <span>Nivel 2</span>
                    </a>
                </li>
                <li style="margin-bottom: 15px;">
                    <a href="#">
                        <i class="fas fa-wifi"></i> <!-- Icono de wifi para representar el tercer año -->
                        <span>Nivel 3</span>
                    </a>
                </li>
            </ul>
        </li>

        <li id="analista-seccion" style="padding-left: 2px;">
            <a id="analista-link" class="app-menu__item" href="#">
                <i class="app-menu__icon fas fa-laptop-code"></i>
                <span class="app-menu__label">Analistas de Sistema</span>
            </a>
            <ul id="analista-modules" class="app-menu__submenu" style="padding-left: 25px;">

                <li style="margin-bottom: 15px;">
                    <a href="#">
                        <i class="fas fa-code"></i> <!-- Icono de redes para representar el primer año -->
                        <span>Nivel 1</span>
                    </a>
                </li>
                <li style="margin-bottom: 15px;">
                    <a href="#">
                        <i class="fas fa-database"></i> <!-- Icono de servidor para representar el segundo año -->
                        <span>Nivel 2</span>
                    </a>
                </li>
                <li style="margin-bottom: 15px;">
                    <a href="#">
                        <i class="fas fa-cogs"></i> <!-- Icono de wifi para representar el tercer año -->
                        <span>Nivel 3</span>
                    </a>
                </li>

            </ul>
        </li>


        <li>
        <li><a class="app-menu__item ignore-submenu" href="/instituto/Adman/Pantallas/Notas.php">
                <i class="app-menu__icon fas fa-clipboard-list"></i><span class="app-menu__label">Notas</span></a></li>
        <li>

        <li><a class="app-menu__item ignore-submenu" href="/instituto/Adman/Pantallas/finales.php">
                <i class="app-menu__icon fas fa-edit"></i><span class="app-menu__label">Finales</span></a></li>
        <li><a class="app-menu__item ignore-submenu" href="/instituto/Adman/Pantallas/documentacion.php">
                <i class="app-menu__icon fas fa-list-alt"></i><span class="app-menu__label">Documentación</span></a>
        </li>
        <li><a class="app-menu__item ignore-submenu" href="/instituto/Login/logout.php">
                <i class="app-menu__icon fas fa-sign-out-alt"></i><span class="app-menu__label">Logout</span></a></li>
    </ul>
</aside>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    // Script para manejar la expansión/cierre de módulos
    $(document).ready(function() {
        // Oculta los submenús de Redes y Analista al principio
        $("#redes-seccion, #analista-seccion").hide();

        // Al hacer clic en el enlace de Curso
        $("#curso-link").click(function(e) {
            e.preventDefault();

            // Muestra u oculta los submenús de Redes y Analista
            $("#redes-seccion, #analista-seccion").toggle();

            // Oculta los submenús de Redes y Analista si están abiertos
            $("#redes-modules, #analista-modules").hide();
        });

        // Al hacer clic en el enlace de Redes
        $("#redes-link").click(function(e) {
            e.preventDefault();

            // Muestra u oculta el módulo de Redes
            $("#redes-modules").toggle();

            // Oculta el módulo de Analista
            $("#analista-modules").hide();
        });

        // Al hacer clic en el enlace de Analista
        $("#analista-link").click(function(e) {
            e.preventDefault();

            // Muestra u oculta el módulo de Analista
            $("#analista-modules").toggle();

            // Oculta el módulo de Redes
            $("#redes-modules").hide();
        });
    });
</script>
