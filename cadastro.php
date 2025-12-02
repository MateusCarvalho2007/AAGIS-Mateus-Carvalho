<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

if (!isset($_SESSION['idUsuario']) || $_SESSION['tipo'] != 'professor') {
    $_SESSION['erro'] = "Você precisa fazer login como professor para cadastrar um estágio!";
    header("Location: index.php");
    exit;
}

// processamento do formulário de cadastro de estágio
if(isset($_POST['botao'])){
    require_once __DIR__ . "/classes/Estagio.php";
    require_once __DIR__ . "/classes/Usuario.php";

    try {
        $idProfessor = $_SESSION['idUsuario'];
        $professorNome = $_SESSION['nome']; // Usa diretamente da sessão
        
        // Buscar aluno
        $alunoEncontrado = Usuario::acharUsuarioPeloEmail(trim($_POST['nomeAluno']));
        if (!$alunoEncontrado) {
            throw new Exception("Aluno não encontrado!");
        }
        
        // Criar estágio com método mais seguro
        $e = new Estagio();
        $e->setName("");
        $e->setDataInicio("0000-00-00");
        $e->setDataFim("0000-00-00");
        $e->setEmpresa(trim($_POST['nomeEmpresa']));
        $e->setSetorEmpresa("");
        $e->setVinculoTrabalhista(0);
        $e->setObrigatorio(0);
        $e->setNameSupervisor("");
        $e->setEmailSupervisor("");
        $e->setProfessor("");
        $e->setIdAluno($alunoEncontrado->getIdUsuario());
        $e->setIdProfessor($idProfessor);
        $e->setStatus(1);

        if ($e->save()) {
            $_SESSION['sucesso'] = "Estágio cadastrado com sucesso!";
            header("Location: listagem.php");
            exit;
        } else {
            throw new Exception("Erro ao salvar no banco de dados.");
        }
        
    } catch (Exception $e) {
        $_SESSION['erro'] = $e->getMessage();
    }
}

require_once __DIR__ . "/classes/Usuario.php";
$alunos = Usuario::listarAlunos();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Estágio</title>
    <link rel="stylesheet" href="styles/cadastro.css">
    <style>
        .mensagem {
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
        }
        .erro {
            color: red;
            background: #ffe6e6;
            border: 1px solid red;
        }
        .sucesso {
            color: green;
            background: #e6ffe6;
            border: 1px solid green;
        }
    </style>
</head>
<body>
    <h1>Cadastrar Estágio</h1>

    <form action="cadastro.php" method="post">
        <label for="nomeAluno">Email do Aluno:</label>
        <input type="text" name="nomeAluno" id="nomeAluno" list="listaAlunos" required value="<?php echo isset($_POST['nomeAluno']) ? htmlspecialchars($_POST['nomeAluno']) : ''; ?>">
        
        <datalist id="listaAlunos">
            <?php foreach($alunos as $aluno): ?>
                <option value="<?php echo htmlspecialchars($aluno->getEmail()); ?>">
            <?php endforeach; ?>
        </datalist>

        <label for="nomeEmpresa">Nome da Empresa:</label>
        <input type="text" name="nomeEmpresa" id="nomeEmpresa" required value="<?php echo isset($_POST['nomeEmpresa']) ? htmlspecialchars($_POST['nomeEmpresa']) : ''; ?>">

        <button type="submit" name="botao" value="cadastrar">Cadastrar</button>
        <button type="button" onclick="location.href='listagem.php'">Cancelar</button>
    </form>
</body>
</html>