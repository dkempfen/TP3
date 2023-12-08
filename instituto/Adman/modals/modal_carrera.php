<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Includes/load.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Adman/subPantallas/lista_planes.php';

$tableUsuarios = tableUsuarios();





$DatosPlan = DatosPlan();

?>

<div class="modal fade" id="tablaModalMateria_" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tablaMostrarMateria"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="tablaModal" name="tablaModal" action="" method="POST" enctype="multipart/form-data">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered" id="tablePlanMateria">

                            <input type="hidden" name="codPlanMateria" id="codPlanMateria"
                                value="<?php echo $DatosPlan['cod_Plan'] ?>">

                            <thead>
                                <tr>
                                    <th>NIVEL</th>
                                    <th>Plan</th>
                                    <th>PROMOCIONAL</th>
                                    <th>CÓDIGO</th>
                                    <th>ASIGNATURA</th>
                                    <th>PROFESOR</th>
                                </tr>
                            </thead>
                            <tbody id="message">
                                <?php
                                // Verificar si se proporcionó el valor de cod_Plan
                                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cod_Plan'])) {
                                    // Obtener el valor de cod_Plan
                                    $cod_Plan = $_POST['cod_Plan'];
                                
                                    // Realizar la conexión a la base de datos y ejecutar la consulta SQL
                                    $sql = "SELECT *
                                            FROM Detalle_Plan dp
                                            INNER JOIN Plan p ON p.cod_Plan = dp.fk_Plan 
                                            INNER JOIN Materia m ON dp.fk_Materia = m.id_Materia
                                            INNER JOIN Materia_Profesor mp ON dp.fk_Materia = mp.id_Materia
                                            INNER JOIN Usuario u ON u.Id_Usuario = mp.id_Profesor
                                            INNER JOIN Persona pr ON pr.DNI = u.fk_DNI
                                            WHERE p.cod_Plan = :cod_Plan
                                            ORDER BY m.Anio_Carrera DESC";
                                
                                    $stmt = $pdo->prepare($sql);
                                    $stmt->bindParam(':cod_Plan', $cod_Plan, PDO::PARAM_INT);
                                    $stmt->execute();
                                
                                    // Verificar si la consulta fue exitosa
                                    if ($stmt) {
                                        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                
                                        // Verificar si se encontraron resultados
                                        if ($stmt->rowCount() > 0) {
                                            // Construir la tabla HTML con los resultados
                                            foreach ($result as $row) {
                                                echo '<tr>';
                                                echo '<td>' . $row['Anio_Carrera'] . '</td>';
                                                echo '<td>' . $row['cod_Plan'] . '</td>';
                                                echo '<td>' . $row['Promocional'] . '</td>';
                                                echo '<td>' . $row['id_Materia'] . '</td>';
                                                echo '<td>' . $row['Descripcion'] . '</td>';
                                                echo '<td>' . $row['Nombre'] . ' ' . $row['Apellido'] . '</td>';
                                                echo '<td>';
                                                // Agrega el campo oculto con un ID único
                                                echo '</td>';
                                                echo '</tr>';
                                            }
                                        } else {
                                            // Mensaje si no se encontraron resultados
                                            echo "No se encontraron resultados para la consulta.";
                                        }
                                    } else {
                                        // Manejar el caso de un error en la consulta SQL
                                        echo "Error en la consulta SQL: " . $sql . "<br>" . $stmt->errorInfo()[2];
                                    }
                                } else {
                                    // Manejar el caso en el que no se proporciona cod_Plan
                                    echo "Error: No se proporcionó un valor válido para cod_Plan.";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </form>

            </div>
            <div class="modal-footer">
                <!-- Utiliza la variable $cod_Plan para el valor del campo oculto -->
                <input type="hidden" name="CodPlanMateria" id="CodPlanMateria" value="<?php echo $cod_Plan; ?>">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

