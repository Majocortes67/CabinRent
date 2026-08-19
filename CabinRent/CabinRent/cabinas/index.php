<?php

session_start();

if (!isset($_SESSION["id_usuario"])) {
    header("Location: ../index.php");
    exit;
}

require_once("../config/conexion.php");

$titulo = "Cabinas | CabinRent";

$sql = "SELECT *
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

                <button
                    id="btnNuevo"
                    class="btn btn-success"
                    data-bs-toggle="modal"
                    data-bs-target="#modalCabina">

                    <i class="bi bi-plus-circle"></i>

                    Nueva Cabina

                </button>

            </div>

            <div class="card shadow-sm">

                <div class="card-body">

                    <table class="table table-hover align-middle">

                        <thead>

                            <tr>

                                <th width="90">Imagen</th>
                                <th>Nombre</th>
                                <th>Capacidad</th>
                                <th>Precio / Noche</th>
                                <th>Estado</th>
                                <th width="180">Acciones</th>

                            </tr>

                        </thead>

                        <tbody>

<?php foreach ($cabinas as $cabina) { ?>

<tr>

    <td>

        <img
            src="../assets/img/cabinas/<?= htmlspecialchars($cabina["imagen"]); ?>"
            width="70"
            height="55"
            style="object-fit:cover;border-radius:8px;">

    </td>

    <td><?= htmlspecialchars($cabina["nombre"]); ?></td>

    <td><?= $cabina["capacidad"]; ?> Personas</td>

    <td>

        ₡ <?= number_format($cabina["precio_noche"], 2); ?>

    </td>

    <td>

        <?php

        switch ($cabina["estado"]) {

            case "Disponible":
                echo '<span class="badge bg-success">Disponible</span>';
                break;

            case "Ocupada":
                echo '<span class="badge bg-warning text-dark">Ocupada</span>';
                break;

            case "Mantenimiento":
                echo '<span class="badge bg-danger">Mantenimiento</span>';
                break;

        }

        ?>

    </td>

    <td>

        <button
            type="button"
            class="btn btn-sm btn-primary btn-editar"

            data-id="<?= $cabina["id_cabina"]; ?>"
            data-nombre="<?= htmlspecialchars($cabina["nombre"]); ?>"
            data-descripcion="<?= htmlspecialchars($cabina["descripcion"]); ?>"
            data-capacidad="<?= $cabina["capacidad"]; ?>"
            data-precio="<?= $cabina["precio_noche"]; ?>"
            data-imagen="<?= htmlspecialchars($cabina["imagen"]); ?>"
            data-estado="<?= $cabina["estado"]; ?>">

            <i class="bi bi-pencil"></i>

        </button>

        <a
            href="eliminar.php?id=<?= $cabina["id_cabina"]; ?>"
            class="btn btn-sm btn-danger"
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

<div class="modal fade" id="modalCabina" tabindex="-1" aria-hidden="true">

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

                    <h5 class="modal-title">
                        Nueva Cabina
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

                            <label class="form-label">
                                Descripción
                            </label>

                            <textarea
                                id="descripcion"
                                name="descripcion"
                                class="form-control"
                                rows="3"
                                required></textarea>

                        </div>

                        <div class="col-md-4 mb-3">

                            <label class="form-label">
                                Precio por Noche
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

                            <label class="form-label">
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

                            <label class="form-label">
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

document.querySelectorAll(".btn-editar").forEach(function(boton){

    boton.addEventListener("click", function(){

        document.querySelector(".modal-title").innerHTML = "Editar Cabina";

        document.getElementById("formCabina").action = "editar.php";

        document.getElementById("id_cabina").value = this.dataset.id;
        document.getElementById("nombre").value = this.dataset.nombre;
        document.getElementById("descripcion").value = this.dataset.descripcion;
        document.getElementById("capacidad").value = this.dataset.capacidad;
        document.getElementById("precio_noche").value = this.dataset.precio;
        document.getElementById("imagen").value = this.dataset.imagen;
        document.getElementById("estado").value = this.dataset.estado;

        let modal = new bootstrap.Modal(
            document.getElementById("modalCabina")
        );

        modal.show();

    });

});

document.getElementById("btnNuevo").addEventListener("click", function(){

    document.querySelector(".modal-title").innerHTML = "Nueva Cabina";

    document.getElementById("formCabina").action = "guardar.php";

    document.getElementById("id_cabina").value = "";
    document.getElementById("nombre").value = "";
    document.getElementById("descripcion").value = "";
    document.getElementById("capacidad").value = "";
    document.getElementById("precio_noche").value = "";
    document.getElementById("imagen").value = "";
    document.getElementById("estado").value = "Disponible";

});

</script>

<?php include("../includes/footer.php"); ?>
