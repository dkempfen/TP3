<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistemas/instituto/Adman/includes/header.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistemas/instituto/Adman/modals/modal_materia.php';
?>

<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i>Finales</h1>
            <button class="btn btn-success" type="button" onclick="openModalF()">Nuevo Final</button>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="#">Lista de Materia</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered" id="tablefinal">
                            <thead>
                                <tr>
                                    <th>Acciones</th>
                                    <th>ID</th>
                                    <th>Materia</th>  
                                    <th>Profesor</th>        
                                    <th>Fecha</th> 
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
require_once 'includes/footer.php';
?>
