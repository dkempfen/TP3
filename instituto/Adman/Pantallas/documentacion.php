<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Adman/includes/header.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Includes/load.php';
?>

<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i>Archivo</h1>
            <button class="btn btn-success" type="button" onclick="openModalD()">Agregar Archivo</button>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="#">Archivo</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered" id="tabledoc">
                            <thead>
                                <tr>
                                   
                                    <th>Nombre Archivo</th>
                                    <th>Materia</th>
                                    <th>Fecha</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="messageFecha">
                                <?php
                                // Comprueba si la consulta fue exitosa
                                $rowDocumentacion = obtenerDocumentos();
                                if ($rowDocumentacion) {
                                    // Loop a través del resultado y generar filas de la tabla
                                    foreach ($rowDocumentacion as $rowDocumentacion) {
                                        echo '<tr>';                                      
                                        echo '<td>' . $rowDocumentacion['Descripcion_Documentacion'] . '</td>';
                                        echo '<td>' . $rowDocumentacion['fk_Materia'] . '</td>';
                                         echo '<td>' . $rowDocumentacion['fk_Plan'] . '</td>';
                                        echo '<td><button class="btn-icon" onclick="ModalsFinalEditar(' . $rowDocumentacion['id_Documentacion'] . ')"><i class="edit-btn"></i>✏️</button></td>';
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


            </div>
        </div>
    </div>
</main>

<?php
require_once '../includes/footer.php';
?>