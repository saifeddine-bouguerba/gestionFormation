<?php include __DIR__ . '/partials/header.php'; ?>

<section style="padding:4rem 2rem; max-width:1100px; margin:0 auto;">
    <h2 class="section-title">🤝 Tous nos programmes de coaching</h2>
    <p class="section-subtitle">Filtrez par type et trouvez le programme qui correspond à vos objectifs.</p>

    <div style="display:flex; gap:0.75rem; flex-wrap:wrap; margin-bottom:2.5rem;">
        <?php
        $niveaux = ['' => 'Tous', 'individuel' => 'Individuel', 'groupe' => 'Groupe', 'entreprise' => 'Entreprise'];
        foreach ($niveaux as $val => $label):
            $active = (($_GET['niveau'] ?? '') === $val);
        ?>
        <a href="index.php?page=formations<?= $val ? '&niveau='.$val : '' ?>"
           style="padding:0.5rem 1.25rem; border-radius:50px; font-size:0.85rem; font-weight:700; text-transform:uppercase; letter-spacing:0.8px; border:2px solid <?= $active ? 'var(--orange)' : 'var(--navy-soft)' ?>; background:<?= $active ? 'var(--orange)' : 'transparent' ?>; color:<?= $active ? '#fff' : 'var(--text-muted)' ?>; transition:all 0.2s;">
            <?= $label ?>
        </a>
        <?php endforeach; ?>
    </div>

    <?php if (empty($formations)): ?>
        <p style="color:var(--text-muted); margin-top:2rem;">Aucun programme disponible pour ce type de coaching.</p>
    <?php else: ?>
        <div class="card-grid">
            <?php foreach ($formations as $f): ?>
                <article class="card">
                    <div style="display:flex; align-items:center; gap:1rem; margin-bottom:1rem;">
                        <div style="font-size:2rem;">🎯</div>
                        <div>
                            <h3><?= htmlspecialchars($f['titre']) ?></h3>
                            <span class="card-badge"><?= htmlspecialchars($f['niveau']) ?></span>
                        </div>
                    </div>
                    <p style="margin-bottom:1rem;"><?= htmlspecialchars($f['description']) ?></p>
                    <div style="display:flex; gap:0.5rem; flex-wrap:wrap; margin-bottom:1.25rem;">
                        <span class="tag tag-navy">📅 <?= htmlspecialchars($f['duree']) ?></span>
                        <span class="tag tag-orange">💰 <?= number_format($f['prix'], 2, ',', ' ') ?> DT</span>
                        <span class="tag tag-gold">🏅 Certifiant</span>
                    </div>
                    <div style="display:flex; gap:0.75rem;">
                        <a href="index.php?page=inscription&formation_id=<?= $f['id'] ?>" class="btn btn-outline" style="flex:1; justify-content:center;">👁️ Détails</a>
                        <a href="index.php?page=inscription&formation_id=<?= $f['id'] ?>" class="btn btn-primary" style="flex:1; justify-content:center;">📅 Réserver</a>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>

<?php include __DIR__ . '/partials/footer.php'; ?>