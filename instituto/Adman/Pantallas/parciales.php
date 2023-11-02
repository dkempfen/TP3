<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema/instituto/Adman/includes/header.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema/instituto/Includes/load.php';
?>

<style>
    .container {
        border: 1px solid #ccc;
        padding: 10px;
        margin: 10px;
        position: relative;
    }

    .container table {
        width: 100%;
    }

    .container th,
    .container td {
        border: 1px solid #ccc;
        padding: 8px;
        text-align: center;
    }

    .container th {
        background-color: #f2f2f2;
    }

    .edit-button {
        background-color: #4CAF50;
        color: white;
        border: none;
        padding: 5px 10px;
        cursor: pointer;
    }

    .analista-container,
    .redes-container {
        /* Estilos específicos para la carrera de Analista de Sistemas y Redes Informáticas */
    }

    .materias-container {
        display: none; /* Ocultar las materias por defecto */
    }

    .expand-button {
        background-color: #007BFF;
        color: white;
        border: none;
        padding: 5px 10px;
        cursor: pointer;
        position: absolute;
        top: 10px;
        right: 10px;
    }
</style>

<script>
    function toggleMaterias(carrera) {
        var materias = document.getElementById(carrera + "-materias");
        var button = document.getElementById(carrera + "-button");
        if (materias.style.display === "none") {
            materias.style.display = "block";
            button.innerHTML = "Colapsar";
        } else {
            materias.style.display = "none";
            button.innerHTML = "Extender";
        }
    }
</script>

<main class="app-content">
    <div class="container analista-container">
        <h2>Analista de Sistemas</h2>
        <button id="analista-button" class="expand-button" onclick="toggleMaterias('analista')">Extender</button>
        <div id="analista-materias" class="materias-container">
            <table>
                <thead>
                    <tr>
                        <th>Materia</th>
                        <th>Fecha de Parcial</th>
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

    <div class="container redes-container">
        <h2>Redes Informáticas</h2>
        <button id="redes-button" class="expand-button" onclick="toggleMaterias('redes')">Extender</button>
        <div id="redes-materias" class="materias-container">
            <table>
                <thead>
                    <tr>
                        <th>Materia</th>
                        <th>Fecha de Parcial</th>
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