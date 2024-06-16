<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Adman/includes/header.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Includes/load.php';

$materias = CursadaRedes();
?>

<style>

.modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
}

.modal-content {
    background-color: #fff;
    margin: 10% auto;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
    position: relative;
}

.close {
    position: absolute;
    top: 10px;
    right: 10px;
    font-size: 20px;
    cursor: pointer;
}

.modal-textarea {
    width: 100%;
    height: 100px;
    margin-bottom: 10px;
}

.modal-guardar-btn {
    background-color: #28a745;
    color: #fff;
    padding: 5px 10px;
    border: none;
    cursor: pointer;
}


#containerFinalAnalista {
    display: flex;
    justify-content: center;
    align-items: center;
}

.cursadaRedes-container {
    display: flex;
    justify-content: space-between;
}

.cursadaRedes-sidebar {
    width: 30%;
}

.cursadaRedes-sidebar h2 {
    font-size: 18px;
    margin-bottom: 10px;
}

.cursadaRedes-sidebar ul {
    list-style-type: none;
    padding: 0;
}

.cursadaRedes-sidebar li {
    margin-bottom: 5px;
}

.cursadaRedes-sidebar a {
    text-decoration: none;
    color: #333;
}

.cursadaRedes-sidebar a:hover {
    color: #007bff;
}

#semanas-container {
    width: 70%;
}

.expandable-container {
    margin-bottom: 20px;
    border: 1px solid #ddd;
    border-radius: 5px;
    overflow: hidden;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
}

.year-container {
    margin-bottom: 20px;
    background-color: #f0f0f0;
    padding: 10px;
    border-radius: 5px;
}

.fecha-semana {
    background-color: #007bff;
    color: #fff;
    padding: 10px;
    margin: 0;
    cursor: pointer;
}

.expand-content {
    padding: 15px;
}

.guardar-btn {
    background-color: #28a745;
    color: #fff;
    padding: 5px 10px;
    border: none;
    cursor: pointer;
}

.expand-textarea {
    margin-top: 10px;
    height: 100px;
    width: calc(100% - 20px);
    padding: 10px;
    box-sizing: border-box;
}

.expand-texto-guardado {
    margin-top: 10px;
    width: calc(100% - 20px);
    padding: 10px;
    box-sizing: border-box;
}

.adjuntar-file {
    margin-top: 10px;
}
</style>

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
            <div id="semanas-container" class="full-height-container"></div>
        </div>
    </div>
</main>

<script>
var contenedorExpandido = null;


function mostrarSemanas(materia) {
    // Ajustar el año según tus necesidades (en este caso, el año 2024)
    var year = 2024;

    // Definir desde qué semana empezar a mostrar (la segunda semana de marzo sería aproximadamente la semana 10)
    var startWeek = 10;

    var contenido = '';


    contenido += '<div class="modal" id="modal-semana-' + semana + '">';
    contenido += '<div class="modal-content">';
    contenido += '<span class="close" onclick="cerrarModal(\'modal-semana-' + semana + '\')">&times;</span>';
    contenido += '<h2>Agregar Texto</h2>';
    contenido += '<textarea class="modal-textarea" id="modal-textarea-semana-' + semana +
        '" placeholder="Escribe aquí..."></textarea>';
    contenido += '<button class="modal-guardar-btn" onclick="agregarTexto(\'modal-textarea-semana-' + semana +
        '\', \'otro-campo-texto-' + semana + '\', \'modal-semana-' + semana + '\')">Guardar</button>';
    contenido += '</div>';
    contenido += '</div>';
 
    // Construir el contenido de los contenedores expansibles para todas las semanas del año
    var contenido = '<div class="full-height-container">';

    // Agregar el contenedor del año que se puede expandir o contraer
    contenido += '<div class="expandable-container year-container" onclick="toggleContent(\'year-content\')">';
    contenido += '<h2 class="fecha-semana">' + year + '</h2>';
    contenido += '<div id="year-content" class="expand-content" style="display: none;">';

    for (var semana = startWeek; semana <= 52; semana++) {
        // Calcular la fecha de inicio de la semana
        var startDate = new Date(year, 0, (semana - 1) * 7 + 1);

        // Calcular la fecha final de la semana
        var endDate = new Date(year, 0, (semana - 1) * 7 + 7);

        contenido += '<div class="expandable-container" id="semana-container-' + semana +
            '" onclick="toggleContent(\'semana-content-' + semana + '\')">';
        contenido += '<h2 class="fecha-semana">Semana ' + semana + ': ' + startDate.toLocaleDateString('es-ES') +
            ' - ' + endDate.toLocaleDateString('es-ES') + '</h2>';
        contenido += '<div id="semana-content-' + semana + '" class="expand-content" style="display: none;">';
        contenido += '<button class="guardar-btn" onclick="agregarTexto(\'textarea-semana-' + semana +
            '\', \'otro-campo-texto-' + semana + '\')">Agregar Texto</button>';
        contenido += '<div id="texto-container-' + semana + '" style="display: none;">';
        contenido += '<i class="fas fa-font"></i> '; // Ícono de texto
        contenido += '<span id="texto-semana-' + semana + '"></span>'; // Contenedor para el texto ingresado
        contenido += '</div>';
        contenido += '<input class="adjuntar-file" type="file" id="file-semana-' + semana +
            '" onchange="adjuntarArchivo(\'file-semana-' + semana + '\')">';
        contenido += '</div>';
        contenido += '</div>'; // Cierra el div de expandable-container dentro del bucle
    }

    contenido += '</div>'; // Cierra el div de year-content
    contenido += '</div>'; // Cierra el div de expandable-container del año

    contenido += '</div>'; // Cierra el div de full-height-container

    // Mostrar el contenido en el contenedor correspondiente
    document.getElementById('semanas-container').innerHTML = contenido;

    // Verificar si estamos al final del año y crear un nuevo año si es necesario
    if (new Date().getFullYear() === year && new Date().getMonth() === 11 && new Date().getDate() >= 31) {
        crearNuevoAno();
    }
}

function abrirModal(modalId) {
    var modal = document.getElementById(modalId);
    modal.style.display = 'block';
}

function cerrarModal(modalId) {
    var modal = document.getElementById(modalId);

    if (modal) {
        modal.style.display = 'none';
    }
}
function agregarTexto(textareaId, otroCampoId) {
    var textarea = document.getElementById(textareaId);
    var otroCampo = document.getElementById(otroCampoId);

    console.log("Textarea:", textarea);
    console.log("Otro campo:", otroCampo);

    if (textarea && otroCampo) {
        // Tu lógica para agregar texto aquí
    } else {
        console.error("Textarea o campo adicional no encontrado en el DOM.");
    }
}

// Función para crear un nuevo año con sus semanas
function crearNuevoAno() {
    // Obtener el año actual
    var currentYear = new Date().getFullYear();

    // Incrementar el año
    var newYear = currentYear + 1;

    // Crear el contenido para el nuevo año (puedes ajustar startWeek según tus necesidades)
    var newYearContent = '<div class="expandable-container year-container" onclick="toggleContent(\'year-content\')">';
    newYearContent += '<h2 class="fecha-semana">' + newYear + '</h2>';
    newYearContent += '<div id="year-content" class="expand-content" style="display: none;">';

    for (var semana = startWeek; semana <= 52; semana++) {
        // Calcular la fecha de inicio de la semana
        var startDate = new Date(newYear, 0, (semana - 1) * 7 + 1);

        // Calcular la fecha final de la semana
        var endDate = new Date(newYear, 0, (semana - 1) * 7 + 7);

        newYearContent += '<div class="expandable-container" id="semana-container-' + semana +
            '" onclick="toggleContent(\'semana-content-' + semana + '\')">';
        newYearContent += '<h2 class="fecha-semana">Semana ' + semana + ': ' + startDate.toLocaleDateString('es-ES') +
            ' - ' + endDate.toLocaleDateString('es-ES') + '</h2>';
        newYearContent += '<div id="semana-content-' + semana + '" class="expand-content" style="display: none;">';
        newYearContent += '<button class="guardar-btn" onclick="guardarTexto(\'textarea-semana-' + semana +
            '\', \'otro-campo-texto-' + semana + '\')">Guardar</button>';
        newYearContent += '<textarea class="expand-textarea" id="textarea-semana-' + semana +
            '" placeholder="Escribe aquí..."></textarea>';
        newYearContent += '<input class="expand-texto-guardado" type="text" id="otro-campo-texto-' + semana +
            '" class="expand-texto-guardado" placeholder="Texto guardado">';
        newYearContent += '<input class="adjuntar-file" type="file" id="file-semana-' + semana +
            '" onchange="adjuntarArchivo(\'file-semana-' + semana + '\')">';
        newYearContent += '</div>';
        newYearContent += '</div>'; // Cierra el div de expandable-container dentro del bucle
    }

    newYearContent += '</div>'; // Cierra el div de year-content
    newYearContent += '</div>'; // Cierra el div de expandable-container del año

    newYearContent += '</div>'; // Cierra el div de full-height-container

    // Agregar el contenido del nuevo año al contenedor correspondiente
    document.getElementById('semanas-container').innerHTML += newYearContent;
}



function toggleContent(contentId) {
    var content = document.getElementById(contentId);

    // Verificar si el clic proviene de un botón de guardar, textarea o input
    var isInsideSpecificElement = event.target.classList.contains('guardar-btn') || event.target.classList.contains(
            'expand-texto-guardado') || event.target.classList.contains('expand-textarea') || event.target.classList
        .contains('adjuntar-file');

    // Si se hace clic en el contenedor del año, simplemente cambia la visualización
    if (contentId === 'year-content') {
        content.style.display = (content.style.display === 'none' || content.style.display === '') ? 'block' : 'none';
    } else {
        // Cerrar la semana actualmente abierta, si hay alguna
        if (contenedorExpandido !== null && contenedorExpandido !== content && !isInsideSpecificElement) {
            contenedorExpandido.style.display = 'none';
        }

        // Actualizar el contenedor actualmente expandido
        contenedorExpandido = (contenedorExpandido !== content) ? content : null;

        // Solo cambiar la visualización si no se hizo clic en elementos específicos
        if (!isInsideSpecificElement) {
            content.style.display = (content.style.display === 'none' || content.style.display === '') ? 'block' :
                'none';
        }

        // Si el contenedor del año está abierto, ciérralo
        var yearContainer = document.getElementById('year-content');
        if (yearContainer.style.display === 'block') {
            yearContainer.style.display = 'none';
        }
    }
    console.log('Visualización del contenido después de alternar:', content.style.display);
}

function guardarTexto(textareaId, otroCampoId) {
    var textarea = document.getElementById(textareaId);
    var otroCampo = document.getElementById(otroCampoId);

    // Guardar el contenido del textarea en el otro campo
    otroCampo.value = textarea.value;
}
</script>

<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/includes/footer.php';
?>