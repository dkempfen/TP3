<!---Modal Usuarios--->
<div class="modal fade" id="modalAlumno" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-5" id="tituloModal">Nuevo Alumno</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formAlumno" name="formAlumno">
                   <input type="hidden" name="idalumno" id="idalumno" value="">
                    <div class="form-group">
                        <label for="control-label">Nombre:</label>
                        <input type="text" class="form-control" name="nombre" id="nombre">
                    </div>
                    <div class="form-group">
                        <label for="control-label">Edad:</label>
                        <input type="text" class="form-control" name="edad" id="edad">
                    </div>
                    <div class="form-group">
                        <label for="control-label">Direccion:</label>
                        <input type="text" class="form-control" name="direccion" id="direccion">
                    </div>
                    <div class="form-group">
                        <label for="control-label">Cedula:</label>
                        <input type="text" class="form-control" name="cedula" id="cedula">
                    </div>
                    <div class="form-group">
                        <label for="control-label">Telefono:</label>
                        <input type="text" class="form-control" name="telefono" id="telefono">
                    </div>
                    <div class="form-group">
                        <label for="control-label">Correo:</label>
                        <input type="text" class="form-control" name="correo" id="correo">
                    </div>
                    <div class="form-group">
                        <label for="control-label">Fecha Nacimiento:</label>
                        <input type="text" class="form-control" name="fecha_nac" id="fecha_nac">
                    </div>
                    <div class="form-group">
                        <label for="control-label">Fecha Registro:</label>
                        <input type="text" class="form-control" name="fecha_res" id="fecha_res">
                    </div>
                    <div class="form-group">
                        <label for="listEstado">Estado</label>
                        <select class="form-control" name="listEstado" id="listEstado">
                            <option value="1">Activo</option>
                            <option value="2">Inactivo</option>                        
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" type="submit">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>