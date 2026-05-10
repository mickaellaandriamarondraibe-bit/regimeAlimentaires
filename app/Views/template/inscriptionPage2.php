<?php ob_start(); ?>
<div class="card" style="max-width:760px;">
  <h1>Inscription - Étape 2</h1>
  <?php if (session()->getFlashdata('error')): ?><div class="alert alert-error"><?= esc(session()->getFlashdata('error')) ?></div><?php endif; ?>
  <form action="<?= site_url('/register') ?>" method="post" class="row">
    <?= csrf_field() ?>
    <div><label>Téléphone</label><input type="text" name="phone" value="<?= esc((string) session('phone')) ?>"></div>
    <div><label>Genre</label><select name="genre" required><option value="">Choisir</option><option value="H" <?= session('genre')==='H'?'selected':'' ?>>Homme</option><option value="F" <?= session('genre')==='F'?'selected':'' ?>>Femme</option></select></div>
    <div><label>Date naissance</label><input type="date" name="date_naissance" value="<?= esc((string) session('date_naissance')) ?>" required></div>
    <div><label>Age</label><input type="number" min="1" name="age" value="<?= esc((string) session('age')) ?>" required></div>
    <div><label>Taille (cm)</label><input type="number" step="0.01" min="50" name="taille" value="<?= esc((string) session('taille')) ?>" required></div>
    <div><label>Poids (kg)</label><input type="number" step="0.01" min="10" name="poids" value="<?= esc((string) session('poids')) ?>" required></div>
    <div class="actions" style="grid-column:1/-1;"><button class="btn btn-primary" type="submit">Créer le compte</button><a class="btn btn-light" href="<?= site_url('/inscription') ?>">Retour</a></div>
  </form>
</div>
<?php $content = ob_get_clean(); echo view('template/base', ['title' => 'Inscription Étape 2', 'content' => $content]); ?>
