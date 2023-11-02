<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema/instituto/Includes/load.php';
?>
<?php

$nueva_foto = cambiarFotoPerfil('cambio_foto_perfil');

?>
<!-- Sidebar menu-->
<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">
  <div class="app-sidebar__user"><img class="app-sidebar__user-avatar" src="/sistema/instituto/Imagenes/profiles/<?php echo $nueva_foto; ?>"
      alt="User Image">
    <div>
      <p class="app-sidebar__user-name"><?= $_SESSION['nombre']?></p>
      <p class="app-sidebar__user-designation"><?= $_SESSION['nombre_rol']?>
      </p>
    </div>
  </div>
  <ul class="app-menu">
    <li><a class="app-menu__item" href="/sistema/instituto/Adman/lista_usuarios.php">
        <i class="app-menu__icon fas fa-users"></i><span class="app-menu__label">Usuarios</span></a></li>
    <li><a class="app-menu__item" href="/sistema/instituto/Adman/lista_alumnos.php">
        <i class="app-menu__icon fas fa-user-graduate"></i><span class="app-menu__label">Alumnos</span></a></li>
    <li><a class="app-menu__item" href="/sistema/instituto/Adman/lista_profesores.php">
        <i class="app-menu__icon fas fa-chalkboard-teacher"></i><span class="app-menu__label">Profesores</span></a></li>
    <li><a class="app-menu__item" href="/sistema/instituto/Adman/lista_planes.php">
        <i class="app-menu__icon fas fa-list-alt"></i><span class="app-menu__label">Planes</span></a></li>
    <li><a class="app-menu__item" href="/sistema/instituto/Adman/lista_materia.php">
        <i class="app-menu__icon fas fa-list-alt"></i><span class="app-menu__label">Materias</span></a></li>
    <li><a class="app-menu__item" href="/sistema/instituto/Adman/carreras.php">
        <i class="app-menu__icon fas fa-list-alt"></i><span class="app-menu__label">Carreras</span></a></li>
    <li><a class="app-menu__item" href="/sistema/instituto/Adman/ActaVolante.php">
        <i class="app-menu__icon fas fa-list-alt"></i><span class="app-menu__label">Acta Volante</span></a></li>
    <li>
    <li><a class="app-menu__item" href="/sistema/instituto/Adman/Notas.php">
        <i class="app-menu__icon fas fa-list-alt"></i><span class="app-menu__label">Notas</span></a></li>
    <li>
    <li><a class="app-menu__item" href="/sistema/instituto/Adman/lista_finales.php">
        <i class="app-menu__icon fas fa-list-alt"></i><span class="app-menu__label">Finales</span></a></li>
        <li><a class="app-menu__item" href="/sistema/instituto/Adman/documentacion.php">
        <i class="app-menu__icon fas fa-list-alt"></i><span class="app-menu__label">Documentación</span></a></li>
    <li><a class="app-menu__item" href="/sistema/instituto/Login/logout.php">
        <i class="app-menu__icon fas fa-sign-out-alt"></i><span class="app-menu__label">Logout</span></a></li>
  </ul>
</aside>