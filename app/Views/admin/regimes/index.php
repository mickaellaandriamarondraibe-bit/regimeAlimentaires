<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<section class="page-head">
    <div class="container page-head-row" data-animate="fade-up">
        <div>
            <span class="badge" data-animate="slide-right" data-delay="80">
                <i class="fa-solid fa-utensils"></i>
                Back Office
            </span>
            <h1 data-animate="slide-right" data-delay="160">Gestion des régimes</h1>
        </div>

        <div class="actions">
            <a class="btn btn-light" href="<?= site_url('ingredient') ?>">
                <i class="fa-solid fa-carrot"></i>
                Ingrédients
            </a>

            <a class="btn btn-primary" href="<?= site_url('regime/create') ?>">
                <i class="fa-solid fa-plus"></i>
                Nouveau régime
            </a>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">

        <article class="card pad">
            <h3>Liste des régimes</h3>

            <?php if (empty($regimes ?? [])): ?>

                <p style="color:var(--muted);margin-top:10px;">
                    Aucun régime enregistré.
                </p>

            <?php else: ?>

                <div class="admin-table-wrap">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nom</th>
                                <th>Variation / semaine</th>
                                <th>Compositions</th>
                                <th>Tarifs</th>
                                <th>Sports associés</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach (($regimes ?? []) as $regime): ?>
                                <tr>
                                    <td><?= esc((string) ($regime['id'] ?? '-')) ?></td>

                                    <td>
                                        <strong><?= esc($regime['name'] ?? '-') ?></strong>
                                        <br>
                                        <span style="color:var(--muted);font-size:.88rem;">
                                            <?= esc($regime['description'] ?? '-') ?>
                                        </span>
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

                                    <td>
                                        <?php if (empty($regime['compositions'] ?? [])): ?>
                                            -
                                        <?php else: ?>
                                            <?php foreach ($regime['compositions'] as $composition): ?>
                                                <div>
                                                    <?= esc($composition['ingredient_name'] ?? '-') ?>
                                                    :
                                                    <strong><?= esc((string) ($composition['pourcentage'] ?? 0)) ?>%</strong>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </td>

                                    <td>
                                        <?php if (empty($regime['prix'] ?? [])): ?>
                                            -
                                        <?php else: ?>
                                            <?php foreach ($regime['prix'] as $prix): ?>
                                                <div>
                                                    <?= esc((string) ($prix['duree_semaine'] ?? '-')) ?> sem.
                                                    :
                                                    <strong>
                                                        <?= esc(number_format((float) ($prix['prix'] ?? 0), 0, ',', ' ')) ?>
                                                        Ar
                                                    </strong>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </td>

                                    <td>
                                        <?php if (empty($regime['sport_associe'] ?? [])): ?>
                                            -
                                        <?php else: ?>
                                            <?php foreach ($regime['sport_associe'] as $sport): ?>
                                                <span class="status-pill status-valid">
                                                    <?= esc($sport['name'] ?? '-') ?>
                                                </span>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </td>

                                    <td>
                                        <a
                                            class="btn btn-light"
                                            href="<?= site_url('regime/detail/' . ($regime['id'] ?? 0)) ?>"
                                        >
                                            <i class="fa-solid fa-eye"></i>
                                            Détail
                                        </a>
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