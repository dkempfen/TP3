<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Includes/load.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Adman/lista_planes.php';

$tableUsuarios = tableUsuarios();



?>

<?php
// Realiza una conexión a la base de datos (debes configurar tus propios detalles de conexión)

// Prepara y ejecuta la consulta SQL para obtener los datos de las asignaturas y profesores
$sql = "SELECT dp.Id_Detalle_Plan, p.Carrera, m.Anio_Carrera, m.Promocional, m.id_Materia, m.Descripcion, pr.Nombre, pr.Apellido,p.cod_Plan
        FROM Detalle_Plan dp
        LEFT JOIN Plan p ON p.cod_Plan = dp.fk_Plan 
        LEFT JOIN Materia m ON dp.fk_Materia = m.id_Materia
        LEFT JOIN Materia_Profesor mp ON dp.fk_Materia = mp.id_Materia
        LEFT JOIN Usuario u ON u.Id_Usuario = mp.id_Profesor
        LEFT JOIN Persona pr ON pr.DNI = u.fk_DNI";

$result = $pdo->query($sql);

?>


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
                <div class="table-responsive">
                    <table class="table table-hover table-bordered" id="tableUsuariosRol">
                        <thead>
                            <tr>
                                <th>NIVEL</th>
                                <th>Plan</th>
                                <th>Promocional</th>
                                <th>CÓDIGO</th>
                                <th>ASIGNATURA</th>
                                <th>Teacher</th>
                            </tr>
                        </thead>
                        <tbody id="message">
                            <?php
                                    if ($result) {
                                // La consulta se ejecutó con éxito, ahora verifica si hay resultados
                                if ($result->rowCount() > 0) {
                                    // Hay resultados, muestra los datos
                                    foreach ($result as $row) {
                                        echo '<tr>';
                                        echo '<td>' . $row['Anio_Carrera'] . '</td>';
                                        echo '<td>' . $row['cod_Plan'] . '</td>';
                                        echo '<td>' . $row['Promocional'] . '</td>';
                                        echo '<td>' . $row['id_Materia'] . '</td>';
                                        echo '<td>' . $row['Descripcion'] . '</td>';
                                        echo '<td>' . $row['Nombre'] . ' ' . $row['Apellido'] . '</td>';
                                        echo '</tr>';
                                    }
                                } else {
                                    echo "No se encontraron resultados para la consulta.";
                                }
                            } else {
                                // Hubo un error en la consulta, muestra un mensaje de error
                                echo "Error: " . $sql . "<br>" . $pdo->errorInfo()[2];
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script>
function mostrarInfoAdicional(codPlan) {
    $('#tablaModal').modal('show');
    
    console.log("Clic en Más Información con codPlan: " + codPlan);

    // Convertir codPlan en un número entero
    codPlan = parseInt(codPlan);

    // Ocultar todas las filas de la tabla
    $('#message tr').hide();

    var filasMostradas = 0;

    // Mostrar solo las filas que coinciden con el codPlan
    $('#message tr').each(function() {
        var codPlanEnFila = $(this).find('td:eq(1)').text();
        console.log("codPlanEnFila: " + codPlanEnFila);

        // Convertir codPlanEnFila en un número entero
        codPlanEnFila = parseInt(codPlanEnFila);

        if (codPlanEnFila === codPlan) {
            $(this).show();
            filasMostradas++;
        }
    });

    console.log("Filas mostradas: " + filasMostradas);
}
</script>
