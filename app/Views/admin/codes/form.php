<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<?php
$isEdit = !empty($codeRecharge);

$action = $isEdit
    ? site_url('codes/update/' . ($codeRecharge['id'] ?? 0))
    : site_url('codes/store');
?>

<section class="page-head">
    <div class="container page-head-row" data-animate="fade-up">
        <div>
            <span class="badge" data-animate="slide-right" data-delay="80">
                <i class="fa-solid fa-ticket"></i>
                Codes
            </span>

            <h1 data-animate="slide-right" data-delay="160">
                <?= $isEdit ? 'Modifier un code' : 'Créer un code de recharge' ?>
            </h1>
        </div>

        <div class="actions">
            <a class="btn btn-light" href="<?= site_url('codes') ?>">
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

                <div class="form-grid">
                    <div class="input-group">
                        <label>Code</label>
                        <input
                            class="input"
                            type="text"
                            name="code"
                            required
                            placeholder="Ex : NTF-50000-A1B2"
                            value="<?= esc(old('code', $codeRecharge['code'] ?? '')) ?>"
                        >
                    </div>

                    <div class="input-group">
                        <label>Montant</label>
                        <input
                            class="input"
                            type="number"
                            name="montant"
                            step="0.01"
                            min="0"
                            required
                            placeholder="Ex : 50000"
                            value="<?= esc(old('montant', $codeRecharge['montant'] ?? '')) ?>"
                        >
                    </div>
                </div>

                <div class="actions" style="margin-top:22px;">
                    <button class="btn btn-primary" type="submit">
                        <i class="fa-solid fa-floppy-disk"></i>
                        <?= $isEdit ? 'Modifier' : 'Enregistrer' ?>
                    </button>

                    <a class="btn btn-light" href="<?= site_url('codes') ?>">
                        Annuler
                    </a>
                </div>
            </form>
        </article>
    </div>
</section>

<?= $this->endSection() ?>