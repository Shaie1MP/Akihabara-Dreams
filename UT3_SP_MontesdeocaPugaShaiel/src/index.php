<?php
// Inicio la sesión
session_start();
include '../includes/funciones.php';

// Verifico si el usuario ha iniciado sesión
$logged_in = isset($_SESSION['user']);
$is_admin = isset($_SESSION['user']) && $_SESSION['user'] == 'admin';

// Obtengo las preferencias del usuario
$idioma = isset($_COOKIE['idioma']) ? $_COOKIE['idioma'] : 'es';
$estilo = isset($_COOKIE['estilo']) ? $_COOKIE['estilo'] : 'claro';

// Manejar la adición de productos al carrito
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['agregar_al_carrito'])) {
    $nombre = $_POST['producto'] ?? '';
    $precio = floatval($_POST['precio'] ?? 0);

    if (!empty($nombre) && $precio > 0) {
        agregarAlCarrito($nombre, $precio);
    }
}

// Obtener el número de productos en el carrito
$num_productos_carrito = obtenerTotalProductos();

// Lista de productos (en la práctica, esto podría venir de una base de datos)
$productos = [
    ["nombre" => "One Piece Vol. 1", "precio" => 9.99, "imagen" => "../images/portada_one-piece.jpg"],
    ["nombre" => "Naruto Vol. 1", "precio" => 9.99, "imagen" => "../images/portada_naruto.jpg"],
    ["nombre" => "Attack on Titan Vol. 1", "precio" => 12.99, "imagen" => "../images/portada_shingeki.jpg"],
    ["nombre" => "My Hero Academia Vol. 1", "precio" => 9.99, "imagen" => "../images/portada_mha.jpg"],
    ["nombre" => "Death Note Vol. 1", "precio" => 9.99, "imagen" => "../images/portada_deathNote.jpeg"],
    ["nombre" => "Fullmetal Alchemist Vol. 1", "precio" => 10.99, "imagen" => "../images/portada_fullmetal.jpeg"],
    ["nombre" => "Dragon Ball Super Vol. 1", "precio" => 9.99, "imagen" => "../images/portada_dragon-ball-super.jpg"],
    ["nombre" => "Demon Slayer Vol. 1", "precio" => 11.99, "imagen" => "../images/portada_kimetsu.jpg"],
    ["nombre" => "Tokyo Ghoul Vol. 1", "precio" => 10.99, "imagen" => "../images/portada_tokyoGhoul.jpeg"],
    ["nombre" => "Hunter x Hunter Vol. 1", "precio" => 9.99, "imagen" => "../images/portada_HxH.jpg"],
    ["nombre" => "Bleach Vol. 1", "precio" => 9.99, "imagen" => "../images/portada_bleach.jpg"],
    ["nombre" => "Jujutsu Kaisen Vol. 1", "precio" => 11.99, "imagen" => "../images/portada_jjk.jpg"],
    ["nombre" => "One Punch Man Vol. 1", "precio" => 10.99, "imagen" => "../images/portada_onePunchMan.jpg"],
    ["nombre" => "Black Clover Vol. 1", "precio" => 9.99, "imagen" => "../images/portada_blackClover.jpg"],
    ["nombre" => "Berserk Vol. 1", "precio" => 14.99, "imagen" => "../images/portada_berserk.jpg"],
    ["nombre" => "Nana Vol. 1", "precio" => 10.99, "imagen" => "../images/portada_nana.jpg"],
    ["nombre" => "Fruits Basket Vol. 1", "precio" => 9.99, "imagen" => "../images/portada_fruitbasket.jpg"],
    ["nombre" => "Monster Vol. 1", "precio" => 12.99, "imagen" => "../images/portada_monster.jpg"],
    ["nombre" => "Haikyuu!! Vol. 1", "precio" => 9.99, "imagen" => "../images/portada_haikyuu.jpg"],
    ["nombre" => "Slam Dunk Vol. 1", "precio" => 10.99, "imagen" => "../images/portada_slamdunk.jpg"]
];

?>
<!DOCTYPE html>
<html lang="<?php echo $idioma; ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo ($idioma == 'es') ? 'Tienda de Mangas' : 'Manga Store'; ?></title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap">
    <link rel="stylesheet" href="../css/estilos.css">
</head>

<body class="<?php echo $estilo; ?>">
<header>
    <div>
        <img src="../images/app.brandmark.io_v3.png">
    </div>
    
    <div>
        <nav>
            <a href="carrito.php">
                <?php echo ($idioma == 'es') ? 'Carrito' : 'Cart'; ?>
                (<?php echo $num_productos_carrito; ?>) <!-- Número dinámico de productos en el carrito -->
            </a>
            
            <a href="preferencias.php"><?php echo ($idioma == 'es') ? 'Preferencias' : 'Preferences'; ?></a>
            
            <!-- Si el usuario está autenticado, muestra el enlace para cerrar sesión, de lo contrario, muestra el de iniciar sesión -->
            <?php if ($logged_in): ?>
                <a href="logout.php"><?php echo ($idioma == 'es') ? 'Cerrar Sesión' : 'Logout'; ?></a>
            <?php else: ?>
                <a href="login.php"><?php echo ($idioma == 'es') ? 'Iniciar Sesión' : 'Login'; ?></a>
            <?php endif; ?>
        </nav>
    </div>
</header>

<main>
    <!-- Mensaje especial si el usuario es administrador -->
    <?php if ($is_admin): ?>
        <p><?php echo ($idioma == 'es') ? '<h1>¡Bienvenido, Administrador!</h1>' : '<h1>Welcome, Administrator!</h1>'; ?></p>
    
    <!-- Mensaje de bienvenida personalizado si el usuario está autenticado -->
    <?php elseif ($logged_in): ?>
        <p><?php echo ($idioma == 'es') ? "<h1>¡Bienvenido, ". $_SESSION['user']. "!</h1>" : "<h1>Welcome, ". $_SESSION['user']. "!</h1>"; ?></p>
    <?php endif; ?>

    <h2><?php echo ($idioma == 'es') ? 'Nuestros Mangas' : 'Our Manga'; ?></h2>

    <div class="productos">
        <!-- Iteración sobre la lista de productos para mostrar cada uno -->
        <?php foreach ($productos as $producto): ?>
            <div class="producto">
                <img src="<?php echo htmlspecialchars($producto['imagen']); ?>" 
                    alt="<?php echo htmlspecialchars($producto['nombre']); ?>">
                
                <h3><?php echo htmlspecialchars($producto['nombre']); ?></h3>
                
                <p><?php echo number_format($producto['precio'], 2); ?>€</p>
                
                <form action="index.php" method="post">
                    <!-- Campos ocultos con el nombre y precio del producto para enviarlos al servidor -->
                    <input type="hidden" name="producto" value="<?php echo htmlspecialchars($producto['nombre']); ?>">
                    <input type="hidden" name="precio" value="<?php echo $producto['precio']; ?>">
                    
                    <button type="submit" 
                        name="agregar_al_carrito"><?php echo ($idioma == 'es') ? 'Agregar al carrito' : 'Add to cart'; ?></button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
</main>


    <footer>
        <p>&copy; 2023 <?php echo ($idioma == 'es') ? 'Tienda de Mangas' : 'Manga Store'; ?></p>
    </footer>
</body>

</html>