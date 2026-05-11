<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<section class="section">
    <div class="container">
        <article class="card pad" data-animate="fade-up" style="max-width:520px;margin:auto;">
            <span class="badge" data-animate="slide-right" data-delay="100">
                <i class="fa-solid fa-right-to-bracket"></i>
                Connexion
            </span>

            <h1 data-animate="slide-right" data-delay="180" style="margin:16px 0;color:var(--purple);">Bon retour sur NutriFit</h1>
            <p data-animate="slide-right" data-delay="260" style="margin-bottom:22px;color:var(--muted);">
                Connectez-vous pour accéder à votre profil, vos programmes et votre wallet.
            </p>

            <form method="post" action="<?= site_url('validationLogin') ?>">
                <?= csrf_field() ?>

                <div class="input-group" data-animate="fade-up" data-delay="340">
                    <label>Email</label>
                    <input class="input" type="email" name="email" required>
                </div>

                <div class="input-group" data-animate="fade-up" data-delay="420">
                    <label>Mot de passe</label>
                    <input class="input" type="password" name="pwd" required>
                </div>

                <button class="btn btn-primary full" type="submit" data-animate="fade-up" data-delay="500">
                    Se connecter
                    <i class="fa-solid fa-arrow-right"></i>
                </button>

                <button class="btn btn-secondary full admin-connex" data-animate="fade-up" data-delay="500">
                    Se connecter en tant qu'admin
                </button>
            </form>

            <p data-animate="fade-up" data-delay="580" style="text-align:center;margin-top:18px;">
                Pas encore inscrit ?
                <a href="<?= site_url('inscription') ?>" style="color:var(--pink);font-weight:900;">
                    Créer un compte
                </a>
            </p>
        </article>
    </div>
</section>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const adminBtn = document.querySelector(".admin-connex");
    const emailInput = document.querySelector("input[name='email']");
    const pwdInput = document.querySelector("input[name='pwd']");

    adminBtn.addEventListener("click", (e) => {
        e.preventDefault();

        emailInput.value = "admin@nutrifit.mg";
        pwdInput.value = "nutrifit5050admin";
    });
});
</script>

<?= $this->endSection() ?>