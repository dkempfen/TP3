  <?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Adman/includes/header.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Includes/load.php';

  ?>
  <?php

  $nueva_foto = cambiarFotoPerfil();
  if ($pdo) {
    // Query para obtener los datos de la tabla 'usuarios'
    $sql = "SELECT * from Usuario";
    $result = $pdo->query($sql);    
    
    // Check if there's a message in the session

    if (isset($_SESSION['password_message'])) {
        $message = $_SESSION['password_message'];
        unset($_SESSION['password_message']); // Clear the session variable after displaying the message
        showConfirmationMessage($message);
    }
    



?>
  <main class="app-content">
      <div class="row-perfil">
          <div class="right_col" role="main">
              <!-- page content -->
              <div class="">
                  <div class="page-title">


                      <!-- content -->
                      <div class="row-perfil">

                          <div class="col-md-4">
                              <div class="image foto-perfil view-first">
                                  <img class="perfil-image" style="width: 120%; display: block;"
                                      src="/instituto/Imagenes/profiles/<?php echo $nueva_foto; ?>" alt="image">
                              </div>

                              <span class="">
                                  <div class="btn btn-info btn-lg btn-cambiar">
                                      <form method="post" id="formulario" enctype="multipart/form-data"
                                          action="/instituto/Includes/cambiofoto.php">
                                          <label for="file">Cambiar imagen</label>
                                          <input type="file" name="file" id="file" accept="image/*" class="file-input">
                                      </form>
                                  </div>
                              </span>
                              <div id="respuesta"></div>
                          </div>

                          <div class="col-md-8 col-xs-12 col-sm-12">
                              <?php /*include "lib/alerts.php";profile(); //llamada a la funcion de alertas*/?>
                              <div class="perfil_panel">
                                  <div class="perfil_title">
                                      <h2>Informacion personal</h2>

                                      <div class="clearfix"></div>
                                  </div>
                                  <div class="x_content">
                                      <form id="cambiarClaveForm" name="cambiarClaveForm" data-parsley-validate
                                          class="form-horizontal form-label-left" action="/instituto/Includes/sql.php"
                                          method="post">
                                          <input type="hidden" name="idusuarioDatos" id="idusuarioDatos"
                                              value="<?php  echo $_SESSION['Id_Usuario']?>" required>

                                          <div class="form-group">
                                              <label class="control-label percontrasena col-sm-3 col-xs-12"
                                                  for="last-name">Nombre
                                              </label>
                                              <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <label type="text" id="last-name" name="first-apellido"
                                                      class="password form-control col-md-7 col-xs-12"><?= $_SESSION['nombre']; ?></label>
                                              </div>
                                          </div>
                                          <div class="form-group">
                                              <label class="control-label percontrasena col-sm-3 col-xs-12"
                                                  for="last-name">Rol
                                              </label>
                                              <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <label type="text" id="last-rol" name="first-rol"
                                                      class="password form-control col-md-7 col-xs-12">
                                                      <?= $_SESSION['nombre_rol']; ?>
                                                  </label>
                                              </div>
                                          </div>

                                          <div class="form-group">
                                              <label class="control-label percontrasena col-sm-3 col-xs-12"
                                                  for="last-name">Edad
                                              </label>
                                              <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <label type="text" id="last-edad" name="first-edad"
                                                      class="password form-control col-md-7 col-xs-12">
                                                      <?=$_SESSION['edad']; ?>
                                                  </label>
                                              </div>
                                          </div>
                                          <div class="form-group">
                                              <label class="control-label percontrasena col-sm-3 col-xs-12"
                                                  for="last-name">Fecha Nacimiento
                                              </label>
                                              <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <label type="text" id="last-fnacimiento" name="first-fnacimiento"
                                                      class="password form-control col-md-7 col-xs-12">
                                                      <?= $_SESSION['fechanac']; ?>
                                                  </label>
                                              </div>
                                          </div>
                                          <div class="form-group">
                                              <label class="control-label percontrasena col-sm-3 col-xs-12"
                                                  for="last-name">Correo electronico
                                              </label>
                                              <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input type="text" id="emailPerfil" name="emailPerfil"
                                                      class="password form-control col-md-7 col-xs-12"
                                                      value="<?= $_SESSION['mail']; ?>">
                                              </div>
                                          </div>

                                          <div class="form-group">
                                              <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3 btonp">
                                                  <button type="submit" name="tokenMail"
                                                      class="btn btn-success btn-perfilactualizar">Actualizar
                                                      Mail</button>
                                              </div>
                                          </div>




                                          <div class="perfil_title">
                                              <h2>Cambio de contraseña</h2>

                                              <div class="clearfix"></div>
                                          </div>
                                          <div class="form-group">
                                              <label class="control-label percontrasena col-sm-3 col-xs-12">Contraseña
                                                  antigua
                                              </label>
                                              <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input id="old_password" name="old_password"
                                                      class="password form-control col-md-7 col-xs-12" type="password">
                                              </div>
                                          </div>
                                          <div class="form-group">
                                              <label class="control-label percontrasena col-sm-3 col-xs-12">Nueva
                                                  contraseña
                                              </label>
                                              <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input id="new_password" name="new_password"
                                                      class="password form-control col-md-7 col-xs-12" type="password">
                                              </div>
                                          </div>
                                          <div class="form-group">
                                              <label class="control-label percontrasena col-sm-3 col-xs-12">Confirmar
                                                  contraseña nueva
                                              </label>
                                              <div class="col-md-6 col-sm-6 col-xs-12">
                                                  <input id="confirm_new_password" name="confirm_new_password"
                                                      class="password form-control col-md-7 col-xs-12" type="password">
                                              </div>
                                          </div>
                                          <div class="form-group">
                                              <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3 btonp">
                                                  <button type="submit" name="token"
                                                      class="btn btn-success btn-perfilactualizar">Actualizar
                                                      clave</button>
                                              </div>
                                          </div>
                                      </form>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div><!-- /page content -->

      </div>

  </main>


  <?php
  } else {
    echo "Error: No se pudo establecer la conexión a la base de datos.";
}
require_once '../includes/footer.php';
  ?>
  <script>
$(function() {
    $("input[name='file']").on("change", function() {
        var formData = new FormData($("#formulario")[0]);
        var ruta = "/instituto/Includes/cambiofoto.php";

        $.ajax({
            url: ruta,
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(datos) {
                $("#respuesta").html(datos);
                // Redireccionar automáticamente después de 2 segundos (opcional)
                setTimeout(function() {
                    window.location.reload();
                }, 2000);
            }
        });
    });
})

function actualizarDatos() {
    var oldPassword = document.getElementById('old_password').value;
    var newPassword = document.getElementById('new_password').value;
    var confirmNewPassword = document.getElementById('confirm_new_password').value;
    var emailPerfil = document.getElementById('emailPerfil').value;


    emailPerfil

    // Realizar la verificación en el lado del cliente antes de enviar la solicitud al servidor
    if (oldPassword === '' || newPassword === '' || confirmNewPassword === '') {
        alert('Debe completar todos los campos.');
        return;
    }

    if (newPassword !== confirmNewPassword) {
        alert('La nueva contraseña y la confirmación no coinciden.');
        return;
    }

    // Envía los datos al servidor para la verificación y actualización
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '/instituto/Includes/sql.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // Manejar la respuesta del servidor
            alert(xhr.responseText);
        }
    };

    // Envía los datos al servidor
    var data = 'old_password=' + encodeURIComponent(oldPassword) +
        '&new_password=' + encodeURIComponent(newPassword) +
        '&confirm_new_password=' + encodeURIComponent(confirmNewPassword) +
        '&emailPerfil=' + encodeURIComponent(emailPerfil);
    xhr.send(data);
}
  </script>
  <script>
document.getElementById('formulario').addEventListener('submit', function() {
    // Recargar la página después de enviar el formulario
    location.reload();
});
  </script>