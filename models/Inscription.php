<?php
require_once __DIR__ . '/Database.php';

class Inscription
{
    public static function ajouter(string $nom, string $prenom, string $email, int $formation_id): int
    {
        $pdo = Database::connect();

        // Vérifier doublon
        $check = $pdo->prepare('SELECT id FROM inscriptions WHERE email = ? AND formation_id = ?');
        $check->execute([$email, $formation_id]);
        if ($check->fetch()) {
            throw new Exception('Cet email est déjà réservé pour ce programme de coaching.');
        }

        $stmt = $pdo->prepare(
            'INSERT INTO inscriptions (nom, prenom, email, formation_id, statut_paiement, date_inscription)
             VALUES (?, ?, ?, ?, "en_attente", NOW())'
        );
        $stmt->execute([$nom, $prenom, $email, $formation_id]);
        return (int) $pdo->lastInsertId();
    }

    public static function getById(int $id): array|false
    {
        $pdo  = Database::connect();
        $stmt = $pdo->prepare(
            'SELECT i.*, f.titre AS formation_titre, f.prix, f.duree, f.niveau
             FROM inscriptions i
             JOIN formations f ON i.formation_id = f.id
             WHERE i.id = ?'
        );
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public static function marquerPaye(int $id): void
    {
        $pdo  = Database::connect();
        $stmt = $pdo->prepare('UPDATE inscriptions SET statut_paiement = "payé" WHERE id = ?');
        $stmt->execute([$id]);
    }
}