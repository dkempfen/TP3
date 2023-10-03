<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Adman/includes/header.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Includes/load.php';


?>
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i>Lista de Calificaciones</h1>

        </div>



    </div>

    <div class="row espaciado-entre-filas align-items-center">

        <div class="container mt-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title text-center">Filtrar Alumnos</h4>
                    <form id="busquedaForm" class="form-row align-items-end">
                        <!-- Agregamos la clase "align-items-end" aquí -->
                        <div class="form-group col-md-3">
                            <label for="dni">DNI:</label>
                            <input type="text" class="form-control" id="dni">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="nombreUser">Nombre:</label>
                            <input type="text" class="form-control" id="nombreUser">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="apellidoUser">Apellido:</label>
                            <input type="text" class="form-control" id="apellidoUser">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="userNotas">Usuario:</label>
                            <input type="text" class="form-control" id="userNotas">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="carreraNotas">Carrera:</label>
                            <select class="form-control" id="carreraNotas">
                                <option value="Redes Informaticas">Redes Informaticas</option>
                                <option value="Analista de Sistema">Analista de Sistema</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="planNotas">Plan:</label>
                            <select class="form-control" id="planNotas">
                                <option value="Plan 1">Plan 1</option>
                                <option value="Plan 2">Plan 2</option>
                                <option value="Plan 3">Plan 3</option>
                                <!-- Agrega más opciones de plan según sea necesario -->
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <button type="submit" class="btn-primary btn-buscar">
                                <i class="fas fa-search"></i> Buscar
                            </button>

                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="container mt-4">

            <div class="col-lg-6 text-left">
                <!-- Divide la fila en 2 columnas y alinea a la derecha -->
                <a id="generarPDFBtn" href="#" onclick="descargarMateriaPDF(); return false;" class="planpdf-button">
                    <i class="fas fa-file-pdf"></i> Descargar PDF
                </a>

                <a id="generareEXCLBtn" href="#" onclick="descargarMateriaEXCL(); return false;"
                    class="planexcel-button">
                    <i class="fas fa-file-excel"></i> Descargar Excel
                </a>

            </div>

        </div>

    </div>
    <div class="container">

        <h2>Calificaciones de Alumnos</h2>
        <table id="calificaciones-table"> <!-- Agregamos el ID "calificaciones-table" -->
            <thead>
                <tr>
                    <th>Materia</th>
                    <th>1 Parcial</th>
                    <th>2 Parcial</th>
                    <th>1 Recuperatorio</th>
                    <th>2 Recuperatorio</th>
                    <th>Final</th>
                    <th>Carrera</th>
                    <th>Editar</th>
                </tr>
            </thead>
            <tbody>
                <!-- <?php foreach ($resultados as $alumno): ?>
            <tr>
                <th colspan="8"><?php echo $alumno['nombre'] . ' ' . $alumno['apellido']; ?></th>
            </tr>
            <?php foreach ($alumno['materias'] as $materia): ?>
                <tr>
                    <td><?php echo $materia['nombre']; ?></td>
                    <td><?php echo $materia['parcial1']; ?></td>
                    <td><?php echo $materia['parcial2']; ?></td>
                    <td><?php echo $materia['recuperatorio1']; ?></td>
                    <td><?php echo $materia['recuperatorio2']; ?></td>
                    <td><?php echo $materia['final']; ?></td>
                    <td><?php echo $alumno['carrera']; ?></td>
                    <td>
                        <button class="edit-button" data-alumno-id="<?php echo $alumno['id_alumno']; ?>">
                            Editar
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endforeach; ?>-->
            </tbody>
        </table>
    </div>
</main>

<?php
require_once '../includes/footer.php';
?>