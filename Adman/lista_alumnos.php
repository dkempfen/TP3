<?php
require_once 'includes/header.php';
require_once 'includes/modals/modal_alumno.php';
?>

<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i>Lista de Alumnos</h1>
            <button class="btn btn-success" type="button" onclick="openModalA()">Nuevo Alumno</button>
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
                                    <th>Acciones</th>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Edad</th>
                                    <th>Direccion</th>
                                    <th>Cedula</th>
                                    <th>Telefono</th>
                                    <th>Correo</th>
                                    <th>Fecha Nacimiento</th>
                                    <th>Fecha Registro</th>
                                    <th>ESTADO</th>
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
require_once 'includes/footer.php';
?>
