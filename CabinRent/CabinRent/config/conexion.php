<?php

$host = "127.0.0.1";
$puerto = 3306;
$usuario = "root";
$contrasena = "Root";
$baseDatos = "cabinrent";

try {

    $conexion = new PDO(
        "mysql:host=$host;port=$puerto;dbname=$baseDatos;charset=utf8mb4",
        $usuario,
        $contrasena,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]
    );

    echo "Conectado correctamente";

} catch (PDOException $e) {

    die($e->getMessage());

}