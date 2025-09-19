<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Control de Producción - Bobina</title>
  <script>
    function iniciarProduccion() {
      document.getElementById("estado").innerText = "Producción iniciada...";
      document.getElementById("lector").focus();
    }

    function validarCodigo() {
      const codigo = document.getElementById("lector").value;
      fetch("validar.php", {
        method: "POST",
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: "codigo=" + encodeURIComponent(codigo)
      })
      .then(res => res.json())
      .then(data => {
        if (data.estado === "ok") {
          document.getElementById("estado").innerText = "Lectura correcta. Producción continúa.";
        } else {
          document.getElementById("estado").innerText = "Error de lectura. Producción detenida.";
          document.getElementById("alarma").play();
        }
        document.getElementById("lector").value = "";
        document.getElementById("lector").focus();
      });
    }
  </script>
</head>
<body onload="iniciarProduccion()">
  <h1>Control de Producción de Bobina</h1>
  <p id="estado">Esperando inicio...</p>

  <input type="text" id="lector" placeholder="Escanea el código" onblur="validarCodigo()" autofocus />

  <audio id="alarma" src="alarma.mp3"></audio>
</body>
</html>
