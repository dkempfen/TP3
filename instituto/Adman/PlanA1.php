<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Adman/includes/header.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Includes/load.php';
?>

<main class="app-content">
    <div class="container mt-5">
        <div class="row">
        <table class="table table-responsive">
    <thead>
        <tr>
            <th colspan="4">PLAN 95 A (Adecuado)</th>
        </tr>
        <tr>
            <th>NIVEL</th>
            <th>Nº</th>
            <th>CÓDIGO</th>
            <th>ASIGNATURA</th>
        </tr>
    </thead>
    <tbody>
        <!-- Año I -->
        <tr>
            <td rowspan="8">I</td>
            <td>1</td>
            <td>950702</td>
            <td>Análisis Matemático I</td>
        </tr>
        <!-- Aquí van las filas para las demás asignaturas del Año I -->
    </tbody>
</table>
        </div>
    </div>
</main>

<?php
require_once 'includes/footer.php';
?>
