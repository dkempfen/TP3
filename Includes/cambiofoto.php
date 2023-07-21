<?php


require_once './load.php';


if (isset($_FILES["file"])) {
  $file = $_FILES["file"];
  $name = $file["name"];
  $type = $file["type"];
  $tmp_n = $file["tmp_name"];
  $size = $file["size"];

  $folder = "../Imagenes/profiles/";
//cambio de foto//
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
            Error al actualizar el pe rfil</div>";
      }
    } else {
      echo "<div class='alert alert-danger' role='alert'>
          Error al subir la imagen</div>";
    }
  }
}

//ingresar foto//

?>