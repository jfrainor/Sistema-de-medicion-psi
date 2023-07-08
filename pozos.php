<?php

require_once 'db/conexion.php';


// Función para registrar un pozo
function registrarPozo($nombre, $ubicacion)
{
  global $conexion;
    
  $sql = "INSERT INTO pozos (nombre, ubicacion) VALUES ('$nombre', '$ubicacion')";
  
  if ($conexion->query($sql) === TRUE) {
    echo "Pozo registrado";
  } else {
      echo "Error al registrar el pozo: " . $conexion->error;
  }
}

// Función para registrar una medida
function registrarMedida( $medida_psi, $fecha_hora, $pozos_idpozo)
{
  global $conexion;

  $sql = "INSERT INTO medidas (medida_psi, fecha_hora, pozos_idpozo) VALUES ($medida_psi, '$fecha_hora', $pozos_idpozo)";
 
  if ($conexion->query($sql) === TRUE) {
      echo "Medida registrada exitosamente";
  } else {
      echo "Error al registrar la medida: " . $conexion->error;
  }
}

// Función para editar un pozo
function editarPozo($pozo_id, $nombre, $ubicacion)
{
    // Lógica para editar el pozo en la base de datos
    global $conexion;
    
    $sql = "UPDATE pozos SET nombre='$nombre', ubicacion='$ubicacion' WHERE idpozo='$pozo_id'";
    
    if ($conexion->query($sql) === TRUE) {
        echo "Pozo actualizado exitosamente";
    } else {
        echo "Error al actualizar el pozo: " . $conexion->error;
    }
    // ...
}

// Función para eliminar un pozo
function eliminarPozo($pozo_id)
{
    global $conexion;

    // Verificar si existen medidas asociadas al pozo
     $sqlVerificarMedidas = "SELECT COUNT(*) AS total FROM medidas WHERE pozos_idpozo = $pozo_id";
     $result = $conexion->query($sqlVerificarMedidas);
     $row = $result->fetch_assoc();
     $totalMedidas = $row['total'];
 
     if ($totalMedidas > 0) {
         echo "El pozo seleccionado tiene medidas asociadas. Elimine las medidas primero.";
         return;
     }

    $sql = "DELETE FROM pozos WHERE idpozo=$pozo_id";

    if ($conexion->query($sql) === TRUE) {
        echo "Pozo eliminado";
    } else {
        echo "Error al eliminar el pozo: " . $conexion->error;
    }
}


// Código para procesar el formulario de registro de un pozo
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['registrar_pozo'])) {
    $nombre = $_POST['nombre'];
    $ubicacion = $_POST['ubicacion'];
    
    // Validación de los datos ingresados
    
    registrarPozo($nombre, $ubicacion);
}

// Código para procesar el formulario de agregar medida
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['registrar_medida'])) {
    $medida_psi = $_POST['registrar_medida_psi'];
    $fecha_hora = $_POST['registrar_medida_fecha_hora'];
    $pozos_idpozo = $_POST['registrar_medida_pozo_id'];

    // Validación de los datos ingresados
    registrarMedida($medida_psi, $fecha_hora, $pozos_idpozo);

}


// Código para procesar el formulario de edición de un pozo
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editar_pozo'])) {
    $pozo_id = $_POST['editar_pozo_id'];
    $nombre = $_POST['editar_nombre'];
    $ubicacion = $_POST['editar_ubicacion'];
    
    // Validación de los datos ingresados
    
    editarPozo($pozo_id, $nombre, $ubicacion);
}

// Código para procesar la eliminación de un pozo
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar_pozo'])) {
    $pozo_id = $_POST['eliminar_pozo_id'];
    
    // Validación y confirmación de la eliminación
    
    eliminarPozo($pozo_id);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Mediciones de pozos petroleros - Pozos</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/styles-index.css">
    <script>
    //Validaciones
    function validarRegistroPozo() {
        var nombre = document.getElementById('nombre').value;
        var ubicacion = document.getElementById('ubicacion').value;

        var regexSoloNumeros = /^[0-9]+$/;
        var regexAlMenosUnaLetra = /[a-zA-Z]/;

        if (nombre.match(regexSoloNumeros) || ubicacion.match(regexSoloNumeros)) {
            alert('El nombre y la ubicación deben contener al menos una letra.');
            return false;
        }

        if (!nombre.match(regexAlMenosUnaLetra) || !ubicacion.match(regexAlMenosUnaLetra)) {
            alert('El nombre y la ubicación deben contener al menos una letra.');
            return false;
        }

        return true;
    }
    </script>
    <script>
    function validarRegistroMedida() {
        var medida_psi = document.getElementById('registrar_medida_psi').value;

        if (medida_psi < 0) {
            alert('La medida PSI no puede ser un número negativo.');
            return false;
        }

        return true;
    }
    </script>
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
                        <a class="nav-link" href="historico.php">Histórico de Medidas</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container welcome-section">

        <!-- Formulario de registro de pozo -->
        <br>
        <h2>Registrar Pozo</h2>
        <br>
        <form method="POST" action="" onsubmit="return validarRegistroPozo()">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre del pozo</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="mb-3">
                <label for="ubicacion" class="form-label```php">Ubicación</label>
                <input type="text" class="form-control" id="ubicacion" name="ubicacion" required>
            </div>
            <button type="submit" class="btn btn-primary" name="registrar_pozo">Registrar</button>
        </form>

        <!-- Tabla de pozos registrados -->
        <hr>
        <br>
        <h2>Pozos Registrados</h2>
        <br>
        <table class="table">
            <thead>
                <tr>
                    <th>Nombre del Pozo</th>
                    <th>Ubicación</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
            <?php
            // Consulta para obtener los pozos registrados
            $sql = "SELECT * FROM pozos";
            $result = $conexion->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['nombre'] . "</td>";
                    echo "<td>" . $row['ubicacion'] . "</td>";
                    echo "<td>";
                    echo "<button class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#agregarMedidaModal' data-pozo-id='" . $row['idpozo'] . "' onclick='registrarMedida(" . $row['idpozo'] . ")'>Agregar Medida</button>";
                    echo "<button class='btn btn-secondary' data-bs-toggle='modal' data-bs-target='#editarPozoModal' data-pozo-id='" . $row['idpozo'] . "' data-pozo-nombre='" . $row['nombre'] . "' data-pozo-ubicacion='" . $row['ubicacion'] . "' onclick='editarPozo(" . $row['idpozo'] . ")'>Editar</button>";
                    echo "<button class='btn btn-danger' data-bs-toggle='modal' data-bs-target='#eliminarPozoModal' data-pozo-id='" . $row['idpozo'] . "'>Eliminar</button>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='3'>No hay pozos registrados</td></tr>";
            }
            ?>
            </tbody>
        </table>
        
        <!-- Modal para agregar medida -->
<div class="modal fade" id="agregarMedidaModal" tabindex="-1" aria-labelledby="agregarMedidaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="agregarMedidaModalLabel">Agregar Medida</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="pozos.php" onsubmit="return validarRegistroMedida()">
                    <div class="mb-3">
                        <label for="registrar_medida_psi" class="form-label">PSI</label>
                        <input type="double" class="form-control" id="registrar_medida_psi" name="registrar_medida_psi" required>
                    </div>
                    <div class="mb-3">
                        <label for="registrar_medida_fecha_hora" class="form-label">Fecha y Hora</label>
                        <input type="datetime-local" class="form-control" id="registrar_medida_fecha_hora" name="registrar_medida_fecha_hora" required>
                    </div>
                    <input type="hidden" id="registrar_medida_pozo_id" name="registrar_medida_pozo_id">
                    <button type="submit" class="btn btn-primary" name="registrar_medida">Agregar</button>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Modal para editar pozo -->
<div class="modal fade" id="editarPozoModal" tabindex="-1" aria-labelledby="editarPozoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editarPozoModalLabel">Editar Pozo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="">
                    <div class="mb-3">
                        <label for="editar_nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="editar_nombre" name="editar_nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="editar_ubicacion" class="form-label">Ubicación</label>
                        <input type="text" class="form-control" id="editar_ubicacion" name="editar_ubicacion" required>
                    </div>
                    <input type="hidden" id="editar_pozo_id" name="editar_pozo_id">
                    <button type="submit" class="btn btn-primary" name="editar_pozo">Guardar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal para eliminar pozo -->
<div class="modal fade" id="eliminarPozoModal" tabindex="-1" aria-labelledby="eliminarPozoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eliminarPozoModalLabel">Eliminar Pozo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>¿Estás seguro de que deseas eliminar este pozo?</p>
                <form method="POST" action="">
                    <input type="hidden" id="eliminar_pozo_id" name="eliminar_pozo_id">
                    <button type="submit" class="btn btn-danger" name="eliminar_pozo">Eliminar</button>
                </form>
            </div>
        </div>
    </div>
    </div>
</div>  
    <!-- Script para obtener el ID del pozo seleccionado en el modal de agregar medida -->
<script>
    var agregarMedidaModal = document.getElementById('agregarMedidaModal');
    agregarMedidaModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var pozoId = button.getAttribute('data-pozo-id');
        var pozoIdInput = document.getElementById('registrar_medida_pozo_id');
        pozoIdInput.value = pozoId;
    })
</script>

<!-- Script para obtener los datos del pozo seleccionado en el modal de editar pozo -->
<script>
    var editarPozoModal = document.getElementById('editarPozoModal');
    editarPozoModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var pozoId = button.getAttribute('data-pozo-id');
        var pozoNombre = button.getAttribute('data-pozo-nombre');
        var pozoUbicacion = button.getAttribute('data-pozo-ubicacion');
        var editarNombreInput = document.getElementById('editar_nombre');
        var editarUbicacionInput = document.getElementById('editar_ubicacion');
        editarNombreInput.value = pozoNombre;
        editarUbicacionInput.value = pozoUbicacion;
        document.getElementById('editar_pozo_id').value = pozoId;
    })
</script>

<!-- Script para obtener el ID del pozo seleccionado en el modal de eliminar pozo -->
<script>
    var eliminarPozoModal = document.getElementById('eliminarPozoModal');
    eliminarPozoModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var pozoId = button.getAttribute('data-pozo-id');
        var eliminarPozoIdInput = document.getElementById('eliminar_pozo_id');
        eliminarPozoIdInput.value = pozoId;
    })
</script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

</body>
</html>
