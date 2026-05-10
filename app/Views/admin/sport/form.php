<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<?php
$isEdit = !empty($sport);
$action = $isEdit
    ? site_url('sport/update/' . ($sport['id'] ?? 0))
    : site_url('sport/create');
?>

<section class="page-head">
    <div class="container page-head-row" data-animate="fade-up">
        <div>
            <span class="badge" data-animate="slide-right" data-delay="80">
                <i class="fa-solid fa-person-running"></i>
                Sport
            </span>
            <h1 data-animate="slide-right" data-delay="160"><?= $isEdit ? 'Modifier une activité sportive' : 'Créer une activité sportive' ?></h1>
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
        <article class="card pad">
            <form method="post" action="<?= $action ?>">
                <?= csrf_field() ?>

                <div class="form-grid">
                    <div class="input-group">
                        <label>Nom du sport</label>
                        <input
                            class="input"
                            type="text"
                            name="sport_name"
                            value="<?= esc($sport['name'] ?? '') ?>"
                            required
                        >
                    </div>

                    <div class="input-group">
                        <label>Variation poids / semaine</label>
                        <input
                            class="input"
                            type="number"
                            step="0.01"
                            name="variation_poids_semaine"
                            value="<?= esc($sport['variation_poids_semaine'] ?? '') ?>"
                            required
                        >
                    </div>
                </div>

                <div class="input-group">
                    <label>Description</label>
                    <textarea class="input" name="description" rows="5"><?= esc($sport['description'] ?? '') ?></textarea>
                </div>

                <div class="actions">
                    <button class="btn btn-primary" type="submit">
                        <i class="fa-solid fa-floppy-disk"></i>
                        <?= $isEdit ? 'Modifier' : 'Enregistrer' ?>
                    </button>

                    <a class="btn btn-light" href="<?= site_url('sport') ?>">
                        Annuler
                    </a>
                </div>
            </form>
        </article>
    </div>
</section>

<?= $this->endSection() ?>