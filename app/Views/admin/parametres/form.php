<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<?php
$isEdit = !empty($parametre);
$action = $isEdit
    ? site_url('parametres/update/' . ($parametre['id'] ?? 0))
    : site_url('parametres/store');
?>

<section class="page-head">
    <div class="container page-head-row" data-animate="fade-up">
        <div>
            <span class="badge" data-animate="slide-right" data-delay="80">
                <i class="fa-solid fa-sliders"></i>
                Paramètres
            </span>
            <h1 data-animate="slide-right" data-delay="160"><?= $isEdit ? 'Modifier un paramètre' : 'Créer un paramètre' ?></h1>
        </div>

        <div class="actions">
            <a class="btn btn-light" href="<?= site_url('parametres') ?>">
                <i class="fa-solid fa-arrow-left"></i>
                Liste des paramètres
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
                        <label>Clé</label>
                        <input
                            class="input"
                            type="text"
                            name="cle"
                            value="<?= esc($parametre['cle'] ?? '') ?>"
                            placeholder="Ex : prix_gold"
                            required
                        >
                    </div>

                    <div class="input-group">
                        <label>Valeur</label>
                        <input
                            class="input"
                            type="text"
                            name="valeur"
                            value="<?= esc($parametre['valeur'] ?? '') ?>"
                            placeholder="Ex : 50000"
                            required
                        >
                    </div>
                </div>

                <div class="input-group">
                    <label>Description</label>
                    <textarea
                        class="input"
                        name="description"
                        rows="5"
                        placeholder="Description du paramètre"
                    ><?= esc($parametre['description'] ?? '') ?></textarea>
                </div>

                <div class="actions">
                    <button class="btn btn-primary" type="submit">
                        <i class="fa-solid fa-floppy-disk"></i>
                        <?= $isEdit ? 'Modifier' : 'Enregistrer' ?>
                    </button>

                    <a class="btn btn-light" href="<?= site_url('parametres') ?>">
                        Annuler
                    </a>
                </div>
            </form>
        </article>
    </div>
</section>

<?= $this->endSection() ?>