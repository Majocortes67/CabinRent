<?php
session_start();

if (!isset($_SESSION["id_usuario"])) {
    header("Location: ../index.php");
    exit;
}

require_once("../config/conexion.php");

$titulo = "Roles | CabinRent";

$sql = "SELECT * FROM roles ORDER BY id_rol ASC";
$stmt = $conexion->prepare($sql);
$stmt->execute();

$roles = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
                        Gestión de Roles
                    </h2>

                    <p class="text-muted mb-0">
                        Administre los roles del sistema.
                    </p>
                </div>

                <button
                    id="btnNuevo"
                    class="btn btn-success"
                    data-bs-toggle="modal"
                    data-bs-target="#modalRol">

                    <i class="bi bi-plus-circle"></i>
                    Nuevo Rol

                </button>

            </div>

            <div class="card shadow-sm">

                <div class="card-body">

                    <table class="table table-hover align-middle">

                        <thead>

                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Estado</th>
                                <th width="180">Acciones</th>
                            </tr>

                        </thead>

                        <tbody>

                            <?php foreach ($roles as $rol) { ?>

                                <tr>

                                    <td><?= $rol["id_rol"]; ?></td>

                                    <td><?= htmlspecialchars($rol["nombre"]); ?></td>

                                    <td>

                                        <?php if ($rol["estado"] == 1) { ?>

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
                                            data-id="<?= $rol["id_rol"]; ?>"
                                            data-nombre="<?= htmlspecialchars($rol["nombre"]); ?>"
                                            data-estado="<?= $rol["estado"]; ?>">

                                            <i class="bi bi-pencil"></i>

                                        </button>

                                        <a
                                            href="eliminar.php?id=<?= $rol['id_rol']; ?>"
                                            class="btn btn-sm btn-danger"
                                            onclick="return confirm('¿Desea eliminar este rol?');">

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

<div class="modal fade" id="modalRol" tabindex="-1" aria-hidden="true">

    <div class="modal-dialog">

        <div class="modal-content">

            <form
                id="formRol"
                action="guardar.php"
                method="POST">

                <input
                    type="hidden"
                    name="id_rol"
                    id="id_rol">

                <div class="modal-header">

                    <h5 class="modal-title">
                        Nuevo Rol
                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body">

                    <div class="mb-3">

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

                    <div class="mb-3">

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

document.querySelectorAll(".btn-editar").forEach(function (boton) {

    boton.addEventListener("click", function () {

        document.querySelector(".modal-title").textContent = "Editar Rol";

        document.getElementById("formRol").action = "editar.php";

        document.getElementById("id_rol").value = this.dataset.id;
        document.getElementById("nombre").value = this.dataset.nombre;
        document.getElementById("estado").value = this.dataset.estado;

        const modal = new bootstrap.Modal(
            document.getElementById("modalRol")
        );

        modal.show();

    });

});

document.getElementById("btnNuevo").addEventListener("click", function () {

    document.querySelector(".modal-title").textContent = "Nuevo Rol";

    document.getElementById("formRol").action = "guardar.php";

    document.getElementById("id_rol").value = "";
    document.getElementById("nombre").value = "";
    document.getElementById("estado").value = "1";

});

</script>

<?php include("../includes/footer.php"); ?>