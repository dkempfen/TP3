<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Adman/includes/header.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Includes/load.php';

$materias = CursadaRedes();
?>

<main class="app-content">
    <div class="cursadaRedes-container">
        <div class="cursadaRedes-sidebar">
            <h2><?php echo substr($materias[0]['Carrera'], 0, 8) . ' ' . $materias[0]['Anio_Carrera']; ?></h2>
            <ul>
                <?php foreach ($materias as $materia): ?>
                    <li>
                        <a href="#" onclick="mostrarSemanas('<?php echo $materia['Descripcion']; ?>')">
                            <?php echo $materia['Descripcion']; ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="container" id="containerFinalAnalista">
            <!-- Contenedor para mostrar las semanas -->
            <div id="semanas-container"></div>
        </div>
    </div>
</main>

<script>
    function mostrarSemanas(materia) {
        // Ajustar el año según tus necesidades (en este caso, el año 2024)
        var year = 2024;

        // Definir desde qué semana empezar a mostrar (la segunda semana de marzo sería aproximadamente la semana 10)
        var startWeek = 10;

        // Construir el contenido de los contenedores expansibles para todas las semanas del año
        var contenido = '';
        for (var semana = startWeek; semana <= 52; semana++) {
            // Calcular la fecha de inicio de la semana
            var startDate = new Date(year, 0, (semana - 1) * 7 + 1);

            // Calcular la fecha final de la semana
            var endDate = new Date(year, 0, (semana - 1) * 7 + 7);

            contenido += '<div class="expandable-container">';
            contenido += '<button class="expand-button" onclick="toggleContent(this)">Semana ' + semana + '</button>';
            contenido += '<div class="expand-content">';
            contenido += '<p class="fecha-semana">' + startDate.toLocaleDateString('es-ES') + ' - ' + endDate.toLocaleDateString('es-ES') + '</p>';
            contenido += '<textarea class="expand-textarea" placeholder="Escribe aquí..."></textarea>';
            contenido += '<input type="file" class="expand-file-input" accept=".txt, .pdf, .docx">';
            contenido += '</div>';
            contenido += '</div>';
        }

        // Mostrar el contenido en el contenedor correspondiente
        document.getElementById('semanas-container').innerHTML = contenido;
    }

    function toggleContent(button) {
        var content = button.nextElementSibling;
        content.style.display = content.style.display === 'none' ? 'block' : 'none';
    }
</script>


<?php
require_once '../includes/footer.php';
?>
