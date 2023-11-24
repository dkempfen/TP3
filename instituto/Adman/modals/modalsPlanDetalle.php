<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Includes/load.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Adman/lista_planes.php';

$obtenerFinales = obtenerFinales();
$DatosMateriaDetalle=DatosMateriaDetalle();
$DatosAlumnoNota = DatosAlumnoNota();
$DatosMateria = DatosMateria();


?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<?php 


foreach ($obtenerDetallesPlan as $obtenerDetallesPlan) { ?>
<div class="modal fade" id="modaleditarFechaFinals_<?php echo $obtenerDetallesPlan['Id_Detalle_Plan']; ?>" tabindex="-1"
    role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header headerEditarFechaFinal">
                <h5 class="modal-title fs-5" id="tituloModalEditarFechaFinal">Editar Fecha Final</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formEditarFechaFinal" name="formEditarFechaFinal" action="/instituto/Includes/slqeditar.php"
                    method="POST">



                    <input type="hidden" name="FechaFinaleditarId" id="FechaFinaleditarId"
                        value="<?php echo $obtenerFinales['Id_Detalle_Plan'] ?>">

                    <input type="hidden" name="idMateriaActualFecha" id="idMateriaActualFecha"
                        value="<?php echo $obtenerFinales['fk_Materia'] ?>">

                    <!--<div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="nombreMateriaeditar">Materia actual:</label>
                            <input type="text" class="form-control" name="nombreMateriaeditar" id="nombreMateriaeditar"
                                value="<?php echo $obtenerFinales['Descripcion']; ?>" readonly>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="materiaFinalNueva">Seleccione la nueva materia:</label>
                            <select id="materiaFinalNueva" name="materiaFinalNueva" class="form-control">
                                <option value="">--Seleccione--</option>
                                <?php foreach ($DatosMateria as $materia) : ?>
                                <option value="<?= $materia['id_Materia'] ?>">
                                    <?= $materia['Descripcion'] ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>-->
                    <div class="form-group">
                        <label for="FechaFinalEditar">Fecha:</label>
                        <input type="date" class="form-control" name="FechaFinalEditar" id="FechaFinalEditar"
                            value="<?php echo $obtenerFinales['Fecha']; ?>">

                    </div>


                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button id="btnActionEditarFormMateria" class="btn btn-primary btn-open-modal" type="submit"
                            name="btnmodificarFechaFInal">
                            <span id="btnEditarFechaFinal">Guardar</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php } ?>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
function ajustarAltoSelect2() {
    var numOpciones = $("#materiaFinalNueva option").length;

    $("#materiaFinalNueva").select2({
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
    $("#materiaFinalNueva").append('<option value="' + valor + '">' + texto + '</option>');
    ajustarAltoSelect2();
}
</script>

<script>
function isValidInput(value) {
    return value.trim() !== '';
}

function mostrarInfoAdicionals(Id_Fecha_Final) {
    document.getElementById('FechaFinaleditarId').value = "";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerEditarFechaFinal");
    document.getElementById('btnEditarFechaFinal').classList.replace("btn-info", "btn-open-modal");
    document.getElementById('btnEditarFechaFinal').innerHTML = 'Guardar';
    document.getElementById('tituloModalEditarFechaFinal').innerHTML = 'Editar Fecha Final';
    document.getElementById('formEditarFechaFinal').reset();
    var Id_Fecha_Final = "#modaleditarFechaFinals_" + Id_Fecha_Final;
    $(Id_Fecha_Final).modal('show');

}

(document).ready(function() {

    // Evento al enviar el formulario de edición de usuario
    $("#formEditarFechaFinal").on("submit", function(event) {
        event.preventDefault();

        // Obtener los valores del formulario
        var FechaFinaleditarId = $("#FechaFinaleditarId").val();
        var materiaFinalNueva = $("#materiaFinalNueva").val();
        var FechaFinalEditar = $("#FechaFinalEditar").val();
        var idMateriaActualFecha = $("#idMateriaActualFecha").val();







        // Realizar la petición AJAX para actualizar el usuario
        $.ajax({
            url: "/instituto/Includes/slqeditar.php",
            type: "POST",
            data: {
                FechaFinaleditarId: FechaFinaleditarId,
                materiaFinalNueva: materiaFinalNueva,
                FechaFinalEditar: FechaFinalEditar,
                idMateriaActualFecha: idMateriaActualFecha,
                btnmodificarFechaFInal: 0 // Agrega una marca para indicar que es una solicitud de modificación
            },
            success: function(response) {
                // Verificar la respuesta del servidor
                if (response.success) {
                    // Mostrar mensaje de éxito
                    Swal.fire({
                        icon: 'success',
                        title: 'Datos actualizados exitosamente',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function() {
                        window.location.reload();
                    });
                } else {
                    // Mostrar mensaje de error
                    Swal.fire({
                        icon: 'error',
                        title: 'Error al actualizar los datos',
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