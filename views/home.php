<?php include __DIR__ . '/partials/header.php'; ?>

<header class="hero">
    <div style="position:relative; z-index:1;">
        <h1>Bienvenue sur <span>CoachPro</span> ✨</h1>
        <p class="hero-subtitle">
            Votre plateforme de coaching en ligne personnalisé.<br>
            Atteignez vos objectifs avec l'aide de nos coachs certifiés.
        </p>
        <a href="index.php?page=formations" class="btn btn-primary" style="margin-top:2rem;">🚀 Découvrir nos coachs</a>
    </div>
</header>

<section id="formations" style="background:var(--navy); padding:4rem 2rem;">
    <div class="section-wrapper" style="max-width:1100px; margin:0 auto;">
        <h2 class="section-title">🤝 Nos programmes de coaching</h2>
        <p class="section-subtitle">Choisissez parmi nos programmes personnalisés, conçus par des coachs certifiés.</p>
        <div class="formations-grid card-grid">
            <?php if (!empty($formations)): ?>
                <?php foreach ($formations as $f): ?>
                    <article class="card">
                        <div class="card-top" style="display:flex; align-items:center; gap:1rem; margin-bottom:1rem;">
                            <div style="font-size:2rem;">🎯</div>
                            <div>
                                <h3><?= htmlspecialchars($f['titre']) ?></h3>
                                <span class="card-badge"><?= htmlspecialchars($f['niveau']) ?></span>
                            </div>
                        </div>
                        <p style="margin-bottom:1rem;"><?= htmlspecialchars($f['description']) ?></p>
                        <div style="display:flex; gap:0.75rem; flex-wrap:wrap; margin-bottom:1.25rem;">
                            <span class="tag tag-navy">📅 <?= htmlspecialchars($f['duree']) ?></span>
                            <span class="tag tag-orange">💰 <?= number_format($f['prix'], 2, ',', ' ') ?> DT</span>
                            <span class="tag tag-gold">🏅 Certifiant</span>
                        </div>
                        <div style="display:flex; gap:0.75rem;">
                            <a href="index.php?page=formations" class="btn btn-outline" style="flex:1; justify-content:center;">👁️ Détails</a>
                            <a href="index.php?page=inscription&formation_id=<?= $f['id'] ?>" class="btn btn-primary" style="flex:1; justify-content:center;">📅 Réserver</a>
                        </div>
                    </article>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Aucun programme disponible pour le moment.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<section id="avis" style="background:var(--navy-mid); padding:4rem 2rem;">
    <div class="section-wrapper" style="max-width:1100px; margin:0 auto;">
        <h2 class="section-title">⭐ Avis de nos coachés</h2>
        <p class="section-subtitle">Découvrez ce que nos coachés pensent de leur expérience avec CoachPro.</p>
        <div class="avis-grid card-grid">

            <?php
            $avis = [
                ['initiales'=>'SS','couleur'=>'#7F77DD','nom'=>'Shahd S.','role'=>'Coaching Carrière','etoiles'=>5,'texte'=>"Un accompagnement complet et très personnalisé. Mon coach m'a aidée à décrocher mon premier poste en ML !",'badge'=>'Coaching Carrière'],
                ['initiales'=>'NM','couleur'=>'#1D9E75','nom'=>'Nour M.','role'=>'Coaching Leadership','etoiles'=>4,'texte'=>"Mon coach est un vrai expert. Les séances de leadership m'ont transformée en manager accomplie.",'badge'=>'Coaching Leadership'],
                ['initiales'=>'AS','couleur'=>'#D85A30','nom'=>'Ala S.','role'=>'Coaching Bien-être','etoiles'=>5,'texte'=>"Le coaching bien-être était exactement ce dont j'avais besoin. J'ai retrouvé mon équilibre pro/perso.",'badge'=>'Coaching Bien-être'],
                ['initiales'=>'MM','couleur'=>'#378ADD','nom'=>'Marwen M.','role'=>'Coaching Entreprise','etoiles'=>4,'texte'=>"Parfait pour notre équipe ! Le suivi personnalisé a boosté la productivité de toute notre structure.",'badge'=>'Coaching Entreprise'],
                ['initiales'=>'RD','couleur'=>'#E8A020','nom'=>'Ranime D.','role'=>'Coaching Carrière','etoiles'=>5,'texte'=>"Grâce à CoachPro, j'ai enfin osé me lancer à mon compte. Un accompagnement qui change vraiment la vie.",'badge'=>'Coaching Carrière'],
            ];
            foreach ($avis as $a):
            ?>
            <div class="card">
                <div style="display:flex; align-items:center; gap:0.75rem; margin-bottom:0.75rem;">
                    <div style="width:44px;height:44px;border-radius:50%;background:<?= $a['couleur'] ?>22;border:2px solid <?= $a['couleur'] ?>;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:0.85rem;color:<?= $a['couleur'] ?>;">
                        <?= $a['initiales'] ?>
                    </div>
                    <div>
                        <p style="color:var(--white);font-weight:600;margin:0;"><?= $a['nom'] ?></p>
                        <p style="font-size:0.8rem;margin:0;"><?= $a['role'] ?></p>
                    </div>
                </div>
                <div style="color:#E8A020;font-size:1rem;margin-bottom:0.5rem;">
                    <?= str_repeat('★', $a['etoiles']) ?><?= str_repeat('☆', 5 - $a['etoiles']) ?>
                </div>
                <p style="font-size:0.9rem;margin-bottom:0.75rem;"><?= $a['texte'] ?></p>
                <span class="card-badge"><?= $a['badge'] ?></span>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section id="pourquoi" style="background:var(--navy); padding:4rem 2rem;">
    <div class="avantages-inner" style="max-width:1100px; margin:0 auto;">
        <h2 class="section-title">🏅 Pourquoi choisir CoachPro ?</h2>
        <p class="section-subtitle">Un accompagnement personnalisé conçu pour votre réussite.</p>
        <div class="card-grid" style="grid-template-columns:repeat(auto-fit,minmax(220px,1fr)); margin-top:2rem;">
            <?php
            $avantages = [
                ['icone'=>'🎯','titre'=>'Coachs certifiés','desc'=>'Des professionnels certifiés avec une approche orientée résultats.'],
                ['icone'=>'🏅','titre'=>'Suivi personnalisé','desc'=>'Chaque programme est adapté à vos objectifs et votre rythme.'],
                ['icone'=>'💡','titre'=>'Séances flexibles','desc'=>'En ligne ou en présentiel, planifiez selon vos disponibilités.'],
                ['icone'=>'🤝','titre'=>'Réseau de coachés','desc'=>'Rejoignez une communauté bienveillante et partagez vos succès.'],
            ];
            foreach ($avantages as $av):
            ?>
            <div class="card" style="text-align:center;">
                <div style="font-size:2.5rem; margin-bottom:0.75rem;"><?= $av['icone'] ?></div>
                <h3 style="margin-bottom:0.5rem;"><?= $av['titre'] ?></h3>
                <p style="font-size:0.9rem;"><?= $av['desc'] ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php include __DIR__ . '/partials/footer.php'; ?>