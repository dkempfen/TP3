<?php
require_once 'includes/header.php';
require_once '../Includes/load.php';



?>
<?php

 $c_user        = count_by_id('Usuario');
 $c_materias     = count_by_id('Materia');
 $c_alum         = count_by_id('Persona');
 $c_prof         = count_by_id('Persona');
?>

<main class="app-content">
  <div class="row">
    <div class="col-md-12">
      <div src="" alt="imagen terciario"></div>
    </div>
    <div class="col-xl-3 col-md-6">
      <div class="card bg-primary">
        <div class="card-body d-flex text-white">
          Usuarios
          <i class="fas fa-users fa-2x ml-auto"></i>
        </div>
        <div class="card-footer d-flex align-items-center justify-content-between">
          <a href="<?php echo '/instituto/Adman/lista_usuarios.php';?>" class="text-white">Ver detalle</a>
          <span class="text-white"><?php  echo $c_user?></span>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-md-6">
      <div class="card bg-success">
        <div class="card-body d-flex text-white">
          Alumnos
          <i class="fas fa-user-graduate fa-2x ml-auto"></i>
        </div>
        <div class="card-footer d-flex align-items-center justify-content-between">
          <a href="<?php echo '/instituto/Adman//lista_alumnos.php';?>" class="text-white">Ver detalle</a>
          <span class="text-white"><?php  echo $c_alum?></span>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-md-6">
      <div class="card bg-danger">
        <div class="card-body d-flex text-white">
          Profesores
          <i class="fas fa-chalkboard-teacher fa-2x ml-auto"></i>
        </div>
        <div class="card-footer d-flex align-items-center justify-content-between">
          <a href="<?php echo '/instituto/Adman/lista_profesores.php';?>" class="text-white">Ver detalle</a>
          <span class="text-white"><?php  echo $c_prof?></span>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-md-6">
      <div class="card bg-info">
        <div class="card-body d-flex text-white">
        Materias
          <i class="fas fa-list-alt fa-2x ml-auto"></i>
        </div>
        <div class="card-footer d-flex align-items-center justify-content-between">
          <a href="<?php echo '/instituto/Adman/lista_materia.php';?>" class="text-white">Ver detalle</a>
          <span class="text-white"><?php  echo $c_materias?></span>
        </div>
      </div>
    </div>

  </div>
  .
</main>

<?php
require_once 'includes/footer.php';
?>