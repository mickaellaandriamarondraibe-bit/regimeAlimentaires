<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<section class="page-head">
    <div class="container page-head-row">

        <div>
            <span class="badge">
                <i class="fa-solid fa-bullseye"></i>
                Objectifs
            </span>

            <h1>Gestion des objectifs</h1>
        </div>

        <div class="actions">

            <a class="btn btn-primary" href="<?= site_url('objectifs/create') ?>">
                <i class="fa-solid fa-plus"></i>
                Nouvel objectif
            </a>

        </div>

    </div>
</section>

<section class="section">
    <div class="container">

        <article class="card pad">

            <h3>Liste des objectifs</h3>

            <?php if (empty($objectifs ?? [])): ?>

                <p style="margin-top:12px;color:var(--muted);">
                    Aucun objectif enregistré.
                </p>

            <?php else: ?>

                <div class="admin-table-wrap">

                    <table class="admin-table">

                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nom</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php foreach (($objectifs ?? []) as $objectif): ?>

                                <tr>

                                    <td>
                                        <?= esc((string) ($objectif['id'] ?? '-')) ?>
                                    </td>

                                    <td>
                                        <strong>
                                            <?= esc($objectif['name'] ?? '-') ?>
                                        </strong>
                                    </td>

                                    <td>

                                        <div class="actions">

                                            <a
                                                class="btn btn-light"
                                                href="<?= site_url('objectifs/edit/' . ($objectif['id'] ?? 0)) ?>">

                                                <i class="fa-solid fa-pen"></i>

                                                Modifier

                                            </a>

                                            <form
                                                method="post"
                                                action="<?= site_url('objectifs/delete/' . ($objectif['id'] ?? 0)) ?>">

                                                <?= csrf_field() ?>

                                                <button
                                                    class="btn btn-light"
                                                    type="submit"
                                                    onclick="return confirm('Supprimer cet objectif ?')">

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