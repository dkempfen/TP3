<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema/instituto/Adman/includes/header.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema/instituto/Includes/load.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema/instituto/Adman/modals/modalsFinal.php';
?>



<main class="app-content">
    <button class="planalta-button"  onclick="openFinalDateModal()"><i class="fas fa-plus"></i> Agregar Fecha de Final</button>

    <div class="container analista-container" id="containerFinal">
        <h2>Analista de Sistemas</h2>
        <button id="analista-button" class="expand-button" id="expand-button-finales" onclick="toggleMaterias('analista')">Extender</button>
        <div id="analista-materias" class="materias-container">
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
                <tbody>
                    <?php
                    // Aquí puedes obtener y mostrar dinámicamente las materias y fechas finales
                    // $materiasAnalista = obtenerMateriasAnalista(); // Reemplaza esto con tu lógica real
                    // foreach ($materiasAnalista as $materia) {
                    //     echo '<tr>';
                    //     echo '<td>' . $materia['nombre'] . '</td>';
                    //     echo '<td>' . $materia['fecha_final'] . '</td>';
                    //     echo '<td>' . $materia['plan'] . '</td>';
                    //     echo '<td><button class="edit-button">Editar</button></td>';
                    //     echo '</tr>';
                    // }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="container redes-container"  id="containerFinal">

        <h2>Redes Informáticas</h2>
        <button id="redes-button" class="expand-button" id="expand-button-finales" onclick="toggleMaterias('redes')">Extender</button>
        <div id="redes-materias" class="materias-container">
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
                <tbody>
                    <?php
                    // Aquí puedes obtener y mostrar dinámicamente las materias y fechas finales
                    // $materiasRedes = obtenerMateriasRedes(); // Reemplaza esto con tu lógica real
                    // foreach ($materiasRedes as $materia) {
                    //     echo '<tr>';
                    //     echo '<td>' . $materia['nombre'] . '</td>';
                    //     echo '<td>' . $materia['fecha_final'] . '</td>';
                    //     echo '<td>' . $materia['plan'] . '</td>';
                    //     echo '<td><button class="edit-button">Editar</button></td>';
                    //     echo '</tr>';
                    // }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</main>


<script>
function toggleMaterias(carrera) {
    var materias = document.getElementById(carrera + "-materias");
    var button = document.getElementById(carrera + "-button");
    if (materias.style.display === "none" || materias.style.display === "") {
        materias.style.display = "block";
        button.innerHTML = "Colapsar";
    } else {
        materias.style.display = "none";
        button.innerHTML = "Extender";
    }
}
</script>
<?php
require_once '../includes/footer.php';
?>

