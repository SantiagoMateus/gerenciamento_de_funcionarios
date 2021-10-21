-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 22-Nov-2020 às 01:21
-- Versão do servidor: 10.1.34-MariaDB
-- PHP Version: 5.6.37

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `funcionarios`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `anexos`
--

CREATE TABLE `anexos` (
  `id` int(11) NOT NULL,
  `funcionario_id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `arquivo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `anexos`
--

INSERT INTO `anexos` (`id`, `funcionario_id`, `nome`, `arquivo`) VALUES
(2, 2, 'Aula03 - Condicional.pdf', 'Aula03 - Condicional.pdf'),
(3, 2, 'Aula08 - Exercícios.pdf', 'Aula08 - Exercícios.pdf'),
(4, 2, 'Aula06 - Testes de Unidade.pdf', 'Aula06 - Testes de Unidade.pdf'),
(5, 2, 'Banco-20180828T194044Z-001.zip', 'Banco-20180828T194044Z-001.zip'),
(6, 11, 'Aula07 - herança.pdf', 'Aula07 - herança.pdf'),
(7, 12, 'Aula05 - Funções em Python.pdf', 'Aula05 - Funções em Python.pdf');

-- --------------------------------------------------------

--
-- Estrutura da tabela `funcionarios`
--

CREATE TABLE `funcionarios` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nome` varchar(50) DEFAULT NULL,
  `endereco` varchar(50) DEFAULT NULL,
  `cargo` varchar(50) DEFAULT NULL,
  `dataadmissao` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `funcionarios`
--

INSERT INTO `funcionarios` (`id`, `nome`, `endereco`, `cargo`, `dataadmissao`) VALUES
(2, 'Jessica Hyde', 'Rua Utopia', 'supervisor', '2020-11-02'),
(3, 'Jaegar', 'Rua Anthem', 'operario', '2020-11-17');

--
-- Acionadores `funcionarios`
--
DELIMITER $$
CREATE TRIGGER `updateLog` AFTER UPDATE ON `funcionarios` FOR EACH ROW INSERT INTO logs VALUES(null, NEW.id, 'Atualizou o usuario', NOW())
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `autor_id` int(11) NOT NULL,
  `action` varchar(20) NOT NULL,
  `cdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `funcionarios`
--
ALTER TABLE `funcionarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `funcionarios`
--
ALTER TABLE `funcionarios`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
