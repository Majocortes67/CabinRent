<nav class="navbar navbar-expand-lg bg-white shadow-sm border-bottom">

    <div class="container-fluid">

        <button
            class="btn border-0 d-lg-none"
            type="button">

            <i class="bi bi-list fs-3"></i>

        </button>

        <div class="ms-auto d-flex align-items-center">

            <div class="me-3 text-end">

                <small class="text-muted d-block">
                    Bienvenido
                </small>

                <strong class="text-dark">
                    <?= $_SESSION["nombre"]; ?>
                </strong>

            </div>

            <div
                class="rounded-circle d-flex justify-content-center align-items-center"
                style="
                    width:45px;
                    height:45px;
                    background:#2F5D50;
                    color:white;
                    font-weight:bold;
                ">

                <?= strtoupper(substr($_SESSION["nombre"],0,1)); ?>

            </div>

        </div>

    </div>

</nav>