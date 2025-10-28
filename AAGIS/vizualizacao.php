<?php
require_once __DIR__ . '/classes/Estagio.php';

// Ativa a exibição de erros
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$id = (int)$_GET['idEstagio'];

try {
    $estagio = Estagio::find($id);
    
    // Se não encontrou o estágio
    if (!$estagio->getIdEstagio()) {
        die("Erro: Estágio não encontrado com o ID: " . $id);
    }
} catch (Exception $e) {
    die("Erro ao buscar estágio: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Visualização de Estágios</title>
    <link rel="stylesheet" href="styleVizualização.css">
</head>
<body>
    <h1>Informações do Estágio</h1>
    
    <div class="container">
        <table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Empresa</th>
                    <th>Setor</th>
                    <th>Início</th>
                    <th>Fim</th>
                    <th>Supervisor</th>
                    <th>Email Supervisor</th>
                    <th>Professor</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="empresa-info"><?= htmlspecialchars($estagio->getName()) ?></td>
                    <td class="empresa-info"><?= htmlspecialchars($estagio->getEmpresa()) ?></td>
                    <td><?= htmlspecialchars($estagio->getSetorEmpresa()) ?></td>
                    <td class="data-info"><?= htmlspecialchars($estagio->getDataInicio()) ?></td>
                    <td class="data-info"><?= htmlspecialchars($estagio->getDataFim()) ?></td>
                    <td class="supervisor-info"><?= htmlspecialchars($estagio->getNameSupervisor()) ?></td>
                    <td class="email-info"><?= htmlspecialchars($estagio->getEmailSupervisor()) ?></td>
                    <td class="supervisor-info"><?= htmlspecialchars($estagio->getProfessor()) ?></td>
                    <td>
                        <?php 
                            $status = $estagio->getStatus();
                            if ($status == Estagio::STATUS_FINALIZADO) {
                                echo '<span class="status-finalizado">Finalizado</span>';
                            } elseif ($status == Estagio::STATUS_ATIVO) {
                                echo '<span class="status-ativo">Ativo</span>';
                            } elseif ($status == Estagio::STATUS_EM_ANDAMENTO) {
                                echo '<span class="status-andamento">Em andamento</span>';
                            } else {
                                echo '<span class="status-desconhecido">Desconhecido</span>';
                            }
                        ?>
                    </td>
                </tr>
            </tbody>
        </table>
        
        <a href="listagem.php" class="voltar-link">Voltar para Listagem</a>
    </div>
</body>
</html>
