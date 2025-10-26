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
	<style>
		table { border-collapse: collapse; width: 100%; }
		th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
		th { background: #f0f0f0; }
	</style>
</head>
<body>
	<h1>Informações dos Estágios</h1>
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
				<td><?= htmlspecialchars($estagio->getName()) ?></td>
				<td><?= htmlspecialchars($estagio->getEmpresa()) ?></td>
				<td><?= htmlspecialchars($estagio->getSetorEmpresa()) ?></td>
				<td><?= htmlspecialchars($estagio->getDataInicio()) ?></td>
				<td><?= htmlspecialchars($estagio->getDataFim()) ?></td>
				<td><?= htmlspecialchars($estagio->getNameSupervisor()) ?></td>
				<td><?= htmlspecialchars($estagio->getEmailSupervisor()) ?></td>
				<td><?= htmlspecialchars($estagio->getProfessor()) ?></td>
				<td>
					<?php 
						$status = $estagio->getStatus();
						if ($status == Estagio::STATUS_FINALIZADO) echo 'Finalizado';
						elseif ($status == Estagio::STATUS_ATIVO) echo 'Ativo';
						elseif ($status == Estagio::STATUS_EM_ANDAMENTO) echo 'Em andamento';
						else echo 'Desconhecido';
					?>
				</td>
			</tr>
		</tbody>
	</table>
	<br>
	<a href="listagem.php">Voltar</a>
</body>
</html>
