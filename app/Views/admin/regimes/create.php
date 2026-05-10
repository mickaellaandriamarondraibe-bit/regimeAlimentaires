<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<section class="page-head">
    <div class="container page-head-row">
        <div>
            <span class="badge">
                <i class="fa-solid fa-plus"></i>
                Régimes
            </span>
            <h1>Créer un régime</h1>
        </div>

        <div class="actions">
            <a class="btn btn-light" href="<?= site_url('regime/list') ?>">
                <i class="fa-solid fa-arrow-left"></i>
                Liste des régimes
            </a>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <form method="post" action="<?= site_url('regime/create') ?>">
            <?= csrf_field() ?>

            <article class="card pad" style="margin-bottom:22px;">
                <h3>Informations du régime</h3>

                <div class="form-grid">
                    <div class="input-group">
                        <label>Nom du régime</label>
                        <input class="input" type="text" name="regime_name" required>
                    </div>

                    <div class="input-group">
                        <label>Variation poids / semaine</label>
                        <input class="input" type="number" step="0.01" name="variation_poids_semaine" required>
                    </div>
                </div>

                <div class="input-group">
                    <label>Description</label>
                    <textarea class="input" name="description" rows="4"></textarea>
                </div>
            </article>

            <article class="card pad" style="margin-bottom:22px;">
                <h3>Composition du régime</h3>

                <?php if (empty($ingredients ?? [])): ?>
                    <p>Aucun ingrédient disponible.</p>
                <?php else: ?>
                    <div class="form-grid">
                        <?php foreach ($ingredients as $ingredient): ?>
                            <div class="input-group">
                                <label>
                                    <?= esc($ingredient['name'] ?? '-') ?> (%)
                                </label>

                                <input
                                    class="input"
                                    type="number"
                                    step="0.01"
                                    min="0"
                                    max="100"
                                    name="pourcentage_<?= esc($ingredient['name'] ?? '') ?>"
                                    placeholder="0">
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </article>

            <article class="card pad" style="margin-bottom:22px;">
                <h3>Tarifs selon la durée</h3>

                <div id="prixRows">
                    <div class="form-grid prix-row">
                        <div class="input-group">
                            <label>Durée en semaines</label>
                            <input class="input" type="number" name="semaine[]" min="1" required>
                        </div>

                        <div class="input-group">
                            <label>Prix</label>
                            <input class="input" type="number" step="0.01" name="prix[]" min="0" required>
                        </div>
                    </div>
                </div>

                <button class="btn btn-light" type="button" onclick="addPrixRow()">
                    <i class="fa-solid fa-plus"></i>
                    Ajouter un tarif
                </button>
            </article>

            <div class="actions">
                <button class="btn btn-primary" type="submit">
                    <i class="fa-solid fa-floppy-disk"></i>
                    Enregistrer le régime
                </button>

                <a class="btn btn-light" href="<?= site_url('regime/list') ?>">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</section>

<script>
    function addPrixRow() {
        const wrapper = document.getElementById('prixRows');

        const row = document.createElement('div');
        row.className = 'form-grid prix-row';
        row.style.marginTop = '12px';

        row.innerHTML = `
        <div class="input-group">
            <label>Durée en semaines</label>
            <input class="input" type="number" name="semaine[]" min="1" required>
        </div>

        <div class="input-group">
            <label>Prix</label>
            <input class="input" type="number" step="0.01" name="prix[]" min="0" required>
        </div>
    `;

        wrapper.appendChild(row);
    }
</script>

<?= $this->endSection() ?>