<?php

$servidor = 'localhost';
$baseDatos = 'inventario';
$usuario = 'root';
$contrasena = '';

$conexion = new PDO(
    "mysql:host=$servidor;dbname=$baseDatos;charset=utf8mb4",
    $usuario,
    $contrasena,
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]
);