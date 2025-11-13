
    <?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    session_start();

    // Verifica se o usuário está logado
    if (!isset($_SESSION['idUsuario'])) {
        header("Location: index.php");
        exit;
    }

    if(isset($_GET['idEstagio'])){
        require_once __DIR__.'/classes/Estagio.php';
        Estagio::mudarStatus($_GET['idEstagio']);
    }

    require_once __DIR__.'/classes/Estagio.php';
    require_once __DIR__.'/classes/Usuario.php';
    $idUsuario = $_SESSION['idUsuario'];
    $usuario = Usuario::acharUsuario($idUsuario);
    $estagios = Estagio::findall($idUsuario);
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Listagem de Estágios</title>
        <link rel="stylesheet" href="styles/listagem.css">
    </head>
    <body>
        <div style="background-color: #f8f9fa; padding: 10px; margin-bottom: 20px;">
            <div style="display: flex; justify-content: space-between; align-items: center; max-width: 1200px; margin: 0 auto;">
                <h1 style="margin: 0;">Lista de Estágios</h1>
                <?php if (isset($_SESSION['nome'])): ?>
                    <div style="display: flex; align-items: center;">
                        <span style="margin-right: 15px;">
                            Bem-vindo, ao AAGIS!
                        </span>
                        <a href="logout.php" style="
                            background-color: #dc3545;
                            color: white;
                            padding: 8px 20px;
                            text-decoration: none;
                            border-radius: 5px;
                            font-size: 18px;">Sair</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
        <br>
        <br>
        <?php if($_SESSION['tipo'] == 'professor'): ?>
            <h3><a href="cadastro.php" style="
                    background-color: white;
                    color: black;
                    padding: 8px 12px;
                    text-decoration: none;
                    border-radius: 5px;
                    font-size: 20px;">Cadastrar Novo Estágio</a></h3>
        <?php endif; ?>
                
        <table border="1" cellpadding="6" cellspacing="0">
            <thead>
                <tr>
                    <?php if($_SESSION['tipo'] == 'professor'): ?>
                        <th>Aluno</th>
                    <?php endif; ?>
                    <th>Empresa</th>
                    <th>Período</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($estagios as $estagio): ?>
                <tr>
                    <?php if($_SESSION['tipo'] == 'professor'): ?>
                        <td><?= htmlspecialchars($estagio->getName()) ?></td>
                    <?php endif; ?>
                    <td><?= htmlspecialchars($estagio->getEmpresa()) ?></td>
                    <td><?= htmlspecialchars($estagio->getDataInicio()) ?> - <?= htmlspecialchars($estagio->getDataFim()) ?></td>
                    <td>
                        <?php
                            $s = $estagio->getStatus();
                            // usa helper para rótulo consistente
                            echo \Estagio::getStatusLabel($s);
                        ?>
                    </td>
                    <td>
                        <?php if($estagio->isFinalizado()): ?>
                            <span style="color:gray">Inacessível (finalizado)</span>
                        <?php else: ?>
                            <a href="editar.php?idEstagio=<?= $estagio->getIdEstagio() ?>">Editar</a>
                            |
                            <a href="visualizacao.php?idEstagio=<?= $estagio->getIdEstagio() ?>">Visualizar</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <?php if($_SESSION['tipo'] == 'professor'): ?>
            <h3><a href="cadastro.php" style="
                    background-color: white;
                    color: black;
                    padding: 8px 12px;
                    text-decoration: none;
                    border-radius: 5px;
                    font-size: 20px;">Cadastrar Novo Estágio</a></h3>
        <?php endif; ?>
    </body>
    </html>