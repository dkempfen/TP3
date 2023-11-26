<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Includes/load.php';

?>
<?php

$nueva_foto = cambiarFotoPerfil('cambio_foto_perfil');

?>
<!-- Sidebar menu-->
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
        <li><a class="app-menu__item" href="/instituto/Adman/Pantallas/home.php">
                <i class="app-menu__icon fas fa-home"></i><span class="app-menu__label">Home</span></a></li>
        <li><a class="app-menu__item" href="/instituto/Adman/Pantallas/lista_personas.php">
                <i class="app-menu__icon fas fa-users"></i><span class="app-menu__label">Personas</span></a></li>
        <li><a class="app-menu__item" href="/instituto/Adman/Pantallas/pantalla_Usuario.php">
                <i class="app-menu__icon fas fa-users"></i><span class="app-menu__label">Usuarios</span></a></li>
        <li><a class="app-menu__item" href="/instituto/Adman/Pantallas/carreras.php">
                <i class="app-menu__icon fas fa-graduation-cap"></i><span class="app-menu__label">Carreras</span></a>
        </li>
        <li>
        <li><a class="app-menu__item" href="/instituto/Adman/Pantallas/Notas.php">
                <i class="app-menu__icon fas fa-clipboard-list"></i><span class="app-menu__label">Notas</span></a></li>
        <li>

        <li><a class="app-menu__item" href="/instituto/Adman/Pantallas/finales.php">
                <i class="app-menu__icon fas fa-edit"></i><span class="app-menu__label">Finales</span></a></li>
        <li><a class="app-menu__item" href="/instituto/Adman/Pantallas/documentacion.php">
                <i class="app-menu__icon fas fa-list-alt"></i><span class="app-menu__label">Documentación</span></a>
        </li>
        <li><a class="app-menu__item" href="/instituto/Login/logout.php">
                <i class="app-menu__icon fas fa-sign-out-alt"></i><span class="app-menu__label">Logout</span></a></li>
    </ul>
</aside>