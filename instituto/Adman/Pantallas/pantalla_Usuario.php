<?php
require_once '../includes/header.php';
require_once '../Includes/load.php';
?>

<?php
$c_user = count_by_id('Usuario');
$c_materias = count_by_id('Materia');
$c_alum = count_by_id('Persona');
$c_prof = count_by_id('Persona');
?>

<main class="app-content">
    <div class="container">
        <!-- Agregamos un contenedor Bootstrap -->
        <div class="row justify-content-center align-items-center mt-4"> <!-- Agregamos mt-4 para margen superior -->
            <!-- Centramos la fila horizontalmente y verticalmente -->
            <div class="col-md-12">
                <div src="" alt="imagen terciario"></div>
            </div>
        </div>
        <div class="row justify-content-center">
            <!-- Centramos la fila horizontalmente -->
            <div class="col-xl-4 col-md-6 mb-4"> <!-- Aumentamos el ancho de las tarjetas y dejamos 'mb-4' -->
                <div class="card bg-primary text-white">
                    <div class="card-body d-flex align-items-center">
                        <i class="fas fa-users fa-3x"></i>
                        <div class="ml-4">
                            <h5 class="card-title">Administrativos</h5>
                            <a href="<?php echo '/instituto/Adman/lista_usuarios.php';?>" class="stretched-link"></a>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        <a href="<?php echo '/instituto/Adman/lista_usuarios.php';?>" class="text-white">Ver detalle</a>
                        <span><?php echo $c_user ?></span>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6 mb-4"> <!-- Aumentamos el ancho de las tarjetas y dejamos 'mb-4' -->
                <div class="card bg-success text-white">
                    <div class="card-body d-flex align-items-center">
                        <i class="fas fa-user-graduate fa-3x"></i>
                        <div class="ml-4">
                            <h5 class="card-title">Alumnos</h5>
                            <a href="<?php echo '/instituto/Adman/lista_alumnos.php';?>" class="stretched-link"></a>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        <a href="<?php echo '/instituto/Adman//lista_alumnos.php';?>" class="text-white">Ver detalle</a>
                        <span><?php echo $c_alum ?></span>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6 mb-4"> <!-- Aumentamos el ancho de las tarjetas y dejamos 'mb-4' -->
                <div class="card bg-danger text-white">
                    <div class="card-body d-flex align-items-center">
                        <i class="fas fa-chalkboard-teacher fa-3x"></i>
                        <div class="ml-4">
                            <h5 class="card-title">Profesores</h5>
                            <a href="<?php echo '/instituto/Adman/lista_profesores.php';?>" class="stretched-link"></a>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        <a href="<?php echo '/instituto/Adman/lista_profesores.php';?>" class="text-white">Ver
                            detalle</a>
                        <span><?php echo $c_prof ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php
require_once 'includes/footer.php';
?>