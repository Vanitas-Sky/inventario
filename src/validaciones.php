
<?php

function validarNombreProducto(string $nombre): bool
{
    $nombre = trim($nombre);

    return mb_strlen($nombre, 'UTF-8') >= 3
        && mb_strlen($nombre, 'UTF-8') <= 50;
}

function validarCantidadProducto($cantidad): bool
{
    if (!is_int($cantidad) && !is_string($cantidad)) {
        return false;
    }

    return filter_var(
        $cantidad,
        FILTER_VALIDATE_INT,
        ['options' => ['min_range' => 1]]
    ) !== false;
}

function validarPrecioProducto($precio): bool {
    // Verificar que sea numérico
    if (!is_numeric($precio)) {
        return false;
    }
    
    $precioFloat = (float) $precio;
    
    // Regla: Número mayor que cero y menor o igual a 500
    return $precioFloat > 0 && $precioFloat <= 500;
}
