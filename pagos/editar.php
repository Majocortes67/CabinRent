<?php

session_start();

require_once("../config/conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id_pago = $_POST["id_pago"];
    $id_reservacion = $_POST["id_reservacion"];
    $fecha_pago = $_POST["fecha_pago"];
    $monto = $_POST["monto"];
    $metodo_pago = $_POST["metodo_pago"];
    $observaciones = trim($_POST["observaciones"]);

    $sql = "UPDATE pagos
            SET
                id_reservacion = :id_reservacion,
                fecha_pago = :fecha_pago,
                monto = :monto,
                metodo_pago = :metodo_pago,
                observaciones = :observaciones
            WHERE id_pago = :id_pago";

    $stmt = $conexion->prepare($sql);

    $stmt->bindParam(":id_reservacion", $id_reservacion, PDO::PARAM_INT);
    $stmt->bindParam(":fecha_pago", $fecha_pago);
    $stmt->bindParam(":monto", $monto);
    $stmt->bindParam(":metodo_pago", $metodo_pago);
    $stmt->bindParam(":observaciones", $observaciones);
    $stmt->bindParam(":id_pago", $id_pago, PDO::PARAM_INT);

    if ($stmt->execute()) {

        $_SESSION["mensaje"] = "Pago actualizado correctamente.";

    } else {

        $_SESSION["mensaje"] = "Ocurrió un error al actualizar el pago.";

    }

    header("Location: index.php");
    exit;

}