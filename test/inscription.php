<?php
require __DIR__ . '/../includes/connexion.php';

$pdo = getConnexion();

// Récupérer l'ID de la formation depuis l'URL
$formation_id = (int)($_GET['formation_id'] ?? 0);

// Vérifier que la formation existe
$stmt = $pdo->prepare('SELECT * FROM formations WHERE id = ?');
$stmt->execute([$formation_id]);
$formation = $stmt->fetch();

// Si la formation n'existe pas, rediriger
if (!$formation) {
    header('Location: /index.php?route=formations');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription - <?= htmlspecialchars($formation['titre']) ?></title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; max-width: 600px; }
        h1 { color: #333; }
        .formation-info {
            background: #f9f9f9;
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 25px;
        }
        .prix { color: #e67e22; font-weight: bold; font-size: 1.2em; }
        label { display: block; margin-top: 15px; font-weight: bold; }
        input[type="text"], input[type="email"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 1em;
        }
        button {
            margin-top: 20px;
            padding: 12px 25px;
            background-color: #e67e22;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 1em;
            cursor: pointer;
        }
        button:hover { background-color: #d35400; }
        .retour { display: inline-block; margin-bottom: 15px; color: #555; }
    </style>
</head>
<body>

<a class="retour" href="/index.php?route=formations">← Retour aux formations</a>

<h1>Inscription à la formation</h1>

<!-- Résumé de la formation choisie -->
<div class="formation-info">
    <strong><?= htmlspecialchars($formation['titre']) ?></strong><br>
    Durée : <?= htmlspecialchars($formation['duree']) ?> |
    Niveau : <?= htmlspecialchars($formation['niveau']) ?><br>
    <span class="prix"><?= number_format($formation['prix'], 2, ',', ' ') ?> DT</span>
</div>

<!-- Formulaire d'inscription -->
<form action="/test/traitement.php" method="POST">

    <!-- ID de la formation (caché) -->
    <input type="hidden" name="formation_id" value="<?= $formation['id'] ?>">

    <label for="nom">Nom :</label>
    <input type="text" id="nom" name="nom" placeholder="Votre nom" required>

    <label for="prenom">Prénom :</label>
    <input type="text" id="prenom" name="prenom" placeholder="Votre prénom" required>

    <label for="email">Email :</label>
    <input type="email" id="email" name="email" placeholder="votre@email.com" required>

    <button type="submit">S'inscrire</button>

</form>

</body>
</html>