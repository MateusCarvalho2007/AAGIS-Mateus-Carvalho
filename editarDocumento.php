<?php
require_once __DIR__ . "/classes/Documento.php";

if (!isset($_GET['idDocumento'])) {
    die("Documento inválido.");
}

$idEstagio = isset($_GET['idEstagio']) ? intval($_GET['idEstagio']) : 0;
require_once __DIR__ . '/classes/Estagio.php';

$estagio = Estagio::find($idEstagio);
$idDocumento = intval($_GET['idDocumento']);
$documento = Documento::find($idDocumento);

if (!$documento) {
    die("Documento não encontrado.");
}

// PROCESSAR POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $documento->setNome(trim($_POST['nome']));
    if($documento->getPrazo() != null){
        $documento->setPrazo($_POST['prazo']);
    }

    $arquivo = $documento->getArquivo();
    if ($arquivo === null || $arquivo === '' || empty($arquivo)) {
        $documento->setDataEnvio(null);
    }

    if ($documento->update()) {
        header("Location: AnexarDoc.php?idEstagio={$documento->getIdEstagio()}&idDocumento={$documento->getIdDocumento()}");
        exit;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <meta charset="UTF-8">
    <link rel="stylesheet" href="styles/cadastro.css">
    <title>Editar Documento</title>
</head>
<body>

<h1>Editar Documento</h1>

<form action="" method="POST" enctype="multipart/form-data">

    <label>Nome:</label><br>
    <input type="text" name="nome" value="<?= htmlspecialchars($documento->getNome()) ?>" required><br><br>

    <?php if($documento->getPrazo() != null):?>
    <label>Prazo:</label><br>
    <input type="date" name="prazo" value="<?= htmlspecialchars($documento->getPrazo()) ?>"><br><br>
    <?php endif;?>

    <button type="submit">Salvar</button>
    <a href="AnexarDoc.php?idEstagio=<?php echo $idEstagio; ?>&idDocumento=<?php echo $documento->getIdDocumento(); ?>" style="background-color: #6c757d; color: #fff; padding: 0.75rem 1.5rem; font-weight: bold; border: none; border-radius: 6px; cursor: pointer; text-decoration: none; display: inline-block; text-align: center; transition: all 0.3s ease;">Voltar</a>

</form>

</body>
</html>
