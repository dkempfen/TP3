<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Includes/load.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Adman/Pantallas/Notas.php';



$DatosAlumnoNota = DatosAlumnoNota();
$DatosMateria =DatosMateria();

?>


<?php 


 ?>
<!-- Agregar jQuery y Select2 -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Modal de Alta de Nota -->
<?php foreach ($DatosAlumnoNota as $alumnos); foreach ($DatosMateria as $materia)  { ?>

<div class="modal fade" id="modalAltaNota" tabindex="-1" role="dialog" aria-labelledby="modalAltaNotaLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header headerRegisterNota">
                <h5 class="modal-title" id="modalAltaNota">Alta de Nota</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Agrega aquí los campos para ingresar los datos de la nota -->
                <form id="formAltaNota" name="formAltaNota" action="/instituto/Includes/slqeditar.php" method="POST">
                    <!-- Campos para la alta de nota -->

                    <input type="hidden" name="id_Cursada" id="id_Cursada"
                        value="<?php  echo $DatosAlumnoNota['id_Cursada']?>">

                    <div class="form-group">
                        <label for="alumnoNota">Alumno</label>
                        <select id="alumnoNota" name="alumnoNota" class="form-control">
                            <option value="">--Seleccione--</option>

                            <?php
                            $alumnos = DatosAlumnoNota(); // Obtén la lista de alumnos desde tu función

                            foreach ($alumnos as $alumnos) {
                                echo '<option value="' . $alumnos['Id_Usuario'] . '">' . $alumnos['Nombre'] . ' ' . $alumnos['Apellido'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="LegajoNota">Legajo</label>
                        <input type="text" id="LegajoNota" name="LegajoNota" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label for="materia">Materia</label>
                        <select id="materia" name="materia" class="form-control">
                            <option value="">--Seleccione--</option>

                            <?php
                            $materia = DatosMateria(); // Obtén la lista de alumnos desde tu función

                            foreach ($materia as $materia) {
                                echo '<option value="' . $materia['id_Materia'] . '">' . $materia['Descripcion'] . ' ' . $materia[''] . '</option>';
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="anioMateria">Año Materia</label>
                        <input type="text" id="anioMateria" name="anioMateria" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label for="estadoMateria">Estado Materia</label>
                        <input type="text" id="estadoMateria" name="estadoMateria" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label for="parcial1">1er Parcial</label>
                        <input type="number" class="form-control" id="parcial1" name="parcial1" required>
                    </div>
                    <div class="form-group">
                        <label for="recuperatorio1">1 Recuperatorio</label>
                        <input type="number" class="form-control" id="recuperatorio1" name="recuperatorio1" required>
                    </div>
                    <div class="form-group">
                        <label for="parcial2">2 Parcial</label>
                        <input type="number" class="form-control" id="parcial2" name="parcial2" required>
                    </div>
                    <div class="form-group">
                        <label for="recuperatorio2">2 Recuperatorio</label>
                        <input type="number" class="form-control" id="recuperatorio2" name="recuperatorio2" required>
                    </div>

                    <div class="form-group">
                        <label for="finalnota">Final</label>
                        <input type="number" class="form-control" id="finalnota" name="finalnota" required>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button id="btnAbrirModalAltaNota" class="btn btn-primary" name="btnaltaNota">Guardar</button>
            </div>
        </div>
    </div>
</div>
<?php } ?>
<script>
function isValidInput(value) {
    return value.trim() !== '';
}

function openModalNota() {


    console.log('Abrir modal'); // Agrega este log para verificar si se llama a la función

    // Abre el modal "Alta de Nota"
    $('#modalAltaNota').modal('show');

    // Resetea el formulario de alta de nota si es necesario
    document.getElementById('formAltaNota').reset();
}
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
                // Llena el campo "LegajoNota" con la respuesta del servidor
                $('#LegajoNota').val(response);
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
                // Llena el campo "anioMateria" con la respuesta del servidor
                $('#anioMateria').val(response);
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
                idAnio: estadoId, // El ID de la materia que deseas consultar
                accion: 'estado' // Agrega un parámetro de acción para obtener el año de la carrera
            },
            success: function(response) {
                // Llena el campo "anioMateria" con la respuesta del servidor
                $('#estadoMateria').val(response);
            },
            error: function(error) {
                console.log('Error al obtener el estado de la materia: ' + error);
            }
        });
    }
});
</script>



<script>
$(document).ready(function() {
    $('#btnAbrirModalAltaNota').on('click', function() {
        var alumnoNota = $("#alumnoNota").val();
        var LegajoNota = $("#LegajoNota").val();
        var materia = $("#materia").val();
        var anioMateria = $("#anioMateria").val()
        var estadoMateria = $("#estadoMateria").val()
        var parcial1 = $("#parcial1").val();
        var recuperatorio1 = $("#recuperatorio1").val();
        var parcial2 = $("#parcial2").val();
        var recuperatorio2 = $("#recuperatorio2").val();
        var finalnota = $("#finalnota").val();
        var id_Cursada = $("#id_Cursada").val();

        $.ajax({
            url: '/instituto/Includes/slqeditar.php',
            type: 'POST',
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
                finalnota: finalnota,
                id_Cursada: id_Cursada,
                btnaltaNota: 0
            },
            success: function(response) {
                if (response === 'success') {
                    $('#modalAltaNota').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Datos guardados exitosamente',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function() {
                        window.location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error al guardar las notas',
                        text: response.message

                    });
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log('Error en la solicitud AJAX:');
                console.log('jqXHR:', jqXHR);
                console.log('Status:', textStatus);
                console.log('Error:', errorThrown);
            }
        });
    });
});
</script>