<?php
// Adicionado: ativar exibição de erros para depuração (remova em produção)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// Verifica se o arquivo de BD existe
if (!file_exists(__DIR__ . '/bd/MySQL.php')) {
    error_log("Arquivo bd/MySQL.php não encontrado em: " . __DIR__ . '/bd/MySQL.php');
    // Mensagem curta para o navegador durante depuração
    echo "Erro: arquivo de banco de dados ausente. Verifique os logs.";
    exit;
}

require_once __DIR__ . "/bd/MySQL.php";

// Verifica se a classe existe
if (!class_exists('MySQL')) {
    error_log("Classe MySQL não encontrada em bd/MySQL.php");
    echo "Erro: classe de conexão não encontrada. Verifique os logs.";
    exit;
}

try {
    if (isset($_POST['login'])) {
        // Sanitização básica dos inputs
        $email = isset($_POST['email']) ? filter_var($_POST['email'], FILTER_SANITIZE_EMAIL) : '';
        $senha = isset($_POST['senha']) ? $_POST['senha'] : '';

        if (empty($email) || empty($senha)) {
            $_SESSION['erro'] = "Por favor, preencha todos os campos.";
            header("Location: index.php");
            exit;
        }

        $conexao = new MySQL();

        // Observação: ideal usar prepared statements / hashing de senha.
        $sql = "SELECT idAluno, nome FROM aluno WHERE email = '{$email}' AND senha = '{$senha}' AND status = 1";
        $resultado = $conexao->consulta($sql);

        if (!empty($resultado)) {
            $aluno = $resultado[0];

            // Guarda os dados do aluno na sessão
            $_SESSION['idAluno'] = $aluno['idAluno'];
            $_SESSION['nome'] = $aluno['nome'];
            $_SESSION['email'] = $email;

            // Por padrão, vamos usar o ID do primeiro professor ativo
            $sqlProf = "SELECT idProfessor, nome FROM professor WHERE status = 1 LIMIT 1";
            $resultadoProf = $conexao->consulta($sqlProf);

            if (!empty($resultadoProf)) {
                $professor = $resultadoProf[0];
                $_SESSION['idProfessor'] = $professor['idProfessor'];
                $_SESSION['nomeProfessor'] = $professor['nome'];
            }

            header("Location: listagem.php");
            exit;
        } else {
            $_SESSION['erro'] = "E-mail ou senha incorretos.";
            header("Location: index.php");
            exit;
        }
    }

    // Se chegou aqui é porque não veio do formulário de login
    header("Location: index.php");
    exit;
} catch (Throwable $e) {
    // Registra erro completo no log do PHP/servidor
    error_log("Erro na autenticação: " . $e->getMessage() . "\n" . $e->getTraceAsString());
    // Mensagem genérica para o cliente (evitar vazar detalhe em produção)
    echo "Erro interno. Verifique os logs do servidor.";
    exit;
}