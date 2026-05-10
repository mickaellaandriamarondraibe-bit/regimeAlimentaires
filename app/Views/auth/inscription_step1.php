<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<section class="section">
    <div class="container">
        <article class="card pad" style="max-width:720px;margin:auto;">
            <span class="badge">
                <i class="fa-solid fa-user-plus"></i>
                Étape 1 / 2
            </span>

            <h1 style="margin:16px 0;color:var(--purple);">Informations personnelles</h1>

            <form method="post" action="<?= site_url('step2') ?>">
                <?= csrf_field() ?>

                <div class="form-grid">
                    <div class="input-group">
                        <label>Nom d'utilisateur</label>
                        <input class="input" type="text" name="username" value="<?= esc((string) session('username')) ?>" required>
                    </div>

                    <div class="input-group">
                        <label>Email</label>
                        <input class="input" type="email" name="email" value="<?= esc((string) session('email')) ?>" required>
                    </div>
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
                    <label>Mot de passe</label>
                    <input class="input" type="password" name="pwd" required>
                </div>

                <button class="btn btn-primary full" type="submit">
                    Continuer
                    <i class="fa-solid fa-arrow-right"></i>
                </button>
            </form>
        </article>
    </div>
</section>

<?= $this->endSection() ?>