<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<section class="page-head">
    <div class="container page-head-row" data-animate="fade-up">
        <div>
            <span class="badge" data-animate="slide-right" data-delay="80">
                <i class="fa-solid fa-link"></i>
                Compatibilité
            </span>
            <h1 data-animate="slide-right" data-delay="160">Régimes associés au sport</h1>
        </div>

        <div class="actions">
            <a class="btn btn-light" href="<?= site_url('sport') ?>">
                <i class="fa-solid fa-arrow-left"></i>
                Liste des sports
            </a>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">

        <article class="card pad" style="margin-bottom:22px;">
            <h3><?= esc($sport['name'] ?? 'Sport') ?></h3>
            <p style="color:var(--muted);margin-top:8px;">
                <?= esc($sport['description'] ?? 'Associer ce sport aux régimes compatibles.') ?>
            </p>
        </article>

        <article class="card pad">
            <h3>Choisir les régimes compatibles</h3>

            <?php
                $regimesLiesIds = [];

                foreach (($regimes_lies ?? []) as $regimeLie) {
                    $regimesLiesIds[] = (int) ($regimeLie['id'] ?? 0);
                }
            ?>

            <form method="post" action="<?= site_url('sport/' . ($sport['id'] ?? 0) . '/regimes/save') ?>">
                <?= csrf_field() ?>

                <?php if (empty($regimes ?? [])): ?>

                    <p>Aucun régime disponible.</p>

                <?php else: ?>

                    <div class="admin-table-wrap">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>Associer</th>
                                    <th>Régime</th>
                                    <th>Description</th>
                                    <th>Variation / semaine</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php foreach (($regimes ?? []) as $regime): ?>
                                    <tr>
                                        <td>
                                            <input
                                                type="checkbox"
                                                name="regime_ids[]"
                                                value="<?= esc((string) ($regime['id'] ?? 0)) ?>"
                                                <?= in_array((int) ($regime['id'] ?? 0), $regimesLiesIds, true) ? 'checked' : '' ?>
                                            >
                                        </td>

                                        <td>
                                            <strong><?= esc($regime['name'] ?? '-') ?></strong>
                                        </td>

                                        <td>
                                            <?= esc($regime['description'] ?? '-') ?>
                                        </td>

                                        <td>
                                            <?php $variation = (float) ($regime['variation_poids_semaine'] ?? 0); ?>

                                            <?php if ($variation > 0): ?>
                                                <span class="status-pill status-valid">
                                                    +<?= esc((string) $variation) ?> kg
                                                </span>
                                            <?php else: ?>
                                                <span class="status-pill status-refused">
                                                    <?= esc((string) $variation) ?> kg
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="actions" style="margin-top:22px;">
                        <button class="btn btn-primary" type="submit">
                            <i class="fa-solid fa-floppy-disk"></i>
                            Enregistrer les associations
                        </button>

                        <a class="btn btn-light" href="<?= site_url('sport') ?>">
                            Annuler
                        </a>
                    </div>

                <?php endif; ?>
            </form>
        </article>

    </div>
</section>

<?= $this->endSection() ?>