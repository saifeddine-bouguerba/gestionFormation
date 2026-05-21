-- Script de création de la base de données `gestion_formations`
CREATE DATABASE IF NOT EXISTS gestion_formations DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE gestion_formations;

CREATE TABLE IF NOT EXISTS formations (
  id INT AUTO_INCREMENT PRIMARY KEY,
  titre VARCHAR(255) NOT NULL,
  description TEXT,
  duree VARCHAR(100),
  niveau VARCHAR(100),
  prix DECIMAL(10,2) DEFAULT 0
);

CREATE TABLE IF NOT EXISTS inscriptions (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nom VARCHAR(255) NOT NULL,
  prenom VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL,
  formation_id INT NOT NULL,
  statut_paiement VARCHAR(50) DEFAULT 'en_attente',
  date_inscription DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (formation_id) REFERENCES formations(id) ON DELETE CASCADE
);