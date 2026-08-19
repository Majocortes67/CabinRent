<?php

session_start();

require_once("../config/conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombre = trim($_POST["nombre"]);
    $estado = $_POST["estado"];

    // Validar que no exista otro rol con el mismo nombre
    $sql = "SELECT COUNT(*) FROM roles WHERE nombre = :nombre";

    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(":nombre", $nombre);
    $stmt->execute();

    if ($stmt->fetchColumn() > 0) {

        $_SESSION["mensaje"] = "El rol ya existe.";
        header("Location: index.php");
        exit;

    }

    // Insertar el nuevo rol
    $sql = "INSERT INTO roles (nombre, estado)
            VALUES (:nombre, :estado)";

    $stmt = $conexion->prepare($sql);

    $stmt->bindParam(":nombre", $nombre);
    $stmt->bindParam(":estado", $estado);

    if ($stmt->execute()) {

        $_SESSION["mensaje"] = "Rol registrado correctamente.";

    } else {

        $_SESSION["mensaje"] = "Ocurrió un error.";

    }

    header("Location: index.php");
    exit;

}