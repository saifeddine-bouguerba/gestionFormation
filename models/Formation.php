<?php
require_once __DIR__ . '/Database.php';

class Formation
{
    /**
     * Récupère tous les programmes de coaching, avec filtre optionnel par type.
     */
    public static function getAll(string $niveau = ''): array
    {
        $pdo = Database::connect();
        if (!empty($niveau)) {
            $stmt = $pdo->prepare('SELECT * FROM formations WHERE niveau = ?');
            $stmt->execute([$niveau]);
        } else {
            $stmt = $pdo->query('SELECT * FROM formations ORDER BY id ASC');
        }
        return $stmt->fetchAll();
    }

    /**
     * Récupère un programme de coaching par son ID.
     */
    public static function getById(int $id): array|false
    {
        $pdo  = Database::connect();
        $stmt = $pdo->prepare('SELECT * FROM formations WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
}