<?php
session_start();

// Limpa a sessão anterior se existir
if (isset($_SESSION['idAluno'])) {
    // Limpa todas as variáveis de sessão
    $_SESSION = array();
    
    // Destroi o cookie da sessão
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time()-3600, '/');
    }
    
    // Destroi a sessão
    session_destroy();
    
    // Inicia uma nova sessão limpa
    session_start();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistema de Estágios</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        .error {
            color: red;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <h1>Login do Aluno</h1>
    
    <?php if (isset($_SESSION['erro'])): ?>
        <div class="error">
            <?php 
                echo $_SESSION['erro'];
                unset($_SESSION['erro']);
            ?>
        </div>
    <?php endif; ?>

    <form action="autenticar.php" method="post">
        <div class="form-group">
            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" required>
        </div>

        <div class="form-group">
            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" required>
        </div>

        <button type="submit" name="login">Entrar</button>
    </form>
</body>
</html>