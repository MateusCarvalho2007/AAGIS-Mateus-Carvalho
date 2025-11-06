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
    <link rel="stylesheet" href="styles/login.css">
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