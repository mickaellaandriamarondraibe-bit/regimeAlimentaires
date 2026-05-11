<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<section class="section">
    <div class="container">
        <article class="card pad" data-animate="fade-up" style="max-width:720px;margin:auto;">
            <span class="badge" data-animate="slide-right" data-delay="100">
                <i class="fa-solid fa-heart-pulse"></i>
                Étape 2 / 2
            </span>

            <h1 data-animate="slide-right" data-delay="180" style="margin:16px 0;color:var(--purple);">Informations personnelles</h1>

            <form method="post" action="<?= site_url('register') ?>">
                <?= csrf_field() ?>

                <div class="form-grid">
                    <div class="input-group" data-animate="fade-up" data-delay="260">
                        <label>Téléphone</label>
                        <input class="input" type="text" name="phone" value="<?= esc((string) session('phone')) ?>">
                    </div>

                    <div class="input-group" data-animate="fade-up" data-delay="340">
                        <label>Date de naissance</label>
                        <input class="input" type="date" name="date_naissance" value="<?= esc((string) session('date_naissance')) ?>">
                    </div>

                    <div class="input-group" data-animate="fade-up" data-delay="420">
                        <label>Genre</label>
                        <select class="select" name="genre">
                            <option value="">Choisir</option>
                            <option value="H" <?= session('genre') === 'H' ? 'selected' : '' ?>>Homme</option>
                            <option value="F" <?= session('genre') === 'F' ? 'selected' : '' ?>>Femme</option>
                        </select>
                    </div>
                </div>

                <div class="form-grid">
                    <div class="input-group" data-animate="fade-up" data-delay="500">
                        <label>Taille en cm</label>
                        <input class="input" type="number" step="0.01" name="taille" value="<?= esc((string) session('taille')) ?>">
                    </div>
                </div>

                <div class="input-group" data-animate="fade-up" data-delay="580">
                    <label>Poids en kg</label>
                    <input class="input" type="number" step="0.01" name="poids" value="<?= esc((string) session('poids')) ?>">
                </div>

                <div class="form-grid">
                    <button class="btn btn-secondary full" type="button" onclick="submitBackForm()" data-animate="fade-up" data-delay="660">
                        <i class="fa-solid fa-arrow-left"></i>
                        Retour
                    </button>
                    <button class="btn btn-green full" type="submit" data-animate="fade-up" data-delay="740">
                        Finaliser l'inscription
                        <i class="fa-solid fa-check"></i>
                    </button>
                </div>
            </form>

            <form id="backForm" method="post" action="<?= site_url('back-to-step1') ?>" style="display:none;">
                <?= csrf_field() ?>
                <input type="hidden" name="phone" value="<?= esc((string) session('phone')) ?>">
                <input type="hidden" name="date_naissance" value="<?= esc((string) session('date_naissance')) ?>">
                <input type="hidden" name="genre" value="<?= esc((string) session('genre')) ?>">
                <input type="hidden" name="taille" value="<?= esc((string) session('taille')) ?>">
                <input type="hidden" name="poids" value="<?= esc((string) session('poids')) ?>">
            </form>

            <script>
                function submitBackForm() {
                    // Récupérer les valeurs des inputs visibles
                    const form = document.querySelector('form');
                    const backForm = document.getElementById('backForm');
                    
                    // Copier les valeurs actuelles des champs
                    backForm.querySelector('input[name="phone"]').value = form.querySelector('input[name="phone"]').value;
                    backForm.querySelector('input[name="date_naissance"]').value = form.querySelector('input[name="date_naissance"]').value;
                    backForm.querySelector('input[name="genre"]').value = form.querySelector('select[name="genre"]').value;
                    backForm.querySelector('input[name="taille"]').value = form.querySelector('input[name="taille"]').value;
                    backForm.querySelector('input[name="poids"]').value = form.querySelector('input[name="poids"]').value;
                    
                    backForm.submit();
                }
            </script>
        </article>
    </div>
</section>

<?= $this->endSection() ?>
