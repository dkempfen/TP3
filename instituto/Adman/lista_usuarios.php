<?php
require_once 'includes/header.php';
require_once 'includes/modals/modals.php';
require_once '../Includes/load.php';

if ($pdo) {
    // Query para obtener los datos de la tabla 'usuarios'
    $sql = "SELECT * from usuarios u INNER JOIN rol  r on u.rol=r.rol_id";
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
                                            echo '<td>' . $row['estado'] . '</td>';
                                            // Agregar un botón más pequeño en esta columna
                                
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
    $(document).ready(function () {
        // Carga de estado de usuarios al cargar la página
        $.ajax({
            url: "../Includes/sql.php",
            type: "POST",
            data: { get_users_state: true },
            success: function (data) {
                var usersState = JSON.parse(data);
                for (var usuario_id in usersState) {
                    var estado = usersState[usuario_id];
                    var checkbox = $('input[data-usuario-id="' + usuario_id + '"]');
                    checkbox.prop("checked", estado === "activo");
                }
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });

        $(".onoffswitch-checkbox").on("change", function () {
            var usuario_id = $(this).data("usuario-id");
            var estado = this.checked ? 'activo' : 'inactivo';

            $.ajax({
                url: "../Includes/sql.php",
                type: "POST",
                data: {
                    usuario_id: usuario_id,
                    estado: estado
                },
                success: function (response) {
                    console.log(response);
                    setTimeout(function () {
                        window.location.reload();
                    }, 2000);
                },
                error: function (xhr, status, error) {
                    console.error(error);
                }
            });
        });
    });
</script>