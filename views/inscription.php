<?php include __DIR__ . '/partials/header.php'; ?>

<section style="padding:4rem 2rem; max-width:600px; margin:0 auto;">
    <h2 class="section-title">📅 Réserver une séance</h2>
    <p class="section-subtitle">Remplissez le formulaire pour vous inscrire à un programme de coaching.</p>

    <?php if (!empty($erreurs)): ?>
        <div style="background:rgba(226,75,74,0.12); border:1.5px solid #E24B4A; border-radius:var(--radius-md); padding:1rem 1.25rem; margin-bottom:1.5rem;">
            <?php foreach ($erreurs as $e): ?>
                <p style="color:#F09595; font-size:0.9rem; margin:0.25rem 0;">❌ <?= htmlspecialchars($e) ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <div class="card" style="padding:2rem;">
        <form method="POST" action="index.php?page=inscription">
            <div style="margin-bottom:1.25rem;">
                <label for="nom">Nom</label>
                <input type="text" id="nom" name="nom" placeholder="Votre nom" value="<?= htmlspecialchars($_POST['nom'] ?? '') ?>" required>
            </div>
            <div style="margin-bottom:1.25rem;">
                <label for="prenom">Prénom</label>
                <input type="text" id="prenom" name="prenom" placeholder="Votre prénom" value="<?= htmlspecialchars($_POST['prenom'] ?? '') ?>" required>
            </div>
            <div style="margin-bottom:1.25rem;">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="votre@email.com" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
            </div>
            <div style="margin-bottom:2rem;">
                <label for="formation_id">Programme de coaching</label>
                <select id="formation_id" name="formation_id" required>
                    <option value="">— Choisissez un programme —</option>
                    <?php foreach ($formations as $f): ?>
                        <option value="<?= $f['id'] ?>"
                            <?= ($formation_preselect == $f['id'] || ($_POST['formation_id'] ?? '') == $f['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($f['titre']) ?> — <?= number_format($f['prix'], 2, ',', ' ') ?> DT
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary" style="width:100%; justify-content:center;">
                ✅ Confirmer l'inscription
            </button>
        </form>
    </div>

    <div style="text-align:center; margin-top:1.5rem;">
        <a href="index.php?page=formations" style="color:var(--text-muted); font-size:0.9rem;">← Retour aux programmes</a>
    </div>
</section>

<?php include __DIR__ . '/partials/footer.php'; ?>