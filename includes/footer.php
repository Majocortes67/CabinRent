<!-- Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php if(isset($_SESSION["mensaje"])) { ?>

<script>

document.addEventListener("DOMContentLoaded", function(){

    const mensaje = "<?= htmlspecialchars($_SESSION["mensaje"]); ?>";

    let icono = "success";
    let titulo = "Éxito";

    if (
        mensaje.includes("no está disponible") ||
        mensaje.includes("debe ser mayor") ||
        mensaje.includes("error") ||
        mensaje.includes("Ocurrió")
    ) {

        icono = "error";
        titulo = "No se pudo completar";

    }

    Swal.fire({

        icon: icono,

        title: titulo,

        text: mensaje,

        confirmButtonColor: "#2F5D50"

    });

});

</script>

<?php

unset($_SESSION["mensaje"]);

}

?>

<!-- JQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- DataTables -->
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>

<!-- Responsive -->
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

<!-- Buttons -->
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>

<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>

<!-- Dependencias -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

<!-- Exportación -->
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>

<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

<script>

$(document).ready(function(){

    const tablas = [

        "#tablaUsuarios",
        "#tablaRoles",
        "#tablaCabinas",
        "#tablaClientes",
        "#tablaReservaciones",
        "#tablaPagos"

    ];

    tablas.forEach(function(tabla){

        if($(tabla).length){

            $(tabla).DataTable({

                responsive: true,

                autoWidth: false,

                pageLength: 10,

                lengthMenu: [
                    [5, 10, 25, 50, -1],
                    [5, 10, 25, 50, "Todos"]
                ],

                dom: '<"datatable-toolbar"<"datatable-buttons"B><"datatable-search"f>>rt<"datatable-bottom"ip>',

                buttons: [

                    {
                        extend: "copy",
                        text: '<i class="bi bi-copy"></i> Copiar'
                    },

                    {
                        extend: "excel",
                        text: '<i class="bi bi-file-earmark-excel"></i> Excel'
                    },

                    {
                        extend: "csv",
                        text: '<i class="bi bi-filetype-csv"></i> CSV'
                    },

                    {
                        extend: "pdf",
                        text: '<i class="bi bi-file-earmark-pdf"></i> PDF'
                    },

                    {
                        extend: "print",
                        text: '<i class="bi bi-printer"></i> Imprimir'
                    }

                ],

                language: {

                    url: "https://cdn.datatables.net/plug-ins/1.13.8/i18n/es-ES.json"

                }

            });

        }

    });

});

</script>

</body>

</html>