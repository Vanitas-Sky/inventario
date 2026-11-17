<?php
$codigoSalida = 0;

try {
    require __DIR__ . '/conexion_pruebas.php';
    echo "Conectado: Se conectó a la base inventario_test.\n";
    
    // I1. INTEGRACIÓN VÁLIDA
    $conexion->beginTransaction();
    echo "\nEjecutando I1: Registro válido...\n";
    
    $consulta = $conexion->prepare('INSERT INTO productos (nombre, cantidad, precio) VALUES (:nombre, :cantidad, :precio)');
    $consulta->execute(['nombre' => 'Teclado', 'cantidad' => 10, 'precio' => 250.50]);
    $id = $conexion->lastInsertId();
    
    $verificacion = $conexion->prepare('SELECT nombre, precio FROM productos WHERE id = :id');
    $verificacion->execute(['id' => $id]);
    $productoGuardado = $verificacion->fetch();
    
    if ($productoGuardado && (float)$productoGuardado['precio'] === 250.50) {
        echo "CORRECTO I1: El dato se guardó y recuperó correctamente en la DB.\n";
    } else {
        echo "ERROR I1: El producto no se guardó como se esperaba.\n";
        $codigoSalida = 1;
    }
    // Limpiar (Rollback)
    $conexion->rollBack();
    echo "Limpieza I1 completada.\n";


    // I2. INTEGRACIÓN INVÁLIDA (Precio fuera de rango)
    $conexion->beginTransaction();
    echo "\nEjecutando I2: Registro inválido (Precio mayor a 500)...\n";
    
    $precioInvalido = 600;
    require_once __DIR__ . '/../src/validaciones.php';
    
    // Simulamos el flujo lógico de guardar.php
    if (!validarPrecioProducto($precioInvalido)) {
        echo "CORRECTO I2: La validación rechazó el dato antes del INSERT, no se creó registro.\n";
    } else {
        // Si fallara la validación y llegara aquí, sería un error
        $consulta->execute(['nombre' => 'Monitor', 'cantidad' => 5, 'precio' => $precioInvalido]);
        echo "ERROR I2: El sistema permitió el registro de un precio inválido.\n";
        $codigoSalida = 1;
    }
    // Limpiar por seguridad
    $conexion->rollBack();
    echo "Limpieza I2 completada.\n";

} catch (PDOException $error) {
    echo "ERROR CRÍTICO: " . $error->getMessage() . "\n";
    if ($conexion !== null && $conexion->inTransaction()) {
        $conexion->rollBack();
    }
    $codigoSalida = 1;
}

exit($codigoSalida);
