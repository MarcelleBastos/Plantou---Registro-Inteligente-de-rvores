-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Tempo de geração: 10/11/2025 às 18:46
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
-- Banco de dados: `plantou_db`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `arvores`
--

CREATE TABLE `arvores` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `tipo` varchar(100) DEFAULT NULL,
  `data_plantio` date DEFAULT NULL,
  `local` varchar(255) DEFAULT NULL,
  `status` varchar(50) DEFAULT 'ativa',
  `co2_absorvido` decimal(10,2) DEFAULT 0.00,
  `descricao` text DEFAULT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `doacoes`
--

CREATE TABLE `doacoes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `valor_doacao` decimal(10,2) NOT NULL,
  `data_doacao` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(50) DEFAULT 'pendente',
  `descricao` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `doacoes`
--

INSERT INTO `doacoes` (`id`, `user_id`, `valor_doacao`, `data_doacao`, `status`, `descricao`) VALUES
(1, 15, 100.00, '2025-10-27 05:37:20', 'confirmado', NULL),
(2, 15, 10000.00, '2025-11-03 02:57:06', 'confirmado', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `projetos`
--

CREATE TABLE `projetos` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `descricao` text DEFAULT NULL,
  `localizacao` varchar(255) DEFAULT NULL,
  `progresso_percentual` int(11) DEFAULT 0,
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp(),
  `data_atualizacao` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `code_2fa` varchar(50) DEFAULT NULL,
  `nome_completo` varchar(255) NOT NULL,
  `data_nascimento` date NOT NULL,
  `genero` enum('masculino','feminino','outro') NOT NULL,
  `nome_mae` varchar(100) DEFAULT NULL,
  `pergunta_secreta` varchar(255) DEFAULT NULL,
  `resposta_secreta` varchar(255) DEFAULT NULL,
  `cpf` char(15) NOT NULL,
  `celular` varchar(15) DEFAULT NULL,
  `cep` char(11) DEFAULT NULL,
  `cidade` varchar(100) DEFAULT NULL,
  `bairro` varchar(100) DEFAULT NULL,
  `rua` varchar(100) DEFAULT NULL,
  `numero` int(11) DEFAULT NULL,
  `complemento` varchar(100) DEFAULT NULL,
  `uf` char(2) DEFAULT NULL,
  `estado` varchar(100) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `data_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `data_atualizacao` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_admin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `username`, `password_hash`, `code_2fa`, `nome_completo`, `data_nascimento`, `genero`, `nome_mae`, `pergunta_secreta`, `resposta_secreta`, `cpf`, `celular`, `cep`, `cidade`, `bairro`, `rua`, `numero`, `complemento`, `uf`, `estado`, `email`, `senha`, `data_registro`, `data_atualizacao`, `is_admin`) VALUES
(14, 'admin', '$2y$10$ba8gmiSKs7UdDO1vUjfGBuNKm5wTnlrvyeCefP1/LWQPBg.LYR4EK', NULL, 'Gustavo Prelado', '0000-00-00', 'masculino', 'Bianca', 'Qual o nome da sua mãe?', 'Maria Silva', '', '<br /><b>Deprec', '<br /><b>De', '<br /><b>Deprecated</b>:  htmlspecialchars(): Passing null to parameter #1 ($string) of type string ', '<br /><b>Deprecated</b>:  htmlspecialchars(): Passing null to parameter #1 ($string) of type string ', '<br /><b>Deprecated</b>:  htmlspecialchars(): Passing null to parameter #1 ($string) of type string ', 0, '<br /><b>Deprecated</b>:  htmlspecialchars(): Passing null to parameter #1 ($string) of type string ', '<b', '<br /><b>Deprecated</b>:  htmlspecialchars(): Passing null to parameter #1 ($string) of type string ', 'admin@gmail.com', 'Adm123##', '2025-10-27 00:10:37', '2025-11-04 14:03:50', 1),
(15, 'marcospontess93', '$2y$10$5UO3dXM5oqESQwpdSaT6neeQ3nW5eOpqYiGG3mEBHO2tzeV6Ljwp2', NULL, 'Marcos Antônio Pontes', '1993-11-28', 'masculino', 'Elienai Pontes dos Santos', 'Qual seu jogo favorito?', 'Final Fantasy X', '13431253750', '21972018150', '21545160', 'Rio de Janeiro', 'Rocha Miranda', 'Rua Itaperoá', 82, 'Fundos', 'RJ', 'Rio de Janeir', 'marcospontess93@gmail.com', '', '2025-10-27 03:30:14', '2025-11-04 18:41:27', 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario_arvore`
--

CREATE TABLE `usuario_arvore` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `arvore_id` int(11) NOT NULL,
  `data_adocao` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `arvores`
--
ALTER TABLE `arvores`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_data` (`data_plantio`);

--
-- Índices de tabela `doacoes`
--
ALTER TABLE `doacoes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_data` (`data_doacao`);

--
-- Índices de tabela `projetos`
--
ALTER TABLE `projetos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_progresso` (`progresso_percentual`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cpf` (`cpf`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Índices de tabela `usuario_arvore`
--
ALTER TABLE `usuario_arvore`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_user_arvore` (`user_id`,`arvore_id`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_arvore_id` (`arvore_id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `arvores`
--
ALTER TABLE `arvores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `doacoes`
--
ALTER TABLE `doacoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `projetos`
--
ALTER TABLE `projetos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de tabela `usuario_arvore`
--
ALTER TABLE `usuario_arvore`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `doacoes`
--
ALTER TABLE `doacoes`
  ADD CONSTRAINT `doacoes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `usuario_arvore`
--
ALTER TABLE `usuario_arvore`
  ADD CONSTRAINT `usuario_arvore_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `usuario_arvore_ibfk_2` FOREIGN KEY (`arvore_id`) REFERENCES `arvores` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
