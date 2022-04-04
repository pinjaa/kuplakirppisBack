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
    image VARCHAR(255),
    kuvaus TEXT, 
    ktg_nro INT
);

-- asiakastili taulu
DROP TABLE IF EXISTS as_tili;
CREATE TABLE as_tili (
    asiakasnro int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    etunimi VARCHAR(150),
    sukunimi VARCHAR(150),
    salasana VARCHAR(150), 
    email VARCHAR(150), 
    osoite VARCHAR(150),
    postinro VARCHAR(5),
    postitmp VARCHAR(150),
    puhelinnro VARCHAR(10)
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
INSERT INTO tuote(tuotenimi, hinta, ktg_nro, image, kuvaus) values ("Kengät", 10, 1, "https://cdn.pixabay.com/photo/2013/07/13/10/45/shoes-157716_1280.png", "Voi miten hienot kengät, osta osta!");
INSERT INTO tuote(tuotenimi, hinta, ktg_nro, image, kuvaus) values ("Puhelin", 100, 2, "https://cdn.pixabay.com/photo/2013/07/12/18/39/smartphone-153650_1280.png", "Ostappa uusi ja mahtava puhelin.");
INSERT INTO tuote(tuotenimi, hinta, ktg_nro, image, kuvaus) values ("Auto", 50, 3, "https://cdn.pixabay.com/photo/2012/05/29/00/43/car-49278_1280.jpg", "Loistava ja nopea auto.");