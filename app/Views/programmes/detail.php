<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<section class="page-head">
    <div class="container page-head-row">
        <div>
            <span class="badge">
                <i class="fa-solid fa-clipboard-check"></i>
                Détail programme
            </span>
            <h1><?= esc($programme['regime']['name'] ?? 'Programme') ?></h1>
        </div>

        <div class="actions">
            <a class="btn btn-light" href="<?= site_url('programme/mes-programmes') ?>">
                <i class="fa-solid fa-arrow-left"></i>
                Mes programmes
            </a>

            <a class="btn btn-primary" href="<?= site_url('pdf/programme/' . ($programme['id'] ?? 0)) ?>">
                <i class="fa-solid fa-file-pdf"></i>
                Exporter PDF
            </a>
        </div>
    </div>
</section>

<section class="section">
    <div class="container profile-grid">

        <article class="card pad">
            <h3>Résumé du programme</h3>

            <div class="admin-table-wrap">
                <table class="admin-table">
                    <tbody>
                        <tr>
                            <th>Objectif</th>
                            <td><?= esc($programme['objectif']['name'] ?? '-') ?></td>
                        </tr>

                        <tr>
                            <th>Objectif en kg</th>
                            <td><?= esc((string) ($programme['objectif_kg'] ?? '-')) ?> kg</td>
                        </tr>

                        <tr>
                            <th>Durée</th>
                            <td><?= esc((string) ($programme['duree_semaine'] ?? '-')) ?> semaine(s)</td>
                        </tr>

                        <tr>
                            <th>Poids initial</th>
                            <td><?= esc((string) ($programme['poids_initial'] ?? '-')) ?> kg</td>
                        </tr>

                        <tr>
                            <th>Poids cible</th>
                            <td><?= esc((string) ($programme['poids_cible'] ?? '-')) ?> kg</td>
                        </tr>

                        <tr>
                            <th>IMC initial</th>
                            <td><?= esc((string) ($programme['imc_initial'] ?? '-')) ?></td>
                        </tr>

                        <tr>
                            <th>Prix payé</th>
                            <td>
                                <?= esc(number_format((float) ($programme['prix_total'] ?? 0), 0, ',', ' ')) ?>
                                Ar
                            </td>
                        </tr>

                        <tr>
                            <th>Date</th>
                            <td><?= esc($programme['date_programme'] ?? '-') ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </article>

        <article class="card pad">
            <h3>Régime choisi</h3>

            <p style="color:var(--muted);line-height:1.7;margin-bottom:18px;">
                <?= esc($programme['regime']['description'] ?? 'Aucune description disponible.') ?>
            </p>

            <div class="metric-grid" style="grid-template-columns:1fr;">
                <div class="metric">
                    <strong>
                        <?= esc((string) ($programme['regime']['variation_poids_semaine'] ?? 0)) ?>
                        kg
                    </strong>
                    <span>Variation régime / semaine</span>
                </div>
            </div>
        </article>

        <article class="card pad">
            <h3>Activités sportives associées</h3>

            <?php if (empty($programme['sports'] ?? [])): ?>
                <p>Aucun sport associé.</p>
            <?php else: ?>
                <div class="admin-table-wrap">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Sport</th>
                                <th>Description</th>
                                <th>Variation / semaine</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach (($programme['sports'] ?? []) as $sport): ?>
                                <tr>
                                    <td><?= esc($sport['name'] ?? '-') ?></td>
                                    <td><?= esc($sport['description'] ?? '-') ?></td>
                                    <td>
                                        <?= esc((string) ($sport['variation_poids_semaine'] ?? 0)) ?>
                                        kg
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </article>

        <article class="card pad">
            <h3>Transaction liée</h3>

            <?php if (empty($programme['transaction'])): ?>
                <p>Aucune transaction liée.</p>
            <?php else: ?>
                <div class="admin-table-wrap">
                    <table class="admin-table">
                        <tbody>
                            <tr>
                                <th>Type</th>
                                <td>
                                    <?php if (($programme['transaction']['type'] ?? '') === 'D'): ?>
                                        <span class="status-pill status-refused">Débit</span>
                                    <?php else: ?>
                                        <span class="status-pill status-valid">Crédit</span>
                                    <?php endif; ?>
                                </td>
                            </tr>

                            <tr>
                                <th>Montant</th>
                                <td>
                                    <?= esc(number_format((float) ($programme['transaction']['montant'] ?? 0), 0, ',', ' ')) ?>
                                    Ar
                                </td>
                            </tr>

                            <tr>
                                <th>Date</th>
                                <td><?= esc($programme['transaction']['date'] ?? '-') ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </article>

    </div>
</section>

<?= $this->endSection() ?>