



<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>📧 SISTEMA DE NOTIFICAÇÃO - VERSÃO FINAL</h2>";

// Incluir PHPMailer manualmente
require_once 'PHPMailer/src/PHPMailer.php';
require_once 'PHPMailer/src/SMTP.php';
require_once 'PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Configurações do Gmail
$config_email = [
    'host' => 'smtp.gmail.com',
    'port' => 587,
    'username' => 'svaagisifrs@gmail.com',
    'password' => 'lxff suay qplv ecaf', // Senha de App do Gmail
    'from_email' => 'svaagisifrs@gmail.com',
    'from_name' => 'Sistema de Estágios IFRS'
];

// Função para enviar email
function enviar_email_final($destinatario, $nome_destinatario, $documentos_vencidos, $config) {
    $mail = new PHPMailer(true);
    
    try {
        // Configurações do servidor
        $mail->isSMTP();
        $mail->Host = $config['host'];
        $mail->SMTPAuth = true;
        $mail->Username = $config['username'];
        $mail->Password = $config['password'];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = $config['port'];
        $mail->CharSet = 'UTF-8';
        
        // Remetente
        $mail->setFrom($config['from_email'], $config['from_name']);
        $mail->addReplyTo($config['from_email'], $config['from_name']);
        
        // Destinatário
        $mail->addAddress($destinatario, $nome_destinatario);
        
        // Conteúdo do email
        $mail->isHTML(true);
        $mail->Subject = '⚠️ ALERTA: Documentos de Estágio Vencidos - ' . date('d/m/Y');
        
        // Preparar lista de documentos
        $lista_documentos = "";
        foreach ($documentos_vencidos as $doc) {
            $data_vencimento = date('d/m/Y', strtotime($doc['prazo']));
            $dias_vencido = $doc['dias_vencido'];
            $status_text = $doc['dataEnvio'] ? 'Enviado' : 'Não enviado';
            
            $lista_documentos .= "<li>
                <strong>{$doc['nome_documento']}</strong> 
                - Venceu há {$dias_vencido} dias ({$data_vencimento})
                <br><small>Status: {$status_text}</small>
            </li>";
        }
        
        // Corpo do email
        $mail->Body = "
        <html>
        <body style='font-family: Arial, sans-serif; line-height: 1.6; color: #333;'>
            <div style='max-width: 600px; margin: 0 auto; padding: 20px;'>
                <div style='background: #f8f9fa; padding: 15px; border-left: 4px solid #dc3545;'>
                    <h2 style='margin: 0; color: #dc3545;'>⚠️ Documentos de Estágio Vencidos</h2>
                </div>
                <div style='background: white; padding: 20px; border: 1px solid #ddd;'>
                    <p>Prezado(a) <strong>{$nome_destinatario}</strong>,</p>
                    
                    <p>Identificamos que os seguintes documentos do seu estágio estão com data vencida:</p>
                    
                    <div style='background: #fff3cd; padding: 15px; margin: 15px 0; border-radius: 5px;'>
                        <ul style='margin: 0; padding-left: 20px;'>
                            {$lista_documentos}
                        </ul>
                    </div>
                    
                    <p><strong>⚠️ Atenção:</strong> Documentos pendentes podem impactar no andamento do seu estágio.</p>
                    
                    <p>Por favor, regularize a situação o mais breve possível acessando o sistema de estágios.</p>
                    
                    <div style='background: #e7f3ff; padding: 10px; border-radius: 5px; margin: 15px 0;'>
                        <strong>📋 Ações necessárias:</strong>
                        <ul style='margin: 5px 0;'>
                            <li>Acesse o sistema de estágios</li>
                            <li>Envie os documentos pendentes</li>
                            <li>Verifique o status de aprovação</li>
                        </ul>
                    </div>
                </div>
                <div style='margin-top: 20px; padding-top: 20px; border-top: 1px solid #eee; font-size: 12px; color: #666;'>
                    <p>Atenciosamente,<br>
                    <strong>Sistema de Gestão de Estágios</strong><br>
                    Instituto Federal do Rio Grande do Sul</p>
                    <p><small>Este é um email automático, por favor não responda.</small></p>
                </div>
            </div>
        </body>
        </html>
        ";
        
        // Versão texto simples
        $texto_simples = "Prezado(a) {$nome_destinatario},\n\n";
        $texto_simples .= "Identificamos que os seguintes documentos do seu estágio estão com data vencida:\n\n";
        
        foreach ($documentos_vencidos as $doc) {
            $data_vencimento = date('d/m/Y', strtotime($doc['prazo']));
            $dias_vencido = $doc['dias_vencido'];
            $status_text = $doc['dataEnvio'] ? 'Enviado' : 'Não enviado';
            $texto_simples .= "• {$doc['nome_documento']} - Venceu há {$dias_vencido} dias ({$data_vencimento}) - {$status_text}\n";
        }
        
        $texto_simples .= "\n⚠️ Atenção: Documentos pendentes podem impactar no andamento do seu estágio.\n\n";
        $texto_simples .= "Por favor, regularize a situação o mais breve possível acessando o sistema de estágios.\n\n";
        $texto_simples .= "Atenciosamente,\nSistema de Gestão de Estágios\nInstituto Federal do Rio Grande do Sul\n\n";
        $texto_simples .= "Este é um email automático, por favor não responda.";
        
        $mail->AltBody = $texto_simples;
        
        // Enviar email
        $mail->send();
        return true;
        
    } catch (Exception $e) {
        error_log("Erro PHPMailer: " . $mail->ErrorInfo);
        return false;
    }
}

// Função principal
function executar_notificacoes_final() {
    global $config_email;
    
    echo "🔍 Buscando documentos vencidos...<br>";
    
    // Conexão com o banco
      $conn = new mysqli('127.0.0.1', 'u157320114_userG3G4', 'extensaoG3G4BD', 'u157320114_extensaoG3G4');
    
    if ($conn->connect_error) {
        echo "❌ Erro de conexão: " . $conn->connect_error . "<br>";
        return;
    }
    
    // SUA QUERY CORRIGIDA
    $query = "
    SELECT 
        d.dataEnvio,
        d.idDocumento,
        d.idEstagio,
        d.nome as nome_documento,
        d.prazo,
        d.status,
        d.notificacao,
        e.idAluno,
        a.nome as nome_aluno,
        a.email as email_aluno,
        DATEDIFF(CURDATE(), d.prazo) as dias_vencido
    FROM documento d
    INNER JOIN estagio e ON d.idEstagio = e.idEstagio
    INNER JOIN usuario a ON e.idAluno = a.idUsuario
    WHERE DATEDIFF(CURDATE(), d.prazo) >= 0 
    AND (d.dataEnvio IS NULL OR d.notificacao = '0000-00-00')  
    AND (d.notificacao IS NULL OR d.notificacao = '0000-00-00')
    AND d.prazo != '0000-00-00'
    ORDER BY e.idAluno, d.prazo ASC
    ";
    
    $result = $conn->query($query);
    
    if (!$result) {
        echo "❌ Erro na consulta: " . $conn->error . "<br>";
        $conn->close();
        return;
    }
    
    $documentos_vencidos = [];
    while ($row = $result->fetch_assoc()) {
        $documentos_vencidos[] = $row;
    }
    
    echo "📊 Documentos vencidos encontrados: " . count($documentos_vencidos) . "<br><br>";
    
    if (count($documentos_vencidos) == 0) {
        echo "✅ Nenhum documento para notificar.<br>";
        $conn->close();
        return;
    }
    
    // Mostrar documentos encontrados
    echo "<h3>📋 DOCUMENTOS ENCONTRADOS:</h3>";
    echo "<table border='1' cellpadding='8' style='border-collapse: collapse; width: 100%;'>";
    echo "<tr style='background-color: #f2f2f2;'>";
    echo "<th>Aluno</th><th>Documento</th><th>Prazo</th><th>Dias</th><th>Email</th><th>Data Envio</th>";
    echo "</tr>";
    
    foreach ($documentos_vencidos as $doc) {
        $cor = $doc['dias_vencido'] > 7 ? 'red' : 'orange';
        $data_envio = $doc['dataEnvio'] ? $doc['dataEnvio'] : 'Não enviado';
        
        echo "<tr style='background-color: #ffebee;'>";
        echo "<td><strong>{$doc['nome_aluno']}</strong></td>";
        echo "<td>{$doc['nome_documento']}</td>";
        echo "<td style='color: {$cor};'><strong>{$doc['prazo']}</strong></td>";
        echo "<td style='color: {$cor};'><strong>{$doc['dias_vencido']} dias</strong></td>";
        echo "<td>{$doc['email_aluno']}</td>";
        echo "<td>{$data_envio}</td>";
        echo "</tr>";
    }
    echo "</table><br>";
    
    // Agrupar por aluno
    $documentos_por_aluno = [];
    foreach ($documentos_vencidos as $doc) {
        $idAluno = $doc['idAluno'];
        if (!isset($documentos_por_aluno[$idAluno])) {
            $documentos_por_aluno[$idAluno] = [
                'aluno' => $doc['nome_aluno'],
                'email' => $doc['email_aluno'],
                'documentos' => []
            ];
        }
        $documentos_por_aluno[$idAluno]['documentos'][] = $doc;
    }
    
    echo "👥 Alunos a serem notificados: " . count($documentos_por_aluno) . "<br><br>";
    
    // Processar cada aluno
    $emails_enviados = 0;
    $erros_envio = 0;
    
    foreach ($documentos_por_aluno as $idAluno => $dados) {
        $qtd_docs = count($dados['documentos']);
        
        echo "<div style='background: #e3f2fd; padding: 10px; margin: 10px 0; border: 1px solid #2196f3;'>";
        echo "📧 <strong>Enviando para:</strong> {$dados['aluno']} ({$dados['email']})<br>";
        echo "📄 <strong>Documentos:</strong> {$qtd_docs}<br>";
        
        // Enviar email
        $email_enviado = enviar_email_final($dados['email'], $dados['aluno'], $dados['documentos'], $config_email);
        
        if ($email_enviado) {
            echo "✅ <strong>Resultado:</strong> Email enviado com sucesso!<br>";
            $emails_enviados++;
            
            // Marcar documentos como notificados
            foreach ($dados['documentos'] as $doc) {
                $update_query = "UPDATE documento SET notificacao = CURDATE() WHERE idDocumento = ?";
                $stmt = $conn->prepare($update_query);
                $stmt->bind_param("i", $doc['idDocumento']);
                
                if ($stmt->execute()) {
                    echo "&nbsp;&nbsp;✅ Documento {$doc['idDocumento']} marcado como notificado<br>";
                } else {
                    echo "&nbsp;&nbsp;❌ Erro ao marcar documento {$doc['idDocumento']}<br>";
                }
                $stmt->close();
            }
        } else {
            echo "❌ <strong>Resultado:</strong> Falha ao enviar email<br>";
            $erros_envio++;
        }
        
        echo "</div>";
    }
    
    // Resumo final
    echo "<h3>📊 RESUMO FINAL:</h3>";
    echo "<div style='background: " . ($emails_enviados > 0 ? '#d4edda' : '#f8d7da') . "; padding: 15px; border: 1px solid " . ($emails_enviados > 0 ? '#c3e6cb' : '#f5c6cb') . ";'>";
    echo "✅ <strong>Emails enviados com sucesso:</strong> {$emails_enviados}<br>";
    echo "❌ <strong>Falhas no envio:</strong> {$erros_envio}<br>";
    echo "📄 <strong>Total de documentos processados:</strong> " . count($documentos_vencidos) . "<br>";
    echo "👥 <strong>Alunos notificados:</strong> " . count($documentos_por_aluno) . "<br>";
    echo "</div>";
    
    $conn->close();
}

// Executar
executar_notificacoes_final();

echo "<hr>";
echo "<p><strong>Execução concluída em:</strong> " . date('d/m/Y H:i:s') . "</p>";

// Link para testar novamente
echo "<br><a href='enviar_notificacoes_final.php' style='background: #007bff; color: white; padding: 10px 15px; text-decoration: none; border-radius: 5px;'>🔄 Executar Novamente</a>";
?>