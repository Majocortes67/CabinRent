<?php
session_start();

if (!isset($_SESSION["id_usuario"])) {
    header("Location: ../index.php");
    exit;
}

$titulo = "Inicio | CabinRent";

include("../includes/header.php");

$nombreUsuario = htmlspecialchars(
    $_SESSION["nombre"] ?? "usuario",
    ENT_QUOTES,
    "UTF-8"
);
?>

<style>
    .hero-cabinrent {
        background: linear-gradient(135deg, #198754, #20c997);
        border-radius: 18px;
        overflow: hidden;
        position: relative;
    }

    .hero-cabinrent::before {
        content: "";
        position: absolute;
        width: 240px;
        height: 240px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.10);
        top: -100px;
        right: -70px;
    }

    .hero-cabinrent::after {
        content: "";
        position: absolute;
        width: 170px;
        height: 170px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.08);
        bottom: -90px;
        left: -50px;
    }

    .hero-content {
        position: relative;
        z-index: 1;
    }

    .module-link {
        color: inherit;
        text-decoration: none;
    }

    .module-card {
        border-radius: 16px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        cursor: pointer;
    }

    .module-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 16px 35px rgba(0, 0, 0, 0.16) !important;
    }

    .module-icon {
        width: 82px;
        height: 82px;
        margin: 0 auto;
        border-radius: 22px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 38px;
    }

    .icon-success {
        color: #198754;
        background: rgba(25, 135, 84, 0.12);
    }

    .icon-primary {
        color: #0d6efd;
        background: rgba(13, 110, 253, 0.12);
    }

    .icon-warning {
        color: #d39e00;
        background: rgba(255, 193, 7, 0.18);
    }

    .icon-danger {
        color: #dc3545;
        background: rgba(220, 53, 69, 0.12);
    }

    .feature-card {
        border-radius: 16px;
        transition: transform 0.25s ease;
    }

    .feature-card:hover {
        transform: translateY(-4px);
    }

    .quick-module {
        border-radius: 14px;
        background: #f8f9fa;
        transition: background 0.25s ease, transform 0.25s ease;
    }

    .quick-module:hover {
        background: #eef8f2;
        transform: translateY(-3px);
    }

    .site-footer {
        border-top: 1px solid #dee2e6;
    }

    @media (max-width: 767.98px) {
        .hero-cabinrent .card-body {
            padding: 2.5rem 1.5rem !important;
        }

        .hero-cabinrent h1 {
            font-size: 2rem;
        }
    }
</style>

<div class="app">

    <?php include("../includes/sidebar.php"); ?>

    <div class="main-content">

        <?php include("../includes/navbar.php"); ?>

        <div class="container-fluid p-4">

            <!-- Banner principal -->
            <section class="card hero-cabinrent border-0 shadow-lg mb-5 text-white">
                <div class="card-body text-center p-5 hero-content">

                    <i class="bi bi-house-heart-fill"
                       style="font-size: 72px;"
                       aria-hidden="true"></i>

                    <h1 class="fw-bold mt-3 mb-2">
                        Bienvenido a CabinRent
                    </h1>

                    <h5 class="fw-normal mb-3">
                        Sistema de Gestión de Cabinas Turísticas
                    </h5>

                    <p class="mx-auto mb-4 fs-5"
                       style="max-width: 760px;">
                        CabinRent centraliza la administración de cabinas, clientes,
                        reservaciones y pagos en una plataforma intuitiva, segura y eficiente.
                    </p>

                    <div class="d-flex flex-wrap justify-content-center gap-2">
                        <a href="../cabinas/index.php"
                           class="btn btn-light btn-lg px-4">
                            <i class="bi bi-house-door-fill me-2"></i>
                            Ver cabinas
                        </a>

                        <a href="../reservaciones/index.php"
                           class="btn btn-outline-light btn-lg px-4">
                            <i class="bi bi-calendar-check-fill me-2"></i>
                            Ver reservaciones
                        </a>
                    </div>

                </div>
            </section>

            <!-- Accesos principales -->
            <section aria-labelledby="modulos-principales">
                <div class="d-flex flex-wrap justify-content-between align-items-end mb-4">
                    <div>
                        <h2 id="modulos-principales" class="fw-bold mb-1">
                            Módulos principales
                        </h2>

                        <p class="text-muted mb-0">
                            Seleccione una opción para ingresar al módulo correspondiente.
                        </p>
                    </div>
                </div>

                <div class="row g-4">

                    <div class="col-xl-3 col-md-6">
                        <a href="../cabinas/index.php" class="module-link">
                            <article class="card module-card shadow-sm border-0 h-100">
                                <div class="card-body text-center p-4">

                                    <div class="module-icon icon-success">
                                        <i class="bi bi-house-door-fill"></i>
                                    </div>

                                    <h4 class="fw-bold mt-4">
                                        Cabinas
                                    </h4>

                                    <p class="text-muted">
                                        Gestione la información, características y disponibilidad
                                        de las cabinas.
                                    </p>

                                    <span class="fw-semibold text-success">
                                        Ir al módulo
                                        <i class="bi bi-arrow-right ms-1"></i>
                                    </span>

                                </div>
                            </article>
                        </a>
                    </div>

                    <div class="col-xl-3 col-md-6">
                        <a href="../clientes/index.php" class="module-link">
                            <article class="card module-card shadow-sm border-0 h-100">
                                <div class="card-body text-center p-4">

                                    <div class="module-icon icon-primary">
                                        <i class="bi bi-people-fill"></i>
                                    </div>

                                    <h4 class="fw-bold mt-4">
                                        Clientes
                                    </h4>

                                    <p class="text-muted">
                                        Administre la información y el registro de los clientes
                                        del sistema.
                                    </p>

                                    <span class="fw-semibold text-primary">
                                        Ir al módulo
                                        <i class="bi bi-arrow-right ms-1"></i>
                                    </span>

                                </div>
                            </article>
                        </a>
                    </div>

                    <div class="col-xl-3 col-md-6">
                        <a href="../reservaciones/index.php" class="module-link">
                            <article class="card module-card shadow-sm border-0 h-100">
                                <div class="card-body text-center p-4">

                                    <div class="module-icon icon-warning">
                                        <i class="bi bi-calendar-check-fill"></i>
                                    </div>

                                    <h4 class="fw-bold mt-4">
                                        Reservaciones
                                    </h4>

                                    <p class="text-muted">
                                        Registre y consulte reservaciones de forma rápida,
                                        ordenada y sencilla.
                                    </p>

                                    <span class="fw-semibold text-warning-emphasis">
                                        Ir al módulo
                                        <i class="bi bi-arrow-right ms-1"></i>
                                    </span>

                                </div>
                            </article>
                        </a>
                    </div>

                    <div class="col-xl-3 col-md-6">
                        <a href="../pagos/index.php" class="module-link">
                            <article class="card module-card shadow-sm border-0 h-100">
                                <div class="card-body text-center p-4">

                                    <div class="module-icon icon-danger">
                                        <i class="bi bi-cash-stack"></i>
                                    </div>

                                    <h4 class="fw-bold mt-4">
                                        Pagos
                                    </h4>

                                    <p class="text-muted">
                                        Lleve el control y seguimiento de los pagos registrados
                                        en el sistema.
                                    </p>

                                    <span class="fw-semibold text-danger">
                                        Ir al módulo
                                        <i class="bi bi-arrow-right ms-1"></i>
                                    </span>

                                </div>
                            </article>
                        </a>
                    </div>

                </div>
            </section>

            <!-- Beneficios -->
            <section class="mt-5" aria-labelledby="beneficios-cabinrent">

                <div class="text-center mb-4">
                    <h2 id="beneficios-cabinrent" class="fw-bold">
                        ¿Por qué utilizar CabinRent?
                    </h2>

                    <p class="text-muted mb-0">
                        Una plataforma creada para facilitar la administración diaria.
                    </p>
                </div>

                <div class="row g-4">

                    <div class="col-lg-4">
                        <article class="card feature-card shadow-sm border-0 h-100">
                            <div class="card-body text-center p-4">

                                <i class="bi bi-shield-check text-success"
                                   style="font-size: 52px;"></i>

                                <h4 class="fw-bold mt-3">
                                    Seguridad
                                </h4>

                                <p class="text-muted mb-0">
                                    El acceso al sistema se controla mediante autenticación
                                    y sesiones de usuario.
                                </p>

                            </div>
                        </article>
                    </div>

                    <div class="col-lg-4">
                        <article class="card feature-card shadow-sm border-0 h-100">
                            <div class="card-body text-center p-4">

                                <i class="bi bi-lightning-charge-fill text-warning"
                                   style="font-size: 52px;"></i>

                                <h4 class="fw-bold mt-3">
                                    Rapidez
                                </h4>

                                <p class="text-muted mb-0">
                                    Los módulos permiten acceder de forma directa a las tareas
                                    principales del sistema.
                                </p>

                            </div>
                        </article>
                    </div>

                    <div class="col-lg-4">
                        <article class="card feature-card shadow-sm border-0 h-100">
                            <div class="card-body text-center p-4">

                                <i class="bi bi-phone text-primary"
                                   style="font-size: 52px;"></i>

                                <h4 class="fw-bold mt-3">
                                    Diseño adaptable
                                </h4>

                                <p class="text-muted mb-0">
                                    La interfaz se adapta a computadoras, tabletas y teléfonos
                                    mediante Bootstrap.
                                </p>

                            </div>
                        </article>
                    </div>

                </div>

            </section>

            <!-- Módulos adicionales -->
            <section class="card shadow-sm border-0 mt-5">
                <div class="card-body p-4">

                    <div class="row align-items-center g-4">

                        <div class="col-lg-5">
                            <h3 class="fw-bold">
                                Todo el sistema en un solo lugar
                            </h3>

                            <p class="text-muted mb-0">
                                Utilice el menú lateral o los accesos rápidos para administrar
                                los diferentes componentes de CabinRent.
                            </p>
                        </div>

                        <div class="col-lg-7">
                            <div class="row g-3">

                                <div class="col-sm-6 col-xl-4">
                                    <a href="../usuarios/index.php"
                                       class="module-link">
                                        <div class="quick-module text-center p-3 h-100">
                                            <i class="bi bi-person-gear text-primary fs-2"></i>
                                            <h6 class="fw-bold mt-2 mb-0">Usuarios</h6>
                                        </div>
                                    </a>
                                </div>

                                <div class="col-sm-6 col-xl-4">
                                    <a href="../roles/index.php"
                                       class="module-link">
                                        <div class="quick-module text-center p-3 h-100">
                                            <i class="bi bi-person-badge text-success fs-2"></i>
                                            <h6 class="fw-bold mt-2 mb-0">Roles</h6>
                                        </div>
                                    </a>
                                </div>

                                <div class="col-sm-6 col-xl-4">
                                    <a href="../reservaciones/index.php"
                                       class="module-link">
                                        <div class="quick-module text-center p-3 h-100">
                                            <i class="bi bi-journal-check text-warning fs-2"></i>
                                            <h6 class="fw-bold mt-2 mb-0">Control</h6>
                                        </div>
                                    </a>
                                </div>

                            </div>
                        </div>

                    </div>

                </div>
            </section>

            <!-- Bienvenida personalizada -->
            <section class="card border-0 shadow-sm mt-5">
                <div class="card-body p-4">

                    <div class="d-flex flex-column flex-md-row align-items-md-center gap-3">

                        <div class="module-icon icon-success m-0 flex-shrink-0"
                             style="width: 68px; height: 68px; font-size: 30px;">
                            <i class="bi bi-person-check-fill"></i>
                        </div>

                        <div>
                            <h3 class="fw-bold mb-1">
                                ¡Bienvenido, <?= $nombreUsuario; ?>!
                            </h3>

                            <p class="text-muted mb-0">
                                Desde esta página puede ingresar rápidamente a cabinas,
                                clientes, reservaciones, pagos, usuarios y roles.
                            </p>
                        </div>

                    </div>

                </div>
            </section>

            <!-- Pie de página -->
            <footer class="site-footer text-center mt-5 pt-4 pb-2">

                <h6 class="fw-bold mb-2">
                    © 2026 CabinRent. Todos los derechos reservados.
                </h6>

                <p class="text-muted mb-1">
                    Sistema de Gestión de Cabinas Turísticas
                </p>

                <p class="mb-0">
                    <strong>Creadores:</strong>
                    Bryan Castillo Sánchez y María José Cortez
                </p>

            </footer>

        </div>

    </div>

</div>

<?php include("../includes/footer.php"); ?>
