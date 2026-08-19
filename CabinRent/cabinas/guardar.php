<?php

session_start();

require_once("../config/conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombre = trim($_POST["nombre"]);
    $descripcion = trim($_POST["descripcion"]);
    $capacidad = (int) $_POST["capacidad"];
    $precio_noche = $_POST["precio_noche"];
    $imagen = $_POST["imagen"];
    $estado = $_POST["estado"];

    // Validar que no exista otra cabina con el mismo nombre

    $sql = "SELECT COUNT(*)
            FROM cabinas
            WHERE nombre = :nombre";

    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(":nombre", $nombre);
    $stmt->execute();

    if ($stmt->fetchColumn() > 0) {

        $_SESSION["mensaje"] = "Ya existe una cabina con ese nombre.";

        header("Location: index.php");
        exit;

    }

    // Registrar cabina

    $sql = "INSERT INTO cabinas
            (
                nombre,
                descripcion,
                capacidad,
                precio_noche,
                imagen,
                estado
            )
            VALUES
            (
                :nombre,
                :descripcion,
                :capacidad,
                :precio_noche,
                :imagen,
                :estado
            )";

    $stmt = $conexion->prepare($sql);

    $stmt->bindParam(":nombre", $nombre);
    $stmt->bindParam(":descripcion", $descripcion);
    $stmt->bindParam(":capacidad", $capacidad, PDO::PARAM_INT);
    $stmt->bindParam(":precio_noche", $precio_noche);
    $stmt->bindParam(":imagen", $imagen);
    $stmt->bindParam(":estado", $estado);

    if ($stmt->execute()) {

        $_SESSION["mensaje"] = "Cabina registrada correctamente.";

    } else {

        $_SESSION["mensaje"] = "Ocurrió un error al registrar la cabina.";

    }

    header("Location: index.php");
    exit;

}