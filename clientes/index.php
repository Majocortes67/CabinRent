<?php

session_start();

if (!isset($_SESSION["id_usuario"])) {

    header("Location: ../index.php");

    exit;

}

require_once("../config/conexion.php");

$titulo = "Clientes | CabinRent";

$sql = "SELECT

            id_cliente,
            identificacion,
            nombre,
            apellido1,
            apellido2,
            telefono,
            correo,
            estado

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

                        Administre los clientes registrados en el sistema.

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
                    <div class="table-responsive">

    <table
        id="tablaClientes"
        class="table table-hover table-striped align-middle w-100">

        <thead>

            <tr>

                <th>Identificación</th>

                <th>Nombre Completo</th>

                <th>Teléfono</th>

                <th>Correo Electrónico</th>

                <th class="text-center">
                    Estado
                </th>

                <th class="text-center" width="150">
                    Acciones
                </th>

            </tr>

        </thead>

        <tbody>

            <?php foreach($clientes as $cliente){ ?>

            <tr>

                <td>

                    <?= htmlspecialchars($cliente["identificacion"]); ?>

                </td>

                <td>

                    <?= htmlspecialchars(

                        $cliente["nombre"]." ".
                        $cliente["apellido1"]." ".
                        $cliente["apellido2"]

                    ); ?>

                </td>

                <td>

                    <?= htmlspecialchars($cliente["telefono"]); ?>

                </td>

                <td>

                    <?= htmlspecialchars($cliente["correo"]); ?>

                </td>

                <td class="text-center">

                    <?php if($cliente["estado"]==1){ ?>

                        <span class="badge bg-success">

                            Activo

                        </span>

                    <?php }else{ ?>

                        <span class="badge bg-danger">

                            Inactivo

                        </span>

                    <?php } ?>

                </td>

                <td class="text-center">

                    <button

                        type="button"

                        class="btn btn-sm btn-primary btn-editar me-1"

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

</div>
<div
    class="modal fade"
    id="modalCliente"
    tabindex="-1"
    aria-labelledby="tituloModalCliente"
    aria-hidden="true">

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

                    <h5
                        class="modal-title"
                        id="tituloModalCliente">

                        Nuevo Cliente

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
                                for="identificacion"
                                class="form-label">

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
                                for="telefono"
                                class="form-label">

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

                            <label
                                for="correo"
                                class="form-label">

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

                            <label
                                for="estado"
                                class="form-label">

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

document.addEventListener("DOMContentLoaded", function(){

    const formulario = document.getElementById("formCliente");

    const tituloModal = document.getElementById("tituloModalCliente");

    const botonNuevo = document.getElementById("btnNuevo");

    const modalElemento = document.getElementById("modalCliente");

    botonNuevo.addEventListener("click", function(){

        tituloModal.textContent = "Nuevo Cliente";

        formulario.action = "guardar.php";

        formulario.reset();

        document.getElementById("id_cliente").value = "";

        document.getElementById("estado").value = "1";

    });

    document.querySelectorAll(".btn-editar").forEach(function(boton){

        boton.addEventListener("click", function(){

            tituloModal.textContent = "Editar Cliente";

            formulario.action = "editar.php";

            document.getElementById("id_cliente").value = this.dataset.id;

            document.getElementById("identificacion").value = this.dataset.identificacion;

            document.getElementById("nombre").value = this.dataset.nombre;

            document.getElementById("apellido1").value = this.dataset.apellido1;

            document.getElementById("apellido2").value = this.dataset.apellido2;

            document.getElementById("telefono").value = this.dataset.telefono;

            document.getElementById("correo").value = this.dataset.correo;

            document.getElementById("estado").value = this.dataset.estado;

            bootstrap.Modal
                .getOrCreateInstance(modalElemento)
                .show();

        });

    });

});

</script>
<?php include("../includes/footer.php"); ?>