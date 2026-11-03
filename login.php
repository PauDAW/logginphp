<?php
// Si existe la cookie "nombre", la usamos para rellenar la caja
$nombre = "";
$recordado = false;
if (isset($_COOKIE["nombre"])) {
    $nombre = $_COOKIE["nombre"];
    $recordado = true;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Acceso al sistema</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="centrado">
    <img class="logo" src="logo.png" alt="Logo">

    <main class="tarjeta">
        <h1>Acceso al sistema</h1>
        <p class="subtitulo">Introduce tus credenciales para continuar</p>
        <p class="subtitulo">Usuario de prueba: <strong>ana</strong> · Contraseña: <strong>1234</strong></p>

        <?php
        // Si validar.php nos manda de vuelta con error, lo mostramos
        if (isset($_GET["error"])) {
            echo '<p class="aviso-error">Usuario o contraseña incorrectos</p>';
        }
        ?>

        <form action="validar.php" method="post">
            <input class="campo" type="text" name="usuario" placeholder="Usuario:" aria-label="Usuario"
                   value="<?php echo htmlspecialchars($nombre); ?>" required>

            <input class="campo" type="password" name="clave" placeholder="Contraseña:" aria-label="Contraseña" required>

            <label class="recordar">
                <input type="checkbox" name="recordar" value="si" <?php echo $recordado ? "checked" : ""; ?>>
                Recordar mi nombre durante 7 días
            </label>

            <button class="boton" type="submit">Iniciar sesión</button>
        </form>

        <a class="enlace-pequeno" href="#">¿Has olvidado tu contraseña?</a>
    </main>
</body>
</html>
