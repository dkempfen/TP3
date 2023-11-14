<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Includes/load.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Adman/Pantallas/finales.php';

$DatosMateriaDetalle=DatosMateriaDetalle();
$DatosAlumnoNota = DatosAlumnoNota();
$DatosMateria = DatosMateria();
$Plan = Plan();


?>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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
                        <label for="materiaFinal">Materia</label>
                        <select id="materiaFinal" name="materiaFinal" class="form-control" style="margin-bottom: 10px;">
                            <option value="">--Seleccione--</option>
                            <?php foreach ($DatosMateria as $materia) : ?>
                            <option value="<?= $materia['id_Materia'] ?>">
                                <?= $materia['Descripcion'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="anioMateriaFinal">Año Materia</label>
                        <input type="text" id="anioMateriaFinal" name="anioMateriaFinal" class="form-control" readonly>
                    </div>


                    <div class="form-group">
                        <label for="fechaFinal">Fecha de Final:</label>
                        <input type="date" class="form-control" name="fechaFinal" id="fechaFinal" required>
                    </div>
                    <div class="form-group">
                        <label for="carreraFinal">Carreras:</label>
                        <select name="carreraFinal[]" id="carreraFinal" class="form-control multiple-select" multiple>
                            <?php foreach ($Plan as $Carrera) : ?>
                            <option value="<?= $Carrera['cod_Plan'] ?>"><?= $Carrera['Carrera'] ?></option>
                            <?php endforeach; ?>
                        </select>
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

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
function ajustarAltoSelect2() {
    var numOpciones = $("#carreraFinal option").length;

    $("#carreraFinal").select2({
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
    $("#carreraFinal").append('<option value="' + valor + '">' + texto + '</option>');
    ajustarAltoSelect2();
}
</script>

<script>
function isValidInput(value) {
    return value.trim() !== '';
}

function openFinalDateModal() {
    console.log('Abrir modal'); // Puedes agregar este log para verificar si se llama a la función




    $('#finalmodal').modal('show');

    document.getElementById('formFinalDate').reset();
}


$(document).ready(function() {
    $('#materiaFinal').selectize({
        options: <?php echo json_encode($DatosMateria); ?>,
        labelField: 'Descripcion', // Nombre del campo a mostrar
        valueField: 'id_Materia', // Nombre del campo a utilizar como valor
        searchField: ['Descripcion'], // Campos para buscar
        render: {
            option: function(item) {
                return '<div>' + item.Descripcion + '</div>';
            },
        },
        create: false, // No permitir crear nuevas opciones
    });
});


$(document).ready(function() {
    $('#materiaFinal').change(function() {
        var materiaId = $(this).val();

        if (materiaId !== '') {
            obtenerAnioMateria(materiaId);
        }
    });

    function obtenerAnioMateria(materiaId) {
        $.ajax({
            url: '/instituto/Includes/funcionesLegajo.php', // Ruta correcta al archivo PHP
            type: 'POST',
            data: {
                idAnio: materiaId, // El ID de la materia que deseas consultar
                accion: 'anio' // Agrega un parámetro de acción para obtener el año de la carrera
            },
            success: function(response) {
                var anioSinEspacios = response.trim();

                // Llena el campo "anioMateria" con la respuesta del servidor
                $('#anioMateriaFinal').val(anioSinEspacios);
            },
            error: function(error) {
                console.log('Error al obtener el año de la materia: ' + error);
            }
        });
    }
});
</script>