<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<section class="page-head">
    <div class="container page-head-row">
        <div>
            <span class="badge">
                <i class="fa-solid fa-user-check"></i>
                Profil client
            </span>
            <h1>Mon profil</h1>
        </div>

        <div class="actions">
            <a class="btn btn-primary" href="<?= site_url('programme') ?>">
                <i class="fa-solid fa-bullseye"></i>
                Choisir un objectif
            </a>

            <a class="btn btn-light" href="<?= site_url('programme/mes-programmes') ?>">
                <i class="fa-solid fa-list-check"></i>
                Mes programmes
            </a>
        </div>
    </div>
</section>

<section class="section">
    <div class="container profile-grid">

        <article class="card pad">
            <h3>Informations personnelles</h3>

            <form method="post" action="<?= site_url('profil/update') ?>">
                <?= csrf_field() ?>

                <div class="form-grid">
                    <div class="input-group">
                        <label>Email</label>
                        <input 
                            class="input" 
                            type="email" 
                            name="email" 
                            value="<?= esc($user['email'] ?? session('email') ?? '') ?>" 
                            required
                        >
                    </div>

                    <div class="input-group">
                        <label>Nom d'utilisateur</label>
                        <input 
                            class="input" 
                            type="text" 
                            name="username" 
                            value="<?= esc($client['name'] ?? session('username') ?? '') ?>" 
                            required
                        >
                    </div>
                </div>

                <div class="form-grid">
                    <div class="input-group">
                        <label>Téléphone</label>
                        <input 
                            class="input" 
                            type="text" 
                            name="phone" 
                            value="<?= esc(($client['phone'] ?? '') === '0' ? '' : ($client['phone'] ?? '')) ?>"
                        >
                    </div>

                    <div class="input-group">
                        <label>Genre</label>
                        <select class="select" name="genre" required>
                            <option value="">Choisir</option>
                            <option value="H" <?= (($client['genre'] ?? '') === 'H') ? 'selected' : '' ?>>
                                Homme
                            </option>
                            <option value="F" <?= (($client['genre'] ?? '') === 'F') ? 'selected' : '' ?>>
                                Femme
                            </option>
                        </select>
                    </div>
                </div>

                <div class="form-grid">
                    <div class="input-group">
                        <label>Taille en cm</label>
                        <input 
                            class="input" 
                            type="number" 
                            step="0.01" 
                            min="50" 
                            max="250" 
                            name="taille" 
                            value="<?= esc($client['taille'] ?? '') ?>" 
                            required
                        >
                    </div>

                    <div class="input-group">
                        <label>Poids en kg</label>
                        <input 
                            class="input" 
                            type="number" 
                            step="0.01" 
                            min="10" 
                            max="300" 
                            name="poids" 
                            value="<?= esc($client['poids'] ?? '') ?>" 
                            required
                        >
                    </div>
                </div>

                <button class="btn btn-primary full" type="submit">
                    <i class="fa-solid fa-floppy-disk"></i>
                    Enregistrer les modifications
                </button>
            </form>
        </article>

        <article class="card pad">
            <h3>Résumé du compte</h3>

            <div class="metric-grid" style="grid-template-columns:1fr;">
                <div class="metric">
                    <strong><?= esc(number_format((float) ($client['wallet'] ?? 0), 0, ',', ' ')) ?> Ar</strong>
                    <span>Solde wallet</span>
                </div>

                <div class="metric">
                    <strong><?= !empty($client['is_gold']) ? 'Gold' : 'Standard' ?></strong>
                    <span>Type de compte</span>
                </div>

                <div class="metric">
                    <strong><?= esc($client['age'] ?? '-') ?></strong>
                    <span>Âge</span>
                </div>
            </div>
        </article>

        <article class="card pad">
            <h3>Option Gold</h3>

            <p style="color:var(--muted);line-height:1.7;margin-bottom:18px;">
                L’option Gold donne une remise de 
                <strong><?= esc((string) ((float) ($gold_reduction ?? 15))) ?>%</strong>
                sur tous les régimes. Elle est payée une seule fois.
            </p>

            <p style="margin-bottom:18px;">
                Prix :
                <strong>
                    <?= esc(number_format((float) ($prix_gold ?? 50000), 0, ',', ' ')) ?> Ar
                </strong>
            </p>

            <?php if (!empty($client['is_gold'])): ?>
                <p class="alert alert-success">
                    Votre option Gold est déjà active.
                </p>
            <?php else: ?>
                <form method="post" action="<?= site_url('profil/gold') ?>">
                    <?= csrf_field() ?>

                    <button class="btn btn-green" type="submit">
                        <i class="fa-solid fa-crown"></i>
                        Activer Gold
                    </button>
                </form>
            <?php endif; ?>
        </article>

        <article class="card pad">
            <h3>Détails santé</h3>

            <?php
                $imc = null;

                if (!empty($client['poids']) && !empty($client['taille'])) {
                    $tailleM = ((float) $client['taille']) / 100;

                    if ($tailleM > 0) {
                        $imc = round(((float) $client['poids']) / ($tailleM * $tailleM), 2);
                    }
                }
            ?>

            <div class="admin-table-wrap">
                <table class="admin-table">
                    <tbody>
                        <tr>
                            <th>Nom</th>
                            <td><?= esc($client['name'] ?? '-') ?></td>
                        </tr>

                        <tr>
                            <th>Email</th>
                            <td><?= esc($user['email'] ?? '-') ?></td>
                        </tr>

                        <tr>
                            <th>Téléphone</th>
                            <td><?= esc($client['phone'] ?? '-') ?></td>
                        </tr>

                        <tr>
                            <th>Genre</th>
                            <td><?= esc($client['genre'] ?? '-') ?></td>
                        </tr>

                        <tr>
                            <th>Date de naissance</th>
                            <td><?= esc($client['date_naissance'] ?? '-') ?></td>
                        </tr>

                        <tr>
                            <th>Taille</th>
                            <td><?= esc($client['taille'] ?? '-') ?> cm</td>
                        </tr>

                        <tr>
                            <th>Poids</th>
                            <td><?= esc($client['poids'] ?? '-') ?> kg</td>
                        </tr>

                        <tr>
                            <th>IMC actuel</th>
                            <td><?= esc((string) ($imc ?? '-')) ?></td>
                        </tr>

                        <tr>
                            <th>Dernier objectif</th>
                            <td><?= esc((string) (session('last_objectif_name') ?? '-')) ?></td>
                        </tr>

                        <tr>
                            <th>Objectif kg</th>
                            <td><?= esc((string) (session('last_objectif_kg') ?? '-')) ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </article>

    </div>
</section>

<?= $this->endSection() ?>