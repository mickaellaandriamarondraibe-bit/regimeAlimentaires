<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<section class="page-head">
    <div class="container page-head-row" data-animate="fade-up">
        <div>
            <span class="badge" data-animate="slide-right" data-delay="80">
                <i class="fa-solid fa-person-running"></i>
                Sport
            </span>
            <h1 data-animate="slide-right" data-delay="160"><?= esc($sport['name'] ?? 'Détail sport') ?></h1>
        </div>

        <div class="actions">
            <a class="btn btn-light" href="<?= site_url('sport') ?>">
                <i class="fa-solid fa-arrow-left"></i>
                Liste
            </a>

            <a class="btn btn-primary" href="<?= site_url('sport/edit/' . ($sport['id'] ?? 0)) ?>">
                <i class="fa-solid fa-pen"></i>
                Modifier
            </a>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <article class="card pad">
            <h3>Informations du sport</h3>

            <div class="admin-table-wrap">
                <table class="admin-table">
                    <tbody>
                        <tr>
                            <th>ID</th>
                            <td><?= esc((string) ($sport['id'] ?? '-')) ?></td>
                        </tr>

                        <tr>
                            <th>Nom</th>
                            <td><?= esc($sport['name'] ?? '-') ?></td>
                        </tr>

                        <tr>
                            <th>Description</th>
                            <td><?= esc($sport['description'] ?? '-') ?></td>
                        </tr>

                        <tr>
                            <th>Variation / semaine</th>
                            <td>
                                <?= esc((string) ($sport['variation_poids_semaine'] ?? 0)) ?> kg
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </article>
    </div>
</section>

<?= $this->endSection() ?>