<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Adman/includes/header.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Adman/modals/modal_materia.php';
?>

<?php
if ($pdo) {
    // Query para obtener los datos de la tabla 'materia' filtrados por el código de plan
    $sql = "SELECT *
    FROM Materia m
    /*LEFT JOIN Detalle_Plan dp ON m.id_Materia = dp.fk_Materia
    LEFT JOIN Plan p ON dp.fk_Plan = p.cod_Plan*/
    LEFT JOIN Materia_Profesor mp ON m.id_Materia = mp.id_Materia
    LEFT JOIN Usuario u ON mp.id_Profesor = u.Id_Usuario
    LEFT JOIN Persona pr ON u.fk_DNI = pr.DNI
    LEFT JOIN Estado es ON m.fk_Estado = es.Id_Estado";
    
    $result = $pdo->query($sql);



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
                                        <th>Carrera</th>
                                        <th>Nivel</th>
                                        <th>Promocional</th>
                                        <th>Profesor</th>
                                        <th>Editar</th>
                                    </tr>
                                </thead>
                                <tbody id="message">
                                    <?php
                                     
                                // Comprueba si la consulta fue exitosa
                                if ($result) {
                                    // Loop a través del resultado y generar filas de la tabla
                                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                        echo '<tr>';
                                        echo '<td class="">';
                                        echo '<label class="switch">';
                                       // Aquí agregamos un ternario para comprobar si el estado está activado o no
                                        $checked = ($row['fk_Estado'] == 1) ? 'checked' : '';
                                        echo '<input class="onoffswitch-checkbox" type="checkbox" name="onoffswitch" value="true" ' . $checked . ' data-usuario-id="' . $row['id_Materia'] . '">';
                                        echo '<span class="slider"></span>';
                                        echo '</label>';
                                        echo '</td>';
                                        echo '<td>' . $row['Descripcion'] . '</td>';
                                        echo '<td>' . $row['Anio_Carrera'] . '</td>';
                                        echo '<td>' . $row['Promocional'] . '</td>';
                                        echo '<td>' . $row['Nombre'] . ' ' . $row['Apellido'] . '</td>';
                                     
                                        //echo '<td>' . ($row['Inscripto'] ? 'Inscrito' : 'No Inscrito') . '</td>';
                                        echo '<td><button class="btn-icon" onclick="openModalsMateriaEdi(' . $row['id_Materia'] . ')"><i class="edit-btn"></i>✏️</button></td>';
                                        echo '</tr>';
                                    }
                                } else { 
                                    echo "Error: " . $sql . "<br>" . $pdo->errorInfo()[2]; // Acceder al mensaje de error usando errorInfo()
                                }
                                ?>
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
} else {
    echo "Error: No se pudo establecer la conexión a la base de datos.";
}
require_once '../includes/footer.php';
?>
<script>
$(document).ready(function() {
    var tableusuarios = $('#tablemateria').DataTable({});

    // Capturar eventos de cambio en los campos de búsqueda
    $('#dniBusqueda, #nombreUserBusqueda, #apellidoUserBusqueda').on('input', function() {
        // Obtener los valores de los campos de búsqueda
        var dni = $('#dniBusqueda').val().toLowerCase();
        var nombre = $('#nombreUserBusqueda').val().toLowerCase();
        var apellido = $('#apellidoUserBusqueda').val().toLowerCase();

        // Verificar si los campos de búsqueda están vacíos
        var camposVacios = dni === '' && nombre === '' && apellido === '';

        // Obtener todos los datos de la tabla (incluso los ocultos en otras páginas)
        var allData = tableusuarios.rows().data().toArray();

        // Filtrar los datos manualmente
        var filteredData = allData.filter(function(rowData) {
            var rowDni = rowData[0]
                .toLowerCase(); // Cambia el índice según tu estructura de datos
            var rowNombre = rowData[1].toLowerCase();
            var rowApellido = rowData[2].toLowerCase();

            // Comprobar si el DNI, Nombre y Apellido de la fila coinciden con los valores de búsqueda
            return rowDni.includes(dni) && rowNombre.includes(nombre) && rowApellido.includes(
                apellido);
        });

       
    });
});
</script>