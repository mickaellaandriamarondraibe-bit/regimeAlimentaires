<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<section class="page-head">
    <div class="container page-head-row">
        <div>
            <span class="badge">
                <i class="fa-solid fa-sliders"></i>
                Back Office
            </span>
            <h1>Paramètres</h1>
        </div>

        <div class="actions">
            <a class="btn btn-primary" href="<?= site_url('parametres/create') ?>">
                <i class="fa-solid fa-plus"></i>
                Nouveau paramètre
            </a>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <article class="card pad">
            <h3>Liste des paramètres</h3>

            <?php if (empty($parametres ?? [])): ?>
                <p>Aucun paramètre enregistré.</p>
            <?php else: ?>
                <div class="admin-table-wrap">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Clé</th>
                                <th>Valeur</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach (($parametres ?? []) as $parametre): ?>
                                <tr>
                                    <td><?= esc((string) ($parametre['id'] ?? '-')) ?></td>
                                    <td><strong><?= esc($parametre['cle'] ?? '-') ?></strong></td>
                                    <td><?= esc($parametre['valeur'] ?? '-') ?></td>
                                    <td><?= esc($parametre['description'] ?? '-') ?></td>
                                    <td>
                                        <div class="actions">
                                            <a class="btn btn-light" href="<?= site_url('parametres/edit/' . ($parametre['id'] ?? 0)) ?>">
                                                <i class="fa-solid fa-pen"></i>
                                                Modifier
                                            </a>

                                            <form method="post" action="<?= site_url('parametres/delete/' . ($parametre['id'] ?? 0)) ?>">
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