<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Includes/load.php';
?>

<?php

if ($result["fk_Rol"]==1) {
    require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Adman/includes/header_alumnos.php';
} elseif ($$result["fk_Rol"]==2) {
    require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Adman/includes/header.php';
} else {
   // Encabezado por defecto
    require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Adman/includes/header.php';
}
?>
<main class="app-content">
  <div class="row">
    <div class="col-md-12">
      <div src="" alt="imagen terciario"></div>
    </div>
   

  </div>
  
</main>

<?php
require_once 'includes/footer.php';
?>


<?php
//require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Includes/load.php';

// Obtén el rol del usuario
//$rol_usuario = obtenerRolUsuario();

//if ($rol_usuario == 'rol1') {
//    require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Adman/includes/header_rol1.php';
//} elseif ($rol_usuario == 'rol2') {
//    require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Adman/includes/header_rol2.php';
//} else {
    // Encabezado por defecto
//    require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Adman/includes/header.php';
//}
?>

