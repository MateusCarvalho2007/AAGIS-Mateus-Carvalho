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
    <title>Upload de Imagens</title>
    <style>
        body{font-family: Arial, sans-serif;display:flex;align-items:center;justify-content:center;height:100vh;margin:0;background:#f5f5f5}
        .card{background:#fff;padding:24px;border-radius:8px;box-shadow:0 4px 12px rgba(0,0,0,0.08);width:420px;text-align:center}
        .drop-container{border:2px dashed #bbb;padding:28px;border-radius:8px;cursor:pointer}
        .drop-container.drag-active{border-color:#007bff;background:#f0f8ff}
        input[type="file"]{display:none}
        .btn{margin-top:12px;padding:10px 16px;border:none;border-radius:6px;background:#007bff;color:#fff;cursor:pointer}
        .msg{margin-top:12px;color:green}
        .err{margin-top:12px;color:#c00}
    </style>
</head>
<body>
    <div class="card">
        <h2>Enviar imagens</h2>

        <?php if ($message): ?>
            <div class="msg"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="err"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form action="AnexarDoc.php" method="POST" enctype="multipart/form-data">
            <label for="images" class="drop-container" id="dropcontainer">
                <span class="drop-title">Arraste as imagens para cá</span>
                <br>ou<br>
                <span style="color:#007bff;cursor:pointer;text-decoration:underline">Escolher arquivos</span>
                <input type="file" id="images" name="images[]" accept="image/*" multiple required>
            </label>

            <button type="submit" class="btn">Enviar</button>
        </form>
    </div>

    <script>
        const dropContainer = document.getElementById("dropcontainer");
        const fileInput = document.getElementById("images");

        dropContainer.addEventListener("dragover", (e) => {
            e.preventDefault();
        });

        dropContainer.addEventListener("dragenter", () => {
            dropContainer.classList.add("drag-active");
        });

        dropContainer.addEventListener("dragleave", () => {
            dropContainer.classList.remove("drag-active");
        });

        dropContainer.addEventListener("drop", (e) => {
            e.preventDefault();
            dropContainer.classList.remove("drag-active");
            fileInput.files = e.dataTransfer.files;
        });

        // abrir diálogo de arquivos ao clicar na área
        dropContainer.addEventListener("click", () => {
            fileInput.click();
        });
    </script>
</body>
</html>
