-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 19-Set-2023 às 17:47
-- Versão do servidor: 10.4.27-MariaDB
-- versão do PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `clinica`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `agreements`
--

CREATE TABLE `agreements` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `descricao` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `agreements`
--

INSERT INTO `agreements` (`id`, `nome`, `descricao`) VALUES
(1, 'Particular', 'Consultas particulares e cadastro de usuários sem convênio.'),
(2, 'Unimed', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `schedule`
--

CREATE TABLE `schedule` (
  `id` int(11) NOT NULL,
  `dia` date NOT NULL,
  `hora` time NOT NULL,
  `medico` int(11) NOT NULL,
  `paciente` int(11) NOT NULL,
  `convenio` int(11) NOT NULL,
  `observacoes` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `schedule`
--

INSERT INTO `schedule` (`id`, `dia`, `hora`, `medico`, `paciente`, `convenio`, `observacoes`, `created_at`, `updated_at`) VALUES
(2, '2023-09-11', '10:00:00', 2, 1, 1, 'Dor de cabeça e vômito', '2023-09-11 17:31:40', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `dia_semana` int(20) NOT NULL,
  `agenda_inicio` time DEFAULT NULL,
  `agenda_fim` time DEFAULT NULL,
  `agenda_inicio_almoco` time DEFAULT NULL,
  `agenda_fim_almoco` time DEFAULT NULL,
  `tempo_consulta` int(11) DEFAULT NULL COMMENT 'O tempo deve ser colocado em minutos ex 20, 30 ou 60 minutos'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `settings`
--

INSERT INTO `settings` (`id`, `dia_semana`, `agenda_inicio`, `agenda_fim`, `agenda_inicio_almoco`, `agenda_fim_almoco`, `tempo_consulta`) VALUES
(1, 1, '09:00:00', '19:00:00', '12:00:00', '13:00:00', 30),
(2, 2, '09:00:00', '18:30:00', '12:00:00', '13:00:00', 30),
(3, 3, '09:00:00', '18:00:00', '12:00:00', '13:00:00', 30),
(4, 4, '09:30:00', '20:00:00', '12:00:00', '13:00:00', 30),
(5, 5, '10:00:00', '19:00:00', '12:00:00', '13:00:00', 30);

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nome` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `email` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `senha` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `rg` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `cpf` int(11) DEFAULT NULL,
  `crm` int(11) DEFAULT NULL,
  `celular` varchar(30) NOT NULL,
  `cep` int(11) DEFAULT NULL,
  `logradouro` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `numero` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `complemento` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `bairro` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `cidade` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `estado` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `tipo` int(11) NOT NULL,
  `convenio` int(11) NOT NULL,
  `conv_numero` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='	';

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`id`, `nome`, `email`, `senha`, `rg`, `cpf`, `crm`, `celular`, `cep`, `logradouro`, `numero`, `complemento`, `bairro`, `cidade`, `estado`, `tipo`, `convenio`, `conv_numero`, `created_at`, `updated_at`) VALUES
(1, 'Paciente', 'paciente@clinica.com.br', '$2y$10$ggb0eGCPRBYCVIY40IOY9ebalydsqiJvmpAr2hg9oSsvnybH763TS', '12345678', 12345678, 12345678, '18997230626', 19015011, 'Rua Barão do Rio Branco', '1838', '', 'Vila Santa Helena', 'Presidente Prudente', 'SP', 3, 2, '12345678', '2023-08-29 01:26:39', NULL),
(2, 'Médico', 'medico@clinica.com.br', '$2y$10$bcmtJRYftD5Oj7X3WDmERObKDdjjN3LVkUTYoG2isBB9jm0A0U7Ve', '12345678', 12345678, 12345678, '1899720626', 19015011, 'Rua Barão do Rio Branco', '1838', '', 'Vila Santa Helena', 'Presidente Prudente', 'SP', 2, 2, '12345678', '2023-08-29 01:27:38', NULL),
(3, 'Secretária', 'secretaria@clinica.com.br', '$2y$10$MmVUrcK6ncY.YBXLNKx.uuXxam742LMtFlfZ8GttHUz4v64zVAoay', '12345678', 12345678, 12345678, '1899720626', 19015011, 'Rua Barão do Rio Branco', '1838', '', 'Vila Santa Helena', 'Presidente Prudente', 'SP', 1, 2, '12345678', '2023-08-29 01:28:12', NULL),
(4, 'Tiago Pereira Ramos', 'tiago.ramos@sp.senai.br', '$2y$10$3ge9rvCibK8lTQbNDUHVE./Cmm2idhPYLUW0InaNyqF4vwRj.Jfvi', '12345678', 12345678, 12345678, '18997230626', 19015011, 'Rua Barão do Rio Branco', '1838', '', 'Vila Santa Helena', 'Presidente Prudente', 'SP', 1, 2, '12345678', '2023-09-12 19:23:24', NULL),
(5, 'Tiago Pereira Ramos', 'tiago.ramos@sp.senai.br', '$2y$10$cpErlIkbzhr24CViJXCEcuNmA67/77EdDhka.R5Tq1qo9Xcki1IUS', '12345678', 12345678, 12345678, '18997230626', 19015011, 'Rua Barão do Rio Branco', '1838', '', 'Vila Santa Helena', 'Presidente Prudente', 'SP', 1, 2, '12345678', '2023-09-12 19:24:47', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `users_types`
--

CREATE TABLE `users_types` (
  `id` int(11) NOT NULL,
  `nome` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `descricao` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `users_types`
--

INSERT INTO `users_types` (`id`, `nome`, `descricao`) VALUES
(1, 'Secretária', 'Usuário do tipo secretária'),
(2, 'Médico', 'Usuário do tipo médico'),
(3, 'Paciente', 'Usuário do tipo Paciente');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `agreements`
--
ALTER TABLE `agreements`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_tb_agendamento_tb_usuarios1_idx` (`medico`),
  ADD KEY `fk_tb_agendamento_tb_usuarios2_idx` (`paciente`),
  ADD KEY `fk_tb_agendamento_tb_convenios1_idx` (`convenio`);

--
-- Índices para tabela `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_tb_usuarios_tb_usuarios_tipos_idx` (`tipo`),
  ADD KEY `fk_tb_usuarios_tb_convenios1_idx` (`convenio`);

--
-- Índices para tabela `users_types`
--
ALTER TABLE `users_types`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `agreements`
--
ALTER TABLE `agreements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `schedule`
--
ALTER TABLE `schedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de tabela `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `users_types`
--
ALTER TABLE `users_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `schedule`
--
ALTER TABLE `schedule`
  ADD CONSTRAINT `fk_tb_agendamento_tb_convenios1` FOREIGN KEY (`convenio`) REFERENCES `agreements` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tb_agendamento_tb_usuarios1` FOREIGN KEY (`medico`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tb_agendamento_tb_usuarios2` FOREIGN KEY (`paciente`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_tb_usuarios_tb_convenios1` FOREIGN KEY (`convenio`) REFERENCES `agreements` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tb_usuarios_tb_usuarios_tipos` FOREIGN KEY (`tipo`) REFERENCES `users_types` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
