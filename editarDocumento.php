<?php
require_once _DIR_ . "/classes/Documento.php";
if (!isset($_GET['idDocumento'])) {
    exit;
}
$idDocumento = intval($_GET['idDocumento']);
$documento = Documento::find($idDocumento);
if (!$documento) {
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $documento->setNome(trim($_POST['nome']));
    $documento->setTipo(trim($_POST['tipo']));
    $documento->setPrazo($_POST['prazo']);
    $documento->setStatus($_POST['status']);
    if (isset($_FILES['arquivo']) && $_FILES['arquivo']['error'] === 0) {
        $nomeArquivo = basename($_FILES['arquivo']['name']);
        $ext = strtolower(pathinfo($nomeArquivo, PATHINFO_EXTENSION));
        if ($ext !== 'pdf') {
            echo "<p style='color:red;'>Apenas arquivos PDF são permitidos.</p>";
        } else {
            $destino = _DIR_ . "/uploads/" . $nomeArquivo;
            if (move_uploaded_file($_FILES['arquivo']['tmp_name'], $destino)) {
                $documento->setArquivo($nomeArquivo);
            } else {
                echo "<p style='color:red;'>Erro ao enviar novo arquivo.</p>";
            }
        }
    }
    if ($documento->update()) {
        echo "<p style='color:green;'>Documento atualizado com sucesso!</p>";
        echo "<a href='listagem.php?idEstagio=" . $documento->getIdEstagio() . "'>Voltar à lista</a>";
        exit;
    } else {
        echo "<p style='color:red;'>Erro ao atualizar o documento.</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>Editar Documento</h2>

<form action="" method="POST" enctype="multipart/form-data">
    <label>Nome:</label><br>
    <input type="text" name="nome" value="<?= htmlspecialchars($documento->getNome()) ?>" required><br><br>

    <label>Tipo:</label><br>
    <input type="text" name="tipo" value="<?= htmlspecialchars($documento->getTipo()) ?>" required><br><br>

    <label>Prazo:</label><br>
    <input type="date" name="prazo" value="<?= htmlspecialchars($documento->getPrazo()) ?>"><br><br>

    <label>Status:</label><br>
    <select name="status" required>
        <?php
        $statusList = [
            Documento::STATUS_PENDENTE,
            Documento::STATUS_ENVIADO,
            Documento::STATUS_CONCLUIDO,
            Documento::STATUS_ATRASADO
        ];
        foreach ($statusList as $s) {
            $selected = ($documento->getStatus() === $s) ? 'selected' : '';
            echo "<option value='$s' $selected>$s</option>";
        }
        ?>
    </select><br><br>

    <label>Arquivo atual:</label><br>
    <?php if ($documento->getArquivo()): ?>
        <a href="uploads/<?= htmlspecialchars($documento->getArquivo()) ?>" target="_blank">
            <?= htmlspecialchars($documento->getArquivo()) ?>
        </a><br><br>
    <?php else: ?>
        <p>Nenhum arquivo enviado.</p>
    <?php endif; ?>

    <button type="submit">Salvar Alterações</button>
    <a href="listagem.php?idEstagio=<?= $documento->getIdEstagio() ?>">Cancelar</a>
</form>
</body>
</html>
