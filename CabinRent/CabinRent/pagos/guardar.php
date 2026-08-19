<?php

session_start();

require_once("../config/conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id_reservacion = $_POST["id_reservacion"];
    $fecha_pago = $_POST["fecha_pago"];
    $monto = $_POST["monto"];
    $metodo_pago = $_POST["metodo_pago"];
    $observaciones = trim($_POST["observaciones"]);

    $sql = "INSERT INTO pagos
            (
                id_reservacion,
                fecha_pago,
                monto,
                metodo_pago,
                observaciones
            )
            VALUES
            (
                :id_reservacion,
                :fecha_pago,
                :monto,
                :metodo_pago,
                :observaciones
            )";

    $stmt = $conexion->prepare($sql);

    $stmt->bindParam(":id_reservacion", $id_reservacion, PDO::PARAM_INT);
    $stmt->bindParam(":fecha_pago", $fecha_pago);
    $stmt->bindParam(":monto", $monto);
    $stmt->bindParam(":metodo_pago", $metodo_pago);
    $stmt->bindParam(":observaciones", $observaciones);

    if ($stmt->execute()) {

        $_SESSION["mensaje"] = "Pago registrado correctamente.";

    } else {

        $_SESSION["mensaje"] = "Ocurrió un error al registrar el pago.";

    }

    header("Location: index.php");
    exit;

}