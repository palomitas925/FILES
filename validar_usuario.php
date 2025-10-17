<?php
header('Content-Type: application/json');

// Obtener datos JSON desde el cuerpo de la solicitud
$data = json_decode(file_get_contents("php://input"), true);

// Extraer usuario y contraseña del JSON recibido
$usuario = $data['usuario'] ?? '';
$contrasena = $data['contrasena'] ?? '';

// Parámetros de conexión
$servername = "localhost";
$username = "Omar";
$password = "Palomitas32$";
$dbname = "popcode";

// Crear conexión
$conexion = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conexion->connect_error) {
  echo json_encode(["exito" => false, "error" => "Error de conexión"]);
  exit;
}

// Establecer el charset a utf8
$conexion->set_charset("utf8");

// Consulta segura con prepared statement
$sql = "SELECT rol_colaborador, area FROM usuarios WHERE nombre_colaborador = ? AND contrasena = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("ss", $usuario, $contrasena);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
  session_start();
$_SESSION['usuario'] = $usuario;
$_SESSION['rol'] = $row["rol_colaborador"];
$_SESSION['area'] = $row["area"];

  echo json_encode([
    "exito" => true,
    "rol_colaborador" => $row["rol_colaborador"],
    "area" => $row["area"]
  ]);
} else {
  echo json_encode(["exito" => false, "error" => "Credenciales inválidas"]);
}

$conexion->close();
?>
