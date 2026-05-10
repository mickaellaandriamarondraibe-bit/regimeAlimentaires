<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<section class="section">
    <div class="container">
        <article class="card pad" style="max-width:720px;margin:auto;">
            <span class="badge">
                <i class="fa-solid fa-heart-pulse"></i>
                Étape 2 / 2
            </span>

            <h1 style="margin:16px 0;color:var(--purple);">Informations de santé</h1>

            <form method="post" action="<?= site_url('register') ?>">
                <?= csrf_field() ?>

                <div class="form-grid">
                    <div class="input-group">
                        <label>Téléphone</label>
                        <input class="input" type="text" name="phone" value="<?= esc((string) session('phone')) ?>">
                    </div>

                    <div class="input-group">
                        <label>Date de naissance</label>
                        <input class="input" type="date" name="date_naissance" value="<?= esc((string) session('date_naissance')) ?>" required>
                    </div>
                </div>

                <div class="form-grid">
                    <div class="input-group">
                        <label>Âge</label>
                        <input class="input" type="number" name="age" min="1" value="<?= esc((string) session('age')) ?>" required>
                    </div>

                    <div class="input-group">
                        <label>Genre</label>
                        <select class="select" name="genre" required>
                            <option value="">Choisir</option>
                            <option value="H" <?= session('genre') === 'H' ? 'selected' : '' ?>>Homme</option>
                            <option value="F" <?= session('genre') === 'F' ? 'selected' : '' ?>>Femme</option>
                        </select>
                    </div>

                    <div class="input-group">
                        <label>Taille en cm</label>
                        <input class="input" type="number" step="0.01" name="taille" value="<?= esc((string) session('taille')) ?>" required>
                    </div>
                </div>

                <div class="input-group">
                    <label>Poids en kg</label>
                    <input class="input" type="number" step="0.01" name="poids" value="<?= esc((string) session('poids')) ?>" required>
                </div>

                <button class="btn btn-green full" type="submit">
                    Finaliser l'inscription
                    <i class="fa-solid fa-check"></i>
                </button>
            </form>
        </article>
    </div>
</section>

<?= $this->endSection() ?>