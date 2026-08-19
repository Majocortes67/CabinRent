<?php
session_start();

require_once "../config/conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $correo = trim($_POST["correo"]);
    $contrasena = trim($_POST["contrasena"]);

    $sql = "SELECT * FROM usuarios WHERE correo = :correo AND estado = 1";

    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(":correo", $correo);
    $stmt->execute();

    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario) {

        // Temporalmente validamos la contraseña en texto plano.
        // Más adelante la cambiaremos a password_hash().

        if ($contrasena == $usuario["password"]) {

            $_SESSION["id_usuario"] = $usuario["id_usuario"];
            $_SESSION["nombre"] = $usuario["nombre"];
            $_SESSION["rol"] = $usuario["id_rol"];

            header("Location: ../dashboard/index.php");
            exit;

        } else {

            echo "Contraseña incorrecta.";

        }

    } else {

        echo "El usuario no existe.";

    }

} else {

    header("Location: ../index.php");
    exit;

}
?>