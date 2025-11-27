<?php
require_once __DIR__ . "/../bd/MySQL.php";

class Documento {
    private $idDocumento;
    private $idEstagio;
    private $nome;
    private $arquivo;
    private $status;
    private $dataEnvio;
    private $prazo;
    private $notificacao;

    const STATUS_PENDENTE = 0;
    const STATUS_ENVIADO = 1;
    const STATUS_CONCLUIDO = 2;
    const STATUS_ATRASADO = 3;

    public function __construct($idEstagio = null, $nome = '', $arquivo = '',
        $status = self::STATUS_PENDENTE, $prazo = null, $notificacao = null) 
    {
        $this->idEstagio = $idEstagio;
        $this->nome = $nome;
        $this->arquivo = $arquivo;
        $this->status = $status;
        $this->prazo = $prazo;
        $this->notificacao = $notificacao;
    }

    public function getIdDocumento() { return $this->idDocumento; }
    public function setIdDocumento($idDocumento): void { $this->idDocumento = $idDocumento; }
    public function getIdEstagio() { return $this->idEstagio; }
    public function setIdEstagio($idEstagio): void { $this->idEstagio = $idEstagio; }
    public function getNome() { return $this->nome; }
    public function setNome($nome): void { $this->nome = $nome; }
    public function getArquivo() { return $this->arquivo; }
    public function setArquivo($arquivo): void { $this->arquivo = $arquivo; }
    public function getStatus() { return $this->status; }
    public function setStatus($status): void { $this->status = $status; }
    public function getDataEnvio() { return $this->dataEnvio; }
    public function setDataEnvio($dataEnvio): void { $this->dataEnvio = $dataEnvio; }
    public function getPrazo() { return $this->prazo; }
    public function setPrazo($prazo): void { $this->prazo = $prazo; }
    public function setNotificacao($notificacao): void { $this->notificacao = $notificacao; }
    public function getNotificacao() {return $this->notificacao; }

    public function save(): bool {
        $conexao = new MySQL();
        $conn = $conexao->getConnection();
        
        $stmt = $conn->prepare("
            INSERT INTO documento (
                idEstagio, nome, arquivo, status, dataEnvio, prazo, notificacao
            ) VALUES (?, ?, ?, ?, NOW(), ?, ?)
        ");

        if (!$stmt) {
            error_log("Erro ao preparar statement: " . $conn->error);
            return false;
        }
        
        $idEstagio = $this->idEstagio;
        $nome = $this->nome;
        $arquivo = $this->arquivo;
        $status = $this->status;
        $prazo = $this->prazo;
        $notificacao = $this->notificacao;
        
        // CORREÇÃO: 6 parâmetros agora
        $stmt->bind_param("isssss", $idEstagio, $nome, $arquivo, $status, $prazo);
        $result = $stmt->execute();
        if ($result) {
            $this->idDocumento = $conn->insert_id;
        }

        $stmt->close();
        return $result;
    }

    public function update(): bool {
        if (!$this->idDocumento) {
            return false;
        }
        $conexao = new MySQL();
        $sql = "
            UPDATE documento SET 
                nome = '{$this->nome}',
                arquivo = '{$this->arquivo}',
                status = '{$this->status}',
                prazo = '{$this->prazo}',
                notificacao = '{$this->notificacao}'
            WHERE idDocumento = {$this->idDocumento}
        ";
        return $conexao->executa($sql);
    }

    public static function find($idDocumento): ?Documento {
        $conexao = new MySQL();
        $sql = "SELECT * FROM documento WHERE idDocumento = {$idDocumento} LIMIT 1";
        $resultado = $conexao->consulta($sql);
        if (!isset($resultado[0])) {
            return null;
        }
        $row = $resultado[0];
        $d = new Documento(
            $row['idEstagio'] ?? null,
            $row['nome'] ?? '',
            $row['arquivo'] ?? '',
            $row['status'] ?? self::STATUS_PENDENTE,
            $row['prazo'] ?? null,
            $row['notificacao'] ?? null
        );
        $d->setIdDocumento($row['idDocumento']);
        $d->setDataEnvio($row['dataEnvio'] ?? null);

        return $d;
    }

    public static function findAll($idEstagio): array {
        $conexao = new MySQL();
        $sql = "SELECT * FROM documento WHERE idEstagio = {$idEstagio} ORDER BY prazo ASC";
        $resultados = $conexao->consulta($sql);
        $documentos = [];
        foreach ($resultados as $row) {
            $d = new Documento(
                $row['idEstagio'] ?? null,
                $row['nome'] ?? '',
                $row['arquivo'] ?? '',
                $row['status'] ?? self::STATUS_PENDENTE,
                $row['prazo'] ?? null,
                $row['notificacao'] ?? null
            );
            $d->setIdDocumento($row['idDocumento']);
            $d->setDataEnvio($row['dataEnvio'] ?? null);
            $documentos[] = $d;
        }

        return $documentos;
    }

    public static function atualizarStatus($idDocumento, $novoStatus): bool {
        $conexao = new MySQL();
        $sql = "UPDATE documento SET status = '{$novoStatus}' WHERE idDocumento = {$idDocumento}";
        return $conexao->executa($sql);
    }

    public static function delete($idDocumento): bool {
        $conexao = new MySQL();
        $sql = "DELETE FROM documento WHERE idDocumento = {$idDocumento}";
        return $conexao->executa($sql);
    }
}
?>