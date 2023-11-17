<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Adman/includes/header.php';

require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Includes/load.php';
// Verificar si hay fechas activas

?>


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
            <button class="btn btn-primary rounded-pill" type="button" onclick="openModalPub()">
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
                            <th>Se habilita nuevas fechas</th>
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

    <div class="row">
        <div id="container">
            <div id="table-container">
                <table id="my-table">
                    <thead>
                        <tr>
                            <th>Aranceles</th>
                            <th>Fecha</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>$</td>
                            <td>2023-09-25</td>
                            <td class="actions">
                                <span class="edit-btn">✏️</span>
                                <span class="delete-btn">🗑️</span>
                            </td>
                        </tr>

                        <!-- Agrega más filas según sea necesario -->
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
                        <tr>

                            <td>2023-09-25</td>
                            <td class="actions">
                                <span class="edit-btn">✏️</span>
                                <span class="delete-btn">🗑️</span>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php
require_once '../includes/footer.php';


?>



    <script>
    $(document).ready(function() {
        // Verificar el estado del interruptor cuando la página se carga
        var isChecked = $("#toggleAllMaterias").prop("checked");
        toggleStatusMessage(isChecked);

        // Agregar un evento de cambio al interruptor
        $("#toggleAllMaterias").on("change", function() {
            var isChecked = $(this).prop("checked");
            toggleStatusMessage(isChecked);
        });

        // Función para mostrar u ocultar el mensaje y las filas de la tabla
        function toggleStatusMessage(isChecked) {
            // Lógica para obtener el mensaje y las filas según el estado del interruptor
            $.ajax({
                url: "/instituto/Includes/sqlaltauser.php", // Ajusta la ruta a tu archivo PHP
                method: "POST",
                data: {
                    isChecked: isChecked
                },
                success: function(response) {
                    // Manejar la respuesta del servidor
                    var data = JSON.parse(response);
                    $("#dateRows1").html(data.dateRows1); // Corregir aquí
                    $("#statusMessage").text(data.message);
                },
                error: function(error) {
                    console.log("Error en la solicitud AJAX:", error);
                }
            });
        }
    });
    </script>