<?php

require_once __DIR__."/../bd/MySQL.php";

class Professor{

    private int $idProfessor;
    private date $data_hora_cadastro;
    private bool $disponivel = True;
    
    public function __construct(private string $nome, private string $email, private string $senha, 
    private int $status, private string $imagem){
    }

    public function getIdProfessor(): int {
        return $this->IdProfessor;
    }

    public function setIdProfessor(int $idProfessor): void {
        $this->IdProfessor = $idProfessor;
    }

    public function getDataHoraCadastro() {
        return $this->data_hora_cadastro;
    }

    public function setDataHoraCadastro($data): void {
        $this->data_hora_cadastro = $data;
    }

    public function isDisponivel(): bool {
        return $this->disponivel;
    }

    public function setDisponivel(bool $valor): void {
        $this->disponivel = $valor;
    }

    public function getNome(): string {
        return $this->nome;
    }

    public function setNome(string $nome): void {
        $this->nome = $nome;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function setEmail(string $email): void {
        $this->email = $email;
    }

    public function getSenha(): string {
        return $this->senha;
    }

    public function setSenha(string $senha): void {
        $this->senha = $senha;
    }

    public function getStatus(): int {
        return $this->status;
    }

    public function setStatus(int $status): void {
        $this->status = $status;
    }

    public function getImagem(): string {
        return $this->imagem;
    }

    public function setImagem(string $imagem): void {
        $this->imagem = $imagem;
    }
    
    public function save():bool{
        $conexao = new MySQL();
        $this->senha = password_hash($this->senha,PASSWORD_BCRYPT); 
        $sql = "INSERT INTO professor (email,senha,nome,status,imagem) VALUES ('{$this->email}','{$this->senha}',
        '{$this->nome}',{$this->status},'{$this->imagem}')";
        return $conexao->executa($sql);
    }

    public function authenticate():bool{
        $conexao = new MySQL();
        $sql = "SELECT IdProfessor,senha FROM professor WHERE email = '{$this->email}'";
        $resultados = $conexao->consulta($sql);
        if(count($resultados) > 0){
            if(password_verify($this->senha,$resultados[0]['senha'])){
                session_start();
                $_SESSION['IdProfessor'] = $resultados[0]['IdProfessor'];
                $_SESSION['email'] = $resultados[0]['email'];
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
}
