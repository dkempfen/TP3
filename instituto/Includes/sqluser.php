<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.5/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.5/dist/sweetalert2.min.css">
</head>

<?php

require_once('load.php');

function showConfirmationMessageUser($message, $rolUserEditar) {
    echo "<script>
        Swal.fire({
            icon: '" . $message['type'] . "',
            title: '" . $message['text'] . "',
            showConfirmButton: false,
            timer: 1500
        }).then(function() {";
            
  /*  if ($rolUserEditar == 3) {
        echo "window.location.href = '/instituto/Adman/lista_usuarios.php?rol=3';";
    } elseif ($rolUserEditar == 2) {
        echo "window.location.href = '/instituto/Adman/lista_usuarios.php?rol=2';";
    } elseif ($rolUserEditar == 1) {
        echo "window.location.href = '/instituto/Adman/lista_usuarios.php?rol=1';";
    } else {
        echo "window.location.href = '/instituto/Adman/lista_usuarios.php';";
    }*/

    echo "});
    </script>";
}

function showConfirmationMessagePlan($messagePlan) {
    echo "<script>
        Swal.fire({
            icon: '" . $messagePlan['type'] . "',
            title: '" . $messagePlan['text'] . "',
            showConfirmButton: false,
            timer: 1500
        }).then(function() {                                  
            window.location.href = '/instituto/Adman/lista_planes.php';

        });
    </script>";
}       

 
function showConfirmationMessageEditarPlan($messageEditarPlan) {
    echo "<script>
        Swal.fire({
            icon: '" . $messageEditarPlan['type'] . "',
            title: '" . $messageEditarPlan['text'] . "',
            showConfirmButton: false,
            timer: 1500
        }).then(function() {                                  
            window.location.href = '/instituto/Adman/lista_planes.php';

        });
    </script>";
}     


function showConfirmationMessagesNotas($messageNota) {
    echo "<script>
        Swal.fire({
            icon: '" . $messageNota['type'] . "',
            title: '" . $messageNota['text'] . "',
            showConfirmButton: false,
            timer: 1500
        }).then(function() {                                  
            window.location.href = '/instituto/Adman/Pantallas/Notas.php';
        });
    </script>";
}  




///////////////Actuañ Datos Pantalla User///////////////////////
function editarUsuarios($legajoUser, $claveeditaruser, $libromatrizEditar, $planUserEditar, $rolUserEditar, $UserId) {
    session_start();
    global $pdo;

    $sql = "UPDATE Usuario SET Legajo = ?, Password = ?, Libromatriz = ?, fk_Plan = ?, fk_Rol = ? WHERE Id_Usuario = ?";
    $stmt = $pdo->prepare($sql);

    // Verifica si los valores son nulos antes de ejecutar la consulta
    $stmt->execute([$legajoUser, $claveeditaruser, $libromatrizEditar, $planUserEditar, $rolUserEditar, $UserId]);

    if ($stmt->rowCount() > 0) {
        $_SESSION['message'] = [
            'type' => 'success',
            'text' => 'Datos del usuario actualizados exitosamente'
        ];
    } else {
        $_SESSION['message'] = [
            'type' => 'error',
            'text' => 'Ha ocurrido un error al actualizar los datos del usuario.'
        ];
    }

    // Redirige a la página de lista de usuarios manteniendo el parámetro 'rol' en la URL
    if (isset($_GET['rol'])) {
        $rol = $_GET['rol'];
        header("Location: /instituto/Adman/lista_usuarios.php?rol=$rol");
    } else {
        header("Location: /instituto/Adman/lista_usuarios.php");
    }
    exit();
}






// Verificar si se ha enviado una solicitud de edición (update)
if (isset($_POST['btnmodificarUsuario'])) {
    $UserId = $_POST['UserId'];
    $dniUserEditar = $_POST['dniUserEditar'];
    $legajoUser = $_POST['Legajoeditar'];
    $claveeditaruser = $_POST['claveeditaruser'];
    $libromatrizEditar = $_POST['libromatrizEditar'];
    $planUserEditar = $_POST['planUserEditar'];
    $rolUserEditar = $_POST['rolUserEditar'];

    // Llamar a la función editarUsuarios solo si los campos requeridos no están vacíos
    editarUsuarios($legajoUser, $claveeditaruser, $libromatrizEditar, $planUserEditar, $rolUserEditar, $UserId);
}

///////////////Actuañ Datos Pantalla User///////////////////////
if (isset($_POST['btnmodificarPlan'])) {
    $cod_Plan = $_POST['cod_Plan'];
    $nombreTarjeta = $_POST['nombreTarjeta'];
    $estadoTarjeta = $_POST['estadoTarjeta'];
    $fechaInicio = $_POST['fechaInicio'];
    $fechaFinal = $_POST['fechaFinal'];

    // Nombre del archivo adjunto
    $nombreArchivo = $_FILES["archivoPlan"]["name"];
    $archivoTemporal = $_FILES["archivoPlan"]["tmp_name"];
    $type = $_FILES["archivoPlan"]["type"];
    $size = $_FILES["archivoPlan"]["size"];
    $folder = $_SERVER['DOCUMENT_ROOT'] . '/instituto/documentos/plan/'; // Ruta donde deseas almacenar los documentos
    $rutaArchivo = $folder . $nombreArchivo;

    // Verifica si los campos requeridos no están vacíos
    if (!empty($nombreTarjeta) && !empty($estadoTarjeta) && !empty($fechaInicio) && !empty($fechaFinal)) {
        // Llama a la función guardarCambios
        guardarCambios($nombreTarjeta, $estadoTarjeta, $fechaInicio, $fechaFinal, $cod_Plan, $rutaArchivo, $nombreArchivo);

        // Mueve el archivo desde la ubicación temporal a la carpeta de destino
        if (move_uploaded_file($archivoTemporal, $rutaArchivo)) {
            // El archivo se ha movido correctamente
        } else {
            // Error al mover el archivo
            echo "Error al subir el archivo.";
        }

        header("Location: /instituto/Adman/lista_planes.php");
        exit();
    } else {
        echo "Los campos requeridos no pueden estar vacíos.";
    }
}

function guardarCambios($nombreTarjeta, $estadoTarjeta, $fechaInicio, $fechaFinal, $cod_Plan) {
    session_start();
    global $pdo;

    // SQL para actualizar la información del plan
    $sql = "UPDATE Plan SET Carrera = ?, Estado_Id_Estado = ?, Fecha_Inicio = ?, Fecha_Final = ? WHERE cod_Plan = ?";
    $stmt = $pdo->prepare($sql);

    // Verifica si los valores son nulos antes de ejecutar la consulta
    $stmt->execute([$nombreTarjeta, $estadoTarjeta, $fechaInicio, $fechaFinal, $cod_Plan]);

    if ($stmt->rowCount() > 0) {
        $_SESSION['messageEditarPlan'] = [
            'type' => 'success',
            'text' => 'Datos del plan actualizados exitosamente'
        ];
    } else {
        $_SESSION['messageEditarPlan'] = [
            'type' => 'error',
            'text' => 'Error al actualizar los datos del plan. Detalles del error: ' . implode(' | ', $stmt->errorInfo())
        ];
    }
}

///////////////////////////////////////////////////

function InsertarPlan($nombreTarjetaCrear, $CarreraCrear, $fechaInicioCrear, $fechaFinalCrear, $estadoPlanCrear) {
    session_start();
    global $pdo;
    

    $sql = "INSERT INTO Plan (cod_Plan, Carrera, Fecha_Inicio, Fecha_Final,Estado_Id_Estado) VALUES (?, ?, ?, ?,?)";
    $stmt = $pdo->prepare($sql);

    // Verifica si los valores son nulos antes de ejecutar la consulta
    $stmt->execute([$nombreTarjetaCrear, $CarreraCrear, $fechaInicioCrear, $fechaFinalCrear, $estadoPlanCrear]);

    if ($stmt->rowCount() > 0) {
        $_SESSION['messagePlan'] = [
            'type' => 'success',
            'text' => 'Datos del plan crear exitosamente'
        ];
    } else {
        $_SESSION['messagePlan'] = [
            'type' => 'error',
            'text' => 'Ha ocurrido un error al crear los datos del plan.'
        ];
    }

    header("Location: /instituto/Adman/lista_planes.php");
    exit();
}

// Verificar si se ha enviado una solicitud de edición (update)
if (isset($_POST['btnmCrearPlan'])) {
    $nombreTarjetaCrear = $_POST['nombreTarjetaCrear']; // Asegúrate de obtener el código de plan desde el formulario
    $CarreraCrear = $_POST['CarreraCrear'];
    $fechaInicioCrear = $_POST['fechaInicioCrear'];
    $fechaFinalCrear = $_POST['fechaFinalCrear'];
    $estadoPlanCrear = $_POST['estadoPlanCrear'];

   

    // Llamar a la función EditarPersona solo si los campos requeridos no están vacíos
    InsertarPlan($nombreTarjetaCrear, $CarreraCrear, $fechaInicioCrear, $fechaFinalCrear, $estadoPlanCrear);

    header("Location: /instituto/Adman/lista_planes.php");
    exit();
}



function insertarNuevaNota($alumnoNota, $LegajoNota, $materia, $anioMateria, $estadoMateria, $parcial1, $recuperatorio1, $parcial2, $recuperatorio2, $finalnota, $promedio) {
    session_start();
    global $pdo;

    $recuperatorio1 = isset($recuperatorio1) ? $recuperatorio1 : 0;
    $parcial2 = isset($parcial2) ? $parcial2 : 0;
    $recuperatorio2 = isset($recuperatorio2) ? $recuperatorio2 : 0;
    $finalnota = isset($finalnota) ? $finalnota : 0;
    $promedio = isset($promedio) ? $promedio : 0;

    $sql = "INSERT INTO DetalleCursada 
            (fk_Usuario, fk_Legajo, fk_Materia, Anio, fk_Estado, Primer_Parcial, Recuperatio_Parcial_1, 
            Segundo_Parcial, Recuperatio_Parcial_2, Final, Promedio)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$alumnoNota, $LegajoNota, $materia, $anioMateria, $estadoMateria, $parcial1, $recuperatorio1, $parcial2, $recuperatorio2, $finalnota,$promedio]);


    if ($stmt->rowCount() > 0) {
        $_SESSION['messageNota'] = [
            'type' => 'success',
            'text' => 'Nota insertada exitosamente.'
        ];
    } else {
        $_SESSION['messageNota'] = [
            'type' => 'error',
            'text' => 'Ha ocurrido un error al insertar la nota.'
        ];
    }

    header("Location: /instituto/Adman/Pantallas/Notas.php");
    exit();
}

// Verificar si se ha enviado una solicitud de inserción
if (isset($_POST['btnmCrearNota'])) {
    $alumnoNota = $_POST['alumnoNota'];
    $LegajoNota = $_POST['LegajoNota'];
    $materia = $_POST['materia'];
    $anioMateria = $_POST['anioMateria'];
    $estadoMateria = $_POST['estadoMateria'];
    $parcial1 = $_POST['parcial1'];
    $recuperatorio1 = $_POST['recuperatorio1'];
    $parcial2 = $_POST['parcial2'];
    $recuperatorio2 = $_POST['recuperatorio2'];
    $finalnota = $_POST['finalnota'];
    $promedio = $_POST['promedio'];

    insertarNuevaNota($alumnoNota, $LegajoNota, $materia, $anioMateria, $estadoMateria, $parcial1, $recuperatorio1, $parcial2, $recuperatorio2, $finalnota,$promedio);
    header("Location: /instituto/Adman/Pantallas/Notas.php");
    exit();
}

////////////////actualizar archivo plan///////////

function insertarDocumento($cod_Plan, $nombreArchivo, $rutaArchivo) {
    global $pdo;

    // Estado predeterminado (puedes cambiarlo según tus necesidades)
    $estadoDocumentacion = 1;

    try {
        // SQL para insertar o actualizar información del documento adjunto
        $sql = "INSERT INTO Documentacion (Descripcion_Documentacion, Estado_Documentacion, Ubicacion, fk_Plan) 
                VALUES (?, ?, ?, ?) 
                ON DUPLICATE KEY UPDATE Descripcion_Documentacion = VALUES(Descripcion_Documentacion), 
                                            Estado_Documentacion = VALUES(Estado_Documentacion), 
                                            Ubicacion = VALUES(Ubicacion)";
        $stmt = $pdo->prepare($sql);

        // Ejecutar la consulta
        $stmt->execute([$nombreArchivo, $estadoDocumentacion, $rutaArchivo, $cod_Plan]);

        return $stmt->rowCount(); // Devuelve el número de filas afectadas
    } catch (PDOException $e) {
        // Manejar errores de la base de datos según tus necesidades
        echo "Error en la base de datos: " . $e->getMessage();
        return 0; // Indica que no se pudo completar la operación
    }
}

  
///////////////ActualizarNuevaNota
function ActualizarNuevaNota($idMateriaEditar, $parcial1Editar, $recuperatorio1Editar, $parcial2Editar, $recuperatorio2Editar, $finalnotaEditar) {
    session_start();
    global $pdo;

    $sql = "UPDATE DetalleCursada SET Primer_Parcial = ?, Recuperatio_Parcial_1 = ?, 
            Segundo_Parcial = ?, Recuperatio_Parcial_2 = ?, Final = ? WHERE id_Cursada = ?";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$parcial1Editar, $recuperatorio1Editar, $parcial2Editar, $recuperatorio2Editar, $finalnotaEditar,$idMateriaEditar]);

    if ($stmt->rowCount() > 0) {
        $_SESSION['messageNota'] = [
            'type' => 'success',
            'text' => 'Nota actualizada exitosamente.'
        ];
        // Agrega un mensaje al array de resultados para mostrar en la consola
        $result['consoleLog'] = 'Nota actualizada exitosamente.';
    } else {
        $_SESSION['messageNota'] = [
            'type' => 'error',
            'text' => 'Ha ocurrido un error al actualizar la nota.'
        ];
        // Agrega un mensaje al array de resultados para mostrar en la consola
        $result['consoleLog'] = 'Error al actualizar la nota.';
    }

    header("Location: /instituto/Adman/Pantallas/Notas.php");
    exit();
}

// Verificar si se ha enviado una solicitud de actualización
if (isset($_POST['btnmCrearNotaEditar'])) {
    $idMateriaEditar = $_POST['idMateriaEditar'];
    $parcial1Editar = $_POST['parcial1Editar'];
    $recuperatorio1Editar = $_POST['recuperatorio1Editar'];
    $parcial2Editar = $_POST['parcial2Editar'];
    $recuperatorio2Editar = $_POST['recuperatorio2Editar'];
    $finalnotaEditar = $_POST['finalnotaEditar'];

    ActualizarNuevaNota($idMateriaEditar,$parcial1Editar, $recuperatorio1Editar, $parcial2Editar, $recuperatorio2Editar, $finalnotaEditar);
    header("Location: /instituto/Adman/Pantallas/Notas.php");

    exit();
}


// Define la función para obtener resultados de búsqueda
function obtenerResultadosBusqueda($dni, $nombre, $apellido, $usuario, $carrera, $plan) {
    // Aquí debes implementar la lógica para obtener los resultados de búsqueda
    // Puedes realizar consultas a tu base de datos u otras operaciones según sea necesario
    // Devuelve los resultados, por ejemplo, un array de resultados
    $resultados = array();

    // Ejemplo: $resultados = tu_logica_de_busqueda($dni, $nombre, $apellido, $usuario, $carrera, $plan);

    return $resultados;
}

// Define la función para generar HTML a partir de los resultados
function generarHtmlResultados($resultados) {
    // Aquí debes implementar la generación de HTML basada en los resultados obtenidos
    // Puedes recorrer los resultados y construir el HTML según tu estructura deseada
    $html = '<div class="resultados">';
    foreach ($resultados as $resultado) {
        $html .= '<p>' . $resultado['nombre'] . ': ' . $resultado['detalle'] . '</p>';
    }
    $html .= '</div>';

    return $html;
}

// Define la función para procesar la búsqueda
/*function procesarBusqueda() {
    // Tu lógica de conexión a la base de datos y demás...

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Obtener datos de búsqueda
        $dni = $_POST['dni'];
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $usuario = $_POST['usuario'];
        $carrera = $_POST['carrera'];
        $plan = $_POST['plan'];

        // Realizar la consulta con los datos de búsqueda y obtener los resultados
        $resultados = obtenerResultadosBusqueda($dni, $nombre, $apellido, $usuario, $carrera, $plan);

        // Devolver el HTML actualizado
        echo generarHtmlResultados($resultados);
    }

    // ... Tu otro código PHP ...
}

// Llamar a la función para procesar la búsqueda
procesarBusqueda();*/
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Obtener los parámetros de la URL
    $dni = isset($_GET['dniAlmno']) ? $_GET['dniAlmno'] : '';
    $nombre = isset($_GET['btnBuscarAlumnosNombre']) ? $_GET['btnBuscarAlumnosNombre'] : '';
    $apellido = isset($_GET['btnBuscarAlumnosApellido']) ? $_GET['btnBuscarAlumnosApellido'] : '';

    // Llamar a la función buscarAlmno con los parámetros obtenidos
    $results = buscarAlmno($pdo, $dni, $nombre, $apellido);

    if (count($results) > 0) {
        // Mostrar la tabla solo si hay resultados
        echo '<table id="calificaciones-table">';
        echo '<thead>';
        // ... tu código para imprimir las cabeceras de la tabla ...
        echo '</thead>';
        echo '<tbody>';
        // ... tu código para imprimir los resultados de la búsqueda ...
        echo '</tbody></table>';
    } else {
        // Si no hay resultados, puedes imprimir un mensaje o simplemente no hacer nada
        // echo "Sin resultados";
    }
}

function buscarAlmno($pdo, $dni, $nombre, $apellido)
{
    $sql = "SELECT dc.id_Cursada, u.fk_DNI, p.Nombre, p.Apellido, dc.fk_Usuario, dc.fk_Legajo, dc.fk_Materia, m.Descripcion, dc.fk_Estado, dc.Primer_Parcial,
        dc.Recuperatio_Parcial_1, dc.Primer_TP, dc.Recuperatio_TP_1, dc.Segundo_Parcial, dc.Recuperatio_Parcial_2, dc.Segundo_TP,
        dc.Recuperatio_TP_2, dc.Promedio, dc.Anio, pn.cod_Plan, pn.Carrera, Final
        FROM DetalleCursada dc
        INNER JOIN Usuario u ON dc.fk_Usuario = u.Id_Usuario
        INNER JOIN Persona p ON p.DNI = u.fk_DNI
        INNER JOIN Materia m ON m.id_Materia = dc.fk_Materia
        INNER JOIN Plan pn ON pn.cod_Plan = u.fk_Plan
        WHERE p.DNI LIKE :dni AND p.Nombre LIKE :nombre AND p.Apellido LIKE :apellido";

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':dni', "%$dni%", PDO::PARAM_STR);
    $stmt->bindValue(':nombre', "%$nombre%", PDO::PARAM_STR);
    $stmt->bindValue(':apellido', "%$apellido%", PDO::PARAM_STR);

    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

?>