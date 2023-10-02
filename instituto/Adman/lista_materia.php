<?php
require_once 'includes/header.php';
require_once './modals/modal_materia.php';
?>

<main class="app-content">

    <div class="custom-menu">
        <nav class="custom-nav">
            <div class="menu-group">
                <ul class="custom-menu-list">
                    <!-- Carreras -->
                    <li class="custom-menu-item">
                    <a class="custom-menu-link" href="/instituto/Adman/Pantallas/carreras.php">Nuestras Carreras</a>

                    </li>
                </ul>
            </div>

            <div class="menu-group">
                <ul class="custom-menu-list">
                    <!-- Planes de Estudio -->
                    <li class="custom-menu-item">
                        <a class="custom-menu-link" href="/instituto/Adman/lista_planes.php">Planes de Estudio</a>

                    </li>
                </ul>
            </div>

            <div class="menu-group">
                <ul class="custom-menu-list">
                    <!-- Materias -->
                    <li class="custom-menu-item">
                        <a class="custom-menu-link" href="/instituto/Adman/lista_materia.php">Materias</a>

                    </li>
                </ul>
            </div>
        </nav>
    </div>

    <div id="menu-container" class="container">



        <div class="row espaciado-entre-filas align-items-center">

            <div class="mx-auto text-center">
                <form id="busquedaForm" class="form-inline mb-5">
                    <div class="form-group mb-2">
                        <label for="materia" class="label-spacing">Materia:</label>
                        <input type="text" class="form-control  " id="materia">
                        </select>
                    </div>
                    <div class="form-group mb-2">
                        <label for="nombrePlan" class="label-spacing">Nombre del Plan:</label>
                        <input type="text" class="form-control" id="nombrePlan">
                    </div>
                    <div class="form-group mb-2">
                        <label for="carrera" class="label-spacing">Carrera:</label>
                        <input type="text" class="form-control" id="carrera">
                        </select>
                    </div>
                    <div class="form-group mb-2">
                        <label for="age" class="label-spacing">Año:</label>
                        <input type="text" class="form-control" id="age">
                        </select>
                    </div>
                </form>
            </div>


            <div class="col-lg-6 text-left">
                <!-- Divide la fila en 2 columnas y alinea a la derecha -->
                <a id="generarPDFBtn" href="#" onclick="descargarMateriaPDF(); return false;" class="planpdf-button">
                    <i class="fas fa-file-pdf"></i> Descargar PDF
                </a>

                <a id="generareEXCLBtn" href="#" onclick="descargarMateriaEXCL(); return false;"
                    class="planexcel-button">
                    <i class="fas fa-file-excel"></i> Descargar Excel
                </a>

                <!-- <a id="crearNuevoPlanBtn" href="#crearNuevoPlanModal" class="planalta-button"
                    onclick="mostrarCrearNuevoPlan(); return false;">
                    <i class="fas fa-plus"></i> Crear Nuevo Plan
                </a>-->
            </div>

            <div class="col-lg-6 text-right">
                <!-- Divide la fila en 2 columnas y alinea a la derecha -->



                <button data-toggle="modal" class="planalta-button" id="crearNuevoPlanBtn" type="button"
                    onclick="openModalM()"><i class="fas fa-plus"></i> Crear Nuevo Materia</button>

                <!-- <a id="crearNuevoPlanBtn" href="#crearNuevoPlanModal" class="planalta-button"
                    onclick="mostrarCrearNuevoPlan(); return false;">
                    <i class="fas fa-plus"></i> Crear Nuevo Plan
                </a>-->
            </div>

        </div>


        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div class="tile-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered" id="tablemateria">
                                <thead>
                                    <tr>
                                        <th>Acciones</th>
                                        <th>ID</th>
                                        <th>Carrera</th>
                                        <th>Plan</th>
                                        <th>Nivel</th>
                                        <th>Promocional</th>
                                        <th>Acción</th>
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
        <div class="row espaciado-entre-plames align-items-center">
            <div class="col-lg-6">
                <!-- Divide la fila en 2 columnas -->
                <div class="custom-link">
                    <a href="/instituto/Adman/Pantallas/carreras.php" title="">
                        <span class="buttonIcon" aria-hidden="true">
                            <i class="fas fa-chevron-left"></i>
                        </span>
                        <span class="buttonText">Anterior</span>
                    </a>
                </div>
            </div>

        </div>
    </div>
</main>

<?php
require_once 'includes/footer.php';
?>