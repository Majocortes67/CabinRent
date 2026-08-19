<?php
/* Conexion BD */

$servidor = "localhost";
$usuario = "root";
$contrasena = "Root";
$baseDatos = "cabinrent";

try {

    $conexion = new PDO(
        "mysql:host=$servidor;dbname=$baseDatos;charset=utf8",
        $usuario,
        $contrasena
    );

    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {

    die("Error de conexión: " . $e->getMessage());

}
?>