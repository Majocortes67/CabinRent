<?php

session_start();

require_once("../config/conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id_rol = $_POST["id_rol"];
    $nombre = trim($_POST["nombre"]);
    $apellido1 = trim($_POST["apellido1"]);
    $apellido2 = trim($_POST["apellido2"]);
    $correo = trim($_POST["correo"]);
    $password = trim($_POST["password"]);
    $telefono = trim($_POST["telefono"]);
    $estado = $_POST["estado"];

    // Validar que el correo no exista

    $sql = "SELECT COUNT(*) 
            FROM usuarios 
            WHERE correo = :correo";

    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(":correo", $correo);
    $stmt->execute();

    if ($stmt->fetchColumn() > 0) {

        $_SESSION["mensaje"] = "Ya existe un usuario con ese correo.";

        header("Location: index.php");
        exit;

    }

    // Guardar usuario

    $sql = "INSERT INTO usuarios
            (
                id_rol,
                nombre,
                apellido1,
                apellido2,
                correo,
                password,
                telefono,
                estado
            )
            VALUES
            (
                :id_rol,
                :nombre,
                :apellido1,
                :apellido2,
                :correo,
                :password,
                :telefono,
                :estado
            )";

    $stmt = $conexion->prepare($sql);

    $stmt->bindParam(":id_rol", $id_rol);
    $stmt->bindParam(":nombre", $nombre);
    $stmt->bindParam(":apellido1", $apellido1);
    $stmt->bindParam(":apellido2", $apellido2);
    $stmt->bindParam(":correo", $correo);
    $stmt->bindParam(":password", $password);
    $stmt->bindParam(":telefono", $telefono);
    $stmt->bindParam(":estado", $estado);

    if ($stmt->execute()) {

        $_SESSION["mensaje"] = "Usuario registrado correctamente.";

    } else {

        $_SESSION["mensaje"] = "Ocurrió un error al registrar el usuario.";

    }

    header("Location: index.php");
    exit;

}