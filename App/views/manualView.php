<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Manual de Usuario - Larense C.A.</title>
    <?php require_once 'components/links.php'; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .pdf-container {
            width: 100%;
            height: calc(100vh - 250px);
            min-height: 600px;
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
        }
        .pdf-viewer {
            width: 100%;
            height: 100%;
            border: none;
        }
        .upload-area {
            border: 2px dashed #1572E8;
            border-radius: 12px;
            padding: 40px;
            text-align: center;
            background: #f8f9fa;
            transition: all 0.3s ease;
        }
        .upload-area:hover {
            border-color: #0d5ab8;
            background: #e9ecef;
        }
        .upload-area.dragover {
            border-color: #28a745;
            background: #d4edda;
        }
        .no-pdf-message {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
            color: #6c757d;
        }
        .no-pdf-message i {
            font-size: 64px;
            margin-bottom: 20px;
            color: #dee2e6;
        }

        /* Estilos modo oscuro para manual */
        body.dark-mode {
            background: #12131d !important;
        }

        body.dark-mode .page-header-custom {
            background: #1a1f2e !important;
            border-color: #2a3041 !important;
        }

        body.dark-mode .page-header-custom h3,
        body.dark-mode .page-header-custom .fw-bold {
            color: #e7e9f0 !important;
        }

        body.dark-mode .breadcrumb-item a {
            color: #9ca3af !important;
        }

        body.dark-mode .breadcrumb-item.active {
            color: #e7e9f0 !important;
        }

        body.dark-mode .card {
            background: #1a1f2e !important;
            border-color: #2a3041 !important;
        }

        body.dark-mode .card-body {
            background: #1a1f2e !important;
        }

        body.dark-mode .pdf-container {
            background: #1a1f2e !important;
            border-color: #2a3041 !important;
        }

        body.dark-mode .no-pdf-message {
            color: #9ca3af !important;
        }

        body.dark-mode .no-pdf-message i {
            color: #3a4055 !important;
        }

        body.dark-mode .modal-content {
            background: #1a1f2e !important;
            border-color: #2a3041 !important;
        }

        body.dark-mode .modal-header {
            background: transparent !important;
            border-bottom-color: #2a3041 !important;
        }

        body.dark-mode .modal-title {
            color: #e7e9f0 !important;
        }

        body.dark-mode .modal-body {
            background: #1a1f2e !important;
        }

        body.dark-mode .upload-area {
            background: #2a3041 !important;
            border-color: #3a4055 !important;
        }

        body.dark-mode .upload-area:hover {
            background: #3a4055 !important;
            border-color: #4a5065 !important;
        }

        body.dark-mode .upload-area.dragover {
            background: #1a4a5a !important;
            border-color: #28a745 !important;
        }

        body.dark-mode .text-muted {
            color: #9ca3af !important;
        }

        body.dark-mode .alert-info {
            background: #1a4a5a !important;
            color: #6bc2d1 !important;
            border-color: #1a5a6a !important;
        }

        body.dark-mode .btn-close {
            filter: invert(1) brightness(2);
        }

        body.dark-mode .container-fluid {
            background: #12131d !important;
        }

        body.dark-mode .page-inner {
            background: #12131d !important;
        }

        body[data-background-color="dark"] {
            background: #12131d !important;
        }

        body[data-background-color="dark"] .container-fluid {
            background: #12131d !important;
        }

        body[data-background-color="dark"] .page-inner {
            background: #12131d !important;
        }

        body[data-background-color="dark"] .page-header-custom {
            background: #1a1f2e !important;
            border-color: #2a3041 !important;
        }

        body[data-background-color="dark"] .page-header-custom h3,
        body[data-background-color="dark"] .page-header-custom .fw-bold {
            color: #e7e9f0 !important;
        }

        body[data-background-color="dark"] .breadcrumb-item a {
            color: #9ca3af !important;
        }

        body[data-background-color="dark"] .breadcrumb-item.active {
            color: #e7e9f0 !important;
        }

        body[data-background-color="dark"] .card {
            background: #1a1f2e !important;
            border-color: #2a3041 !important;
        }

        body[data-background-color="dark"] .card-body {
            background: #1a1f2e !important;
        }

        body[data-background-color="dark"] .pdf-container {
            background: #1a1f2e !important;
            border-color: #2a3041 !important;
        }

        body[data-background-color="dark"] .no-pdf-message {
            color: #9ca3af !important;
        }

        body[data-background-color="dark"] .no-pdf-message i {
            color: #3a4055 !important;
        }

        body[data-background-color="dark"] .modal-content {
            background: #1a1f2e !important;
            border-color: #2a3041 !important;
        }

        body[data-background-color="dark"] .modal-header {
            background: transparent !important;
            border-bottom-color: #2a3041 !important;
        }

        body[data-background-color="dark"] .modal-title {
            color: #e7e9f0 !important;
        }

        body[data-background-color="dark"] .modal-body {
            background: #1a1f2e !important;
        }

        body[data-background-color="dark"] .upload-area {
            background: #2a3041 !important;
            border-color: #3a4055 !important;
        }

        body[data-background-color="dark"] .upload-area:hover {
            background: #3a4055 !important;
            border-color: #4a5065 !important;
        }

        body[data-background-color="dark"] .upload-area.dragover {
            background: #1a4a5a !important;
            border-color: #28a745 !important;
        }

        body[data-background-color="dark"] .text-muted {
            color: #9ca3af !important;
        }

        body[data-background-color="dark"] .alert-info {
            background: #1a4a5a !important;
            color: #6bc2d1 !important;
            border-color: #1a5a6a !important;
        }

        body[data-background-color="dark"] .btn-close {
            filter: invert(1) brightness(2);
        }
    </style>
</head>
<body>
    <?php require_once 'components/menu.php'; ?>
    <?php require_once 'components/header.php'; ?>

    <div style="padding-top: 120px;"></div>

    <div class="container-fluid px-4">
        <div class="page-inner">
            
            <!-- Header de pagina -->
            <div class="page-header-custom mb-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <div class="icon-circle me-3" style="background: linear-gradient(135deg, #1572E8 0%, #0d5ab8 100%); width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fa fa-book-open" style="color: white; font-size: 20px;"></i>
                        </div>
                        <div>
                            <h3 class="fw-bold mb-0" style="color: #333;">Manual de Usuario</h3>
                            <nav aria-label="breadcrumb" class="mt-1">
                                <ol class="breadcrumb mb-0" style="background: none; padding: 0;">
                                    <li class="breadcrumb-item"><a href="index.php?url=dashboard" style="color: #1572E8;"><i class="icon-home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="index.php?url=dashboard" style="color: #666;">Dashboard</a></li>
                                    <li class="breadcrumb-item active" style="color: #333;">Manual de Usuario</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Visor de PDF -->
            <div class="card shadow border-0" style="border-radius: 12px; overflow: hidden;">
                <div class="card-body p-0">
                    <div class="pdf-container">
                        <?php if (file_exists('storage/manuales/manual_usuario.pdf')): ?>
                            <iframe src="storage/manuales/manual_usuario.pdf" class="pdf-viewer" title="Manual de Usuario PDF"></iframe>
                        <?php else: ?>
                            <div class="no-pdf-message">
                                <i class="fa fa-file-pdf"></i>
                                <h4>No hay PDF cargado</h4>
                                <p class="mb-3">Aún no se ha subido ningún manual de usuario.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Modal para subir PDF -->
    <div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 12px; border: none;">
                <div class="modal-header" style="background: linear-gradient(135deg, #1572E8 0%, #0d5ab8 100%); border: none;">
                    <h5 class="modal-title" id="uploadModalLabel" style="color: white; font-weight: 600;">
                        <i class="fa fa-upload me-2"></i>Subir Manual de Usuario
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form id="uploadForm" enctype="multipart/form-data">
                        <div class="upload-area" id="dropZone">
                            <i class="fa fa-cloud-upload-alt" style="font-size: 48px; color: #1572E8; margin-bottom: 15px;"></i>
                            <h5>Arrastra y suelta tu PDF aquí</h5>
                            <p class="text-muted mb-3">o</p>
                            <input type="file" name="pdf" id="pdfInput" accept=".pdf" style="display: none;">
                            <button type="button" class="btn btn-outline-primary" onclick="document.getElementById('pdfInput').click()">
                                <i class="fa fa-folder-open me-2"></i>Seleccionar archivo
                            </button>
                            <p class="text-muted mt-3 mb-0" style="font-size: 12px;">
                                <i class="fa fa-info-circle me-1"></i>Tamaño máximo: 50MB
                            </p>
                            <p class="text-muted mb-0" style="font-size: 12px;">
                                <i class="fa fa-file-pdf me-1 text-danger"></i>Solo archivos PDF
                            </p>
                        </div>
                        <div id="fileInfo" class="mt-3 text-center" style="display: none;">
                            <div class="alert alert-info">
                                <i class="fa fa-file-pdf text-danger me-2"></i>
                                <span id="fileName"></span>
                                <span id="fileSize" class="text-muted ms-2"></span>
                            </div>
                        </div>
                        <div id="uploadProgress" class="mt-3" style="display: none;">
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 100%"></div>
                            </div>
                            <p class="text-center mt-2 text-muted">Subiendo archivo...</p>
                        </div>
                    </form>
                </div>
                <div class="modal-footer" style="border: none;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="btnSubir" onclick="subirPDF()" disabled>
                        <i class="fa fa-upload me-2"></i>Subir PDF
                    </button>
                </div>
            </div>
        </div>
    </div>

    <?php require_once 'components/scripts.php'; ?>
    
    <script>
        const dropZone = document.getElementById('dropZone');
        const pdfInput = document.getElementById('pdfInput');
        const fileInfo = document.getElementById('fileInfo');
        const fileName = document.getElementById('fileName');
        const fileSize = document.getElementById('fileSize');
        const btnSubir = document.getElementById('btnSubir');
        const uploadModal = document.getElementById('uploadModal');

        // Drag and drop
        dropZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropZone.classList.add('dragover');
        });

        dropZone.addEventListener('dragleave', () => {
            dropZone.classList.remove('dragover');
        });

        dropZone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropZone.classList.remove('dragover');
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                handleFile(files[0]);
            }
        });

        // File input change
        pdfInput.addEventListener('change', (e) => {
            if (e.target.files.length > 0) {
                handleFile(e.target.files[0]);
            }
        });

        function handleFile(file) {
            if (file.type !== 'application/pdf') {
                alert('Por favor, selecciona un archivo PDF válido.');
                return;
            }
            if (file.size > 50 * 1024 * 1024) {
                alert('El archivo excede el tamaño máximo permitido (50MB).');
                return;
            }

            fileName.textContent = file.name;
            fileSize.textContent = '(' + formatFileSize(file.size) + ')';
            fileInfo.style.display = 'block';
            btnSubir.disabled = false;

            // Crear DataTransfer para asignar al input
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);
            pdfInput.files = dataTransfer.files;
        }

        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }

        function subirPDF() {
            const formData = new FormData(document.getElementById('uploadForm'));
            const progressDiv = document.getElementById('uploadProgress');
            
            progressDiv.style.display = 'block';
            btnSubir.disabled = true;

            fetch('index.php?url=manual&action=subir', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                progressDiv.style.display = 'none';
                if (data.success) {
                    // Cerrar modal y recargar página
                    const modal = bootstrap.Modal.getInstance(uploadModal);
                    modal.hide();
                    alert('PDF subido exitosamente');
                    location.reload();
                } else {
                    alert('Error: ' + data.message);
                    btnSubir.disabled = false;
                }
            })
            .catch(error => {
                progressDiv.style.display = 'none';
                alert('Error al subir el archivo');
                btnSubir.disabled = false;
                console.error('Error:', error);
            });
        }

        // Reset form when modal closes
        uploadModal.addEventListener('hidden.bs.modal', function () {
            document.getElementById('uploadForm').reset();
            fileInfo.style.display = 'none';
            btnSubir.disabled = true;
        });
    </script>
</body>
</html>
