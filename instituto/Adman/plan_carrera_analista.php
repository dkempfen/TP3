<?php
require_once 'includes/header.php';
require_once '../Includes/load.php';
?>

<style>
.expansor {
    cursor: pointer;
    font-size: 18px;
    color: #007bff;
    /* Color azul de Bootstrap */
    margin-left: 10px;
    /* Espacio entre el texto y el icono */
}

.expansor:hover {
    color: #0056b3;
    /* Cambia el color al pasar el mouse por encima */
}
</style>

<main class="app-content">
    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title">Plan A1</h2>
                        <label id="seleccionar-label">
                            <input name="tarjetasSeleccionadas" type="checkbox" class="tarjeta-checkbox"
                                value="tarjeta1">
                        </label>

                        <div class="card-divider"></div>
                        <p><strong>Estado:</strong> Activo</p>
                        <p><strong>Fecha Inicio:</strong> 01/10/2023</p>
                        <p><strong>Fecha Final:</strong> 01/10/2024</p>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex justify-content-end">

                            <button class="btn btn-primary btn-sm mr-2"  type="button" onclick="mostrarEditarTarjeta()">Editar</button>
                            <button class="btn btn-info btn-sm" onclick="mostrarInfoAdicional()">Más
                                Información</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title">Plan A2023</h2>
                        <label id="seleccionar-label">
                            <input name="tarjetasSeleccionadas" type="checkbox" class="tarjeta-checkbox"
                                value="tarjeta2">
                        </label>
                        <div class="card-divider"></div>
                        <p><strong>Estado:</strong> Activo</p>
                        <p><strong>Fecha Inicio:</strong> 01/10/2023</p>
                        <p><strong>Fecha Final:</strong> 01/10/2024</p>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex justify-content-end">
                            <button class="btn btn-primary btn-sm mr-2"
                                onclick="mostrarEditarTarjetat()">Editar</button>
                            <button class="btn btn-info btn-sm">Más Información</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title">Plan XYZ</h2>
                        <label id="seleccionar-label">
                            <input name="tarjetasSeleccionadas" type="checkbox" class="tarjeta-checkbox"
                                value="tarjeta3">
                        </label>
                        <div class="card-divider"></div>
                        <p><strong>Estado:</strong> Activo</p>
                        <p><strong>Fecha Inicio:</strong> 01/10/2023</p>
                        <p><strong>Fecha Final:</strong> 01/10/2024</p>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex justify-content-end">
                            <button class="btn btn-primary btn-sm mr-2"
                                onclick="mostrarEditarTarjetas()">Editar</button>
                            <button class="btn btn-info btn-sm">Más Información</button>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-lg-12 d-flex align-items-center justify-content-between">
                <button class="btn btn-secondary btn-xs" onclick="window.history.back()">Volver Atrás</button>
                <button class="btn btn-success btn-xs" onclick="mostrarSeleccionTarjetasPDF()">Generar PDF</button>
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


    <!-- Modal para mostrar la tabla -->
    <div class="modal fade" id="tablaModal" tabindex="-1" role="dialog" aria-labelledby="tablaModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tablaModalLabel">Información Adicional</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-responsive">
                        <tbody>
                            <tr>
                                <td style="text-align: center;" colspan="4" width="618">Plan A1</td>
                            </tr>
                            <tr>
                                <td width="80">NIVEL</td>
                                <td width="80">Nº</td>
                                <td width="80">CÓDIGO</td>
                                <td width="378">ASIGNATURA</td>
                            </tr>
                            <tr>
                                <td style="text-align: center;" rowspan="8" width="80">I</td>
                                <td width="80">1</td>
                                <td width="80">950702</td>
                                <td>
                                    Prácticas Profesionalizantes I
                                    <span class="expansor" data-toggle="collapse"
                                        data-target=".info-adicional-1">&#9660;</span>
                                </td>
                            </tr>
                            <tr class="collapse info-adicional-1">
                                <td colspan="4">
                                    <!-- Contenido adicional que deseas mostrar -->
                                    Teacher: Gustavo Orti
                                </td>
                            </tr>
                            <tr>
                                <td width="80">2</td>
                                <td width="80">950701</td>
                                <td>
                                    Arquitectura de Computadores
                                    <span class="expansor" data-toggle="collapse"
                                        data-target=".info-adicional-2">&#9660;</span>
                                </td>
                            </tr>
                            <tr class="collapse info-adicional-2">
                                <td colspan="4">
                                    <!-- Contenido adicional que deseas mostrar -->
                                    Teacher: Silvia Rocchi
                                </td>
                            </tr>
                            <tr>
                                <td width="80">3</td>
                                <td width="80">951604</td>
                                <td>
                                    Sistemas y Organizaciones
                                    <span class="expansor" data-toggle="collapse"
                                        data-target=".info-adicional-3">&#9660;</span>
                                </td>
                            </tr>
                            <tr class="collapse info-adicional-3">
                                <td colspan="4">
                                    <!-- Contenido adicional que deseas mostrar -->
                                    Teacher: Gustavo Orti
                                </td>
                            </tr>
                            <tr>
                                <td width="80">4</td>
                                <td width="80">951601</td>
                                <td>
                                    Algoritmos y Estructuras de Datos I
                                    <span class="expansor" data-toggle="collapse"
                                        data-target=".info-adicional-4">&#9660;</span>
                                </td>
                            </tr>
                            <tr class="collapse info-adicional-4">
                                <td colspan="4">
                                    <!-- Contenido adicional que deseas mostrar -->
                                    Teacher: Gaston Sebastian Barrionuevo
                                </td>
                            </tr>
                            <tr>
                                <td width="80">5</td>
                                <td width="80">950605</td>
                                <td width="378">
                                    Algebra
                                    <span class="expansor" data-toggle="collapse"
                                        data-target=".info-adicional-5">&#9660;</span>
                                </td>
                            </tr>
                            <tr class="collapse info-adicional-5">
                                <td colspan="4">
                                    <!-- Contenido adicional que deseas mostrar -->
                                    Teacher: Giulana Fernanda Spoltore
                                </td>
                            </tr>
                            <tr>
                                <td width="80">6</td>
                                <td width="80">951407</td>
                                <td>
                                    Análisis Matemático I
                                    <span class="expansor" data-toggle="collapse"
                                        data-target=".info-adicional-6">&#9660;</span>
                                </td>
                            </tr>
                            <tr class="collapse info-adicional-6">
                                <td colspan="4">
                                    <!-- Contenido adicional que deseas mostrar -->
                                    Teacher: Juan Alberto Ledesma
                                </td>
                            </tr>
                            <tr>
                                <td width="80">7</td>
                                <td width="80">&nbsp;&nbsp;950520</td>
                                <td>
                                    Ciencia Tecnología y Sociedad
                                    <span class="expansor" data-toggle="collapse"
                                        data-target=".info-adicional-7">&#9660;</span>
                                </td>
                            </tr>
                            <tr class="collapse info-adicional-7">
                                <td colspan="4">
                                    <!-- Contenido adicional que deseas mostrar -->
                                    Teacher: Diego Alberto Benitez
                                </td>
                            </tr>
                            <tr>
                                <td width="80">8</td>
                                <td width="80">950599</td>
                                <td>
                                    Inglés I
                                    <span class="expansor" data-toggle="collapse"
                                        data-target=".info-adicional-8">&#9660;</span>
                                </td>
                            </tr>
                            <tr class="collapse info-adicional-8">
                                <td colspan="4">
                                    <!-- Contenido adicional que deseas mostrar -->
                                    Teacher: Horacio R. Dal Dosso
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: center;" rowspan="8" width="80">II</td>
                                <td width="80">9</td>
                                <td width="80">950600</td>
                                <td>
                                    Prácticas Profesionalizantes II
                                    <span class="expansor" data-toggle="collapse"
                                        data-target=".info-adicional-9">&#9660;</span>
                                </td>
                            </tr>
                            <tr class="collapse info-adicional-9">
                                <td colspan="4">
                                    <!-- Contenido adicional que deseas mostrar -->
                                    Teacher: Luisa María BravoBase de Datos
                                </td>
                            </tr>
                            <tr>
                                <td width="80">10</td>
                                <td width="80">950601</td>
                                <td>
                                    Base de Datos
                                    <span class="expansor" data-toggle="collapse"
                                        data-target=".info-adicional-10">&#9660;</span>
                                </td>
                            </tr>
                            <tr class="collapse info-adicional-10">
                                <td colspan="4">
                                    <!-- Contenido adicional que deseas mostrar -->
                                    Teacher: Alejandro Martín Ferraris
                                </td>
                            </tr>
                            <tr>
                                <td width="80">11</td>
                                <td width="80">950602</td>
                                <td>
                                    Sistemas Operativos
                                    <span class="expansor" data-toggle="collapse"
                                        data-target=".info-adicional-11">&#9660;</span>
                                </td>
                            </tr>
                            <tr class="collapse info-adicional-11">
                                <td colspan="4">
                                    <!-- Contenido adicional que deseas mostrar -->
                                    Teacher: Raul Lamas
                                </td>
                            </tr>
                            <tr>
                                <td width="80">12</td>
                                <td width="80">950603</td>
                                <td>
                                    Algoritmos y Estructuras de Datos II
                                    <span class="expansor" data-toggle="collapse"
                                        data-target=".info-adicional-12">&#9660;</span>
                                </td>
                            </tr>
                            <tr class="collapse info-adicional-12">
                                <td colspan="4">
                                    <!-- Contenido adicional que deseas mostrar -->
                                    Teacher: Gaston Sebastian Barrionuevo
                                </td>
                            </tr>
                            <tr>
                                <td width="80">13</td>
                                <td width="80">950605</td>
                                <td>
                                    Ingeniería de Software I
                                    <span class="expansor" data-toggle="collapse"
                                        data-target=".info-adicional-13">&#9660;</span>
                                </td>
                            </tr>
                            <tr class="collapse info-adicional-13">
                                <td colspan="4">
                                    <!-- Contenido adicional que deseas mostrar -->
                                    Teacher: Viviana Sanchez
                                </td>
                            </tr>
                            <tr>
                                <td width="80">14</td>
                                <td width="80">951407</td>
                                <td>
                                    Estadística
                                    <span class="expansor" data-toggle="collapse"
                                        data-target=".info-adicional-14">&#9660;</span>
                                </td>
                            </tr>
                            <tr class="collapse info-adicional-14">
                                <td colspan="4">
                                    <!-- Contenido adicional que deseas mostrar -->
                                    Teacher: Carlos Evangelista
                                </td>
                            </tr>
                            <tr>
                                <td width="80">15</td>
                                <td width="80">&nbsp;&nbsp;950520</td>
                                <td>
                                    Análisis Matemático II
                                    <span class="expansor" data-toggle="collapse"
                                        data-target=".info-adicional-15">&#9660;</span>
                                </td>
                            </tr>
                            <tr class="collapse info-adicional-15">
                                <td colspan="4">
                                    <!-- Contenido adicional que deseas mostrar -->
                                    Teacher: Laura Inés Besso
                                </td>
                            </tr>
                            <tr>
                                <td width="80">16</td>
                                <td width="80">950599</td>
                                <td>
                                    Inglés II
                                    <span class="expansor" data-toggle="collapse"
                                        data-target=".info-adicional-16">&#9660;</span>
                                </td>
                            </tr>
                            <tr class="collapse info-adicional-16">
                                <td colspan="4">
                                    <!-- Contenido adicional que deseas mostrar -->
                                    Teacher: Horacio R. Dal Dosso
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: center;" rowspan="8" width="80">III</td>
                                <td width="80">17</td>
                                <td width="80">950600</td>
                                <td>
                                    Prácticas Profesionalizantes III
                                    <span class="expansor" data-toggle="collapse"
                                        data-target=".info-adicional-17">&#9660;</span>
                                </td>
                            </tr>
                            <tr class="collapse info-adicional-17">
                                <td colspan="4">
                                    <!-- Contenido adicional que deseas mostrar -->
                                    Teacher: Gustavo Garcia
                                    Teacher: Silvia Rocchi
                                </td>
                            </tr>
                            <tr>
                                <td width="80">18</td>
                                <td width="80">950601</td>
                                <td>
                                    Algoritmos y Estructura de Datos III
                                    <span class="expansor" data-toggle="collapse"
                                        data-target=".info-adicional-18">&#9660;</span>
                                </td>
                            </tr>
                            <tr class="collapse info-adicional-18">
                                <td colspan="4">
                                    <!-- Contenido adicional que deseas mostrar -->
                                    Teacher: Rómulo Arceri
                                </td>
                            </tr>
                            <tr>
                                <td width="80">19</td>
                                <td width="80">950602</td>
                                <td>
                                    Ingeniería de Software II
                                    <span class="expansor" data-toggle="collapse"
                                        data-target=".info-adicional-19">&#9660;</span>
                                </td>
                            </tr>
                            <tr class="collapse info-adicional-19">
                                <td colspan="4">
                                    <!-- Contenido adicional que deseas mostrar -->
                                    Teacher: Ignacio Castillo
                                </td>
                            </tr>
                            <tr>
                                <td width="80">20</td>
                                <td width="80">950603</td>
                                <td>
                                    Redes y Comunicaciones
                                    <span class="expansor" data-toggle="collapse"
                                        data-target=".info-adicional-20">&#9660;</span>
                                </td>
                            </tr>
                            <tr class="collapse info-adicional-20">
                                <td colspan="4">
                                    <!-- Contenido adicional que deseas mostrar -->
                                    Teacher: Raul Lamas
                                </td>
                            </tr>
                            <tr>
                                <td width="80">21</td>
                                <td width="80">950605</td>
                                <td>
                                    Seminario de Actualización
                                    <span class="expansor" data-toggle="collapse"
                                        data-target=".info-adicional-21">&#9660;</span>
                                </td>
                            </tr>
                            <tr class="collapse info-adicional-21">
                                <td colspan="4">
                                    <!-- Contenido adicional que deseas mostrar -->
                                    Teacher: Jorge Insfran
                                </td>
                            </tr>
                            <tr>
                                <td width="80">22</td>
                                <td width="80">951407</td>
                                <td>
                                    Aspectos Legales de la Profesión
                                    <span class="expansor" data-toggle="collapse"
                                        data-target=".info-adicional-22">&#9660;</span>
                                </td>
                            </tr>
                            <tr class="collapse info-adicional-22">
                                <td colspan="4">
                                    <!-- Contenido adicional que deseas mostrar -->
                                    Teacher: Alejandro Mosti
                                </td>
                            </tr>
                            <tr>
                                <td width="80">23</td>
                                <td width="80">950599</td>
                                <td>
                                    Inglés III
                                    <span class="expansor" data-toggle="collapse"
                                        data-target=".info-adicional-23">&#9660;</span>
                                </td>
                            </tr>
                            <tr class="collapse info-adicional-23">
                                <td colspan="4">
                                    <!-- Contenido adicional que deseas mostrar -->
                                    Teacher: Lara Alarcón Cancelliere
                                </td>
                            </tr>
                        </tbody>
                    </table>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

</main>



<?php
require_once 'includes/footer.php';
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>

<script>
function mostrarInfoAdicional() {
    $('#tablaModal').modal('show');

    // Obtén el elemento con el id "infoAdicional"
    var infoAdicional = document.getElementById("infoAdicional");

    // Muestra la información adicional cambiando el estilo de display
    infoAdicional.style.display = "block";
}
</script>

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
</script>

