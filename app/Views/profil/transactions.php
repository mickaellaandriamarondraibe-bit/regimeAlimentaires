<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<section class="page-head">
    <div class="container page-head-row" data-animate="fade-up">

        <div>
            <span class="badge" data-animate="slide-right" data-delay="80">
                <i class="fa-solid fa-wallet"></i>
                Wallet
            </span>

            <h1 data-animate="slide-right" data-delay="160">Mes transactions</h1>
        </div>

        <div class="actions">

            <a class="btn btn-light" href="<?= site_url('profil') ?>">
                <i class="fa-solid fa-user"></i>
                Retour profil
            </a>

            <a class="btn btn-primary" href="<?= site_url('programme/catalogue') ?>">
                <i class="fa-solid fa-cart-shopping"></i>
                Voir catalogue
            </a>

        </div>

    </div>
</section>

<section class="section">
    <div class="container">

        <article class="card pad" style="margin-bottom:22px;">

            <h3>Résumé financier</h3>

            <?php
                $solde = (float) ($client['wallet'] ?? 0);

                $totalCredit = 0;
                $totalDebit = 0;

                foreach (($transactions ?? []) as $transaction) {

                    if (($transaction['type'] ?? '') === 'C') {
                        $totalCredit += (float) ($transaction['montant'] ?? 0);
                    } else {
                        $totalDebit += (float) ($transaction['montant'] ?? 0);
                    }
                }
            ?>

            <div class="metric-grid">

                <div class="metric">
                    <strong>
                        <?= esc(number_format($solde, 0, ',', ' ')) ?>
                        Ar
                    </strong>

                    <span>Solde actuel</span>
                </div>

                <div class="metric">
                    <strong>
                        <?= esc(number_format($totalCredit, 0, ',', ' ')) ?>
                        Ar
                    </strong>

                    <span>Total crédits</span>
                </div>

                <div class="metric">
                    <strong>
                        <?= esc(number_format($totalDebit, 0, ',', ' ')) ?>
                        Ar
                    </strong>

                    <span>Total débits</span>
                </div>

                <div class="metric">
                    <strong>
                        <?= esc((string) count($transactions ?? [])) ?>
                    </strong>

                    <span>Transactions</span>
                </div>

            </div>

        </article>

        <article class="card pad">

            <div class="page-head-row" style="margin-bottom:18px;">

                <div>
                    <h3>Historique des transactions</h3>

                    <p style="margin-top:6px;color:var(--muted);">
                        Historique complet des crédits et débits du compte.
                    </p>
                </div>

            </div>

            <?php if (empty($transactions ?? [])): ?>

                <p>Aucune transaction enregistrée.</p>

            <?php else: ?>

                <div class="admin-table-wrap">

                    <table class="admin-table">

                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Type</th>
                                <th>Montant</th>
                                <th>Description</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php foreach (($transactions ?? []) as $transaction): ?>

                                <?php
                                    $isCredit = ($transaction['type'] ?? '') === 'C';
                                ?>

                                <tr>

                                    <td>
                                        <?= esc($transaction['date'] ?? '-') ?>
                                    </td>

                                    <td>

                                        <?php if ($isCredit): ?>

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

                                        <strong>
                                            <?= $isCredit ? '+' : '-' ?>

                                            <?= esc(number_format(
                                                (float) ($transaction['montant'] ?? 0),
                                                0,
                                                ',',
                                                ' '
                                            )) ?>

                                            Ar
                                        </strong>

                                    </td>

                                    <td>

                                        <?php if ($isCredit): ?>

                                            Crédit du wallet

                                        <?php else: ?>

                                            Achat programme / dépense

                                        <?php endif; ?>

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