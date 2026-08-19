<?php

session_start();

if (!isset($_SESSION["id_usuario"])) {
    header("Location: ../index.php");
    exit;
}

require_once("../config/conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id_rol = $_POST["id_rol"] ?? "";
    $nombre = $_POST["nombre"] ?? "";
    $estado = $_POST["estado"] ?? 1;


    if (empty($nombre)) {

        $_SESSION["error"] = "Debe ingresar el nombre del rol.";

        header("Location: index.php");
        exit;

    }


    if (!empty($id_rol)) {

        $sql = "UPDATE roles 
                SET nombre = ?, estado = ?
                WHERE id_rol = ?";

        $stmt = $conexion->prepare($sql);

        $resultado = $stmt->execute([
            $nombre,
            $estado,
            $id_rol
        ]);


        if ($resultado) {

            $_SESSION["success"] = "Rol actualizado correctamente.";

        } else {

            $_SESSION["error"] = "Error al actualizar el rol.";

        }


    } else {


        $sql = "INSERT INTO roles(nombre, estado)
                VALUES(?, ?)";


        $stmt = $conexion->prepare($sql);


        $resultado = $stmt->execute([
            $nombre,
            $estado
        ]);


        if ($resultado) {

            $_SESSION["success"] = "Rol registrado correctamente.";

        } else {

            $_SESSION["error"] = "Error al registrar el rol.";

        }

    }


    header("Location: index.php");
    exit;

}



if (isset($_GET["eliminar"])) {


    $id_rol = $_GET["eliminar"];


    $sql = "DELETE FROM roles 
            WHERE id_rol = ?";


    $stmt = $conexion->prepare($sql);


    $resultado = $stmt->execute([
        $id_rol
    ]);


    if ($resultado) {

        $_SESSION["success"] = "Rol eliminado correctamente.";

    } else {

        $_SESSION["error"] = "No se pudo eliminar el rol.";

    }


    header("Location: index.php");
    exit;

}


header("Location: index.php");
exit;