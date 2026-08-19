<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>CabinRent | Inicio de Sesión</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="assets/css/style.css">

</head>

<body>

    <div class="login-container">

        <div class="login-card">

            <div class="icono-cabana">

               <i class="bi bi-house-heart-fill"></i>

            </div>

            <h1>CabinRent</h1>

            <p class="subtitle">
                Sistema de Gestión de Cabinas
            </p>

            <form action="login/validar.php" method="POST">

                <div class="mb-3">

                    <label class="form-label">
                        Correo Electrónico
                    </label>

                    <input
                        type="email"
                        class="form-control"
                        name="correo"
                        placeholder="Ingrese su correo"
                        required>

                </div>

                <div class="mb-4">

                    <label class="form-label">
                        Contraseña
                    </label>

                    <input
                        type="password"
                        class="form-control"
                        name="contrasena"
                        placeholder="Ingrese su contraseña"
                        required>

                </div>

                <button
                    type="submit"
                    class="btn btn-success w-100">

                    <i class="bi bi-box-arrow-in-right"></i>

                    Iniciar Sesión

                </button>

            </form>

            <hr>

            <hr>

                <div class="desarrollado">

                    <p class="mb-2">
                        Desarrollado por
                    </p>

                    <img
                        src="assets/img/logo/SBM Tech Solutions.png"
                        alt="SBM Tech Solutions">

                    <h6 class="mt-3 mb-1">
                        SBM Tech Solutions
                    </h6>

                    <small>
                        Código limpio para soluciones eficientes.
                    </small>

                </div>

        </div>

    </div>

</body>

</html>