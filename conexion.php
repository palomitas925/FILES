<?php
// Parámetros de conexión
$servername = "localhost";
$username = "Omar";
$password = "Palomitas32$";
$dbname = "popcode";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Establecer el charset a utf8
$conn->set_charset("utf8");
?>
