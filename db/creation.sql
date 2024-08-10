CREATE DATABASE IF NOT EXISTS locadora_carros;
use locadora_carros;

CREATE TABLE IF NOT EXISTS Usuario (
    email VARCHAR(30) PRIMARY KEY,
    nome VARCHAR(20),
    sobrenome VARCHAR(20),
    senha VARCHAR(100),
    token VARCHAR(100)
);
CREATE TABLE IF NOT EXISTS Carros (
    id VARCHAR(4) PRIMARY KEY,
    imagem VARCHAR(100) NOT NULL,
    nome VARCHAR(20) NOT NULL,
    consumo FLOAT NOT NULL,
    custo FLOAT NOT NULL,
    data_alugado DATE,
    cliente_usuario VARCHAR(30),
    FOREIGN KEY (cliente_usuario) REFERENCES Usuario (email)
);

INSERT INTO Carros (imagem, id, nome, consumo, custo) VALUES
("img/corolla-cross.webp", "cc", "Corolla Cross", 16.8, 6),
("img/creta.jpg", "cr", "Creta 2.0", 14.8, 5.5),
("img/t-cross.jpg", "tc", "T-Cross", 14, 5.7),
("img/tiggo.jpg", "tg", "Tiggo 5x", 11.5, 3.9),
("img/versa.jpg", "vs", "Versa", 12.7, 4.8);