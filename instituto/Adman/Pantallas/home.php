<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistemas/instituto/Adman/includes/header.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistemas/instituto/Adman/modals/modal_materia.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistemas/instituto/Includes/load.php';
?>



<main class="app-content">

    <div class="app-title">
        <h1><i class="fa fa-dashboard"></i>Home</h1>
    </div>



        <div id="filter-container" class="filter-container">
            <div class="filter-inputs">
                <label for="fecha_desde">Desde:</label>
                <input type="date" id="fecha_desde" name="fecha_desde">
            </div>
            <div class="filter-inputs">
                <label for="fecha_hasta">Hasta:</label>
                <input type="date" id="fecha_hasta" name="fecha_hasta">
            </div>
            <div class="filter-inputs">
                <label for="titulo">Título:</label>
                <input type="text" id="titulo" name="titulo">
                <button id="btn_buscar">Buscar</button>
            </div>
            <div class="new-publication-button">
                <button class="btn btn-primary rounded-pill" type="button" onclick="openModalPub()">
                    <i class="fas fa-plus-circle mr-2"></i>Nueva Publicación
                </button>
            </div>
        </div>


    <div class="row">
        <div id="container">
            <div id="table-container">
                <table id="my-table">
                    <thead>
                        <tr>
                            <th>Se habilita nuevas fechas</th>
                            <th>Fecha</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Si</td>
                            <td>2023-09-25</td>
                            <td class="actions">
                                <span class="edit-btn">✏️</span>
                                <span class="delete-btn">🗑️</span>
                            </td>
                        </tr>
                        <tr>
                            <td>No</td>
                            <td>2023-09-26</td>
                            <td class="actions">
                                <span class="edit-btn">✏️</span>
                                <span class="delete-btn">🗑️</span>
                            </td>
                        </tr>
                        <!-- Agrega más filas según sea necesario -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row">
        <div id="container">
            <div id="table-container">
                <table id="my-table">
                    <thead>
                        <tr>
                            <th>Aranceles</th>
                            <th>Fecha</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Si</td>
                            <td>2023-09-25</td>
                            <td class="actions">
                                <span class="edit-btn">✏️</span>
                                <span class="delete-btn">🗑️</span>
                            </td>
                        </tr>
                        <tr>
                            <td>No</td>
                            <td>2023-09-26</td>
                            <td class="actions">
                                <span class="edit-btn">✏️</span>
                                <span class="delete-btn">🗑️</span>
                            </td>
                        </tr>
                        <!-- Agrega más filas según sea necesario -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row">
        <div id="container">
            <div id="table-container">
                <table id="my-table">
                    <thead>
                        <tr>
                            <th>Fiesta Fin de Cursada</th>
                            <th>Fecha</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Si</td>
                            <td>2023-09-25</td>
                            <td class="actions">
                                <span class="edit-btn">✏️</span>
                                <span class="delete-btn">🗑️</span>
                            </td>
                        </tr>
                        <tr>
                            <td>No</td>
                            <td>2023-09-26</td>
                            <td class="actions">
                                <span class="edit-btn">✏️</span>
                                <span class="delete-btn">🗑️</span>
                            </td>
                        </tr>
                        <!-- Agrega más filas según sea necesario -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php
require_once '../includes/footer.php';
?>