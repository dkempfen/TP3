<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Includes/load.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Adman/Pantallas/Notas.php';

$DatosAlumnoNota = DatosAlumnoNota();
$DatosMateria = DatosMateria();


?>
<!-- Agregar jQuery y Select2 -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Modal de Alta de Nota -->

<?php foreach ($DatosAlumnoNota as $alumno) : ?>
<?php foreach ($DatosMateria as $materia) : ?>
<div class="modal fade" id="modalCrearNota" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header headerNota">
                <h5 class="modal-title" id="tituloModalCrearNota">Alta de Nota</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formCrearNota" name="formCrearNota" action="/instituto/Includes/sqluser.php" method="POST">

                    <input type="hidden" name="idPlancrearNota" id="idPlancrearNota"
                        value="<?php  echo $materia['id_Cursada']?>">


                    <div class="form-group">
                        <label for="alumnoNota">Alumno</label>
                        <select id="alumnoNota" name="alumnoNota" class="form-control">
                            <option value="">--Seleccione--</option>
                            <?php foreach ($DatosAlumnoNota as $alumno) : ?>
                            <option value="<?= $alumno['Id_Usuario'] ?>">
                                <?= $alumno['Nombre'] . ' ' . $alumno['Apellido'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group" style="display: none;">
                        <label for="LegajoNota">Legajo</label>
                        <input type="text" id="LegajoNota" name="LegajoNota" class="form-control" readonly>
                    </div>

                    <div class="form-group">
                        <label for="materia">Materia</label>
                        <select id="materia" name="materia" class="form-control">
                            <option value="">--Seleccione--</option>
                            <?php foreach ($DatosMateria as $materia) : ?>
                            <option value="<?= $materia['id_Materia'] ?>"><?= $materia['Descripcion'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group" style="display: none;">
                        <label for="anioMateria">Año Materia</label>
                        <input type="text" id="anioMateria" name="anioMateria" class="form-control" readonly>
                    </div>




                    <div class="form-group" style="display: none;">
                        <label for="estadoMateria">Estado Materia</label>
                        <input type="text" id="estadoMateria" name="estadoMateria" class="form-control" readonly>
                    </div>

                    <div class="form-group">
                        <label for="parcial1">1er Parcial</label>
                        <input type="number" class="form-control" id="parcial1" name="parcial1">
                    </div>

                    <div class="form-group" hidden>
                        <label for="recuperatorio1">1 Recuperatorio</label>
                        <input type="number" class="form-control" id="recuperatorio1" name="recuperatorio1">
                    </div>

                    <div class="form-group" hidden>
                        <label for="parcial2">2 Parcial</label>
                        <input type="number" class="form-control" id="parcial2" name="parcial2">
                    </div>

                 
                    <div class="form-group" hidden>
                        <label for="recuperatorio2">2 Recuperatorio</label>
                        <input type="number" class="form-control" id="recuperatorio2" name="recuperatorio2">
                    </div>

                    
                    <div class="form-group" hidden>
                        <label for="promedio">Promedio</label>
                        <input type="number" class="form-control" id="promedio" name="promedio">
                    </div>

                  
                    <div class="form-group" hidden>
                        <label for="finalnota">Final</label>
                        <input type="number" class="form-control" id="finalnota" name="finalnota">
                    </div>



                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button id="btnActionAltaPlan" class="btn btn-primary btn-open-modal" type="submit"
                            name="btnmCrearNota">
                            <span id="btnCrearNota">Guardar</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>
<?php endforeach; ?>

<script>
function isValidInput(value) {
    return value.trim() !== '';
}

// Función para abrir el modal de Alta de Nota
function openModalNota() {
    console.log('Abrir modal');

    document.getElementById('idPlancrearNota').value = "";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerNota");
    document.getElementById('btnCrearNota').classList.replace("btn-info", "btn-open-modal");
    document.getElementById('btnCrearNota').innerHTML = 'Guardar';
    document.getElementById('tituloModalCrearNota').innerHTML = 'Alta Primer Nota';
    document.getElementById('formCrearNota').reset();

    $('#modalCrearNota').modal('show');


}
(document).ready(function() {

    $('#formCrearNota').on('submit', function(event) {
        event.preventDefault(); //
        console.log('Botón Guardar clickeado');
        var idPlancrearNota = $("#idPlancrearNota").text(); // Usar "dniUser" en lugar de "dni"
        var materia = $("#materia").val();
        var anioMateria = $("#anioMateria").val();
        var estadoMateria = $("#estadoMateria").val();
        var parcial1 = $("#parcial1").val();
        var recuperatorio1 = $("#recuperatorio1").val();
        var parcial2 = $("#parcial2").val();
        var recuperatorio2 = $("#recuperatorio2").val();
        var promedio = $("#promedio").val();
        var finalnota = $("#finalnota").val();

        


        // Realizar la petición AJAX para insertar o actualizar datos
        $.ajax({
            url: "/instituto/Includes/sqluser.php", // Reemplaza con la ruta correcta a tu archivo PHP
            type: "POST",
            data: {
                alumnoNota: alumnoNota,
                LegajoNota: LegajoNota,
                materia: materia,
                anioMateria: anioMateria,
                estadoMateria: estadoMateria,
                parcial1: parcial1,
                recuperatorio1: recuperatorio1,
                parcial2: parcial2,
                recuperatorio2: recuperatorio2,
                promedio: promedio,
                finalnota: finalnota,

                btnmCrearNota: 0
            },

            success: function(response) {
                // Verificar la respuesta del servidor
                if (response.success) {
                    // Cerrar el modal
                    $('#modalNotaCrear').modal('hide');

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







<script>
$(document).ready(function() {
    $('#alumnoNota').selectize({
        options: <?php echo json_encode($DatosAlumnoNota); ?>,
        labelField: 'NombreApellido',
        valueField: 'Id_Usuario',
        searchField: ['Nombre', 'Apellido'],
        create: false,
        onChange: function(value) {
            obtenerLegajoPorAlumno(value);
        }
    });

    function obtenerLegajoPorAlumno(alumnoId) {
        $.ajax({
            url: '/instituto/Includes/funcionesLegajo.php', // Ruta correcta al archivo PHP
            type: 'POST',
            data: {
                id: alumnoId, // El ID del alumno que deseas consultar
                accion: 'legajo' // Agrega un parámetro de acción para obtener el legajo
            },
            success: function(response) {
                var legajoSinEspacios = response.trim();

                // Llena el campo "LegajoNota" con la respuesta del servidor
                $('#LegajoNota').val(legajoSinEspacios);
            },
            error: function(error) {
                console.log('Error al obtener el legajo: ' + error);
            }
        });

    }


});

$(document).ready(function() {
    $('#materia').selectize({
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
    $('#materia').change(function() {
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
                $('#anioMateria').val(anioSinEspacios);
            },
            error: function(error) {
                console.log('Error al obtener el año de la materia: ' + error);
            }
        });
    }
});


$(document).ready(function() {
    $('#materia').change(function() {
        var estadoId = $(this).val();

        if (estadoId !== '') {
            obtenerEstadoMateria(estadoId);
        }
    });

    function obtenerEstadoMateria(estadoId) {
        $.ajax({
            url: '/instituto/Includes/funcionesLegajo.php', // Ruta correcta al archivo PHP
            type: 'POST',
            data: {
                idEstado: estadoId, // El ID de la materia que deseas consultar
                accion: 'estado' // Agrega un parámetro de acción para obtener el año de la carrera
            },
            success: function(response) {
                var estadoSinEspacios = response.trim();

                // Llena el campo "anioMateria" con la respuesta del servidor
                $('#estadoMateria').val(estadoSinEspacios);
            },
            error: function(error) {
                console.log('Error al obtener el estado de la materia: ' + error);
            }
        });
    }
});
</script>