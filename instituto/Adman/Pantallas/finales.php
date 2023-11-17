<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Adman/includes/header.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Includes/load.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Adman/modals/modalsFinal.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Adman/modals/ModalsFinalEditar.php';
$obtenerMateriasAnalista = obtenerMateriasAnalista();
$obtenerMateriasRedes = obtenerMateriasRedes();
$obtenerFinales = obtenerFinales();
?>
<?php
$estadoToggleAllActual = obtenerEstadoToggleAll(); // Cambia esto según tu lógica
$checkedToggleAll = ($estadoToggleAllActual == 1) ? 'checked' : '';
   
$result = toggleStatusMessage($checkedToggleAll);


if ($pdo) {
    // Query para obtener todas las materias y los profesores asociados si los tienen
    $sql = "SELECT * FROM FechasFinales ff 
    INNER JOIN Materia m ON ff.fk_Materia = m.id_Materia
    INNER JOIN Detalle_Plan dp ON dp.fk_Materia = ff.fk_Materia";
    
    $result = $pdo->query($sql);
// Asegúrate de usar la misma clave de sesión en ambos lugares
if (isset($_SESSION['messageFecha'])) {
    $messageFecha = $_SESSION['messageFecha'];
    unset($_SESSION['messageFecha']); // Clear the session variable after displaying the message
    showConfirmationMessagesFechaFinal($messageFecha);
}




?>


<main class="app-content">
    <div class="container analista-container" id="containerFinalAnalista">
        <div class="button-container">
            <button class="planalta-button" onclick="openFinalDateModal()">
                <i class="fas fa-plus"></i> Agregar Fecha de Final
            </button>
            <label class="switch">
                <input id="toggleAllMaterias" class="onoffswitch-checkbox" type="checkbox" name="onoffswitch"
                    <?= $checkedToggleAll ?> onchange="toggleAllMaterias(this)">
                <span class="slider"></span>
            </label>
        </div>
    </div>

    <div class="container analista-container" id="containerFinalAnalista">
        <h2>Analista de Sistemas</h2>
        <button class="expand-button analista-button">Extender</button>
        <div class="materias-container analista-materias">
            <table id="tableFechaFinal">
                <thead>
                    <tr>
                        <th>Estado</th>
                        <th>Materia</th>
                        <th>Nivel</th>
                        <th>Fecha de Final</th>
                        <th>Plan</th>
                        <th>Editar</th>
                    </tr>
                </thead>
                <tbody id="messageFecha">
                    <?php
                    // Comprueba si la consulta fue exitosa
                    $rowFinalesAnlista = obtenerMateriasAnalista();
                    if ($rowFinalesAnlista) {
                        // Loop a través del resultado y generar filas de la tabla
                        foreach ($rowFinalesAnlista as $rowFinalesAnlista) {
                            echo '<tr>';
                            echo '<td class="">';
                            echo '<label class="switch">';
                           // Aquí agregamos un ternario para comprobar si el estado está activado o no
                            $checkedFecha = ($rowFinalesAnlista['fk_Estado_Final'] == 1) ? 'checked' : '';
                            echo '<input class="onoffswitch-checkbox" type="checkbox" name="onoffswitch" value="true" ' . $checkedFecha . ' data-fechaFinal-id="' . $rowFinalesAnlista['Id_Fecha_Final'] . '" disabled>';
                            echo '<span class="slider"></span>';
                            echo '</label>';
                            echo '<td>' . $rowFinalesAnlista['Descripcion'] . '</td>';
                            echo '<td>' . $rowFinalesAnlista['Anio_Carrera'] . '</td>';
                            echo '<td>' . $rowFinalesAnlista['Fecha'] . '</td>';
                            echo '<td>' . $rowFinalesAnlista['fk_Plan'] . '</td>';
                            echo '<td><button class="btn-icon" onclick="ModalsFinalEditar(' . $rowFinalesAnlista['Id_Fecha_Final'] . ')"><i class="edit-btn"></i>✏️</button></td>';
                            echo '</tr>';
                        }
                    } else {
                        echo "Sin datos que mostrar"; // Puedes personalizar el mensaje de error según tus necesidades
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="container redes-container" id="containerFinalRedes">
        <h2>Redes Informáticas</h2>
        <button class="expand-button redes-button">Extender</button>
        <div class="materias-container redes-materias">
            <table id="tableFechaFinal">
                <thead>
                    <tr>
                        <th>Estado</th>
                        <th>Materia</th>
                        <th>Nivel</th>
                        <th>Fecha de Final</th>
                        <th>Plan</th>
                        <th>Editar</th>
                    </tr>
                </thead>
                <tbody id="messageFecha">
                    <?php
                    // Comprueba si la consulta fue exitosa
                    $rowFinalesRedes = obtenerMateriasRedes();
                    if ($rowFinalesRedes) {
                        // Loop a través del resultado y generar filas de la tabla
                        foreach ($rowFinalesRedes as $rowFinalesRedes) {
                            echo '<tr>';
                            echo '<td class="">';
                            echo '<label class="switch">';
                           // Aquí agregamos un ternario para comprobar si el estado está activado o no
                            $checked = ($rowFinalesRedes['fk_Estado_Final'] == 1) ? 'checked' : '';
                            echo '<input class="onoffswitch-checkbox" type="checkbox" name="onoffswitch" value="true" ' . $checked . ' data-usuario-id="' . $rowFinalesRedes['Id_Fecha_Final']. '" disabled>';
                            echo '<span class="slider"></span>';
                            echo '</label>';
                            echo '<td>' . $rowFinalesRedes['Descripcion'] . '</td>';
                            echo '<td>' . $rowFinalesRedes['Anio_Carrera'] . '</td>';
                            echo '<td>' . $rowFinalesRedes['Fecha'] . '</td>';
                            echo '<td>' . $rowFinalesRedes['fk_Plan'] . '</td>';
                            echo '<td><button class="btn-icon" onclick="ModalsFinalEditar(' . $rowFinalesRedes['Id_Fecha_Final'] . ')"><i class="edit-btn"></i>✏️</button></td>';
                            echo '</tr>';
                        }
                    } else {
                        echo "Sin datos que mostrar"; // Puedes personalizar el mensaje de error según tus necesidades
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</main>
<?php
} else {
    echo "Error: No se pudo establecer la conexión a la base de datos.";
}
require_once '../includes/footer.php';
?>
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Función para alternar la visibilidad de las materias
    function toggleMaterias(carrera) {
        var materiasContainer = document.querySelector("." + carrera + "-materias");
        var button = document.querySelector("." + carrera + "-button");

        if (materiasContainer.style.display === "none" || materiasContainer.style.display === "") {
            materiasContainer.style.display = "block";
            button.innerHTML = "Colapsar";
        } else {
            materiasContainer.style.display = "none";
            button.innerHTML = "Extender";
        }
    }

    // Vincular eventos a los botones
    var analistaButton = document.querySelector(".analista-button");
    if (analistaButton) {
        analistaButton.addEventListener("click", function() {
            toggleMaterias("analista");
        });
    }

    var redesButton = document.querySelector(".redes-button");
    if (redesButton) {
        redesButton.addEventListener("click", function() {
            toggleMaterias("redes");
        });
    }
});
</script>
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/includes/footer.php';
?>

<script>
function toggleAllMaterias(checkbox) {
    var estado = checkbox.checked ? 1 : 2; // Si está marcado, estado es 1; de lo contrario, es 2

    // Luego, puedes hacer una llamada AJAX para actualizar el estado en la base de datos
    // Aquí he agregado un ejemplo usando jQuery, asegúrate de tener jQuery cargado en tu página
    $.ajax({
        url: "/instituto/Includes/sqlaltauser.php", // Ajusta la ruta a tu archivo PHP
        type: "POST",
        data: {
            toggleAll: true,
            estado: estado
        },
        success: function(response) {
            // Puedes realizar acciones adicionales si es necesario
            console.log(response);

            // Recarga la página después de una pausa de 1 segundo (1000 milisegundos)
            setTimeout(function() {
                location.reload();
            }, 1000);
        },
        error: function(error) {
            console.log("Error en la solicitud AJAX:", error);
        }
    });
}
</script>

