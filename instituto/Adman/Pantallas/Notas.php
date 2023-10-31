<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Adman/includes/header.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Includes/load.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Adman/modals/altaNota.php';



?>


<?php

   
if (isset($_SESSION['messageNota'])) {
    $messageNota = $_SESSION['messageNota'];
    unset($_SESSION['messageNota']); // Clear the session variable after displaying the message
    showConfirmationMessagesNotas($messageNota);
}

if ($pdo) {
  

    $sqlmaterianota = "select dc.id_Cursada,u.fk_DNI,p.Nombre,p.Apellido, dc.fk_Usuario, dc.fk_Legajo, dc.fk_Materia,m.Descripcion,dc.fk_Estado, dc.Primer_Parcial, 
    dc.Recuperatio_Parcial_1, dc.Primer_TP, dc.Recuperatio_TP_1, dc.Segundo_Parcial,dc.Recuperatio_Parcial_2, dc.Segundo_TP,
     dc.Recuperatio_TP_2, dc.Promedio, dc.Anio, pn.cod_Plan, pn.Carrera, Final
     from DetalleCursada dc INNER JOIN Usuario u ON dc.fk_Usuario=u.Id_Usuario
     INNER JOIN Persona p ON p.DNI=u.fk_DNI 
     INNER JOIN Materia m ON m.id_Materia=dc.fk_Materia  
     INNER JOIN Plan pn  ON pn.cod_Plan=u.fk_Plan";

    $materianota = $pdo->query($sqlmaterianota);



    // Inicializar $alumnoData
    $alumnoData = null;
?>
<main class="app-content">

    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i>Lista de Calificaciones</h1>

        </div>



    </div>
    <div id="menu-container" class="container">

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
                    onclick="openModalNota()"><i class="fas fa-plus"></i> Ingresar Nota</button>

                <!-- <a id="crearNuevoPlanBtn" href="#crearNuevoPlanModal" class="planalta-button"
                    onclick="mostrarCrearNuevoPlan(); return false;">
                    <i class="fas fa-plus"></i> Crear Nuevo Plan
                </a>-->
            </div>

        </div>
        <div class="container">
            <h2>Calificaciones de Alumnos</h2>

            <?php while ($materia = $materianota->fetch(PDO::FETCH_ASSOC)) : ?>
            <?php
            // Verificar si los datos del alumno actual son diferentes de los datos anteriores
            if ($alumnoData === null || $alumnoData['fk_DNI'] !== $materia['fk_DNI']) {
                if ($alumnoData !== null) {
                    // Cerrar la tabla anterior si no es el primer grupo de calificaciones
                    echo '</tbody></table>';
                }
                // Iniciar una nueva tabla para el nuevo alumno
                echo '<table id="calificaciones-table">';
                echo '<thead>';
                echo '<tr>';
                echo '<th class="alumno-header" colspan="10"><i class="fas fa-graduation-cap"></i> Nombre Alumno: ' . $materia['Nombre'] . ' ' . $materia['Apellido'] . '</th>';
                echo '</tr>';
                echo '<tr id="nombre-alumno">';
                echo '<th>Materia</th>';
                echo '<th>1 Parcial</th>';
                echo '<th>1 Recuperatorio</th>';
                echo '<th>2 Parcial</th>';
                echo '<th>2 Recuperatorio</th>';
                echo '<th>Promedio</th>';
                echo '<th>Final</th>';
                echo '<th>Carrera</th>';
                echo '<th>Año</th>';
                echo '<th>Editar</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';
                // Actualizar los datos del alumno actual
                $alumnoData = $materia;
            }
            ?>
            <tr>
                <td id="materiaEditar" name="materiaEditar" class="no-editable"><?php echo $materia['Descripcion']; ?></td>
                <td id="parcial1Editar" name="parcial1Editar" class="editable"><?php echo $materia['Primer_Parcial']; ?></td>
                <td id="recuperatorio1Editar" name="recuperatorio1Editar" class="editable"><?php echo $materia['Recuperatio_Parcial_1']; ?></td>
                <td id="parcial2Editar" name="parcial2Editar" class="editable"><?php echo $materia['Segundo_Parcial']; ?></td>
                <td id="recuperatorio2Editar" name="recuperatorio2Editar" class="editable"><?php echo $materia['Recuperatio_Parcial_2']; ?></td>
                <td id="promedioEditar" name="promedioEditar" class="no-editable"><?php echo $materia['Promedio']; ?></td>
                <td id="finalnotaEditar" name="finalnotaEditar" class="editable"><?php echo $materia['Final']; ?></td>
                <td id="carreraEditar" name="carreraEditar" class="no-editable"><?php echo $materia['Carrera']; ?></td>
                <td id="anioMateriaEditar" name="anioMateriaEditar" class="no-editable"><?php echo $materia['Anio']; ?></td>
                <input type="hidden" name="nota_IDALUMNO_0" value="1">

                <td>
                    <button class="edit-button" data-alumno-id="<?php echo $materia['fk_Usuario']; ?>"
                        data-id-cursada="<?php echo $materia['id_Cursada'] ; ?>" type="submit">
                        Editar
                    </button>

                    
                </td>
            </tr>
            <?php endwhile; ?>



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
    var idCursada = null; // Variable global para almacenar el valor de idCursada

    // Agrega un manejador de eventos al botón "Editar" para cada fila
    $('.edit-button').click(function() {
        var fila = $(this).closest('tr');
        idCursada = fila.find('.edit-button').data('id-cursada');

        // Encuentra todas las celdas con la clase "editable" dentro de la fila
        fila.find('td.editable').each(function() {
            var valorOriginal = $(this).text();
            $(this).html('<input type="text" value="' + valorOriginal + '" class="editable-input">');
        });

        // Agrega un botón para guardar los cambios
        fila.find('td:last').html('<button class="guardar-button">Guardar</button>');
    });

    // Agrega un manejador de eventos al botón "Guardar" (delegado para elementos dinámicos)
    $('#menu-container').on('click', '.guardar-button', function() {
        var fila = $(this).closest('tr');
        var botonEditar = fila.find('.edit-button');
        var alumnoId = botonEditar.data('alumno-id');
        var idCursada = botonEditar.data('id-cursada');

        // Recopila los valores editados de las celdas con la clase "editable" en un arreglo
        var datos = [];
        fila.find('td.editable').each(function(index) {
            var input = $(this).find('input');
            var valorOriginal = input.attr('value'); // Valor original
            var valorNuevo = input.val(); // Nuevo valor
            datos.push({
                nombreCampo: 'nota_' + alumnoId + '_' + index,
                valorOriginal: valorOriginal,
                valorNuevo: valorNuevo
            });
        });

      /*  var datos = {
            alumnoNotaEditar: alumnoId,
            LegajoNotaEditar: 0, // Asegúrate de obtener este valor adecuadamente
            materiaEditar: fila.find('#materiaEditar').text(),
            anioMateriaEditar: fila.find('#anioMateriaEditar').text(),
            estadoMateriaEditar: 0, // Asegúrate de obtener este valor adecuadamente
            parcial1Editar: fila.find('#parcial1Editar input').val(),
            recuperatorio1Editar: fila.find('#recuperatorio1Editar input').val(),
            parcial2Editar: fila.find('#parcial2Editar input').val(),
            recuperatorio2Editar: fila.find('#recuperatorio2Editar input').val(),
            finalnotaEditar: fila.find('#finalnotaEditar input').val(),
            idCursada: idCursada
        };*/

        $.ajax({
            url: "/instituto/Includes/sqluser.php", // Reemplaza con la ruta correcta a tu archivo PHP
            type: 'POST',
            data: {
                alumnoId: alumnoId,
                idCursada: idCursada,
                data: datos, // Envía los datos como un objeto
            },
            success: function(response) {
                // Verificar la respuesta del servidor
                if (response.success) {
                    // Cerrar el modal
                    $('#modalNotaUpdate').modal('hide');

                    // Mostrar mensaje de éxito
                    Swal.fire({
                        icon: 'success',
                        title: 'Datos guardados exitosamente',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function() {
                        window.location.reload();
                    });
                } else {
                    // Mostrar mensaje de error
                    Swal.fire({
                        icon: 'error',
                        title: 'Error al guardar los datos',
                        text: response.message
                    });
                }
            },
            error: function(error) {
                console.log("Error en la solicitud AJAX:", error);
            }
        });

        // Restaura el formato original de las celdas con la clase "editable"
        fila.find('td.editable').each(function(index) {
            var input = $(this).find('input');
            input.replaceWith(datos[index].valorOriginal);
        });

        // Elimina el botón "Guardar"
        fila.find('td:last').html('<button class="edit-button">Editar</button>');
    });
});
</script>