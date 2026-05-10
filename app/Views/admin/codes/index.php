<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<section class="page-head">
    <div class="container page-head-row" data-animate="fade-up">
        <div>
            <span class="badge" data-animate="slide-right" data-delay="80">
                <i class="fa-solid fa-ticket"></i>
                Codes
            </span>
            <h1 data-animate="slide-right" data-delay="160">Gestion des codes de recharge</h1>
        </div>

        <div class="actions">

            <a class="btn btn-light" href="<?= site_url('admin/transactions') ?>">
                <i class="fa-solid fa-clock"></i>
                Demandes de validation
            </a>

            <a class="btn btn-primary" href="<?= site_url('codes/create') ?>">
                <i class="fa-solid fa-plus"></i>
                Nouveau code
            </a>

        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <article class="card pad">
            <h3>Liste des codes</h3>

            <?php if (empty($codes ?? [])): ?>
                <p style="margin-top:12px;color:var(--muted);">
                    Aucun code enregistré.
                </p>
            <?php else: ?>

                <div class="admin-table-wrap">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Code</th>
                                <th>Montant</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach (($codes ?? []) as $code): ?>
                                <tr>
                                    <td><?= esc((string) ($code['id'] ?? '-')) ?></td>

                                    <td>
                                        <strong><?= esc($code['code'] ?? '-') ?></strong>
                                    </td>

                                    <td>
                                        <?= esc(number_format((float) ($code['montant'] ?? 0), 0, ',', ' ')) ?>
                                        Ar
                                    </td>

                                    <td>
                                        <div class="actions">
                                            <a
                                                class="btn btn-light"
                                                href="<?= site_url('codes/edit/' . ($code['id'] ?? 0)) ?>">
                                                <i class="fa-solid fa-pen"></i>
                                                Modifier
                                            </a>

                                            <form
                                                method="post"
                                                action="<?= site_url('codes/delete/' . ($code['id'] ?? 0)) ?>">
                                                <?= csrf_field() ?>

                                                <button
                                                    class="btn btn-light"
                                                    type="submit"
                                                    onclick="return confirm('Supprimer ce code ?')">
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