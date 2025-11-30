<?php
require_once __DIR__ . '/classes/Estagio.php';
require_once __DIR__ . '/bd/MySQL.php';
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Variáveis de controle
$estagio = null;
$mensagemSucesso = null;
$mensagemErro = null;
$nomeProfessor = null;
$emailProfessor = null;

// Tratar POST para atualizar status (somente professores podem alterar)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idEstagio'])) {
    // Verifica tipo do usuário na sessão
    $usuarioTipo = $_SESSION['tipo'] ?? null;
    if ($usuarioTipo !== 'professor') {
        // Bloqueia ação para usuários que não são professores
        $mensagemErro = 'Acesso negado! Apenas professores podem alterar o status!';
    } else {
        $idEstagio = intval($_POST['idEstagio']);
        $novoStatus = isset($_POST['status']) ? intval($_POST['status']) : null;
        
        if ($novoStatus !== null) {
            // Validar status
            $statusesValidos = [
                Estagio::STATUS_FINALIZADO,
                Estagio::STATUS_ATIVO,
                Estagio::STATUS_CONCLUIDO
            ];
            
            if (in_array($novoStatus, $statusesValidos, true)) {
                $ok = Estagio::updateStatus($idEstagio, $novoStatus);
                if ($ok) {
                    $mensagemSucesso = 'Status atualizado com sucesso!';
                } else {
                    $mensagemErro = 'Erro ao atualizar o status!';
                }
            } else {
                $mensagemErro = 'Status inválido.';
            }
        }
    }
}

// Obter ID do estágio
$id = isset($_POST['idEstagio']) ? intval($_POST['idEstagio']) : intval($_GET['idEstagio'] ?? 0);

try {
    $estagio = Estagio::find($id);
    
    // Se não encontrou o estágio
    if (!$estagio->getIdEstagio()) {
        die("Erro: Estágio não encontrado com o ID: " . $id);
    }
    
    // Buscar nome e email do professor
    if ($estagio->getIdProfessor()) {
        $conexao = new MySQL();
        $sql = "SELECT nome, email FROM usuario WHERE idUsuario = " . intval($estagio->getIdProfessor()) . " LIMIT 1";
        $resultado = $conexao->consulta($sql);
        if (!empty($resultado)) {
            $nomeProfessor = $resultado[0]['nome'] ?? 'Não encontrado';
            $emailProfessor = $resultado[0]['email'] ?? 'Não encontrado';
        }
    }
} catch (Exception $e) {
    die("Erro ao buscar estágio: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <meta charset="UTF-8">
    <title>Visualização de Estágios</title>
    <link rel="stylesheet" href="styles/visualizacao.css">
</head>
<body>
    <h1>Informações do Estágio</h1>
    <div id="container">
        
        <!-- Exibir mensagens de sucesso ou erro -->
        <?php if (!empty($mensagemSucesso)): ?>
            <div class="mensagem-sucesso">
                <?php echo htmlspecialchars($mensagemSucesso); ?>
            </div>
        <?php endif; ?>
        
        <?php if (!empty($mensagemErro)): ?>
            <div class="mensagem-erro">
                <?php echo htmlspecialchars($mensagemErro); ?>
            </div>
        <?php endif; ?>
        
        <!-- Informações do Estágio -->
        <?php $DI = date('d/m/Y', strtotime($estagio->getDataInicio())); ?>
        <?php $DF = date('d/m/Y', strtotime($estagio->getDataFim())); ?>
        <div class="alinha" style="margin-bottom: 20px;">
            <p><strong>Estagiário:</strong> <?php echo htmlspecialchars($estagio->getName()); ?></p>
            <p><strong>Empresa:</strong> <?php echo htmlspecialchars($estagio->getEmpresa()); ?></p>
            <p><strong>Setor:</strong> <?php echo htmlspecialchars($estagio->getSetorEmpresa()); ?></p>
            <p><strong>Supervisor:</strong> <?php echo htmlspecialchars($estagio->getNameSupervisor()); ?></p>
            <p><strong>Email Supervisor:</strong> <?php echo htmlspecialchars($estagio->getEmailSupervisor()); ?></p>
            <p><strong>Orientador:</strong> <?php echo htmlspecialchars($nomeProfessor); ?></p>
            <p><strong>Email Orientador:</strong> <?php echo htmlspecialchars($emailProfessor); ?></p>
            <p><strong>Período:</strong> <?php echo str_replace('-', '/', htmlspecialchars($DI)); ?> a <?php echo str_replace('-', '/', htmlspecialchars($DF)); ?></p>
            <p><strong>Tipo de Estágio:</strong> <?php echo ($estagio->isObrigatorio() ? 'Obrigatório' : 'Não Obrigatório'); ?></p>
            <p><strong>Vínculo Trabalhista:</strong> <?php echo ($estagio->isVinculoTrabalhista() ? 'Carteira Assinada' : 'Sem Carteira'); ?></p>
            <!-- Exibição do Status -->
            <p><strong>Status do Estágio:</strong> 
                <?php
                $status = $estagio->getStatus();
                if ($status == Estagio::STATUS_FINALIZADO) {
                    echo '<span class="status-finalizado">Finalizado</span>';
                } elseif ($status == Estagio::STATUS_ATIVO) {
                    echo '<span class="status-ativo">Ativo</span>';
                } elseif ($status == Estagio::STATUS_CONCLUIDO) {
                    echo '<span class="status-concluido">Concluído</span>';
                } else {
                    echo '<span class="status-desconhecido">Desconhecido</span>';
                }
                ?>
            </p>
            
            <?php if (isset($_SESSION['tipo']) && $_SESSION['tipo'] === 'professor'): ?>
            <div class="form-actions">
                <!-- Formulário para alterar status -->
                <form action="visualizacao.php" method="post">
                    <input type="hidden" name="idEstagio" value="<?php echo $estagio->getIdEstagio(); ?>">
                    
                    <label for="status"><strong>Alterar Status:</strong></label>
                    <select name="status" id="status" required>
                        <option value="<?php echo Estagio::STATUS_ATIVO; ?>" <?php echo ($status == Estagio::STATUS_ATIVO) ? 'selected' : ''; ?>>
                            Ativo
                        </option>
                        <option value="<?php echo Estagio::STATUS_FINALIZADO; ?>" <?php echo ($status == Estagio::STATUS_FINALIZADO) ? 'selected' : ''; ?>>
                            Finalizado
                        </option>
                    </select>
                    <button type="submit">Atualizar Status</button>
                </form>
                
                <!-- Botão rápido para Marcar como Concluído -->
                <?php if ($status != Estagio::STATUS_CONCLUIDO && $status != Estagio::STATUS_FINALIZADO): ?>
                    <form action="visualizacao.php" method="post" onsubmit="return confirm('Marcar este estágio como Concluído?');">
                        <input type="hidden" name="idEstagio" value="<?php echo $estagio->getIdEstagio(); ?>">
                        <input type="hidden" name="status" value="<?php echo Estagio::STATUS_CONCLUIDO; ?>">
                        <button type="submit" class="btn-concluir">
                            Marcar como Concluído
                        </button>
                    </form>
                <?php endif; ?>
            </div>
            <?php else: ?>
                <!-- Usuário não é professor: área de alteração de status oculta -->
            <?php endif; ?>
            <br>
            <div class="alinhaA">
                <a href="listagem.php">Voltar para Listagem</a>
            </div>
        </div>
    </div>
</body>
</html>
