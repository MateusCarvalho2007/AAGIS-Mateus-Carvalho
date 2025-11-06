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
    <link rel="stylesheet" href="styles/cadastro.css">
</head>
<body>
    <h1>Informações do Estágio</h1>
    <div id="container">
        <form action="visualizacao.php" method="post">          
                    <?php
                    echo "<label>Empresa: <br> {$estagio->getEmpresa()} </label><br>";
                    echo "<label>Setor: <br> {$estagio->getSetorEmpresa()} </label><br>";
                    echo "<label>Supervisor: <br> {$estagio->getNameSupervisor()} </label><br>";
                    echo "<label>E-mail Supervisor: <br> {$estagio->getEmailSupervisor()} </label><br>";
                    echo "<label>Tipo de Estágio: <br> {$estagio->getIdEstagio()}</label><br>";
                    echo"<label>Data Início: <br> {$estagio->getDataInicio()}</label><br>";
                    echo"<label>Data Fim: <br> {$estagio->getDataFim()}</label><br>";

                    echo "<label>Tipo de Estágio: " . ($estagio->isObrigatorio() ? 'Obrigatório' : 'Não Obrigatório') . "</label> <br>";
                    echo "<label> Vínculo Trabalhista: " . ($estagio->isVinculoTrabalhista() ? 'Carteira Assinada' : 'Sem Carteira') . "</label> <br>";

                    ?>
               
               
            <!-- // echo "<h2>Estágiario: {$estagio->getName()}</h2>";
            // echo "<h2>Empresa: {$estagio->getEmpresa()}</h2>";
            // echo "<h2>Setor:{$estagio->getSetorEmpresa()}</h2>";
            // echo "<h2>Supervisor: {$estagio->getNameSupervisor()}</h2>";
            // echo "<h2>Email Supervisor: {$estagio->getEmailSupervisor()}</h2>";
            // echo "<h2>Período: {$estagio->getDataInicio()} a {$estagio->getDataFim()}</h2>";
            // echo "<h2>Tipo de Estágio: " . ($estagio->isObrigatorio() ? 'Obrigatório' : 'Não Obrigatório') . "</h2>";
            // echo "<h2>Vínculo Trabalhista: " . ($estagio->isVinculoTrabalhista() ? 'Carteira Assinada' : 'Sem Carteira') . "</h2>"; 
            // echo "<h2> Status do Estágio: " . ($status = $estagio->getStatus()) . "</h2>";
            // if ($status == Estagio::STATUS_FINALIZADO) {
            //     echo '<span class="status-finalizado">Finalizado</span>';
            // } elseif ($status == Estagio::STATUS_ATIVO) {
            //     echo '<span class="status-ativo">Ativo</span>';
            // } elseif ($status == Estagio::STATUS_EM_ANDAMENTO) {
            //     echo '<span class="status-andamento">Em andamento</span>';
            // } else {
            //     echo '<span class="status-desconhecido">Desconhecido</span>';
            // }
             -->
            <br>
            <a href="listagem.php">Voltar para Listagem</a>
        </form>
    </div>
</body>
</html>