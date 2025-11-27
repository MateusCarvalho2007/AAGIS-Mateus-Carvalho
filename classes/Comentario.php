<?php
require_once __DIR__ . "/../bd/MySQL.php";

class Comentario {

    private $idComentario;
    private $idDocumento;
    private $idUsuario;
    private $comentario;
    private $dataHora;
    private $nomeUsuario;

    public function __construct($idDocumento = null, $idUsuario = null, $comentario = '', $dataHora = null) {
        $this->idDocumento = $idDocumento;
        $this->idUsuario = $idUsuario;
        $this->comentario = $comentario;
        $this->dataHora = $dataHora;
    }

    // Getters e Setters
    public function getIdComentario() { return $this->idComentario; }
    public function setIdComentario($id) { $this->idComentario = $id; }

    public function getIdDocumento() { return $this->idDocumento; }
    public function setIdDocumento($id) { $this->idDocumento = $id; }

    public function getIdUsuario() { return $this->idUsuario; }
    public function setIdUsuario($id) { $this->idUsuario = $id; }

    public function getComentario() { return $this->comentario; }
    public function setComentario($text) { $this->comentario = $text; }

    public function getDataHora() { return $this->dataHora; }
    public function setDataHora($dt) { $this->dataHora = $dt; }

    public function getNomeUsuario() { return $this->nomeUsuario; }
    public function setNomeUsuario($nome) { $this->nomeUsuario = $nome; }

    // Salvar novo comentário
    public function save(): bool {
        $conexao = new MySQL();
        $conn = $conexao->getConnection();

        // Verifica se o documento existe para evitar violação de FK
        if (empty($this->idDocumento) || intval($this->idDocumento) <= 0) {
            error_log("Comentário: idDocumento inválido: " . var_export($this->idDocumento, true));
            return false;
        }

        $checkStmt = $conn->prepare("SELECT idDocumento FROM documento WHERE idDocumento = ? LIMIT 1");
        if (!$checkStmt) {
            error_log("Erro ao preparar statement de verificação: " . $conn->error);
            return false;
        }
        $idDocInt = intval($this->idDocumento);
        $checkStmt->bind_param('i', $idDocInt);
        $checkStmt->execute();
        $checkRes = $checkStmt->get_result();
        if (!$checkRes || $checkRes->num_rows === 0) {
            // Documento não existe — registrar e abortar
            error_log("Comentário: documento não encontrado (idDocumento=" . $this->idDocumento . ")");
            $checkStmt->close();
            return false;
        }
        $checkStmt->close();

        $stmt = $conn->prepare("INSERT INTO comentario_documento (idDocumento, idUsuario, comentario, dataHora) VALUES (?, ?, ?, NOW())");
        if (!$stmt) {
            error_log("Erro ao preparar statement: " . $conn->error);
            return false;
        }

        $idDocumento = $idDocInt;
        $idUsuario = intval($this->idUsuario);
        $comentario = $this->comentario;

        $stmt->bind_param("iis", $idDocumento, $idUsuario, $comentario);
        $result = $stmt->execute();
        if ($result) {
            $this->idComentario = $conn->insert_id;
        } else {
            // Registra erro detalhado
            error_log("Erro ao executar INSERT comentario_documento: (" . $stmt->errno . ") " . $stmt->error);
        }

        $stmt->close();
        return $result;
    }

    // Atualizar comentário existente
    public function update(): bool {
        if (!$this->idComentario) {
            return false;
        }
        $conexao = new MySQL();
        $conn = $conexao->getConnection();

        $stmt = $conn->prepare("UPDATE comentario_documento SET comentario = ? WHERE idComentario = ?");
        if (!$stmt) {
            error_log("Erro ao preparar statement: " . $conn->error);
            return false;
        }

        $comentario = $this->comentario;
        $idComentario = $this->idComentario;

        $stmt->bind_param("si", $comentario, $idComentario);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    // Deletar comentário
    public static function delete($idComentario): bool {
        $conexao = new MySQL();
        $conn = $conexao->getConnection();

        $stmt = $conn->prepare("DELETE FROM comentario_documento WHERE idComentario = ?");
        if (!$stmt) {
            error_log("Erro ao preparar statement: " . $conn->error);
            return false;
        }

        $id = intval($idComentario);
        $stmt->bind_param("i", $id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    // Buscar todos os comentários de um documento
    public static function findByDocumento($idDocumento): array {
        $conexao = new MySQL();
        $conn = $conexao->getConnection();

        $stmt = $conn->prepare("SELECT cd.idComentario, cd.idDocumento, cd.idUsuario, cd.comentario, cd.dataHora, u.nome FROM comentario_documento cd LEFT JOIN usuario u ON cd.idUsuario = u.idUsuario WHERE cd.idDocumento = ? ORDER BY cd.dataHora DESC");
        if (!$stmt) {
            error_log("Erro ao preparar statement: " . $conn->error);
            return [];
        }

        $id = intval($idDocumento);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        $comentarios = [];
        while ($row = $result->fetch_assoc()) {
            $c = new Comentario(
                $row['idDocumento'],
                $row['idUsuario'],
                $row['comentario'],
                $row['dataHora']
            );
            $c->setIdComentario($row['idComentario']);
            $c->setNomeUsuario($row['nome']);
            $comentarios[] = $c;
        }

        $stmt->close();
        return $comentarios;
    }

    // Buscar um comentário específico
    public static function find($idComentario): ?Comentario {
        $conexao = new MySQL();
        $conn = $conexao->getConnection();

        $stmt = $conn->prepare("SELECT * FROM comentario_documento WHERE idComentario = ? LIMIT 1");
        if (!$stmt) {
            error_log("Erro ao preparar statement: " . $conn->error);
            return null;
        }

        $id = intval($idComentario);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            return null;
        }

        $row = $result->fetch_assoc();
        $c = new Comentario(
            $row['idDocumento'],
            $row['idUsuario'],
            $row['comentario'],
            $row['dataHora']
        );
        $c->setIdComentario($row['idComentario']);

        $stmt->close();
        return $c;
    }
}
?>