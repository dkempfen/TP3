<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.5/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.5/dist/sweetalert2.min.css">
</head>

<?php
require_once('load.php');
function showConfirmationMessage($message) {
  echo "<script>
      Swal.fire({
          icon: '" . $message['type'] . "',
          title: '" . $message['text'] . "',
          showConfirmButton: false,
          timer: 1500
      });
  </script>";
}

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

if (isset($_FILES["file"])) {
    global $pdo;
    $file = $_FILES["file"];
    $name = $file["name"];
    $type = $file["type"];
    $tmp_n = $file["tmp_name"];
    $size = $file["size"];

    $folder = "../Imagenes/profiles/";

    // Cambio de foto
    if ($type != 'image/jpg' && $type != 'image/jpeg' && $type != 'image/png' && $type != 'image/gif') {
        echo "<div class='alert alert-success' role='alert'>
            <button type='button' class='close' data-dismiss='alert'>&times;</button>
            Error, el archivo no es una imagen</div>";
    } else if ($size > 1024 * 1024) {
        echo "<div class='alert alert-success' role='alert'>
            <button type='button' class='close' data-dismiss='alert'>&times;</button>
            Error, el tamaño máximo permitido es un 1MB</div>";
    } else {
        $src = $folder . $name;
        if (move_uploaded_file($tmp_n, $src)) {
            $query = "UPDATE cambio_foto_perfil SET nueva_foto = ?";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(1, $name);
            if ($stmt->execute()) {
                echo "<div class='alert alert-success' role='alert'>
                    ¡Bien hecho! Perfil actualizado correctamente</div>";
            } else {
                echo "<div class='alert alert-danger' role='alert'>
                    Error al actualizar el perfil</div>";
            }
        } else {
            echo "<div class='alert alert-danger' role='alert'>
                Error al subir la imagen</div>";
        }
    }
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
  /////////////////////Actulizar Estado//////////////////////////////
 
  function actualizarEstadoUsuario($pdo, $usuario_id, $estado) {
    $updateQuery = "UPDATE usuarios SET estado = :estado WHERE usuario_id = :usuario_id";
    $stmt = $pdo->prepare($updateQuery);
    $stmt->bindParam(':estado', $estado, PDO::PARAM_INT);
    $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}

if (isset($_POST['usuario_id']) && isset($_POST['estado'])) {
    $usuario_id = $_POST['usuario_id'];
    $estado = $_POST['estado'];

    if (actualizarEstadoUsuario($pdo, $usuario_id, $estado)) {
        $_SESSION['message'] = [
            'type' => 'success',
            'text' => 'Estado de usuario actualizado exitosamente'
        ];
    } else {
        $_SESSION['message'] = [
            'type' => 'error',
            'text' => 'Ha ocurrido un error al actualizar el estado del usuario.'
        ];
    }
}






//////////////////////////////Actulizar User///////////////////////
function DatosUsuarios($table)
{
    global $pdo;

    $sql = "SELECT usuario_id,nombre, mail, clave, rol, estado FROM " . $table;
    $datosUsuarios = $pdo->prepare($sql);
    $datosUsuarios->execute();

    $rows = $datosUsuarios->fetchAll(PDO::FETCH_ASSOC);
    return $rows;
}
function ActulizarUser()
    {      

if(isset($_POST['btnmodificar']))
{session_start();
  global $pdo;
  $idusuarioeditar = $_POST['idusuarioeditar'];
  $nombreeditar = $_POST['nombreeditar'];
  $maileditar = $_POST['maileditar'];
  $claveeditar = $_POST['claveeditar'];
  $listRoleditar = $_POST['listRoleditar'];
  $listEstadoeditar = $_POST['listEstadoeditar'];


  
  $sql = "UPDATE usuarios SET nombre = '$nombreeditar', mail = '$maileditar', clave = '$claveeditar', 
  rol = '$listRoleditar', estado = '$listEstadoeditar' WHERE usuario_id = '$idusuarioeditar'";
      $stmt = $pdo->prepare($sql);
      $stmt->bindParam(":nombreeditar", $nombreeditar);
      $stmt->bindParam(":maileditar", $maileditar);
      $stmt->bindParam(":claveeditar", $claveeditar);
      $stmt->bindParam(":listRoleditar", $listRoleditar);
      $stmt->bindParam(":listEstadoeditar", $listEstadoeditar);
      $stmt->bindParam(":idusuarioeditar", $idusuarioeditar);
      $stmt->execute();
      
      if ($stmt->rowCount() === 0) {        
        $_SESSION['message'] = [
            'type' => 'info',
            'text' => 'No se ha actualizado ningún dato.'
        ];
    } elseif ($stmt->rowCount() > 0) {
        // Al menos un dato se actualizó correctamente
        $_SESSION['message'] = [
            'type' => 'success',
            'text' => 'Usuario actualizado exitosamente.'
        ];
    } else {
        // Ocurrió un error al actualizar el usuario
        $_SESSION['message'] = [
            'type' => 'error',
            'text' => 'Ha ocurrido un error al actualizar el usuario.'
        ];
    }

    
      
}
}


if (isset($_POST['nombreeditar']) && isset($_POST['idusuarioeditar']) && isset($_POST['maileditar']) && isset($_POST['claveeditar']) && isset($_POST['listRoleditar']) && isset($_POST['listEstadoeditar'])) {
  ActulizarUser();

  header("Location: /instituto/Adman/lista_usuarios.php");
  exit();
}
/*-------------canbiar ckave-----------------------*/
 
function cambioClave()
    {   
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  
  session_start();
global $pdo;
  $oldPassword = $_POST["old_password"];
  $newPassword = $_POST["new_password"];
  $confirmNewPassword = $_POST["confirm_new_password"];
  $usuario_id = 1; // Cambia esto según tu lógica

  $sql = "SELECT clave FROM usuarios WHERE usuario_id = :usuario_id";
  $stmt = $pdo->prepare($sql);
  $stmt->bindParam(':usuario_id', $usuario_id);
  $stmt->execute();
  $row = $stmt->fetch();
  $clave_actual_almacenada_db = $row['clave'];
  if (empty($oldPassword) || empty($newPassword) || empty($confirmNewPassword)) {
      $_SESSION['password_message'] = [
          'type' => 'error',
          'text' => 'Debe completar todos los datos. Por favor, llene todos los campos requeridos.'
        ];
      
      }

  elseif ($oldPassword !== $clave_actual_almacenada_db) {
      $_SESSION['password_message'] = ['type' => 'error', 'text' => 'La contraseña actual ingresada no coincide con la contraseña almacenada.'];
  } elseif ($newPassword !== $confirmNewPassword) {
      $_SESSION['password_message'] = ['type' => 'error', 'text' => 'Las contraseñas no coinciden. No se pudo cambiar la contraseña.'];
  } else {
      try {
          $updateSql = "UPDATE usuarios SET clave = :new_password WHERE usuario_id = :usuario_id";
          $updateStmt = $pdo->prepare($updateSql);
          $updateStmt->bindParam(':new_password', $newPassword);
          $updateStmt->bindParam(':usuario_id', $usuario_id);
          $updateStmt->execute();
          $_SESSION['password_message'] = ['type' => 'success', 'text' => '¡Contraseña cambiada exitosamente!'];
      } catch (PDOException $e) {
          $_SESSION['password_message'] = ['type' => 'error', 'text' => 'Error al actualizar la contraseña: ' . $e->getMessage()];
      }
  }

  header("Location: /instituto/Adman/profile.php");
  exit();
}
if (isset($_SESSION['password_message'])) {
  $messages = $_SESSION['password_message'];
  unset($_SESSION['password_message']);
  showConfirmationMessage($messages);
}

}
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  if (isset($_POST["token"])) {

  cambioClave();
}}

 

?>