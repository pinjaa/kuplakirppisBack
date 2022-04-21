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

-- tuotekuva taulu
DROP TABLE IF EXISTS tuotekuva;
CREATE TABLE tuotekuva (
    id int NOT NULL,
    nro int NOT NULL,
    nimi VARCHAR(150),
    PRIMARY KEY (id, nro)
);

-- käyttäjätili taulu
DROP TABLE IF EXISTS kayttaja_tili;
CREATE TABLE kayttaja_tili (
    id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    etunimi VARCHAR(150),
    sukunimi VARCHAR(150),
    salasana VARCHAR(150), 
    email VARCHAR(150) UNIQUE, 
    osoite VARCHAR(150),
    postinro VARCHAR(5),
    postitmp VARCHAR(150),
    puhelinnro VARCHAR(10),
    admin_oikeus VARCHAR(1)
);

-- tilaus taulu
DROP TABLE IF EXISTS tilaus;
CREATE TABLE tilaus (
    tilausnro INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    tilauspvm TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
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
ADD FOREIGN KEY (asiakasnro) REFERENCES kayttaja_tili(id);

ALTER TABLE tuote
ADD FOREIGN KEY (ktg_nro) REFERENCES kategoria(ktg_nro);

ALTER TABLE tilausrivi
ADD FOREIGN KEY (tilausnro) REFERENCES tilaus(tilausnro);

ALTER TABLE tilausrivi
ADD FOREIGN KEY (tuotenro) REFERENCES tuote(id);

ALTER TABLE tuotekuva
ADD FOREIGN KEY (id) REFERENCES tuote(id);


-- tuoteryhmien lisäys
INSERT INTO kategoria (ktg_nimi) values ('Vaatteet');
INSERT INTO kategoria (ktg_nimi) values ('Elektroniikka ja kodinkoneet');
INSERT INTO kategoria (ktg_nimi) values ('Ajoneuvot');
INSERT INTO kategoria (ktg_nimi) values ('Hifi');
INSERT INTO kategoria (ktg_nimi) values ('Keittiö');
INSERT INTO kategoria (ktg_nimi) values ('Koti');
INSERT INTO kategoria (ktg_nimi) values ('Vapaa-aika');

-- tuotteiden lisäys
INSERT INTO tuote(tuotenimi, hinta, ktg_nro, image, kuvaus) values ("Auto", 50, 3, "https://cdn.pixabay.com/photo/2012/05/29/00/43/car-49278_1280.jpg", "Loistava ja nopea auto.");
INSERT INTO tuote(tuotenimi, hinta, ktg_nro, image, kuvaus) values ("Kannettava tietokone, Acer", 80, 2, "IMG_6963.jpg",
    "Hyvin toimiva lähes uusi Acerin läppäri. Sisältää intel i5 7000 jotain CPU:n. Hyvin pyörii pasianssi grandmaster");
INSERT INTO tuote(tuotenimi, hinta, ktg_nro, image, kuvaus) values ("Panasonic stereo", 15, 4, "IMG_6966.jpg",
    "Edulliset stereot joissa radio, bluetooth ja cd-asema. Mukana tulee kaukosäädin.");
INSERT INTO tuote(tuotenimi, hinta, ktg_nro, image, kuvaus) values ("Musta kissa", 2, 6, "IMG_6968.jpg",
    "Kissan muotoinen koriste-esine. Päällä kolo tuikkukynttilälle");
INSERT INTO tuote(tuotenimi, hinta, ktg_nro, image, kuvaus) values ("Salaatti", 1, 5, "IMG_6970.jpg",
    "Rapea salaatti, ruukku ei tule mukana");
INSERT INTO tuote(tuotenimi, hinta, ktg_nro, image, kuvaus) values ("Ipad 2015", 150, 2, "IMG_6971.jpg",
    "Apple Ipad mallia 2015. Tehokas vehje, voit katsoa Netflixiä, Youtubea ja pelata Haydaytä kaikki samaan aikaan!
    Mukana tulee Apple pen -kynä jolla Haydayn pelaus on entistä tehokkaampaa, sekä kotelo johon menee sekä pädi
    että kynä, ja joka taittuu telineeksi Netfixin katsomisen ajaksi.");
INSERT INTO tuote(tuotenimi, hinta, ktg_nro, image, kuvaus) values ("Käsipaino 5kg", 5, 7, "IMG_6974.jpg",
    "Käsipaino. Painaa 5 kilogrammaa.");
INSERT INTO tuote(tuotenimi, hinta, ktg_nro, image, kuvaus) values ("Rayman PS1", 25, 7, "IMG_6976.jpg",
    "Alkuperäinen Rayman harvinaisuus Playstation-konsolille. Täydellisessä kunnossa ja ohjekirjakin löytyy");
INSERT INTO tuote(tuotenimi, hinta, ktg_nro, image, kuvaus) values ("Ms Pac-Man Maze Madness PS1", 20, 7, "IMG_6979.jpg",
    "Neiti pacmanin labyrinttipeli Playstation-konsolille. Täydellisessä kunnossa, ei ohjekirjaa.");
INSERT INTO tuote(tuotenimi, hinta, ktg_nro, image, kuvaus) values ("Vaasi", 3, 6, "IMG_6982.jpg",
    "Punainen mosaiikkivaasi. Sisälle voi laittaa vaikka tuikkukynttilän. Kimmeltää kivasti auringonvalossa.");
INSERT INTO tuote(tuotenimi, hinta, ktg_nro, image, kuvaus) values ("Pääkallo-tyyny", 1, 6, "IMG_6983.jpg",
    "Paljetti-tyyny jossa pääkallo. Erittäin epämukava mutta näyttää kivalta.");
INSERT INTO tuote(tuotenimi, hinta, ktg_nro, image, kuvaus) values ("Itkevä lapsi -maalaus", 500, 6, "IMG_6984.jpg",
    "Giovanni Bragolin Itkevä lapsi -maalaus. Legendan mukaan Giovannin maalaama Crying boy -maalaus on kirottu.
    80-luvulla Britanniassa kyseinen maalaus löydettiin usean palaneen talon raunioista täysin ehjänä. Postitus 5e");
INSERT INTO tuote(tuotenimi, hinta, ktg_nro, image, kuvaus) values ("Terttu", 2, 6, "IMG_6985.jpg",
    "Kemin lumilinnan Terttu-maskotti -pehmolelu. Harvinaisuus");
INSERT INTO tuote(tuotenimi, hinta, ktg_nro, image, kuvaus) values ("Uhrilampaat VHS", 3, 7, "IMG_6986.jpg",
    "Uhrilampaat VHS-kasetti.");
INSERT INTO tuote(tuotenimi, hinta, ktg_nro, image, kuvaus) values ("Kemi kuvina", 5, 7, "IMG_6987.jpg",
    "Kemi kuvina -kirja. Sisältää kuvitusta ja Kemin historiaa. Tärkeä kulttuuritietämyksen kappale.");
INSERT INTO tuote(tuotenimi, hinta, ktg_nro, image, kuvaus) values ("Haalarit", 50, 1, "IMG_6988.jpg",
    "Outo ry:n tradenomiopiskelijoiden opiskelijahaalarit. Kaunis turkoosi sävy joka päihittää muiden alojen
    tylsät haalarit mennen tullen. Virvoitusjuomille tarkoitettu retkipullo myydään erikseen.");
INSERT INTO tuote(tuotenimi, hinta, ktg_nro, image, kuvaus) values ("Rieker kengät", 25, 1, "IMG_6990.jpg",
    "Riekerin talvikengät. Turkisreunus ja puolikorkea korko.");
INSERT INTO tuote(tuotenimi, hinta, ktg_nro, image, kuvaus) values ("Farkkutakki", 10, 1, "IMG_6992.jpg",
    "Farkkutakki. Alunperin sininen, sävytetty mustalla tekstiilivärillä.");
INSERT INTO tuote(tuotenimi, hinta, ktg_nro, image, kuvaus) values ("Samettitakki", 12, 1, "IMG_6993.jpg",
    "Samettinen päälytakki vuorella. Juhliin sopiva, erityisesti lakkiaisiin.");
INSERT INTO tuote(tuotenimi, hinta, ktg_nro, image, kuvaus) values ("Erätakki", 8, 1, "IMG_6994.jpg",
    "Camo-kuvioinen takki eräilyyn. Erinomainen kalastusreissuille tai vaikka mustikkaan. Uskomaton määrä taskuja");
INSERT INTO tuote(tuotenimi, hinta, ktg_nro, image, kuvaus) values ("Bacardi", 2, 5, "IMG_6995.jpg",
    "Tyhjä pullo Bacardia. Koristeeksi tai uuteen täyttöön.");
INSERT INTO tuote(tuotenimi, hinta, ktg_nro, image, kuvaus) values ("Kahvinkeitin", 5, 5, "IMG_6996.jpg",
    "Vaatimaton DeLonghi kahvinkeitin. Keittää kahvin.");
INSERT INTO tuote(tuotenimi, hinta, ktg_nro, image, kuvaus) values ("Keittiöveitsi", 50, 5, "IMG_6997.jpg",
    "Rovaniemen taianomaisesta kaupungista ostettu suomalaisella käsityöllä tehty Marttiini-keittiöveitsi. 
    Hullun terävä ja leikkaa porkkanat ja perunat vaivatta");
INSERT INTO tuote(tuotenimi, hinta, ktg_nro, image, kuvaus) values ("Muumimuki, Taikuri", 15, 5, "IMG_6998.jpg",
    "Arabian Taikuri-muki, eli paras muumimuki.");
INSERT INTO tuote(tuotenimi, hinta, ktg_nro, image, kuvaus) values ("Game Boy Color", 10, 7, "IMG_7000.jpg",
    "Toimiva legendaarinen Game Boy Color. Kaunis turkoosin sävy niin kuin tradenomihaalareissa konsanaan");
INSERT INTO tuote(tuotenimi, hinta, ktg_nro, image, kuvaus) values ("Pyyhekumi", 1, 7, "IMG_7001.jpg",
    "Iso uudenveroinen pyyhekumi jossa hasun hauska teksti.");
INSERT INTO tuote(tuotenimi, hinta, ktg_nro, image, kuvaus) values ("Hitachi HDD 250Gt", 20, 2, "IMG_7002.jpg",
    "Toistaiseksi toimiva kovalevy. Tilaa noin 250 Gt ehkä.");
INSERT INTO tuote(tuotenimi, hinta, ktg_nro, image, kuvaus) values ("Guest 2", 250, 2, "IMG_7004.jpg",
    "Guest 2 VR-headset ja ohjaimet");
INSERT INTO tuote(tuotenimi, hinta, ktg_nro, image, kuvaus) values ("JBL bluetooth-kuulokkeet", 45, 2, "IMG_7005.jpg",
    "Langattomat JBL kuulokkeet ja latauskotelo.");
INSERT INTO tuote(tuotenimi, hinta, ktg_nro, image, kuvaus) values ("JBL bluetooth-kaijutin", 5, 2, "IMG_7006.jpg",
    "Söpö ja käytännöllinen JBL kaijutin. Huono äänenlaatu mutta mahtuu taskuun.
    Saattaa olla vedenkestävä en oo testannu.");
