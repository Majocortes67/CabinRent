<!-- Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php if (isset($_SESSION["mensaje"])) { ?>

<script>
Swal.fire({
    icon: 'success',
    title: 'Éxito',
    text: <?= json_encode($_SESSION["mensaje"]); ?>,
    confirmButtonColor: '#2F5D50'
});
</script>

<?php

unset($_SESSION["mensaje"]);

}

?>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- DataTables -->
<script src="https://cdn.datatables.net/2.3.2/js/dataTables.min.js"></script>

<script src="https://cdn.datatables.net/2.3.2/js/dataTables.bootstrap5.min.js"></script>

<!-- Responsive -->
<script src="https://cdn.datatables.net/responsive/3.0.5/js/dataTables.responsive.min.js"></script>

<script src="https://cdn.datatables.net/responsive/3.0.5/js/responsive.bootstrap5.min.js"></script>

<!-- Buttons -->
<script src="https://cdn.datatables.net/buttons/3.2.5/js/dataTables.buttons.min.js"></script>

<script src="https://cdn.datatables.net/buttons/3.2.5/js/buttons.bootstrap5.min.js"></script>

<!-- Dependencias de exportación -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.20/pdfmake.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.20/vfs_fonts.js"></script>

<!-- Exportación -->
<script src="https://cdn.datatables.net/buttons/3.2.5/js/buttons.html5.min.js"></script>

<script src="https://cdn.datatables.net/buttons/3.2.5/js/buttons.print.min.js"></script>

<!-- Inicialización global de DataTables -->
<script>
document.addEventListener('DOMContentLoaded', function () {

    const tablaUsuarios = document.querySelector('#tablaUsuarios');

    if (tablaUsuarios) {

        new DataTable('#tablaUsuarios', {

            responsive: true,

            pageLength: 10,

            lengthMenu: [
                [5, 10, 25, 50, -1],
                [5, 10, 25, 50, 'Todos']
            ],

            layout: {

                topStart: {

                    buttons: [

                        {
                            extend: 'copyHtml5',
                            text: '<i class="bi bi-clipboard"></i> Copiar',
                            className: 'btn btn-secondary btn-sm',
                            exportOptions: {
                                columns: ':not(:last-child)'
                            }
                        },

                        {
                            extend: 'excelHtml5',
                            text: '<i class="bi bi-file-earmark-excel"></i> Excel',
                            className: 'btn btn-success btn-sm',
                            title: 'Usuarios - CabinRent',
                            exportOptions: {
                                columns: ':not(:last-child)'
                            }
                        },

                        {
                            extend: 'csvHtml5',
                            text: '<i class="bi bi-filetype-csv"></i> CSV',
                            className: 'btn btn-info btn-sm',
                            title: 'Usuarios - CabinRent',
                            exportOptions: {
                                columns: ':not(:last-child)'
                            }
                        },

                        {
                            extend: 'pdfHtml5',
                            text: '<i class="bi bi-file-earmark-pdf"></i> PDF',
                            className: 'btn btn-danger btn-sm',
                            title: 'Usuarios - CabinRent',
                            orientation: 'landscape',
                            pageSize: 'A4',
                            exportOptions: {
                                columns: ':not(:last-child)'
                            }
                        },

                        {
                            extend: 'print',
                            text: '<i class="bi bi-printer"></i> Imprimir',
                            className: 'btn btn-dark btn-sm',
                            title: 'Usuarios - CabinRent',
                            exportOptions: {
                                columns: ':not(:last-child)'
                            }
                        }

                    ]

                },

                topEnd: 'search',

                bottomStart: [
                    'pageLength',
                    'info'
                ],

                bottomEnd: 'paging'

            },

            language: {

                decimal: '',

                emptyTable: 'No hay usuarios registrados',

                info: 'Mostrando _START_ a _END_ de _TOTAL_ registros',

                infoEmpty: 'Mostrando 0 a 0 de 0 registros',

                infoFiltered: '(filtrado de _MAX_ registros totales)',

                lengthMenu: 'Mostrar _MENU_ registros',

                loadingRecords: 'Cargando...',

                processing: 'Procesando...',

                search: 'Buscar:',

                searchPlaceholder: 'Buscar usuario...',

                zeroRecords: 'No se encontraron resultados',

                paginate: {

                    first: 'Primero',

                    last: 'Último',

                    next: 'Siguiente',

                    previous: 'Anterior'

                }

            },

            columnDefs: [

                {
                    targets: 6,
                    orderable: false,
                    searchable: false
                }

            ]

        });

    }

});
</script>

</body>

</html>