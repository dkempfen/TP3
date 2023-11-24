<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Adman/includes/header.php';

require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Includes/load.php';
// Verificar si hay fechas activas

if (isset($_SESSION['messageFinCursada'])) {
    $messageFinCursada = $_SESSION['messageFinCursada'];
    unset($_SESSION['messageFinCursada']); // Clear the session variable after displaying the message
    showConfirmationMessageFechaFinCursada($messageFinCursada);
}

?>

<link href="https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css" rel="stylesheet">

<main class="app-content">

    <div class="app-title">
        <h1><i class="fa fa-dashboard"></i>Home</h1>
    </div>



    <div id="filter-container" class="filter-container">
        <div class="filter-inputs">
            <label for="fecha_desde">Desde:</label>
            <input type="date" id="fecha_desde" name="fecha_desde">
        </div>
        <div class="filter-inputs">
            <label for="fecha_hasta">Hasta:</label>
            <input type="date" id="fecha_hasta" name="fecha_hasta">
        </div>
        <div class="filter-inputs">
            <label for="titulo">Título:</label>
            <input type="text" id="titulo" name="titulo">
            <button id="btn_buscar">Buscar</button>
        </div>
        <div class="new-publication-button">
            <button class="btn btn-primary rounded-pill" type="button" onclick="openModaArchivos()">
                <i class="fas fa-plus-circle mr-2"></i>Nueva Publicación
            </button>
        </div>
    </div>


    <div class="row">
        <div id="container">
            <div id="table-container">
                <table id="my-table">
                    <thead>
                        <tr>
                            <th>Fechas finales</th>
                        </tr>
                    </thead>
                    <tbody id="dateRows1">
                        <tr>
                            <td>
                                <?php
                                // Llamar a la función para obtener el estado
                                $estado = obtenerEstadoToggleAll();

                                // Mostrar mensaje según el estado
                                if ($estado == 1) {
                                    echo "Las fechas están activas";
                                } else {
                                    echo "No hay fechas activas";
                                }
                                ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="row" id="aranceles-container">
        <div id="container">
            <div id="table-container">
                <table id="my-table">
                    <thead>
                        <tr>
                            <th>Aranceles</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody id="dateRows1">
                        <?php
                    // Comprueba si la consulta fue exitosa
                    $rowDatosAranceles = buscarAranceles();
                    if ($rowDatosAranceles) {
                        // Loop a través del resultado y generar filas de la tabla
                        foreach ($rowDatosAranceles as $rowDatosAranceles) {
                            echo '<tr>';
                            echo '<td>';
                            // Agrega un enlace para descargar el archivo
                            echo '<a href="/' . $rowDatosAranceles['Descripcion_Documentacion'] . '" download>' . $rowDatosAranceles['Descripcion_Documentacion'] . '</a>';
                            echo '</td>';
                            echo '<td>' . $rowDatosAranceles['fecha_documentacion'] . '</td>';
                            echo '</tr>';
                        }
                    } else {
                        echo '<tr><td colspan="2"><p style="font-size: 18px; color: #333;">Sin datos que mostrar</p></td></tr>';
                    }
                    ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row">
        <div id="container">
            <div id="table-container">
                <table id="my-table">
                    <thead>
                        <tr>
                            <th>Fecha Fiesta Fin de Cursada</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                  $rowfechaFinCursada = fechaFinCursada();
                  if ($rowfechaFinCursada) {
                      // Loop a través del resultado y generar filas de la tabla
                      foreach ($rowfechaFinCursada as $rowfechaFinCursada) {
                          echo '<tr>';
                          echo '<td id="fechaFinCursada_' . $rowfechaFinCursada['id'] . '" contenteditable="false">' . $rowfechaFinCursada['fecha_fin_cursada'] . '</td>';
                          echo '<td>';
                          echo '<button class="btn-icon" onclick="habilitarEdicionFecha(' . $rowfechaFinCursada['id'] . ')"><i class="edit-btn"></i>✏️</button>';
                          echo '<button class="btn-icon guardar-btn d-none" id="guardarFechaBtn_' . $rowfechaFinCursada['id'] . '" name="btnActualizarFecha" onclick="actualizarFecha(' . $rowfechaFinCursada['id'] . ')"><i class="mdi mdi-content-save" style="margin-left: 10px; font-size: 20px;"></i></button>';
                          echo '<button class="btn-icon cerrar-btn d-none" id="cerrarFechaBtn_' . $rowfechaFinCursada['id'] . '" onclick="cerrarEdicionFecha(' . $rowfechaFinCursada['id'] . ')"><i class="close-btn" style="margin-left: 10px; font-size: 20px;"></i>❌</button>';
                          echo '</td>';
                          echo '</tr>';
                      }
                  } else {
                      echo '<tr><td colspan="2"><p style="font-size: 18px; color: #333;">Sin datos que mostrar</p></td></tr>';
                  }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <?php
    require_once '../includes/footer.php';


    ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
    function habilitarEdicionFecha(idFecha) {
        // Obtén el elemento td correspondiente a la fecha
        var tdFecha = document.getElementById('fechaFinCursada_' + idFecha);

        // Habilita la edición cambiando el atributo contenteditable a true
        tdFecha.contentEditable = true;

        // Puedes agregar estilos adicionales para indicar que el campo es editable
        tdFecha.style.border = '1px solid blue';
        tdFecha.style.backgroundColor = '#f0f8ff'; // Un tono de azul claro

        // Muestra el botón de guardar correspondiente a este campo
        var guardarBtn = document.getElementById('guardarFechaBtn_' + idFecha);
        guardarBtn.classList.remove('d-none');

        // Muestra el botón de cerrar correspondiente a este campo
        var cerrarBtn = document.getElementById('cerrarFechaBtn_' + idFecha);
        cerrarBtn.classList.remove('d-none');
    }

    function cerrarEdicionFecha(idFecha) {
        // Obtén el elemento td correspondiente a la fecha
        var tdFecha = document.getElementById('fechaFinCursada_' + idFecha);

        // Deshabilita la edición cambiando el atributo contenteditable a false
        tdFecha.contentEditable = false;

        // Restaura los estilos originales o elimina los estilos adicionales
        tdFecha.style.border = '';
        tdFecha.style.backgroundColor = '';

        // Oculta el botón de guardar correspondiente a este campo
        var guardarBtn = document.getElementById('guardarFechaBtn_' + idFecha);
        guardarBtn.classList.add('d-none');

        // Oculta el botón de cerrar correspondiente a este campo
        var cerrarBtn = document.getElementById('cerrarFechaBtn_' + idFecha);
        cerrarBtn.classList.add('d-none');
    }

    function actualizarFecha(idFecha) {
        // Obtén el nuevo valor de la fecha
        var nuevoValorFecha = document.getElementById('fechaFinCursada_' + idFecha).innerText;

        // Realiza una solicitud AJAX para actualizar la fecha en la base de datos
        // Aquí deberías implementar la lógica para enviar la nueva fecha al servidor

        // Después de actualizar la fecha, cierra la edición
        cerrarEdicionFecha(idFecha);

        // Obtén el elemento td correspondiente al asunto
        var tdFecha = document.getElementById('fechaFinCursada_' + idFecha);

        // Obtén el nuevo valor del asunto
        var nuevoValorFecha = tdFecha.innerText;

        // Deshabilita la edición cambiando el atributo contenteditable a false
        tdFecha.contentEditable = false;

        // Puedes quitar los estilos adicionales si lo deseas
        tdFecha.style.border = 'none';
        tdFecha.style.backgroundColor = 'transparent';

        // Oculta el botón de guardar correspondiente a este campo
        var guardarBtn = document.getElementById('guardarFechaBtn_' + idFecha);
        guardarBtn.classList.add('d-none');

        $.ajax({
            url: "/instituto/Includes/sql.php",
            type: "POST",
            data: {
                idFecha: idFecha,
                nuevoValorFecha: nuevoValorFecha,
                btnActualizarFecha: 0
            },
            success: function(response) {
                // Verificar la respuesta del servidor
                if (response.success) {
                    // Actualizar el contenido del td con el nuevo asunto
                    tdAsunto.innerText = nuevoValorFecha;
                } else {
                    // Mostrar mensaje de error
                    /* Swal.fire({
                         icon: 'error',
                         title: 'Error al guardar los datos',
                         text: response.message
                     });*/
                }
            },
            error: function(error) {
                console.log("Error en la solicitud AJAX:", error);
            },
            complete: function() {
                // Recargar la página inmediatamente después de la actualización
                location.reload();
            }
        });
    }
    </script>