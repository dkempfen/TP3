<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.5/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.5/dist/sweetalert2.min.css">
</head>

<?php
require_once('load.php');


///editar user///////

function actualizarUsuario() 
{
    session_start();
    $usuario = isset($_POST["usuario"]) ? $_POST["usuario"] : null;
    $listEstado = isset($_POST["listEstado"]) ? intval($_POST["listEstado"]) : 0;

    $rol_id = null;
    if (isset($_POST["listRol"])) {
        $listRol = $_POST["listRol"];
        $rol = ($listRol == 1) ? "Administrador" : (($listRol == 2) ? "Profesor" : "Alumno");

        global $pdo;
        $sql = "SELECT rol_id FROM rol WHERE nombre_rol = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$rol]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            $rol_id = $result['rol_id'];
        } else {
            $_SESSION['message'] = [
                'type' => 'error',
                'text' => 'El rol seleccionado no existe.'
            ];
            return;
        }
    }

    $sql = "UPDATE usuarios 
            SET ";
    $params = array();

    if (!empty($_POST["nombre"])) {
        $sql .= "nombre = ?";
        $params[] = $_POST["nombre"];
    }
    if (!empty($_POST["mail"])) {
        $sql .= ", mail = ?";
        $params[] = $_POST["mail"];
    }
    if (!empty($_POST["clave"])) {
        $sql .= ", clave = ?";
        $params[] = $_POST["clave"];
    }
    if ($rol_id !== null) {
        $sql .= ", rol = ?";
        $params[] = $rol_id;
    }
    
    $sql .= ", estado = ? WHERE usuario = ?"; 
    $params[] = $listEstado;
    $params[] = $usuario;

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    if ($stmt->rowCount() > 0) {
        $_SESSION['message'] = [
            'type' => 'success',
            'text' => 'Usuario actualizado exitosamente'
        ];
    } else {
        $_SESSION['message'] = [
            'type' => 'error',
            'text' => 'Ha ocurrido un error al actualizar el usuario.'
        ];
    }
}

?>