<?php
require_once __DIR__ . '/../src/validaciones.php';

$casos1 = [
    ["Nombre valido: Teclado", "Teclado", True],
    ["Nombre vacio", "", false],
    ["Nombre con espacios", "   ", false],
    ["Nombre valido: Mouse", "Mouse", true],
];

$casos = [
    ["Cantidad valido: 5", "5", True],
    ["Cantidad menor a 0", "-1", false],
    ["Cantidad en cero", "0", false],
    ["Cantidad valido: 1", "1", true]
];

// Añade esto debajo de tus casos de cantidad
$casosPrecio = [
    ["Precio válido normal (250)", "250", true],
    ["Precio límite superior válido (500)", "500", true],
    ["Precio límite inferior inválido (0)", "0", false],
    ["Precio negativo inválido (-10)", "-10", false],
    ["Precio excede límite (500.01)", "500.01", false]
];

$correctas = 0;
$fallidas = 0;

foreach ($casos1 as [$descripcion, $entrada, $esperado]) {
    $obtenido = validarNombreProducto($entrada);

    if ($obtenido === $esperado) {
        echo "Prueba correcta: $descripcion\n";
        $correctas++;
    } else {
        echo "Prueba fallida: $descripcion\n";
        echo "Esperado: " . var_export($esperado, true) . "\n";
        echo "Obtenido: " . var_export($obtenido, true) . "\n";
        $fallidas++;
    }
}

foreach ($casos as [$descripcion, $entrada, $esperado]) {
    $obtenido = validarCantidadProducto($entrada);

    if ($obtenido === $esperado) {
        echo "Prueba correcta: $descripcion\n";
        $correctas++;
    } else {
        echo "Prueba fallida: $descripcion\n";
        echo "Esperado: " . var_export($esperado, true) . "\n";
        echo "Obtenido: " . var_export($obtenido, true) . "\n";
        $fallidas++;
    }
}

foreach ($casosPrecio as [$descripcion, $entrada, $esperado]) {
    $obtenido = validarPrecioProducto($entrada);
    if ($obtenido === $esperado) {
        echo "Prueba correcta: $descripcion\n";
        $correctas++;
    } else {
        echo "Prueba fallida: $descripcion\n";
        echo "Esperado: " . var_export($esperado, true) . "\n";
        echo "Obtenido: " . var_export($obtenido, true) . "\n";
        $fallidas++;
    }
}

echo "\n--- RESUMEN ---\n";
echo "Total: " . (count($casos) + count($casos1) + count($casosPrecio)) . "\n";
echo "Correctas:  $correctas\n";
echo "Fallidas: $fallidas\n";

exit($fallidas > 0 ? 1 : 0);