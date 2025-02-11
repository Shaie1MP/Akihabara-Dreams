<?php
// Inicio la sesión
session_start();
include '../includes/funciones.php';

// Verifico si el usuario ha iniciado sesión
$logged_in = isset($_SESSION['user']);

// Obtengo las preferencias del usuario
$idioma = isset($_COOKIE['idioma']) ? $_COOKIE['idioma'] : 'es';
$estilo = isset($_COOKIE['estilo']) ? $_COOKIE['estilo'] : 'claro';

$carrito = obtenerCarrito();

$total_productos = obtenerTotalProductos();
$total_precio = obtenerPrecioTotal();

if (isset($_POST['vaciar_carrito'])) {
    vaciarCarrito();
    header('Location: carrito.php');
    exit;
}

?>
<!DOCTYPE html>
<html lang="<?php echo $idioma; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo ($idioma == 'es') ? 'Carrito - Tienda de Mangas' : 'Cart - Manga Store'; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body class="<?php echo $estilo; ?>">
<header>
    <h1><?php echo ($idioma == 'es') ? 'Carrito de Compras' : 'Shopping Cart'; ?></h1>
    
    <nav>
        <a href="index.php"><?php echo ($idioma == 'es') ? 'Volver a la Tienda' : 'Back to Store'; ?></a>
    </nav>
</header>

<main>
    <?php if (empty($carrito)): ?>
        <p><?php echo ($idioma == 'es') ? 'El carrito está vacío' : 'The cart is empty'; ?></p>
    <?php else: ?>
        <!-- Si hay productos en el carrito, genera una tabla para mostrar los detalles -->
        <table>
            <thead>
                <tr>
                    <th><?php echo ($idioma == 'es') ? 'Producto' : 'Product'; ?></th>
                    <th><?php echo ($idioma == 'es') ? 'Cantidad' : 'Quantity'; ?></th>
                    <th><?php echo ($idioma == 'es') ? 'Precio' : 'Price'; ?></th>
                    <th><?php echo ($idioma == 'es') ? 'Total' : 'Total'; ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($carrito as $producto): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($producto['nombre']); ?></td>
                        <td><?php echo $producto['cantidad']; ?></td>
                        <td><?php echo number_format($producto['precio'], 2); ?>€</td>
                        <td><?php echo number_format($producto['precio'] * $producto['cantidad'], 2); ?>€</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3"><?php echo ($idioma == 'es') ? 'Total' : 'Total'; ?></td>
                    <td><?php echo number_format($total_precio, 2); ?>€</td>
                </tr>
            </tfoot>
        </table>

        <p><?php echo ($idioma == 'es') ? 'Cantidad total de productos:' : 'Total quantity of products:'; ?> <?php echo $total_productos; ?></p>
        
        <form action="carrito.php" method="post">
            <button type="submit" name="vaciar_carrito"><?php echo ($idioma == 'es') ? 'Vaciar Carrito' : 'Empty Cart'; ?></button>
        </form>
    <?php endif; ?>
</main>

<footer>
    <p>&copy; 2023 <?php echo ($idioma == 'es') ? 'Tienda de Mangas' : 'Manga Store'; ?></p>
</footer>
</body>
</html>

