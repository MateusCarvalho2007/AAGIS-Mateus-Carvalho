<?php
session_start();
require_once __DIR__ . "/bd/MySQL.php";

if (isset($_POST['login'])) {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $senha = $_POST['senha'];

    if (!$email || !$senha) {
        $_SESSION['erro'] = "Por favor, preencha todos os campos.";
        header("Location: login.php");
        exit;
    }

    $conexao = new MySQL();
    
    // Usando prepared statement para evitar SQL injection
    $stmt = $conexao->getConnection()->prepare("SELECT idAluno, nome FROM aluno WHERE email = ? AND senha = ? AND status = 1");
    $stmt->bind_param("ss", $email, $senha);
    $stmt->execute();
    $resultado = $stmt->get_result();
    
    if ($resultado->num_rows === 1) {
        $aluno = $resultado->fetch_assoc();
        
        // Guarda os dados do aluno na sessão
        $_SESSION['idAluno'] = $aluno['idAluno'];
        $_SESSION['nome'] = $aluno['nome'];
        $_SESSION['email'] = $email;
        
        // Por padrão, vamos usar o ID do primeiro professor ativo
        $stmtProf = $conexao->getConnection()->prepare("SELECT idProfessor, nome FROM professor WHERE status = 1 LIMIT 1");
        $stmtProf->execute();
        $professor = $stmtProf->get_result()->fetch_assoc();
        
        if ($professor) {
            $_SESSION['idProfessor'] = $professor['idProfessor'];
            $_SESSION['nomeProfessor'] = $professor['nome'];
        }
        
        header("Location: listagem.php");
        exit;
    } else {
        $_SESSION['erro'] = "E-mail ou senha incorretos.";
        header("Location: login.php");
        exit;
    }
}

// Se chegou aqui é porque não veio do formulário de login
header("Location: login.php");
exit;