-- tietokannan luontilause
DROP database if EXISTS kuplakirppis;
CREATE database kuplakirppis;
use kuplakirppis;

-- kategoria taulu
DROP TABLE IF EXISTS kategoria;
CREATE TABLE kategoria (
    ktg_nro int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    ktg_nimi VARCHAR(255)
);

-- tuote taulu
DROP TABLE IF EXISTS tuote;
CREATE TABLE tuote (
    id int PRIMARY KEY AUTO_INCREMENT,
    tuotenimi VARCHAR(255) NOT NULL,
    hinta DOUBLE(10,2) NOT NULL, 
    image VARCHAR(50),
    kuvaus TEXT, 
    ktg_nro INT
);

-- asiakastili taulu
DROP TABLE IF EXISTS as_tili;
CREATE TABLE as_tili (
    asiakasnro int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    tunnus VARCHAR(30),
    salasana VARCHAR(20), 
    email VARCHAR(50)
);

-- tilaus taulu
DROP TABLE IF EXISTS tilaus;
CREATE TABLE tilaus (
    tilausnro INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    tilauspvm DATE,
    asiakasnro INT
);

-- tilausrivi taulu
DROP TABLE IF EXISTS tilausrivi;
CREATE TABLE tilausrivi (
    rivinro INT NOT NULL,
    tilausnro INT, 
    tuotenro INT
);



-- foreign key lisäykset, ei toimineet taulujen luonnin yhteydessä
ALTER TABLE tilaus
ADD FOREIGN KEY (asiakasnro) REFERENCES as_tili(asiakasnro);

ALTER TABLE tuote
ADD FOREIGN KEY (ktg_nro) REFERENCES kategoria(ktg_nro);

ALTER TABLE tilausrivi
ADD FOREIGN KEY (tilausnro) REFERENCES tilaus(tilausnro);

ALTER TABLE tilausrivi
ADD FOREIGN KEY (tuotenro) REFERENCES tuote(id);


-- tuoteryhmien lisäys
INSERT INTO kategoria (ktg_nimi) values ('Vaatteet');
INSERT INTO kategoria (ktg_nimi) values ('Elektroniikka ja kodinkoneet');
INSERT INTO kategoria (ktg_nimi) values ('Ajoneuvot');
INSERT INTO kategoria (ktg_nimi) values ('Hifi');
INSERT INTO kategoria (ktg_nimi) values ('Keittiö');
INSERT INTO kategoria (ktg_nimi) values ('Koti');
INSERT INTO kategoria (ktg_nimi) values ('Vapaa-aika');

-- tuote taulun testauslauseet
INSERT INTO tuote(tuotenimi, hinta, ktg_nro) values ("kenkä", 10, 1);
INSERT INTO tuote(tuotenimi, hinta, ktg_nro) values ("paita", 5, 1);
INSERT INTO tuote(tuotenimi, hinta, ktg_nro) values ("pyykkikone", 50, 2);