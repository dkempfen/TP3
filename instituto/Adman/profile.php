  <?php
  require_once 'includes/header.php';
  require_once '../Includes/load.php';

  ?>
  <?php

  $nueva_foto = cambiarFotoPerfil('cambio_foto_perfil');
  if ($pdo) {
    // Query para obtener los datos de la tabla 'usuarios'
    $sql = "SELECT * from usuario";
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
                                      src="../Imagenes/profiles/<?php echo $nueva_foto; ?>" alt="image">
                              </div>

                              <span class="">
                                  <div class="btn btn-info btn-lg btn-cambiar">
                                      <form method="post" id="formulario" enctype="multipart/form-data">
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
                                          class="form-horizontal form-label-left"
                                          action="/instituto/Includes/sql.php" method="post">
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
                                                  <input type="text" id="last-name" name="email"
                                                      class="password form-control col-md-7 col-xs-12"
                                                      value="<?= $_SESSION['mail']; ?>">
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
                                                      class="password form-control col-md-7 col-xs-12" type=""
                                                      placeholder="**********"  value="<?= $_SESSION['clave']; ?>"
                                                    >                                                                         
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
                                                      Datos</button>
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
  require_once 'includes/footer.php';
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
  </script>
    <script>
$(document).ready(function() {
    // Asociar un evento al botón de cambio de contraseña
    $("#change_password_button").on("click", function() {
        var oldPassword = $("#old_password").val();
        var newPassword = $("#new_password").val();

        // Verificar si las contraseñas no están vacías
        if (oldPassword === "" || newPassword === "") {
            console.log("Por favor, complete ambos campos.");
            return;
        }

        // Realizar la solicitud AJAX para cambiar la contraseña
        $.ajax({
            type: "POST",
            url: "/instituto/Includes/sql.php",
            data: { old_password: oldPassword, new_password: newPassword },
            success: function(response) {
                console.log(response);
                // Si la respuesta es exitosa, mostrar un mensaje y recargar la página
                alert(response);
                window.location.reload();
            },
            error: function(xhr, status, error) {
                console.log("Error en la solicitud AJAX:", error);
            }
        });
    });
});
    </script>