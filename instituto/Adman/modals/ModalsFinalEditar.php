<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Includes/load.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Adman/Pantallas/finales.php';

$obtenerFinales=obtenerFinales();
$Plan = Plan();

?>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<?php foreach ($obtenerFinales as $obtenerFinales) ; { ?>

<div class="modal fade" id="finalmodalEditar_<?php echo $obtenerFinales['Id_Fecha_Final']; ?>" tabindex="-1"
    role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header headerEditarFinal">
                <h5 class="modal-title fs-5" id="FechaFInalEditar">Editar Fecha de Final</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form id="formFinalDateEditar" name="formFinalDateEditar" action="/tu_ruta_para_guardar_la_fecha" method="POST">

                    <input type="hidden" name="EditarFechaFinal" id="EditarFechaFinal"
                        value="<?php  echo $obtenerFinales['Id_Fecha_Final']?>">

                    <div class="form-group">
                        <label for="materiaFinalEditar">Materia</label>
                        <input type="text" class="form-control" name="materiaFinalEditar" id="materiaFinalEditar"
                            value="<?= $obtenerFinales['Descripcion']?>">
                    </div>
                    <div class="form-group">
                        <label for="fechaFinalEditar">Fecha de Final:</label>
                        <input type="date" class="form-control" name="fechaFinalEditar" id="fechaFinalEditar" required>
                    </div>
                    <div class="form-group">
                        <label for="carreraFinalEditar">Carreras:</label>
                        <select name="carreraFinalEditar[]" id="carreraFinalEditar" class="form-control multiple-select"
                            multiple>
                            <?php foreach ($Plan as $Carrera) : ?>
                            <option value="<?= $Carrera['cod_Plan'] ?>"><?= $Carrera['Carrera'] ?></option>

                            <option value="<?= $obtenerFinales['cod_Plan'] ?>" <?= $selected ?>>
                                <?= $obtenerFinales['Carrera'] ?></option>

                            <?php endforeach; ?>
                        </select>
                    </div>


                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button id="btnActioneEditarFInal" class="btn btn-primary btn-open-modal" type="submit"
                    name="btnmFechFinalEditar">
                    <span id="btnFinalEditar">Guardar</span>
                </button>
            </div>
        </div>
    </div>
</div>
<?php } ?>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
function ajustarAltoSelect2() {
    var numOpciones = $("#carreraFinalEditar option").length;

    $("#carreraFinalEditar").select2({
        tags: true,
        tokenSeparators: [','],
        dropdownAutoWidth: true,
        width: '100%',
    });
}

// Llama a la función al cargar la página
ajustarAltoSelect2();

// Llama a la función cada vez que se agregue una nueva opción
function agregarNuevaCarrera(valor, texto) {
    $("#carreraFinalEditar").append('<option value="' + valor + '">' + texto + '</option>');
    ajustarAltoSelect2();
}
</script>

<script>
function isValidInput(value) {
    return value.trim() !== '';
}

function ModalsFinalEditar(Id_Fecha_Final) {
    console.log('Abrir modal');
    document.getElementById('EditarFechaFinal').value = "";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerEditarFinal");
    document.getElementById('btnFinalEditar').classList.replace("btn-info", "btn-open-modal");
    document.getElementById('btnFinalEditar').innerHTML = 'Guardar';
    document.getElementById('FechaFInalEditar').innerHTML = 'Editar Fecha Final';
    document.getElementById('formFinalDateEditar').reset();
    var Id_Fecha_Final = "#finalmodalEditar_" + Id_Fecha_Final;
    $(Id_Fecha_Final).modal('show');

}

(document).ready(function() {

$('#formFinalDateEditar').on('submit', function(event) {
    event.preventDefault(); //
    console.log('Botón Guardar clickeado');
    var EditarFechaFinal = $("#EditarFechaFinal").val();
    var materiaFinalEditar = $("#materiaFinalEditar").val();
    var fechaFinalEditar = $("#fechaFinalEditar").val();
    var carreraFinalEditar = $("#carreraFinalEditar").val();
  

    // Realizar la petición AJAX para insertar o actualizar datos
    $.ajax({
        url: "/instituto/Includes/sqluser.php", // Reemplaza con la ruta correcta a tu archivo PHP
        type: "POST",
        data: {
            EditarFechaFinal: EditarFechaFinal,
            materiaFinalEditar: materiaFinalEditar,
            fechaFinalEditar: fechaFinalEditar,
            carreraFinalEditar: carreraFinalEditar,
     

            btnmFechFinalEditar: 0
        },

        success: function(response) {
            // Verificar la respuesta del servidor
            if (response.success) {
                // Cerrar el modal
                $('#modalNotaAgregar').modal('hide');

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
});




});
</script>
