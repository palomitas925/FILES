<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'Administrador') {
  header("Location: index.html");
  exit;
}
$usuario_nombre = $_SESSION['usuario'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>POP CODE - Administrador</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

  <header>
    <img src="../imagenes/SLIMPOP.png" alt="Logo SlimPop">
    <h1>Administrador TI </h1>
    <a href="logout.php" class="logout-btn">Cerrar sesión</a>
  </header>

  <main>
    <h2>¡Bienvenido, <?php echo htmlspecialchars( $usuario_nombre); ?>!</h2>
    <p>¿Qué deseas hacer hoy?</p>

    <div class="button-grid">
      <a href="escaneo.html" class="action-btn">
        <span>𝄃𝄂𝄀𝄁</span>
        Escanear
      </a>

      <a href="inventarios.html" class="action-btn">
        <span>📋</span>
        Inventarios
      </a>

      <a href="reportes.html" class="action-btn">
        <span>📊</span>
        Reportes
      </a>

      <a href="usuarios.html" class="action-btn">
        <span>👥</span>
        Usuarios
      </a>

      <a href="retiros.html" class="action-btn">
        <span>🔄</span>
        Retiro y Devoluciones
      </a>
    </div>
  </main>

  <footer>
    <img src="../imagenes/carita_feliz_blanca.png" alt="Logo SlimPop" class="logo-esquina">
  </footer>

</body>
</html>
