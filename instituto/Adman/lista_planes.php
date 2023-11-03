<?php
//require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Adman/ModelsPlan/crearPlan.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Adman/includes/header.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Includes/load.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Adman/modals/modal_EditarPlan.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Adman/modals/modal_carrera.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Adman/modals/modal_CrearPlan.php';

?>

<?php
if ($pdo) {
    // Query para obtener los datos de la tabla 'usuarios'
    $sql = "SELECT pl.*
    FROM Plan pl";
    
    $result = $pdo->query($sql);
    // Check if there's a message in the session

    if (isset($_SESSION['message'])) {
        $message = $_SESSION['message'];
        unset($_SESSION['message']); // Clear the session variable after displaying the message
        showConfirmationMessageUser($message);
    }
    if (isset($_SESSION['message'])) {
        $message = $_SESSION['message'];
        unset($_SESSION['message']); // Clear the session variable after displaying the message
        showConfirmationMessages($message);
    }

    if (isset($_SESSION['messagePlan'])) {
        $messagePlan = $_SESSION['messagePlan'];
        unset($_SESSION['messagePlan']); // Clear the session variable after displaying the message
        showConfirmationMessagePlan($messagePlan);
    }

    if (isset($_SESSION['messageEditarPlan'])) {
        $messageEditarPlan = $_SESSION['messageEditarPlan'];
        unset($_SESSION['messageEditarPlan']); // Clear the session variable after displaying the message
        showConfirmationMessageEditarPlan($messageEditarPlan);
    }



?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">



<main class="app-content">

    <div class="custom-menu">
        <nav class="custom-nav">
            <div class="menu-group">
                <ul class="custom-menu-list">
                    <!-- Carreras -->
                    <li class="custom-menu-item">
                        <a class="custom-menu-link" href="/instituto/Adman/Pantallas/carreras.php">Nuestras Carreras</a>

                    </li>
                </ul>
            </div>

            <div class="menu-group">
                <ul class="custom-menu-list">
                    <!-- Planes de Estudio -->
                    <li class="custom-menu-item">
                        <a class="custom-menu-link" href="/instituto/Adman/lista_planes.php">Planes de Estudio</a>

                    </li>
                </ul>
            </div>

            <div class="menu-group">
                <ul class="custom-menu-list">
                    <!-- Materias -->
                    <li class="custom-menu-item">
                        <a class="custom-menu-link" href="/instituto/Adman/lista_materia.php">Materias</a>

                    </li>
                </ul>
            </div>
        </nav>
    </div>
    <div id="menu-container" class="container">



        <div class="row espaciado-entre-filas align-items-center">

            <form id="busquedaForm" class="form-inline mb-5">
                <div class="form-group mb-2">
                    <label for="carrera" class="label-spacing">Carrera:</label>
                    <input type="text" class="form-control  " id="carrera">
                    </select>
                </div>
                <div class="form-group mb-2">
                    <label for="nombrePlan" class="label-spacing">Nombre del Plan:</label>
                    <input type="text" class="form-control" id="nombrePlan">
                </div>
                <div class="form-group mb-2">
                    <label for="fechaInicio" class="label-spacing">Fecha de Inicio:</label>
                    <input type="date" class="form-control" id="fechaInicio">
                </div>
                <div class="form-group mb-2">
                    <label for="fechaFinal" class="label-spacing">Fecha de Finalización:</label>
                    <input type="date" class="form-control" id="fechaFinal">
                </div>
            </form>
            <div class="col-lg-6">
            </div>
            <div class="col-lg-6 text-right">
                <!-- Divide la fila en 2 columnas y alinea a la derecha -->
                <a id="generarPDFBtn" href="#" onclick="mostrarSeleccionTarjetasPDF(); return false;"
                    class="planpdf-button">
                    <i class="fas fa-file-pdf"></i> Descargar PDF
                </a>
                <button data-toggle="modal" class="planalta-button" id="crearNuevoPlanBtn" type="button"  data-toggle="modal"
                    onclick="mostrarCrearNuevoPlan()"><i class="fas fa-plus"></i> Crear Nuevo Plan</button>

                <!-- <a id="crearNuevoPlanBtn" href="#crearNuevoPlanModal" class="planalta-button"
                    onclick="mostrarCrearNuevoPlan(); return false;">
                    <i class="fas fa-plus"></i> Crear Nuevo Plan
                </a>-->
            </div>

        </div>


        <div class="row espaciado-entre-filas">
            <?php
                // Realiza una conexión a la base de datos (debes configurar tus propios detalles de conexión)

                $sql = "SELECT P.cod_Plan, P.Carrera, P.Estado_Id_Estado, P.Fecha_Inicio, P.Fecha_Final, D.Descripcion
                     FROM Plan AS P
                     LEFT JOIN Documentacion AS D ON P.cod_Plan = D.fk_Plan";
                $resultado = $pdo->query($sql);

                // Recorrer los resultados y generar la estructura HTML
                foreach ($resultado as $fila) {
                    echo '<div class="col-lg-4 margen-inferior">'; 
                    echo '<div class="card">';
                    echo '<input type="hidden" class="codigo-plan" value="' . $fila['cod_Plan'] . '">';

                    echo '<div class="card-body">';
                    echo '<h2 class="card-title">' . $fila['Carrera'] . '</h2>';
                    echo '<label id="seleccionar-label">';
                    echo '<input name="tarjetasSeleccionadas" type="checkbox" class="tarjeta-checkbox" value="' . $fila['Carrera'] . '">';
                    echo '</label>';
                    echo '<div class="card-divider"></div>';
                    echo '<p><strong>Plan:</strong> ' . $fila['cod_Plan'] . '</p>';
                    echo '<p><strong>Estado:</strong> ' . ($fila['Estado_Id_Estado'] == 1 ? 'Habilitado' : 'Inhabilitado') . '</p>';
                    echo '<p><strong>Fecha Inicio:</strong> ' . $fila['Fecha_Inicio'] . '</p>';
                    echo '<p><strong>Fecha Final:</strong> ' . $fila['Fecha_Final'] . '</p>';
                    
                    // Verificar si hay una descripción de archivo
                    if ($fila['Descripcion'] !== null) {
                        echo '<p><strong>Archivo del Plan:</strong> ' . $fila['Descripcion'] . '</p>';
                    } else {
                        echo '<p><strong>Archivo del Plan:</strong> No se ha adjuntado archivo</p>';
                    }
                
                    echo '</div>';
                    echo '<div class="card-footer">';
                    echo '<div class="d-flex justify-content-end">';
                    
                    $estadoSeleccionado = ($fila['Estado_Id_Estado'] == 1) ? 'Habilitado' : 'Inhabilitado';
                    
                    echo '<button class="btn btn-primary btn-sm mr-2" type="button" onclick="mostrarEditarTarjeta(this)"
                    data-codigo-plan="' . $fila['cod_Plan'] . '" data-nombre-tarjeta="' . $fila['Carrera'] . '"
                    data-estado-tarjeta="' . $fila['Estado_Id_Estado'] .'" data-fecha-inicio="' . $fila['Fecha_Inicio'] . '"
                    data-fecha-final="' . $fila['Fecha_Final'] . '">Editar</button>';
                    
                    echo '<button class="btn btn-info btn-sm" onclick="mostrarInfoAdicional(' . $fila['cod_Plan'] . ')">Más Información</button>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }

                // Cierra la conexión a la base de datos
                $pdo = null;
                ?>
        </div>
        <div class="row espaciado-entre-plames align-items-center">
            <div class="col-lg-6">
                <!-- Divide la fila en 2 columnas -->
                <div class="custom-link">
                    <a href="/instituto/Adman/Pantallas/carreras.php" title="">
                        <span class="buttonIcon" aria-hidden="true">
                            <i class="fas fa-chevron-left"></i>
                        </span>
                        <span class="buttonText">Anterior</span>
                    </a>
                </div>
            </div>

        </div>

    </div>

    <!-- Selector de tarjetas para el PDF -->
    <div class="modal fade" id="selectorTarjetasPDF" tabindex="-1" role="dialog"
        aria-labelledby="selectorTarjetasPDFLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="selectorTarjetasPDFLabel">Selecciona las tarjetas para el PDF</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Aquí se mostrarán las tarjetas seleccionadas por separado -->
                    <div id="tarjetasSeleccionadasPDF">
                        <!-- Las tarjetas seleccionadas se mostrarán aquí -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-success" onclick="generarPDF()">Generar PDF</button>
                </div>
            </div>
        </div>
    </div>

   

    

</main>


<?php
} else {
    echo "Error: No se pudo establecer la conexión a la base de datos.";
}
require_once '../includes/footer.php';
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>



<script>
document.addEventListener("DOMContentLoaded", function() {
    var celdasExpandibles = document.querySelectorAll("td");

    // Agregar un controlador de eventos a cada celda
    celdasExpandibles.forEach(function(celda) {
        celda.addEventListener("click", function() {
            // Obtén el div de información adicional dentro de la celda
            var infoAdicional = this.querySelector(".info-adicional");

            // Cambia la visibilidad del div
            if (infoAdicional.style.display === "none" || infoAdicional.style.display === "") {
                infoAdicional.style.display = "block";
            } else {
                infoAdicional.style.display = "none";
            }
        });
    });
});

</script>
<script>
function descargarPDF() {
    const doc = new jsPDF();
    doc.text("Plan A1", 10, 10); // Agregar el título o contenido del PDF aquí
    // Agregar más contenido al PDF si es necesario
    doc.save("plan_a1.pdf"); // Nombre del archivo PDF
}
</script>
<script>
// Array para almacenar las tarjetas seleccionadas para el PDF
const tarjetasSeleccionadasPDF = [];

// Función para mostrar el selector de tarjetas para el PDF
function mostrarSeleccionTarjetasPDF() {
    // Limpiar el formulario de selección de tarjetas
    document.getElementById('formTarjetasPDF').innerHTML = '';

    // Obtener todas las tarjetas
    const tarjetas = document.querySelectorAll('.tarjeta-checkbox');

    // Crear elementos de selección para cada tarjeta
    tarjetas.forEach((tarjeta, index) => {
        if (tarjeta.checked) {
            const label = document.createElement('label');
            label.appendChild(tarjeta.cloneNode(true));
            label.appendChild(document.createTextNode(` Tarjeta ${tarjeta.value}`));

            document.getElementById('formTarjetasPDF').appendChild(label);
        }
    });

    // Mostrar el selector de tarjetas
    $('#selectorTarjetasPDF').modal('show');
}

// Función para generar el PDF con las tarjetas seleccionadas
function generarPDF() {
    // Obtener las tarjetas seleccionadas desde el formulario
    const tarjetasSeleccionadas = Array.from(document.querySelectorAll('input[name="tarjetasSeleccionadas"]:checked'))
        .map(input => input.value);

    // Verificar si se seleccionó al menos una tarjeta
    if (tarjetasSeleccionadas.length === 0) {
        alert('Debes seleccionar al menos una tarjeta para generar el PDF.');
        return;
    }

    const doc = new jsPDF();

    // Ciclo para agregar cada tarjeta seleccionada al PDF
    tarjetasSeleccionadas.forEach((tarjeta, index) => {
        if (index > 0) {
            doc.addPage(); // Agregar una nueva página para cada tarjeta adicional
        }
        const contenidoTarjeta = document.querySelector(`input[value="${tarjeta}"]`).closest('.card').innerHTML;
        doc.fromHTML(contenidoTarjeta, 15, 15);
    });

    // Descargar el PDF
    doc.save('plan_personalizado.pdf');
}
</script>

<script>
function mostrarSeleccionTarjetasPDF() {
    // Obtener todas las tarjetas
    const tarjetas = document.querySelectorAll('.tarjeta-checkbox');

    // Verificar si al menos una tarjeta está seleccionada
    let alMenosUnaSeleccionada = false;

    tarjetas.forEach((tarjeta) => {
        if (tarjeta.checked) {
            alMenosUnaSeleccionada = true;
        }
    });

    if (!alMenosUnaSeleccionada) {
        alert('Debes seleccionar al menos una tarjeta.');
        return;
    }

    // Limpiar el contenido del modal
    document.getElementById('tarjetasSeleccionadasPDF').innerHTML = '';

    // Crear y agregar tarjetas seleccionadas al modal
    tarjetas.forEach((tarjeta) => {
        if (tarjeta.checked) {
            const tarjetaSeleccionada = document.createElement('div');
            tarjetaSeleccionada.innerHTML = `
                <label>
                    <input type="checkbox" class="tarjeta-seleccionada-checkbox" value="${tarjeta.value}" checked>
                    Tarjeta ${tarjeta.value}
                </label>
            `;
            document.getElementById('tarjetasSeleccionadasPDF').appendChild(tarjetaSeleccionada);
        }
    });

    // Mostrar el selector de tarjetas
    $('#selectorTarjetasPDF').modal('show');
}
</script>

<script>
$(document).ready(function() {
    // Cuando se hace clic en el botón "Editar", abrir el modal
    $("#editarTarjeta3Btn").click(function() {
        $("#editarTarjeta1Modal").modal("show");
    });
});


function isValidInput(value) {
    return value.trim() !== '';
}

function mostrarCrearNuevoPlan() {
    console.log('Abrir modal'); // Agrega este log para verificar si se llama a la función

    document.getElementById('idPlancrear').value = "";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerPlan");
    document.getElementById('btnCrearPlan').classList.replace("btn-info", "btn-open-modal");
    document.getElementById('btnCrearPlan').innerHTML = 'Guardar';
    document.getElementById('tituloModalCrearPlan').innerHTML = 'Crear Plan';
    document.getElementById('formCrearPlan').reset();

    $('#modalCrearPlan').modal('show');

    
}
</script>
