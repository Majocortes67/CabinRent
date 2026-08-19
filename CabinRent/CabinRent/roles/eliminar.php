<?php

session_start();

require_once("../config/conexion.php");

if (isset($_GET["id"])) {

    $id = (int) $_GET["id"];

    $sql = "DELETE FROM roles WHERE id_rol = :id";

    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);

    if ($stmt->execute()) {

        $_SESSION["mensaje"] = "Rol eliminado correctamente.";

    } else {

        $_SESSION["mensaje"] = "No se pudo eliminar el rol.";

    }

}

header("Location: index.php");
exit;