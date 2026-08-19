<?php

session_start();

require_once("../config/conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id_cliente = $_POST["id_cliente"];
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
            WHERE identificacion = :identificacion
            AND id_cliente <> :id_cliente";

    $stmt = $conexion->prepare($sql);

    $stmt->bindParam(":identificacion", $identificacion);
    $stmt->bindParam(":id_cliente", $id_cliente, PDO::PARAM_INT);

    $stmt->execute();

    if ($stmt->fetchColumn() > 0) {

        $_SESSION["mensaje"] = "Ya existe otro cliente con esa identificación.";

        header("Location: index.php");
        exit;

    }

    // Validar correo

    $sql = "SELECT COUNT(*)
            FROM clientes
            WHERE correo = :correo
            AND id_cliente <> :id_cliente";

    $stmt = $conexion->prepare($sql);

    $stmt->bindParam(":correo", $correo);
    $stmt->bindParam(":id_cliente", $id_cliente, PDO::PARAM_INT);

    $stmt->execute();

    if ($stmt->fetchColumn() > 0) {

        $_SESSION["mensaje"] = "Ya existe otro cliente con ese correo.";

        header("Location: index.php");
        exit;

    }

    // Actualizar cliente

    $sql = "UPDATE clientes
            SET
                identificacion = :identificacion,
                nombre = :nombre,
                apellido1 = :apellido1,
                apellido2 = :apellido2,
                telefono = :telefono,
                correo = :correo,
                estado = :estado
            WHERE id_cliente = :id_cliente";

    $stmt = $conexion->prepare($sql);

    $stmt->bindParam(":identificacion", $identificacion);
    $stmt->bindParam(":nombre", $nombre);
    $stmt->bindParam(":apellido1", $apellido1);
    $stmt->bindParam(":apellido2", $apellido2);
    $stmt->bindParam(":telefono", $telefono);
    $stmt->bindParam(":correo", $correo);
    $stmt->bindParam(":estado", $estado);
    $stmt->bindParam(":id_cliente", $id_cliente, PDO::PARAM_INT);

    if ($stmt->execute()) {

        $_SESSION["mensaje"] = "Cliente actualizado correctamente.";

    } else {

        $_SESSION["mensaje"] = "Ocurrió un error al actualizar el cliente.";

    }

    header("Location: index.php");
    exit;

}