<?php

//metodos para funcionar o bd
require_once __DIR__."/Configuracao.php";

class MySQL{
	
	private $connection;
	
	//faz conectar com o sql sem ter que colocar o script na pasta
	public function __construct(){
		try {
			// Tenta conectar primeiro sem especificar o banco
			$this->connection = new \mysqli(HOST, USUARIO, SENHA, BANCO);
			
			if ($this->connection->connect_error) {
				throw new Exception('Erro de conexão: ' . $this->connection->connect_error);
			}
			
			// Tenta criar o banco se não existir
			$this->connection->query("CREATE DATABASE IF NOT EXISTS " . BANCO);
			
			// Seleciona o banco
			$this->connection->select_db(BANCO);
			
			// Define charset
			$this->connection->set_charset("utf8");
			
		} catch (Exception $e) {
			error_log("Erro na conexão MySQL: " . $e->getMessage());
			throw $e;
		}
	}
	
	// Método para acessar a conexão (necessário para prepared statements)
	public function getConnection() {
		return $this->connection;
	}

	public function executa($sql){
		try {
			$result = $this->connection->query($sql);
			if ($result === false) {
				throw new Exception("Erro na query: " . $this->connection->error);
			}
			return $result;
		} catch (Exception $e) {
			error_log("Erro ao executar query: " . $e->getMessage());
			throw $e;
		}
	}
	
	public function consulta($sql){
		try {
			$result = $this->connection->query($sql);
			if ($result === false) {
				throw new Exception("Erro na consulta: " . $this->connection->error);
			}
			
			$data = array();
			while($item = mysqli_fetch_array($result, MYSQLI_ASSOC)){
				$data[] = $item;
			}
			return $data;
		} catch (Exception $e) {
			error_log("Erro ao consultar: " . $e->getMessage());
			throw $e;
		}
	}
	}
?>