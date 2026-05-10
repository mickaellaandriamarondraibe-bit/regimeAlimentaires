<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<section class="page-head">

    <div class="container page-head-row" data-animate="fade-up">

        <div>

            <span class="badge" data-animate="slide-right" data-delay="80">
                <i class="fa-solid fa-list-check"></i>
                Programmes
            </span>

            <h1 data-animate="slide-right" data-delay="160">Mes programmes</h1>

        </div>

        <div class="actions">

            <a class="btn btn-light" href="<?= site_url('programme/catalogue') ?>">
                <i class="fa-solid fa-arrow-left"></i>
                Catalogue
            </a>

            <a class="btn btn-primary" href="<?= site_url('programme') ?>">
                <i class="fa-solid fa-plus"></i>
                Nouveau programme
            </a>

        </div>

    </div>

</section>

<section class="section">

    <div class="container">
        <div class="mes-prog-layout">
            <aside class="mes-prog-side card" data-animate="fade-up">
                <img src="<?= base_url('assets/img/program.png') ?>" alt="Programme nutrition et sport">
                <div class="mes-prog-side-overlay">
                    <span class="badge"><i class="fa-solid fa-dumbbell"></i> Discipline</span>
                    <h3>Ton progrès se construit chaque semaine.</h3>
                </div>
            </aside>

            <div class="mes-prog-main">

                <?php if (empty($programmes ?? [])): ?>

                    <article class="card pad">

                        <h3>Aucun programme</h3>

                        <p style="margin-top:10px;color:var(--muted);">
                            Vous n'avez encore acheté aucun programme.
                        </p>

                        <div class="actions" style="margin-top:18px;">

                            <a class="btn btn-primary" href="<?= site_url('programme/catalogue') ?>">
                                Voir le catalogue
                            </a>

                        </div>

                    </article>

                <?php else: ?>

                    <div class="programs-grid">

                        <?php foreach (($programmes ?? []) as $programme): ?>

                    <?php
                    $regimeName = $programme['regime_name'] ?? '-';

                    $sportName = $programme['sport_name'] ?? '-';

                    $prix = (float) ($programme['montant'] ?? 0);

                    $objectifKg = $programme['objectif_kg'] ?? '-';

                    $variation = $programme['variation_poids_semaine'] ?? '-';

                    $date = $programme['date_programme'] ?? ($programme['created_at'] ?? '-');
                    ?>

                            <article class="card">

                        <div class="pad">

                            <div class="actions" style="justify-content:space-between;margin-bottom:14px;">

                                <span class="badge">

                                    <i class="fa-solid fa-heart-pulse"></i>

                                    Programme actif

                                </span>

                                <span class="status-pill status-valid">
                                    Confirmé
                                </span>

                            </div>

                            <h3 style="margin-bottom:12px;">
                                <?= esc($regimeName) ?>
                            </h3>

                            <div class="admin-table-wrap" style="margin-bottom:18px;">

                                <table class="admin-table">

                                    <tbody>

                                        <tr>

                                            <th>Sport</th>

                                            <td>
                                                <?= esc($sportName) ?>
                                            </td>

                                        </tr>

                                        <tr>

                                            <th>Objectif</th>

                                            <td>
                                                <?= esc((string) $objectifKg) ?>
                                                kg
                                            </td>

                                        </tr>

                                        <tr>

                                            <th>Variation / semaine</th>

                                            <td>
                                                <?= esc((string) $variation) ?>
                                                kg
                                            </td>

                                        </tr>

                                        <tr>

                                            <th>Montant payé</th>

                                            <td>
                                                <?= esc(number_format($prix, 0, ',', ' ')) ?>
                                                Ar
                                            </td>

                                        </tr>

                                        <tr>

                                            <th>Date</th>

                                            <td>
                                                <?= esc($date) ?>
                                            </td>

                                        </tr>

                                    </tbody>

                                </table>

                            </div>

                            <div class="actions">

                                <a
                                    class="btn btn-primary full"
                                    href="<?= site_url('programme/detail/' . ($programme['id'] ?? 0)) ?>">

                                    <i class="fa-solid fa-eye"></i>

                                    Voir les détails

                                </a>

                            </div>

                        </div>

                            </article>

                        <?php endforeach; ?>

                    </div>

                <?php endif; ?>
            </div>
        </div>

    </div>

</section>

<?= $this->endSection() ?>
