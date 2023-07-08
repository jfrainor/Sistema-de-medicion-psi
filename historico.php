<?php

require_once 'db/conexion.php';


// Función para obtener las medidas psi de un pozo
function obtenerMedidas($idpozo)
{
    // Lógica para obtener las medidas de la base de datos para el pozo especificado
    global $conexion;

    $sql = "SELECT * FROM medidas WHERE pozos_idpozo = $idpozo";
    $result = $conexion->query($sql);

    if ($result->num_rows > 0) {
        return $result->fetch_all(MYSQLI_ASSOC);
    } else {
        return [];
    }
    // 
}

// Obtener el ID del pozo seleccionado
$idpozo = isset($_POST['pozo_nombre']) ? $_POST['pozo_nombre'] : null;

// Verificar si se seleccionó un pozo
if ($idpozo !== null) {
    // Obtener las medidas del pozo seleccionado
    $medidas = obtenerMedidas($idpozo);

    // Arreglos para almacenar las fechas y las medidas
    $fechas = [];
    $medidasPsi = [];

    if (!empty($medidas)) {
        foreach ($medidas as $medida) {
            $fechas[] = $medida['fecha_hora'];
            $medidasPsi[] = $medida['medida_psi'];
        }
}
}

// Función para editar una medida
function editarMedida($medida_id, $medida_psi, $fecha_hora)
{
    // Lógica para editar la medida en la base de datos
    global $conexion;

    $sql = "UPDATE medidas SET medida_psi = $medida_psi, fecha_hora = '$fecha_hora' WHERE idmedida = $medida_id";

    if ($conexion->query($sql) === TRUE) {
        echo "Medida editada correctamente";
    } else {
        echo "Error al editar la medida: " . $conexion->error;
    }
}

// Función para eliminar una medida
function eliminarMedida($medida_id)
{
    // Lógica para eliminar la medida de la base de datos
    global $conexion;

    $sql = "DELETE FROM medidas WHERE idmedida = $medida_id";

    if ($conexion->query($sql) === TRUE) {
        echo "Medida eliminada correctamente";
    } else {
        echo "Error al eliminar la medida: " . $conexion->error;
    }
}



// Código para procesar el formulario de edición de una medida
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editar_medida'])) {
    $medida_id = $_POST['editar_medida_id'];
    $medida_psi = $_POST['editar_medida_psi'];
    $fecha_hora = $_POST['editar_medida_fecha_hora'];


    // Validación de los datos ingresados
    editarMedida($medida_id, $medida_psi, $fecha_hora);

     // Redireccionar a historico.php
     header("Location: historico.php");
     exit();
}

// Código para procesar la eliminación de una medida
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar_medida'])) {
    $medida_id = $_POST['eliminar_medida_id'];

    // Validación y confirmación de la eliminación

    eliminarMedida($medida_id);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Mediciones de pozos petroleros - Histórico de Medidas</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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
                        <a class="nav-link" href="pozos.php">Pozos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="historico.php">Histórico de Medidas</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <!-- Selección del pozo -->
        <br>
        <h2>Seleccionar Pozo</h2>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="pozo_nombre" class="form-label">Nombre del Pozo</label>
                <select class="form-select" id="pozo_nombre" name="pozo_nombre" required>
                    <!-- Opciones de los pozos registrados -->
                    <?php
                    // Consulta para obtener los pozos registrados
                    $sql = "SELECT * FROM pozos";
                    $result = $conexion->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $selected = ($row['idpozo'] == $idpozo) ? 'selected' : '';
                            echo "<option value='" . $row['idpozo'] . "' $selected>" . $row['nombre'] . "</option>";
                        }
                    } else {
                        echo "<option value=''>No hay pozos registrados</option>";
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary" name="seleccionar_pozo">Seleccionar</button>
        </form>

        <?php
        // Verificar si se seleccionó un pozo
        if ($idpozo !== null) {
            // Obtener las medidas del pozo seleccionado
            if (!empty($medidas)) {
                ?>
                <!-- Tabla de medidas -->
                <h2>Medidas del Pozo</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Fecha y Hora</th>
                            <th>PSI</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($medidas as $medida) {
                            echo "<tr>";
                            echo "<td>" . $medida['fecha_hora'] . "</td>";
                            echo "<td>" . $medida['medida_psi'] . "</td>";
                            echo "<td>";
                            echo "<button class='btn btn-secondary' data-bs-toggle='modal' data-bs-target='#editarMedidaModal' data-medida-id='" . $medida['idmedida'] . "' data-medida-psi='" . $medida['medida_psi'] . "' data-fecha-hora='" . $medida['fecha_hora'] . "'>Editar</button>";
                            echo "<button class='btn btn-danger' data-bs-toggle='modal' data-bs-target='#eliminarMedidaModal' data-medida-id='" . $medida['idmedida'] . "'>Eliminar</button>";
                            echo "</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
                <?php
            } else {
                echo "<p>No hay medidas registradas para este pozo.</p>";
            }
        }
        ?>

                <!-- Modal para editar medida -->
        <div class="modal fade" id="editarMedidaModal" tabindex="-1" aria-labelledby="editarMedidaModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editarMedidaModalLabel">Editar Medida</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="historico.php">
                            <div class="mb-3">
                                <label for="editar_medida_psi" class="form-label">PSI</label>
                                <input type="double" class="form-control" id="editar_medida_psi" name="editar_medida_psi" required>
                            </div>
                            <div class="mb-3">
                                <label for="editar_medida_fecha_hora" class="form-label">Fecha y Hora</label>
                                <input type="datetime-local" class="form-control" id="editar_medida_fecha_hora" name="editar_medida_fecha_hora" required>
                            </div>
                            <input type="hidden" id="editar_medida_id" name="editar_medida_id">
                            <button type="submit" class="btn btn-primary" name="editar_medida">Guardar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal para eliminar medida -->
        <div class="modal fade" id="eliminarMedidaModal" tabindex="-1" aria-labelledby="eliminarMedidaModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="eliminarMedidaModalLabel">Eliminar Medida</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>¿Estás seguro de que deseas eliminar esta medida?</p>
                        <form method="POST" action="historico.php">
                            <input type="hidden" id="eliminar_medida_id" name="eliminar_medida_id">
                            <button type="submit" class="btn btn-danger" name="eliminar_medida">Eliminar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gráfica comparativa -->
        <h2>Gráfica Comparativa</h2>
        <canvas id="graficoMedidas"></canvas>
        <br>

        <script>
        // Obtener el elemento canvas y su contexto
            var canvas = document.getElementById('graficoMedidas');
            var ctx = canvas.getContext('2d');

            // Crear el gráfico
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: <?php echo json_encode($fechas); ?>,
                    datasets: [{
                        label: 'Pozo seleccionado',
                        data: <?php echo json_encode($medidasPsi); ?>,
                        fill: false,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        tension: 0.1
                    }]
                },
                options: {
                    scales: {
                        x: {
                            display: true,
                            title: {
                                display: true,
                                text: 'Fecha-hora'
                            }
                        },
                        y: {
                            display: true,
                            title: {
                                display: true,
                                text: 'Medidas (PSI)'
                            }
                        }
                    }
                }
            });
        </script>

</div>

    <script>
        //Obtener datos en el modal para editar y eliminar medida
        var editarMedidaModal = document.getElementById('editarMedidaModal');
        editarMedidaModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var medidaId = button.getAttribute('data-medida-id');
            var medidaPsi = button.getAttribute('data-medida-psi');
            var medidaFechaHora = button.getAttribute('data-fecha-hora');
            var editarPsiInput = document.getElementById('editar_medida_psi');
            var editarFechaHoraInput = document.getElementById('editar_medida_fecha_hora');
            editarPsiInput.value = medidaPsi;
            editarFechaHoraInput.value = medidaFechaHora;
            document.getElementById('editar_medida_id').value = medidaId;
        })

        var eliminarMedidaModal = document.getElementById('eliminarMedidaModal');
        eliminarMedidaModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var medidaId = button.getAttribute('data-medida-id');
            var eliminarMedidaIdInput = document.getElementById('eliminar_medida_id');
            eliminarMedidaIdInput.value = medidaId;
        })
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>