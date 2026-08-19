<?php

session_start();

require_once("../config/conexion.php");

if (isset($_GET["id"])) {

    $id = (int) $_GET["id"];

    $sql = "DELETE FROM clientes
            WHERE id_cliente = :id";

    $stmt = $conexion->prepare($sql);

    $stmt->bindParam(":id", $id, PDO::PARAM_INT);

    if ($stmt->execute()) {

        $_SESSION["mensaje"] = "Cliente eliminado correctamente.";

    } else {

        $_SESSION["mensaje"] = "No fue posible eliminar el cliente.";

    }

}

header("Location: index.php");
exit;