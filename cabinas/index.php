<?php

session_start();

if (!isset($_SESSION["id_usuario"])) {
    header("Location: ../index.php");
    exit;
}

require_once("../config/conexion.php");

$titulo = "Cabinas | CabinRent";

$sql = "SELECT
            id_cabina,
            nombre,
            descripcion,
            capacidad,
            precio_noche,
            imagen,
            estado
        FROM cabinas
        ORDER BY id_cabina ASC";

$stmt = $conexion->prepare($sql);
$stmt->execute();

$cabinas = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
                        Gestión de Cabinas
                    </h2>

                    <p class="text-muted mb-0">
                        Administre las cabinas del sistema.
                    </p>

                </div>

                <div class="d-flex gap-2 flex-wrap">

                    <button
                        id="btnDisponibilidad"
                        type="button"
                        class="btn btn-info"
                        data-bs-toggle="modal"
                        data-bs-target="#modalDisponibilidad">

                        <i class="bi bi-calendar-check"></i>
                        Consultar disponibilidad

                    </button>

                    <button
                        id="btnNuevo"
                        type="button"
                        class="btn btn-success"
                        data-bs-toggle="modal"
                        data-bs-target="#modalCabina">

                        <i class="bi bi-plus-circle"></i>
                        Nueva Cabina

                    </button>

                </div>

            </div>
                        <div class="card shadow-sm">

                <div class="card-body">

                    <div class="table-responsive">

                        <table
                            id="tablaCabinas"
                            class="table table-hover table-striped align-middle w-100">

                            <thead>

                                <tr>

                                    <th>Imagen</th>
                                    <th>Nombre</th>
                                    <th>Capacidad</th>
                                    <th>Precio por noche</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>

                                </tr>

                            </thead>

                            <tbody>

                                <?php foreach ($cabinas as $cabina) { ?>

                                    <tr>

                                        <td>

                                            <?php if (!empty($cabina["imagen"])) { ?>

                                                <img
                                                    src="../assets/img/cabinas/<?= htmlspecialchars(
                                                        $cabina["imagen"],
                                                        ENT_QUOTES,
                                                        "UTF-8"
                                                    ); ?>"
                                                    alt="<?= htmlspecialchars(
                                                        $cabina["nombre"],
                                                        ENT_QUOTES,
                                                        "UTF-8"
                                                    ); ?>"
                                                    width="80"
                                                    height="60"
                                                    style="object-fit: cover; border-radius: 10px;">

                                            <?php } else { ?>

                                                <span class="text-muted">
                                                    Sin imagen
                                                </span>

                                            <?php } ?>

                                        </td>

                                        <td>

                                            <?= htmlspecialchars(
                                                $cabina["nombre"],
                                                ENT_QUOTES,
                                                "UTF-8"
                                            ); ?>

                                        </td>

                                        <td>

                                            <?= (int) $cabina["capacidad"]; ?>
                                            personas

                                        </td>

                                        <td>

                                            ₡<?= number_format(
                                                (float) $cabina["precio_noche"],
                                                2,
                                                ",",
                                                "."
                                            ); ?>

                                        </td>

                                        <td>

                                            <?php switch ($cabina["estado"]) {

                                                case "Disponible": ?>

                                                    <span class="badge bg-success">
                                                        Disponible
                                                    </span>

                                                    <?php break;

                                                case "Ocupada": ?>

                                                    <span class="badge bg-warning text-dark">
                                                        Ocupada
                                                    </span>

                                                    <?php break;

                                                case "Mantenimiento": ?>

                                                    <span class="badge bg-danger">
                                                        Mantenimiento
                                                    </span>

                                                    <?php break;

                                                default: ?>

                                                    <span class="badge bg-secondary">
                                                        Sin definir
                                                    </span>

                                            <?php } ?>

                                        </td>

                                        <td class="text-nowrap">

                                            <button
                                                type="button"
                                                class="btn btn-sm btn-primary btn-editar me-1"
                                                title="Editar cabina"

                                                data-id="<?= (int) $cabina["id_cabina"]; ?>"

                                                data-nombre="<?= htmlspecialchars(
                                                    $cabina["nombre"],
                                                    ENT_QUOTES,
                                                    "UTF-8"
                                                ); ?>"

                                                data-descripcion="<?= htmlspecialchars(
                                                    $cabina["descripcion"] ?? "",
                                                    ENT_QUOTES,
                                                    "UTF-8"
                                                ); ?>"

                                                data-capacidad="<?= (int) $cabina["capacidad"]; ?>"

                                                data-precio="<?= htmlspecialchars(
                                                    $cabina["precio_noche"],
                                                    ENT_QUOTES,
                                                    "UTF-8"
                                                ); ?>"

                                                data-imagen="<?= htmlspecialchars(
                                                    $cabina["imagen"] ?? "",
                                                    ENT_QUOTES,
                                                    "UTF-8"
                                                ); ?>"

                                                data-estado="<?= htmlspecialchars(
                                                    $cabina["estado"],
                                                    ENT_QUOTES,
                                                    "UTF-8"
                                                ); ?>">

                                                <i class="bi bi-pencil"></i>

                                            </button>

                                            <a
                                                href="eliminar.php?id=<?= (int) $cabina["id_cabina"]; ?>"
                                                class="btn btn-sm btn-danger"
                                                title="Eliminar cabina"
                                                onclick="return confirm('¿Desea eliminar esta cabina?');">

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
<!-- Modal para consultar disponibilidad -->
<div
    class="modal fade"
    id="modalDisponibilidad"
    tabindex="-1"
    aria-labelledby="tituloModalDisponibilidad"
    aria-hidden="true">

    <div class="modal-dialog modal-xl">

        <div class="modal-content">

            <div class="modal-header">

                <h5
                    class="modal-title"
                    id="tituloModalDisponibilidad">

                    Consultar disponibilidad de cabinas

                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Cerrar">
                </button>

            </div>

            <div class="modal-body">

                <div class="row g-3 mb-4">

                    <div class="col-md-4">

                        <label
                            for="fechaIngresoDisponibilidad"
                            class="form-label">

                            Fecha de ingreso

                        </label>

                        <input
                            type="date"
                            id="fechaIngresoDisponibilidad"
                            class="form-control"
                            required>

                    </div>

                    <div class="col-md-4">

                        <label
                            for="fechaSalidaDisponibilidad"
                            class="form-label">

                            Fecha de salida

                        </label>

                        <input
                            type="date"
                            id="fechaSalidaDisponibilidad"
                            class="form-control"
                            required>

                    </div>

                    <div class="col-md-4 d-flex align-items-end">

                        <button
                            type="button"
                            id="btnBuscarDisponibilidad"
                            class="btn btn-success w-100">

                            <i class="bi bi-search"></i>
                            Buscar disponibilidad

                        </button>

                    </div>

                </div>

                <div
                    id="mensajeDisponibilidad"
                    class="alert d-none"
                    role="alert">
                </div>

                <div class="table-responsive">

                    <table class="table table-bordered table-hover align-middle">

                        <thead class="table-light">

                            <tr>

                                <th>Imagen</th>
                                <th>Cabina</th>
                                <th>Capacidad</th>
                                <th>Precio por noche</th>
                                <th>Disponibilidad</th>

                            </tr>

                        </thead>

                        <tbody id="resultadoDisponibilidad">

                            <tr>

                                <td
                                    colspan="5"
                                    class="text-center text-muted py-4">

                                    Seleccione las fechas y presione Buscar disponibilidad.

                                </td>

                            </tr>

                        </tbody>

                    </table>

                </div>

            </div>

            <div class="modal-footer">

                <button
                    type="button"
                    class="btn btn-secondary"
                    data-bs-dismiss="modal">

                    Cerrar

                </button>

            </div>

        </div>

    </div>

</div>

<div
    class="modal fade"
    id="modalCabina"
    tabindex="-1"
    aria-labelledby="tituloModalCabina"
    aria-hidden="true">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <form
                id="formCabina"
                action="guardar.php"
                method="POST">

                <input
                    type="hidden"
                    id="id_cabina"
                    name="id_cabina">

                <div class="modal-header">

                    <h5
                        class="modal-title"
                        id="tituloModalCabina">

                        Nueva Cabina

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
                                for="capacidad"
                                class="form-label">

                                Capacidad

                            </label>

                            <input
                                type="number"
                                id="capacidad"
                                name="capacidad"
                                class="form-control"
                                min="1"
                                required>

                        </div>

                        <div class="col-12 mb-3">

                            <label
                                for="descripcion"
                                class="form-label">

                                Descripción

                            </label>

                            <textarea
                                id="descripcion"
                                name="descripcion"
                                class="form-control"
                                rows="3"></textarea>

                        </div>

                        <div class="col-md-4 mb-3">

                            <label
                                for="precio_noche"
                                class="form-label">

                                Precio por noche

                            </label>

                            <input
                                type="number"
                                id="precio_noche"
                                name="precio_noche"
                                class="form-control"
                                step="0.01"
                                min="0"
                                required>

                        </div>

                        <div class="col-md-4 mb-3">

                            <label
                                for="imagen"
                                class="form-label">

                                Imagen

                            </label>

                            <select
                                id="imagen"
                                name="imagen"
                                class="form-select"
                                required>

                                <option value="">
                                    Seleccione...
                                </option>

                                <option value="Cabina 1.png">
                                    Cabina 1
                                </option>

                                <option value="Cabina 2.png">
                                    Cabina 2
                                </option>

                                <option value="Cabina 3.jpg">
                                    Cabina 3
                                </option>

                            </select>

                        </div>

                        <div class="col-md-4 mb-3">

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

                                <option value="Disponible">
                                    Disponible
                                </option>

                                <option value="Ocupada">
                                    Ocupada
                                </option>

                                <option value="Mantenimiento">
                                    Mantenimiento
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

    const formulario = document.getElementById("formCabina");
    const tituloModal = document.getElementById("tituloModalCabina");
    const botonNuevo = document.getElementById("btnNuevo");
    const modalElemento = document.getElementById("modalCabina");

    botonNuevo.addEventListener("click", function () {

        tituloModal.textContent = "Nueva Cabina";

        formulario.action = "guardar.php";
        formulario.reset();

        document.getElementById("id_cabina").value = "";
        document.getElementById("estado").value = "Disponible";

    });

    document.addEventListener("click", function (evento) {

        const botonEditar = evento.target.closest(".btn-editar");

        if (!botonEditar) {
            return;
        }

        tituloModal.textContent = "Editar Cabina";

        formulario.action = "editar.php";

        document.getElementById("id_cabina").value =
            botonEditar.dataset.id;

        document.getElementById("nombre").value =
            botonEditar.dataset.nombre;

        document.getElementById("descripcion").value =
            botonEditar.dataset.descripcion;

        document.getElementById("capacidad").value =
            botonEditar.dataset.capacidad;

        document.getElementById("precio_noche").value =
            botonEditar.dataset.precio;

        document.getElementById("imagen").value =
            botonEditar.dataset.imagen;

        document.getElementById("estado").value =
            botonEditar.dataset.estado;

        const modalCabina =
            bootstrap.Modal.getOrCreateInstance(modalElemento);

        modalCabina.show();

    });



    const fechaIngresoDisponibilidad = document.getElementById(
        "fechaIngresoDisponibilidad"
    );

    const fechaSalidaDisponibilidad = document.getElementById(
        "fechaSalidaDisponibilidad"
    );

    const botonBuscarDisponibilidad = document.getElementById(
        "btnBuscarDisponibilidad"
    );

    const resultadoDisponibilidad = document.getElementById(
        "resultadoDisponibilidad"
    );

    const mensajeDisponibilidad = document.getElementById(
        "mensajeDisponibilidad"
    );

    function mostrarMensajeDisponibilidad(tipo, mensaje) {

        mensajeDisponibilidad.className = "alert alert-" + tipo;
        mensajeDisponibilidad.textContent = mensaje;
        mensajeDisponibilidad.classList.remove("d-none");

    }

    function ocultarMensajeDisponibilidad() {

        mensajeDisponibilidad.classList.add("d-none");
        mensajeDisponibilidad.textContent = "";

    }

    fechaIngresoDisponibilidad.addEventListener("change", function () {

        fechaSalidaDisponibilidad.min = this.value;

        if (
            fechaSalidaDisponibilidad.value !== "" &&
            fechaSalidaDisponibilidad.value <= this.value
        ) {
            fechaSalidaDisponibilidad.value = "";
        }

    });

    botonBuscarDisponibilidad.addEventListener("click", async function () {

        const fechaIngreso = fechaIngresoDisponibilidad.value;
        const fechaSalida = fechaSalidaDisponibilidad.value;

        ocultarMensajeDisponibilidad();

        if (fechaIngreso === "" || fechaSalida === "") {

            mostrarMensajeDisponibilidad(
                "warning",
                "Debe seleccionar la fecha de ingreso y la fecha de salida."
            );

            return;
        }

        if (fechaSalida <= fechaIngreso) {

            mostrarMensajeDisponibilidad(
                "warning",
                "La fecha de salida debe ser posterior a la fecha de ingreso."
            );

            return;
        }

        botonBuscarDisponibilidad.disabled = true;
        botonBuscarDisponibilidad.innerHTML =
            '<span class="spinner-border spinner-border-sm me-2"></span>Buscando...';

        resultadoDisponibilidad.innerHTML = `
            <tr>
                <td colspan="5" class="text-center py-4">
                    Consultando disponibilidad...
                </td>
            </tr>
        `;

        try {

            const parametros = new URLSearchParams({
                fecha_ingreso: fechaIngreso,
                fecha_salida: fechaSalida
            });

            const respuesta = await fetch(
                "consultar_disponibilidad.php?" + parametros.toString(),
                {
                    method: "GET",
                    headers: {
                        "Accept": "application/json"
                    }
                }
            );

            if (!respuesta.ok) {
                throw new Error("No fue posible consultar la disponibilidad.");
            }

            const datos = await respuesta.json();

            if (!datos.ok) {
                throw new Error(
                    datos.mensaje || "Ocurrió un error durante la consulta."
                );
            }

            if (datos.cabinas.length === 0) {

                resultadoDisponibilidad.innerHTML = `
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">
                            No se encontraron cabinas registradas.
                        </td>
                    </tr>
                `;

                return;
            }

            resultadoDisponibilidad.innerHTML = datos.cabinas.map(function (cabina) {

                const imagen = cabina.imagen
                    ? `<img
                            src="../assets/img/cabinas/${cabina.imagen_segura}"
                            alt="${cabina.nombre_seguro}"
                            width="80"
                            height="60"
                            style="object-fit:cover;border-radius:10px;">`
                    : '<span class="text-muted">Sin imagen</span>';

                const estado = cabina.disponible
                    ? '<span class="badge bg-success">Disponible</span>'
                    : '<span class="badge bg-danger">No disponible</span>';

                return `
                    <tr>
                        <td>${imagen}</td>
                        <td>${cabina.nombre_seguro}</td>
                        <td>${cabina.capacidad} personas</td>
                        <td>₡${cabina.precio_formateado}</td>
                        <td>${estado}</td>
                    </tr>
                `;

            }).join("");

        } catch (error) {

            resultadoDisponibilidad.innerHTML = `
                <tr>
                    <td colspan="5" class="text-center text-danger py-4">
                        No fue posible cargar la disponibilidad.
                    </td>
                </tr>
            `;

            mostrarMensajeDisponibilidad("danger", error.message);

        } finally {

            botonBuscarDisponibilidad.disabled = false;
            botonBuscarDisponibilidad.innerHTML =
                '<i class="bi bi-search"></i> Buscar disponibilidad';

        }

    });

});

</script>

<?php include("../includes/footer.php"); ?>