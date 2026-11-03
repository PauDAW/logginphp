<?php
session_start();

// Si no ha iniciado sesión, lo mandamos al login
if (!isset($_SESSION["usuario"])) {
    header("Location: login.php");
    exit;
}
$usuario = $_SESSION["usuario"];
$nombreMostrar = ucfirst($usuario); // ana -> Ana

// Contador de visitas con cookie (dura 7 días)
if (isset($_COOKIE["visitas"])) {
    $visitas = (int) $_COOKIE["visitas"] + 1;
} else {
    $visitas = 1;
}
setcookie("visitas", $visitas, time() + 60 * 60 * 24 * 7);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bienvenida</title>
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
        <div class="bienvenida">
            <h1>
                <svg class="icono" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><circle cx="12" cy="7" r="4.5"/><path d="M3 22c0-5 4-8 9-8s9 3 9 8z"/></svg>
                ¡Bienvenido/a, <?php echo htmlspecialchars($nombreMostrar); ?>!
            </h1>
            <p>Has visitado esta página <?php echo $visitas; ?> <?php echo $visitas == 1 ? "vez" : "veces"; ?></p>
        </div>

        <a class="opcion" href="subirPractica.php">
            <svg class="icono" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 18a4.5 4.5 0 0 1-.5-9 6 6 0 0 1 11.5 1.5A3.8 3.8 0 0 1 17.5 18"/><path d="M12 21v-8M9 15.5l3-3 3 3"/></svg>
            Subir nueva práctica
        </a>
        <a class="opcion" href="validar.php?salir=1">
            <svg class="icono" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M10 4H5v16h5M9 12h12M17 8l4 4-4 4"/></svg>
            Cerrar sesión
        </a>
    </main>
</body>
</html>
