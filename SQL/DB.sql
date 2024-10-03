CREATE DATABASE dnd;
USE dnd;

CREATE TABLE ficha_personagem (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100),
    classe VARCHAR(50),
    raca VARCHAR(50),
    nivel INT,
    forca INT,
    destreza INT,
    constituicao INT,
    inteligencia INT,
    sabedoria INT,
    carisma INT,
    pontos_vida INT,
    equipamento TEXT,
    habilidades TEXT
);
