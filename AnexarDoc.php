<?php
// ...existing code...
    
require __DIR__ . "/vendor/autoload.php";

use Src\Exceptions\Infrastructure\UploadException;
use Src\Models\Uploader;

$error = '';
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['images']) && count(array_filter($_FILES['images']['name'])) > 0) {
        try {
            $saved = Uploader::uploadImages($_FILES['images']);
            $count = is_array($saved) ? count($saved) : 1;
            $message = "Upload concluído: {$count} arquivo(s) enviados com sucesso.";
        } catch (UploadException $e) {
            $error = $e->getMessage();
        } catch (Exception $e) {
            $error = 'Ocorreu um erro no upload.';
        }
    } else {
        $error = 'Nenhuma imagem selecionada. Selecione pelo menos uma imagem.';
    }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Task - Post your text here!</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f5f5f5;
            color: #333;
            line-height: 1.6;
            padding: 20px;
            display: flex;
            justify-content: center;
            min-height: 100vh;
        }
        
        .container {
            width: 100%;
            max-width: 800px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        .header {
            padding: 20px;
            border-bottom: 1px solid #e0e0e0;
        }
        
        .header h1 {
            font-size: 24px;
            margin-bottom: 10px;
            color: #333;
        }
        
        .task-info {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-bottom: 10px;
            font-size: 14px;
        }
        
        .task-info div {
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        .status {
            display: flex;
            align-items: center;
            gap: 5px;
            color: #4CAF50;
            font-weight: bold;
        }
        
        .status::before {
            content: "✔";
            color: #4CAF50;
        }
        
        hr {
            border: none;
            border-top: 1px solid #e0e0e0;
            margin: 20px 0;
        }
        
        .submission-status {
            padding: 20px;
        }
        
        .submission-status h2 {
            font-size: 18px;
            margin-bottom: 15px;
            color: #333;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        table td {
            padding: 12px 10px;
            border-bottom: 1px solid #e0e0e0;
            vertical-align: top;
        }
        
        table td:first-child {
            font-weight: bold;
            width: 30%;
        }
        
        .file-submission {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        
        .file-item {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px;
            background-color: #f9f9f9;
            border-radius: 4px;
        }
        
        .file-icon {
            font-size: 20px;
        }
        
        .file-details {
            display: flex;
            flex-direction: column;
        }
        
        .file-name {
            font-weight: bold;
        }
        
        .file-date {
            font-size: 12px;
            color: #666;
        }
        
        .comments {
            padding: 20px;
        }
        
        .comments h3 {
            font-size: 16px;
            margin-bottom: 10px;
            color: #333;
        }
        
        .comments label {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
        }
        
        .comments input[type="checkbox"] {
            width: 18px;
            height: 18px;
        }
        
        .buttons {
            padding: 20px;
            display: flex;
            gap: 10px;
        }
        
        .btn {
            padding: 10px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.2s;
        }
        
        .btn-edit {
            background-color: #007bff;
            color: white;
        }
        
        .btn-edit:hover {
            background-color: #0069d9;
        }
        
        .btn-remove {
            background-color: #dc3545;
            color: white;
        }
        
        .btn-remove:hover {
            background-color: #c82333;
        }
        
        .upload-section {
            padding: 20px;
            border-top: 1px solid #e0e0e0;
            background-color: #f9f9f9;
        }
        
        .upload-section h2 {
            font-size: 18px;
            margin-bottom: 15px;
            color: #333;
        }
        
        .card {
            background: #fff;
            padding: 24px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            text-align: center;
        }
        
        .drop-container {
            border: 2px dashed #bbb;
            padding: 28px;
            border-radius: 8px;
            cursor: pointer;
            margin-bottom: 15px;
            transition: all 0.3s;
        }
        
        .drop-container:hover {
            border-color: #007bff;
            background: #f0f8ff;
        }
        
        .drop-container.drag-active {
            border-color: #007bff;
            background: #f0f8ff;
        }
        
        input[type="file"] {
            display: none;
        }
        
        .btn-upload {
            margin-top: 12px;
            padding: 10px 16px;
            border: none;
            border-radius: 6px;
            background: #007bff;
            color: #fff;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.2s;
        }
        
        .btn-upload:hover {
            background: #0069d9;
        }
        
        .msg {
            margin-top: 12px;
            color: green;
            padding: 10px;
            background-color: #f0fff0;
            border-radius: 4px;
            border-left: 4px solid #4CAF50;
        }
        
        .err {
            margin-top: 12px;
            color: #c00;
            padding: 10px;
            background-color: #fff0f0;
            border-radius: 4px;
            border-left: 4px solid #dc3545;
        }
        
        .file-actions {
            margin-left: auto;
            display: flex;
            gap: 8px;
        }
        
        .file-action-btn {
            background: none;
            border: none;
            cursor: pointer;
            color: #666;
            font-size: 14px;
        }
        
        .file-action-btn:hover {
            color: #333;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Nome Documento</h1>
            
            <div class="task-info">
                <div><strong>Aberto:</strong> quinta, 6 nov 2025, 00:00</div>
                <div><strong>Vencimento:</strong> quinta, 6 nov 2025, 15:00</div>
            </div>
            
        </div>
        
        <div class="submission-status">
            
            <table>
                <tr>
                    <td>Status de envio</td>
                    <td>Enviado para avaliação</td>
                </tr>
                <tr>
                    <td>Status da avaliação</td>
                    <td>Não há notas</td>
                </tr>
                <tr>
                    <td>Tempo restante</td>
                    <td>A tarefa foi enviada 37 minutos 58 segundos adiantado</td>
                </tr>
                <tr>
                    <td>Última modificação</td>
                    <td>quinta, 6 nov 2025, 14:22</td>
                </tr>
                <tr>
                    <td>Envios de arquivo</td>
                    <td><form action="AnexarDoc.php" method="POST" enctype="multipart/form-data">
            <label for="images" class="drop-container" id="dropcontainer">
                <span style="color:#007bff;cursor:pointer">Escolher arquivos</span>
                <input type="file" id="images" name="images[]" accept="/*" multiple required>
            </label>

            <button type="submit" class="btn">Enviar</button>
        </form>
    </form></td>

    <div><a href="listagemDoc.php">Voltar</a></div>
    <br>

            
            
            