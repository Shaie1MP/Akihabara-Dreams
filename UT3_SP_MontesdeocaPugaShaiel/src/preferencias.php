<?php
// Inicio la sesión
session_start();
include '../includes/funciones.php';

// Verifico si el usuario ha iniciado sesión
$logged_in = isset($_SESSION['user']);

// Obtengo las preferencias actuales del usuario
$idioma = isset($_COOKIE['idioma']) ? $_COOKIE['idioma'] : 'es';
$estilo = isset($_COOKIE['estilo']) ? $_COOKIE['estilo'] : 'claro';

// Compruebo que los campos se han enviado por el método POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nuevo_idioma = $_POST['idioma'] ?? 'es';
    $nuevo_estilo = $_POST['estilo'] ?? 'claro';

    setcookie('idioma', $nuevo_idioma, time() + (86400 * 30));
    setcookie('estilo', $nuevo_estilo, time() + (86400 * 30));

    // Actualizar las variables para reflejar los cambios inmediatamente
    $idioma = $nuevo_idioma;
    $estilo = $nuevo_estilo;
}

?>
<!DOCTYPE html>
<html lang="<?php echo $idioma; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo ($idioma == 'es') ? 'Preferencias - Tienda Online' : 'Preferences - Online Store'; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body class="<?php echo $estilo; ?>">
    <header>
        <h1><?php echo ($idioma == 'es') ? 'Preferencias' : 'Preferences'; ?></h1>
        <nav>
            <a href="index.php"><?php echo ($idioma == 'es') ? 'Volver a la Tienda' : 'Back to Store'; ?></a>
        </nav>
    </header>

    <main>
        <div class="form-container">
            <form action="preferencias.php" method="post">
                <div class="form-group">
                    <label for="idioma"><?php echo ($idioma == 'es') ? 'Idioma:' : 'Language:'; ?></label>
                    <select name="idioma" id="idioma">
                        <option value="es" <?php echo $idioma == 'es' ? 'selected' : ''; ?>><?php echo ($idioma == 'es') ? 'Español' : 'Spanish'; ?></option>
                        <option value="en" <?php echo $idioma == 'en' ? 'selected' : ''; ?>><?php echo ($idioma == 'es') ? 'Inglés' : 'English'; ?></option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="estilo"><?php echo ($idioma == 'es') ? 'Estilo:' : 'Style:'; ?></label>
                    <select name="estilo" id="estilo">
                        <option value="claro" <?php echo $estilo == 'claro' ? 'selected' : ''; ?>><?php echo ($idioma == 'es') ? 'Claro' : 'Light'; ?></option>
                        <option value="oscuro" <?php echo $estilo == 'oscuro' ? 'selected' : ''; ?>><?php echo ($idioma == 'es') ? 'Oscuro' : 'Dark'; ?></option>
                    </select>
                </div>
                <div class="form-group">
                    <button type="submit"><?php echo ($idioma == 'es') ? 'Guardar Preferencias' : 'Save Preferences'; ?></button>
                </div>
            </form>
        </div>
    </main>

    <footer>
        <p>&copy; 2023 <?php echo ($idioma == 'es') ? 'Tienda Online' : 'Online Store'; ?></p>
    </footer>
</body>
</html>

