<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<section class="page-head">
    <div class="container page-head-row" data-animate="fade-up">
        <div>
            <span class="badge" data-animate="slide-right" data-delay="80"><i class="fa-solid fa-chart-line"></i> Programmes</span>
            <h1 data-animate="slide-right" data-delay="160">Suggestions selon votre objectif</h1>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <article class="card pad" style="margin-bottom:18px;">
            <h3>Choisir un objectif</h3>

            <p>
                Votre IMC actuel :
                <strong><?= esc((string) ($imc ?? '-')) ?></strong>
            </p>

            <form method="post" action="<?= site_url('programme/suggestion') ?>">
                <?= csrf_field() ?>

                <div class="form-grid">
                    <div class="input-group">
                        <label>Objectif</label>
                        <select class="select" name="objectif_id" required>
                            <option value="">Choisir</option>
                            <?php foreach (($objectifs ?? []) as $objectif): ?>
                                <option value="<?= esc((string) $objectif['id']) ?>"
                                    <?= ((int) ($objectif_selectionne ?? 0) === (int) $objectif['id']) ? 'selected' : '' ?>>
                                    <?= esc($objectif['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="input-group">
                        <label>Objectif en kg</label>
                        <input class="input" type="number" step="0.01" min="0.1" name="objectif_kg"
                               value="<?= esc((string) ($objectif_kg_saisi ?? '')) ?>">
                    </div>
                </div>

                <button class="btn btn-primary" type="submit">
                    Afficher les régimes correspondants
                </button>
            </form>
        </article>

        <article class="card pad">
            <h3>Régimes suggérés</h3>

            <?php if (empty($suggestions ?? [])): ?>
                <p>Aucune suggestion pour le moment.</p>
            <?php else: ?>
                <div class="programs-grid">
                    <?php foreach ($suggestions as $s): ?>
                        <article class="card pad">
                            <h3><?= esc($s['regime']['name'] ?? '-') ?></h3>

                            <p><strong>Sport :</strong> <?= esc($s['sport']['name'] ?? '-') ?></p>
                            <p><strong>Durée :</strong> <?= esc((string) ($s['duree_facturee'] ?? '-')) ?> semaine(s)</p>
                            <p><strong>Variation / semaine :</strong> <?= esc((string) ($s['variation_totale'] ?? '-')) ?> kg</p>
                            <p><strong>Prix :</strong> <?= esc(number_format((float) ($s['prix_final'] ?? 0), 0, ',', ' ')) ?> Ar</p>

                            <form method="post" action="<?= site_url('programme/confirmer') ?>">
                                <?= csrf_field() ?>
                                <input type="hidden" name="objectif_id" value="<?= esc((string) ($objectif_selectionne ?? 0)) ?>">
                                <input type="hidden" name="objectif_kg" value="<?= esc((string) ($objectif_kg_saisi ?? 1)) ?>">
                                <input type="hidden" name="regime_id" value="<?= esc((string) ($s['regime']['id'] ?? 0)) ?>">
                                <input type="hidden" name="sport_id" value="<?= esc((string) ($s['sport']['id'] ?? 0)) ?>">

                                <button class="btn btn-primary full" type="submit">
                                    Choisir ce programme
                                </button>
                            </form>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </article>
    </div>
</section>

<?= $this->endSection() ?>