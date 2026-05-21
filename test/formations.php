<?php
// Ce fichier récupère les formations depuis la BD et les affiche.
require __DIR__ . '/../includes/connexion.php';

$pdo = getConnexion();

// Récupérer le filtre niveau depuis l'URL (optionnel)
$niveau = $_GET['niveau'] ?? '';

if (!empty($niveau)) {
    // Requête préparée avec paramètre variable
    $stmt = $pdo->prepare('SELECT * FROM formations WHERE niveau = ?');
    $stmt->execute([$niveau]);
} else {
    // Pas de filtre : retourner toutes les formations
    $stmt = $pdo->query('SELECT * FROM formations ORDER BY id ASC');
}

$formations = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Nos Formations</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; }
        .formation {
            border: 1px solid #ddd;
            padding: 20px;
            margin: 15px 0;
            border-radius: 8px;
        }
        .prix {
            color: #e67e22;
            font-size: 1.3em;
            font-weight: bold;
        }
        .filtres {
            margin-bottom: 20px;
        }
        .filtres a {
            margin-right: 10px;
        }
    </style>
</head>
<body>

<h1>Liste des Formations</h1>

<!-- Liens de filtrage -->
<div class="filtres">
    <a href="/index.php?route=formations">Toutes les formations</a> |
    <a href="/index.php?route=formations&niveau=Débutant">Débutant</a> |
    <a href="/index.php?route=formations&niveau=Intermédiaire">Intermédiaire</a> |
    <a href="/index.php?route=formations&niveau=Avancé">Avancé</a>
</div>

<?php if (empty($formations)): ?>
    <p>Aucune formation disponible pour le moment.</p>
<?php else: ?>
    <?php foreach ($formations as $f): ?>
        <div class="formation">
            <h2><?= htmlspecialchars($f['titre']) ?></h2>
            <p><?= htmlspecialchars($f['description']) ?></p>
            <p>
                Durée : <?= htmlspecialchars($f['duree']) ?> |
                Niveau : <?= htmlspecialchars($f['niveau']) ?>
            </p>
            <p class="prix">
                <?= number_format($f['prix'], 2, ',', ' ') ?> DT
            </p>
            <a href="/index.php?route=inscription&formation_id=<?= $f['id'] ?>">
                S'inscrire
            </a>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

</body>
</html>