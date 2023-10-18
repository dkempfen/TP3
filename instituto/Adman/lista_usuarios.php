<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Adman/includes/header.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Includes/load.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Adman/models/editarModelesUser.php';


?>

<?php
if ($pdo) {
    // Inicializamos la variable $result
    $result = null;

    // Verifica si se ha pasado un parámetro 'rol' en la URL
    if (isset($_GET['rol'])) {
        $rolSeleccionado = $_GET['rol'];
        // Query para obtener los datos de la tabla 'usuarios' filtrados por el rol seleccionado
        $sql = "SELECT *
            FROM Usuario u
            INNER JOIN Rol r ON u.fk_Rol = r.id_Rol
            WHERE r.id_Rol = :rol";
        // Prepara la consulta
        $stmt = $pdo->prepare($sql);
        // Enlaza el valor del parámetro
        $stmt->bindParam(':rol', $rolSeleccionado, PDO::PARAM_STR);
        // Ejecuta la consulta
        $stmt->execute();
        // Asigna el resultado a la variable $result
        $result = $stmt;
    } else {
        // Si no se ha pasado un parámetro 'rol', ejecuta la consulta sin filtrar por rol
        $sql = "SELECT *
            FROM Usuario u
            INNER JOIN Rol r ON u.fk_Rol = r.id_Rol";
        $result = $pdo->query($sql);
    }

    if (isset($_SESSION['message'])) {
        $message = $_SESSION['message'];
        unset($_SESSION['message']); // Clear the session variable after displaying the message
        showConfirmationMessageUser($message);
    }
    if (isset($_SESSION['message'])) {
        $message = $_SESSION['message'];
        unset($_SESSION['message']); // Clear the session variable after displaying the message
        showConfirmationMessage($message);
    }


?>


<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i>Lista de Usuario</h1>

        </div>



    </div>
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form id="busquedaForm" class="form-row align-items-end mx-auto">
                        <div class="form-group col-md-4 mb-2">
                            <label for="dni" class="text-center">DNI:</label>
                            <input type="number" class="form-control mx-auto" id="dniBusquedaUser">
                        </div>
                        <div class="form-group col-md-4 mb-2">
                            <label for="nombreUser" class="text-center">Legajo:</label>
                            <input type="text" class="form-control mx-auto" id="nombreLegajoBusqueda">
                        </div>
                        <div class="form-group col-md-4 mb-2">
                            <label for="apellidoUser" class="text-center">Usuario:</label>
                            <input type="text" class="form-control mx-auto" id="UserBusqueda">
                        </div>



                    </form>
                </div>
            </div>
        </div>
    </div>



    <div class="row mt-4">
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
            <a class="Usernalta-button" id="botnAterior"
                href="/instituto/Adman/Pantallas/pantalla_Usuario.php">Anterior</a>
        </div>




    </div>
    <div class="mt-4">
        <div class="row">


            <div class="col-md-12">
                <div class="tile">
                    <div class="tile-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered" id="tableUsuariosRol">
                                <thead>
                                    <tr>
                                        <th>ACCIONES</th>
                                        <th>ID</th>
                                        <th>Legajo</th>
                                        <th>USUARIO</th>
                                        <th>Libro Matriz</th>
                                        <th>Plan</th>
                                        <th>ROL</th>
                                        <th>DNI</th>
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
                                        echo '<td>' . $row['Legajo'] . '</td>';
                                        echo '<td>' . $row['User'] . '</td>';
                                        echo '<td>' . $row['Libromatriz'] . '</td>';
                                        echo '<td>' . $row['fk_Plan'] . '</td>';
                                        echo '<td>' . $row['descripcion'] . '</td>';
                                        echo '<td>' . $row['fk_DNI'] . '</td>';
                                        //echo '<td>' . ($row['Inscripto'] ? 'Inscrito' : 'No Inscrito') . '</td>';
                                        echo '<td><button class="btn-icon" onclick="openModalsUserEdi(' . $row['Id_Usuario'] . ')"><i class="edit-btn"></i>✏️</button></td>';
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
require_once '../includes/footer.php';
?>

<script>
$(document).ready(function() {


    $('#tableUsuariosRol').on("change", ".onoffswitch-checkbox", function() {
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
</script>