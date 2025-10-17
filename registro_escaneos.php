<?php
session_start();
include 'conexion.php';

$usuario = $_SESSION['usuario'] ?? 'desconocido';

$consulta = $conn->prepare("SELECT id_escaneado, lote_escaneado, nombre_colaborador_usuarios, fecha_escaneo, hora_escaneo, codigo_barras_producto, descripcion_producto, estado_escaneo FROM registros_escaneos ORDER BY fecha_escaneo DESC, hora_escaneo DESC");
$consulta->execute();
$resultado = $consulta->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Registro de Escaneos</title>
  <link rel="stylesheet" href="estilos.css">
  <style>
    .modal {
      display: none;
      position: fixed;
      top: 20%;
      left: 30%;
      width: 40%;
      background: white;
      border: 2px solid #ccc;
      padding: 20px;
      z-index: 1000;
      border-radius: 10px;
    }
    .modal input[type="date"] {
      width: 100%;
      margin-bottom: 10px;
    }
    .modal label {
      display: block;
      margin-top: 10px;
    }
    .overlay {
      display: none;
      position: fixed;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background: rgba(0,0,0,0.5);
      z-index: 999;
    }
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
    .botones {
      margin-top: 20px;
    }
  </style>
</head>
<body>
  <h1>Registro de Escaneos</h1>

  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Lote</th>
        <th>Operador</th>
        <th>Fecha</th>
        <th>Hora</th>
        <th>Código barras</th>
        <th>Descripción</th>
        <th>Estado</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($row = $resultado->fetch_assoc()): ?>
        <tr>
          <td><?= $row['id_escaneado'] ?></td>
          <td><?= $row['lote_escaneado'] ?></td>
          <td><?= $row['nombre_colaborador_usuarios'] ?></td>
          <td><?= $row['fecha_escaneo'] ?></td>
          <td><?= $row['hora_escaneo'] ?></td>
          <td><?= $row['codigo_barras_producto'] ?></td>
          <td><?= $row['descripcion_producto'] ?></td>
          <td><?= $row['estado_escaneo'] ?></td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>

  <div class="botones">
    <button onclick="abrirModal()">Generar Reporte</button>
    <button onclick="location.href='panel.php'">Regresar</button>
  </div>

  <!-- Ventana emergente -->
  <div class="overlay" id="overlay"></div>
  <div class="modal" id="modal">
    <h3>Preferencias de Reporte</h3>
    <form action="generar_reporte.php" method="POST">
      <label>Fecha inicio:</label>
      <input type="date" name="fecha_inicio" required>

      <label>Fecha final:</label>
      <input type="date" name="fecha_final" required>

      <label><input type="checkbox" name="con_lote"> Con Lote</label>
      <label><input type="checkbox" name="con_hora"> Con Horas</label>

      <div style="margin-top: 15px;">
        <button type="submit">Generar</button>
        <button type="button" onclick="cerrarModal()">Cancelar</button>
      </div>
    </form>
  </div>

  <script>
    function abrirModal() {
      document.getElementById('modal').style.display = 'block';
      document.getElementById('overlay').style.display = 'block';
    }
    function cerrarModal() {
      document.getElementById('modal').style.display = 'none';
      document.getElementById('overlay').style.display = 'none';
    }
  </script>
</body>
</html>
