-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 25/11/2025 às 00:48
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
-- Estrutura para tabela `documento`
--

CREATE TABLE `documento` (
  `idDocumento` int(11) NOT NULL,
  `idEstagio` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `arquivo` text DEFAULT NULL,
  `status` int(11) NOT NULL,
  `dataEnvio` date DEFAULT NULL,
  `prazo` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `documento`
--

INSERT INTO `documento` (`idDocumento`, `idEstagio`, `nome`, `arquivo`, `status`, `dataEnvio`, `prazo`) VALUES
(1, 64, 'Autorização de Uso de Imagens', NULL, 0, NULL, NULL),
(2, 64, 'Plano de Atividades', NULL, 0, NULL, '2025-12-09'),
(3, 64, 'Relatório Final', NULL, 0, NULL, '2026-05-24'),
(4, 64, 'Relatório Parcial', NULL, 0, NULL, '2026-03-25');

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
  `idProfessor` int(11) NOT NULL,
  `status` int(10) NOT NULL,
  `professor` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `estagio`
--

INSERT INTO `estagio` (`idEstagio`, `nome`, `dataInicio`, `dataFim`, `empresa`, `setorEmpresa`, `vinculoTrabalhista`, `nomeSupervisor`, `obrigatorio`, `emailSupervisor`, `idAluno`, `idProfessor`, `status`, `professor`) VALUES
(60, 'Mathias Scherer', '2025-11-01', '2025-11-15', 'Dell', 'Suporte Técnico Servidor', 0, 'Sergio Robertos', 1, 'robertosergio@email.com', 1, 20, 1, ''),
(64, 'Mathias Scherer', '2025-11-01', '2025-11-15', 'SAP', 'Developer', 0, 'Sergio Robertos', 1, 'robertosergio@email.com', 1, 20, 1, 'asd');

--
-- Acionadores `estagio`
--
DELIMITER $$
CREATE TRIGGER `criaAutorizacaoImagem` AFTER INSERT ON `estagio` FOR EACH ROW BEGIN
    INSERT INTO documento(idEstagio, nome, status, prazo)
    VALUES (NEW.idEstagio, 'Autorização de Uso de Imagens', 0, null);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `criaPlanoDeAtividades` AFTER INSERT ON `estagio` FOR EACH ROW BEGIN
    INSERT INTO documento(idEstagio, nome, status, prazo)
    VALUES (NEW.idEstagio, 'Plano de Atividades', 0, NOW() + INTERVAL 14 DAY);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `criaRelatorioFinal` AFTER INSERT ON `estagio` FOR EACH ROW BEGIN
    INSERT INTO documento(idEstagio, nome, status, prazo)
    VALUES (NEW.idEstagio, 'Relatório Final', 0, NOW() + INTERVAL 180 DAY);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `criaRelatorioParcial` AFTER INSERT ON `estagio` FOR EACH ROW BEGIN
    INSERT INTO documento(idEstagio, nome, status, prazo)
    VALUES (NEW.idEstagio, 'Relatório Parcial', 0, NOW() + INTERVAL 120 DAY);
END
$$
DELIMITER ;

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
-- Estrutura para tabela `professor_solicitacao`
--

CREATE TABLE `professor_solicitacao` (
  `idProfessorSolicitacao` int(11) NOT NULL,
  `idProfessor` int(11) NOT NULL,
  `idSolicitacao` int(11) NOT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `professor_solicitacao`
--

INSERT INTO `professor_solicitacao` (`idProfessorSolicitacao`, `idProfessor`, `idSolicitacao`, `status`) VALUES
(1, 12, 2, 1),
(2, 21, 2, 0),
(3, 12, 3, 0),
(4, 14, 3, 0),
(5, 9, 3, 0),
(6, 21, 3, 0),
(7, 21, 4, 2),
(8, 12, 5, 2),
(9, 14, 5, 2),
(10, 20, 6, 2),
(11, 20, 7, 2),
(12, 22, 7, 2),
(13, 12, 8, 2),
(14, 14, 8, 2),
(15, 9, 9, 1),
(16, 14, 10, 2),
(17, 20, 10, 2),
(18, 9, 10, 2),
(19, 21, 10, 2),
(20, 14, 11, 2),
(21, 20, 11, 2),
(22, 9, 11, 2),
(23, 21, 11, 2),
(24, 22, 11, 2),
(25, 8, 11, 2),
(26, 12, 11, 2),
(27, 24, 11, 2);

-- --------------------------------------------------------

--
-- Estrutura para tabela `solicitacao`
--

CREATE TABLE `solicitacao` (
  `idSolicitacao` int(11) NOT NULL,
  `empresa` varchar(255) NOT NULL,
  `areaAtuacao` varchar(500) NOT NULL,
  `tipoEstagio` varchar(50) NOT NULL,
  `carga_horaria_semanal` int(11) DEFAULT NULL,
  `turno` varchar(50) DEFAULT NULL,
  `obs` text DEFAULT NULL,
  `data` timestamp NOT NULL DEFAULT current_timestamp(),
  `idAluno` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `solicitacao`
--

INSERT INTO `solicitacao` (`idSolicitacao`, `empresa`, `areaAtuacao`, `tipoEstagio`, `carga_horaria_semanal`, `turno`, `obs`, `data`, `idAluno`) VALUES
(1, 'Grupo k1', 'Ti', 'obrigatorio', 20, 'manha', 'Não tem', '2025-11-11 23:09:01', 16),
(2, 'Grupo k1', 'Ti', 'obrigatorio', 12, 'manha', 'Sei não', '2025-11-11 23:13:25', 16),
(3, 'Grupo k1', 'Ti', 'nao-obrigatorio', 20, 'manha', 'Oi', '2025-11-13 16:05:32', 16),
(4, 'Grupo k2', 'Ti', 'obrigatorio', 20, 'nao-sei', 'Nada', '2025-11-13 16:08:06', 16),
(5, 'e', 'e', 'obrigatorio', NULL, 'nao-sei', NULL, '2025-11-13 19:44:57', 16),
(9, 'Madesa', 'TI', 'obrigatorio', 30, 'manha', NULL, '2025-11-25 00:08:02', 4),
(11, 'Brombate', 'mercado', 'nao-obrigatorio', 20, 'nao-sei', 'testando', '2025-11-25 00:33:52', 4);

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
(1, 'Mathias Scherer', 'mathias.scherer@aluno.feliz.ifrs.edu.br', '$2y$10$m2leGuQIEUANQsychQNL/ehnxmFwsOWEMk8vc4c2neFL5Z8oZBvTu', 0, 'aluno', '2025-10-26 22:36:48', 'img_6923999d226b28.74963614.png', 0),
(2, 'Nauany Gomes ', 'nauany.alves@aluno.feliz.ifrs.edu.br', '$2y$10$uTVc3aVSlKgTEzODdwlrhOcKlTkIZMZbGdBWYaw1SYP25qdUCGDTC', 0, 'aluno', '2025-10-26 23:02:59', NULL, 1),
(4, 'milena spohr', 'milena.spohr@aluno.feliz.ifrs.edu.br', '$2y$10$lRwxQSqGxi9J08NQLwgIy.3jML4zpW0qEe73MLvRZDcr/Io0bTrSa', 0, 'aluno', '2025-10-26 23:21:46', 'img_6924fc85396336.45312060.jpg', 0),
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
(20, 'asd', 'asd@feliz.ifrs.edu.br', '$2y$10$iIz7nz3brlO74KBrHD5yK.QKB5Y9nbFoajIiWh.Vqb04Qb3oxHu3y', 0, 'professor', '2025-11-03 22:25:08', NULL, 1),
(21, 'Lucas Jose', 'lucas.jose@feliz.ifrs.edu.br', '$2y$10$8FyXx95MnrL51L30UmC.RurwCsIJP6uIaJqHKVuHDoQBnnb7uwU4e', 0, 'professor', '2025-11-18 17:24:36', NULL, 1),
(22, 'Lucas Meurer Leichtweis', 'lucas.meurer@feliz.ifrs.edu.br', '$2y$10$30/R.Gll4oTdzONAStO4uORL/bPJJPMtAUfh3E5BWfFg/kv97VCYq', 0, 'professor', '2025-11-18 17:28:14', NULL, 1),
(23, 'gabi teste', 'gabriela.teste@aluno.feliz.ifrs.edu.br', '$2y$10$XVViHWqz9o4KnWEtt2fOIe5hvCtNnlWJFJXAxU9aKJsicv3K5iYtK', 0, 'aluno', '2025-11-24 23:50:09', NULL, 0),
(24, 'testee', 'testee@feliz.ifrs.edu.br', '$2y$10$3pL9pgFHH/SmpEL3lFDh3eQQG3H00qUlbeWsIj1xauTtbqw39UM9y', 0, 'professor', '2025-11-25 00:25:04', NULL, 1);

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
(31, 20, 15),
(34, 21, 2),
(35, 21, 8),
(36, 22, 5),
(37, 9, 13),
(38, 9, 14),
(39, 9, 16),
(40, 9, 17),
(41, 23, 1),
(42, 4, 11),
(43, 4, 12),
(44, 4, 16);

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
(14, 7, 1),
(15, 7, 2),
(16, 7, 5),
(17, 7, 12),
(18, 8, 8),
(19, 8, 10),
(20, 8, 11),
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
(75, 20, 7),
(81, 21, 1),
(82, 21, 3),
(83, 21, 4),
(84, 21, 6),
(85, 22, 3),
(86, 22, 8),
(87, 22, 13),
(88, 9, 1),
(89, 9, 2),
(90, 9, 5),
(91, 9, 6),
(96, 23, 11),
(97, 23, 14),
(98, 23, 15),
(99, 23, 17),
(100, 24, 9),
(101, 24, 11),
(102, 24, 16),
(103, 4, 6),
(104, 4, 10),
(105, 4, 13),
(106, 4, 15);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`idAdmin`);

--
-- Índices de tabela `documento`
--
ALTER TABLE `documento`
  ADD PRIMARY KEY (`idDocumento`),
  ADD KEY `idEstagio` (`idEstagio`);

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
-- AUTO_INCREMENT de tabela `documento`
--
ALTER TABLE `documento`
  MODIFY `idDocumento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `estagio`
--
ALTER TABLE `estagio`
  MODIFY `idEstagio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT de tabela `interesse`
--
ALTER TABLE `interesse`
  MODIFY `idInteresse` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de tabela `professor_solicitacao`
--
ALTER TABLE `professor_solicitacao`
  MODIFY `idProfessorSolicitacao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de tabela `solicitacao`
--
ALTER TABLE `solicitacao`
  MODIFY `idSolicitacao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de tabela `usuario_desinteresse`
--
ALTER TABLE `usuario_desinteresse`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT de tabela `usuario_interesse`
--
ALTER TABLE `usuario_interesse`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `documento`
--
ALTER TABLE `documento`
  ADD CONSTRAINT `documento_ibfk_1` FOREIGN KEY (`idEstagio`) REFERENCES `estagio` (`idEstagio`);

--
-- Restrições para tabelas `estagio`
--
ALTER TABLE `estagio`
  ADD CONSTRAINT `estagio_ibfk_1` FOREIGN KEY (`idAluno`) REFERENCES `usuario` (`idUsuario`),
  ADD CONSTRAINT `estagio_ibfk_2` FOREIGN KEY (`idProfessor`) REFERENCES `usuario` (`idUsuario`);

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
