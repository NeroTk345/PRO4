CREATE DATABASE Aurora;
USE Aurora;

-- Gebruik InnoDB voor relationele integriteit

-- Tabel: Gebruiker
CREATE TABLE Gebruiker (
    Id INT PRIMARY KEY AUTO_INCREMENT,
    Voornaam VARCHAR(50) NOT NULL,
    Tussenvoegsel VARCHAR(10),
    Achternaam VARCHAR(50) NOT NULL,
    Gebruikersnaam VARCHAR(100) NOT NULL,
    Wachtwoord VARCHAR(255) NOT NULL,
    IsIngelogd BIT NOT NULL,
    Ingelogd DATETIME,
    Uitgelogd DATETIME,
    Isactief BIT NOT NULL,
    Opmerking VARCHAR(250),
    Datumaangemaakt DATETIME(6) NOT NULL,
    Datumgewijzigd DATETIME(6) NOT NULL
) ENGINE=InnoDB;

-- Tabel: Rol
CREATE TABLE Rol (
    Id INT PRIMARY KEY AUTO_INCREMENT,
    GebruikerId INT NOT NULL,
    Naam VARCHAR(100) NOT NULL,
    Isactief BIT NOT NULL,
    Opmerking VARCHAR(250),
    Datumaangemaakt DATETIME(6) NOT NULL,
    Datumgewijzigd DATETIME(6) NOT NULL,
    FOREIGN KEY (GebruikerId) REFERENCES Gebruiker(Id)
) ENGINE=InnoDB;

-- Tabel: Contact
CREATE TABLE Contact (
    Id INT PRIMARY KEY AUTO_INCREMENT,
    GebruikerId INT NOT NULL,
    Email VARCHAR(100) NOT NULL,
    Mobiel VARCHAR(20) NOT NULL,
    Isactief BIT NOT NULL,
    Opmerking VARCHAR(250),
    Datumaangemaakt DATETIME(6) NOT NULL,
    Datumgewijzigd DATETIME(6) NOT NULL,
    FOREIGN KEY (GebruikerId) REFERENCES Gebruiker(Id)
) ENGINE=InnoDB;

-- Tabel: Medewerker
CREATE TABLE Medewerker (
    Id INT PRIMARY KEY AUTO_INCREMENT,
    GebruikerId INT NOT NULL,
    Nummer MEDIUMINT NOT NULL UNIQUE,
    Medewerkersoort VARCHAR(20) NOT NULL,
    Isactief BIT NOT NULL,
    Opmerking VARCHAR(250),
    Datumaangemaakt DATETIME(6) NOT NULL,
    Datumgewijzigd DATETIME(6) NOT NULL,
    FOREIGN KEY (GebruikerId) REFERENCES Gebruiker(Id)
) ENGINE=InnoDB;

-- Tabel: Bezoeker
CREATE TABLE Bezoeker (
    Id INT PRIMARY KEY AUTO_INCREMENT,
    GebruikerId INT NOT NULL,
    Relatienummer MEDIUMINT NOT NULL UNIQUE,
    Isactief BIT NOT NULL,
    Opmerking VARCHAR(250),
    Datumaangemaakt DATETIME(6) NOT NULL,
    Datumgewijzigd DATETIME(6) NOT NULL,
    FOREIGN KEY (GebruikerId) REFERENCES Gebruiker(Id)
) ENGINE=InnoDB;

-- Tabel: Prijs
CREATE TABLE Prijs (
    Id INT PRIMARY KEY AUTO_INCREMENT,
    Tarief DECIMAL(5,2) NOT NULL,
    Isactief BIT NOT NULL,
    Opmerking VARCHAR(250),
    Datumaangemaakt DATETIME(6) NOT NULL,
    Datumgewijzigd DATETIME(6) NOT NULL
) ENGINE=InnoDB;

-- Tabel: Voorstelling
CREATE TABLE Voorstelling (
    Id INT PRIMARY KEY AUTO_INCREMENT,
    MedewerkerId INT NOT NULL,
    Naam VARCHAR(100) NOT NULL,
    Beschrijving TEXT,
    Datum DATE NOT NULL,
    Tijd TIME NOT NULL,
    MaxAantalTickets INT NOT NULL,
    Beschikbaarheid VARCHAR(50) NOT NULL,
    Isactief BIT NOT NULL,
    Opmerking VARCHAR(250),
    Datumaangemaakt DATETIME(6) NOT NULL,
    Datumgewijzigd DATETIME(6) NOT NULL,
    FOREIGN KEY (MedewerkerId) REFERENCES Medewerker(Id)
) ENGINE=InnoDB;

-- Tabel: Ticket
CREATE TABLE Ticket (
    Id INT PRIMARY KEY AUTO_INCREMENT,
    BezoekerId INT NOT NULL,
    VoorstellingId INT NOT NULL,
    PrijsId INT NOT NULL,
    Nummer MEDIUMINT NOT NULL UNIQUE,
    Barcode VARCHAR(20) NOT NULL UNIQUE,
    Datum DATE NOT NULL,
    Tijd TIME NOT NULL,
    Status VARCHAR(20) NOT NULL,
    Isactief BIT NOT NULL,
    Opmerking VARCHAR(250),
    Datumaangemaakt DATETIME(6) NOT NULL,
    Datumgewijzigd DATETIME(6) NOT NULL,
    FOREIGN KEY (BezoekerId) REFERENCES Bezoeker(Id),
    FOREIGN KEY (VoorstellingId) REFERENCES Voorstelling(Id),
    FOREIGN KEY (PrijsId) REFERENCES Prijs(Id)
) ENGINE=InnoDB;

-- Tabel: Melding
CREATE TABLE Melding (
    Id INT PRIMARY KEY AUTO_INCREMENT,
    BezoekerId INT,
    VoorstellingId INT,
    Nummer MEDIUMINT NOT NULL UNIQUE,
    Type VARCHAR(20) NOT NULL,
    Bericht VARCHAR(250) NOT NULL,
    Isactief BIT NOT NULL,
    Opmerking VARCHAR(250),
    Datumaangemaakt DATETIME(6) NOT NULL,
    Datumgewijzigd DATETIME(6) NOT NULL,
    FOREIGN KEY (BezoekerId) REFERENCES Bezoeker(Id),
    FOREIGN KEY (VoorstellingId) REFERENCES Voorstelling(Id)
) ENGINE=InnoDB;

-- 1. Maak de voorstellingen tabel aan
CREATE TABLE IF NOT EXISTS voorstellingen (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titel VARCHAR(255) NOT NULL,
    beschrijving TEXT,
    datum DATE NOT NULL,
    tijd TIME NOT NULL,
    prijs DECIMAL(10,2) NOT NULL,
    max_bezoekers INT DEFAULT 100,
    huidige_bezoekers INT DEFAULT 0,
    locatie VARCHAR(255),
    afbeelding_url VARCHAR(500),
    status ENUM('actief', 'inactief', 'uitverkocht') DEFAULT 'actief',
    aangemaakt_op TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    gewijzigd_op TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- 2. Zorg ervoor dat Gebruiker tabel een id kolom heeft (als die er nog niet is)
-- ALTER TABLE Gebruiker ADD COLUMN id INT AUTO_INCREMENT PRIMARY KEY FIRST;

-- 3. Maak een beheerder account aan (optioneel, voor testen)
INSERT INTO Gebruiker (Voornaam, Achternaam, Gebruikersnaam, Wachtwoord, IsIngelogd, Isactief, Datumaangemaakt, Datumgewijzigd) 
VALUES ('Admin', 'Gebruiker', 'admin@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 0, 1, NOW(), NOW());

-- 4. Voeg beheerder rol toe
-- Eerst haal het ID van de beheerder op en vervang XXX hieronder met dat ID
-- SELECT id FROM Gebruiker WHERE Gebruikersnaam = 'admin@example.com';
-- INSERT INTO rol (Gebruikerid, Naam) VALUES (XXX, 'Beheerder');

-- 5. Voeg test voorstellingen toe (optioneel)
INSERT INTO voorstellingen (titel, beschrijving, datum, tijd, prijs, max_bezoekers, locatie, afbeelding_url, status) VALUES
('Romeo en Julia', 'De klassieke tragedie van Shakespeare over onmogelijke liefde', '2025-06-15', '20:00:00', 25.00, 150, 'Grote Zaal', 'https://images.unsplash.com/photo-1507924538820-ede94a04019d', 'actief'),
('Comedy Night', 'Een avond vol humor met de beste Nederlandse cabaretiers', '2025-06-20', '19:30:00', 22.50, 120, 'Kleine Zaal', 'https://images.unsplash.com/photo-1465101046530-73398c7f28ca', 'actief'),
('Jazz Concert', 'Intieme jazzavond met lokale en internationale musici', '2025-06-25', '21:00:00', 18.00, 80, 'Café Theater', 'https://images.unsplash.com/photo-1509228468518-180dd4864904', 'actief');

