-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 04/11/2025 às 17:49
-- Versão do servidor: 11.8.3-MariaDB-log
-- Versão do PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `u157320114_extensaoG3G4`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `admin`
--

CREATE TABLE `admin` (
  `idAdmin` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `admin`
--

INSERT INTO `admin` (`idAdmin`, `email`, `senha`) VALUES
(3, 'admin@feliz.ifrs.edu.br', '$2y$10$KLHJQ40yLkZl2vsu4DEqZutrOgirbQvhIaaSzcRmB/o1CjIz5qSmC');

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
  `disponivel` tinyint(1) DEFAULT NULL,
  `idProfessor` int(11) NOT NULL,
  `orientador` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `aluno`
--

INSERT INTO `aluno` (`idAluno`, `nome`, `email`, `senha`, `status`, `data_hora_cadastro`, `imagem`, `disponivel`, `idProfessor`, `orientador`) VALUES
(1, 'gustavo', 'gustavo@email.com', '123', 1, '2025-10-21 20:23:05', NULL, 1, 2, 'julio'),
(12, 'fernando', 'fernando@email.com', '123', 1, '2025-10-28 04:57:57', 'null', 1, 2, 'julio'),
(13, 'Maria', 'maria@gmail.com', '123', 1, '2025-10-28 17:36:28', NULL, NULL, 2, 'julio');

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
(33, 'Gustavo', '2025-10-16', '2025-10-31', 'Tech Solutions S.A.', 'suporte técnico', 1, 'LUCAS FLACH KUNRATH', 0, 'lfk@gmail.com', 1, 2),
(50, 'Gustavo', '2025-10-04', '2025-10-30', 'Fueltech', 'Eletronic Central Unit', 0, 'Anderson', 1, 'anderson@teste', 1, 2),
(52, 'fernando', '2025-10-02', '2026-02-01', 'SAP', 'TI', 0, 'Diego', 0, 'diogo12@gmail.com', 12, 2),
(53, 'gustavo', '2025-10-01', '2025-10-29', 'BrasilTech', 'TI', 0, 'Carlos', 1, 'Carlos@gmail.com', 1, 2),
(54, 'gustavo', '2025-10-09', '2025-10-14', 'Brasil tech', 'RMA', 0, 'Matheus Griebler', 1, 'matheusGriebler@gmail.com', 1, 2),
(55, 'fernando', '2025-10-01', '2025-10-09', 'Madesa', 'TI', 0, 'Carlos da Silva', 1, 'Carlos@gmail.com', 12, 2),
(56, 'fernando', '2025-10-01', '2025-10-23', 'DELL', 'TI', 1, 'Cláudio', 1, 'claudio@gmail.com', 12, 2),
(57, 'fernando', '2025-10-30', '2025-10-31', 'if', 'ti', 1, 'tulio', 1, 'tulio@email.com', 12, 2),
(58, 'Maria', '2025-10-01', '2025-10-10', 'ifrs', 'TI', 0, 'joel', 1, 'joel@ifrs.com', 13, 2);

-- --------------------------------------------------------

--
-- Estrutura para tabela `interesse`
--

CREATE TABLE `interesse` (
  `idInteresse` int(11) NOT NULL,
  `descricao` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `interesse`
--

INSERT INTO `interesse` (`idInteresse`, `descricao`) VALUES
(1, 'Desenvolvimento de software'),
(2, 'Desenvolvimento web'),
(3, 'Desenvolvimento mobile'),
(4, 'Inteligência artificial'),
(5, 'Machine learning'),
(6, 'Data science'),
(7, 'Big data'),
(8, 'Computação em nuvem (Cloud computing)'),
(9, 'DevOps'),
(10, 'Segurança da informação'),
(11, 'Redes de computadores'),
(12, 'Banco de dados'),
(13, 'Sustentabilidade'),
(14, 'Conservação ambiental'),
(15, 'Reciclagem e gerenciamento de resíduos'),
(16, 'Energias renováveis'),
(17, 'Mudanças climáticas');

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
(2, 'julio', 'julio@teste.com', 'teste', 1, '2025-10-28 03:32:39', NULL, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `professor_solicitacao`
--

CREATE TABLE `professor_solicitacao` (
  `idProfessorSolicitacao` int(11) NOT NULL,
  `idProfessor` int(11) NOT NULL,
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
  `idAluno` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

CREATE TABLE `usuario` (
  `idUsuario` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `status` int(11) DEFAULT NULL,
  `tipo` varchar(255) NOT NULL,
  `data_hora_cadastro` timestamp NOT NULL DEFAULT current_timestamp(),
  `imagem` varchar(255) DEFAULT NULL,
  `disponivel` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuario`
--

INSERT INTO `usuario` (`idUsuario`, `nome`, `email`, `senha`, `status`, `tipo`, `data_hora_cadastro`, `imagem`, `disponivel`) VALUES
(1, 'Mathias Scherer', 'mathias.scherer@aluno.feliz.ifrs.edu.br', '$2y$10$m2leGuQIEUANQsychQNL/ehnxmFwsOWEMk8vc4c2neFL5Z8oZBvTu', 0, 'aluno', '2025-10-26 22:36:48', NULL, 1),
(2, 'Nauany Gomes ', 'nauany.alves@aluno.feliz.ifrs.edu.br', '$2y$10$uTVc3aVSlKgTEzODdwlrhOcKlTkIZMZbGdBWYaw1SYP25qdUCGDTC', 0, 'aluno', '2025-10-26 23:02:59', NULL, 1),
(4, 'milena spohr', 'milena.spohr@aluno.feliz.ifrs.edu.br', '$2y$10$lRwxQSqGxi9J08NQLwgIy.3jML4zpW0qEe73MLvRZDcr/Io0bTrSa', 0, 'aluno', '2025-10-26 23:21:46', NULL, 1),
(5, 'John Test da Silva', 'john.teste@feliz.ifrs.edu.br', '$2y$10$zwOTCR8twzz0lEdpsO.QXOX9GF9VLbQIJoOCo7DvEQCjImBf0LNpm', 0, 'professor', '2025-10-27 00:36:15', NULL, 1),
(6, 'Thaila Caroline Rocha de Jesus', 'thaila.jesus@aluno.feliz.ifrs.edu.br', '$2y$10$IWLe0crzAU5ykc0I3/mOJembQqoTz22Sh.nonNbL9JyL6zLWI1MES', 0, 'aluno', '2025-10-27 00:47:31', NULL, 1),
(7, 'Luiz Henrique Müller Pacheco', 'luiz.pacheco@aluno.feliz.ifrs.edu.br', '$2y$10$mX/eJOoV4PL1qTNqpk1fZuXZFGzP3pLdulX2zm1PqXy0ECcAkIx9u', 0, 'aluno', '2025-10-27 11:08:08', NULL, 1),
(8, 'Ronaldo Müller', 'ronaldo.muller@feliz.ifrs.edu.br', '$2y$10$IVQvSc6GnSINMJl9NVP84ei7.MSm88hgY52Qml6gdDF3Bomz0Apsi', 0, 'professor', '2025-10-27 11:16:42', NULL, 1),
(9, 'João de Jesus', 'joao.jesus@feliz.ifrs.edu.br', '$2y$10$Nkn8Ve6GYPdEvmds3Fjxy.g1uYHp3NRRBbdYiyj2ktQ.ZN9avVE0C', 0, 'professor', '2025-10-27 11:26:46', NULL, 1),
(10, 'Nicolas Kochhann', 'nicolas.kochhann@aluno.feliz.ifrs.edu.br', '$2y$10$cnSZXxF0ujDJUgV9r5Up2egLqVF6yAPNoRQOkBbLshN8JwwwkEFD.', 0, 'aluno', '2025-10-28 00:35:24', NULL, 1),
(11, 'luiz', 'luiz@aluno.feliz.ifrs.edu.br', '$2y$10$awqqqJuxtzGzAO/UWxG0huLjrGn6Vvuwy6GbaHYlJTL.kcq0fQqTG', 0, 'aluno', '2025-10-28 11:07:22', NULL, 1),
(12, 'Túlio Baségio', 'tulio.basegio@feliz.ifrs.edu.br', '$2y$10$RHhzPIuPFJtJUltCokr6yOcEAEEMA47Gu/o2qhJT8OWJJFYuV8eca', 0, 'professor', '2025-10-28 16:38:40', NULL, 1),
(13, 'João dos Campos', 'joao.campos@aluno.feliz.ifrs.edu.br', '$2y$10$5TzXPSU8/IkkpOJ7QtPdqOVtpAR5bGfd5.41hhHDgeSY8d57ndITy', 0, 'aluno', '2025-10-28 16:50:43', NULL, 1),
(14, 'Ana Paula Lemke', 'ana.lemke@feliz.ifrs.edu.br', '$2y$10$n8zPsmBPgERf9Q4hrD/ux.pP6VfVJKd1wgDxYhJsHkkSbenXItDf6', 0, 'professor', '2025-10-28 16:52:06', NULL, 1),
(15, 'Jose Soarez', 'ze.soarez@aluno.feliz.ifrs.edu.br', '$2y$10$uVZx7DXXdWtB/GglWmAQ9uSbU/WwtrkhIYRl1AmvGsezaE8Qdl7.y', 0, 'aluno', '2025-10-28 16:53:48', NULL, 1),
(16, 'Lucas Meurer Leichtweis', 'lucas.leichtweis@aluno.feliz.ifrs.edu.br', '$2y$10$6NWDLS2duBs24Eu1TRnX4.gtqVOhedoiW8jOp2tj0FCDqigIurNci', 0, 'aluno', '2025-11-02 23:39:37', NULL, 1),
(17, 'João Almeida', 'joao.almeida@aluno.feliz.ifrs.edu.br', '$2y$10$rO/CNU74.9vtYP4ZSn0iTOgojcayw/ECh9qMHqd/vPzi6hTwPTDSe', 0, 'aluno', '2025-11-03 01:29:36', NULL, 1),
(20, 'asd', 'asd@feliz.ifrs.edu.br', '$2y$10$iIz7nz3brlO74KBrHD5yK.QKB5Y9nbFoajIiWh.Vqb04Qb3oxHu3y', 0, 'professor', '2025-11-03 22:25:08', NULL, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario_desinteresse`
--

CREATE TABLE `usuario_desinteresse` (
  `id` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `idInteresse` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuario_desinteresse`
--

INSERT INTO `usuario_desinteresse` (`id`, `idUsuario`, `idInteresse`) VALUES
(1, 1, 2),
(2, 1, 3),
(3, 1, 5),
(4, 2, 3),
(5, 2, 7),
(6, 2, 15),
(7, 2, 17),
(9, 4, 11),
(10, 7, 4),
(11, 7, 10),
(12, 7, 13),
(13, 7, 14),
(14, 7, 15),
(15, 7, 16),
(16, 7, 17),
(17, 8, 15),
(18, 13, 4),
(19, 13, 6),
(20, 16, 11),
(21, 17, 3),
(22, 17, 10),
(29, 20, 2),
(30, 20, 12),
(31, 20, 15);

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
-- Despejando dados para a tabela `usuario_interesse`
--

INSERT INTO `usuario_interesse` (`id`, `idUsuario`, `idInteresse`) VALUES
(1, 1, 6),
(2, 1, 7),
(3, 1, 9),
(4, 2, 4),
(5, 2, 11),
(6, 2, 12),
(11, 4, 6),
(12, 4, 10),
(13, 4, 13),
(14, 7, 1),
(15, 7, 2),
(16, 7, 5),
(17, 7, 12),
(18, 8, 8),
(19, 8, 10),
(20, 8, 11),
(21, 9, 1),
(22, 9, 2),
(23, 9, 3),
(24, 10, 1),
(25, 10, 2),
(26, 10, 3),
(27, 10, 9),
(28, 11, 1),
(29, 11, 2),
(30, 11, 3),
(31, 12, 1),
(32, 12, 2),
(33, 12, 3),
(34, 12, 7),
(35, 12, 8),
(36, 12, 12),
(37, 12, 13),
(38, 12, 17),
(39, 13, 1),
(40, 13, 2),
(41, 13, 3),
(42, 13, 10),
(43, 13, 12),
(44, 14, 1),
(45, 14, 10),
(46, 14, 11),
(47, 14, 12),
(48, 15, 11),
(49, 15, 12),
(50, 15, 13),
(51, 15, 14),
(52, 16, 1),
(53, 16, 2),
(54, 16, 12),
(55, 17, 1),
(56, 17, 2),
(57, 17, 4),
(58, 17, 5),
(59, 17, 6),
(60, 17, 8),
(61, 17, 11),
(71, 20, 1),
(72, 20, 3),
(73, 20, 5),
(74, 20, 6),
(75, 20, 7);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`idAdmin`);

--
-- Índices de tabela `aluno`
--
ALTER TABLE `aluno`
  ADD PRIMARY KEY (`idAluno`),
  ADD KEY `idProfessor` (`idProfessor`);

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
  ADD PRIMARY KEY (`idProfessorSolicitacao`),
  ADD KEY `FK_prof_solic_solicitacao` (`idSolicitacao`),
  ADD KEY `FK_prof_solic_usuario` (`idProfessor`);

--
-- Índices de tabela `solicitacao`
--
ALTER TABLE `solicitacao`
  ADD PRIMARY KEY (`idSolicitacao`),
  ADD KEY `FK_solicitacao_usuario` (`idAluno`);

--
-- Índices de tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idUsuario`);

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
-- AUTO_INCREMENT de tabela `admin`
--
ALTER TABLE `admin`
  MODIFY `idAdmin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `aluno`
--
ALTER TABLE `aluno`
  MODIFY `idAluno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de tabela `estagio`
--
ALTER TABLE `estagio`
  MODIFY `idEstagio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT de tabela `interesse`
--
ALTER TABLE `interesse`
  MODIFY `idInteresse` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de tabela `professor`
--
ALTER TABLE `professor`
  MODIFY `idProfessor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `professor_solicitacao`
--
ALTER TABLE `professor_solicitacao`
  MODIFY `idProfessorSolicitacao` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `solicitacao`
--
ALTER TABLE `solicitacao`
  MODIFY `idSolicitacao` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de tabela `usuario_desinteresse`
--
ALTER TABLE `usuario_desinteresse`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de tabela `usuario_interesse`
--
ALTER TABLE `usuario_interesse`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `aluno`
--
ALTER TABLE `aluno`
  ADD CONSTRAINT `aluno_ibfk_1` FOREIGN KEY (`idProfessor`) REFERENCES `professor` (`idProfessor`);

--
-- Restrições para tabelas `estagio`
--
ALTER TABLE `estagio`
  ADD CONSTRAINT `estagio_ibfk_2` FOREIGN KEY (`idAluno`) REFERENCES `aluno` (`idAluno`),
  ADD CONSTRAINT `estagio_ibfk_3` FOREIGN KEY (`idProfessor`) REFERENCES `professor` (`idProfessor`);

--
-- Restrições para tabelas `professor_solicitacao`
--
ALTER TABLE `professor_solicitacao`
  ADD CONSTRAINT `FK_prof_solic_solicitacao` FOREIGN KEY (`idSolicitacao`) REFERENCES `solicitacao` (`idSolicitacao`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_prof_solic_usuario` FOREIGN KEY (`idProfessor`) REFERENCES `usuario` (`idUsuario`) ON DELETE CASCADE;

--
-- Restrições para tabelas `solicitacao`
--
ALTER TABLE `solicitacao`
  ADD CONSTRAINT `FK_solicitacao_usuario` FOREIGN KEY (`idAluno`) REFERENCES `usuario` (`idUsuario`) ON DELETE CASCADE;

--
-- Restrições para tabelas `usuario_desinteresse`
--
ALTER TABLE `usuario_desinteresse`
  ADD CONSTRAINT `FK_usuario_desinteresse_interesse` FOREIGN KEY (`idInteresse`) REFERENCES `interesse` (`idInteresse`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_usuario_desinteresse_usuario` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`) ON DELETE CASCADE;

--
-- Restrições para tabelas `usuario_interesse`
--
ALTER TABLE `usuario_interesse`
  ADD CONSTRAINT `FK_usuario_interesse_interesse` FOREIGN KEY (`idInteresse`) REFERENCES `interesse` (`idInteresse`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_usuario_interesse_usuario` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
