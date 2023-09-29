<?php
require_once '../includes/header.php';
require_once './modals/modals.php';
require_once './models/usuarios/edidtar_user.php';
require_once '../Includes/load.php';

if ($pdo) {
    // Query para obtener los datos de la tabla 'usuarios'
    $sql = "SELECT * from Usuario u INNER JOIN Rol  r on u.fk_Rol=r.id_Rol
   INNER JOIN Persona p ON p.DNI = u.fk_DNI
   INNER JOIN Estado e on e.Id_Estado= u.fk_Estado_Usuario";
    $result = $pdo->query($sql);
    // Check if there's a message in the session

    if (isset($_SESSION['message'])) {
        $message = $_SESSION['message'];
        unset($_SESSION['message']); // Clear the session variable after displaying the message
        showConfirmationMessage($message);
    }

    ?>

<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i>Lista de Personas</h1>

        </div>



    </div>

    <div class="row">
        <div class="col-lg-6 text-left">
            <!-- Divide la fila en 2 columnas y alinea a la izquierda -->
            <a id="generarPDFBtn" href="#" onclick="descargarMateriaPDF(); return false;" class="planpdf-button">
                <i class="fas fa-file-pdf"></i> Descargar PDF
            </a>

            <a id="generarEXCELBtn" href="#" onclick="descargarMateriaEXCEL(); return false;" class="planexcel-button">
                <i class="fas fa-file-excel"></i> Descargar Excel
            </a>
        </div>

        <div class="col-lg-6 text-right">
            <!-- Divide la fila en 2 columnas y alinea a la derecha -->
            <button class="Usernalta-button" id="crearNuevaCarreraBtn" type="button" data-toggle="modal"
                onclick="openModal()"><i class="fas fa-plus"></i> Nuevo Usuario</button>
        </div>
    </div>
    <div class="mt-4">
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
                                        <th>Legajo</th>
                                        <th>USUARIO</th>
                                        <th>Plan</th>
                                        <th>DNI</th>
                                        <th>ROL</th>
                                        <th>EDITAR</th>
                                    </tr>
                                </thead>
                                <tbody id="message">
                                    <?php
                                // Comprueba si la consulta fue exitosa
                                if ($result) {
                                    // Loop a través del resultado y generar filas de la tabla
                                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                        echo '<tr>';
                                        echo '<td class="">';
                                        echo '<label class="switch">';
                                        // Aquí agregamos un ternario para comprobar si el estado está activado o no
                                        $checked = ($row['fk_Estado_Usuario'] == 1) ? 'checked' : '';
                                        echo '<input class="onoffswitch-checkbox" type="checkbox" name="onoffswitch" value="true" ' . $checked . ' data-usuario-id="' . $row['Id_Usuario'] . '">';
                                        echo '<span class="slider"></span>';
                                        echo '</label>';
                                        echo '</td>';
                                        echo '<td>' . $row['Id_Usuario'] . '</td>';
                                        echo '<td>' . $row['Nombre'] . '</td>';
                                        echo '<td>' . $row['User'] . '</td>';
                                        echo '<td>' . $row['Legajo'] . '</td>';
                                        echo '<td>' . $row['fk_Plan'] . '</td>';
                                        echo '<td>' . $row['fk_DNI'] . '</td>';
                                        echo '<td>' . $row['fk_Rol'] . '</td>';
                                        echo '<td><button class="btn btn-sm btn-warning edit-link" onclick="openModals(' . $row['Id_Usuario'] . ')">Editar</button></td>';
                                        echo '</tr>';
                                    }
                                } else {
                                    echo "Error: " . $sql . "<br>" . $pdo->errorInfo()[2]; // Acceder al mensaje de error usando errorInfo()
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/TableExport/5.2.0/js/tableexport.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.4/xlsx.full.min.js"></script>

<script>
$(document).ready(function() {
    var tableusuarios = $('#tableUsuarios').DataTable();

    $('#tableUsuarios').on("change", ".onoffswitch-checkbox", function() {
        var self = this;
        var Id_Usuario = $(this).data("usuario-id");
        var fk_Estado_Usuario = this.checked ? 1 : 2;

        $.ajax({
            url: "/instituto/Includes/sql.php", // Reemplaza con la ruta correcta a tu archivo PHP
            type: "POST",
            data: {
                Id_Usuario: Id_Usuario,
                fk_Estado_Usuario: fk_Estado_Usuario
            },

            success: function(response) {
                var messageDiv = $('#message'); // Elemento donde se mostrará el mensaje
                messageDiv.html(response); // Coloca el mensaje en el elemento
                setTimeout(function() {
                    messageDiv.html(''); // Borra el mensaje después de un tiempo
                    window.location.reload(); // Recarga la página si es necesario
                }, 2000);
            },
            error: function(error) {
                console.log("Error en la solicitud AJAX:", error);
            }
        });
    });
});

function exportToExcel() {
    // Utiliza la biblioteca TableExport para exportar la tabla a Excel
    TableExport(document.getElementById('tableUsuarios'), {
        headers: true,
        footers: true,
        formats: ['xlsx'],
        filename: 'listado_usuarios',
    });
}
</script>