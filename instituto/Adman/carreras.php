<?php
require_once 'includes/header.php';
require_once '../Includes/load.php';
?>



<main class="app-content">
    <div class="container-carrera  mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="btn-group btn-group-lg d-flex">
                    <a href="/instituto/Adman/carreras.php" class="custom-button">Carreras</a>
                    <a href="/instituto/Adman/lista_planes.php" class="custom-button">Planes</a>
                    <a href="/enlace-1" class="custom-button">Materias</a>
                </div>
            </div>
        </div>
    </div>

    <section id="carrers">
        <div class="container-carrera">
            <a href="/instituto/Adman/plan_carrera_analista.php" class="card" target="_blank">
                <img src="/instituto/Imagenes/analista.jpeg" alt="Analista de Sistemas" />
                <div class="centrado">
                    <h3>Analista de Sistemas</h3> <!-- Título centrado -->
                    <span class="button button__secundary">Ver más</span>
                </div>
            </a>
            <a href="/instituto/Imagenes/redes.jpeg" class="card" target="_blank">
                <img src="/instituto/Imagenes/redes.jpeg" alt="Redes Informáticas" />
                <div class="centrado">
                    <h3>Redes Informáticas</h3> <!-- Título centrado -->
                    <span class="button button__secundary">Ver más</span>
                </div>
            </a>
        </div>
    </section>
</main>


<?php
require_once 'includes/footer.php';
?>