<?php
if (isset($_SESSION['message']) && isset($_SESSION['message_type'])) {
    $message = is_array($_SESSION['message']) ? 'Error en datos' : (string)$_SESSION['message'];
    $message_type = (string)$_SESSION['message_type'];

    $js_message = htmlspecialchars($message, ENT_QUOTES, 'UTF-8');
    $js_message_type = htmlspecialchars($message_type, ENT_QUOTES, 'UTF-8');

    echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: '" . ($js_message_type === 'success' ? 'success' : 'error') . "',
                title: '" . ($js_message_type === 'success' ? '¡Exitoso!' : '¡Error!') . "',
                text: '{$js_message}',
                confirmButtonText: 'Cerrar',
                timer: 6000,
                timerProgressBar: true,
            });
        });
    </script>";

    unset($_SESSION['message']);
    unset($_SESSION['message_type']);
}
?>
