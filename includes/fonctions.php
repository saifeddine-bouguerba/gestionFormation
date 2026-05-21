<?php
function afficherErreur($erreur) {
    if (!empty($erreur)) {
        return "<div style='color:red;'>$erreur</div>";
    }
}

function afficherSucces($nom, $prenom, $email) {
    return "<div style='color:green;'>
Formulaire valide ✔ <br>
Nom : $nom <br>
Prénom : $prenom <br>
Email : $email
</div>";
}

?>