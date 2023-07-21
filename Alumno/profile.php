<?php
require_once 'includes/header.php';
?>


<main class="app-content">
  <div class="row">
    <div class="right_col" role="main">
      <!-- page content -->
      <div class="">
        <div class="page-title">

          <!-- content -->
          <div class="row">

            <div class="col-md-4">
              <div class="image view view-first">
                <img class="thumb-image" style="width: 100%; display: block;" src="/instituto/Imagenes/avatar.png"
                  alt="image" />
              </div>
              <span class="btn btn-info btn-lg">
                <form method="post" id="formulario" enctype="multipart/form-data">
                  Cambiar Imagen de perfil<input type="file" name="file">
                </form>        
              </span>
              <div id="respuesta"></div>
            </div>

            <div class="col-md-8 col-xs-12 col-sm-12">
              <?php /*include "lib/alerts.php";profile(); //llamada a la funcion de alertas*/?>
              <div class="x_panel">
                <div class="x_title">
                  <h2>Informacion personal</h2>

                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left"
                    action="/instituto/Includes/actionperfile.php" method="post">

                    <div class="form-group">
                      <label class="control-label percontrasena col-sm-3 col-xs-12" for="last-name">Nombre
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <label type="text" id="last-name" name="first-apellido"
                          class="form-control col-md-7 col-xs-12"><?= $_SESSION['nombre']; ?></label>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label percontrasena col-sm-3 col-xs-12" for="last-name">Rol
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <label type="text" id="last-rol" name="first-rol" class="form-control col-md-7 col-xs-12">
                          <?= $_SESSION['nombre_rol']; ?>
                        </label>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label percontrasena col-sm-3 col-xs-12" for="last-name">Edad
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <label type="text" id="last-edad" name="first-edad" class="form-control col-md-7 col-xs-12">
                          <?= $_SESSION['edad']; ?>
                        </label>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label percontrasena col-sm-3 col-xs-12" for="last-name">Fecha Nacimiento
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <label type="text" id="last-fnacimiento" name="first-fnacimiento" class="form-control col-md-7 col-xs-12">
                          <?= $_SESSION['fechanac']; ?>
                        </label>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label percontrasena col-sm-3 col-xs-12" for="last-name">Carrera
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <label type="text" id="last-carrrea" name="first-carrrea" class="form-control col-md-7 col-xs-12">
                          <?= $_SESSION['carrrea']; ?>
                        </label>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label percontrasena col-sm-3 col-xs-12" for="last-name">Correo electronico
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" id="last-name" name="email" class="form-control col-md-7 col-xs-12"
                          value="<?= $_SESSION['mail']; ?>">
                      </div>
                    </div>



                    <div class="x_title">
                      <h2>Cambio de contraseña</h2>

                      <div class="clearfix"></div>
                    </div>
                    <div class="form-group">
                      <label class="control-label percontrasena col-sm-3 col-xs-12">Contraseña
                        antigua
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input id="birthday" name="password" class="date-picker form-control col-md-7 col-xs-12"
                          type="password" placeholder="**********">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label percontrasena col-sm-3 col-xs-12">Nueva
                        contraseña
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input id="birthday" name="new_password" class="date-picker form-control col-md-7 col-xs-12"
                          type="password">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label percontrasena col-sm-3 col-xs-12">Confirmar
                        contraseña nueva
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input id="birthday" name="confirm_new_password"
                          class="date-picker form-control col-md-7 col-xs-12" type="password">
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                        <button type="submit" name="token" class="btn btn-success">Actualizar
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
require_once 'includes/footer.php';
?>
<script>
    $(function(){
        $("input[name='file']").on("change", function(){
            var formData = new FormData($("#formulario")[0]);
            var ruta = "/instituto/Includes/cambiofoto.php";
            $.ajax({
                url: ruta,
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(datos)
                {
                    $("#respuesta").html(datos);
                }
            });
        });
    });
</script>