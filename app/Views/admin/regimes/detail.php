<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<section class="page-head">
    <div class="container page-head-row">
        <div>
            <span class="badge">
                <i class="fa-solid fa-utensils"></i>
                Régime
            </span>
            <h1><?= esc($regime['name'] ?? 'Détail régime') ?></h1>
        </div>

        <div class="actions">
            <a class="btn btn-light" href="<?= site_url('regime/list') ?>">
                <i class="fa-solid fa-arrow-left"></i>
                Liste des régimes
            </a>

            <a class="btn btn-primary" href="<?= site_url('regime/create') ?>">
                <i class="fa-solid fa-plus"></i>
                Nouveau régime
            </a>
        </div>
    </div>
</section>

<section class="section">
    <div class="container profile-grid">

        <article class="card pad">
            <h3>Informations générales</h3>

            <div class="admin-table-wrap">
                <table class="admin-table">
                    <tbody>
                        <tr>
                            <th>ID</th>
                            <td><?= esc((string) ($regime['id'] ?? '-')) ?></td>
                        </tr>

                        <tr>
                            <th>Nom</th>
                            <td><?= esc($regime['name'] ?? '-') ?></td>
                        </tr>

                        <tr>
                            <th>Description</th>
                            <td><?= esc($regime['description'] ?? '-') ?></td>
                        </tr>

                        <tr>
                            <th>Variation / semaine</th>
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
                    </tbody>
                </table>
            </div>
        </article>

        <article class="card pad">
            <h3>Composition alimentaire</h3>

            <?php if (empty($regime['compositions'] ?? [])): ?>
                <p>Aucune composition enregistrée.</p>
            <?php else: ?>
                <div class="admin-table-wrap">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Ingrédient</th>
                                <th>Pourcentage</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach (($regime['compositions'] ?? []) as $composition): ?>
                                <tr>
                                    <td><?= esc($composition['ingredient_name'] ?? '-') ?></td>
                                    <td>
                                        <strong>
                                            <?= esc((string) ($composition['pourcentage'] ?? 0)) ?>%
                                        </strong>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </article>

        <article class="card pad">
            <h3>Tarifs</h3>

            <?php if (empty($regime['prix'] ?? [])): ?>
                <p>Aucun tarif enregistré.</p>
            <?php else: ?>
                <div class="admin-table-wrap">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Durée</th>
                                <th>Prix</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach (($regime['prix'] ?? []) as $prix): ?>
                                <tr>
                                    <td>
                                        <?= esc((string) ($prix['duree_semaine'] ?? '-')) ?>
                                        semaine(s)
                                    </td>

                                    <td>
                                        <strong>
                                            <?= esc(number_format((float) ($prix['prix'] ?? 0), 0, ',', ' ')) ?>
                                            Ar
                                        </strong>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </article>

        <article class="card pad">
            <h3>Sports compatibles</h3>

            <?php if (empty($regime['sport_associe'] ?? [])): ?>
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
                            <?php foreach (($regime['sport_associe'] ?? []) as $sport): ?>
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

    </div>
</section>

<?= $this->endSection() ?>