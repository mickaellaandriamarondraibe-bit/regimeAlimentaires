<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<section class="page-head">
    <div class="container page-head-row">
        <div>
            <span class="badge">
                <i class="fa-solid fa-person-running"></i>
                Back Office
            </span>
            <h1>Gestion des activités sportives</h1>
        </div>

        <div class="actions">
            <a class="btn btn-primary" href="<?= site_url('sport/create') ?>">
                <i class="fa-solid fa-plus"></i>
                Nouveau sport
            </a>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <article class="card pad">
            <h3>Liste des sports</h3>

            <?php if (empty($sports ?? [])): ?>
                <p style="color:var(--muted);margin-top:10px;">
                    Aucune activité sportive enregistrée.
                </p>
            <?php else: ?>
                <div class="admin-table-wrap">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nom</th>
                                <th>Description</th>
                                <th>Variation / semaine</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach (($sports ?? []) as $sport): ?>
                                <tr>
                                    <td><?= esc((string) ($sport['id'] ?? '-')) ?></td>

                                    <td>
                                        <strong><?= esc($sport['name'] ?? '-') ?></strong>
                                    </td>

                                    <td><?= esc($sport['description'] ?? '-') ?></td>

                                    <td>
                                        <?php $variation = (float) ($sport['variation_poids_semaine'] ?? 0); ?>

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
                                        <div class="actions">
                                            <a class="btn btn-light" href="<?= site_url('sport/edit/' . ($sport['id'] ?? 0)) ?>">
                                                <i class="fa-solid fa-pen"></i>
                                                Modifier
                                            </a>

                                            <a class="btn btn-light" href="<?= site_url('sport/' . ($sport['id'] ?? 0) . '/regimes') ?>">
                                                <i class="fa-solid fa-link"></i>
                                                Régimes
                                            </a>

                                            <form method="post" action="<?= site_url('sport/delete/' . ($sport['id'] ?? 0)) ?>">
                                                <?= csrf_field() ?>
                                                <button class="btn btn-light" type="submit">
                                                    <i class="fa-solid fa-trash"></i>
                                                    Supprimer
                                                </button>
                                            </form>
                                        </div>
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