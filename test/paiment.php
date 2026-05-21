<?php
require __DIR__ . '/../includes/connexion.php';

$pdo = getConnexion();

// Récupérer l'ID de l'inscription depuis l'URL
$id = (int)($_GET['id'] ?? 0);

// Récupérer les détails de l'inscription avec la formation associée
$stmt = $pdo->prepare('
    SELECT i.*, f.titre, f.prix, f.duree, f.niveau
    FROM inscriptions i
    JOIN formations f ON i.formation_id = f.id
    WHERE i.id = ?
');
$stmt->execute([$id]);
$inscription = $stmt->fetch();

if (!$inscription) {
    header('Location: /index.php?route=formations');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Confirmation d'inscription</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; max-width: 600px; }
        .confirmation {
            background: #eafaf1;
            border: 1px solid #2ecc71;
            padding: 25px;
            border-radius: 8px;
        }
        h1 { color: #27ae60; }
        .detail { margin: 8px 0; }
        .label { font-weight: bold; color: #555; }
        .prix { color: #e67e22; font-weight: bold; font-size: 1.2em; }
        a {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        a:hover { background: #2980b9; }
    </style>
</head>
<body>

<div class="confirmation">
    <h1>✅ Inscription enregistrée !</h1>
    <p>Merci <strong><?= htmlspecialchars($inscription['prenom']) ?> <?= htmlspecialchars($inscription['nom']) ?></strong>, votre inscription a bien été reçue.</p>

    <div class="detail"><span class="label">Formation :</span> <?= htmlspecialchars($inscription['titre']) ?></div>
    <div class="detail"><span class="label">Durée :</span> <?= htmlspecialchars($inscription['duree']) ?></div>
    <div class="detail"><span class="label">Niveau :</span>s <?= htmlspecialchars($inscription['niveau']) ?></div>
    <div class="detail"><span class="label">Email :</span> <?= htmlspecialchars($inscription['email']) ?></div>
    <div class="detail"><span class="label">Statut paiement :</span> En attente</div>
    <div class="detail"><span class="label">Prix :</span> <span class="prix"><?= number_format($inscription['prix'], 2, ',', ' ') ?> DT</span></div>
</div>

<a href="/index.php?route=formations">← Retour aux formations</a>

</body>
</html>