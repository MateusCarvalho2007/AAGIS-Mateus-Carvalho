<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['idAluno'])) {
    header("Location: login.php");
    exit;
}

if(isset($_GET['idEstagio'])){
     require_once __DIR__.'/classes/Estagio.php';
     Estagio::mudarStatus($_GET['idEstagio']);
}

require_once __DIR__.'/classes/Estagio.php';
$estagios = Estagio::findall();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listagem de Estágios</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div style="background-color: #f8f9fa; padding: 10px; margin-bottom: 20px;">
        <div style="display: flex; justify-content: space-between; align-items: center; max-width: 1200px; margin: 0 auto;">
            <h1 style="margin: 0;">Lista de Estágios</h1>
            <?php if (isset($_SESSION['nome'])): ?>
                <div style="display: flex; align-items: center;">
                    <span style="margin-right: 15px;">
                        Bem-vindo(a), <strong><?= htmlspecialchars($_SESSION['nome']) ?></strong>
                    </span>
                    <a href="logout.php" style="
                        background-color: #dc3545;
                        color: white;
                        padding: 8px 15px;
                        text-decoration: none;
                        border-radius: 4px;
                        font-size: 14px;">Sair</a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <a href="cadastro.php">Cadastrar novo estágio</a>
    <br>
    <br>
    <table border="1" cellpadding="6" cellspacing="0">
        <thead>
            <tr>
                <th>Aluno</th>
                <th>Empresa</th>
                <th>Período</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($estagios as $estagio): ?>
            <tr>
                <td><?= htmlspecialchars($estagio->getIdEstagio()) ?></td>
                <td><?= htmlspecialchars($estagio->getName()) ?></td>
                <td><?= htmlspecialchars($estagio->getEmpresa()) ?></td>
                <td><?= htmlspecialchars($estagio->getDataInicio()) ?> - <?= htmlspecialchars($estagio->getDataFim()) ?></td>
                <td>
                    <?php
                        $s = $estagio->getStatus();
                        if($s == \Estagio::STATUS_FINALIZADO){
                            echo 'Finalizado';
                        } elseif($s == \Estagio::STATUS_ATIVO){
                            echo 'Ativo';
                        } else {
                            echo 'Em andamento';
                        }
                    ?>
                </td>
                <td>
                    <?php if($estagio->isFinalizado()): ?>
                        <span style="color:red">Estágio Finalizado</span>
                    <?php else: ?>
                        <a href="editar.php?idEstagio=<?= $estagio->getIdEstagio() ?>">Editar</a>
                        |
                        <a href="vizualizacao.php?idEstagio=<?= $estagio->getIdEstagio() ?>">Visualizar</a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <br>
</body>
</html>
