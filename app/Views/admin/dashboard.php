<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<section class="page-head">
    <div class="container page-head-row" data-animate="fade-up">
        <div>
            <span class="badge" data-animate="slide-right" data-delay="80">
                <i class="fa-solid fa-shield-halved"></i>
                Administration
            </span>

            <h1 data-animate="slide-right" data-delay="160">Dashboard Admin</h1>
        </div>

        <div class="actions">
            <a class="btn btn-primary" href="<?= site_url('regime/create') ?>">
                <i class="fa-solid fa-plus"></i>
                Nouveau régime
            </a>

            <a class="btn btn-light" href="<?= site_url('ingredient') ?>">
                <i class="fa-solid fa-carrot"></i>
                Ingrédients
            </a>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">

        <!-- STATISTIQUES -->
        <article class="card pad">

            <h3 style="margin-bottom:18px;">Vue globale</h3>

            <div class="metric-grid">

                <div class="metric">
                    <strong><?= esc((string) ($stats['users'] ?? 0)) ?></strong>
                    <span>Utilisateurs</span>
                </div>

                <div class="metric">
                    <strong><?= esc((string) ($stats['regimes'] ?? 0)) ?></strong>
                    <span>Régimes</span>
                </div>

                <div class="metric">
                    <strong><?= esc((string) ($stats['ingredients'] ?? 0)) ?></strong>
                    <span>Ingrédients</span>
                </div>

                <div class="metric">
                    <strong>
                        <?= esc(number_format((float) ($stats['montant_total'] ?? 0), 0, ',', ' ')) ?>
                        Ar
                    </strong>

                    <span>Transactions totales</span>
                </div>

            </div>

        </article>

        <!-- GRAPHES -->
        <article class="card pad" style="margin-top:22px;">

            <h3 style="margin-bottom:18px;">Graphiques</h3>

            <div class="form-grid">

                <div>
                    <h4 style="margin-bottom:12px;color:var(--purple);">
                        Transactions Crédit / Débit
                    </h4>

                    <canvas id="txTypeChart" height="170"></canvas>
                </div>

                <div>
                    <h4 style="margin-bottom:12px;color:var(--purple);">
                        Répartition des utilisateurs
                    </h4>

                    <canvas id="usersRoleChart" height="170"></canvas>
                </div>

            </div>

        </article>

        <!-- DEMANDES DE CODES -->
        <article class="card pad" style="margin-top:22px;">

            <div class="page-head-row" style="margin-bottom:18px;">
                <div>
                    <h3>Demandes de codes</h3>
                    <p style="color:var(--muted);margin-top:6px;">
                        Gestion des validations et refus des demandes.
                    </p>
                </div>
            </div>

            <?php
                $demandesEnAttente = array_filter(
                    $demandes_codes ?? [],
                    static function ($demande) {
                        return ($demande['statut'] ?? '') === 'en_attente';
                    }
                );
            ?>

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

                                    <td>
                                        <?= esc((string) ($demande['id'] ?? '-')) ?>
                                    </td>

                                    <td>
                                        <?= esc($demande['client_name'] ?? '-') ?>
                                    </td>

                                    <td>
                                        <?= esc($demande['code'] ?? '-') ?>
                                    </td>

                                    <td>

                                        <?php
                                            $statut = $demande['statut'] ?? '';
                                        ?>

                                        <?php if ($statut === 'en_attente'): ?>

                                            <span class="status-pill status-pending">
                                                En attente
                                            </span>

                                        <?php elseif ($statut === 'valide'): ?>

                                            <span class="status-pill status-valid">
                                                Validé
                                            </span>

                                        <?php else: ?>

                                            <span class="status-pill status-refused">
                                                Refusé
                                            </span>

                                        <?php endif; ?>

                                    </td>

                                    <td>
                                        <?= esc($demande['admin_name'] ?? '-') ?>
                                    </td>

                                    <td>
                                        <?= esc($demande['date_validation'] ?? '-') ?>
                                    </td>

                                    <td>

                                        <?php if (($demande['statut'] ?? '') === 'en_attente'): ?>

                                            <div class="actions">

                                                <form
                                                    method="post"
                                                    action="<?= site_url('admin/demandes-code/valider/' . $demande['id']) ?>"
                                                >
                                                    <?= csrf_field() ?>

                                                    <button class="btn btn-green" type="submit">
                                                        Valider
                                                    </button>
                                                </form>

                                                <form
                                                    method="post"
                                                    action="<?= site_url('admin/demandes-code/refuser/' . $demande['id']) ?>"
                                                >
                                                    <?= csrf_field() ?>

                                                    <button class="btn btn-light" type="submit">
                                                        Refuser
                                                    </button>
                                                </form>

                                            </div>

                                        <?php else: ?>

                                            <span style="color:var(--muted);font-weight:700;">
                                                Traité
                                            </span>

                                        <?php endif; ?>

                                    </td>

                                </tr>

                            <?php endforeach; ?>

                        </tbody>

                    </table>

                </div>

            <?php endif; ?>

        </article>

        <!-- DERNIERS UTILISATEURS -->
        <article class="card pad" style="margin-top:22px;">

            <h3 style="margin-bottom:18px;">Derniers utilisateurs</h3>

            <div class="admin-table-wrap">

                <table class="admin-table">

                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Rôle</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php foreach (($latest_users ?? []) as $user): ?>

                            <tr>

                                <td>
                                    <?= esc((string) ($user['id'] ?? '-')) ?>
                                </td>

                                <td>
                                    <?= esc($user['name'] ?? '-') ?>
                                </td>

                                <td>
                                    <?= esc($user['email'] ?? '-') ?>
                                </td>

                                <td>
                                    <?= esc($user['role'] ?? '-') ?>
                                </td>

                            </tr>

                        <?php endforeach; ?>

                    </tbody>

                </table>

            </div>

        </article>

        <!-- DERNIERS REGIMES -->
        <article class="card pad" style="margin-top:22px;">

            <h3 style="margin-bottom:18px;">Derniers régimes</h3>

            <div class="admin-table-wrap">

                <table class="admin-table">

                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Variation / semaine</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php foreach (($latest_regimes ?? []) as $regime): ?>

                            <tr>

                                <td>
                                    <?= esc((string) ($regime['id'] ?? '-')) ?>
                                </td>

                                <td>
                                    <?= esc($regime['name'] ?? '-') ?>
                                </td>

                                <td>
                                    <?= esc((string) ($regime['variation_poids_semaine'] ?? '-')) ?>
                                    kg
                                </td>

                            </tr>

                        <?php endforeach; ?>

                    </tbody>

                </table>

            </div>

        </article>

        <!-- DERNIERES TRANSACTIONS -->
        <article class="card pad" style="margin-top:22px;">

            <h3 style="margin-bottom:18px;">Dernières transactions</h3>

            <div class="admin-table-wrap">

                <table class="admin-table">

                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Type</th>
                            <th>Client</th>
                            <th>Montant</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php foreach (($latest_transactions ?? []) as $transaction): ?>

                            <tr>

                                <td>
                                    <?= esc($transaction['date'] ?? '-') ?>
                                </td>

                                <td>

                                    <?php if (($transaction['type'] ?? '') === 'C'): ?>

                                        <span class="status-pill status-valid">
                                            Crédit
                                        </span>

                                    <?php else: ?>

                                        <span class="status-pill status-refused">
                                            Débit
                                        </span>

                                    <?php endif; ?>

                                </td>

                                <td>
                                    <?= esc($transaction['name'] ?? '-') ?>
                                </td>

                                <td>
                                    <?= esc(number_format((float) ($transaction['montant'] ?? 0), 0, ',', ' ')) ?>
                                    Ar
                                </td>

                            </tr>

                        <?php endforeach; ?>

                    </tbody>

                </table>

            </div>

        </article>

    </div>
</section>

<?= $this->endSection() ?>