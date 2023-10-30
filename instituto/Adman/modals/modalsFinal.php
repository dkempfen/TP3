<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistemas/instituto/Includes/load.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistemas/instituto/Adman/Pantallas/finales.php';




?>


<div class="modal fade" id="finalmodal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title fs-5" id="tituloModal">Agregar Fecha de Final</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formFinalDate" name="formFinalDate" action="/tu_ruta_para_guardar_la_fecha" method="POST">
                    <div class="form-group">
                        <label for="materia">Materia:</label>
                        <input type="text" class="form-control" name="materia" id="materia" required>
                    </div>
                    <div class="form-group">
                        <label for="nivel">Nivel:</label>
                        <input type="text" class="form-control" name="nivel" id="nivel" required>
                    </div>
                    <div class="form-group">
                        <label for="fechaFinal">Fecha de Final:</label>
                        <input type="date" class="form-control" name="fechaFinal" id="fechaFinal" required>
                    </div>
                    <div class="form-group">
                        <label for="plan">Plan:</label>
                        <input type="text" class="form-control" name="plan" id="plan" required>
                    </div>
                    <div class="form-group">
                        <label for="carrera">Carreras:</label>
                        <select class="form-control" name="carrera[]" id="carrera" multiple required>
                            <option value="Analista de Sistemas">Analista de Sistemas</option>
                            <option value="Redes Informáticas">Redes Informáticas</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Carreras seleccionadas:</label>
                        <ul id="carreras-seleccionadas">
                            <!-- Aquí se mostrarán las carreras seleccionadas -->
                        </ul>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button class="btn btn-primary" id="btnGuardarFechaFinal" onclick="guardarFechaFinal()">Guardar</button>
            </div>
        </div>
    </div>
</div>
<!-- Agrega SweetAlert2 y jQuery a tu página -->


<script>
function isValidInput(value) {
    return value.trim() !== '';
}

function openFinalDateModal() {
    console.log('Abrir modal'); // Puedes agregar este log para verificar si se llama a la función




    $('#finalmodal').modal('show');

    document.getElementById('formFinalDate').reset();
}
</script>

<script>
var select = document.getElementById('carrera');
var carrerasSeleccionadasList = document.getElementById('carreras-seleccionadas');

select.addEventListener('dblclick', function(e) {
    var selectedOption = e.target.options[e.target.selectedIndex];
    if (selectedOption) {
        var carrera = selectedOption.value;
        
        // Verificar si la carrera ya se ha seleccionado
        var carreraExistente = document.querySelector(`#carreras-seleccionadas li[data-value="${carrera}"]`);
        if (!carreraExistente) {
            var li = document.createElement('li');
            li.setAttribute('data-value', carrera);
            li.textContent = carrera;
            carrerasSeleccionadasList.appendChild(li);
        }
    }
});
</script>