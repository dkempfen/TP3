<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Includes/load.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Adman/Pantallas/Notas.php';

$DatosAlumnoNota = DatosAlumnoNota();
$DatosMateria = DatosMateria();
$DatosMateriaDetalle =DatosMateriaDetalle();
$DatosMateriaDetalleAgregar = DatosMateriaDetalleAgregar();
?>
<!-- Agregar jQuery y Select2 -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Modal de Alta de Nota -->

<?php foreach ($DatosAlumnoNota as $alumno) ; foreach ($DatosMateriaDetalle as $DatosMateriaDetalle) { ?>
<div class="modal fade" id="modalAgregarNota_<?php echo $DatosMateriaDetalle['id_Cursada']; ?>" tabindex="-1"
    role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header headerNota">
                <h5 class="modal-title" id="tituloModalAgregarNota">Agregar Nota</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formAgregarNota" name="formAgregarNota" action="/instituto/Includes/sqluser.php"
                    method="POST">

                    <input type="hidden" name="agregarNota" id="agregarNota"
                        value="<?php  echo $DatosMateriaDetalle['id_Cursada']?>">

                    <!--<input type="hidden" name="alumnoNotaagregar" id="alumnoNotaagregar"
                        value="<?php  echo $DatosMateriaDetalle['Id_Usuario']?>">-->

                    <div class="form-group" style="display: none;">
                        <label for="idMateriaEditar">Id Materia:</label>
                        <input type="number" class="form-control" name="idMateriaEditar" id="idMateriaEditar"
                            value="<?php  echo $DatosMateriaDetalle['id_Cursada']?>" required>
                    </div>

                    <div class="form-group" style="display: none;">
                        <label for="alumnoEditarNota">Id Alumno</label>
                        <input type="number" class="form-control" name="alumnoEditarNota" id="alumnoEditarNota"
                            value="<?= $DatosMateriaDetalle['Id_Usuario'] ?>"
                            placeholder="<?= $DatosMateriaDetalle['Nombre'] . ' ' . $DatosMateriaDetalle['Apellido'] ?>">
                    </div>

                    <div class="form-group">
                        <label for="alumnoNombre">Alumno</label>
                        <input type="text" class="form-control" name="alumnoNombre" id="alumnoNombre"
                            value="<?= $DatosMateriaDetalle['Nombre'] . ' ' . $DatosMateriaDetalle['Apellido'] ?>">
                    </div>

                    <div class="form-group" style="display: none;">
                        <label for="LegajoNotaEditar">Legajo</label>
                        <input type="text" id="LegajoNotaEditar" name="LegajoNotaEditar" class="form-control"
                            value="<?php  echo $DatosMateriaDetalle['fk_Legajo']?>">
                    </div>

                    <div class="form-group" style="display: none;">
                        <label for="materiaEditar">ID Materia</label>
                        <input type="number" class="form-control" name="materiaEditar" id="materiaEditar"
                            value="<?php  echo $DatosMateriaDetalle['id_Materia']?>">
                    </div>

                    <div class="form-group">
                        <label for="materiaNombre">Materia</label>
                        <input type="text" class="form-control" name="materiaNombre" id="materiaNombre"
                            value="<?php  echo $DatosMateriaDetalle['Descripcion']?>">
                    </div>


                    <div class="form-group" style="display: none;">
                        <label for="anioMateriaEditar">Año Materia</label>
                        <input type="text" id="anioMateriaEditar" name="anioMateriaEditar" class="form-control"
                            value="<?php  echo $DatosMateriaDetalle['Anio']?>">
                    </div>

                    <div class="form-group" style="display: none;">
                        <label for="estadoMateriaEditar">Estado Materia</label>
                        <input type="text" id="estadoMateriaEditar" name="estadoMateriaEditar" class="form-control"
                            value="<?php  echo $DatosMateriaDetalle['fk_Estado']?>">
                    </div>

                    <div class="form-group">
                        <label for="parcial1Editar">1er Parcial</label>
                        <input type="number" class="form-control" id="parcial1Editar" name="parcial1Editar"
                            value="<?php  echo $DatosMateriaDetalle['Primer_Parcial']?>">
                    </div>

                    <div class="form-group">
                        <label for="recuperatorio1Editar">1 Recuperatorio</label>
                        <input type="number" class="form-control" id="recuperatorio1Editar" name="recuperatorio1Editar"
                            value="<?php  echo $DatosMateriaDetalle['Recuperatio_Parcial_1']?>">

                    </div>

                    <div class="form-group">
                        <label for="parcial2Editar">2 Parcial</label>
                        <input type="number" class="form-control" id="parcial2Editar" name="parcial2Editar"
                            value="<?php  echo $DatosMateriaDetalle['Segundo_Parcial']?>">

                    </div>

                    <div class="form-group">
                        <label for="recuperatorio2Editar">2 Recuperatorio</label>
                        <input type="number" class="form-control" id="recuperatorio2Editar" name="recuperatorio2Editar"
                            value="<?php  echo $DatosMateriaDetalle['Recuperatio_Parcial_2']?>">
                    </div>

                    <div class="form-group">
                        <label for="finalnotaEditar">Final</label>
                        <input type="number" class="form-control" id="finalnotaEditar" name="finalnotaEditar"
                            value="<?php  echo $DatosMateriaDetalle['Final']?>">
                    </div>



                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button id="btnActionAltaPlan" class="btn btn-primary btn-open-modal" type="submit"
                            name="btnmCrearNotaEditar">
                            <span id="btnCrearNotaEditar">Guardar</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php } ?>

<script>
function isValidInput(value) {
    return value.trim() !== '';
}

// Función para abrir el modal de Alta de Nota
function openModalAgregarMasNota(id_Cursada) {
    console.log('Abrir modal');

    document.getElementById('agregarNota').value = "";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerNota");
    document.getElementById('btnCrearNotaEditar').classList.replace("btn-info", "btn-open-modal");
    document.getElementById('btnCrearNotaEditar').innerHTML = 'Guardar';
    document.getElementById('tituloModalAgregarNota').innerHTML = 'Agregar Nota';
    document.getElementById('formAgregarNota').reset();
    var id_Cursada = "#modalAgregarNota_" + id_Cursada;
    $(id_Cursada).modal('show');



}
(document).ready(function() {

    $('#formAgregarNota').on('submit', function(event) {
        event.preventDefault(); //
        console.log('Botón Guardar clickeado');
        var alumnoNotaagregar = $("#alumnoNotaagregar").text(); // Usar "dniUser" en lugar de "dni"
        var materiaEditar = $("#materiaEditar").val();
        var anioMateriaEditar = $("#anioMateriaEditar").val();
        var estadoMateriaEditar = $("#estadoMateriaEditar").val();
        var parcial1Editar = $("#parcial1Editar").val();
        var recuperatorio1Editar = $("#recuperatorio1Editar").val();
        var parcial2Editar = $("#parcial2Editar").val();
        var recuperatorio2Editar = $("#recuperatorio2Editar").val();
        var finalnotaEditar = $("#finalnotaEditar").val();
        var agregarNota = $("#agregarNota").val();
        var alumnoEditarNota = $("#alumnoEditarNota").val();
        var idMateriaEditar = $("#idMateriaEditar").val()





        // Realizar la petición AJAX para insertar o actualizar datos
        $.ajax({
            url: "/instituto/Includes/sqluser.php", // Reemplaza con la ruta correcta a tu archivo PHP
            type: "POST",
            data: {
                idMateriaEditar: idMateriaEditar,
                agregarNota: agregarNota,
                alumnoNotaagregar: alumnoNotaagregar,
                alumnoEditarNota: alumnoEditarNota,
                LegajoNotaEditar: LegajoNotaEditar,
                materiaEditar: materiaEditar,
                anioMateriaEditar: anioMateriaEditar,
                estadoMateriaEditar: estadoMateriaEditar,
                parcial1Editar: parcial1Editar,
                recuperatorio1Editar: recuperatorio1Editar,
                parcial2Editar: parcial2Editar,
                recuperatorio2Editar: recuperatorio2Editar,
                finalnotaEditar: finalnotaEditar,

                btnmCrearNotaEditar: 0
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