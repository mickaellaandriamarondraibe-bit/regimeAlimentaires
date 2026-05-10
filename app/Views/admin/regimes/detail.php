<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<section class="page-head">
    <div class="container page-head-row" data-animate="fade-up">
        <div>
            <span class="badge" data-animate="slide-right" data-delay="80">
                <i class="fa-solid fa-utensils"></i>
                Régime
            </span>
            <h1 data-animate="slide-right" data-delay="160"><?= esc($regime['name'] ?? 'Détail régime') ?></h1>
        </div>

        <div class="actions">
            <a class="btn btn-light" href="<?= site_url('regime/list') ?>">
                <i class="fa-solid fa-arrow-left"></i>
                Liste des régimes
            </a>

            <a class="btn btn-primary" href="<?= site_url('regime/create') ?>">
                <i class="fa-solid fa-plus"></i>
                Nouveau régime
            </a>
        </div>
    </div>
</section>

<section class="section">
    <div class="container profile-grid">

        <article class="card pad js-edit-section" data-section="general">
            <div class="section-head">
                <h3>Informations générales</h3>
                <div class="section-actions">
                    <button class="btn btn-light js-edit-btn" type="button">Modifier</button>
                    <button class="btn btn-primary js-save-btn" type="submit" form="form-general">Enregistrer</button>
                    <button class="btn btn-light js-cancel-btn" type="button">Annuler</button>
                </div>
            </div>

            <div class="view-only">
                <div class="admin-table-wrap">
                    <table class="admin-table">
                        <tbody>
                            <tr>
                                <th>ID</th>
                                <td><?= esc((string) ($regime['id'] ?? '-')) ?></td>
                            </tr>

                            <tr>
                                <th>Nom</th>
                                <td><?= esc($regime['name'] ?? '-') ?></td>
                            </tr>

                            <tr>
                                <th>Description</th>
                                <td><?= esc($regime['description'] ?? '-') ?></td>
                            </tr>

                            <tr>
                                <th>Variation / semaine</th>
                                <td>
                                    <?php $variation = (float) ($regime['variation_poids_semaine'] ?? 0); ?>

                                    <?php if ($variation > 0): ?>
                                        <span class="status-pill status-valid">
                                            +<?= esc((string) $variation) ?> kg
                                        </span>
                                    <?php else: ?>
                                        <span class="status-pill status-refused">
                                            <?= esc((string) $variation) ?> kg
                                        </span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <form
                id="form-general"
                class="edit-only"
                method="post"
                action="<?= site_url('regime/update/' . ($regime['id'] ?? 0) . '/general') ?>"
            >
                <?= csrf_field() ?>

                <div class="form-grid">
                    <div class="input-group">
                        <label>Nom du régime</label>
                        <input
                            class="input"
                            type="text"
                            name="name"
                            value="<?= esc($regime['name'] ?? '') ?>"
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
                            value="<?= esc((string) ($regime['variation_poids_semaine'] ?? '')) ?>"
                            required
                        >
                    </div>
                </div>

                <div class="input-group">
                    <label>Description</label>
                    <textarea class="input" name="description" rows="4"><?= esc($regime['description'] ?? '') ?></textarea>
                </div>
            </form>
        </article>

        <article class="card pad js-edit-section" data-section="composition">
            <div class="section-head">
                <h3>Composition alimentaire</h3>
                <div class="section-actions">
                    <button class="btn btn-light js-edit-btn" type="button">Modifier</button>
                    <button class="btn btn-primary js-save-btn" type="submit" form="form-composition">Enregistrer</button>
                    <button class="btn btn-light js-cancel-btn" type="button">Annuler</button>
                </div>
            </div>

            <div class="view-only">
                <?php if (empty($regime['compositions'] ?? [])): ?>
                    <p>Aucune composition enregistrée.</p>
                <?php else: ?>
                    <div class="admin-table-wrap">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>Ingrédient</th>
                                    <th>Pourcentage</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php foreach (($regime['compositions'] ?? []) as $composition): ?>
                                    <tr>
                                        <td><?= esc($composition['ingredient_name'] ?? '-') ?></td>
                                        <td>
                                            <strong>
                                                <?= esc((string) ($composition['pourcentage'] ?? 0)) ?>%
                                            </strong>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>

            <form
                id="form-composition"
                class="edit-only"
                method="post"
                action="<?= site_url('regime/update/' . ($regime['id'] ?? 0) . '/composition') ?>"
            >
                <?= csrf_field() ?>

                <?php if (empty($ingredients ?? [])): ?>
                    <p>Aucun ingrédient disponible.</p>
                <?php else: ?>
                    <div class="form-grid">
                        <?php foreach ($ingredients as $ingredient): ?>
                            <?php $ingredientId = (int) ($ingredient['id'] ?? 0); ?>
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
                                    name="pourcentage_<?= esc((string) $ingredientId) ?>"
                                    value="<?= esc((string) ($composition_map[$ingredientId] ?? 0)) ?>"
                                >
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </form>
        </article>

        <article class="card pad js-edit-section" data-section="prix">
            <div class="section-head">
                <h3>Tarifs</h3>
                <div class="section-actions">
                    <button class="btn btn-light js-edit-btn" type="button">Modifier</button>
                    <button class="btn btn-primary js-save-btn" type="submit" form="form-prix">Enregistrer</button>
                    <button class="btn btn-light js-cancel-btn" type="button">Annuler</button>
                </div>
            </div>

            <div class="view-only">
                <?php if (empty($regime['prix'] ?? [])): ?>
                    <p>Aucun tarif enregistré.</p>
                <?php else: ?>
                    <div class="admin-table-wrap">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>Durée</th>
                                    <th>Prix</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php foreach (($regime['prix'] ?? []) as $prix): ?>
                                    <tr>
                                        <td>
                                            <?= esc((string) ($prix['duree_semaine'] ?? '-')) ?>
                                            semaine(s)
                                        </td>

                                        <td>
                                            <strong>
                                                <?= esc(number_format((float) ($prix['prix'] ?? 0), 0, ',', ' ')) ?>
                                                Ar
                                            </strong>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>

            <form
                id="form-prix"
                class="edit-only"
                method="post"
                action="<?= site_url('regime/update/' . ($regime['id'] ?? 0) . '/prix') ?>"
            >
                <?= csrf_field() ?>

                <div id="prixRowsEdit">
                    <?php if (empty($regime['prix'] ?? [])): ?>
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
                    <?php else: ?>
                        <?php foreach (($regime['prix'] ?? []) as $row): ?>
                            <div class="form-grid prix-row" style="margin-top:12px;">
                                <div class="input-group">
                                    <label>Durée en semaines</label>
                                    <input
                                        class="input"
                                        type="number"
                                        name="semaine[]"
                                        min="1"
                                        value="<?= esc((string) ($row['duree_semaine'] ?? '')) ?>"
                                        required
                                    >
                                </div>

                                <div class="input-group">
                                    <label>Prix</label>
                                    <input
                                        class="input"
                                        type="number"
                                        step="0.01"
                                        name="prix[]"
                                        min="0"
                                        value="<?= esc((string) ($row['prix'] ?? '')) ?>"
                                        required
                                    >
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <button class="btn btn-light" type="button" onclick="addPrixRowEdit()">
                    <i class="fa-solid fa-plus"></i>
                    Ajouter un tarif
                </button>
            </form>
        </article>

        <article class="card pad js-edit-section" data-section="sports">
            <div class="section-head">
                <h3>Sports compatibles</h3>
                <div class="section-actions">
                    <button class="btn btn-light js-edit-btn" type="button">Modifier</button>
                    <button class="btn btn-primary js-save-btn" type="submit" form="form-sports">Enregistrer</button>
                    <button class="btn btn-light js-cancel-btn" type="button">Annuler</button>
                </div>
            </div>

            <div class="view-only">
                <?php if (empty($regime['sport_associe'] ?? [])): ?>
                    <p>Aucun sport associé.</p>
                <?php else: ?>
                    <div class="admin-table-wrap">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>Sport</th>
                                    <th>Description</th>
                                    <th>Variation / semaine</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php foreach (($regime['sport_associe'] ?? []) as $sport): ?>
                                    <tr>
                                        <td><?= esc($sport['name'] ?? '-') ?></td>
                                        <td><?= esc($sport['description'] ?? '-') ?></td>
                                        <td>
                                            <?= esc((string) ($sport['variation_poids_semaine'] ?? 0)) ?>
                                            kg
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>

            <form
                id="form-sports"
                class="edit-only"
                method="post"
                action="<?= site_url('regime/update/' . ($regime['id'] ?? 0) . '/sports') ?>"
            >
                <?= csrf_field() ?>

                <?php if (empty($all_sports ?? [])): ?>
                    <p>Aucun sport disponible.</p>
                <?php else: ?>
                    <div class="form-grid">
                        <?php foreach ($all_sports as $sport): ?>
                            <?php $sportId = (int) ($sport['id'] ?? 0); ?>
                            <label class="input-group" style="gap:10px;">
                                <input
                                    type="checkbox"
                                    name="sport_ids[]"
                                    value="<?= esc((string) $sportId) ?>"
                                    <?= in_array($sportId, ($linked_sport_ids ?? []), true) ? 'checked' : '' ?>
                                >
                                <div>
                                    <strong><?= esc($sport['name'] ?? '-') ?></strong>
                                    <div style="color:var(--muted);font-size:.88rem;">
                                        <?= esc($sport['description'] ?? '-') ?>
                                    </div>
                                </div>
                            </label>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </form>
        </article>

    </div>
</section>

<style>
    .section-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 14px;
        flex-wrap: wrap;
    }

    .section-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .edit-only {
        display: none;
    }

    .js-edit-section .js-save-btn,
    .js-edit-section .js-cancel-btn {
        display: none;
    }

    .js-edit-section.is-editing .view-only {
        display: none;
    }

    .js-edit-section.is-editing .edit-only {
        display: block;
    }

    .js-edit-section.is-editing .js-edit-btn {
        display: none;
    }

    .js-edit-section.is-editing .js-save-btn,
    .js-edit-section.is-editing .js-cancel-btn {
        display: inline-flex;
    }
</style>

<script>
    function addPrixRowEdit() {
        const wrapper = document.getElementById('prixRowsEdit');
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

    (function setupSectionEditing() {
        const sections = Array.from(document.querySelectorAll('.js-edit-section'));
        let activeSection = null;

        const toggleLocks = () => {
            sections.forEach((section) => {
                const editBtn = section.querySelector('.js-edit-btn');
                if (!editBtn) {
                    return;
                }

                if (activeSection && section !== activeSection) {
                    editBtn.disabled = true;
                } else {
                    editBtn.disabled = false;
                }
            });
        };

        sections.forEach((section) => {
            const editBtn = section.querySelector('.js-edit-btn');
            const cancelBtn = section.querySelector('.js-cancel-btn');
            const form = section.querySelector('form');

            if (editBtn) {
                editBtn.addEventListener('click', () => {
                    if (activeSection && activeSection !== section) {
                        alert('Veuillez enregistrer ou annuler la section en cours avant de changer.');
                        return;
                    }

                    section.classList.add('is-editing');
                    activeSection = section;
                    toggleLocks();
                });
            }

            if (cancelBtn) {
                cancelBtn.addEventListener('click', () => {
                    if (form) {
                        form.reset();
                    }

                    section.classList.remove('is-editing');
                    activeSection = null;
                    toggleLocks();
                });
            }
        });

        toggleLocks();
    })();
</script>

<?= $this->endSection() ?>