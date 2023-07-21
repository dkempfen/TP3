<?php
require_once 'includes/header.php';
require_once 'includes/modals/modal_alumno.php';
?>

<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i>Lista de Alumnos</h1>
            <div class="caja_busqueda">
            <label for="caja_busqueda">Buscar:</label>
            <input type="text" name="caja_busqueda" id="caja_busqueda"></input >
            </div>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="#">Lista de Alumnos</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered" id="tablealumnos">
                            <thead>
                                <tr>

                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Apellido</th>
                                    <th>Materia inscripto</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                               
                            </tbody>
                        </table>
                    </div>
                </div>


            </div>
        </div>
    </div>
</main>

<?php
require_once 'instituto/profesor/includes/footer.php';
?>
