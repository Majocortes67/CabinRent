<?php

session_start();

require_once("../config/conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id_usuario = $_POST["id_usuario"];
    $id_rol = $_POST["id_rol"];
    $nombre = trim($_POST["nombre"]);
    $apellido1 = trim($_POST["apellido1"]);
    $apellido2 = trim($_POST["apellido2"]);
    $correo = trim($_POST["correo"]);
    $password = trim($_POST["password"]);
    $telefono = trim($_POST["telefono"]);
    $estado = $_POST["estado"];

    // Verificar que el correo no pertenezca a otro usuario

    $sql = "SELECT COUNT(*)
            FROM usuarios
            WHERE correo = :correo
            AND id_usuario <> :id_usuario";

    $stmt = $conexion->prepare($sql);

    $stmt->bindParam(":correo", $correo);
    $stmt->bindParam(":id_usuario", $id_usuario);

    $stmt->execute();

    if ($stmt->fetchColumn() > 0) {

        $_SESSION["mensaje"] = "Ya existe otro usuario con ese correo.";

        header("Location: index.php");
        exit;

    }

    $sql = "UPDATE usuarios
            SET
                id_rol = :id_rol,
                nombre = :nombre,
                apellido1 = :apellido1,
                apellido2 = :apellido2,
                correo = :correo,
                password = :password,
                telefono = :telefono,
                estado = :estado
            WHERE id_usuario = :id_usuario";

    $stmt = $conexion->prepare($sql);

    $stmt->bindParam(":id_rol", $id_rol);
    $stmt->bindParam(":nombre", $nombre);
    $stmt->bindParam(":apellido1", $apellido1);
    $stmt->bindParam(":apellido2", $apellido2);
    $stmt->bindParam(":correo", $correo);
    $stmt->bindParam(":password", $password);
    $stmt->bindParam(":telefono", $telefono);
    $stmt->bindParam(":estado", $estado);
    $stmt->bindParam(":id_usuario", $id_usuario);

    if ($stmt->execute()) {

        $_SESSION["mensaje"] = "Usuario actualizado correctamente.";

    } else {

        $_SESSION["mensaje"] = "Ocurrió un error al actualizar el usuario.";

    }

    header("Location: index.php");
    exit;

}