<?php
session_start();

// Si no ha iniciado sesión, lo mandamos al login
if (!isset($_SESSION["usuario"])) {
    header("Location: login.php");
    exit;
}
$usuario = $_SESSION["usuario"];
$nombreMostrar = ucfirst($usuario); // ana -> Ana

// Cookie con el último archivo entregado (la crea guardarPractica.php)
if (isset($_COOKIE["ultimo_archivo"])) {
    $mensaje = "Último archivo entregado: " . htmlspecialchars($_COOKIE["ultimo_archivo"]);
} else {
    $mensaje = "No has realizado entregas todavía.";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Subir práctica</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="cabecera">
        <a class="marca" href="bienvenida.php">Mi proyecto</a>
        <nav class="cabecera-der">
            <details class="menu-usuario">
                <summary>Hola, <?php echo htmlspecialchars($nombreMostrar); ?></summary>
                <div>
                    <a href="bienvenida.php">Menú principal</a>
                    <a href="subirPractica.php">Subir práctica</a>
                </div>
            </details>
            <a href="validar.php?salir=1">Cerrar sesión</a>
        </nav>
    </header>

    <main class="contenido">
        <h1 class="titulo-pagina">Subir práctica</h1>

        <p class="mensaje-ultimo"><?php echo $mensaje; ?></p>

        <form class="formulario" action="guardarPractica.php" method="post" enctype="multipart/form-data">
            <label for="titulo">Título de la práctica</label>
            <input type="text" id="titulo" name="titulo" placeholder="Introduce el título" required>

            <label for="descripcion">Descripción</label>
            <textarea id="descripcion" name="descripcion" placeholder="Descripción de la práctica" required></textarea>

            <label for="archivo">Archivo (PDF, DOC, DOCX, ZIP)</label>
            <div class="selector-archivo">
                <label class="boton-archivo" for="archivo">Seleccionar archivo</label>
                <input type="file" id="archivo" name="archivo" accept=".pdf,.doc,.docx,.zip" required>
                <span id="nombre-archivo">Ningún archivo seleccionado</span>
            </div>

            <button class="boton" type="submit">Guardar práctica</button>
        </form>
    </main>

    <script>
        // Muestra el nombre del archivo elegido
        document.getElementById("archivo").addEventListener("change", function () {
            var nombre = this.files.length ? this.files[0].name : "Ningún archivo seleccionado";
            document.getElementById("nombre-archivo").textContent = nombre;
        });
    </script>
</body>
</html>
