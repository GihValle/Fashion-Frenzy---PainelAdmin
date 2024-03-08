-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 27-Fev-2024 às 18:01
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
-- Banco de dados: `projeto_int`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `categoria`
--

CREATE TABLE `categoria` (
  `pk_categoria` tinyint(4) NOT NULL,
  `categoria` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `categoria`
--

INSERT INTO `categoria` (`pk_categoria`, `categoria`) VALUES
(1, 'Esportivo'),
(2, 'Social'),
(3, 'Casual');

-- --------------------------------------------------------

--
-- Estrutura da tabela `cliente`
--

CREATE TABLE `cliente` (
  `pk_cliente` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `cpf` char(11) NOT NULL,
  `tel` varchar(14) NOT NULL,
  `endereco` varchar(200) NOT NULL,
  `nascimento` date NOT NULL,
  `email` varchar(50) NOT NULL,
  `senha` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `cliente`
--

INSERT INTO `cliente` (`pk_cliente`, `nome`, `cpf`, `tel`, `endereco`, `nascimento`, `email`, `senha`) VALUES
(1, 'Gabriel', '49060977823', '12988232647', 'Rua João de Barros', '2000-02-12', 'teste@gmail.com', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4'),
(2, 'Idianara', '23456789012', '12988232647', 'Endereco2', '2000-02-12', 'idianara@gmail.com', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4'),
(3, 'Giovanna', '34567890123', '12988232647', 'Endereco3', '2000-02-12', 'giovanna@gmail.com', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4'),
(4, 'Helena', '45678901234', '12988232647', 'Endereco4', '2000-02-12', 'helena@gmail.com', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4'),
(5, 'Natály', '56789012345', '12988232647', 'Endereco5', '2000-02-12', 'nataly@gmail.com', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4'),
(6, 'Francine', '67890123456', '12988232647', 'Endereco6', '2000-02-12', 'francine@gmail.com', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4'),
(7, 'João', '78901234567', '12988232647', 'Endereco7', '2000-02-12', 'joao@gmail.com', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4'),
(8, 'Maurício', '89012345678', '12988232647', 'Endereco8', '2000-02-12', 'mauricio@gmail.com', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4'),
(9, 'Marcos', '90123456789', '12988232647', 'Endereco9', '2000-02-12', 'marcos@gmail.com', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4'),
(10, 'Jesus da Silva', '01234567890', '12988232647', 'Endereco10', '2000-02-12', 'jesusdasilva@gmail.com', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4');

-- --------------------------------------------------------

--
-- Estrutura da tabela `cor`
--

CREATE TABLE `cor` (
  `pk_cor` tinyint(4) NOT NULL,
  `cor` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `cor`
--

INSERT INTO `cor` (`pk_cor`, `cor`) VALUES
(1, 'Vermelho'),
(2, 'Azul'),
(3, 'Verde'),
(4, 'Rosa'),
(5, 'Branco'),
(6, 'Preto');

-- --------------------------------------------------------

--
-- Estrutura da tabela `genero`
--

CREATE TABLE `genero` (
  `pk_genero` tinyint(4) NOT NULL,
  `genero` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `genero`
--

INSERT INTO `genero` (`pk_genero`, `genero`) VALUES
(1, 'M'),
(2, 'F'),
(3, 'U');

-- --------------------------------------------------------

--
-- Estrutura da tabela `marca`
--

CREATE TABLE `marca` (
  `pk_marca` tinyint(4) NOT NULL,
  `marca` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `marca`
--

INSERT INTO `marca` (`pk_marca`, `marca`) VALUES
(1, 'Oakley'),
(2, 'Adidas'),
(3, 'GAP'),
(4, 'New era');

-- --------------------------------------------------------

--
-- Estrutura da tabela `pedido`
--

CREATE TABLE `pedido` (
  `pk_pedido` int(11) NOT NULL,
  `valor_total` varchar(10) NOT NULL,
  `cod_rastrea` varchar(50) NOT NULL,
  `data_pedido` datetime NOT NULL,
  `tipo_pagamento` enum('pix','crédito','débito','carnê') NOT NULL,
  `cod_promocao` varchar(50) DEFAULT NULL,
  `fk_cliente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `pedido`
--

INSERT INTO `pedido` (`pk_pedido`, `valor_total`, `cod_rastrea`, `data_pedido`, `tipo_pagamento`, `cod_promocao`, `fk_cliente`) VALUES
(1, '100', '49060977823', '2024-02-19 13:54:18', 'pix', 'teste', 1),
(2, '140', '43070977823', '2024-02-19 13:54:18', 'crédito', 'teste', 2),
(3, '200', '49160977823', '2024-02-19 13:54:18', 'débito', 'teste', 3),
(4, '150', '49960977823', '2024-02-19 13:54:18', 'pix', 'teste', 4),
(5, '400', '49860977823', '2024-02-19 13:54:18', 'débito', 'teste', 5),
(6, '215', '49260977823', '2024-02-19 13:54:18', 'débito', 'teste', 6),
(7, '135', '49160977823', '2024-02-19 13:54:18', 'carnê', 'teste', 7),
(8, '305', '46060977823', '2024-02-19 13:54:18', 'carnê', 'teste', 8);

-- --------------------------------------------------------

--
-- Estrutura da tabela `produto`
--

CREATE TABLE `produto` (
  `pk_produto` int(11) NOT NULL,
  `img` varchar(100) NOT NULL,
  `desc_produto` text NOT NULL,
  `nome` varchar(50) NOT NULL,
  `valor` float NOT NULL,
  `fk_marca` tinyint(4) NOT NULL,
  `fk_cor` tinyint(4) NOT NULL,
  `fk_tamanho` tinyint(4) NOT NULL,
  `fk_genero` tinyint(4) NOT NULL,
  `fk_categoria` tinyint(4) NOT NULL,
  `fk_subcategoria` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `produto`
--

INSERT INTO `produto` (`pk_produto`, `img`, `desc_produto`, `nome`, `valor`, `fk_marca`, `fk_cor`, `fk_tamanho`, `fk_genero`, `fk_categoria`, `fk_subcategoria`) VALUES
(1, 'null', 'teste-1', 'Cardigã', 100, 1, 1, 1, 1, 1, 8),
(2, 'null', 'teste-2', 'Moletom', 200, 2, 2, 2, 2, 2, 5),
(3, 'null', 'teste-3', 'Body', 50, 3, 3, 3, 3, 3, 6),
(4, 'null', 'teste-4', 'Jaqueta', 350, 4, 4, 4, 1, 1, 4),
(5, 'null', 'teste-5', 'Regata', 35, 1, 5, 5, 2, 2, 3),
(6, 'null', 'teste-6', 'Camiseta', 40, 2, 6, 6, 3, 3, 2),
(7, 'null', 'teste-7', 'Suéter', 150, 3, 1, 1, 1, 1, 7),
(8, 'null', 'teste-8', 'Blusa', 20, 4, 2, 2, 2, 2, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `rl_cat_prod`
--

CREATE TABLE `rl_cat_prod` (
  `pk_rl` int(11) NOT NULL,
  `fk_categoria` tinyint(4) NOT NULL,
  `fk_produto` int(11) NOT NULL,
  `qtd` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `rl_cor_prod`
--

CREATE TABLE `rl_cor_prod` (
  `pk_rl` int(11) NOT NULL,
  `fk_cor` tinyint(4) NOT NULL,
  `fk_produto` int(11) NOT NULL,
  `qtd` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `rl_gen_prod`
--

CREATE TABLE `rl_gen_prod` (
  `pk_rl` int(11) NOT NULL,
  `fk_genero` tinyint(4) NOT NULL,
  `fk_produto` int(11) NOT NULL,
  `qtd` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `rl_marca_prod`
--

CREATE TABLE `rl_marca_prod` (
  `pk_rl` int(11) NOT NULL,
  `fk_marca` tinyint(4) NOT NULL,
  `fk_produto` int(11) NOT NULL,
  `qtd` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `rl_ped_prod`
--

CREATE TABLE `rl_ped_prod` (
  `pk_rl` int(11) NOT NULL,
  `fk_produto` int(11) NOT NULL,
  `fk_cor` tinyint(4) NOT NULL,
  `fk_tamanho` tinyint(4) NOT NULL,
  `fk_pedido` int(11) NOT NULL,
  `qtd` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `rl_ped_prod`
--

INSERT INTO `rl_ped_prod` (`pk_rl`, `fk_produto`, `fk_cor`, `fk_tamanho`, `fk_pedido`, `qtd`) VALUES
(6, 1, 1, 1, 1, 10),
(7, 2, 2, 2, 2, 20),
(8, 3, 3, 3, 3, 15),
(9, 4, 4, 4, 4, 38),
(10, 5, 1, 5, 5, 56);

-- --------------------------------------------------------

--
-- Estrutura da tabela `rl_subcat_prod`
--

CREATE TABLE `rl_subcat_prod` (
  `pk_rl` int(11) NOT NULL,
  `fk_subcategoria` smallint(6) NOT NULL,
  `fk_produto` int(11) NOT NULL,
  `qtd` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `rl_tamanho_prod`
--

CREATE TABLE `rl_tamanho_prod` (
  `pk_rl` int(11) NOT NULL,
  `fk_tamanho` tinyint(4) NOT NULL,
  `fk_produto` int(11) NOT NULL,
  `qtd` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `subcategoria`
--

CREATE TABLE `subcategoria` (
  `pk_subcategoria` smallint(6) NOT NULL,
  `sub_categoria` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `subcategoria`
--

INSERT INTO `subcategoria` (`pk_subcategoria`, `sub_categoria`) VALUES
(1, 'Blusa'),
(2, 'Camiseta'),
(3, 'Regata'),
(4, 'Jaqueta'),
(5, 'Moletom'),
(6, 'Body'),
(7, 'Suéter'),
(8, 'Cardigã');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tamanho`
--

CREATE TABLE `tamanho` (
  `pk_tamanho` tinyint(4) NOT NULL,
  `tamanho` char(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `tamanho`
--

INSERT INTO `tamanho` (`pk_tamanho`, `tamanho`) VALUES
(1, 'pp'),
(2, 'p'),
(3, 'm'),
(4, 'g'),
(5, 'gg'),
(6, 'xgg');

-- --------------------------------------------------------

--
-- Estrutura da tabela `token`
--

CREATE TABLE `token` (
  `pk_id` int(11) NOT NULL,
  `email` varchar(150) NOT NULL,
  `cpf` varchar(15) NOT NULL,
  `token` varchar(12) NOT NULL,
  `data_criacao` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `token`
--

INSERT INTO `token` (`pk_id`, `email`, `cpf`, `token`, `data_criacao`) VALUES
(1, 'givalle2005@gmail.com', '45428423803', '77cbc1f93d7f', '2024-02-21 17:25:26'),
(2, 'ladyrhaellynn@gmail.com', '45428423803', '290958a0afbb', '2024-02-27 13:44:10');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE `usuario` (
  `pk_usuario` smallint(6) NOT NULL,
  `email` varchar(50) NOT NULL,
  `senha` varchar(80) NOT NULL,
  `habilita` smallint(6) NOT NULL,
  `codigo` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`pk_usuario`, `email`, `senha`, `habilita`, `codigo`) VALUES
(1, 'idianaralohana7@gmail.com', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', 1, 'b51e8d'),
(2, 'givalle2005@gmail.com', '', 1, '776577');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`pk_categoria`);

--
-- Índices para tabela `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`pk_cliente`);

--
-- Índices para tabela `cor`
--
ALTER TABLE `cor`
  ADD PRIMARY KEY (`pk_cor`);

--
-- Índices para tabela `genero`
--
ALTER TABLE `genero`
  ADD PRIMARY KEY (`pk_genero`);

--
-- Índices para tabela `marca`
--
ALTER TABLE `marca`
  ADD PRIMARY KEY (`pk_marca`);

--
-- Índices para tabela `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`pk_pedido`),
  ADD KEY `fk_cliente` (`fk_cliente`);

--
-- Índices para tabela `produto`
--
ALTER TABLE `produto`
  ADD PRIMARY KEY (`pk_produto`),
  ADD KEY `fk_marca` (`fk_marca`),
  ADD KEY `fk_cor` (`fk_cor`),
  ADD KEY `fk_tamanho` (`fk_tamanho`),
  ADD KEY `fk_genero` (`fk_genero`),
  ADD KEY `fk_subcategoria` (`fk_subcategoria`),
  ADD KEY `fk_categoria` (`fk_categoria`);

--
-- Índices para tabela `rl_cat_prod`
--
ALTER TABLE `rl_cat_prod`
  ADD PRIMARY KEY (`pk_rl`),
  ADD KEY `fk_categoria` (`fk_categoria`),
  ADD KEY `fk_produto` (`fk_produto`);

--
-- Índices para tabela `rl_cor_prod`
--
ALTER TABLE `rl_cor_prod`
  ADD PRIMARY KEY (`pk_rl`),
  ADD KEY `fk_cor` (`fk_cor`),
  ADD KEY `fk_produto` (`fk_produto`);

--
-- Índices para tabela `rl_gen_prod`
--
ALTER TABLE `rl_gen_prod`
  ADD PRIMARY KEY (`pk_rl`),
  ADD KEY `fk_genero` (`fk_genero`),
  ADD KEY `fk_produto` (`fk_produto`);

--
-- Índices para tabela `rl_marca_prod`
--
ALTER TABLE `rl_marca_prod`
  ADD PRIMARY KEY (`pk_rl`),
  ADD KEY `fk_marca` (`fk_marca`),
  ADD KEY `fk_produto` (`fk_produto`);

--
-- Índices para tabela `rl_ped_prod`
--
ALTER TABLE `rl_ped_prod`
  ADD PRIMARY KEY (`pk_rl`),
  ADD KEY `fk_produto` (`fk_produto`),
  ADD KEY `fk_cor` (`fk_cor`),
  ADD KEY `fk_tamanho` (`fk_tamanho`),
  ADD KEY `fk_pedido` (`fk_pedido`);

--
-- Índices para tabela `rl_subcat_prod`
--
ALTER TABLE `rl_subcat_prod`
  ADD PRIMARY KEY (`pk_rl`),
  ADD KEY `fk_subcategoria` (`fk_subcategoria`),
  ADD KEY `fk_produto` (`fk_produto`);

--
-- Índices para tabela `rl_tamanho_prod`
--
ALTER TABLE `rl_tamanho_prod`
  ADD PRIMARY KEY (`pk_rl`),
  ADD KEY `fk_tamanho` (`fk_tamanho`),
  ADD KEY `fk_produto` (`fk_produto`);

--
-- Índices para tabela `subcategoria`
--
ALTER TABLE `subcategoria`
  ADD PRIMARY KEY (`pk_subcategoria`);

--
-- Índices para tabela `tamanho`
--
ALTER TABLE `tamanho`
  ADD PRIMARY KEY (`pk_tamanho`);

--
-- Índices para tabela `token`
--
ALTER TABLE `token`
  ADD PRIMARY KEY (`pk_id`);

--
-- Índices para tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`pk_usuario`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `categoria`
--
ALTER TABLE `categoria`
  MODIFY `pk_categoria` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `cliente`
--
ALTER TABLE `cliente`
  MODIFY `pk_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `cor`
--
ALTER TABLE `cor`
  MODIFY `pk_cor` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `genero`
--
ALTER TABLE `genero`
  MODIFY `pk_genero` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `marca`
--
ALTER TABLE `marca`
  MODIFY `pk_marca` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `pedido`
--
ALTER TABLE `pedido`
  MODIFY `pk_pedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `produto`
--
ALTER TABLE `produto`
  MODIFY `pk_produto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `rl_cat_prod`
--
ALTER TABLE `rl_cat_prod`
  MODIFY `pk_rl` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `rl_cor_prod`
--
ALTER TABLE `rl_cor_prod`
  MODIFY `pk_rl` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `rl_gen_prod`
--
ALTER TABLE `rl_gen_prod`
  MODIFY `pk_rl` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `rl_marca_prod`
--
ALTER TABLE `rl_marca_prod`
  MODIFY `pk_rl` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `rl_ped_prod`
--
ALTER TABLE `rl_ped_prod`
  MODIFY `pk_rl` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `rl_subcat_prod`
--
ALTER TABLE `rl_subcat_prod`
  MODIFY `pk_rl` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `rl_tamanho_prod`
--
ALTER TABLE `rl_tamanho_prod`
  MODIFY `pk_rl` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `subcategoria`
--
ALTER TABLE `subcategoria`
  MODIFY `pk_subcategoria` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `tamanho`
--
ALTER TABLE `tamanho`
  MODIFY `pk_tamanho` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `token`
--
ALTER TABLE `token`
  MODIFY `pk_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `pk_usuario` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `pedido`
--
ALTER TABLE `pedido`
  ADD CONSTRAINT `pedido_ibfk_1` FOREIGN KEY (`fk_cliente`) REFERENCES `cliente` (`pk_cliente`);

--
-- Limitadores para a tabela `produto`
--
ALTER TABLE `produto`
  ADD CONSTRAINT `produto_ibfk_1` FOREIGN KEY (`fk_marca`) REFERENCES `marca` (`pk_marca`),
  ADD CONSTRAINT `produto_ibfk_2` FOREIGN KEY (`fk_cor`) REFERENCES `cor` (`pk_cor`),
  ADD CONSTRAINT `produto_ibfk_3` FOREIGN KEY (`fk_tamanho`) REFERENCES `tamanho` (`pk_tamanho`),
  ADD CONSTRAINT `produto_ibfk_4` FOREIGN KEY (`fk_genero`) REFERENCES `genero` (`pk_genero`),
  ADD CONSTRAINT `produto_ibfk_5` FOREIGN KEY (`fk_subcategoria`) REFERENCES `subcategoria` (`pk_subcategoria`),
  ADD CONSTRAINT `produto_ibfk_6` FOREIGN KEY (`fk_categoria`) REFERENCES `categoria` (`pk_categoria`);

--
-- Limitadores para a tabela `rl_cat_prod`
--
ALTER TABLE `rl_cat_prod`
  ADD CONSTRAINT `rl_cat_prod_ibfk_1` FOREIGN KEY (`fk_categoria`) REFERENCES `categoria` (`pk_categoria`),
  ADD CONSTRAINT `rl_cat_prod_ibfk_2` FOREIGN KEY (`fk_produto`) REFERENCES `produto` (`pk_produto`);

--
-- Limitadores para a tabela `rl_cor_prod`
--
ALTER TABLE `rl_cor_prod`
  ADD CONSTRAINT `rl_cor_prod_ibfk_1` FOREIGN KEY (`fk_cor`) REFERENCES `cor` (`pk_cor`),
  ADD CONSTRAINT `rl_cor_prod_ibfk_2` FOREIGN KEY (`fk_produto`) REFERENCES `produto` (`pk_produto`);

--
-- Limitadores para a tabela `rl_gen_prod`
--
ALTER TABLE `rl_gen_prod`
  ADD CONSTRAINT `rl_gen_prod_ibfk_1` FOREIGN KEY (`fk_genero`) REFERENCES `genero` (`pk_genero`),
  ADD CONSTRAINT `rl_gen_prod_ibfk_2` FOREIGN KEY (`fk_produto`) REFERENCES `produto` (`pk_produto`);

--
-- Limitadores para a tabela `rl_marca_prod`
--
ALTER TABLE `rl_marca_prod`
  ADD CONSTRAINT `rl_marca_prod_ibfk_1` FOREIGN KEY (`fk_marca`) REFERENCES `marca` (`pk_marca`),
  ADD CONSTRAINT `rl_marca_prod_ibfk_2` FOREIGN KEY (`fk_produto`) REFERENCES `produto` (`pk_produto`);

--
-- Limitadores para a tabela `rl_ped_prod`
--
ALTER TABLE `rl_ped_prod`
  ADD CONSTRAINT `rl_ped_prod_ibfk_1` FOREIGN KEY (`fk_produto`) REFERENCES `produto` (`pk_produto`),
  ADD CONSTRAINT `rl_ped_prod_ibfk_2` FOREIGN KEY (`fk_cor`) REFERENCES `cor` (`pk_cor`),
  ADD CONSTRAINT `rl_ped_prod_ibfk_3` FOREIGN KEY (`fk_tamanho`) REFERENCES `tamanho` (`pk_tamanho`),
  ADD CONSTRAINT `rl_ped_prod_ibfk_4` FOREIGN KEY (`fk_pedido`) REFERENCES `pedido` (`pk_pedido`);

--
-- Limitadores para a tabela `rl_subcat_prod`
--
ALTER TABLE `rl_subcat_prod`
  ADD CONSTRAINT `rl_subcat_prod_ibfk_1` FOREIGN KEY (`fk_subcategoria`) REFERENCES `subcategoria` (`pk_subcategoria`),
  ADD CONSTRAINT `rl_subcat_prod_ibfk_2` FOREIGN KEY (`fk_produto`) REFERENCES `produto` (`pk_produto`);

--
-- Limitadores para a tabela `rl_tamanho_prod`
--
ALTER TABLE `rl_tamanho_prod`
  ADD CONSTRAINT `rl_tamanho_prod_ibfk_1` FOREIGN KEY (`fk_tamanho`) REFERENCES `tamanho` (`pk_tamanho`),
  ADD CONSTRAINT `rl_tamanho_prod_ibfk_2` FOREIGN KEY (`fk_produto`) REFERENCES `produto` (`pk_produto`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
