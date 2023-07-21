<?php
require_once 'includes/header.php';
require_once 'includes/modals/modals.php';
require_once '../Includes/load.php';

if ($pdo) {
    // Query para obtener los datos de la tabla 'usuarios'
    $sql = "SELECT usuario_id, nombre, usuario, rol, estado FROM usuarios";
    $result = $pdo->query($sql);

    ?>



    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-dashboard"></i>Lista de Usuarios</h1>
                <button class="btn btn-success" type="button" onclick="openModal()">Nuevo Usuario</button>

            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
                <li class="breadcrumb-item"><a href="#">Lista de Usuarios</a></li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div class="tile-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered" id="tableUsuarios">
                                <thead>
                                    <tr>
                                        <th>ACCIONES</th>
                                        <th>ID</th>
                                        <th>NOMBRE</th>
                                        <th>USUARIO</th>
                                        <th>ROL</th>
                                        <th>ESTADO</th>
                                    
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Comprueba si la consulta fue exitosa
                                    if ($result) {
                                        // Loop a través del resultado y generar filas de la tabla
                                        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                            echo '<tr>';
                                            echo '<td class="form-check form-switch"><input class="ace ace-switch ace-switch-6"  type="checkbox" name="userCheckbox[]" value="true" checked="checked""' . $row['usuario_id'] . '"></td>';  
                                            echo '<td>' . $row['usuario_id'] . '</td>';
                                            echo '<td>' . $row['nombre'] . '</td>';
                                            echo '<td>' . $row['usuario'] . '</td>';
                                            echo '<td>' . $row['rol'] . '</td>';
                                            echo '<td>' . $row['estado'] . '</td>';
                                            echo '</tr>';
                                        }
                                    } else {
                                        echo "Error: " . $sql . "<br>" . $pdo->errorInfo()[2]; // Access the error message using errorInfo()
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

    
} else {
    echo "Error: No se pudo establecer la conexión a la base de datos.";
}
require_once 'includes/footer.php';
?>