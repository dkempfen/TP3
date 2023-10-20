<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Includes/load.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Adman/lista_materia.php';


?>

<!-- ... Resto del código ... -->

<div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
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
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button id="btnActionEditarFormMateria" class="btn btn-primary btn-open-modal" type="submit"
                    name="btnmodificarProfesor">
                    <span id="btnEditarProfesor">Guardar</span>
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal-body">
    
</div>