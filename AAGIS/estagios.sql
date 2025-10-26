-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 27/10/2025 às 00:01
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `estagios`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `aluno`
--

CREATE TABLE `aluno` (
  `idAluno` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `status` int(11) DEFAULT NULL,
  `data_hora_cadastro` timestamp NOT NULL DEFAULT current_timestamp(),
  `imagem` varchar(255) DEFAULT NULL,
  `disponivel` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `aluno`
--

INSERT INTO `aluno` (`idAluno`, `nome`, `email`, `senha`, `status`, `data_hora_cadastro`, `imagem`, `disponivel`) VALUES
(1, 'teste', 'teste@teste', 'teste', 1, '2025-10-21 17:23:05', NULL, 1),
(2, 'Ana Paula', 'ana.paula@teste.com', 'teste', 1, '2025-10-21 18:01:34', NULL, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `estagio`
--

CREATE TABLE `estagio` (
  `idEstagio` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `dataInicio` date NOT NULL,
  `dataFim` date NOT NULL,
  `empresa` varchar(255) NOT NULL,
  `setorEmpresa` varchar(255) NOT NULL,
  `vinculoTrabalhista` tinyint(1) NOT NULL,
  `nomeSupervisor` varchar(255) NOT NULL,
  `obrigatorio` tinyint(1) NOT NULL,
  `emailSupervisor` varchar(255) NOT NULL,
  `idAluno` int(11) NOT NULL,
  `idProfessor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `estagio`
--

INSERT INTO `estagio` (`idEstagio`, `nome`, `dataInicio`, `dataFim`, `empresa`, `setorEmpresa`, `vinculoTrabalhista`, `nomeSupervisor`, `obrigatorio`, `emailSupervisor`, `idAluno`, `idProfessor`) VALUES
(1, '', '2025-11-01', '2026-04-30', 'Tech Solutions S.A.', 'Desenvolvimento', 1, 'João da Silva', 1, 'supervisor@techsolutions.com', 1, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `interesse`
--

CREATE TABLE `interesse` (
  `idInteresse` int(11) NOT NULL,
  `descricao` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `professor`
--

CREATE TABLE `professor` (
  `idProfessor` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `status` int(11) DEFAULT NULL,
  `data_hora_cadastro` timestamp NOT NULL DEFAULT current_timestamp(),
  `imagem` varchar(255) DEFAULT NULL,
  `disponivel` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `professor`
--

INSERT INTO `professor` (`idProfessor`, `nome`, `email`, `senha`, `status`, `data_hora_cadastro`, `imagem`, `disponivel`) VALUES
(1, 'Ana Paula', 'ana.paula@teste.com', 'teste', 1, '2025-10-21 18:42:26', NULL, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `professor_solicitacao`
--

CREATE TABLE `professor_solicitacao` (
  `id` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `idSolicitacao` int(11) NOT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `solicitacao`
--

CREATE TABLE `solicitacao` (
  `idSolicitacao` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `descricao` varchar(500) DEFAULT NULL,
  `carga_horaria_semanal` int(11) DEFAULT NULL,
  `idUsuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario_desinteresse`
--

CREATE TABLE `usuario_desinteresse` (
  `id` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `idInteresse` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario_interesse`
--

CREATE TABLE `usuario_interesse` (
  `id` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `idInteresse` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `aluno`
--
ALTER TABLE `aluno`
  ADD PRIMARY KEY (`idAluno`);

--
-- Índices de tabela `estagio`
--
ALTER TABLE `estagio`
  ADD PRIMARY KEY (`idEstagio`),
  ADD KEY `idAluno` (`idAluno`),
  ADD KEY `idProfessor` (`idProfessor`);

--
-- Índices de tabela `interesse`
--
ALTER TABLE `interesse`
  ADD PRIMARY KEY (`idInteresse`);

--
-- Índices de tabela `professor`
--
ALTER TABLE `professor`
  ADD PRIMARY KEY (`idProfessor`);

--
-- Índices de tabela `professor_solicitacao`
--
ALTER TABLE `professor_solicitacao`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_prof_solic_solicitacao` (`idSolicitacao`),
  ADD KEY `FK_prof_solic_usuario` (`idUsuario`);

--
-- Índices de tabela `solicitacao`
--
ALTER TABLE `solicitacao`
  ADD PRIMARY KEY (`idSolicitacao`),
  ADD KEY `FK_solicitacao_usuario` (`idUsuario`);

--
-- Índices de tabela `usuario_desinteresse`
--
ALTER TABLE `usuario_desinteresse`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_usuario_desinteresse_interesse` (`idInteresse`),
  ADD KEY `FK_usuario_desinteresse_usuario` (`idUsuario`);

--
-- Índices de tabela `usuario_interesse`
--
ALTER TABLE `usuario_interesse`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_usuario_interesse_interesse` (`idInteresse`),
  ADD KEY `FK_usuario_interesse_usuario` (`idUsuario`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `aluno`
--
ALTER TABLE `aluno`
  MODIFY `idAluno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `estagio`
--
ALTER TABLE `estagio`
  MODIFY `idEstagio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `interesse`
--
ALTER TABLE `interesse`
  MODIFY `idInteresse` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `professor`
--
ALTER TABLE `professor`
  MODIFY `idProfessor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `professor_solicitacao`
--
ALTER TABLE `professor_solicitacao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `solicitacao`
--
ALTER TABLE `solicitacao`
  MODIFY `idSolicitacao` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `usuario_desinteresse`
--
ALTER TABLE `usuario_desinteresse`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `usuario_interesse`
--
ALTER TABLE `usuario_interesse`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `estagio`
--
ALTER TABLE `estagio`
  ADD CONSTRAINT `estagio_ibfk_1` FOREIGN KEY (`idAluno`) REFERENCES `aluno` (`idAluno`),
  ADD CONSTRAINT `estagio_ibfk_2` FOREIGN KEY (`idProfessor`) REFERENCES `professor` (`idProfessor`);

--
-- Restrições para tabelas `professor_solicitacao`
--
ALTER TABLE `professor_solicitacao`
  ADD CONSTRAINT `FK_prof_solic_solicitacao` FOREIGN KEY (`idSolicitacao`) REFERENCES `solicitacao` (`idSolicitacao`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_prof_solic_usuario` FOREIGN KEY (`idUsuario`) REFERENCES `aluno` (`idAluno`) ON DELETE CASCADE;

--
-- Restrições para tabelas `solicitacao`
--
ALTER TABLE `solicitacao`
  ADD CONSTRAINT `FK_solicitacao_usuario` FOREIGN KEY (`idUsuario`) REFERENCES `aluno` (`idAluno`) ON DELETE CASCADE;

--
-- Restrições para tabelas `usuario_desinteresse`
--
ALTER TABLE `usuario_desinteresse`
  ADD CONSTRAINT `FK_usuario_desinteresse_interesse` FOREIGN KEY (`idInteresse`) REFERENCES `interesse` (`idInteresse`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_usuario_desinteresse_usuario` FOREIGN KEY (`idUsuario`) REFERENCES `aluno` (`idAluno`) ON DELETE CASCADE;

--
-- Restrições para tabelas `usuario_interesse`
--
ALTER TABLE `usuario_interesse`
  ADD CONSTRAINT `FK_usuario_interesse_interesse` FOREIGN KEY (`idInteresse`) REFERENCES `interesse` (`idInteresse`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_usuario_interesse_usuario` FOREIGN KEY (`idUsuario`) REFERENCES `aluno` (`idAluno`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
