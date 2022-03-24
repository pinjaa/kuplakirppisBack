-- kategoria taulu
DROP TABLE IF EXISTS kategoria;
CREATE TABLE kategoria (
    ktg_nro int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    ktg_nimi VARCHAR(255)
)

-- tuote taulu
DROP TABLE IF EXISTS tuote;
CREATE TABLE tuote (
    tuotenro int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    tuotenimi VARCHAR(255),
    hinta DOUBLE(10,2), 
    kuvaus TEXT, 
    ktg_nro INT FOREIGN KEY REFERENCES kategoria(ktg_nro)
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
    asiakasnro INT FOREIGN KEY REFERENCES as_tili(asiakasnro)
);

-- tilausrivi taulu
DROP TABLE IF EXISTS tilausrivi;
CREATE TABLE tilausrivi (
    rivinro INT NOT NULL AUTO_INCREMENT
    tilausnro INT FOREIGN KEY REFERENCES tilaus(tilausnro),
    tuotenro INT FOREIGN KEY REFERENCES tuote(tuotenro)
)