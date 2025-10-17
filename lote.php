<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Generador de Lote</title>
  <style>
    body { font-family: Arial, sans-serif; margin: 40px; }
    label, select, input { margin: 10px 0; display: block; }
    .resultado { margin-top: 20px; font-weight: bold; color: green; }
  </style>
</head>
<body>

  <h2>Generador Automático de Número de Lote</h2>

  <form method="POST">
    <label for="tipo">Tipo de Producto:</label>
    <select name="tipo" id="tipo" required>
      <option value="T">T</option>
      <option value="TP">TP</option>
    </select>

    <label for="turno">Turno:</label>
    <select name="turno" id="turno" required>
      <option value="A">Matutino (A)</option>
      <option value="B">Vespertino (B)</option>
      <option value="C">Nocturno (C)</option>
    </select>

    <label for="linea">Línea:</label>
    <select name="linea" id="linea" required>
      <option value="1">Línea 1</option>
      <option value="2">Línea 2</option>
      <option value="3">Línea 3</option>
    </select>

    <input type="submit" value="Generar Lote">
  </form>

  <?php
  function generarLote($tipoProducto, $turno, $linea) {
    $fecha = new DateTime();
    $diaJuliano = $fecha->format('z') + 1;
    $año = $fecha->format('y');
    return str_pad($diaJuliano, 3, '0', STR_PAD_LEFT) . $año . strtoupper($tipoProducto) . strtoupper($turno) . $linea;
  }

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tipo = $_POST["tipo"];
    $turno = $_POST["turno"];
    $linea = $_POST["linea"];
    $lote = generarLote($tipo, $turno, $linea);
    echo "<div class='resultado'>Número de lote generado: <strong>$lote</strong></div>";
  }
  ?>

</body>
</html>
