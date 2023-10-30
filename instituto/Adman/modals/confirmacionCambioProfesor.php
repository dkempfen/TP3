<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistemas/instituto/Includes/load.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistemas/instituto/Adman/lista_materia.php';


?>

<!-- ... Resto del código ... -->
<div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="formMateriaProfesor" name="formMateriaProfesor" action="/sistemas/instituto/Includes/slqeditar.php" method="POST">
                <input type="hidden" name="profesorId" id="profesorId" value="-1">
                <input type="hidden" name="materiaId" id="materiaId" value="-1">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmModalLabel">Confirmar Cambio</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    ¿Desea cambiar el profesor seleccionado a este nuevo valor?
                    <br>
                    Profesor seleccionado:
                    <?php
                    if (isset($_SESSION['profesorSeleccionado'])) {
                        // Muestra el nombre del profesor seleccionado
                        echo $_SESSION['profesorSeleccionado'];
                    } else {
                        echo "No se ha seleccionado un profesor.";
                    }
                    ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary" name="btnProfesorMateria">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Obtener los valores de materiaId y profesorId y mostrarlos en el modal
$('#formMateriaProfesor').on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget);
    var profesorId = button.data('profesorid'); // Obtiene el ID del profesor
    var materiaId = button.data('materiaid'); // Obtiene el ID de la materia
    var profesorSeleccionadoId = 123; // Reemplaza con el ID real del profesor seleccionado

    // Actualiza el valor del campo profesorId
    $('#profesorId').val(profesorSeleccionadoId);

    $('#materiaId').val(materiaId);

    // También puedes mostrar el nombre del profesor seleccionado
    var profesorSeleccionado = button.data('profesorseleccionado');
    $('#profesorSeleccionado').text(profesorSeleccionado);
});
</script>