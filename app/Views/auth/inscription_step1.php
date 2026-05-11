<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<section class="section">
    <div class="container">
        <article class="card pad" data-animate="fade-up" style="max-width:720px;margin:auto;">
            <span class="badge" data-animate="slide-right" data-delay="100">
                <i class="fa-solid fa-user-plus"></i>
                Étape 1 / 2
            </span>

            <h1 data-animate="slide-right" data-delay="180" style="margin:16px 0;color:var(--purple);">Informations de connexion</h1>

            <form method="post" action="<?= site_url('step2') ?>">
                <?= csrf_field() ?>

                <div class="form-grid">
                    <div class="input-group" data-animate="fade-up" data-delay="260">
                        <label>Nom d'utilisateur</label>
                        <input class="input" type="text" name="username" value="<?= esc((string) session('username')) ?>" required>
                    </div>

                    <div class="input-group" data-animate="fade-up" data-delay="340">
                        <label>Email</label>
                        <input class="input" type="email" name="email" value="<?= esc((string) session('email')) ?>" required>
                    </div>
                </div>

                <div class="input-group" data-animate="fade-up" data-delay="420">
                    <label>Mot de passe</label>
                    <div style="position:relative;">
                        <input class="input" type="password" name="pwd" id="pwdField" style="padding-right:44px;" required>
                        <button type="button" id="togglePwdBtn" aria-label="Afficher le mot de passe" style="position:absolute;right:10px;top:50%;transform:translateY(-50%);border:none;background:transparent;color:var(--purple);cursor:pointer;">
                            <i class="fa-solid fa-eye"></i>
                        </button>
                    </div>
                </div>

                <button class="btn btn-primary full" type="submit" data-animate="fade-up" data-delay="580">
                    Continuer
                    <i class="fa-solid fa-arrow-right"></i>
                </button>
            </form>
        </article>
    </div>
</section>

<script>
    (function () {
        const pwd = document.getElementById('pwdField');
        const btn = document.getElementById('togglePwdBtn');
        if (!pwd || !btn) return;

        btn.addEventListener('click', function () {
            const isHidden = pwd.type === 'password';
            pwd.type = isHidden ? 'text' : 'password';
            btn.setAttribute('aria-label', isHidden ? 'Masquer le mot de passe' : 'Afficher le mot de passe');
            btn.innerHTML = isHidden
                ? '<i class="fa-solid fa-eye-slash"></i>'
                : '<i class="fa-solid fa-eye"></i>';
        });
    })();
</script>

<?= $this->endSection() ?>
