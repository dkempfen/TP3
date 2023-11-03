<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Includes/load.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Adman/lista_materia.php';


$DatosMateriaProfesor = DatosMateriaProfesor();


 ?>



<div class="modal fade"  id="modalMateria" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
                 <div class="modal-header headerMateria">
                <h5 class="modal-title fs-5" id="tituloModalMateria">Nueva Materia</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formMateria" name="formMateria">
          
                   <input type="hidden" name="idMateria" id="idMateria" value="<?php  echo $DatosMateriaProfesor['id_Materia']?>">

                    <div class="form-group">
                        <label for="control-label">Nombre Materia:</label>
                        <input type="text" class="form-control" name="nombreMateria" id="nombreMateria">
                    </div>    
                    
                    <div class="form-group">
                        <label for="control-label">Nombre Profesor:</label>
                        <input type="text" class="form-control" name="nombreProfesor" id="nombreProfesor">
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
                        <button id="btnActionAltaMateriaForm" class="btn btn-primary btn-open-modal" type="submit"
                            name="btnCrearMateria">
                            <span id="btnCrearMateria">Guardar</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>




<!-- Agrega SweetAlert2 y jQuery a tu página -->

<script>
function isValidInput(value) {
    return value.trim() !== '';
}

function openModalMateria() {
    console.log('Abrir modal'); // Agrega este log para verificar si se llama a la función

    document.getElementById('idMateria').value = "";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerMateria");
    document.getElementById('btnCrearMateria').classList.replace("btn-info", "btn-open-modal");
    document.getElementById('btnCrearMateria').innerHTML = 'Guardar';
    document.getElementById('tituloModalMateria').innerHTML = 'Crear Materia';
    document.getElementById('formMateria').reset();

    $('#modalMateria').modal('show');

    
}

</script>
