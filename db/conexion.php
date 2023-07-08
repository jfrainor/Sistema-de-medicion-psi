<?php
// Archivo: conexion.php

// Configuración de la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pozos_petroleros";

// Crear la conexión
$conexion = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conexion -> connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

?>


