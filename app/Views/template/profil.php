<?php ob_start(); ?>
<div class="card" style="max-width:860px;">
  <h1>Mon profil</h1>
  <?php if (session()->getFlashdata('success')): ?><div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div><?php endif; ?>
  <?php if (session()->getFlashdata('error')): ?><div class="alert alert-error"><?= esc(session()->getFlashdata('error')) ?></div><?php endif; ?>
  <form action="<?= site_url('/profil/update') ?>" method="post" class="row">
    <?= csrf_field() ?>
    <div><label>Email</label><input type="email" name="email" value="<?= esc($user['email'] ?? '') ?>" required></div>
    <div><label>Nom d'utilisateur</label><input type="text" name="username" value="<?= esc($client['name'] ?? session('username') ?? '') ?>" required></div>
    <div><label>Téléphone</label><input type="text" name="phone" value="<?= esc(($client['phone'] ?? '') === '0' ? '' : ($client['phone'] ?? '')) ?>"></div>
    <div><label>Genre</label><select name="genre" required><option value="">Choisir</option><option value="H" <?= ($client['genre'] ?? '')==='H'?'selected':'' ?>>Homme</option><option value="F" <?= ($client['genre'] ?? '')==='F'?'selected':'' ?>>Femme</option></select></div>
    <div><label>Taille (cm)</label><input type="number" step="0.01" min="50" max="250" name="taille" value="<?= esc($client['taille'] ?? '') ?>" required></div>
    <div><label>Poids (kg)</label><input type="number" step="0.01" min="10" max="300" name="poids" value="<?= esc($client['poids'] ?? '') ?>" required></div>
    <div class="actions" style="grid-column:1/-1;"><button class="btn btn-primary" type="submit">Enregistrer</button></div>
  </form>
</div>
<?php $content = ob_get_clean(); echo view('template/base', ['title' => 'Profil', 'content' => $content]); ?>
