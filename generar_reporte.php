<?php
session_start();
include 'conexion.php';

$fecha_inicio = $_POST['fecha_inicio'] ?? '';
$fecha_final = $_POST['fecha_final'] ?? '';
$con_lote = isset($_POST['con_lote']);
$con_hora = isset($_POST['con_hora']);

// Validación básica
if (!$fecha_inicio || !$fecha_final) {
    echo "Fechas inválidas.";
    exit;
}

// Construcción dinámica de columnas
$columnas = "id_escaneado, nombre_colaborador_usuarios, fecha_escaneo, codigo_barras_producto, descripcion_producto, estado_escaneo";
if ($con_lote) $columnas .= ", lote_escaneado";
if ($con_hora) $columnas .= ", hora_escaneo";

// Consulta filtrada
$sql = "SELECT $columnas FROM registros_escaneos WHERE fecha_escaneo BETWEEN ? AND ? ORDER BY fecha_escaneo DESC, hora_escaneo DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $fecha_inicio, $fecha_final);
$stmt->execute();
$resultado = $stmt->get_result();
?>

<!DOCTYPE html
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Reporte de Escaneos</title>
  <style>
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }
    th, td {
      border: 1px solid #ccc;
      padding: 8px;
      text-align: center;
    }
    h2 {
      text-align: center;
      margin-top: 20px;
    }
  </style>
</head>
<body>
  <h2>Reporte de Escaneos<br>Del <?= $fecha_inicio ?> al <?= $fecha_final ?></h2>

  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Operador</th>
        <th>Fecha</th>
        <?php if ($con_hora): ?><th>Hora</th><?php endif; ?>
        <th>Código</th>
        <th>Descripción</th>
        <?php if ($con_lote): ?><th>Lote</th><?php endif; ?>
        <th>Estado</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($row = $resultado->fetch_assoc()): ?>
        <tr>
          <td><?= $row['id_escaneado'] ?></td>
          <td><?= $row['nombre_colaborador_usuarios'] ?></td>
          <td><?= $row['fecha_escaneo'] ?></td>
          <?php if ($con_hora): ?><td><?= $row['hora_escaneo'] ?? '-' ?></td><?php endif; ?>
          <td><?= $row['codigo_barras_producto'] ?></td>
          <td><?= $row['descripcion_producto'] ?></td>
          <?php if ($con_lote): ?><td><?= $row['lote_escaneado'] ?? '-' ?></td><?php endif; ?>
          <td><?= $row['estado_escaneo'] ?></td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</body>
</html>
