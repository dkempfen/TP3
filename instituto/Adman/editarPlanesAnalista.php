<?php
require_once 'includes/header.php';
require_once '../Includes/load.php';
?>

<div class="modal fade" id="editarTarjeta1Modal" tabindex="-1" role="dialog" aria-labelledby="editarTarjeta1ModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editarTarjeta1ModalLabel">Editar Tarjeta 1</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Aquí puedes agregar los campos de edición, como inputs, select, etc. -->
                <div class="form-group">
                    <label for="nombreTarjeta1">Nombre:</label>
                    <input type="text" class="form-control" id="nombreTarjeta1" placeholder="Nombre del plan">
                </div>
                <div class="form-group">
                    <label for="estadoTarjeta1">Estado:</label>
                    <input type="text" class="form-control" id="estadoTarjeta1" placeholder="Estado del plan">
                </div>
                <div class="form-group">
                    <label for="fechaInicioTarjeta1">Fecha Inicio:</label>
                    <input type="text" class="form-control" id="fechaInicioTarjeta1" placeholder="Fecha de inicio">
                </div>
                <div class="form-group">
                    <label for="fechaFinalTarjeta1">Fecha Final:</label>
                    <input type="text" class="form-control" id="fechaFinalTarjeta1" placeholder="Fecha de finalización">
                </div>
                <!-- Agrega más campos de edición según tus necesidades -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary">Guardar Cambios</button>
            </div>
        </div>
    </div>
</div>

<?php
require_once 'includes/footer.php';
?>
