<?php

session_start();

if (!isset($_SESSION["id_usuario"])) {

    header("Location: ../index.php");

    exit;

}

require_once("../config/conexion.php");

$titulo = "Reservaciones | CabinRent";

$sql = "SELECT
            r.*,
            CONCAT(
                c.nombre,
                ' ',
                c.apellido1,
                ' ',
                c.apellido2
            ) AS cliente,
            cb.nombre AS cabina
        FROM reservaciones r
        INNER JOIN clientes c
            ON r.id_cliente = c.id_cliente
        INNER JOIN cabinas cb
            ON r.id_cabina = cb.id_cabina
        ORDER BY r.id_reservacion DESC";

$stmt = $conexion->prepare($sql);

$stmt->execute();

$reservaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);


$sqlClientes = "SELECT
                    id_cliente,
                    CONCAT(
                        nombre,
                        ' ',
                        apellido1,
                        ' ',
                        apellido2
                    ) AS nombre
                FROM clientes
                WHERE estado = 1
                ORDER BY nombre";

$stmtClientes = $conexion->prepare($sqlClientes);

$stmtClientes->execute();

$clientes = $stmtClientes->fetchAll(PDO::FETCH_ASSOC);


$sqlCabinas = "SELECT
                    id_cabina,
                    nombre,
                    precio_noche
               FROM cabinas
               WHERE estado = 'Disponible'
               ORDER BY nombre";

$stmtCabinas = $conexion->prepare($sqlCabinas);

$stmtCabinas->execute();

$cabinas = $stmtCabinas->fetchAll(PDO::FETCH_ASSOC);


include("../includes/header.php");

?>

<div class="app">

    <?php include("../includes/sidebar.php"); ?>

    <div class="main-content">

        <?php include("../includes/navbar.php"); ?>

        <div class="container-fluid p-4">

            <div
                class="d-flex justify-content-between align-items-center mb-4">

                <div>

                    <h2 class="fw-bold mb-1">

                        Gestión de Reservaciones

                    </h2>

                    <p class="text-muted mb-0">

                        Administre las reservaciones del sistema.

                    </p>

                </div>

                <button
                    id="btnNuevo"
                    type="button"
                    class="btn btn-success"
                    data-bs-toggle="modal"
                    data-bs-target="#modalReservacion">

                    <i class="bi bi-plus-circle"></i>

                    Nueva Reservación

                </button>

            </div>

            <div class="card shadow-sm">

                <div class="card-body">

                    <div class="table-responsive">

                        <table
                            id="tablaReservaciones"
                            class="table table-hover table-striped align-middle w-100">

                            <thead>

                                <tr>

                                    <th>Cliente</th>

                                    <th>Cabina</th>

                                    <th>Ingreso</th>

                                    <th>Salida</th>

                                    <th>Total</th>

                                    <th class="text-center">
                                        Estado
                                    </th>

                                    <th
                                        class="text-center"
                                        width="180">

                                        Acciones

                                    </th>

                                </tr>

                            </thead>

                            <tbody>

                                <?php foreach ($reservaciones as $reservacion) { ?>

                                    <tr>

                                        <td>

                                            <?= htmlspecialchars(
                                                $reservacion["cliente"]
                                            ); ?>

                                        </td>

                                        <td>

                                            <?= htmlspecialchars(
                                                $reservacion["cabina"]
                                            ); ?>

                                        </td>

                                        <td>

                                            <?= date(
                                                "d/m/Y",
                                                strtotime(
                                                    $reservacion["fecha_ingreso"]
                                                )
                                            ); ?>

                                        </td>

                                        <td>

                                            <?= date(
                                                "d/m/Y",
                                                strtotime(
                                                    $reservacion["fecha_salida"]
                                                )
                                            ); ?>

                                        </td>

                                        <td
                                            data-order="<?= htmlspecialchars(
                                                $reservacion["total"]
                                            ); ?>">

                                            ₡ <?= number_format(
                                                $reservacion["total"],
                                                2,
                                                ".",
                                                ","
                                            ); ?>

                                        </td>                                        <td class="text-center">

                                            <?php

                                            switch ($reservacion["estado"]) {

                                                case "Pendiente":
                                                    echo '<span class="badge bg-warning text-dark">Pendiente</span>';
                                                    break;

                                                case "Confirmada":
                                                    echo '<span class="badge bg-success">Confirmada</span>';
                                                    break;

                                                case "Finalizada":
                                                    echo '<span class="badge bg-primary">Finalizada</span>';
                                                    break;

                                                case "Cancelada":
                                                    echo '<span class="badge bg-danger">Cancelada</span>';
                                                    break;

                                            }

                                            ?>

                                        </td>

                                        <td class="text-center">

                                            <button
                                                type="button"
                                                class="btn btn-sm btn-primary btn-editar me-1"

                                                data-id="<?= $reservacion["id_reservacion"]; ?>"
                                                data-cliente="<?= $reservacion["id_cliente"]; ?>"
                                                data-cabina="<?= $reservacion["id_cabina"]; ?>"
                                                data-ingreso="<?= $reservacion["fecha_ingreso"]; ?>"
                                                data-salida="<?= $reservacion["fecha_salida"]; ?>"
                                                data-noches="<?= $reservacion["noches"]; ?>"
                                                data-subtotal="<?= $reservacion["subtotal"]; ?>"
                                                data-impuesto="<?= $reservacion["impuesto"]; ?>"
                                                data-total="<?= $reservacion["total"]; ?>"
                                                data-estado="<?= $reservacion["estado"]; ?>">

                                                <i class="bi bi-pencil"></i>

                                            </button>

                                            <a
                                                href="eliminar.php?id=<?= $reservacion["id_reservacion"]; ?>"
                                                class="btn btn-sm btn-danger"
                                                onclick="return confirm('¿Desea eliminar esta reservación?');">

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
    id="modalReservacion"
    tabindex="-1"
    aria-hidden="true">

    <div class="modal-dialog modal-xl">

        <div class="modal-content">

            <form
                id="formReservacion"
                action="guardar.php"
                method="POST">

                <input
                    type="hidden"
                    id="id_reservacion"
                    name="id_reservacion">

                <div class="modal-header">

                    <h5
                        class="modal-title">

                        Nueva Reservación

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

                                Cliente

                            </label>

                            <select
                                id="id_cliente"
                                name="id_cliente"
                                class="form-select"
                                required>

                                <option value="">

                                    Seleccione...

                                </option>

                                <?php foreach($clientes as $cliente){ ?>

                                    <option
                                        value="<?= $cliente["id_cliente"]; ?>">

                                        <?= htmlspecialchars($cliente["nombre"]); ?>

                                    </option>

                                <?php } ?>

                            </select>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">

                                Cabina

                            </label>

                            <select
                                id="id_cabina"
                                name="id_cabina"
                                class="form-select"
                                required>

                                <option value="">

                                    Seleccione...

                                </option>

                                <?php foreach($cabinas as $cabina){ ?>

                                    <option
                                        value="<?= $cabina["id_cabina"]; ?>"
                                        data-precio="<?= $cabina["precio_noche"]; ?>">

                                        <?= htmlspecialchars($cabina["nombre"]); ?>

                                    </option>

                                <?php } ?>

                            </select>

                        </div>                        <div class="col-md-3 mb-3">

                            <label class="form-label">

                                Fecha de Ingreso

                            </label>

                            <input
                                type="date"
                                id="fecha_ingreso"
                                name="fecha_ingreso"
                                class="form-control"
                                required>

                        </div>

                        <div class="col-md-3 mb-3">

                            <label class="form-label">

                                Fecha de Salida

                            </label>

                            <input
                                type="date"
                                id="fecha_salida"
                                name="fecha_salida"
                                class="form-control"
                                required>

                        </div>

                        <div class="col-md-2 mb-3">

                            <label class="form-label">

                                Noches

                            </label>

                            <input
                                type="number"
                                id="noches"
                                name="noches"
                                class="form-control"
                                readonly>

                        </div>

                        <div class="col-md-2 mb-3">

                            <label class="form-label">

                                Subtotal

                            </label>

                            <input
                                type="number"
                                id="subtotal"
                                name="subtotal"
                                class="form-control"
                                step="0.01"
                                readonly>

                        </div>

                        <div class="col-md-2 mb-3">

                            <label class="form-label">

                                Impuesto

                            </label>

                            <input
                                type="number"
                                id="impuesto"
                                name="impuesto"
                                class="form-control"
                                step="0.01"
                                readonly>

                        </div>

                        <div class="col-md-2 mb-3">

                            <label class="form-label">

                                Total

                            </label>

                            <input
                                type="number"
                                id="total"
                                name="total"
                                class="form-control"
                                step="0.01"
                                readonly>

                        </div>

                        <div class="col-md-3 mb-3">

                            <label class="form-label">

                                Estado

                            </label>

                            <select
                                id="estado"
                                name="estado"
                                class="form-select"
                                required>

                                <option value="Pendiente">
                                    Pendiente
                                </option>

                                <option value="Confirmada">
                                    Confirmada
                                </option>

                                <option value="Finalizada">
                                    Finalizada
                                </option>

                                <option value="Cancelada">
                                    Cancelada
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

function iniciarReservacion() {

    const cabina = document.getElementById("id_cabina");
    const ingreso = document.getElementById("fecha_ingreso");
    const salida = document.getElementById("fecha_salida");

    const noches = document.getElementById("noches");
    const subtotal = document.getElementById("subtotal");
    const impuesto = document.getElementById("impuesto");
    const total = document.getElementById("total");


    function limpiarCalculo() {

        noches.value = "";
        subtotal.value = "";
        impuesto.value = "";
        total.value = "";

    }


    function calcularReservacion() {

        if (
            cabina.value === "" ||
            ingreso.value === "" ||
            salida.value === ""
        ) {

            limpiarCalculo();

            return;

        }


        const opcion =
            cabina.options[cabina.selectedIndex];

        const precio =
            parseFloat(opcion.getAttribute("data-precio"));


        if (isNaN(precio)) {

            limpiarCalculo();

            return;

        }


        const fechaIngreso =
            new Date(ingreso.value + "T00:00:00");

        const fechaSalida =
            new Date(salida.value + "T00:00:00");


        const diferencia =
            fechaSalida.getTime() -
            fechaIngreso.getTime();


        const cantidadNoches =
            Math.round(
                diferencia /
                (1000 * 60 * 60 * 24)
            );


        if (cantidadNoches <= 0) {

            limpiarCalculo();

            return;

        }


        const montoSubtotal =
            cantidadNoches * precio;


        const montoImpuesto =
            montoSubtotal * 0.13;


        const montoTotal =
            montoSubtotal + montoImpuesto;


        noches.value =
            cantidadNoches;


        subtotal.value =
            montoSubtotal.toFixed(2);


        impuesto.value =
            montoImpuesto.toFixed(2);


        total.value =
            montoTotal.toFixed(2);

    }


    cabina.addEventListener(
        "change",
        calcularReservacion
    );


    ingreso.addEventListener(
        "change",
        calcularReservacion
    );


    salida.addEventListener(
        "change",
        calcularReservacion
    );


    document.getElementById("btnNuevo")
        .addEventListener(
            "click",
            function() {

                document.querySelector(
                    "#modalReservacion .modal-title"
                ).textContent =
                    "Nueva Reservación";


                document.getElementById(
                    "formReservacion"
                ).action =
                    "guardar.php";


                document.getElementById(
                    "id_reservacion"
                ).value = "";


                document.getElementById(
                    "id_cliente"
                ).value = "";


                cabina.value = "";


                ingreso.value = "";


                salida.value = "";


                limpiarCalculo();


                document.getElementById(
                    "estado"
                ).value =
                    "Pendiente";

            }
        );


    document.querySelectorAll(
        ".btn-editar"
    ).forEach(function(boton) {

        boton.addEventListener(
            "click",
            function() {

                document.querySelector(
                    "#modalReservacion .modal-title"
                ).textContent =
                    "Editar Reservación";


                document.getElementById(
                    "formReservacion"
                ).action =
                    "editar.php";


                document.getElementById(
                    "id_reservacion"
                ).value =
                    this.dataset.id;


                document.getElementById(
                    "id_cliente"
                ).value =
                    this.dataset.cliente;


                cabina.value =
                    this.dataset.cabina;


                ingreso.value =
                    this.dataset.ingreso;


                salida.value =
                    this.dataset.salida;


                noches.value =
                    this.dataset.noches;


                subtotal.value =
                    this.dataset.subtotal;


                impuesto.value =
                    this.dataset.impuesto;


                total.value =
                    this.dataset.total;


                document.getElementById(
                    "estado"
                ).value =
                    this.dataset.estado;


                const modal =
                    bootstrap.Modal.getOrCreateInstance(
                        document.getElementById(
                            "modalReservacion"
                        )
                    );


                modal.show();

            }
        );

    });

}


if (document.readyState === "loading") {

    document.addEventListener(
        "DOMContentLoaded",
        iniciarReservacion
    );

} else {

    iniciarReservacion();

}

</script>

<?php include("../includes/footer.php"); ?>