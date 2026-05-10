<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<section class="home-hero">
    <div class="container hero-grid">
        <div data-animate="hero-left">
            <span class="badge" data-animate="slide-right" data-delay="80"><i class="fa-solid fa-bolt"></i> Programme nutritionnel international</span>
            <h1 data-animate="slide-left-to-right" data-delay="180">Mangez mieux. <span>Progressez simplement.</span></h1>
            <p data-animate="slide-right" data-delay="280">Suivez nos programmes enrichis pour atteindre votre poids idéal. Profitez de coaching gratuit sur des activités sportives pour booster vos résultats.</p>
            <div class="hero-actions" data-animate="slide-right" data-delay="380">
                <a class="btn btn-primary" href="<?= session('user_id') ? site_url('programme') : site_url('login') ?>">
                    Commencer maintenant
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
                <a class="btn btn-light" href="<?= site_url('programme/catalogue') ?>">Voir les menus</a>
            </div>
        </div>

        <div class="hero-visual">
            <div class="big-food"></div>
            <img class="deco-photo d1" src="<?= base_url('assets/img/grilled-chicken-rice-spicy-chickpeas-avocado-cabbage-pepper-buddha-bowl.jpg') ?>" alt="Bol healthy décoratif">
           
            <span class="orbit o2">🥑</span>
            <span class="orbit o3">🥕</span>
            <div class="floating f1"><i class="fa-solid fa-truck-fast"></i> Livraison à domicile</div>
            <div class="floating f2"><i class="fa-solid fa-user-doctor"></i> Coach nutrition</div>
        </div>
    </div>
</section>

<section class="page-head">
    <div class="container page-head-row" data-animate="fade-up">
        <div>
            <span class="badge">
                <i class="fa-solid fa-house"></i>
                Accueil
            </span>
            <h1>Bonjour, <?= esc($client['name'] ?? session('username') ?? 'Client') ?></h1>
        </div>

        <div class="actions">
            <a class="btn btn-primary" href="<?= site_url('programme') ?>">
                <i class="fa-solid fa-bullseye"></i>
                Choisir un objectif
            </a>

            <a class="btn btn-light" href="<?= site_url('programme/catalogue') ?>">
                <i class="fa-solid fa-utensils"></i>
                Voir le catalogue
            </a>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">

        <article class="card pad home-card" data-animate="fade-up" style="margin-bottom:22px;">
            <h3>Résumé de votre compte</h3>

            <?php
            $imc = null;

            if (!empty($client['poids']) && !empty($client['taille'])) {
                $tailleM = ((float) $client['taille']) / 100;

                if ($tailleM > 0) {
                    $imc = round(((float) $client['poids']) / ($tailleM * $tailleM), 2);
                }
            }
            ?>

            <div class="metric-grid">
                <div class="metric">
                    <strong><?= esc(number_format((float) ($client['wallet'] ?? 0), 0, ',', ' ')) ?> Ar</strong>
                    <span>Wallet</span>
                </div>

                <div class="metric">
                    <strong><?= esc((string) ($imc ?? '-')) ?></strong>
                    <span>IMC actuel</span>
                </div>

                <div class="metric">
                    <strong><?= esc((string) ($client['poids'] ?? '-')) ?> kg</strong>
                    <span>Poids</span>
                </div>

                <div class="metric">
                    <strong><?= !empty($client['is_gold']) ? 'Gold' : 'Standard' ?></strong>
                    <span>Compte</span>
                </div>
            </div>
        </article>

        <div class="programs-grid">
            <article class="card pad home-card" data-animate="card">
                <img class="card-deco" src="<?= base_url('assets/img/grilled-chicken-rice-spicy-chickpeas-avocado-cabbage-pepper-buddha-bowl.jpg') ?>" alt="Illustration programme">
                <span class="badge">
                    <i class="fa-solid fa-chart-line"></i>
                    Programme
                </span>

                <h3 style="margin-top:16px;">Trouver un programme adapté</h3>

                <p style="color:var(--muted);line-height:1.7;margin:12px 0 18px;">
                    Choisissez un objectif : réduire votre poids, augmenter votre poids ou atteindre votre IMC idéal.
                </p>

                <a class="btn btn-primary full" href="<?= site_url('programme') ?>">
                    Commencer
                </a>
            </article>

            <article class="card pad home-card" data-animate="card">
                <img class="card-deco" src="<?= base_url('assets/img/top-view-healthy-diet-salad-with-grilled-chicken-broccoli-cauliflower-tomato-lettuce-avocado-lettuce.jpg') ?>" alt="Illustration catalogue">
                <span class="badge">
                    <i class="fa-solid fa-book-open"></i>
                    Catalogue
                </span>

                <h3 style="margin-top:16px;">Voir les régimes disponibles</h3>

                <p style="color:var(--muted);line-height:1.7;margin:12px 0 18px;">
                    Consultez les régimes, les tarifs selon la durée et les activités sportives compatibles.
                </p>

                <a class="btn btn-green full" href="<?= site_url('programme/catalogue') ?>">
                    Ouvrir le catalogue
                </a>
            </article>

            <article class="card pad home-card" data-animate="card">
                <h3>Recharger mon wallet</h3>

                <p style="color:var(--muted);line-height:1.7;margin:12px 0 18px;">
                    Entrez un code de recharge. La demande sera ensuite validée par un administrateur.
                </p>

                <form method="post" action="<?= site_url('envoyerCode') ?>">
                    <?= csrf_field() ?>

                    <div class="input-group">
                        <label>Code de recharge</label>
                        <input
                            class="input"
                            type="text"
                            name="code"
                            placeholder="Ex : CODE-50000"
                            required>
                    </div>

                    <button class="btn btn-primary full" type="submit">
                        <i class="fa-solid fa-paper-plane"></i>
                        Envoyer la demande
                    </button>
                </form>
            </article>
        </div>

    </div>
</section>

<?= $this->endSection() ?>
