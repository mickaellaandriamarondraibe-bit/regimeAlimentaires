<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<section class="page-head">
    <div class="container page-head-row">
        <div>
            <span class="badge">
                <i class="fa-solid fa-money-bill-transfer"></i>
                Back Office
            </span>
            <h1>Transactions et demandes de codes</h1>
        </div>

        <div class="actions">
            <a class="btn btn-light" href="<?= site_url('dashboard') ?>">
                <i class="fa-solid fa-arrow-left"></i>
                Dashboard
            </a>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">

        <article class="card pad" style="margin-bottom:22px;">
            <h3>Demandes de codes</h3>

            <?php if (empty($demandes_codes ?? [])): ?>

                <p>Aucune demande de code enregistrée.</p>

            <?php else: ?>

                <div class="admin-table-wrap">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Client</th>
                                <th>Code</th>
                                <th>Statut</th>
                                <th>Validé par</th>
                                <th>Date validation</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach (($demandes_codes ?? []) as $demande): ?>
                                <tr>
                                    <td><?= esc((string) ($demande['id'] ?? '-')) ?></td>
                                    <td><?= esc($demande['client_name'] ?? '-') ?></td>
                                    <td><?= esc($demande['code'] ?? '-') ?></td>

                                    <td>
                                        <?php if (($demande['statut'] ?? '') === 'en_attente'): ?>
                                            <span class="status-pill status-pending">En attente</span>
                                        <?php elseif (($demande['statut'] ?? '') === 'valide'): ?>
                                            <span class="status-pill status-valid">Validé</span>
                                        <?php else: ?>
                                            <span class="status-pill status-refused">Refusé</span>
                                        <?php endif; ?>
                                    </td>

                                    <td><?= esc($demande['validated_by_email'] ?? '-') ?></td>
                                    <td><?= esc($demande['validated_at'] ?? '-') ?></td>

                                    <td>
                                        <?php if (($demande['statut'] ?? '') === 'en_attente'): ?>
                                            <div class="actions">
                                                <form method="post" action="<?= site_url('admin/demandes-code/valider/' . ($demande['id'] ?? 0)) ?>">
                                                    <?= csrf_field() ?>
                                                    <button class="btn btn-green" type="submit">
                                                        Valider
                                                    </button>
                                                </form>

                                                <form method="post" action="<?= site_url('admin/demandes-code/refuser/' . ($demande['id'] ?? 0)) ?>">
                                                    <?= csrf_field() ?>
                                                    <button class="btn btn-light" type="submit">
                                                        Refuser
                                                    </button>
                                                </form>
                                            </div>
                                        <?php else: ?>
                                            <span style="color:var(--muted);font-weight:800;">Traité</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

            <?php endif; ?>
        </article>

        <article class="card pad" style="margin-bottom:22px;">
            <h3>Achats de programmes</h3>

            <?php if (empty($achats_programmes ?? [])): ?>

                <p>Aucun achat de programme enregistré.</p>

            <?php else: ?>

                <div class="admin-table-wrap">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Date</th>
                                <th>Client</th>
                                <th>Régime</th>
                                <th>Prix total</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach (($achats_programmes ?? []) as $achat): ?>
                                <tr>
                                    <td><?= esc((string) ($achat['id'] ?? '-')) ?></td>
                                    <td><?= esc($achat['date_programme'] ?? '-') ?></td>
                                    <td><?= esc($achat['client_name'] ?? '-') ?></td>
                                    <td><?= esc($achat['regime_name'] ?? '-') ?></td>
                                    <td>
                                        <?= esc(number_format((float) ($achat['prix_total'] ?? 0), 0, ',', ' ')) ?>
                                        Ar
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

            <?php endif; ?>
        </article>

        <article class="card pad">
            <h3>Historique des transactions</h3>

            <?php if (empty($latest_transactions ?? [])): ?>

                <p>Aucune transaction enregistrée.</p>

            <?php else: ?>

                <div class="admin-table-wrap">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Type</th>
                                <th>Client</th>
                                <th>Email</th>
                                <th>Montant</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach (($latest_transactions ?? []) as $transaction): ?>
                                <tr>
                                    <td><?= esc($transaction['date'] ?? '-') ?></td>

                                    <td>
                                        <?php if (($transaction['type'] ?? '') === 'C'): ?>
                                            <span class="status-pill status-valid">Crédit</span>
                                        <?php else: ?>
                                            <span class="status-pill status-refused">Débit</span>
                                        <?php endif; ?>
                                    </td>

                                    <td><?= esc($transaction['name'] ?? '-') ?></td>
                                    <td><?= esc($transaction['email'] ?? '-') ?></td>

                                    <td>
                                        <?= esc(number_format((float) ($transaction['montant'] ?? 0), 0, ',', ' ')) ?>
                                        Ar
                                    </td>
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