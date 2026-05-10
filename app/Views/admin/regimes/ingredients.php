<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<section class="page-head">
    <div class="container page-head-row">
        <div>
            <span class="badge">
                <i class="fa-solid fa-carrot"></i>
                Régimes
            </span>
            <h1>Ingrédients des régimes</h1>
        </div>

        <div class="actions">
            <a class="btn btn-light" href="<?= site_url('dashboard') ?>">
                <i class="fa-solid fa-arrow-left"></i>
                Dashboard
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

        <article class="card pad" style="margin-bottom:22px;">
            <h3>Ajouter un ingrédient</h3>

            <form method="post" action="<?= site_url('ingredient/create') ?>">
                <?= csrf_field() ?>

                <div class="form-grid">
                    <div class="input-group">
                        <label>Nom de l’ingrédient</label>
                        <input
                            class="input"
                            type="text"
                            name="name"
                            placeholder="Ex : Viande, Poisson, Volaille"
                            required
                        >
                    </div>

                    <div class="input-group" style="align-self:end;">
                        <button class="btn btn-primary full" type="submit">
                            <i class="fa-solid fa-plus"></i>
                            Ajouter
                        </button>
                    </div>
                </div>
            </form>
        </article>

        <article class="card pad">
            <div class="page-head-row" style="margin-bottom:18px;">
                <div>
                    <h3>Liste des ingrédients</h3>
                    <p style="color:var(--muted);margin-top:6px;">
                        Ces ingrédients sont utilisés pour composer les régimes avec des pourcentages.
                    </p>
                </div>
            </div>

            <?php if (empty($ingredients ?? [])): ?>

                <p>Aucun ingrédient enregistré.</p>

            <?php else: ?>

                <div class="admin-table-wrap">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nom</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach (($ingredients ?? []) as $ingredient): ?>
                                <tr>
                                    <td><?= esc((string) ($ingredient['id'] ?? '-')) ?></td>
                                    <td><?= esc($ingredient['name'] ?? '-') ?></td>
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