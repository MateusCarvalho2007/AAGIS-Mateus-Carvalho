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
    <link rel="stylesheet" href="styleListagem.css">
</head>
<body>
    <div class="header">
        <div class="header-content">
            <h1>Lista de Estágios</h1>
            <?php if (isset($_SESSION['nome'])): ?>
                <div class="user-info">
                    <span class="welcome-message">
                        Bem-vindo(a), <strong><?= htmlspecialchars($_SESSION['nome']) ?></strong>
                    </span>
                    <a href="logout.php" class="logout-btn">Sair</a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="container">
        <a href="cadastro.php" class="cadastro-link">Cadastrar novo estágio</a>
        
        <table>
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
                    <td class="aluno"><?= htmlspecialchars($estagio->getName()) ?></td>
                    <td class="empresa"><?= htmlspecialchars($estagio->getEmpresa()) ?></td>
                    <td class="periodo"><?= htmlspecialchars($estagio->getDataInicio()) ?> - <?= htmlspecialchars($estagio->getDataFim()) ?></td>
                    <td>
                        <?php
                            $s = $estagio->getStatus();
                            if($s == \Estagio::STATUS_FINALIZADO){
                                echo '<span class="status-finalizado">Finalizado</span>';
                            } elseif($s == \Estagio::STATUS_ATIVO){
                                echo '<span class="status-ativo">Ativo</span>';
                            } else {
                                echo '<span class="status-andamento">Em andamento</span>';
                            }
                        ?>
                    </td>
                    <td>
                        <div class="action-links">
                            <?php if($estagio->isFinalizado()): ?>
                                <span class="estagio-finalizado">Estágio finalizado</span>
                            <?php else: ?>
                                <a href="editar.php?idEstagio=<?= $estagio->getIdEstagio() ?>" class="action-link">Editar</a>
                                <a href="vizualizacao.php?idEstagio=<?= $estagio->getIdEstagio() ?>" class="action-link">Visualizar</a>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
