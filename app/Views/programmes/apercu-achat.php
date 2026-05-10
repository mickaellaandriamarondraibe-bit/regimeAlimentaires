<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<section class="page-head">
    <div class="container page-head-row" data-animate="fade-up">
        <div>
            <span class="badge" data-animate="slide-right" data-delay="80">
                <i class="fa-solid fa-eye"></i>
                Aperçu
            </span>
            <h1 data-animate="slide-right" data-delay="160">Confirmez votre programme</h1>
        </div>
        <div class="actions">
            <a class="btn btn-light" href="<?= $source === 'catalogue' ? site_url('programme/catalogue') : site_url('programme') ?>">
                <i class="fa-solid fa-arrow-left"></i>
                Retour
            </a>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="grid" style="grid-template-columns: 1fr 1fr; gap: 32px;">
            <!-- Colonne gauche : Détails du programme -->
            <div>
                <!-- Régime et Sport -->
                <article class="card" data-animate="fade-up">
                    <div class="pad">
                        <h3 style="margin-bottom: 20px;">Programme</h3>
                        
                        <div style="margin-bottom: 20px;">
                            <p style="color: var(--muted); margin-bottom: 4px; font-size: 0.875rem;">Régime</p>
                            <strong style="font-size: 1.125rem;"><?= esc($regime['name'] ?? '-') ?></strong>
                        </div>

                        <div style="margin-bottom: 20px;">
                            <p style="color: var(--muted); margin-bottom: 4px; font-size: 0.875rem;">Sport</p>
                            <strong style="font-size: 1.125rem;"><?= esc($sport['name'] ?? '-') ?></strong>
                        </div>

                        <div>
                            <p style="color: var(--muted); margin-bottom: 4px; font-size: 0.875rem;">Objectif</p>
                            <strong style="font-size: 1.125rem;"><?= esc($objectif['name'] ?? '-') ?></strong>
                        </div>
                    </div>
                </article>

                <!-- Durée et Variation -->
                <article class="card" data-animate="fade-up" style="margin-top: 16px;">
                    <div class="pad">
                        <h3 style="margin-bottom: 20px;">Détails</h3>

                        <div class="admin-table-wrap">
                            <table class="admin-table">
                                <tbody>
                                    <tr>
                                        <th>Durée du programme</th>
                                        <td><?= $duree_facturee ?> semaine<?= $duree_facturee > 1 ? 's' : '' ?></td>
                                    </tr>
                                    <tr>
                                        <th>Variation / semaine</th>
                                        <td><?= number_format($variation_totale, 2, ',', ' ') ?> kg</td>
                                    </tr>
                                    <tr>
                                        <th>Objectif en kg</th>
                                        <td><?= number_format($objectif_kg, 2, ',', ' ') ?> kg</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </article>

                <!-- Évolution -->
                <article class="card" data-animate="fade-up" style="margin-top: 16px;">
                    <div class="pad">
                        <h3 style="margin-bottom: 20px;">Votre évolution</h3>

                        <div class="admin-table-wrap">
                            <table class="admin-table">
                                <tbody>
                                    <tr>
                                        <th>Poids actuel</th>
                                        <td><?= number_format($poids_initial, 2, ',', ' ') ?> kg</td>
                                    </tr>
                                    <tr>
                                        <th>Poids cible</th>
                                        <td><?= number_format($poids_cible, 2, ',', ' ') ?> kg</td>
                                    </tr>
                                    <tr>
                                        <th>IMC actuel</th>
                                        <td><?= number_format($imc_initial, 2, ',', ' ') ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </article>
            </div>

            <!-- Colonne droite : Tarification -->
            <div>
                <!-- Prix -->
                <article class="card" data-animate="fade-up">
                    <div class="pad">
                        <h3 style="margin-bottom: 20px;">Tarification</h3>

                        <div class="admin-table-wrap" style="margin-bottom: 20px;">
                            <table class="admin-table">
                                <tbody>
                                    <tr>
                                        <th>Prix base</th>
                                        <td><?= number_format($prix_base, 0, ',', ' ') ?> Ar</td>
                                    </tr>
                                    <?php if ($prix_final < $prix_base): ?>
                                        <tr>
                                            <th>Réduction Gold</th>
                                            <td style="color: var(--success);">-<?= number_format($prix_base - $prix_final, 0, ',', ' ') ?> Ar</td>
                                        </tr>
                                    <?php endif; ?>
                                    <tr style="background-color: var(--light); font-weight: bold;">
                                        <th>Prix final</th>
                                        <td><?= number_format($prix_final, 0, ',', ' ') ?> Ar</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </article>

                <!-- Solde -->
                <article class="card" data-animate="fade-up" style="margin-top: 16px; <?= $solde_insuffisant ? 'border: 2px solid var(--danger);' : '' ?>">
                    <div class="pad">
                        <h3 style="margin-bottom: 20px;">Votre portefeuille</h3>

                        <div class="admin-table-wrap">
                            <table class="admin-table">
                                <tbody>
                                    <tr>
                                        <th>Solde disponible</th>
                                        <td style="<?= $solde_insuffisant ? 'color: var(--danger);' : 'color: var(--success);' ?> font-weight: bold;">
                                            <?= number_format($solde_actuel, 0, ',', ' ') ?> Ar
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Coût du programme</th>
                                        <td><?= number_format($prix_final, 0, ',', ' ') ?> Ar</td>
                                    </tr>
                                    <tr style="background-color: var(--light);">
                                        <th>Après achat</th>
                                        <td style="<?= $solde_insuffisant ? 'color: var(--danger);' : 'color: var(--success);' ?> font-weight: bold;">
                                            <?= number_format($solde_actuel - $prix_final, 0, ',', ' ') ?> Ar
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <?php if ($solde_insuffisant): ?>
                            <div class="alert alert-danger" style="margin-top: 16px;">
                                <strong>⚠ Solde insuffisant</strong>
                                <p style="margin: 8px 0 0 0;">Il vous manque <?= number_format($prix_final - $solde_actuel, 0, ',', ' ') ?> Ar</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </article>

                <!-- Actions -->
                <div class="actions" style="margin-top: 24px; flex-direction: column; gap: 10px;">
                    <?php if (!$solde_insuffisant): ?>
                        <form method="post" action="<?= site_url('programme/acheter') ?>" style="width: 100%;">
                            <?= csrf_field() ?>
                            <input type="hidden" name="objectif_id" value="<?= $objectif_id ?>">
                            <input type="hidden" name="regime_id" value="<?= $regime_id ?>">
                            <input type="hidden" name="sport_id" value="<?= $sport_id ?>">
                            <input type="hidden" name="objectif_kg" value="<?= $objectif_kg ?>">
                            <input type="hidden" name="prix_final" value="<?= $prix_final ?>">
                            <input type="hidden" name="duree_facturee" value="<?= $duree_facturee ?>">
                            <input type="hidden" name="poids_initial" value="<?= $poids_initial ?>">
                            <input type="hidden" name="poids_cible" value="<?= $poids_cible ?>">
                            <input type="hidden" name="imc_initial" value="<?= $imc_initial ?>">

                            <button type="submit" class="btn btn-primary full">
                                <i class="fa-solid fa-check"></i>
                                Confirmer l'achat
                            </button>
                        </form>
                    <?php else: ?>
                        <button type="button" class="btn btn-secondary full" disabled>
                            <i class="fa-solid fa-lock"></i>
                            Solde insuffisant
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
