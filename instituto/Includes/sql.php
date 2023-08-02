<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.5/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.5/dist/sweetalert2.min.css">
</head>

<?php
require_once('load.php');



function count_by_id($table)
{
  global $pdo;
  $sql = "SELECT COUNT(*) AS total FROM " . $table;
  $stmt = $pdo->prepare($sql);
  $stmt->execute();

  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  if ($row) {
    return $row['total'];
  }

  return 0; 
}
/*--------------------------------------------------------------*/
function count_id($table)
{
  global $pdo;
  $sql = "SELECT COUNT(*) AS total FROM " . $table;
  $stmt = $pdo->prepare($sql);
  $stmt->execute();

  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  if ($row) {
    return $row['total'];
  }

  return 0; 
}


/*--------------------------------------------------------------*/
function cambiarFotoPerfil($table)
{
  global $pdo;

  $sql = "SELECT nueva_foto FROM " . $table;
  $fotocambio = $pdo->prepare($sql);
  $fotocambio->execute();

  $rows = $fotocambio->fetch(PDO::FETCH_ASSOC);
  if ($rows) {
    return $rows['nueva_foto'];
  }

  return ""; 
}


function obtenerFotoPerfilActual()
{
 
  return $_SESSION['foto_perfil'];
}

////////////////////////////////////////////////////////////
function obtenerEstadoTodosUsuarios()
{
  global $pdo;
  $sql = "SELECT usuario_id, estado FROM usuarios";
  $stmt = $pdo->query($sql);
  $usersState = array();
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $usersState[$row['usuario_id']] = $row['estado'];
  }
  echo json_encode($usersState);
}

  if (isset($_POST['action'])) {
    $action = $_POST['action'];

    // Check the action and perform the corresponding operation
    if ($action === 'insert') {
        insertarNuevoUsuario();
    } elseif ($action === 'update') {
        actualizarUsuario();
    } 
  }
    function insertarNuevoUsuario()
    {
      session_start();
      $nombre = $_POST["nombre"];
      $usuario = $_POST["usuario"];
      $mail = $_POST["mail"];
      $clave = $_POST["clave"];
      $listRol = $_POST["listRol"];
      $listEstado = isset($_POST["listEstado"]) ? intval($_POST["listEstado"]) : 0;


      if (empty($nombre) || empty($usuario) || empty($mail) || empty($clave) || empty($listRol) || empty($listEstado)) {
        $_SESSION['message'] = [
          'type' => 'error',
          'text' => 'Debe completar todos los datos. Por favor, llene todos los campos requeridos.'
        ];
        return;
      }

      $rol = ($listRol == 1) ? "Administrador" : (($listRol == 2) ? "Profesor" : "Alumno");

      global $pdo;
      $sql = "SELECT rol_id FROM rol WHERE nombre_rol = ?";
      $stmt = $pdo->prepare($sql);
      $stmt->execute([$rol]);
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      if (!$result) {
        $_SESSION['message'] = [
          'type' => 'error',
          'text' => 'El rol seleccionado no existe.'
        ];
        return;
      }

      $rol_id = $result['rol_id'];


      $sql = "INSERT INTO usuarios (nombre, usuario, mail, clave, rol, estado) VALUES (?, ?, ?, ?, ?, ?)";
      $stmt = $pdo->prepare($sql);
      $stmt->execute([$nombre, $usuario, $mail, $clave, $rol_id, $listEstado]);

      if ($stmt->rowCount() > 0) {
        $_SESSION['message'] = [
          'type' => 'success',
          'text' => 'Usuario insertado exitosamente'
        ];
      } else {
        $_SESSION['message'] = [
          'type' => 'error',
          'text' => 'Ha ocurrido un error al insertar el usuario.'
        ];
      }
    }

    if (isset($_POST['nombre']) && isset($_POST['usuario']) && isset($_POST['mail']) && isset($_POST['clave']) && isset($_POST['listRol']) && isset($_POST['listEstado'])) {
      insertarNuevoUsuario();

      header("Location: /instituto/Adman/lista_usuarios.php");
      exit();
    }
    function actualizarUsuario()
    {
        session_start();
        $usuarioeditar_id = $_POST["idusuarioeditar"];
        $nombreeditar = $_POST["nombreeditar"];
        $maileditar = $_POST["maileditar"];
        $claveeditar = $_POST["claveeditar"];
        $roleditar = $_POST["listRoleditar"];
        $estadoeditar = $_POST["listEstadoeditar"];

  
    
        // Convert "listRoleditar" value to the corresponding role name
        $rol_modificar = ($roleditar == 1) ? "Administrador" : (($roleditar == 2) ? "Profesor" : "Alumno");
    
        global $pdo;
        // Check if the role exists in the database
        $sql = "SELECT rol_id FROM rol WHERE nombre_rol = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$rol_modificar]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if (!$result) {
            $_SESSION['message'] = [
                'type' => 'error',
                'text' => 'El rol seleccionado no existe.'
            ];
            return;
        }
    
        $roleditar_id = $result['rol_id'];
    
        // Prepare the SQL query for updating
        $updateQuery = "UPDATE usuarios SET";
        $params = [];
    
        // Build the update query and bind the parameters
        if (!empty($nombreeditar)) {
            $updateQuery .= " nombre = ?";
            $params[] = $nombreeditar;
        }
    
        if (!empty($maileditar)) {
            $updateQuery .= ", mail = ?";
            $params[] = $maileditar;
        }
        
        if (!empty($claveeditar)) {
          $updateQuery .= ", clave = ?";
          $params[] = $claveeditar;
      }
    
        if (!empty($roleditar_id)) {
            $updateQuery .= ", rol = ?";
            $params[] = $roleditar_id;
        }
    
        if (!empty($estadoeditar)) {
            $updateQuery .= ", estado = ?";
            $params[] = $estadoeditar;
        }
    
        $updateQuery .= " WHERE usuario_id = ?";
        $params[] = $usuarioeditar_id;
    
        if (empty($params)) {
            $_SESSION['message'] = [
                'type' => 'error',
                'text' => 'No se proporcionaron datos para actualizar. Debe completar al menos un campo.'
            ];
            return;
        }
    
        // Execute the update query
        $stmt = $pdo->prepare($updateQuery);
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
    if (isset($_POST['nombreeditar']) && isset($_POST['maileditar']) && isset($_POST['claveeditar']) && isset($_POST['listRoleditar']) && isset($_POST['listEstadoeditar'])) {
      actualizarUsuario();

      header("Location: /instituto/Adman/lista_usuarios.php");
      exit();
    }
    

if (isset($_POST['usuario_id']) && isset($_POST['estado'])) {
    $usuario_id = $_POST['usuario_id'];
    $estado = $_POST['estado'];

    $updateQuery = "UPDATE usuarios SET estado = :estado WHERE usuario_id = :usuario_id";
    $stmt = $pdo->prepare($updateQuery);
    $stmt->bindParam(':estado', $estado, PDO::PARAM_INT);
    $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Error updating user state']);
    }
   
} 



//////////////////////////////
function DatosUsuarios($table)
{
    global $pdo;

    $sql = "SELECT usuario_id,nombre, mail, clave, rol, estado FROM " . $table;
    $datosUsuarios = $pdo->prepare($sql);
    $datosUsuarios->execute();

    $rows = $datosUsuarios->fetchAll(PDO::FETCH_ASSOC);
    return $rows;
}
?>

