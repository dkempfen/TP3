<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Adman/includes/header.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Includes/load.php';
?>


<main class="app-content">
    <div class="container">
        <!-- Agregamos un contenedor Bootstrap -->
        <div class="row justify-content-center align-items-center mt-4">
            <!-- Agregamos mt-4 para margen superior -->
            <!-- Centramos la fila horizontalmente y verticalmente -->
            <div class="col-md-12">
                <div src="" alt="imagen terciario"></div>
            </div>
        </div>
        <div class="row justify-content-center">
            <!-- Centramos la fila horizontalmente -->
            <div class="col-xl-4 col-md-6 mb-4">
                <!-- Aumentamos el ancho de las tarjetas y dejamos 'mb-4' -->
                <div class="card bg-primary text-white">
                    <div class="card-body d-flex align-items-center">
                        <i class="fas fa-user-tie fa-3x"></i>
                        <div class="ml-4">
                            <h5 class="card-title">Administrativos</h5>
                            <a href="<?php echo '/instituto/Adman/lista_usuarios.php?rol=3';?>"
                                class="stretched-link"></a>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        <a href="<?php echo '/instituto/Adman/lista_usuarios.php?rol=3';?>" class="text-white">Ver
                            detalle</a>
                        <span><?php echo $totalAdmins ?></span>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6 mb-4">
                <!-- Aumentamos el ancho de las tarjetas y dejamos 'mb-4' -->
                <div class="card bg-success text-white">
                    <div class="card-body d-flex align-items-center">
                        <i class="fas fa-user-graduate fa-3x"></i>
                        <div class="ml-4">
                            <h5 class="card-title">Alumnos</h5>
                            <a href="<?php echo '/instituto/Adman/lista_usuarios.php?rol=1';?>"
                                class="stretched-link"></a>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        <a href="<?php echo '/instituto/Adman/lista_usuarios.php?rol=1';?>" class="text-white">Ver
                            detalle</a>
                        <span><?php echo $totalAlumnos?></span>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6 mb-4">
                <!-- Aumentamos el ancho de las tarjetas y dejamos 'mb-4' -->
                <div class="card bg-danger text-white">
                    <div class="card-body d-flex align-items-center">
                        <i class="fas fa-chalkboard-teacher fa-3x"></i>
                        <div class="ml-4">
                            <h5 class="card-title">Profesores</h5>
                            <a href="<?php echo '/instituto/Adman/lista_usuarios.php?rol=2';?>"
                                class="stretched-link"></a>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        <a href="<?php echo '/instituto/Adman/lista_usuarios.php?rol=2';?>" class="text-white">Ver
                            detalle</a>
                        <span><?php echo $totalProfesores ?></span>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card bg-info text-white">
                    <div class="card-body d-flex align-items-center">
                        <span style="position: relative; font-size: 24px;">
                            <i class="fas fa-male" style="position: absolute; top: 0; left: 0;"></i>
                            <i class="fas fa-female" style="position: absolute; top: 0; left: 0;"></i>
                        </span>
                        <div class="ml-4">
                            <h5 class="card-title">Todos los Usuarios</h5>
                            <a href="<?php echo '/instituto/Adman/lista_usuarios.php';?>" class="stretched-link"></a>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        <a href="<?php echo '/instituto/Adman/lista_usuarios.php';?>" class="text-white">Ver detalle</a>
                        <span><?php echo $totalUsuarios ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php
require_once '../includes/footer.php';
?>