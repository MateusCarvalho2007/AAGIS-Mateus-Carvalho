<?php
require_once _DIR_ . "/../bd/MySQL.php";

class Documento {

    private $idDocumento;
    private $idEstagio;
    private $nome;
    private $tipo;
    private $arquivo;
    private $status;
    private $dataEnvio;
    private $prazo;
    const STATUS_PENDENTE = "Pendente";
    const STATUS_ENVIADO = "Enviado";
    const STATUS_CONCLUIDO = "Concluído";
    const STATUS_ATRASADO = "Atrasado";
    public function __construct(
        $idEstagio = null,
        $nome = '',
        $tipo = '',
        $arquivo = '',
        $status = self::STATUS_PENDENTE,
        $prazo = null
    ) {
        $this->idEstagio = $idEstagio;
        $this->nome = $nome;
        $this->tipo = $tipo;
        $this->arquivo = $arquivo;
        $this->status = $status;
        $this->prazo = $prazo;
    }
    public function getIdDocumento() { return $this->idDocumento; }
    public function setIdDocumento($idDocumento): void { $this->idDocumento = $idDocumento; }
    public function getIdEstagio() { return $this->idEstagio; }
    public function setIdEstagio($idEstagio): void { $this->idEstagio = $idEstagio; }
    public function getNome() { return $this->nome; }
    public function setNome($nome): void { $this->nome = $nome; }
    public function getTipo() { return $this->tipo; }
    public function setTipo($tipo): void { $this->tipo = $tipo; }
    public function getArquivo() { return $this->arquivo; }
    public function setArquivo($arquivo): void { $this->arquivo = $arquivo; }
    public function getStatus() { return $this->status; }
    public function setStatus($status): void { $this->status = $status; }
    public function getDataEnvio() { return $this->dataEnvio; }
    public function setDataEnvio($dataEnvio): void { $this->dataEnvio = $dataEnvio; }
    public function getPrazo() { return $this->prazo; }
    public function setPrazo($prazo): void { $this->prazo = $prazo; }
    public function save(): bool {
        $conexao = new MySQL();
        $conn = $conexao->getConnection();
        $stmt = $conn->prepare("
            INSERT INTO documento (
                idEstagio, nome, tipo, arquivo, status, dataEnvio, prazo
            ) VALUES (?, ?, ?, ?, ?, NOW(), ?)
        ");

        if (!$stmt) {
            error_log("Erro ao preparar statement: " . $conn->error);
            return false;
        }
        $idEstagio = $this->idEstagio;
        $nome = $this->nome;
        $tipo = $this->tipo;
        $arquivo = $this->arquivo;
        $status = $this->status;
        $prazo = $this->prazo;
        $stmt->bind_param("isssss", $idEstagio, $nome, $tipo, $arquivo, $status, $prazo);
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
                tipo = '{$this->tipo}',
                arquivo = '{$this->arquivo}',
                status = '{$this->status}',
                prazo = '{$this->prazo}'
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
            $row['tipo'] ?? '',
            $row['arquivo'] ?? '',
            $row['status'] ?? self::STATUS_PENDENTE,
            $row['prazo'] ?? null
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
                $row['tipo'] ?? '',
                $row['arquivo'] ?? '',
                $row['status'] ?? self::STATUS_PENDENTE,
                $row['prazo'] ?? null
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