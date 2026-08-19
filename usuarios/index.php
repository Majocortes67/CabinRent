<?php

session_start();

if (!isset($_SESSION["id_usuario"])) {
    header("Location: ../index.php");
    exit;
}

require_once("../config/conexion.php");

$titulo = "Usuarios | CabinRent";

$sql = "SELECT
            u.id_usuario,
            u.id_rol,
            u.nombre,
            u.apellido1,
            u.apellido2,
            u.correo,
            u.password,
            u.telefono,
            u.estado,
            r.nombre AS rol
        FROM usuarios u
        INNER JOIN roles r
            ON u.id_rol = r.id_rol
        ORDER BY u.id_usuario ASC";

$stmt = $conexion->prepare($sql);
$stmt->execute();

$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sqlRoles = "SELECT *
             FROM roles
             WHERE estado = 1
             ORDER BY nombre ASC";

$stmtRoles = $conexion->prepare($sqlRoles);
$stmtRoles->execute();

$roles = $stmtRoles->fetchAll(PDO::FETCH_ASSOC);

include("../includes/header.php");
?>


<div class="app">

    <?php include("../includes/sidebar.php"); ?>

    <div class="main-content">

        <?php include("../includes/navbar.php"); ?>

        <div class="container-fluid p-4">

            <div class="d-flex justify-content-between align-items-center mb-4">

                <div>

                    <h2 class="fw-bold mb-1">
                        Gestión de Usuarios
                    </h2>

                    <p class="text-muted mb-0">
                        Administre los usuarios del sistema.
                    </p>

                </div>

                <button
                    id="btnNuevo"
                    class="btn btn-success"
                    data-bs-toggle="modal"
                    data-bs-target="#modalUsuario">

                    <i class="bi bi-plus-circle"></i>

                    Nuevo Usuario

                </button>

            </div>

            <div class="card shadow-sm">

                <div class="card-body">

                    <div class="table-responsive">

<table
    id="tablaUsuarios"
    class="table table-hover table-striped align-middle w-100">

                        <thead>

                            <tr>

                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Correo</th>
                                <th>Teléfono</th>
                                <th>Rol</th>
                                <th>Estado</th>
                                <th width="180">Acciones</th>

                            </tr>

                        </thead>

                        <tbody>

<?php foreach ($usuarios as $usuario) { ?>

<tr>

    <td><?= $usuario["id_usuario"]; ?></td>

    <td>

        <?= htmlspecialchars(
            $usuario["nombre"] . " " .
            $usuario["apellido1"] . " " .
            $usuario["apellido2"]
        ); ?>

    </td>

    <td><?= htmlspecialchars($usuario["correo"]); ?></td>

    <td><?= htmlspecialchars($usuario["telefono"]); ?></td>

    <td><?= htmlspecialchars($usuario["rol"]); ?></td>

    <td>

        <?php if ($usuario["estado"] == 1) { ?>

            <span class="badge bg-success">
                Activo
            </span>

        <?php } else { ?>

            <span class="badge bg-danger">
                Inactivo
            </span>

        <?php } ?>

    </td>

    <td>

        <button
            type="button"
            class="btn btn-sm btn-primary btn-editar"

            data-id="<?= $usuario["id_usuario"]; ?>"
            data-rol="<?= $usuario["id_rol"]; ?>"
            data-nombre="<?= htmlspecialchars($usuario["nombre"]); ?>"
            data-apellido1="<?= htmlspecialchars($usuario["apellido1"]); ?>"
            data-apellido2="<?= htmlspecialchars($usuario["apellido2"]); ?>"
            data-correo="<?= htmlspecialchars($usuario["correo"]); ?>"
            data-password="<?= htmlspecialchars($usuario["password"]); ?>"
            data-telefono="<?= htmlspecialchars($usuario["telefono"]); ?>"
            data-estado="<?= $usuario["estado"]; ?>">

            <i class="bi bi-pencil"></i>

        </button>

        <a
            href="eliminar.php?id=<?= $usuario["id_usuario"]; ?>"
            class="btn btn-sm btn-danger"
            onclick="return confirm('¿Desea eliminar este usuario?');">

            <i class="bi bi-trash"></i>

        </a>

    </td>

</tr>

<?php } ?>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>
<div class="modal fade" id="modalUsuario" tabindex="-1" aria-hidden="true">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <form
                id="formUsuario"
                action="guardar.php"
                method="POST">

                <input
                    type="hidden"
                    name="id_usuario"
                    id="id_usuario">

                <div class="modal-header">

                    <h5 class="modal-title">
                        Nuevo Usuario
                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body">

                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Rol
                            </label>

                            <select
                                id="id_rol"
                                name="id_rol"
                                class="form-select"
                                required>

                                <option value="">
                                    Seleccione...
                                </option>

                                <?php foreach ($roles as $rol) { ?>

                                    <option value="<?= $rol["id_rol"]; ?>">

                                        <?= htmlspecialchars($rol["nombre"]); ?>

                                    </option>

                                <?php } ?>

                            </select>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Nombre
                            </label>

                            <input
                                type="text"
                                id="nombre"
                                name="nombre"
                                class="form-control"
                                required>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Primer Apellido
                            </label>

                            <input
                                type="text"
                                id="apellido1"
                                name="apellido1"
                                class="form-control"
                                required>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Segundo Apellido
                            </label>

                            <input
                                type="text"
                                id="apellido2"
                                name="apellido2"
                                class="form-control">

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Correo Electrónico
                            </label>

                            <input
                                type="email"
                                id="correo"
                                name="correo"
                                class="form-control"
                                required>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Contraseña
                            </label>

                            <input
                                type="text"
                                id="password"
                                name="password"
                                class="form-control"
                                required>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Teléfono
                            </label>

                            <input
                                type="text"
                                id="telefono"
                                name="telefono"
                                class="form-control">

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Estado
                            </label>

                            <select
                                id="estado"
                                name="estado"
                                class="form-select">

                                <option value="1">
                                    Activo
                                </option>

                                <option value="0">
                                    Inactivo
                                </option>

                            </select>

                        </div>

                    </div>

                </div>

                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-secondary px-4"
                        data-bs-dismiss="modal">

                        Cancelar

                    </button>

                    <button
                        type="submit"
                        class="btn btn-success px-4">

                        Guardar

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

<script>

document.querySelectorAll(".btn-editar").forEach(function(boton){

    boton.addEventListener("click", function(){

        document.querySelector(".modal-title").innerHTML = "Editar Usuario";

        document.getElementById("formUsuario").action = "editar.php";

        document.getElementById("id_usuario").value = this.dataset.id;
        document.getElementById("id_rol").value = this.dataset.rol;
        document.getElementById("nombre").value = this.dataset.nombre;
        document.getElementById("apellido1").value = this.dataset.apellido1;
        document.getElementById("apellido2").value = this.dataset.apellido2;
        document.getElementById("correo").value = this.dataset.correo;
        document.getElementById("password").value = this.dataset.password;
        document.getElementById("telefono").value = this.dataset.telefono;
        document.getElementById("estado").value = this.dataset.estado;

        let modal = new bootstrap.Modal(
            document.getElementById("modalUsuario")
        );

        modal.show();

    });

});

document.getElementById("btnNuevo").addEventListener("click", function(){

    document.querySelector(".modal-title").innerHTML = "Nuevo Usuario";

    document.getElementById("formUsuario").action = "guardar.php";

    document.getElementById("id_usuario").value = "";
    document.getElementById("id_rol").value = "";
    document.getElementById("nombre").value = "";
    document.getElementById("apellido1").value = "";
    document.getElementById("apellido2").value = "";
    document.getElementById("correo").value = "";
    document.getElementById("password").value = "";
    document.getElementById("telefono").value = "";
    document.getElementById("estado").value = "1";

});

</script>

<?php include("../includes/footer.php"); ?>

