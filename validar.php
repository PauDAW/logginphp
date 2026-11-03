<?php
session_start();

// Cerrar sesión: bienvenida.php, subirPractica.php y guardarPractica.php enlazan aquí con ?salir=1
// (la cookie "nombre" se queda, es la de "Recordar mi nombre")
if (isset($_GET["salir"])) {
    session_destroy();
    header("Location: login.php");
    exit;
}

// Solo aceptamos datos enviados desde el formulario
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: login.php");
    exit;
}

// Recogemos los datos del formulario
$usuario = trim($_POST["usuario"] ?? "");
$clave = $_POST["clave"] ?? "";

// Usuario y contraseña de prueba
if ($usuario == "ana" && $clave == "1234") {

    // Guardamos el usuario para saber que ha iniciado sesión
    $_SESSION["usuario"] = $usuario;

    // Si marcó la casilla, creamos la cookie 7 días
    // 60 segundos * 60 minutos * 24 horas * 7 días
    if (isset($_POST["recordar"])) {
        setcookie("nombre", $usuario, time() + 60 * 60 * 24 * 7);
    } else {
        // Si no la marca, borramos la cookie que hubiera
        setcookie("nombre", "", time() - 3600);
    }

    // Mostramos la pantalla "Validación credenciales" y a los 2 segundos
    // el navegador va solo a la página de bienvenida
    header("Refresh: 2; url=bienvenida.php");
} else {
    // Datos incorrectos: volvemos al login con un error
    header("Location: login.php?error=1");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Validación credenciales</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="centrado">
    <main class="tarjeta">
        <div class="spinner" aria-hidden="true">
            <?php for ($i = 0; $i < 12; $i++) { echo '<span style="--i:' . $i . '"></span>'; } ?>
        </div>
        <h1>Validación credenciales</h1>
        <p class="subtitulo">Por favor, espera un momento</p>
    </main>
</body>
</html>
