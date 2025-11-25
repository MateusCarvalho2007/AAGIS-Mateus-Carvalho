<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['idUsuario'])) {
    header("Location: index.php");
    exit;
}

$idEstagio = $_GET['idEstagio'] ?? 0;
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Anexar Documento - AAGIS</title>
    <link rel="stylesheet" href="styles/cadastro.css">
    <style>
        /* Estilos específicos para a página de anexar documento */
        .file-upload-container {
            margin-bottom: 1.5rem;
        }
        
        .drop-container {
            border: 2px dashed #007bff;
            padding: 2rem;
            border-radius: 8px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            background: #f8f9fa;
            margin-bottom: 1rem;
        }
        
        .drop-container:hover {
            border-color: #0056b3;
            background: #e3f2fd;
        }
        
        .drop-container.drag-active {
            border-color: #0056b3;
            background: #e3f2fd;
            transform: scale(1.02);
        }
        
        .drop-icon {
            font-size: 3rem;
            color: #007bff;
            margin-bottom: 1rem;
        }
        
        .drop-text h3 {
            color: #333;
            margin-bottom: 0.5rem;
            font-weight: 600;
        }
        
        .drop-text p {
            color: #666;
            margin-bottom: 1rem;
            background: none;
            box-shadow: none;
            padding: 0;
        }
        
        .btn-browse {
            background: #007bff;
            color: white;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
            transition: all 0.3s ease;
            display: inline-block;
        }
        
        .btn-browse:hover {
            background: #0056b3;
            transform: translateY(-2px);
        }
        
        input[type="file"] {
            display: none;
        }
        
        .file-info {
            margin-top: 1rem;
            padding: 1rem;
            background: #e7f3ff;
            border-radius: 6px;
            border-left: 4px solid #007bff;
            animation: fadeIn 0.5s ease-in-out;
        }
        
        .file-info.hidden {
            display: none;
        }
        
        .file-name {
            font-weight: bold;
            color: #333;
            margin-bottom: 0.5rem;
        }
        
        .file-size {
            color: #666;
            font-size: 0.9rem;
        }
        
        .file-types {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-top: 1rem;
            justify-content: center;
        }
        
        .file-type {
            background: #007bff;
            color: white;
            padding: 0.3rem 0.8rem;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: 500;
        }
        
        .form-actions {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
            flex-wrap: wrap;
            justify-content: center;
        }
        
        .btn-cancel {
            background-color: #6c757d;
            color: #fff;
            padding: 0.9rem 2rem;
            font-weight: bold;
            font-size: 1rem;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }
        
        .btn-cancel:hover {
            background-color: #5a6268;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(108, 117, 125, 0.3);
            color: #fff;
        }
        
        /* Ajustes para mensagens */
        .message-container {
            max-width: 600px;
            margin: 1rem auto;
        }
        
        /* Animações */
        @keyframes pulse {
            0%, 100% {
                box-shadow: 0 0 0 rgba(0, 123, 255, 0.4);
            }
            50% {
                box-shadow: 0 0 0 10px rgba(0, 123, 255, 0);
            }
        }
        
        .pulse {
            animation: pulse 2s infinite;
        }

        /* Ajuste do botão voltar */
        .back-button-container {
            text-align: center;
            margin-top: 1rem;
        }

        .info-label {
            font-weight: 600;
            color: #333;
            margin-bottom: 0.5rem;
            display: block;
        }

        .info-value {
            color: #666;
            margin-bottom: 1.5rem;
            padding: 0.5rem;
            background: #f8f9fa;
            border-radius: 5px;
            border-left: 3px solid #007bff;
        }
    </style>
</head>
<body>
    <h1>Anexar Documento</h1>

    <form action="#" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <h1 style="color: black;">Nome do Documento</h1>
        </div>
        
        <div class="form-group">
            <label class="info-label">Vencimento</label>
            <div class="info-value">quinta, 6 nov 2025, 15:00</div>
        </div>
        
        <div class="form-group">
            <label class="info-label">Status de Envio</label>
            <div class="info-value">Enviado para avaliação</div>
        </div>
        
        <div class="form-group">
            <label class="info-label">Dias Restantes</label>
            <div class="info-value">A tarefa foi enviada 37 minutos 58 segundos adiantado</div>
        </div>
        
        <div class="form-group">
            <label class="info-label">Comentários</label>
            <div class="info-value">Comentários (0)</div>
        </div>
        
        <div class="form-group file-upload-container">
            <label class="info-label">Documento</label>
            <div class="drop-container" id="dropcontainer">
                <div class="drop-icon">📄</div>
                <div class="drop-text">
                    <h3>Arraste e solte seu arquivo aqui</h3>
                    <p>ou</p>
                </div>
                <button type="button" class="btn-browse pulse" onclick="document.getElementById('documento').click()">
                    Selecione um arquivo
                </button>
                <div class="file-types">
                    <span class="file-type">PDF</span>
                    <span class="file-type">DOC</span>
                    <span class="file-type">DOCX</span>
                    <span class="file-type">TXT</span>
                    <span class="file-type">ODT</span>
                    <span class="file-type">RTF</span>
                </div>
                <input type="file" id="documento" name="documento" accept=".pdf,.doc,.docx,.txt,.odt,.rtf">
            </div>
            <div class="file-info hidden" id="fileInfo">
                <div class="file-name" id="fileName"></div>
                <div class="file-size" id="fileSize"></div>
            </div>
        </div>
        
        <div class="form-actions">
            <button type="submit">Anexar Documento</button>
        </div>

        <div class="back-button-container">
            <a href="listagemDoc.php?idEstagio=<?php echo $idEstagio; ?>" class="btn-cancel">Voltar</a>
        </div>
    </form>

    <script>
        // Elementos DOM
        const dropContainer = document.getElementById('dropcontainer');
        const fileInput = document.getElementById('documento');
        const fileInfo = document.getElementById('fileInfo');
        const fileName = document.getElementById('fileName');
        const fileSize = document.getElementById('fileSize');
        const browseBtn = document.querySelector('.btn-browse');
        
        // Prevenir comportamento padrão de drag and drop
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropContainer.addEventListener(eventName, preventDefaults, false);
            document.body.addEventListener(eventName, preventDefaults, false);
        });
        
        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }
        
        // Efeitos visuais para drag and drop
        ['dragenter', 'dragover'].forEach(eventName => {
            dropContainer.addEventListener(eventName, highlight, false);
        });
        
        ['dragleave', 'drop'].forEach(eventName => {
            dropContainer.addEventListener(eventName, unhighlight, false);
        });
        
        function highlight() {
            dropContainer.classList.add('drag-active');
            browseBtn.classList.remove('pulse');
        }
        
        function unhighlight() {
            dropContainer.classList.remove('drag-active');
        }
        
        // Manipular arquivos soltos
        dropContainer.addEventListener('drop', handleDrop, false);
        
        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            
            if (files.length) {
                fileInput.files = files;
                updateFileInfo(files[0]);
                browseBtn.classList.remove('pulse');
            }
        }
        
        // Manipular seleção de arquivo via botão
        fileInput.addEventListener('change', function() {
            if (this.files.length) {
                updateFileInfo(this.files[0]);
                browseBtn.classList.remove('pulse');
            }
        });
        
        // Atualizar informações do arquivo selecionado
        function updateFileInfo(file) {
            fileName.textContent = file.name;
            fileSize.textContent = formatFileSize(file.size);
            fileInfo.classList.remove('hidden');
        }
        
        // Formatar tamanho do arquivo
        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }
        
        // Validação do formulário
        document.querySelector('form').addEventListener('submit', function(e) {
            const file = fileInput.files[0];
            if (!file) {
                e.preventDefault();
                alert('Por favor, selecione um arquivo para upload.');
                return;
            }
            
            // Validar extensão do arquivo
            const allowedExtensions = ['.pdf', '.doc', '.docx', '.txt', '.odt', '.rtf'];
            const fileExtension = '.' + file.name.split('.').pop().toLowerCase();
            
            if (!allowedExtensions.includes(fileExtension)) {
                e.preventDefault();
                alert('Tipo de arquivo não permitido. Por favor, selecione um arquivo PDF, DOC, DOCX, TXT, ODT ou RTF.');
                return;
            }
            
            // Validar tamanho do arquivo (máximo 10MB)
            const maxSize = 10 * 1024 * 1024; // 10MB em bytes
            if (file.size > maxSize) {
                e.preventDefault();
                alert('O arquivo é muito grande. O tamanho máximo permitido é 10MB.');
                return;
            }
            
            // Simular envio (sem backend)
            e.preventDefault();
            alert('Documento selecionado: ' + file.name + '\nTamanho: ' + formatFileSize(file.size) + '\n\nFuncionalidade de upload seria processada aqui.');
        });
    </script>
</body>
</html>