<?php

$pagina = basename($_SERVER["PHP_SELF"]);

?>

<aside class="sidebar">

    <div class="sidebar-header">

        <i class="bi bi-house-heart-fill logo-icon"></i>

        <h3>CabinRent</h3>

        <span>Sistema de Gestión</span>

    </div>

    <ul class="sidebar-menu">

        <li>

            <a href="../dashboard/index.php" class="<?= $pagina == "index.php" && strpos($_SERVER["REQUEST_URI"], "/dashboard/") !== false ? "active" : ""; ?>">

                <i class="bi bi-speedometer2"></i>

                Dashboard

            </a>

        </li>

        <li>

            <a href="../roles/index.php" class="<?= strpos($_SERVER["REQUEST_URI"], "/roles/") !== false ? "active" : ""; ?>">

                <i class="bi bi-shield-lock"></i>

                Roles

            </a>

        </li>

        <li>

            <a href="../usuarios/index.php" class="<?= strpos($_SERVER["REQUEST_URI"], "/usuarios/") !== false ? "active" : ""; ?>">

                <i class="bi bi-people"></i>

                Usuarios

            </a>

        </li>

        <li>

            <a href="../cabinas/index.php" class="<?= strpos($_SERVER["REQUEST_URI"], "/cabinas/") !== false ? "active" : ""; ?>">

                <i class="bi bi-house-door"></i>

                Cabinas

            </a>

        </li>

        <li>

            <a href="../clientes/index.php" class="<?= strpos($_SERVER["REQUEST_URI"], "/clientes/") !== false ? "active" : ""; ?>">

                <i class="bi bi-person-badge"></i>

                Clientes

            </a>

        </li>

        <li>

            <a href="../reservaciones/index.php" class="<?= strpos($_SERVER["REQUEST_URI"], "/reservaciones/") !== false ? "active" : ""; ?>">

                <i class="bi bi-calendar-check"></i>

                Reservaciones

            </a>

        </li>

        <li>

            <a href="../pagos/index.php" class="<?= strpos($_SERVER["REQUEST_URI"], "/pagos/") !== false ? "active" : ""; ?>">

                <i class="bi bi-credit-card"></i>

                Pagos

            </a>

        </li>

    </ul>

    <div class="sidebar-footer">

        <a href="../login/logout.php">

            <i class="bi bi-box-arrow-right"></i>

            Cerrar sesión

        </a>

    </div>

</aside>