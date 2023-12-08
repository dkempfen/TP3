<div class="modal fade" id="crearNuevoPlanBtn">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Crear Nuevo Plan</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="nuevoPlanForm">
                    <div class="form-group">
                        <label for="carrera">Carrera:</label>
                        <select class="form-control" id="carrera">
                            <option value="Analista de Sistemas">Analista de Sistemas</option>
                            <option value="Redes Informáticas">Redes Informáticas</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nombrePlan">Nombre del Plan:</label>
                        <input type="text" class="form-control" id="nombrePlan">
                    </div>
                    <div class="form-group">
                        <label for="fechaInicio">Fecha de Inicio:</label>
                        <input type="date" class="form-control" id="fechaInicio">
                    </div>
                    <div class="form-group">
                        <label for="fechaFinal">Fecha de Finalización:</label>
                        <input type="date" class="form-control" id="fechaFinal">
                    </div>
                    <div class="form-group">
                        <label for="estado">Estado del Plan:</label>
                        <select class="form-control" id="estado">
                            <option value="Activo">Activo</option>
                            <option value="Inactivo">Inactivo</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="guardarNuevoPlan()">Guardar</button>
            </div>
        </div>
    </div>
</div>


<script>
function mostrarCrearNuevoPlan() {
    // Obtener los valores del formulario
    const carrera = document.getElementById("carrera").value;
    const nombrePlan = document.getElementById("nombrePlan").value;
    const fechaInicio = document.getElementById("fechaInicio").value;
    const fechaFinal = document.getElementById("fechaFinal").value;
    const estado = document.getElementById("estado").value;
    var modal = document.getElementById("crearNuevoPlanModal");
    
    // Muestra el modal utilizando Bootstrap
    $('#crearNuevoPlanBtn').modal("show");

    document.getElementById("nuevoPlanForm").reset();
}
</script>