<?php

session_start();

if (!isset($_SESSION["id_usuario"])) {
    header("Location: ../index.php");
    exit;
}

require_once("../config/conexion.php");

$titulo = "Clientes | CabinRent";

$sql = "SELECT *
        FROM clientes
        ORDER BY id_cliente ASC";

$stmt = $conexion->prepare($sql);
$stmt->execute();

$clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
                        Gestión de Clientes
                    </h2>

                    <p class="text-muted mb-0">
                        Administre los clientes del sistema.
                    </p>

                </div>

                <button
                    id="btnNuevo"
                    class="btn btn-success"
                    data-bs-toggle="modal"
                    data-bs-target="#modalCliente">

                    <i class="bi bi-plus-circle"></i>

                    Nuevo Cliente

                </button>

            </div>

            <div class="card shadow-sm">

                <div class="card-body">

                    <table class="table table-hover align-middle">

                        <thead>

                            <tr>

                                <th>Identificación</th>
                                <th>Nombre Completo</th>
                                <th>Teléfono</th>
                                <th>Correo</th>
                                <th>Estado</th>
                                <th width="180">Acciones</th>

                            </tr>

                        </thead>

                        <tbody>

<?php foreach ($clientes as $cliente) { ?>

<tr>

    <td>

        <?= htmlspecialchars($cliente["identificacion"]); ?>

    </td>

    <td>

        <?= htmlspecialchars(
            $cliente["nombre"] . " " .
            $cliente["apellido1"] . " " .
            $cliente["apellido2"]
        ); ?>

    </td>

    <td>

        <?= htmlspecialchars($cliente["telefono"]); ?>

    </td>

    <td>

        <?= htmlspecialchars($cliente["correo"]); ?>

    </td>

    <td>

        <?php if ($cliente["estado"] == 1) { ?>

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

            data-id="<?= $cliente["id_cliente"]; ?>"
            data-identificacion="<?= htmlspecialchars($cliente["identificacion"]); ?>"
            data-nombre="<?= htmlspecialchars($cliente["nombre"]); ?>"
            data-apellido1="<?= htmlspecialchars($cliente["apellido1"]); ?>"
            data-apellido2="<?= htmlspecialchars($cliente["apellido2"]); ?>"
            data-telefono="<?= htmlspecialchars($cliente["telefono"]); ?>"
            data-correo="<?= htmlspecialchars($cliente["correo"]); ?>"
            data-estado="<?= $cliente["estado"]; ?>">

            <i class="bi bi-pencil"></i>

        </button>

        <a
            href="eliminar.php?id=<?= $cliente["id_cliente"]; ?>"
            class="btn btn-sm btn-danger"
            onclick="return confirm('¿Desea eliminar este cliente?');">

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

<div class="modal fade" id="modalCliente" tabindex="-1" aria-hidden="true">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <form
                id="formCliente"
                action="guardar.php"
                method="POST">

                <input
                    type="hidden"
                    id="id_cliente"
                    name="id_cliente">

                <div class="modal-header">

                    <h5 class="modal-title">
                        Nuevo Cliente
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
                                Identificación
                            </label>

                            <input
                                type="text"
                                id="identificacion"
                                name="identificacion"
                                class="form-control"
                                required>

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
                                class="form-control"
                                required>

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

        document.querySelector(".modal-title").innerHTML = "Editar Cliente";

        document.getElementById("formCliente").action = "editar.php";

        document.getElementById("id_cliente").value = this.dataset.id;
        document.getElementById("identificacion").value = this.dataset.identificacion;
        document.getElementById("nombre").value = this.dataset.nombre;
        document.getElementById("apellido1").value = this.dataset.apellido1;
        document.getElementById("apellido2").value = this.dataset.apellido2;
        document.getElementById("telefono").value = this.dataset.telefono;
        document.getElementById("correo").value = this.dataset.correo;
        document.getElementById("estado").value = this.dataset.estado;

        let modal = new bootstrap.Modal(
            document.getElementById("modalCliente")
        );

        modal.show();

    });

});

document.getElementById("btnNuevo").addEventListener("click", function(){

    document.querySelector(".modal-title").innerHTML = "Nuevo Cliente";

    document.getElementById("formCliente").action = "guardar.php";

    document.getElementById("id_cliente").value = "";
    document.getElementById("identificacion").value = "";
    document.getElementById("nombre").value = "";
    document.getElementById("apellido1").value = "";
    document.getElementById("apellido2").value = "";
    document.getElementById("telefono").value = "";
    document.getElementById("correo").value = "";
    document.getElementById("estado").value = "1";

});

</script>

<?php include("../includes/footer.php"); ?>