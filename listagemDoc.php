<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listagem de Documentos - AAGIS</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f8f9fa;
            color: #333;
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        header {
            background-color: #0080ff;
            color: white;
            padding: 10px 0;
            margin-bottom: 20px;
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .header-content h1 {
            font-size: 1.8rem;
            margin: 0;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .btn-logout {
            background-color: #dc3545;
            color: white;
            padding: 8px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 18px;
        }

        .page-title {
            margin: 20px 0;
            color: #333;
            font-size: 2rem;
            text-align: center;
        }

        .estagio-info {
            background-color: white;
            padding: 20px;
            margin-bottom: 25px;
            border: 1px solid #ddd;
        }

        .estagio-info h2 {
            color: #333;
            margin-bottom: 15px;
            font-size: 1.5rem;
        }

        .estagio-details {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 15px;
            margin-top: 15px;
        }

        .detail-item {
            display: flex;
            flex-direction: column;
        }

        .detail-label {
            font-weight: 600;
            color: #6c757d;
            font-size: 0.9rem;
        }

        .detail-value {
            color: #333;
            font-weight: 500;
            font-size: 1rem;
        }

        .actions-bar {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 10px;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: white;
            padding: 8px 15px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: 500;
        }

        .documents-container {
            background-color: white;
            border: 1px solid #ddd;
        }

        .documents-header {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr 1fr;
            background-color: #f8f9fa;
            color: #333;
            padding: 10px 6px;
            font-weight: 600;
            border-bottom: 1px solid #ddd;
        }

        .document-item {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr 1fr;
            padding: 10px 6px;
            border-bottom: 1px solid #ddd;
            align-items: center;
        }

        .document-item:last-child {
            border-bottom: none;
        }

        .document-name {
            font-weight: 500;
            color: #333;
        }

        .status-badge {
            padding: 4px 8px;
            font-size: 0.8rem;
            font-weight: 500;
            text-align: center;
            display: inline-block;
        }

        .status-pendente {
            background-color: #fff3cd;
            color: #856404;
        }

        .status-enviado {
            background-color: #d1ecf1;
            color: #0c5460;
        }

        .status-concluido {
            background-color: #d4edda;
            color: #155724;
        }

        .status-atrasado {
            background-color: #f8d7da;
            color: #721c24;
        }

        .document-actions {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .btn-action {
            padding: 6px 12px;
            text-decoration: none;
            font-size: 0.85rem;
        }

        .btn-view {
            color: #007bff;
        }

        .btn-upload {
            color: #007bff;
        }

        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: #6c757d;
        }

        .empty-state-icon {
            font-size: 3rem;
            margin-bottom: 15px;
            color: #adb5bd;
        }

        @media (max-width: 768px) {
            .documents-header, .document-item {
                grid-template-columns: 1fr;
                gap: 10px;
                text-align: center;
            }
            
            .document-actions {
                justify-content: center;
            }
            
            .estagio-details {
                grid-template-columns: 1fr;
            }
            
            .header-content {
                flex-direction: column;
                gap: 10px;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="header-content">
            <h1>Lista de Documentos</h1>
            <div class="user-info">
                <span>Bem-vindo, ao AAGIS!</span>
                <a href="logout.php" class="btn-logout">Sair</a>
            </div>
        </div>
    </header>

    <div class="container">
        <h1 class="page-title">Listagem de Documentos</h1>
        
        <?php
        // Simulação de dados - em um sistema real, esses dados viriam do banco
        $idEstagio = $_GET['idEstagio'] ?? 0;
        
        // Informações do estágio
        $estagio = [
            'aluno' => 'Mathias Scherer',
            'empresa' => 'SAP',
            'setor' => 'Developer',
            'periodo' => '01/11/2025 - 15/11/2025',
            'supervisor' => 'Sergio Robertos',
            'status' => 'Ativo'
        ];
        
        // Documentos do estágio
        $documentos = [
            [
                'id' => 1,
                'nome' => 'Autorização de Uso de Imagens',
                'status' => 0, // 0 = Pendente, 1 = Enviado, 2 = Concluído, 3 = Atrasado
                'dataEnvio' => null,
                'prazo' => null,
                'arquivo' => null
            ],
            [
                'id' => 2,
                'nome' => 'Plano de Atividades',
                'status' => 0,
                'dataEnvio' => '',
                'prazo' => '',
                'arquivo' => ''
            ],
            [
                'id' => 3,
                'nome' => 'Relatório Parcial',
                'status' => 3,
                'dataEnvio' => null,
                'prazo' => '',
                'arquivo' => null
            ],
            [
                'id' => 4,
                'nome' => 'Relatório Final',
                'status' => 0,
                'dataEnvio' => null,
                'prazo' => '',
                'arquivo' => null
            ]
        ];
        
        // Mapeamento de status para texto
        $statusText = [
            0 => 'Pendente',
            1 => 'Enviado',
            2 => 'Concluído',
            3 => 'Atrasado'
        ];
        
        // Mapeamento de status para classes CSS
        $statusClass = [
            0 => 'status-pendente',
            1 => 'status-enviado',
            2 => 'status-concluido',
            3 => 'status-atrasado'
        ];
        ?>
        
        <div class="estagio-info">
            <h2>Informações do Estágio</h2>
            <div class="estagio-details">
                <div class="detail-item">
                    <span class="detail-label">Aluno</span>
                    <span class="detail-value"><?php echo $estagio['aluno']; ?></span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Empresa</span>
                    <span class="detail-value"><?php echo $estagio['empresa']; ?></span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Setor</span>
                    <span class="detail-value"><?php echo $estagio['setor']; ?></span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Período</span>
                    <span class="detail-value"><?php echo $estagio['periodo']; ?></span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Status</span>
                    <span class="detail-value"><?php echo $estagio['status']; ?></span>
                </div>
            </div>
        </div>
        
        <div class="actions-bar">
            <a href="listagem.php" class="btn-secondary">
                ← Voltar para Listagem de Estágios
            </a>
        </div>
        
        <div class="documents-container">
            <div class="documents-header">
                <div>Documento</div>
                <div>Status</div>
                <div>Data de Envio</div>
                <div>Prazo</div>
                <div>Ações</div>
            </div>
            
            <?php if (empty($documentos)): ?>
                <div class="empty-state">
                    <div class="empty-state-icon">📄</div>
                    <h3>Nenhum documento encontrado</h3>
                    <p>Comece anexando seu primeiro documento.</p>
                </div>
            <?php else: ?>
                <?php foreach ($documentos as $doc): ?>
                    <div class="document-item">
                        <div class="document-name"><?php echo $doc['nome']; ?></div>
                        <div>
                            <span class="status-badge <?php echo $statusClass[$doc['status']]; ?>">
                                <?php echo $statusText[$doc['status']]; ?>
                            </span>
                        </div>
                        <div><?php echo $doc['dataEnvio'] ? date('d/m/Y', strtotime($doc['dataEnvio'])) : '--'; ?></div>
                        <div><?php echo $doc['prazo'] ? date('d/m/Y', strtotime($doc['prazo'])) : '--'; ?></div>
                        <div class="document-actions">
                            <?php if ($doc['arquivo']): ?>
                                <a href="uploads/<?php echo $doc['arquivo']; ?>" target="_blank" class="btn-action btn-view">Visualizar</a>
                            <?php endif; ?>
                            
                            <?php if ($doc['status'] == 0 || $doc['status'] == 3): ?>
                                <a href="anexarDoc.php?idEstagio=<?php echo $idEstagio; ?>&idDocumento=<?php echo $doc['id']; ?>" class="btn-action btn-upload">Anexar Documento</a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>