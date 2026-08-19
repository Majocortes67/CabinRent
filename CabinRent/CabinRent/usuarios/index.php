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

$sqlRoles = "SELECT
                id_rol,
                nombre
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
                    type="button"
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
                                    <th>Acciones</th>

                                </tr>

                            </thead>

                            <tbody>

                                <?php foreach ($usuarios as $usuario) { ?>

                                    <tr>

                                        <td>
                                            <?= (int) $usuario["id_usuario"]; ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars(
                                                trim(
                                                    $usuario["nombre"] . " " .
                                                    $usuario["apellido1"] . " " .
                                                    ($usuario["apellido2"] ?? "")
                                                ),
                                                ENT_QUOTES,
                                                "UTF-8"
                                            ); ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars(
                                                $usuario["correo"],
                                                ENT_QUOTES,
                                                "UTF-8"
                                            ); ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars(
                                                $usuario["telefono"] ?? "",
                                                ENT_QUOTES,
                                                "UTF-8"
                                            ); ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars(
                                                $usuario["rol"],
                                                ENT_QUOTES,
                                                "UTF-8"
                                            ); ?>
                                        </td>

                                        <td>

                                            <?php if ((int) $usuario["estado"] === 1) { ?>

                                                <span class="badge bg-success">
                                                    Activo
                                                </span>

                                            <?php } else { ?>

                                                <span class="badge bg-danger">
                                                    Inactivo
                                                </span>

                                            <?php } ?>

                                        </td>

                                        <td class="text-nowrap">

                                            <button
                                                type="button"
                                                class="btn btn-sm btn-primary btn-editar"
                                                title="Editar usuario"

                                                data-id="<?= (int) $usuario["id_usuario"]; ?>"

                                                data-rol="<?= (int) $usuario["id_rol"]; ?>"

                                                data-nombre="<?= htmlspecialchars(
                                                    $usuario["nombre"],
                                                    ENT_QUOTES,
                                                    "UTF-8"
                                                ); ?>"

                                                data-apellido1="<?= htmlspecialchars(
                                                    $usuario["apellido1"],
                                                    ENT_QUOTES,
                                                    "UTF-8"
                                                ); ?>"

                                                data-apellido2="<?= htmlspecialchars(
                                                    $usuario["apellido2"] ?? "",
                                                    ENT_QUOTES,
                                                    "UTF-8"
                                                ); ?>"

                                                data-correo="<?= htmlspecialchars(
                                                    $usuario["correo"],
                                                    ENT_QUOTES,
                                                    "UTF-8"
                                                ); ?>"

                                                data-password="<?= htmlspecialchars(
                                                    $usuario["password"],
                                                    ENT_QUOTES,
                                                    "UTF-8"
                                                ); ?>"

                                                data-telefono="<?= htmlspecialchars(
                                                    $usuario["telefono"] ?? "",
                                                    ENT_QUOTES,
                                                    "UTF-8"
                                                ); ?>"

                                                data-estado="<?= (int) $usuario["estado"]; ?>">

                                                <i class="bi bi-pencil"></i>

                                            </button>

                                            <a
                                                href="eliminar.php?id=<?= (int) $usuario["id_usuario"]; ?>"
                                                class="btn btn-sm btn-danger"
                                                title="Eliminar usuario"
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

</div>
<div
    class="modal fade"
    id="modalUsuario"
    tabindex="-1"
    aria-labelledby="tituloModalUsuario"
    aria-hidden="true">

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

                    <h5
                        class="modal-title"
                        id="tituloModalUsuario">

                        Nuevo Usuario

                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Cerrar">
                    </button>

                </div>

                <div class="modal-body">

                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <label
                                for="id_rol"
                                class="form-label">

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

                                    <option value="<?= (int) $rol["id_rol"]; ?>">

                                        <?= htmlspecialchars(
                                            $rol["nombre"],
                                            ENT_QUOTES,
                                            "UTF-8"
                                        ); ?>

                                    </option>

                                <?php } ?>

                            </select>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label
                                for="nombre"
                                class="form-label">

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

                            <label
                                for="apellido1"
                                class="form-label">

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

                            <label
                                for="apellido2"
                                class="form-label">

                                Segundo Apellido

                            </label>

                            <input
                                type="text"
                                id="apellido2"
                                name="apellido2"
                                class="form-control">

                        </div>

                        <div class="col-md-6 mb-3">

                            <label
                                for="correo"
                                class="form-label">

                                Correo electrónico

                            </label>

                            <input
                                type="email"
                                id="correo"
                                name="correo"
                                class="form-control"
                                required>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label
                                for="password"
                                class="form-label">

                                Contraseña

                            </label>

                            <input
                                type="password"
                                id="password"
                                name="password"
                                class="form-control"
                                required>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label
                                for="telefono"
                                class="form-label">

                                Teléfono

                            </label>

                            <input
                                type="text"
                                id="telefono"
                                name="telefono"
                                class="form-control">

                        </div>

                        <div class="col-md-6 mb-3">

                            <label
                                for="estado"
                                class="form-label">

                                Estado

                            </label>

                            <select
                                id="estado"
                                name="estado"
                                class="form-select"
                                required>

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

document.addEventListener("DOMContentLoaded", function () {

    const formulario = document.getElementById("formUsuario");
    const tituloModal = document.getElementById("tituloModalUsuario");
    const botonNuevo = document.getElementById("btnNuevo");
    const modalElemento = document.getElementById("modalUsuario");

    botonNuevo.addEventListener("click", function () {

        tituloModal.textContent = "Nuevo Usuario";

        formulario.action = "guardar.php";
        formulario.reset();

        document.getElementById("id_usuario").value = "";
        document.getElementById("estado").value = "1";
        document.getElementById("password").required = true;

    });

    document.addEventListener("click", function (evento) {

        const botonEditar = evento.target.closest(".btn-editar");

        if (!botonEditar) {
            return;
        }

        tituloModal.textContent = "Editar Usuario";

        formulario.action = "editar.php";

        document.getElementById("id_usuario").value =
            botonEditar.dataset.id;

        document.getElementById("id_rol").value =
            botonEditar.dataset.rol;

        document.getElementById("nombre").value =
            botonEditar.dataset.nombre;

        document.getElementById("apellido1").value =
            botonEditar.dataset.apellido1;

        document.getElementById("apellido2").value =
            botonEditar.dataset.apellido2;

        document.getElementById("correo").value =
            botonEditar.dataset.correo;

        document.getElementById("password").value =
            botonEditar.dataset.password;

        document.getElementById("telefono").value =
            botonEditar.dataset.telefono;

        document.getElementById("estado").value =
            botonEditar.dataset.estado;

        const modalUsuario =
            bootstrap.Modal.getOrCreateInstance(modalElemento);

        modalUsuario.show();

    });

});

</script>

<?php include("../includes/footer.php"); ?>