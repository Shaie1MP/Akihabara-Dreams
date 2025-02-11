<?php
// Función para agregar un producto al carrito pasandole el nombre y el precio
function agregarAlCarrito($nombre, $precio) {
    $carrito = isset($_COOKIE['carrito']) ? json_decode($_COOKIE['carrito'], true) : [];
    
    if (isset($carrito[$nombre])) {
        $carrito[$nombre]['cantidad']++;
    } else {
        $carrito[$nombre] = [
            'nombre' => $nombre,
            'precio' => $precio,
            'cantidad' => 1
        ];
    }
    
    setcookie('carrito', json_encode($carrito), time() + (86400 * 30), '/'); // Cookie válida por 30 días
}

// Función para obtener el contenido del carrito
function obtenerCarrito() {
    return isset($_COOKIE['carrito']) ? json_decode($_COOKIE['carrito'], true) : [];
}

// Función para obtener el total de productos en el carrito
function obtenerTotalProductos() {
    $carrito = obtenerCarrito();
    $total = 0;
    foreach ($carrito as $producto) {
        $total += $producto['cantidad'];
    }
    return $total;
}

// Función para obtener el precio total del carrito
function obtenerPrecioTotal() {
    $carrito = obtenerCarrito();
    $total = 0;
    foreach ($carrito as $producto) {
        $total += $producto['precio'] * $producto['cantidad'];
    }
    return $total;
}

// Función para vaciar el carrito
function vaciarCarrito() {
    setcookie('carrito', '', time() + 3600, '/');
}

