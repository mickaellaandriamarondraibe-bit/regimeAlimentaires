<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<?php
$isEdit = !empty($objectif);

$action = $isEdit
    ? site_url('objectifs/update/' . ($objectif['id'] ?? 0))
    : site_url('objectifs/store');
?>

<section class="page-head">

    <div class="container page-head-row">

        <div>

            <span class="badge">
                <i class="fa-solid fa-bullseye"></i>
                Objectifs
            </span>

            <h1>
                <?= $isEdit ? 'Modifier un objectif' : 'Créer un objectif' ?>
            </h1>

        </div>

        <div class="actions">

            <a class="btn btn-light" href="<?= site_url('objectifs') ?>">

                <i class="fa-solid fa-arrow-left"></i>

                Retour

            </a>

        </div>

    </div>

</section>

<section class="section">

    <div class="container">

        <article class="card pad">

            <form method="post" action="<?= $action ?>">

                <?= csrf_field() ?>

                <div class="input-group">

                    <label>Nom de l’objectif</label>

                    <input
                        class="input"
                        type="text"
                        name="name"
                        required
                        placeholder="Ex : Perte de poids"
                        value="<?= esc(old('name', $objectif['name'] ?? '')) ?>"
                    >

                </div>

                <div class="actions" style="margin-top:22px;">

                    <button class="btn btn-primary" type="submit">

                        <i class="fa-solid fa-floppy-disk"></i>

                        <?= $isEdit ? 'Modifier' : 'Enregistrer' ?>

                    </button>

                    <a class="btn btn-light" href="<?= site_url('objectifs') ?>">

                        Annuler

                    </a>

                </div>

            </form>

        </article>

    </div>

</section>

<?= $this->endSection() ?>