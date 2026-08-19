<?php

session_start();

require_once("../config/conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id_cliente = $_POST["id_cliente"];
    $id_cabina = $_POST["id_cabina"];
    $fecha_ingreso = $_POST["fecha_ingreso"];
    $fecha_salida = $_POST["fecha_salida"];
    $noches = $_POST["noches"];
    $subtotal = $_POST["subtotal"];
    $impuesto = $_POST["impuesto"];
    $total = $_POST["total"];
    $estado = $_POST["estado"];

    if (strtotime($fecha_salida) <= strtotime($fecha_ingreso)) {

        $_SESSION["mensaje"] = "La fecha de salida debe ser mayor que la fecha de ingreso.";

        header("Location: index.php");
        exit;

    }

    $sql = "INSERT INTO reservaciones
            (
                id_cliente,
                id_cabina,
                fecha_ingreso,
                fecha_salida,
                noches,
                subtotal,
                impuesto,
                total,
                estado
            )
            VALUES
            (
                :id_cliente,
                :id_cabina,
                :fecha_ingreso,
                :fecha_salida,
                :noches,
                :subtotal,
                :impuesto,
                :total,
                :estado
            )";

    $stmt = $conexion->prepare($sql);

    $stmt->bindParam(":id_cliente", $id_cliente, PDO::PARAM_INT);
    $stmt->bindParam(":id_cabina", $id_cabina, PDO::PARAM_INT);
    $stmt->bindParam(":fecha_ingreso", $fecha_ingreso);
    $stmt->bindParam(":fecha_salida", $fecha_salida);
    $stmt->bindParam(":noches", $noches, PDO::PARAM_INT);
    $stmt->bindParam(":subtotal", $subtotal);
    $stmt->bindParam(":impuesto", $impuesto);
    $stmt->bindParam(":total", $total);
    $stmt->bindParam(":estado", $estado);

    if ($stmt->execute()) {

        $_SESSION["mensaje"] = "Reservación registrada correctamente.";

    } else {

        $_SESSION["mensaje"] = "Ocurrió un error al registrar la reservación.";

    }

    header("Location: index.php");
    exit;

}