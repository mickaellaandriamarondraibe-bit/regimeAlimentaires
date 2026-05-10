<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<section class="page-head">
    <div class="container page-head-row" data-animate="fade-up">

        <div>
            <span class="badge" data-animate="slide-right" data-delay="80">
                <i class="fa-solid fa-utensils"></i>
                Catalogue
            </span>

            <h1 data-animate="slide-right" data-delay="160">Catalogue des régimes</h1>
        </div>

        <div class="actions">

            <a class="btn btn-light" href="<?= site_url('programme') ?>">
                <i class="fa-solid fa-arrow-left"></i>
                Retour
            </a>

            <a class="btn btn-primary" href="<?= site_url('programme/mes-programmes') ?>">
                <i class="fa-solid fa-list-check"></i>
                Mes programmes
            </a>

        </div>

    </div>
</section>

<section class="section">

    <div class="container">

        <?php if (empty($regimes ?? [])): ?>

            <article class="card pad">
                <p>Aucun régime disponible.</p>
            </article>

        <?php else: ?>

            <div class="programs-grid">

                <?php foreach (($regimes ?? []) as $regime): ?>

                    <?php
                        $variation = (float) ($regime['variation_poids_semaine'] ?? 0);

                        $prixList = $regime['prix'] ?? [];
                        $selectedPrix = $prixList[0] ?? null;
                        $prix = (float) ($selectedPrix['prix'] ?? 0);

                        $sports = $regime['sports'] ?? [];

                        $isPositive = $variation > 0;
                    ?>

                    <article class="card">

                        <div class="pad">

                            <div class="actions" style="justify-content:space-between;margin-bottom:14px;">

                                <span class="badge">

                                    <?php if ($isPositive): ?>

                                        <i class="fa-solid fa-arrow-trend-up"></i>
                                        Prise de poids

                                    <?php else: ?>

                                        <i class="fa-solid fa-arrow-trend-down"></i>
                                        Perte de poids

                                    <?php endif; ?>

                                </span>

                                <?php if (!empty($client['is_gold'])): ?>

                                    <span class="status-pill status-valid">
                                        Réduction Gold
                                    </span>

                                <?php endif; ?>

                            </div>

                            <h3 style="margin-bottom:10px;">
                                <?= esc($regime['name'] ?? '-') ?>
                            </h3>

                            <p style="color:var(--muted);line-height:1.7;margin-bottom:18px;">
                                <?= esc($regime['description'] ?? 'Programme nutritionnel personnalisé.') ?>
                            </p>

                            <div class="admin-table-wrap" style="margin-bottom:18px;">

                                <table class="admin-table">

                                    <tbody>

                                        <tr>
                                            <th>Variation / semaine</th>

                                            <td>
                                                <?= esc((string) $variation) ?>
                                                kg
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>Prix</th>

                                            <td>
                                                <?= esc(number_format($prix, 0, ',', ' ')) ?>
                                                Ar
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>Sports compatibles</th>

                                            <td>

                                                <?php if (empty($sports)): ?>

                                                    Aucun sport associé

                                                <?php else: ?>

                                                    <div class="actions">

                                                        <?php foreach ($sports as $sport): ?>

                                                            <span class="status-pill status-valid">
                                                                <?= esc($sport['name'] ?? '-') ?>
                                                            </span>

                                                        <?php endforeach; ?>

                                                    </div>

                                                <?php endif; ?>

                                            </td>
                                        </tr>

                                    </tbody>

                                </table>

                            </div>

                            <?php if (!empty($sports)): ?>

                                <?php foreach ($sports as $sport): ?>

                                    <form
                                        method="post"
                                        action="<?= site_url('programme/confirmer-catalogue') ?>"
                                        style="margin-bottom:10px;"
                                    >

                                        <?= csrf_field() ?>

                                        <input
                                            type="hidden"
                                            name="regime_id"
                                            value="<?= esc((string) ($regime['id'] ?? 0)) ?>"
                                        >

                                        <input
                                            type="hidden"
                                            name="sport_id"
                                            value="<?= esc((string) ($sport['id'] ?? 0)) ?>"
                                        >
                                        <input
                                            type="hidden"
                                            name="prix_regime_id"
                                            value="<?= esc((string) ($selectedPrix['id'] ?? 0)) ?>"
                                        >

                                        <button class="btn btn-primary full" type="submit">

                                            <i class="fa-solid fa-check"></i>

                                            Choisir avec
                                            <?= esc($sport['name'] ?? '-') ?>

                                        </button>

                                    </form>

                                <?php endforeach; ?>

                            <?php else: ?>

                                <button class="btn btn-light full" disabled>
                                    Aucun sport compatible
                                </button>

                            <?php endif; ?>

                        </div>

                    </article>

                <?php endforeach; ?>

            </div>

        <?php endif; ?>

    </div>

</section>

<?= $this->endSection() ?>
