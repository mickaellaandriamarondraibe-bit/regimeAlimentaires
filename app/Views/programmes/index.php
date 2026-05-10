<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<?php
$objectifId = (int) ($objectif_selectionne ?? 0);
$objectifKg = (float) ($objectif_kg_saisi ?? 0);
$objectifLabel = 'Objectif';

foreach (($objectifs ?? []) as $obj) {
    if ((int) ($obj['id'] ?? 0) === $objectifId) {
        $objectifLabel = (string) ($obj['name'] ?? 'Objectif');
        break;
    }
}

$objectifPill = $objectifId > 0
    ? (rtrim(rtrim(number_format(abs($objectifKg), 2, '.', ''), '0'), '.') . ' kg')
    : '-';

$heroImage = base_url('assets/img/sport.png');
$cardImages = [
    base_url('assets/img/grilled-chicken-rice-spicy-chickpeas-avocado-cabbage-pepper-buddha-bowl.jpg'),
    base_url('assets/img/top-view-healthy-diet-salad-with-grilled-chicken-broccoli-cauliflower-tomato-lettuce-avocado-lettuce.jpg'),
    base_url('assets/img/food_sport.png'),
];
?>

<section class="program-page">
    <div class="program-hero" style="background-image: linear-gradient(90deg, rgba(248, 244, 251, .96) 0%, rgba(248, 244, 251, .82) 40%, rgba(248, 244, 251, .38) 65%, rgba(248, 244, 251, .92) 100%), url('<?= esc($heroImage) ?>');">
        <div class="container program-hero-content">
            <div class="program-copy" data-animate="fade-up">
                <span class="program-chip"><i class="fa-solid fa-chart-simple"></i> Programmes personnalisés</span>
                <h1>Trouvez le programme idéal pour <span>votre objectif</span></h1>
                <p>Perte de poids, prise de masse ou équilibre alimentaire : NutriFit vous propose un régime adapté à votre profil.</p>

                <div class="program-features">
                    <span><i class="fa-solid fa-apple-whole"></i> Nutrition équilibrée</span>
                    <span><i class="fa-solid fa-dumbbell"></i> Entraînements adaptés</span>
                    <span><i class="fa-solid fa-chart-line"></i> Suivi intelligent</span>
                </div>
            </div>

            <aside class="program-stats" data-animate="fade-left">
                <div class="stat-row">
                    <span class="stat-icon"><i class="fa-solid fa-weight-scale"></i></span>
                    <div>
                        <small>IMC actuel</small>
                        <strong><?= esc((string) ($imc ?? '-')) ?></strong>
                    </div>
                    <em>Normal</em>
                </div>
                <div class="stat-row">
                    <span class="stat-icon"><i class="fa-solid fa-bullseye"></i></span>
                    <div>
                        <small>Objectif</small>
                        <strong><?= esc($objectifPill) ?></strong>
                    </div>
                    <em><?= esc($objectifLabel) ?></em>
                </div>
                <div class="stat-row">
                    <span class="stat-icon"><i class="fa-solid fa-arrow-trend-up"></i></span>
                    <div>
                        <small>Progression</small>
                        <strong><?= !empty($suggestions ?? []) ? '100%' : '0%' ?></strong>
                    </div>
                    <em><?= !empty($suggestions ?? []) ? 'Actif' : 'Débutant' ?></em>
                </div>

                <a href="<?= site_url('profil') ?>" class="program-profile-link">Mettre à jour mon profil <i class="fa-solid fa-arrow-right"></i></a>
            </aside>
        </div>
    </div>

    <div class="container">
        <section class="program-filter card" data-animate="fade-up">
            <div class="program-filter-lead">
                <span class="program-target"><i class="fa-solid fa-bullseye"></i></span>
                <div>
                    <h3>Définissez votre objectif</h3>
                    <p>Nous vous proposerons les régimes les plus adaptés.</p>
                </div>
            </div>

            <form class="program-filter-form" method="post" action="<?= site_url('programme/suggestion') ?>">
                <?= csrf_field() ?>

                <div class="input-group">
                    <label>Objectif</label>
                    <select class="select" name="objectif_id" required>
                        <option value="">Choisir un objectif</option>
                        <?php foreach (($objectifs ?? []) as $objectif): ?>
                            <option value="<?= esc((string) $objectif['id']) ?>"
                                <?= ((int) ($objectif_selectionne ?? 0) === (int) $objectif['id']) ? 'selected' : '' ?>>
                                <?= esc($objectif['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="input-group">
                    <label>Objectif en kg</label>
                    <input class="input" type="number" step="0.01" min="0.1" name="objectif_kg" placeholder="Ex : -5 ou +3"
                           value="<?= esc((string) ($objectif_kg_saisi ?? '')) ?>">
                </div>

                <button class="btn btn-primary" type="submit">
                    <i class="fa-solid fa-sparkles"></i>
                    Afficher les régimes
                </button>
            </form>
        </section>

        <section class="program-suggestions" data-animate="fade-up">
            <div class="program-suggestions-head">
                <div>
                    <h3>Régimes suggérés</h3>
                    <p>Voici les programmes adaptés à votre objectif et profil.</p>
                </div>
                <a class="btn btn-light" href="<?= site_url('programme/catalogue') ?>">Voir tous les programmes <i class="fa-solid fa-arrow-right"></i></a>
            </div>

            <?php if (empty($suggestions ?? [])): ?>
                <article class="card pad">
                    <p>Aucune suggestion pour le moment. Choisissez un objectif pour afficher vos programmes personnalisés.</p>
                </article>
            <?php else: ?>
                <div class="program-cards">
                    <?php foreach ($suggestions as $index => $s): ?>
                        <?php
                        $img = $cardImages[$index % count($cardImages)];
                        $difficulty = ((int) ($s['duree_facturee'] ?? 0) > 4) ? 'Intermédiaire' : 'Facile';
                        ?>
                        <article class="program-item card">
                            <img src="<?= esc($img) ?>" alt="Illustration régime">

                            <div class="program-item-body">
                                <h4><?= esc($s['regime']['name'] ?? '-') ?></h4>
                                <p><?= esc($s['sport']['name'] ?? '-') ?></p>

                                <div class="program-meta">
                                    <span><i class="fa-regular fa-calendar"></i> <?= esc((string) ($s['duree_facturee'] ?? '-')) ?> semaines</span>
                                    <span><i class="fa-solid fa-link"></i> <?= esc($difficulty) ?></span>
                                </div>

                                <div class="program-buy">
                                    <strong><?= esc(number_format((float) ($s['prix_final'] ?? 0), 0, ',', ' ')) ?> Ar</strong>

                                    <form method="post" action="<?= site_url('programme/confirmer') ?>" style="display: inline;">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="objectif_id" value="<?= esc((string) ($objectif_selectionne ?? 0)) ?>">
                                        <input type="hidden" name="objectif_kg" value="<?= esc((string) ($objectif_kg_saisi ?? 1)) ?>">
                                        <input type="hidden" name="regime_id" value="<?= esc((string) ($s['regime']['id'] ?? 0)) ?>">
                                        <input type="hidden" name="sport_id" value="<?= esc((string) ($s['sport']['id'] ?? 0)) ?>">
                                        <button class="program-go" type="submit"><i class="fa-solid fa-arrow-right"></i></button>
                                    </form>
                                </div>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>
    </div>
</section>

<?= $this->endSection() ?>
