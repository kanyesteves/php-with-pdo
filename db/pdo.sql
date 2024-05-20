CREATE DATABASE loja;
USE loja;

CREATE TABLE IF NOT EXISTS estoque (
    `id` INT UNSIGNED AUTO_INCREMENT NOT NULL,
    `produto` varchar(100) NOT NULL,
    `cor` varchar(100) NOT NULL,
    `tamanho` ENUM('P', 'M', 'G') NOT NULL,
    `deposito` varchar(100) NOT NULL,
    `data_disponibilidade` DATE NOT NULL,
    `quantidade` INT UNSIGNED NOT NULL,
    CONSTRAINT `estoque_pk` PRIMARY KEY ('id'),
    CONSTRAINT `estoque_un` UNIQUE KEY ('produto', 'cor', 'tamanho', 'deposito', 'data_disponibilidade')
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8mb3
COLLATE=utf8mb3_general_ci;