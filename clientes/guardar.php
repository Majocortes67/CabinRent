<?php

session_start();

require_once("../config/conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $identificacion = trim($_POST["identificacion"]);
    $nombre = trim($_POST["nombre"]);
    $apellido1 = trim($_POST["apellido1"]);
    $apellido2 = trim($_POST["apellido2"]);
    $telefono = trim($_POST["telefono"]);
    $correo = trim($_POST["correo"]);
    $estado = $_POST["estado"];

    // Validar identificación

    $sql = "SELECT COUNT(*)
            FROM clientes
            WHERE identificacion = :identificacion";

    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(":identificacion", $identificacion);
    $stmt->execute();

    if ($stmt->fetchColumn() > 0) {

        $_SESSION["mensaje"] = "Ya existe un cliente con esa identificación.";

        header("Location: index.php");
        exit;

    }

    // Validar correo

    $sql = "SELECT COUNT(*)
            FROM clientes
            WHERE correo = :correo";

    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(":correo", $correo);
    $stmt->execute();

    if ($stmt->fetchColumn() > 0) {

        $_SESSION["mensaje"] = "Ya existe un cliente con ese correo.";

        header("Location: index.php");
        exit;

    }

    // Registrar cliente

    $sql = "INSERT INTO clientes
            (
                identificacion,
                nombre,
                apellido1,
                apellido2,
                telefono,
                correo,
                estado,
                fecha_registro
            )
            VALUES
            (
                :identificacion,
                :nombre,
                :apellido1,
                :apellido2,
                :telefono,
                :correo,
                :estado,
                NOW()
            )";

    $stmt = $conexion->prepare($sql);

    $stmt->bindParam(":identificacion", $identificacion);
    $stmt->bindParam(":nombre", $nombre);
    $stmt->bindParam(":apellido1", $apellido1);
    $stmt->bindParam(":apellido2", $apellido2);
    $stmt->bindParam(":telefono", $telefono);
    $stmt->bindParam(":correo", $correo);
    $stmt->bindParam(":estado", $estado);

    if ($stmt->execute()) {

        $_SESSION["mensaje"] = "Cliente registrado correctamente.";

    } else {

        $_SESSION["mensaje"] = "Ocurrió un error al registrar el cliente.";

    }

    header("Location: index.php");
    exit;

}