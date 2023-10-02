<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.5/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.5/dist/sweetalert2.min.css">
</head>

<?php

require_once('load.php');

function showConfirmationMessages($message) {
    echo "<script>
        Swal.fire({
            icon: '" . $message['type'] . "',
            title: '" . $message['text'] . "',
            showConfirmButton: false,
            timer: 1500
        }).then(function() {                                  
            window.location.href = '/instituto/Adman/Pantallas/lista_personas.php';
        });
    </script>";
}       



function actualizarUser($idusuarioeditar, $dni, $nombre, $apellido, $fechanacimiento, $telefono, $email, $domicilio, $roleditar) {
    session_start();
    global $pdo;

    // Actualizar los campos de la tabla Persona
    $sql = "UPDATE Persona SET Nombre = ?, Apellido = ?, Fechanacimiento = ?, Telefono = ?, Email = ?, Domicilio = ? WHERE DNI = ?";
    $stmt = $pdo->prepare($sql);

    // Verifica si los valores son nulos antes de ejecutar la consulta
    $stmt->execute([$nombre, $apellido, $fechanacimiento, $telefono, $email, $domicilio, $dni]);

    if ($stmt->rowCount() > 0) {
        $_SESSION['message'] = [
            'type' => 'success',
            'text' => 'Datos de persona actualizados exitosamente'
        ];
    } else {
        $_SESSION['message'] = [
            'type' => 'error',
            'text' => 'Ha ocurrido un error al actualizar los datos de persona.'
        ];
    }

    header("Location: /instituto/Adman/Pantallas/lista_personas.php");
    exit();
}



// Verificar si se ha enviado una solicitud de modificación
if (isset($_POST['btnmodificar'])) {
    $idusuarioeditar = $_POST['idusuarioeditar'];
    $dni = $_POST['dnioeditar'];
    $nombre = $_POST['nombreeditar'];
    $apellido = $_POST['apellidoeditar'];
    $fechanacimiento = $_POST['fechanacimientoeditar'];
    $telefono = $_POST['telefonoeditar'];
    $email = $_POST['emailoeditar'];
    $domicilio = $_POST['domicilioeditar'];
    $roleditar = $_POST['roleditar'];

    actualizarUser($idusuarioeditar, $dni, $nombre, $apellido, $fechanacimiento, $telefono, $email, $domicilio, $roleditar);


    header("Location: /instituto/Adman/Pantallas/lista_personas.php");
    exit();

}



?>