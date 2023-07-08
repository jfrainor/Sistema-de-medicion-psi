<!DOCTYPE html>
<html>
<head>
    <title>Mediciones de PSI - PDVSA</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/styles-index.css">


</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">PDVSA</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="pozos.php">Gestionar Pozos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="historico.php">Histórico de Medidas </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4 welcome-section">
        <h1>Registro de mediciones PSI para Pozos Petroleros</h1>
        <br>
        <div class="row">
            <div class="col">
                <br>
                <p><b>La aplicación presenta las siguiente funciones:</b></p>
                <li>Registro de Pozos</li>
                <li>Registrar Medidas PSI para cada pozo</li>
                <li>Consultar tablas de registro</li>
                <li>Visualizar gráfica para comparar los PSI registrados</li>
                <br>
                <div>
                    <button type="button" class="btn btn-primary" onclick="window.location.href='pozos.php'">Empezar</button>
                </div>
                
            </div>
            <div class="col">
                <div id="carouselExampleIndicators" class="carousel slide">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                    </div>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                        <img src="assets/img/pozos.jpg" class="d-block w-100" alt="...">
                        </div>
                        <div class="carousel-item">
                        <img src="assets/img/pozo-2.jpg" class="d-block w-100" alt="...">
                        </div>
                        <div class="carousel-item">
                        <img src="assets/img/medida-psi.jpeg" class="d-block w-100" width="80" height="360"  alt="...">
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
            <br>
                <p><b>¿Qué es PSI?</b></p>
                <p>La libra de fuerza por pulgada cuadrada (lbf/in² o lbf/in²), abreviada psi,es una unidad de presión perteneciente al sistema anglosajón de unidades.Para expresar la presión relativa al ambiente</p>
                <p>La libra de fuerza por pulgada cuadrada y todos sus derivados fueron reemplazados por el Sistema Internacional de Unidades (SI). Es incorrecto modificar la unidad para indicar información sobre la magnitud física expresada como se hace con psia y psig; cuando se requiera tal información, esta debe incorporarse como parte del símbolo, nombre o descripción de la magnitud física, sin alterar la unidad.2</p>
                <br>
            </div>
            <div class="col">
            <br>
            <p><b>Perforación de pozos</b></p>
            <p>La presión, medida generalmente en libras por pulgada cuadrada (psi), existente en el fondo del pozo. Esta presión puede ser calculada en un pozo estático relleno de fluido con la ecuación:</p>

            <p>BHP = MW * Profundidad * 0,052</p>
            <p>Donde BHP es la presión de fondo de pozo en libras por pulgada cuadrada, MW es el peso del lodo en libras por galón, la Profundidad es la profundidad vertical verdadera en pies, y 0,052 es un factor de conversión si se utilizan estas unidades de medida.</p>
            <br>
            </div>
        </div>
 
       
    </div>

    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
