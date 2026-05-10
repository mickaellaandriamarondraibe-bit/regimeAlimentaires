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

<section class="catalogue-cover" data-animate="fade-up">
    <div class="container">
        <div class="catalogue-cover-media">
            <img src="<?= base_url('assets/img/food_sport.png') ?>" alt="Nutrition et sport">
            <div class="catalogue-cover-overlay">
                <span class="badge"><i class="fa-solid fa-fire"></i> Motivation</span>
                <h2>Mange bien. Bouge fort. Reste régulier.</h2>
            </div>
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
                    $sports = $regime['sports'] ?? [];
                    $isPositive = $variation > 0;

                    $prixMin = null;

                    foreach ($prixList as $p) {
                        $val = (float) ($p['prix'] ?? 0);

                        if ($prixMin === null || $val < $prixMin) {
                            $prixMin = $val;
                        }
                    }

                    $modalId = 'modal-regime-' . (int) ($regime['id'] ?? 0);
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
                                    <span class="status-pill status-valid">Réduction Gold</span>
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
                                            <td><?= esc((string) $variation) ?> kg</td>
                                        </tr>

                                        <tr>
                                            <th>Prix</th>
                                            <td>
                                                <?php if ($prixMin !== null): ?>
                                                    À partir de <?= esc(number_format($prixMin, 0, ',', ' ')) ?> Ar
                                                <?php else: ?>
                                                    Aucun tarif
                                                <?php endif; ?>
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>Sports compatibles</th>
                                            <td>
                                                <?php if (empty($sports)): ?>
                                                    Aucun sport associé
                                                <?php else: ?>
                                                    <div class="actions" style="flex-wrap:wrap;">
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

                            <?php if (!empty($sports) && !empty($prixList)): ?>
                                <button
                                    class="btn btn-primary full js-open-program-modal"
                                    type="button"
                                    data-modal-id="<?= esc($modalId) ?>">
                                    <i class="fa-solid fa-check"></i>
                                    Choisir ce programme
                                </button>
                            <?php else: ?>
                                <button class="btn btn-light full" disabled>
                                    Programme indisponible
                                </button>
                            <?php endif; ?>

                        </div>
                    </article>

                    <div id="<?= esc($modalId) ?>" class="catalogue-modal">
                        <div class="card catalogue-modal-card">>
                            <div class="pad">

                                <div class="actions" style="justify-content:space-between;margin-bottom:18px;">
                                    <h3 style="margin:0;">
                                        <?= esc($regime['name'] ?? '-') ?>
                                    </h3>

                                    <button
                                        type="button"
                                        class="btn btn-light js-close-program-modal"
                                        data-modal-id="<?= esc($modalId) ?>">
                                        <i class="fa-solid fa-xmark"></i>
                                    </button>
                                </div>

                                <form method="post" action="<?= site_url('programme/confirmer-catalogue') ?>">
                                    <?= csrf_field() ?>

                                    <input type="hidden" name="regime_id" value="<?= esc((string) ($regime['id'] ?? 0)) ?>">

                                    <div class="input-group" style="margin-bottom:16px;">
                                        <label>Durée et tarif</label>

                                        <select class="select" name="prix_regime_id" required>
                                            <option value="">Choisir une durée</option>

                                            <?php foreach ($prixList as $prix): ?>
                                                <option value="<?= esc((string) ($prix['id'] ?? 0)) ?>">
                                                    <?= esc((string) ($prix['duree_semaine'] ?? 0)) ?> semaines -
                                                    <?= esc(number_format((float) ($prix['prix'] ?? 0), 0, ',', ' ')) ?> Ar
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="input-group" style="margin-bottom:16px;">
                                        <label>Sports à associer</label>

                                        <div style="display:grid;gap:10px;margin-top:8px;">
                                            <?php foreach ($sports as $sport): ?>
                                                <label style="display:flex;align-items:center;gap:10px;">
                                                    <input
                                                        type="checkbox"
                                                        name="sport_ids[]"
                                                        value="<?= esc((string) ($sport['id'] ?? 0)) ?>">
                                                    <span>
                                                        <?= esc($sport['name'] ?? '-') ?>
                                                        <small style="color:var(--muted);">
                                                            —
                                                            <?= esc((string) ($sport['variation_poids_semaine'] ?? 0)) ?>
                                                            kg / semaine
                                                        </small>
                                                    </span>
                                                </label>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>

                                    <button class="btn btn-primary full" type="submit">
                                        <i class="fa-solid fa-arrow-right"></i>
                                        Continuer vers l’aperçu
                                    </button>
                                </form>

                            </div>
                        </div>
                    </div>

                <?php endforeach; ?>

            </div>

        <?php endif; ?>

    </div>

</section>

<?= $this->endSection() ?>