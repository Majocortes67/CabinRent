<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php

if(isset($_SESSION["mensaje"])){

?>

<script>

Swal.fire({

    icon:'success',

    title:'Éxito',

    text:'<?= $_SESSION["mensaje"]; ?>',

    confirmButtonColor:'#2F5D50'

});

</script>

<?php

unset($_SESSION["mensaje"]);

}

?>

</body>

</html>