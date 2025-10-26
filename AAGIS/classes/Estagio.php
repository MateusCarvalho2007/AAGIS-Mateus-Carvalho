<?php
require_once __DIR__."/../bd/MySQL.php";

class Estagio{

    // propriedades públicas/privadas sem tipagem estrita para compatibilidade
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

    // status constants
    const STATUS_FINALIZADO = 0;
    const STATUS_ATIVO = 1;
    const STATUS_EM_ANDAMENTO = 2;

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

    //salva as info
    public function save():bool{
        $conexao = new MySQL();
        $sql = "INSERT INTO estagio (name, dataInicio, dataFim, empresa, setorEmpresa, vinculoTrabalhista, 
        obrigatorio, nameSupervisor, emailSupervisor, professor, idAluno, idProfessor, status)
        VALUES ('{$this->name}', '{$this->dataInicio}', '{$this->dataFim}', '{$this->empresa}',
        '{$this->setorEmpresa}', '{$this->vinculoTrabalhista}', '{$this->obrigatorio}', '{$this->nameSupervisor}',
        '{$this->emailSupervisor}', '{$this->professor}', '{$this->idAluno}', '{$this->idProfessor}', '{$this->status}')";
        return $conexao->executa($sql);
    }

    //pega todas as infos
     public static function findall():array{
        $conexao = new MySQL();
        $sql = "SELECT * FROM estagio";
        $resultados = $conexao->consulta($sql);
        $estagios = array();
        foreach($resultados as $resultado){
            $e = new Estagio(
                $resultado['name'] ?? '',
                $resultado['dataInicio'] ?? null,
                $resultado['dataFim'] ?? null,
                $resultado['empresa'] ?? '',
                $resultado['setorEmpresa'] ?? '',
                $resultado['vinculoTrabalhista'] ?? 0,
                $resultado['obrigatorio'] ?? 0,
                $resultado['nameSupervisor'] ?? '',
                $resultado['emailSupervisor'] ?? '',
                $resultado['professor'] ?? '',
                $resultado['idAluno'] ?? null,
                $resultado['idProfessor'] ?? null,
                $resultado['status'] ?? 1
            );
            $e->idEstagio = $resultado['idEstagio'] ?? null;
            $e->setStatus($resultado['status'] ?? 1);
            $estagios[] = $e;
        }
        return $estagios;
    }

    public static function find($idEstagio):Estagio{
        $conexao = new MySQL();
        $sql = "SELECT * FROM estagio WHERE idEstagio = {$idEstagio}";
        $resultado = $conexao->consulta($sql);
        $row = $resultado[0];
        $e = new Estagio(
            $row['name'] ?? '',
            $row['dataInicio'] ?? null,
            $row['dataFim'] ?? null,
            $row['empresa'] ?? '',
            $row['setorEmpresa'] ?? '',
            $row['vinculoTrabalhista'] ?? 0,
            $row['obrigatorio'] ?? 0,
            $row['nameSupervisor'] ?? '',
            $row['emailSupervisor'] ?? '',
            $row['professor'] ?? '',
            $row['idAluno'] ?? null,
            $row['idProfessor'] ?? null,
            $row['status'] ?? 1
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

    //STATIC = NAO PRECISA CRIAR OBJETO PRA USAR O MÉTODO
    //BOOL = VALOR Q VAI RETORNAR

}