<?php

session_start();

header("Content-Type: application/json; charset=utf-8");

if (!isset($_SESSION["id_usuario"])) {

    http_response_code(401);

    echo json_encode(
        [
            "ok" => false,
            "mensaje" => "La sesión ha expirado. Inicie sesión nuevamente."
        ],
        JSON_UNESCAPED_UNICODE
    );

    exit;
}

require_once("../config/conexion.php");

try {

    $fechaIngreso = trim($_GET["fecha_ingreso"] ?? "");
    $fechaSalida = trim($_GET["fecha_salida"] ?? "");

    if ($fechaIngreso === "" || $fechaSalida === "") {

        throw new Exception(
            "Debe seleccionar la fecha de ingreso y la fecha de salida."
        );
    }

    $fechaIngresoObj = DateTime::createFromFormat(
        "Y-m-d",
        $fechaIngreso
    );

    $fechaSalidaObj = DateTime::createFromFormat(
        "Y-m-d",
        $fechaSalida
    );

    $fechaIngresoValida =
        $fechaIngresoObj &&
        $fechaIngresoObj->format("Y-m-d") === $fechaIngreso;

    $fechaSalidaValida =
        $fechaSalidaObj &&
        $fechaSalidaObj->format("Y-m-d") === $fechaSalida;

    if (!$fechaIngresoValida || !$fechaSalidaValida) {

        throw new Exception(
            "El formato de las fechas no es válido."
        );
    }

    if ($fechaSalida <= $fechaIngreso) {

        throw new Exception(
            "La fecha de salida debe ser posterior a la fecha de ingreso."
        );
    }

    $sql = "SELECT
                c.id_cabina,
                c.nombre,
                c.capacidad,
                c.precio_noche,
                c.imagen,
                c.estado,

                CASE
                    WHEN c.estado = 'Mantenimiento' THEN 0

                    WHEN EXISTS (
                        SELECT 1
                        FROM reservaciones r
                        WHERE r.id_cabina = c.id_cabina
                          AND r.estado IN ('Pendiente', 'Confirmada')
                          AND r.fecha_ingreso < :fecha_salida
                          AND r.fecha_salida > :fecha_ingreso
                    ) THEN 0

                    ELSE 1
                END AS disponible

            FROM cabinas c

            ORDER BY c.nombre ASC";

    $stmt = $conexion->prepare($sql);

    $stmt->bindValue(
        ":fecha_ingreso",
        $fechaIngreso,
        PDO::PARAM_STR
    );

    $stmt->bindValue(
        ":fecha_salida",
        $fechaSalida,
        PDO::PARAM_STR
    );

    $stmt->execute();

    $filas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $cabinas = [];

    foreach ($filas as $fila) {

        $nombre = $fila["nombre"] ?? "";
        $imagen = $fila["imagen"] ?? "";

        $cabinas[] = [

            "id_cabina" => (int) $fila["id_cabina"],

            "nombre" => $nombre,

            "nombre_seguro" => htmlspecialchars(
                $nombre,
                ENT_QUOTES,
                "UTF-8"
            ),

            "capacidad" => (int) $fila["capacidad"],

            "precio_noche" => (float) $fila["precio_noche"],

            "precio_formateado" => number_format(
                (float) $fila["precio_noche"],
                2,
                ",",
                "."
            ),

            "imagen" => $imagen,

            "imagen_segura" => htmlspecialchars(
                $imagen,
                ENT_QUOTES,
                "UTF-8"
            ),

            "estado" => $fila["estado"] ?? "",

            "disponible" => (bool) $fila["disponible"]

        ];
    }

    echo json_encode(
        [
            "ok" => true,
            "cabinas" => $cabinas
        ],
        JSON_UNESCAPED_UNICODE |
        JSON_UNESCAPED_SLASHES
    );

} catch (PDOException $error) {

    http_response_code(500);

    echo json_encode(
        [
            "ok" => false,
            "mensaje" => "Ocurrió un error al consultar la base de datos."
        ],
        JSON_UNESCAPED_UNICODE
    );

} catch (Exception $error) {

    http_response_code(400);

    echo json_encode(
        [
            "ok" => false,
            "mensaje" => $error->getMessage()
        ],
        JSON_UNESCAPED_UNICODE
    );
}