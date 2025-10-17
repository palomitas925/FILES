<?php
session_start();
include 'conexion.php';
date_default_timezone_set('America/Mexico_City');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['codigo_barras'])) {
    $codigo = intval($_POST['codigo_barras']);
    $lote = intval($_POST['lote_escaneado']);
    $usuario = $_SESSION['usuario'] ?? 'desconocido';

    $consulta = $conn->prepare("SELECT descripcion, imagen FROM productos_escanear WHERE codigo_barras = ?");
    $consulta->bind_param("i", $codigo);
    $consulta->execute();
    $resultado = $consulta->get_result();

    $estado = "fallido";
    if ($resultado->num_rows > 0) {
        $datos = $resultado->fetch_assoc();
        $descripcion = $datos['descripcion'];
        $imagen = $datos['imagen'];
        $estado = "exitoso";

        // Registro del escaneo
        $registro = $conn->prepare("INSERT INTO registros_escaneos (
            codigo_barras_producto,
            descripcion_producto,
            lote_escaneado,
            fecha_escaneo,
            hora_escaneo,
            estado_escaneo,
            nombre_colaborador_usuarios
        ) VALUES (?, ?, ?, CURDATE(), CURTIME(), ?, ?)");

        $registro->bind_param("isisss", $codigo, $descripcion, $lote, $estado, $usuario);
        $registro->execute();
    } else {
        $descripcion = "No encontrado";
        $imagen = "img/error.png";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>POPCODE</title>
  <link rel="stylesheet" href="estilo_esc_prod.css">
</head>
<body>
  <div class="contenedor">
    <div class="panel-izquierdo">
      <h1>Escaneo de Productos</h1>
      <form method="POST">
        <label>Código de barras:</label>
        <input type="text" name="codigo_barras" autofocus autocomplete="off" required>

        <label>Descripción:</label>
        <input type="textarea" value="<?= $descripcion ?? '' ?>" readonly>

        <div class="focos">
          <div class="foco <?= ($estado ?? '') === 'exitoso' ? 'verde' : 'rojo' ?>"></div>
        </div>

        <div class="botones">
          <button type="button" onclick="location.href='producto_escanear_lote.php'">Regresar</button>
          <button type="button" onclick="location.href='registro_escaneos.php'">Registros</button>
        </div>
      </form>
    </div>

    <div class="panel-derecho">
      <label>Imagen:</label>
      <div class="imagen">
        <img src="<?= $imagen ?? 'img/placeholder.png' ?>" alt="Imagen del producto" width="200">
        <p>IMG 600x900</p>
      </div>
    </div>
  </div>
</body>
</html>
