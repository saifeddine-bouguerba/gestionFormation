<?php require __DIR__ . '/partials/header.php'; ?>

<section style="padding:5rem 2rem; max-width:560px; margin:0 auto; text-align:center;">
    <div class="card" style="padding:3rem 2rem;">
        <?php if (!empty($_SESSION['paiement_ok']) && $_SESSION['paiement_ok'] === true): ?>
            <div style="font-size:4rem; margin-bottom:1rem;">🎉</div>
            <h1 style="color:var(--orange); margin-bottom:1rem;">Réservation confirmée !</h1>
            <p style="margin-bottom:0.5rem;">
                Merci <strong style="color:var(--white);"><?= htmlspecialchars($_SESSION['etudiant_prenom'] ?? '') ?></strong>, votre réservation a bien été enregistrée.
            </p>
            <p style="margin-bottom:0.5rem;">Vous êtes désormais inscrit(e) au programme :</p>
            <p style="color:var(--orange); font-size:1.15rem; font-weight:700; font-family:'Barlow Condensed',sans-serif; text-transform:uppercase; margin:1rem 0;">
                <?= htmlspecialchars($_SESSION['formation_titre'] ?? '') ?>
            </p>
            <p style="color:var(--text-muted); font-size:0.9rem; margin-bottom:2rem;">
                Votre coach vous contactera sous 24h pour fixer votre première séance.
            </p>
            <a href="index.php?page=cours" class="btn btn-primary" style="display:inline-flex; justify-content:center;">
                🎯 Accéder à mon espace coaching
            </a>
        <?php else: ?>
            <div style="font-size:4rem; margin-bottom:1rem;">⚠️</div>
            <h1 style="margin-bottom:1rem;">Page introuvable</h1>
            <p style="margin-bottom:2rem;">Aucune confirmation de réservation trouvée pour cette session.</p>
            <a href="index.php" class="btn btn-outline">← Retour à l'accueil</a>
        <?php endif; ?>
    </div>
</section>

<?php require __DIR__ . '/partials/footer.php'; ?>