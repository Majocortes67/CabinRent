<?php

session_start();

/* Eliminar todas las variables de sesión */
$_SESSION = [];

/* Destruir la sesión */
session_destroy();

/* Evitar que el navegador use páginas en caché */
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

/* Regresar al login */
header("Location: ../index.php");
exit;