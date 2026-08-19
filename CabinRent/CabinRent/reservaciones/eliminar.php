<?php

session_start();

require_once("../config/conexion.php");

if (isset($_GET["id"])) {

    $id = (int) $_GET["id"];

    $sql = "DELETE FROM reservaciones
            WHERE id_reservacion = :id";

    $stmt = $conexion->prepare($sql);

    $stmt->bindParam(":id", $id, PDO::PARAM_INT);

    if ($stmt->execute()) {

        $_SESSION["mensaje"] = "Reservación eliminada correctamente.";

    } else {

        $_SESSION["mensaje"] = "No fue posible eliminar la reservación.";

    }

}

header("Location: index.php");
exit;