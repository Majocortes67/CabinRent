<?php

session_start();

require_once("../config/conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id_cabina = $_POST["id_cabina"];
    $nombre = trim($_POST["nombre"]);
    $descripcion = trim($_POST["descripcion"]);
    $capacidad = (int) $_POST["capacidad"];
    $precio_noche = $_POST["precio_noche"];
    $imagen = $_POST["imagen"];
    $estado = $_POST["estado"];

    // Validar que no exista otra cabina con el mismo nombre

    $sql = "SELECT COUNT(*)
            FROM cabinas
            WHERE nombre = :nombre
            AND id_cabina <> :id_cabina";

    $stmt = $conexion->prepare($sql);

    $stmt->bindParam(":nombre", $nombre);
    $stmt->bindParam(":id_cabina", $id_cabina, PDO::PARAM_INT);

    $stmt->execute();

    if ($stmt->fetchColumn() > 0) {

        $_SESSION["mensaje"] = "Ya existe otra cabina con ese nombre.";

        header("Location: index.php");
        exit;

    }

    // Actualizar cabina

    $sql = "UPDATE cabinas
            SET
                nombre = :nombre,
                descripcion = :descripcion,
                capacidad = :capacidad,
                precio_noche = :precio_noche,
                imagen = :imagen,
                estado = :estado
            WHERE id_cabina = :id_cabina";

    $stmt = $conexion->prepare($sql);

    $stmt->bindParam(":nombre", $nombre);
    $stmt->bindParam(":descripcion", $descripcion);
    $stmt->bindParam(":capacidad", $capacidad, PDO::PARAM_INT);
    $stmt->bindParam(":precio_noche", $precio_noche);
    $stmt->bindParam(":imagen", $imagen);
    $stmt->bindParam(":estado", $estado);
    $stmt->bindParam(":id_cabina", $id_cabina, PDO::PARAM_INT);

    if ($stmt->execute()) {

        $_SESSION["mensaje"] = "Cabina actualizada correctamente.";

    } else {

        $_SESSION["mensaje"] = "Ocurrió un error al actualizar la cabina.";

    }

    header("Location: index.php");
    exit;

}