<?php
session_start();

// Si no ha iniciado sesión, lo mandamos al login
if (!isset($_SESSION["usuario"])) {
    header("Location: login.php");
    exit;
}
$usuario = $_SESSION["usuario"];
$nombreMostrar = ucfirst($usuario); // ana -> Ana

// Solo se puede llegar aquí desde el formulario
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: subirPractica.php");
    exit;
}

$carpeta = "uploads/";
$extensionesPermitidas = ["pdf", "doc", "docx", "zip"];
$tamanoMaximo = 5 * 1024 * 1024; // 5 MB

$titulo = trim($_POST["titulo"] ?? "");
$descripcion = trim($_POST["descripcion"] ?? "");
$error = "";
$guardado = false;
$nombreOriginal = "";

if ($titulo === "" || $descripcion === "") {
    $error = "Debes rellenar el título y la descripción.";

} elseif (!isset($_FILES["archivo"]) || $_FILES["archivo"]["error"] === UPLOAD_ERR_NO_FILE) {
    $error = "Debes seleccionar un archivo.";

} elseif ($_FILES["archivo"]["error"] === UPLOAD_ERR_INI_SIZE || $_FILES["archivo"]["error"] === UPLOAD_ERR_FORM_SIZE) {
    $error = "El archivo es demasiado grande.";

} elseif ($_FILES["archivo"]["error"] !== UPLOAD_ERR_OK) {
    $error = "No se ha podido subir el archivo. Inténtalo de nuevo.";

} else {
    $nombreOriginal = basename($_FILES["archivo"]["name"]);
    $extension = strtolower(pathinfo($nombreOriginal, PATHINFO_EXTENSION));

    if (!in_array($extension, $extensionesPermitidas)) {
        $error = "Formato no permitido. Solo se admiten PDF, DOC, DOCX y ZIP.";

    } elseif ($_FILES["archivo"]["size"] > $tamanoMaximo) {
        $error = "El archivo supera el máximo de 5 MB.";

    } else {
        // La carpeta debe existir antes de guardar
        if (!is_dir($carpeta)) {
            mkdir($carpeta, 0755, true);
        }

        // Quitamos caracteres raros y añadimos fecha para que no se pisen archivos
        $nombreLimpio = preg_replace("/[^A-Za-z0-9._-]/", "_", $nombreOriginal);
        $nombreGuardado = date("Ymd_His") . "_" . $nombreLimpio;

        if (move_uploaded_file($_FILES["archivo"]["tmp_name"], $carpeta . $nombreGuardado)) {

            // Cookie con el nombre del último archivo enviado (7 días)
            setcookie("ultimo_archivo", $nombreOriginal, time() + 60 * 60 * 24 * 7);

            $guardado = true;
        } else {
            $error = "No se ha podido guardar el archivo en el servidor.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $guardado ? "Práctica subida" : "Error al subir"; ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="centrado">
    <main class="tarjeta ancha">
        <?php if ($guardado) { ?>

            <svg class="icono-grande" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path d="M7.5 12.5l3 3 6-7"/></svg>
            <h1>Práctica subida correctamente</h1>
            <p class="subtitulo">Tu práctica se ha guardado en el sistema</p>

            <div class="resumen">
                <div><strong>Título:</strong> <span><?php echo htmlspecialchars($titulo); ?></span></div>
                <div><strong>Descripción:</strong> <span><?php echo htmlspecialchars($descripcion); ?></span></div>
                <div><strong>Archivo:</strong> <span><?php echo htmlspecialchars($nombreOriginal); ?></span></div>
            </div>

            <div class="acciones">
                <a class="boton" href="subirPractica.php">Subir otra práctica</a>
                <a class="boton secundario" href="bienvenida.php">Volver al menú</a>
            </div>

        <?php } else { ?>

            <svg class="icono-grande" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path d="M8.5 8.5l7 7M15.5 8.5l-7 7"/></svg>
            <h1>No se ha podido subir</h1>
            <p class="aviso-error"><?php echo htmlspecialchars($error); ?></p>

            <div class="acciones">
                <a class="boton" href="subirPractica.php">Volver al formulario</a>
            </div>

        <?php } ?>
    </main>
</body>
</html>
