CREATE DATABASE baza_danych_quiz;

USE baza_danych_quiz;

CREATE TABLE uzytkownicy (
    iduzytkownika int AUTO_INCREMENT PRIMARY KEY,
    nick text default "<Brak nicku>",
    punkty int default 0
);

CREATE TABLE pytania (
    idpytania int AUTO_INCREMENT PRIMARY KEY,
    pytanie text NOT NULL,
    p_odp text NOT NULL
);

CREATE TABLE tabela_wynikow
(
    idmiejsca int AUTO_INCREMENT PRIMARY KEY,
    uzytkownik int,
    FOREIGN KEY(uzytkownik) REFERENCES uzytkownicy(iduzytkownika)
);

INSERT INTO pytania
VALUES (NULL, "Ile to jest: 2 + 2 * 2?", "6"),
(NULL, "Ile to: 2<sup>8</sup>", "256"),
(NULL, "Ile to bedzie: 8 / 4?", "2"),
(NULL, "Ile to bedzie: x + 1 = 0", "-1"),
(NULL, "Ile to bedzie: 6<sup>2</sup>?", "36"),
(NULL, "Podaj wartosc liczby PI w zaokragleniu", "3"),
(NULL, "Podaj wartosc liczby Eulera w zaokragleniu", "3");