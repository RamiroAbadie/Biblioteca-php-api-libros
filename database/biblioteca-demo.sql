CREATE DATABASE IF NOT EXISTS bibliotecapersonal_php_demo;
USE bibliotecapersonal_php_demo;

SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS libro_genero;
DROP TABLE IF EXISTS libro_editorial;
DROP TABLE IF EXISTS libro_autor;
DROP TABLE IF EXISTS libro;
DROP TABLE IF EXISTS genero;
DROP TABLE IF EXISTS editorial;
DROP TABLE IF EXISTS autor;
DROP TABLE IF EXISTS pais;
DROP TABLE IF EXISTS ubicacion;

SET FOREIGN_KEY_CHECKS = 1;

CREATE TABLE pais (
  id_pais BIGINT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(255) NOT NULL
);

CREATE TABLE autor (
  id_autor BIGINT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(255) NOT NULL,
  id_pais BIGINT NOT NULL,
  sexo VARCHAR(10),
  FOREIGN KEY (id_pais) REFERENCES pais(id_pais)
);

CREATE TABLE genero (
  id_genero BIGINT AUTO_INCREMENT PRIMARY KEY,
  descripcion VARCHAR(255) NOT NULL
);

CREATE TABLE editorial (
  id_editorial BIGINT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(255) NOT NULL,
  id_pais BIGINT NOT NULL,
  FOREIGN KEY (id_pais) REFERENCES pais(id_pais)
);

CREATE TABLE ubicacion (
  id_ubicacion BIGINT AUTO_INCREMENT PRIMARY KEY,
  descripcion VARCHAR(255)
);

CREATE TABLE libro (
  id_libro BIGINT AUTO_INCREMENT PRIMARY KEY,
  titulo VARCHAR(255) NOT NULL,
  paginas INT,
  id_ubicacion BIGINT NOT NULL,
  FOREIGN KEY (id_ubicacion) REFERENCES ubicacion(id_ubicacion)
);

CREATE TABLE libro_autor (
  id_libro BIGINT,
  id_autor BIGINT,
  PRIMARY KEY (id_libro,id_autor),
  FOREIGN KEY (id_libro) REFERENCES libro(id_libro),
  FOREIGN KEY (id_autor) REFERENCES autor(id_autor)
);

CREATE TABLE libro_editorial (
  id_libro BIGINT,
  id_editorial BIGINT,
  PRIMARY KEY (id_libro,id_editorial),
  FOREIGN KEY (id_libro) REFERENCES libro(id_libro),
  FOREIGN KEY (id_editorial) REFERENCES editorial(id_editorial)
);

CREATE TABLE libro_genero (
  id_libro BIGINT,
  id_genero BIGINT,
  PRIMARY KEY (id_libro,id_genero),
  FOREIGN KEY (id_libro) REFERENCES libro(id_libro),
  FOREIGN KEY (id_genero) REFERENCES genero(id_genero)
);

INSERT INTO pais VALUES
(1,'Argentina'),
(2,'Bolivia'),
(3,'España'),
(7,'Estados Unidos');

INSERT INTO autor VALUES
(1,'Julio Verne',3,'M'),
(2,'Jack London',7,'M'),
(3,'Edgar Allan Poe',7,'M');

INSERT INTO genero VALUES
(1,'Novela'),
(2,'Aventura'),
(3,'Terror');

INSERT INTO editorial VALUES
(1,'Sudamericana',1),
(2,'Penguin',7);

INSERT INTO ubicacion VALUES
(1,'Biblioteca principal'),
(2,'Estante A');

INSERT INTO libro VALUES
(1,'Cinco semanas en globo',220,1),
(2,'El llamado de la selva',210,1),
(3,'El gato negro',120,2);

INSERT INTO libro_autor VALUES
(1,1),
(2,2),
(3,3);

INSERT INTO libro_genero VALUES
(1,2),
(2,2),
(3,3);

INSERT INTO libro_editorial VALUES
(1,1),
(2,2),
(3,2);