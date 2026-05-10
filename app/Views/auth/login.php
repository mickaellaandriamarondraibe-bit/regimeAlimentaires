<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<section class="section">
    <div class="container">
        <article class="card pad" style="max-width:520px;margin:auto;">
            <span class="badge">
                <i class="fa-solid fa-right-to-bracket"></i>
                Connexion
            </span>

            <h1 style="margin:16px 0;color:var(--purple);">Bon retour sur NutriFit</h1>
            <p style="margin-bottom:22px;color:var(--muted);">
                Connectez-vous pour accéder à votre profil, vos programmes et votre wallet.
            </p>

            <form method="post" action="<?= site_url('validationLogin') ?>">
                <?= csrf_field() ?>

                <div class="input-group">
                    <label>Email</label>
                    <input class="input" type="email" name="email" required>
                </div>

                <div class="input-group">
                    <label>Mot de passe</label>
                    <input class="input" type="password" name="pwd" required>
                </div>

                <button class="btn btn-primary full" type="submit">
                    Se connecter
                    <i class="fa-solid fa-arrow-right"></i>
                </button>
            </form>

            <p style="text-align:center;margin-top:18px;">
                Pas encore inscrit ?
                <a href="<?= site_url('inscription') ?>" style="color:var(--pink);font-weight:900;">
                    Créer un compte
                </a>
            </p>
        </article>
    </div>
</section>

<?= $this->endSection() ?>