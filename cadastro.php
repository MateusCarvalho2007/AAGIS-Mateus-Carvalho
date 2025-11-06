<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['idAluno'])) {
    $_SESSION['erro'] = "Você precisa fazer login para cadastrar um estágio!";
    header("Location: index.php");
    exit;
}

// processamento do formulário de cadastro de estágio
if(isset($_POST['botao'])){
    require_once __DIR__ . "/classes/Estagio.php";

    // Verificar se o usuário está logado
    if (!isset($_SESSION['idAluno']) || !isset($_SESSION['idProfessor'])) {
        die("Erro: Você precisa estar logado para cadastrar um estágio.");
    }

    // assumir valores do session quando disponível
    $alunoNome = $_SESSION['nome'] ?? '';
    $idAluno = $_SESSION['idAluno'] ?? null;
    $professorNome = $_SESSION['nomeProfessor'] ?? '';
    $idProfessor = $_SESSION['idProfessor'] ?? null;

    // ler campos do formulário com nomes consistentes
    $dataInicio = $_POST['dataInicio'] ?? null;
    $dataFim = $_POST['dataFim'] ?? null;
    $estagioTipo = isset($_POST['estagioTipo']) ? intval($_POST['estagioTipo']) : 0; // 1 obrigatório, 0 não
    $vinculo = isset($_POST['vinculo']) ? intval($_POST['vinculo']) : 0; // 1 com carteira, 0 sem
    $setor = $_POST['setor'] ?? '';
    $nomeEmpresa = $_POST['nomeEmpresa'] ?? '';
    $nomeSupervisor = $_POST['nomeSupervisor'] ?? '';
    $emailSupervisor = $_POST['emailSupervisor'] ?? '';

    $e = new Estagio($alunoNome, $dataInicio, $dataFim, $nomeEmpresa, $setor, $vinculo,
        $estagioTipo, $nomeSupervisor, $emailSupervisor, $professorNome, $idAluno, $idProfessor, 1);

    // tenta salvar e dá feedback ao usuário
    try {
        $ok = $e->save();
        if ($ok) {
            $_SESSION['sucesso'] = "Estágio cadastrado com sucesso!";
            header("Location: listagem.php");
            exit;
        } else {
            $_SESSION['erro'] = "Erro ao salvar o estágio. Verifique os logs do servidor.";
            header("Location: cadastro.php");
            exit;
        }
    } catch (Throwable $t) {
        error_log('Exceção ao salvar estágio: ' . $t->getMessage());
        $_SESSION['erro'] = "Erro interno ao processar o cadastro.";
        header("Location: cadastro.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Estágio</title>
    <link rel="stylesheet" href="styles/cadastro.css">
</head>
<body>
    <h1>Fazer Cadastro do Estágio:</h1>
    <br>

    <form action="cadastro.php" method="post">

        <label for="nomeEmpresa">Nome da Empresa: </label>
        <input type="text" name="nomeEmpresa" id="nomeEmpresa" required>

        <label for="setor">Setor Atuante: </label>
        <input type="text" name="setor" id="setor" required>

        <label for="nomeSupervisor">Nome do Supervisor: </label>
        <input type="text" name="nomeSupervisor" id="nomeSupervisor" required>
        
        <label for="emailSupervisor">E-mail do Supervisor: </label>
        <input type="email" name="emailSupervisor" id="emailSupervisor" required>

        <label for="dataInicio">Data de Início: </label>
        <input type="date" name="dataInicio" id="dataInicio" required>

        <label for="dataFim">Data de Fim: </label>
        <input type="date" name="dataFim" id="dataFim" required>

        <div>
            <label>Tipo de Estágio:</label>
            <label><input type="radio" name="estagioTipo" value="1" required> Obrigatório</label>
            <label><input type="radio" name="estagioTipo" value="0"> Não Obrigatório</label>
        </div>

        <div>
            <label>Vínculo Trabalhista:</label>
            <label><input type="radio" name="vinculo" value="1" required> Carteira Assinada</label>
            <label><input type="radio" name="vinculo" value="0"> Sem Carteira Assinada</label>
        </div>

        <!-- botões -->
        <button type="submit" name="botao" value="cadastrar">Cadastrar</button>
        <button type="button" onclick="location.href='listagem.php'">Cancelar</button>
    </form>

</body>
</html>