<?php require __DIR__ . '/partials/header.php'; ?>

<section style="padding:4rem 2rem; max-width:560px; margin:0 auto;">

    <?php if (empty($inscription)): ?>
        <div class="card" style="text-align:center; padding:3rem 2rem;">
            <div style="font-size:3rem; margin-bottom:1rem;">💳</div>
            <h2>Réservation introuvable</h2>
            <p style="margin:1rem 0;">
                <a href="index.php" class="btn btn-outline">← Retour à l'accueil</a>
            </p>
        </div>
    <?php else: ?>

        <h2 class="section-title">💳 Confirmation de réservation</h2>

        <?php if (!empty($erreur_paiement)): ?>
            <div style="background:rgba(226,75,74,0.12); border:1.5px solid #E24B4A; border-radius:var(--radius-md); padding:1rem 1.25rem; margin-bottom:1.5rem; color:#F09595;">
                ❌ Paiement refusé — veuillez réessayer.
            </div>
        <?php endif; ?>

        <div class="card" style="margin-bottom:1.5rem; padding:2rem;">
            <div style="display:flex; flex-direction:column; gap:0.75rem;">
                <div style="display:flex; justify-content:space-between; border-bottom:1px solid var(--navy-soft); padding-bottom:0.75rem;">
                    <span style="color:var(--text-muted); font-size:0.85rem; text-transform:uppercase; letter-spacing:0.7px;">Participant</span>
                    <span style="color:var(--white); font-weight:600;"><?= htmlspecialchars($inscription['prenom']) ?> <?= htmlspecialchars($inscription['nom']) ?></span>
                </div>
                <div style="display:flex; justify-content:space-between; border-bottom:1px solid var(--navy-soft); padding-bottom:0.75rem;">
                    <span style="color:var(--text-muted); font-size:0.85rem; text-transform:uppercase; letter-spacing:0.7px;">Email</span>
                    <span><?= htmlspecialchars($inscription['email']) ?></span>
                </div>
                <div style="display:flex; justify-content:space-between; border-bottom:1px solid var(--navy-soft); padding-bottom:0.75rem;">
                    <span style="color:var(--text-muted); font-size:0.85rem; text-transform:uppercase; letter-spacing:0.7px;">Programme</span>
                    <span style="color:var(--white); font-weight:600;"><?= htmlspecialchars($inscription['formation_titre'] ?? '') ?></span>
                </div>
                <div style="display:flex; justify-content:space-between; border-bottom:1px solid var(--navy-soft); padding-bottom:0.75rem;">
                    <span style="color:var(--text-muted); font-size:0.85rem; text-transform:uppercase; letter-spacing:0.7px;">Type</span>
                    <span><?= htmlspecialchars($inscription['niveau']) ?></span>
                </div>
                <div style="display:flex; justify-content:space-between; border-bottom:1px solid var(--navy-soft); padding-bottom:0.75rem;">
                    <span style="color:var(--text-muted); font-size:0.85rem; text-transform:uppercase; letter-spacing:0.7px;">Durée</span>
                    <span><?= htmlspecialchars($inscription['duree']) ?></span>
                </div>
                <div style="display:flex; justify-content:space-between; margin-top:0.25rem;">
                    <span style="color:var(--text-muted); font-size:0.85rem; text-transform:uppercase; letter-spacing:0.7px;">Total</span>
                    <span style="color:var(--orange); font-size:1.4rem; font-weight:800; font-family:'Barlow Condensed',sans-serif;">
                        <?= number_format($inscription['prix'], 2, ',', ' ') ?> DT
                    </span>
                </div>
            </div>
        </div>

        <form method="POST" action="index.php?page=paiement&id=<?= $inscription['id'] ?>" style="display:flex; flex-direction:column; gap:0.75rem;">
            <button type="submit" name="mode" value="ok" class="btn btn-primary" style="width:100%; justify-content:center; padding:0.85rem;">
                ✅ Confirmer la réservation
            </button>
            <button type="submit" name="mode" value="fail" class="btn btn-secondary" style="width:100%; justify-content:center;">
                Simuler un échec de paiement
            </button>
        </form>

        <div style="text-align:center; margin-top:1.5rem;">
            <a href="index.php?page=formations" style="color:var(--text-muted); font-size:0.9rem;">← Retour aux programmes</a>
        </div>

    <?php endif; ?>
</section>

<?php require __DIR__ . '/partials/footer.php'; ?>