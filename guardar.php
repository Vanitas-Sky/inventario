
<?php

require_once __DIR__ . '/config/conexion.php';
require_once __DIR__ . '/src/Validaciones.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

//Obtener los datos del formulario
$nombre = $_POST['nombre'] ?? '';
$cantidad = $_POST['cantidad'] ?? '';
$precio = $_POST['precio'] ?? '';

// Comprobar que los datos tengan el tipo esperado
if (!is_string($nombre) || !is_string($cantidad)) {
    header('Location: index.php?estado=incompleto');
    exit;
}

// Eliminar espacios innecesarios
$nombre = trim($nombre);
$cantidad = trim($cantidad);
$precio = trim($precio);

// Verificar campos vacíos
if ($nombre === '' || $cantidad === '') {
    header('Location: index.php?estado=incompleto');
    exit;
}

// Validar el nombre del producto
if (!validarNombreProducto($nombre)) {
    header('Location: index.php?estado=nombre_invalido');
    exit;
}

// Validar la cantidad
if (!validarCantidadProducto($cantidad)) {
    header('Location: index.php?estado=cantidad_invalida');
    exit;
}

if (!validarPrecioProducto($precio)) {
    header('Location: index.php?estado=precio_invalido');
    exit;
}

// Guardar en la base de datos
$sentencia = $conexion->prepare(
    'INSERT INTO productos (nombre, cantidad, precio) 
     VALUES (:nombre, :cantidad, :precio)'
);
$sentencia->execute([
    'nombre' => $nombre,
    'cantidad' => (int) $cantidad,
    'precio' => (float) $precio // NUEVO
]);

// Regresar al formulario
header('Location: index.php?estado=guardado');
exit;
