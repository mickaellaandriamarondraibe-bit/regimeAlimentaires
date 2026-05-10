<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<section class="page-head">
    <div class="container page-head-row">
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

        <article class="card pad" style="margin-bottom:22px;">
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
            <article class="card pad">
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

            <article class="card pad">
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

            <article class="card pad">
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