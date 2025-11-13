
<?php
require_once __DIR__."/../bd/MySQL.php";

class Estagio{

    private $idEstagio;
    private $name;
    private $dataInicio;
    private $dataFim;
    private $empresa;
    private $setorEmpresa;
    private $vinculoTrabalhista;
    private $obrigatorio;
    private $nameSupervisor;
    private $emailSupervisor;
    private $professor;
    private $idAluno;
    private $idProfessor;
    private $status;

    const STATUS_FINALIZADO = 0;
    const STATUS_ATIVO = 1;
    const STATUS_EM_ANDAMENTO = 2;
    // alias to keep naming consistent with UI (Concluído)
    const STATUS_CONCLUIDO = 2;

    public function __construct($name = '', $dataInicio = null, $dataFim = null,
        $empresa = '', $setorEmpresa = '', $vinculoTrabalhista = 0,
        $obrigatorio = 0, $nameSupervisor = '', $emailSupervisor = '',
        $professor = '', $idAluno = null, $idProfessor = null, $status = 1){

        $this->name = $name;
        $this->dataInicio = $dataInicio;
        $this->dataFim = $dataFim;
        $this->empresa = $empresa;
        $this->setorEmpresa = $setorEmpresa;
        $this->vinculoTrabalhista = $vinculoTrabalhista;
        $this->obrigatorio = $obrigatorio;
        $this->nameSupervisor = $nameSupervisor;
        $this->emailSupervisor = $emailSupervisor;
        $this->professor = $professor;
        $this->idAluno = $idAluno;
        $this->idProfessor = $idProfessor;
        $this->status = $status;
    }

    public function getIdEstagio(){
        return $this->idEstagio;
    }

    public function setIdEstagio($idEstagio): void{
        $this->idEstagio = $idEstagio;
    }

    public function getIdAluno(){
        return $this->idAluno;
    }

    public function setIdAluno($idAluno): void{
        $this->idAluno = $idAluno;
    }

     public function getIdProfessor(){
        return $this->idProfessor;
    }

    public function setIdProfessor($idProfessor): void{
        $this->idProfessor = $idProfessor;
    }

    public function getName(){
        return $this->name;
    }

    public function setName($name): void{
        $this->name = $name;
    }

    public function getDataInicio(){
        return $this->dataInicio;
    }

    public function setDataInicio($dataInicio): void{
        $this->dataInicio = $dataInicio;
    }

    public function getDataFim(){
        return $this->dataFim;
    }

    public function setDataFim($dataFim): void{
        $this->dataFim = $dataFim;
    }

    public function getEmpresa(){
        return $this->empresa;
    }

    public function setEmpresa($empresa): void{
        $this->empresa = $empresa;
    }

    public function getSetorEmpresa(){
        return $this->setorEmpresa;
    }

    public function setSetorEmpresa($setorEmpresa): void{
        $this->setorEmpresa = $setorEmpresa;
    }

    public function isVinculoTrabalhista(){
        return $this->vinculoTrabalhista;
    }

    public function setVinculoTrabalhista($vinculo): void{
        $this->vinculoTrabalhista = $vinculo;
    }

    public function isObrigatorio(){
        return $this->obrigatorio;
    }

    public function setObrigatorio($obrigatorio): void{
        $this->obrigatorio = $obrigatorio;
    }

    public function getNameSupervisor(){
        return $this->nameSupervisor;
    }

    public function setNameSupervisor($nameSupervisor): void{
        $this->nameSupervisor = $nameSupervisor;
    }

    public function getEmailSupervisor(){
        return $this->emailSupervisor;
    }

    public function setEmailSupervisor($emailSupervisor): void{
        $this->emailSupervisor = $emailSupervisor;
    }

    public function getProfessor(){
        return $this->professor;
    }

    public function setProfessor($professor): void{
        $this->professor = $professor;
    }

    // salva as info usando prepared statement para maior segurança
    public function save(): bool {
        $conexao = new MySQL();
        $conn = $conexao->getConnection();

        $stmt = $conn->prepare(
            "INSERT INTO estagio (
                nome, dataInicio, dataFim, empresa, setorEmpresa,
                vinculoTrabalhista, nomeSupervisor, obrigatorio,
                emailSupervisor, idAluno, idProfessor
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
        );

        if (!$stmt) {
            error_log("Erro ao preparar statement: " . $conn->error);
            return false;
        }

        // usar variáveis locais (passadas por referência) — obrigatório no bind_param
        $nome = $this->name;
        $dataInicio = $this->dataInicio;
        $dataFim = $this->dataFim;
        $empresa = $this->empresa;
        $setorEmpresa = $this->setorEmpresa;
        $vinculo = intval($this->vinculoTrabalhista);
        $nomeSupervisor = $this->nameSupervisor;
        $obrigatorio = intval($this->obrigatorio);
        $emailSupervisor = $this->emailSupervisor;
        $idAluno = $this->idAluno !== null ? intval($this->idAluno) : null;
        $idProfessor = $this->idProfessor !== null ? intval($this->idProfessor) : null;

        // tipos: nome(s), dataInicio(s), dataFim(s), empresa(s), setorEmpresa(s), vinculo(i),
        // nomeSupervisor(s), obrigatorio(i), emailSupervisor(s), idAluno(i), idProfessor(i)
        $types = "sssssisisii"; // 11 parâmetros

        // bind_param exige parâmetros por referência; usar variáveis locais garante isso
        if (!$stmt->bind_param($types,
            $nome,
            $dataInicio,
            $dataFim,
            $empresa,
            $setorEmpresa,
            $vinculo,
            $nomeSupervisor,
            $obrigatorio,
            $emailSupervisor,
            $idAluno,
            $idProfessor
        )) {
            error_log("Erro ao bind_param: " . $stmt->error);
            $stmt->close();
            return false;
        }

        $result = $stmt->execute();
        if (!$result) {
            error_log("Erro ao executar statement: " . $stmt->error . " SQL: " . $stmt->sqlstate);
            $stmt->close();
            return false;
        }

        // define id inserido quando disponível
        $this->idEstagio = $conn->insert_id ?: $this->idEstagio;

        $stmt->close();
        return true;
    }

    //pega todas as infos
    public static function findall($idAluno = null): array {
        $conexao = new MySQL();

        $idUsuarioInt = (int) ($_SESSION['idUsuario']);
        $tipo = $_SESSION['tipo'] ?? 'aluno';

        if ($tipo === 'professor') {
            $sql = "SELECT e.*, a.nome AS nomeAluno
                    FROM estagio e
                    LEFT JOIN usuario a ON e.idAluno = a.idUsuario
                    WHERE e.idProfessor = {$idUsuarioInt}";
        } else {
            $sql = "SELECT e.*, u.nome AS nomeProfessor 
                    FROM estagio e 
                    LEFT JOIN usuario u ON e.idProfessor = u.idUsuario
                    WHERE e.idAluno = {$idUsuarioInt}";
        }

        $resultados = $conexao->consulta($sql);
        $estagios = array();
        foreach ($resultados as $resultado) {
            $profNome = $resultado['nomeProfessor'] ?? '';
            $e = new Estagio(
                $resultado['nome'] ?? '',
                $resultado['dataInicio'] ?? null,
                $resultado['dataFim'] ?? null,
                $resultado['empresa'] ?? '',
                $resultado['setorEmpresa'] ?? '',
                $resultado['vinculoTrabalhista'] ?? 0,
                $resultado['obrigatorio'] ?? 0,
                $resultado['nomeSupervisor'] ?? '',
                $resultado['emailSupervisor'] ?? '',
                $profNome,
                $resultado['idAluno'] ?? null,
                $resultado['idProfessor'] ?? null
            );
            $e->idEstagio = $resultado['idEstagio'] ?? null;
            $e->setStatus($resultado['status'] ?? 1);
            $estagios[] = $e;
        }

        return $estagios;
    }



    public static function find($idEstagio):Estagio{
        $conexao = new MySQL();
        // traz o estágio e o nome do professor (quando existir)
        $sql = "SELECT e.*, u.nome AS nomeProfessor FROM estagio e LEFT JOIN usuario u ON e.idProfessor = u.idUsuario WHERE e.idEstagio = {$idEstagio} LIMIT 1";
        $resultado = $conexao->consulta($sql);
        if (!isset($resultado[0])) {
            throw new Exception('Estágio não encontrado');
        }
        $row = $resultado[0];
        $profNome = $row['nomeProfessor'] ?? '';
        $e = new Estagio(
            $row['nome'] ?? '',
            $row['dataInicio'] ?? null,
            $row['dataFim'] ?? null,
            $row['empresa'] ?? '',
            $row['setorEmpresa'] ?? '',
            $row['vinculoTrabalhista'] ?? 0,
            $row['obrigatorio'] ?? 0,
            $row['nomeSupervisor'] ?? '',
            $row['emailSupervisor'] ?? '',
            $profNome,
            $row['idAluno'] ?? null,
            $row['idProfessor'] ?? null
        );
        $e->setIdEstagio($row['idEstagio'] ?? null);
        $e->setStatus($row['status'] ?? 1);
        return $e;
    }

    // atualiza um estagio existente
    public function update(): bool{
        if(!$this->idEstagio){
            return false;
        }
        $conexao = new MySQL();
        $sql = "UPDATE estagio SET 
            nome = '{$this->name}',
            dataInicio = '{$this->dataInicio}',
            dataFim = '{$this->dataFim}',
            empresa = '{$this->empresa}',
            setorEmpresa = '{$this->setorEmpresa}',
            vinculoTrabalhista = '{$this->vinculoTrabalhista}',
            obrigatorio = '{$this->obrigatorio}',
            nomeSupervisor = '{$this->nameSupervisor}',
            emailSupervisor = '{$this->emailSupervisor}',
            idAluno = '{$this->idAluno}',
            idProfessor = '{$this->idProfessor}'
            WHERE idEstagio = {$this->idEstagio}"
        ;
        echo '<pre>' . $sql . '</pre>';  // DEBUG: mostra o SQL
        $result = $conexao->executa($sql);
        if (!$result) {
            die('Erro ao atualizar o estágio!');
        }
        return $result;
    }

    public function getStatus(){
        return $this->status;
    }

    public function setStatus($status): void{
        $this->status = $status;
    }

    /**
     * Retorna um rótulo legível para um código de status
     */
    public static function getStatusLabel($status): string{
        $s = intval($status);
        switch($s){
            case self::STATUS_FINALIZADO:
                return 'Finalizado';
            case self::STATUS_ATIVO:
                return 'Ativo';
            case self::STATUS_CONCLUIDO:
            case self::STATUS_EM_ANDAMENTO:
                return 'Concluído';
            default:
                return 'Desconhecido';
        }
    }

    public function isConcluido(): bool{
        return intval($this->status) === self::STATUS_CONCLUIDO || intval($this->status) === self::STATUS_EM_ANDAMENTO;
    }

    /**
     * Atualiza apenas o campo status de um estágio (prepared statement)
     */
    public static function updateStatus(int $idEstagio, int $status): bool{
        $conexao = new MySQL();
        $conn = $conexao->getConnection();

        $sql = "UPDATE estagio SET status = ? WHERE idEstagio = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            error_log("Erro ao preparar statement (updateStatus): " . $conn->error);
            return false;
        }
        $s = intval($status);
        $id = intval($idEstagio);
        if (!$stmt->bind_param('ii', $s, $id)) {
            error_log("Erro ao bind_param (updateStatus): " . $stmt->error);
            $stmt->close();
            return false;
        }
        $res = $stmt->execute();
        if (!$res) {
            error_log("Erro ao executar statement (updateStatus): " . $stmt->error);
        }
        $stmt->close();
        return (bool)$res;
    }

    public function isFinalizado(): bool{
        return intval($this->status) === self::STATUS_FINALIZADO;
    }

    public function isAtivo(): bool{
        return intval($this->status) === self::STATUS_ATIVO || intval($this->status) === self::STATUS_EM_ANDAMENTO;
    }

    // marca um estágio como finalizado (soft-delete)
    public static function finalizar($idEstagio): bool{
        $conexao = new MySQL();
        $sql = "UPDATE estagio SET status = " . self::STATUS_FINALIZADO . " WHERE idEstagio = {$idEstagio}";
        return $conexao->executa($sql);
    }

    // alterna status (por exemplo abrir/fechar estágio)
    public static function mudarStatus($idEstagio): bool{
        $conexao = new MySQL();
        // pega status atual
        $sql = "SELECT status FROM estagio WHERE idEstagio = {$idEstagio}";
        $res = $conexao->consulta($sql);
        if(!isset($res[0])) return false;
        $novo = $res[0]['status'] == 1 ? 0 : 1;
        $sql2 = "UPDATE estagio SET status = {$novo} WHERE idEstagio = {$idEstagio}";
        return $conexao->executa($sql2);
    }

}