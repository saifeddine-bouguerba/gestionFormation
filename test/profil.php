<?php
$nom = "Mezzi";
$prenom = "Rania";
$email = "rania.mezzi@edu.isetcom.tn";
$age = 20;
$ville = "Bizerte";
$formation = "développement web";

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Profil utilisateur</title>
</head>
<body>
    <h1>Profil utilisateur</h1>
    <p><strong>Nom :</strong> <?= $nom ?></p>
    <p><strong>Prénom :</strong> <?= $prenom ?></p>
    <p><strong>Email :</strong> <?= $email ?></p>
    <p><strong>Âge :</strong> <?php echo $age; ?> ans</p>
    <p><strong>Ville :</strong> <?= $ville ?></p>
    <p><strong>Formation :</strong> <?= $formation ?></p>
    <?php echo "<p>Bienvenue $prenom , dans la formation $formation !</p>"; ?>

</body>
</html>