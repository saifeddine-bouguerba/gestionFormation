<?php include __DIR__ . '/partials/header.php'; ?>

<section style="padding:3rem 2rem; max-width:900px; margin:0 auto;">

    <?php if (!$formation): ?>
        <div class="card" style="text-align:center; padding:3rem;">
            <p>Aucun programme trouvé pour votre session.</p>
            <a href="index.php" class="btn btn-outline" style="margin-top:1.5rem; display:inline-flex;">← Retour à l'accueil</a>
        </div>
    <?php else: ?>

    <!-- Breadcrumb -->
    <div style="font-size:0.85rem; color:var(--text-muted); margin-bottom:2rem;">
        <a href="index.php" style="color:var(--text-muted);">Accueil</a>
        <span style="margin:0 0.5rem; color:var(--orange);">›</span>
        <a href="index.php?page=formations" style="color:var(--text-muted);">Programmes</a>
        <span style="margin:0 0.5rem; color:var(--orange);">›</span>
        <span style="color:var(--white);"><?= htmlspecialchars($formation['titre']) ?></span>
    </div>

    <!-- Welcome banner -->
    <div style="background:rgba(244,101,12,0.1); border:1.5px solid rgba(244,101,12,0.3); border-radius:var(--radius-lg); padding:1.5rem 2rem; display:flex; align-items:center; gap:1.25rem; margin-bottom:2.5rem;">
        <div style="font-size:2.5rem;">🎯</div>
        <div>
            <h2 style="font-size:1.2rem; margin-bottom:0.25rem;">
                Bienvenue, <?= htmlspecialchars($_SESSION['etudiant_prenom'] ?? 'Coaché') ?> !
            </h2>
            <p style="font-size:0.9rem; margin:0;">
                Votre séance de coaching <strong style="color:var(--orange);"><?= htmlspecialchars($formation['titre']) ?></strong> est confirmée. Votre coach vous contactera sous 24h.
            </p>
        </div>
    </div>

    <!-- Formation header -->
    <div class="card" style="display:flex; align-items:flex-start; gap:1.5rem; padding:2rem; margin-bottom:2rem;">
        <div style="font-size:3rem;">🎯</div>
        <div style="flex:1;">
            <h1 style="font-size:1.6rem; margin-bottom:0.5rem;"><?= htmlspecialchars($formation['titre']) ?></h1>
            <p style="margin-bottom:1rem;"><?= htmlspecialchars($formation['description']) ?></p>
            <div style="display:flex; gap:0.75rem; flex-wrap:wrap;">
                <span class="tag tag-navy">📅 <?= htmlspecialchars($formation['duree']) ?></span>
                <span class="tag tag-navy">🤝 <?= htmlspecialchars($formation['niveau']) ?></span>
                <span class="tag tag-gold">🏅 Certifiant</span>
            </div>
        </div>
    </div>

    <!-- Programme -->
    <h2 class="section-title" style="margin-bottom:1.5rem;">📋 Déroulé des séances</h2>

    <?php
    $modules = [
        ['num'=>1,'titre'=>'Séance de découverte','duree'=>'Séance 1','items'=>['Présentation mutuelle coach / coaché','Définition des objectifs personnels','Évaluation de la situation actuelle','Élaboration du plan d\'action']],
        ['num'=>2,'titre'=>'Développement & Progression','duree'=>'Séances 2–3','items'=>['Travail sur les axes d\'amélioration','Exercices pratiques personnalisés','Retours et ajustements du coach','Suivi des progrès réalisés']],
        ['num'=>3,'titre'=>'Consolidation & Autonomie','duree'=>'Séances 4–5','items'=>['Ancrage des nouvelles habitudes','Gestion des obstacles et blocages','Développement de l\'autonomie','Bilan intermédiaire avec le coach']],
        ['num'=>4,'titre'=>'Bilan final & Certification','duree'=>'Séance finale','items'=>['Bilan complet du parcours de coaching','Célébration des réussites obtenues','Remise du certificat CoachPro','Accès au réseau de coachés alumni']],
    ];
    foreach ($modules as $m):
    ?>
    <div class="card" style="margin-bottom:1rem; padding:1.5rem 2rem;">
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:1rem;">
            <div style="display:flex; align-items:center; gap:1rem;">
                <div style="width:36px; height:36px; border-radius:50%; background:var(--orange); display:flex; align-items:center; justify-content:center; font-weight:800; font-size:0.9rem; color:#fff; flex-shrink:0;">
                    <?= $m['num'] ?>
                </div>
                <h3 style="margin:0;"><?= $m['titre'] ?></h3>
            </div>
            <span class="tag tag-navy"><?= $m['duree'] ?></span>
        </div>
        <ul style="list-style:none; padding:0; display:flex; flex-direction:column; gap:0.4rem;">
            <?php foreach ($m['items'] as $item): ?>
            <li style="font-size:0.9rem; color:var(--text-muted); padding-left:1rem; position:relative;">
                <span style="position:absolute; left:0; color:var(--orange);">›</span>
                <?= $item ?>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php endforeach; ?>

    <!-- Ressources -->
    <h2 class="section-title" style="margin:2.5rem 0 1.5rem;">📂 Ressources disponibles</h2>

    <?php
    $ressources = [
        ['icone'=>'📄','titre'=>'Guide de coaching (PDF)','desc'=>'Fiches pratiques et outils de développement personnel','dispo'=>true],
        ['icone'=>'🎬','titre'=>'Replays des séances','desc'=>'Enregistrements de vos sessions de coaching','dispo'=>true],
        ['icone'=>'📝','titre'=>'Exercices personnalisés','desc'=>'Travaux pratiques adaptés à vos objectifs','dispo'=>true],
        ['icone'=>'🏅','titre'=>'Certificat CoachPro','desc'=>'Délivré après validation du bilan final','dispo'=>false],
    ];
    foreach ($ressources as $r):
    ?>
    <div class="card" style="display:flex; align-items:center; gap:1rem; padding:1rem 1.5rem; margin-bottom:0.75rem;">
        <div style="font-size:1.75rem; flex-shrink:0;"><?= $r['icone'] ?></div>
        <div style="flex:1;">
            <p style="color:var(--white); font-weight:600; margin:0 0 0.2rem;"><?= $r['titre'] ?></p>
            <p style="font-size:0.85rem; margin:0;"><?= $r['desc'] ?></p>
        </div>
        <?php if ($r['dispo']): ?>
            <span class="tag tag-gold" style="white-space:nowrap;">✅ Disponible</span>
        <?php else: ?>
            <span class="tag tag-navy" style="white-space:nowrap;">🔒 À débloquer</span>
        <?php endif; ?>
    </div>
    <?php endforeach; ?>

    <div style="text-align:center; margin-top:2.5rem;">
        <a href="index.php" style="color:var(--text-muted); font-size:0.9rem;">← Retour à l'accueil</a>
    </div>

    <?php endif; ?>
</section>

<?php include __DIR__ . '/partials/footer.php'; ?>