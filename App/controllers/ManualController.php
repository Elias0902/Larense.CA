<?php
date_default_timezone_set('America/Caracas');
require_once 'components/utils.php';

$action = isset($_GET['action']) ? $_GET['action'] : '';

switch($action) {
    case 'subir':
        subirPDF();
        break;
    default:
        mostrarManual();
        break;
}

function mostrarManual() {
    require_once 'app/views/manualView.php';
}

function subirPDF() {
    $response = ['success' => false, 'message' => ''];
    
    if (isset($_FILES['pdf']) && $_FILES['pdf']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['pdf']['tmp_name'];
        $fileName = $_FILES['pdf']['name'];
        $fileSize = $_FILES['pdf']['size'];
        $fileType = $_FILES['pdf']['type'];
        
        // Validar que sea PDF
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        if ($fileExtension !== 'pdf') {
            $response['message'] = 'El archivo debe ser un PDF';
            echo json_encode($response);
            return;
        }
        
        // Validar tamaño máximo (50MB)
        $maxSize = 50 * 1024 * 1024; // 50MB
        if ($fileSize > $maxSize) {
            $response['message'] = 'El archivo excede el tamaño máximo permitido (50MB)';
            echo json_encode($response);
            return;
        }
        
        // Directorio de upload
        $uploadDir = 'storage/manuales/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        // Nombre único
        $newFileName = 'manual_usuario.pdf';
        $destPath = $uploadDir . $newFileName;
        
        // Mover archivo
        if (move_uploaded_file($fileTmpPath, $destPath)) {
            $response['success'] = true;
            $response['message'] = 'PDF subido exitosamente';
            $response['file_path'] = $destPath;
        } else {
            $response['message'] = 'Error al guardar el archivo';
        }
    } else {
        $response['message'] = 'No se recibió ningún archivo o hubo un error en la subida';
    }
    
    echo json_encode($response);
}
?>
