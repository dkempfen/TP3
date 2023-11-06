<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Adman/includes/header.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Adman/modals/modal_materia.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Adman/modals/editar_materia.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Adman/modals/confirmacionCambioProfesor.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Includes/load.php';


?>

<?php

   

if ($pdo) {
    // Query para obtener todas las materias y los profesores asociados si los tienen
    $sql = "SELECT * 
    FROM Materia m
    LEFT JOIN Estado es ON m.fk_Estado = es.Id_Estado";
    
    $result = $pdo->query($sql);

    $sqlProfesores = "SELECT *
    FROM Usuario u 
    LEFT JOIN Persona pr ON u.fk_DNI = pr.DNI
    LEFT JOIN Estado es ON u.fk_Estado_Usuario = es.Id_Estado
    LEFT JOIN Materia_Profesor mp ON mp.id_Profesor = u.Id_Usuario
    LEFT JOIN Materia m ON m.id_Materia = mp.id_Materia
    WHERE u.fk_Rol = 2 and u.fk_Estado_Usuario=1";

    $profesores = $pdo->query($sqlProfesores);

  if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']); // Clear the session variable after displaying the message
    showConfirmationMessagesMateria($message);
}

if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']); // Clear the session variable after displaying the message
    showConfirmationMessagesMateriaEstado($message);
}
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
                    onclick="openModalMateria()"><i class="fas fa-plus"></i> Crear Nuevo Materia</button>

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
                                // Comprueba si la consulta de profesores fue exitosa
                                if ($profesores) {
                                    $profesoresList = $profesores->fetchAll(PDO::FETCH_ASSOC);

                                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                        echo '<tr data-materia-id="' . $row['id_Materia'] . '">';
                                        echo '<td class="">';
                                        echo '<label class="switch">';
                                        $checked = ($row['fk_Estado'] == 1) ? 'checked' : '';
                                        echo '<input class="onoffswitch-checkbox" type="checkbox" name="onoffswitch" value="true" ' . $checked . '  data-materia-id="' . $row['id_Materia'] . '">';
                                        echo '<span class="slider"></span>';
                                        echo '</label>';
                                        echo '</td>';
                                        echo '<td>' . $row['Descripcion'] . '</td>';
                                        echo '<td>';
                                        if ($row['Anio_Carrera'] == 1) {
                                            echo 'Nivel 1';
                                        } elseif ($row['Anio_Carrera'] == 2) {
                                            echo 'Nivel 2';
                                        } elseif ($row['Anio_Carrera'] == 3) {
                                            echo 'Nivel 3';
                                        } 
                                        echo '</td>';

                                        echo '<td>';
                                        if ($row['Promocional'] == 1) {
                                            echo 'Promocional';
                                        } elseif ($row['Promocional'] == 0) {
                                            echo 'No Promocional';
                                        }
                                        echo '</td>';
                                        // Añadir la lista desplegable de profesores
                                        echo '<td>';
                                        echo '<div class="form-group">';
                                        
                                        $selectName = 'ProfCarrera_' . $row['id_Materia'];
                                        
                                        echo '<select class="form-control" name="' . $selectName . '" id="' . $selectName . '" required onchange="mostrarModalConfirmacion(this)">';
                                        
                                        // Consulta SQL para obtener el profesor asignado a la materia actual
                                        $sqlProfesorMateria = "SELECT u.Id_Usuario, pr.Nombre, pr.Apellido
                                                               FROM Usuario u 
                                                               LEFT JOIN Persona pr ON u.fk_DNI = pr.DNI
                                                               LEFT JOIN Materia_Profesor mp ON u.Id_Usuario = mp.id_Profesor
                                                               WHERE mp.id_Materia = :materia_id";
                                
                                        $stmt = $pdo->prepare($sqlProfesorMateria);
                                        $stmt->execute(['materia_id' => $row['id_Materia']]);
                                        $profesorAsignado = $stmt->fetch(PDO::FETCH_ASSOC);

                                        echo '<option value="">Seleccionar Profesor</option>';

                                
                                        foreach ($profesoresList as $profesor) {
                                            $selected = '';
                                            
                                            // Comprobar si este profesor está asignado a la materia actual
                                            if ($profesorAsignado && $profesor['Id_Usuario'] == $profesorAsignado['Id_Usuario']) {
                                                $selected = 'selected';
                                                $_SESSION['ProfesorSeleccionado_' . $row['id_Materia']] = $profesor['Nombre'] . ' ' . $profesor['Apellido'];
                                            }
                                            echo '<option value="' . $profesor['Id_Usuario'] . '" ' . $selected . ' data-materia-id="' . $row['id_Materia'] . '">';
                                            echo $profesor['Nombre'] . ' ' . $profesor['Apellido'];
                                            echo '</option>';
                                        }
                                
                                        echo '</select>';
                                        echo '</div>';
                                        echo '</td>';
                                     
                                        
                                        echo '<td><button class="btn-icon" onclick="openModalsMateriaEdi(' . $row['id_Materia'] . ')"><i class="edit-btn"></i>✏️</button></td>';
                                        echo '</tr>';
                                    }
                                } else { 
                                    echo "Error: " . $sql . "<br>" . $pdo->errorInfo()[2];
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

<script>
function mostrarModalConfirmacion(selectElement) {
    if (selectElement.value !== '') {
        // Obtener el nombre del profesor seleccionado
        var selectedProfessorName = selectElement.options[selectElement.selectedIndex].text;
        var idMateria = selectElement.options[selectElement.selectedIndex].getAttribute('data-materia-id');
        var idUsuario = selectElement.value;

        // Actualizar los campos ocultos con los valores seleccionados
        document.getElementById('materiaId').value = idMateria;
        document.getElementById('profesorId').value = idUsuario;

        // Actualizar el contenido del modal de confirmación
        document.querySelector('#confirmModal .modal-body').innerHTML = '¿Desea cambiar el profesor seleccionado a este nuevo valor?<br>Profesor seleccionado: ' + selectedProfessorName;

        // Mostrar el modal de confirmación
        $('#confirmModal').modal('show');
    }
}
</script>



<script>
$(document).ready(function() {
    var tableMateria = $('#tablemateria').DataTable();

    $('#tablemateria').on("change", ".onoffswitch-checkbox", function() {
        var self = this;
        var Id_materia = $(this).data("materia-id");
        var fk_Estado = this.checked ? 1 : 2;

        $.ajax({
            url: "/instituto/Includes/sqlaltauser.php",
            type: "POST",
            data: {
                Id_materia: Id_materia,
                fk_Estado: fk_Estado
            },

            success: function(response) {
                var messageMater = $('#message'); // Elemento donde se mostrará el mensaje
                messageMater.html(response); // Coloca el mensaje en el elemento
                setTimeout(function() {
                    messageMater.html(''); // Borra el mensaje después de un tiempo
                    // Realiza otras operaciones si es necesario, pero no vuelvas a inicializar DataTable
                }, 2000);
            },
            error: function(error) {
                console.log("Error en la solicitud AJAX:", error);
            }
        });
    });


});
</script> 