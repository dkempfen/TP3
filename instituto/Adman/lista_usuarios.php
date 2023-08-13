<?php
session_start();

require_once 'includes/header.php';
require_once './modals/modals.php';
require_once './models/usuarios/edidtar_user.php';
require_once '../Includes/load.php';

if ($pdo) {
    // Query para obtener los datos de la tabla 'usuarios'
    $sql = "SELECT * from usuarios u INNER JOIN rol  r on u.rol=r.rol_id";
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
                                    <th>EDITAR</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    // Comprueba si la consulta fue exitosa
                                    if ($result) {
                                        // Loop a través del resultado y generar filas de la tabla
                                        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                            echo '<tr>';
                                            echo '<td class="">';
                                            echo '<label class="switch">';
                                            // Aquí agregamos un ternario para comprobar si el estado está activado o no
                                            $checked = ($row['estado'] == 1) ? 'checked' : '';
                                            echo '<input class="onoffswitch-checkbox" type="checkbox" name="onoffswitch" value="true" ' . $checked . ' data-usuario-id="' . $row['usuario_id'] . '">';
                                            echo '<span class="slider"></span>';
                                            echo '</label>';
                                            echo '</td>';
                                            echo '<td>' . $row['usuario_id'] . '</td>';
                                            echo '<td>' . $row['nombre'] . '</td>';
                                            echo '<td>' . $row['usuario'] . '</td>';
                                            echo '<td>' . $row['nombre_rol'] . '</td>';                                        
                                            echo '<td><button class="btn btn-sm btn-warning edit-link" onclick="openModals(' . $row['usuario_id'] . ')">Editar</button></td>';
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
</main>

<?php
} else {
    echo "Error: No se pudo establecer la conexión a la base de datos.";
}
require_once 'includes/footer.php';
?>



<script>
$(document).ready(function() {
    var tableusuarios = $('#tableUsuarios').DataTable();

    $('#tableUsuarios').on("change", ".onoffswitch-checkbox", function() {
        var self = this;
        var usuario_id = $(this).data("usuario-id");
        var estado = this.checked ? 1 : 0;

        $.ajax({
            url: "/instituto/Includes/sql.php",
            type: "POST",
            data: {
                usuario_id: usuario_id,
                estado: estado
            },
            dataType: "json",
            success: function(response) {
                console.log(response);

                if (response.hasOwnProperty('success') && response.success) {
                    var estadoText = estado == 1 ? "Activo" : "Inactivo";
                    $(self).closest("td").prev().text(estadoText);

                    Swal.fire({
                        icon: "success",
                        title: "Estado actualizado",
                        showConfirmButton: false,
                        timer: 1500
                    });
                } else {
                    console.log("Error en la respuesta del servidor:", response);

                    Swal.fire({
                        icon: "error",
                        title: "Error al actualizar el estado",
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            },
            error: function(xhr, status, error) {
                console.log("Error en la solicitud AJAX:", error);
                console.log("Response:", xhr.responseText);

                Swal.fire({
                    icon: "error",
                    title: "Estado actualizado",
                    showConfirmButton: false,
                    timer: 1500
                });
            }
        });
    });
});
</script>