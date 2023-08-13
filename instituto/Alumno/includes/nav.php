<!-- Sidebar menu-->
<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">
  <div class="app-sidebar__user"><img class="app-sidebar__user-avatar" src="/instituto/Imagenes/avatar.png"
      alt="User Image">
    <div>
      <p class="app-sidebar__user-name">
        <?= $_SESSION['nombre'];?>
      </p>
      <p class="app-sidebar__user-designation">
        <?= $_SESSION['nombre_rol'];?>
      </p>
    </div>
  </div>
  <ul class="app-menu">
    <li><a class="app-menu__item" href="/instituto/Alumno/lista_materia.php">
        <i class="app-menu__icon fas fa-list-alt"></i><span class="app-menu__label">Materias</span></a></li>
    
    <li>
    <li><a class="app-menu__item" href="/instituto/Alumno//lista_Notas.php">
        <i class="app-menu__icon fas fa-list-alt"></i><span class="app-menu__label">Notas</span></a></li>
    <li>
    <li><a class="app-menu__item" href="/instituto/Alumno//lista_finales.php">
        <i class="app-menu__icon fas fa-list-alt"></i><span class="app-menu__label">Finales</span></a></li>
    <li><a class="app-menu__item" href="/instituto/Login/logout.php">
        <i class="app-menu__icon fas fa-sign-out-alt"></i><span class="app-menu__label">Logout</span></a></li>
  </ul>
</aside>