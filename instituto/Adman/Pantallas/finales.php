<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Adman/includes/header.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Includes/load.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Adman/modals/modalsFinal.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Adman/modals/ModalsFinalEditar.php';
$obtenerMateriasAnalista = obtenerMateriasAnalista();
$obtenerMateriasRedes = obtenerMateriasRedes();
$obtenerFinales = obtenerFinales();
?>

<main class="app-content">
    <button class="planalta-button" onclick="openFinalDateModal()"><i class="fas fa-plus"></i> Agregar Fecha de
        Final</button>

    <div class="container analista-container" id="containerFinalAnalista">
        <h2>Analista de Sistemas</h2>
        <button class="expand-button analista-button">Extender</button>
        <div class="materias-container analista-materias">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Materia</th>
                        <th>Nivel</th>
                        <th>Fecha de Final</th>
                        <th>Plan</th>
                        <th>Editar</th>
                    </tr>
                </thead>
                <tbody id="message">
                    <?php
                    // Comprueba si la consulta fue exitosa
                    $rowFinalesAnalista = obtenerMateriasAnalista();
                    if ($rowFinalesAnalista) {
                        // Loop a través del resultado y generar filas de la tabla
                        foreach ($rowFinalesAnalista as $rowFinalesAnlista) {
                            echo '<tr>';
                            echo '<td>' . $rowFinalesAnlista['Id_Fecha_Final'] . '</td>';
                            echo '<td>' . $rowFinalesAnlista['Descripcion'] . '</td>';
                            echo '<td>' . $rowFinalesAnlista['Anio_Carrera'] . '</td>';
                            echo '<td>' . $rowFinalesAnlista['Fecha'] . '</td>';
                            echo '<td>' . $rowFinalesAnlista['fk_Plan'] . '</td>';
                            echo '<td><button class="btn-icon" onclick="ModalsFinalEditar(' . $rowFinalesAnlista['Id_Fecha_Final'] . ')"><i class="edit-btn"></i>✏️</button></td>';
                            echo '</tr>';
                        }
                    } else {
                        echo "Error en la consulta"; // Puedes personalizar el mensaje de error según tus necesidades
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!--<div class="container redes-container" id="containerFinalRedes">
        <h2>Redes Informáticas</h2>
        <button class="expand-button redes-button">Extender</button>
        <div class="materias-container redes-materias">
            <table>
                <thead>
                    <tr>
                        <th>Materia</th>
                        <th>Nivel</th>
                        <th>Fecha de Final</th>
                        <th>Plan</th>
                        <th>Editar</th>
                    </tr>
                </thead>
                <tbody id="messages">
                    <?php
                    // Comprueba si la consulta fue exitosa
                    $rowFinalesRedes = obtenerMateriasRedes();
                    if ($rowFinalesRedes) {
                        // Loop a través del resultado y generar filas de la tabla
                        foreach ($rowFinalesRedes as $rowFinalesRedes) {
                            echo '<tr>';
                            echo '<td>' . $rowFinalesRedes['Descripcion'] . '</td>';
                            echo '<td>' . $rowFinalesRedes['Anio_Carrera'] . '</td>';
                            echo '<td>' . $rowFinalesRedes['Fecha'] . '</td>';
                            echo '<td>' . $rowFinalesRedes['fk_Plan'] . '</td>';
                            echo '<td><button class="btn-icon" onclick="ModalsFinalEditar(' . $rowFinalesRedes['Id_Fecha_Final'] . ')"><i class="edit-btn"></i>✏️</button></td>';
                            echo '</tr>';
                        }
                    } else {
                        echo "Error en la consulta"; // Puedes personalizar el mensaje de error según tus necesidades
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>-->
</main>

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