<?php
date_default_timezone_set('America/Caracas');
require_once 'components/utils.php';

$action = isset($_GET['action']) ? $_GET['action'] : '';

switch($action) {
    default:
        mostrarDocumentacion();
        break;
}

function mostrarDocumentacion() {
    require_once 'app/views/documentacionView.php';
}
?>
