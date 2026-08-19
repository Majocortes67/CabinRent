<?php

session_start();

if (!isset($_SESSION["id_usuario"])) {
    header("Location: ../index.php");
    exit;
}

require_once("../config/conexion.php");

$titulo = "Pagos | CabinRent";

$sql = "SELECT
            p.*,
            CONCAT(
                c.nombre,' ',
                c.apellido1,' ',
                c.apellido2
            ) AS cliente,
            r.total
        FROM pagos p
        INNER JOIN reservaciones r
            ON p.id_reservacion = r.id_reservacion
        INNER JOIN clientes c
            ON r.id_cliente = c.id_cliente
        ORDER BY p.id_pago DESC";

$stmt = $conexion->prepare($sql);
$stmt->execute();

$pagos = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sqlReservaciones = "SELECT
                        r.id_reservacion,
                        CONCAT(
                            c.nombre,' ',
                            c.apellido1,' ',
                            c.apellido2,
                            ' - ₡',
                            FORMAT(r.total,2)
                        ) AS reservacion,
                        r.total
                    FROM reservaciones r
                    INNER JOIN clientes c
                        ON r.id_cliente = c.id_cliente
                    ORDER BY r.id_reservacion DESC";

$stmtReservaciones = $conexion->prepare($sqlReservaciones);
$stmtReservaciones->execute();

$reservaciones = $stmtReservaciones->fetchAll(PDO::FETCH_ASSOC);

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
                        Gestión de Pagos
                    </h2>

                    <p class="text-muted mb-0">
                        Administre los pagos registrados.
                    </p>

                </div>

                <button
                    id="btnNuevo"
                    class="btn btn-success"
                    data-bs-toggle="modal"
                    data-bs-target="#modalPago">

                    <i class="bi bi-plus-circle"></i>

                    Nuevo Pago

                </button>

            </div>

            <div class="card shadow-sm">

                <div class="card-body">

                    <table class="table table-hover align-middle">

                        <thead>

                            <tr>

                                <th>Cliente</th>
                                <th>Fecha Pago</th>
                                <th>Monto</th>
                                <th>Método</th>
                                <th width="180">Acciones</th>

                            </tr>

                        </thead>

                        <tbody>

<?php foreach ($pagos as $pago) { ?>

<tr>

    <td>

        <?= htmlspecialchars($pago["cliente"]); ?>

    </td>

    <td>

        <?= date("d/m/Y", strtotime($pago["fecha_pago"])); ?>

    </td>

    <td>

        ₡ <?= number_format($pago["monto"], 2); ?>

    </td>

    <td>

        <?= htmlspecialchars($pago["metodo_pago"]); ?>

    </td>

    <td>

        <button
            type="button"
            class="btn btn-sm btn-primary btn-editar"

            data-id="<?= $pago["id_pago"]; ?>"
            data-reservacion="<?= $pago["id_reservacion"]; ?>"
            data-fecha="<?= $pago["fecha_pago"]; ?>"
            data-monto="<?= $pago["monto"]; ?>"
            data-metodo="<?= $pago["metodo_pago"]; ?>"
            data-observaciones="<?= htmlspecialchars($pago["observaciones"]); ?>">

            <i class="bi bi-pencil"></i>

        </button>

        <a
            href="eliminar.php?id=<?= $pago["id_pago"]; ?>"
            class="btn btn-sm btn-danger"
            onclick="return confirm('¿Desea eliminar este pago?');">

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

<div class="modal fade" id="modalPago" tabindex="-1" aria-hidden="true">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <form
                id="formPago"
                action="guardar.php"
                method="POST">

                <input
                    type="hidden"
                    id="id_pago"
                    name="id_pago">

                <div class="modal-header">

                    <h5 class="modal-title">
                        Nuevo Pago
                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body">

                    <div class="row">

                        <div class="col-md-12 mb-3">

                            <label class="form-label">
                                Reservación
                            </label>

                            <select
                                id="id_reservacion"
                                name="id_reservacion"
                                class="form-select"
                                required>

                                <option value="">
                                    Seleccione...
                                </option>

<?php foreach ($reservaciones as $reservacion) { ?>

                                <option
                                    value="<?= $reservacion["id_reservacion"]; ?>"
                                    data-total="<?= $reservacion["total"]; ?>">

                                    <?= htmlspecialchars($reservacion["reservacion"]); ?>

                                </option>

<?php } ?>

                            </select>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Fecha de Pago
                            </label>

                            <input
                                type="date"
                                id="fecha_pago"
                                name="fecha_pago"
                                class="form-control"
                                required>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Monto
                            </label>

                            <input
                                type="number"
                                id="monto"
                                name="monto"
                                class="form-control"
                                step="0.01"
                                readonly>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Método de Pago
                            </label>

                            <select
                                id="metodo_pago"
                                name="metodo_pago"
                                class="form-select"
                                required>

                                <option value="">
                                    Seleccione...
                                </option>

                                <option value="Efectivo">
                                    Efectivo
                                </option>

                                <option value="Tarjeta">
                                    Tarjeta
                                </option>

                                <option value="Transferencia">
                                    Transferencia
                                </option>

                                <option value="SINPE">
                                    SINPE
                                </option>

                            </select>

                        </div>

                        <div class="col-md-12 mb-3">

                            <label class="form-label">
                                Observaciones
                            </label>

                            <textarea
                                id="observaciones"
                                name="observaciones"
                                class="form-control"
                                rows="3"
                                placeholder="Ingrese una observación (opcional)"></textarea>

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

function cargarMonto() {

    const reservacion = document.getElementById("id_reservacion");

    if (reservacion.selectedIndex <= 0) {

        document.getElementById("monto").value = "";

        return;

    }

    const monto = reservacion.options[
        reservacion.selectedIndex
    ].dataset.total;

    document.getElementById("monto").value = parseFloat(monto).toFixed(2);

}

document.getElementById("id_reservacion").addEventListener(
    "change",
    cargarMonto
);

document.getElementById("btnNuevo").addEventListener("click", function(){

    document.querySelector(".modal-title").innerHTML = "Nuevo Pago";

    document.getElementById("formPago").action = "guardar.php";

    document.getElementById("id_pago").value = "";
    document.getElementById("id_reservacion").value = "";
    document.getElementById("fecha_pago").value = "";
    document.getElementById("monto").value = "";
    document.getElementById("metodo_pago").value = "";
    document.getElementById("observaciones").value = "";

});

document.querySelectorAll(".btn-editar").forEach(function(boton){

    boton.addEventListener("click", function(){

        document.querySelector(".modal-title").innerHTML = "Editar Pago";

        document.getElementById("formPago").action = "editar.php";

        document.getElementById("id_pago").value = this.dataset.id;
        document.getElementById("id_reservacion").value = this.dataset.reservacion;
        document.getElementById("fecha_pago").value = this.dataset.fecha;
        document.getElementById("monto").value = this.dataset.monto;
        document.getElementById("metodo_pago").value = this.dataset.metodo;
        document.getElementById("observaciones").value = this.dataset.observaciones;

        let modal = new bootstrap.Modal(
            document.getElementById("modalPago")
        );

        modal.show();

    });

});

</script>

<?php include("../includes/footer.php"); ?>