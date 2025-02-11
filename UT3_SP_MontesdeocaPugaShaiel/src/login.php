<?php
// Inicio la sesión
session_start();
include '../includes/funciones.php';

// Obtener preferencias del usuario
$idioma = isset($_COOKIE['idioma']) ? $_COOKIE['idioma'] : 'es';
$estilo = isset($_COOKIE['estilo']) ? $_COOKIE['estilo'] : 'claro';

$error = '';

// Compruebo que los campos se recogen por el método POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Si el usuario es admin y la contraseña es 1234, te crea la sesión de administrador y te lleva al index
    if ($username == 'admin' && $password == '1234') {
        $_SESSION['user'] = 'admin';
        header('Location: index.php');
        exit;
    // Si es otro usuario que no es administrador te crea igualmente la sesión de usuario y te manda al index
    } elseif (!empty($username) && !empty($password)) {
        $_SESSION['user'] = $username;
        header('Location: index.php');
        exit;
    } else {
        $error = ($idioma == 'es') ? 'Usuario o contraseña incorrectos' : 'Incorrect username or password';
    }
}

?>
<!DOCTYPE html>
<html lang="<?php echo $idioma; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo ($idioma == 'es') ? 'Iniciar Sesión - Tienda Online' : 'Login - Online Store'; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body class="<?php echo $estilo; ?>">
    <header>
        <h1><?php echo ($idioma == 'es') ? 'Iniciar Sesión' : 'Login'; ?></h1>
        <nav>
            <a href="index.php"><?php echo ($idioma == 'es') ? 'Volver a la Tienda' : 'Back to Store'; ?></a>
        </nav>
    </header>

    <main>
        <div class="form-container">
            <?php 
                if (!empty($error)) {
                    echo "<p>Error: $error</p>";   
                }
            ?>
            <form action="login.php" method="post">
                <h1 style="text-align: center;"><?php echo ($idioma == 'es') ? 'Iniciar sesión' : 'Login'; ?></h1>
                <div class="form-group">
                    <label for="username"><?php echo ($idioma == 'es') ? 'Nombre de Usuario:' : 'Username:'; ?></label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="password"><?php echo ($idioma == 'es') ? 'Contraseña:' : 'Password:'; ?></label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <button type="submit"><?php echo ($idioma == 'es') ? 'Iniciar Sesión' : 'Login'; ?></button>
                </div>
            </form>
        </div>
    </main>

    <footer>
        <p>&copy; 2023 <?php echo ($idioma == 'es') ? 'Tienda Online' : 'Online Store'; ?></p>
    </footer>
</body>
</html>

