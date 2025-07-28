-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 11-Abr-2025 às 21:21
-- Versão do servidor: 10.4.27-MariaDB
-- versão do PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `todolist`
--

-- --------------------------------------------------------

--
-- Tabela de usuários
CREATE TABLE USUARIO (
  `IDUSUARIO` int(11) NOT NULL AUTO_INCREMENT,
  `NOME` varchar(100) NOT NULL,
  `SENHA` varchar(255) NOT NULL,
  `DATACAD` DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`IDUSUARIO`)
);

-- Tabela de Categorias (cada uma vinculada a um usuário)
CREATE TABLE CATEGORIA (
   `IDCATEGORIA` INT AUTO_INCREMENT PRIMARY KEY,
   `NOME` VARCHAR(100) NOT NULL,
   `IDUSUARIO` INT NOT NULL,
   FOREIGN KEY (`IDUSUARIO`) REFERENCES `USUARIO`(`IDUSUARIO`)
       ON DELETE CASCADE
);

-- Tabela de Tarefas
CREATE TABLE TAREFA (
    `IDTAREFA` INT AUTO_INCREMENT PRIMARY KEY,
    `TITULO` VARCHAR(255) NOT NULL,
    `DESCRICAO` TEXT,
    `PRIORIDADE` ENUM('baixa', 'media', 'alta') DEFAULT 'media',
    `STATUS` ENUM('pendente', 'concluida', 'cancelada') DEFAULT 'pendente',
    `PRAZO` DATE,
    `DATACRIACAO` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `DATACONCLUSAO` DATETIME NULL,
    `JUSTIFICATIVA` TEXT,
    `IDUSUARIO` INT NOT NULL,
    `IDCATEGORIA` INT,

    FOREIGN KEY (`IDUSUARIO`) REFERENCES `USUARIO`(`IDUSUARIO`) ON DELETE CASCADE,
    FOREIGN KEY (`IDCATEGORIA`) REFERENCES `CATEGORIA`(`IDCATEGORIA`) ON DELETE SET NULL
);

-- Inserts de exemplo (opcionais, pra testar)

-- Usuário exemplo
INSERT INTO `USUARIO` (`NOME`, `SENHA`)
VALUES ('Arligreicy', '123456');

-- Categorias exemplo
INSERT INTO `CATEGORIA` (`NOME`, `IDUSUARIO`)
VALUES 
('Trabalho', 1),
('Casa', 1),
('Estudos', 1);

-- Tarefas exemplo
INSERT INTO `TAREFA` (`TITULO`, `DESCRICAO`, `PRIORIDADE`, `STATUS`, `PRAZO`, `IDUSUARIO`, `IDCATEGORIA`)
VALUES 
('Finalizar sistema ToDo', 'Criar tela de tarefas e filtros', 'alta', 'pendente', '2025-08-01', 1, 1),
('Arrumar guarda-roupa', 'Organizar como for melhor', 'baixa', 'pendente', '2025-08-04', 1, 2),
('Realizar prova da pós', 'Focar em cibersegurança e data mining', 'alta', 'concluida', '2025-07-31', 1, 3);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
