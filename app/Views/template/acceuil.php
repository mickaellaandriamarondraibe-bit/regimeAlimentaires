<?php ob_start(); ?>
<div class="card">
  <h1>Bienvenue <?= esc((string) session('name')) ?></h1>
  <p class="muted">Choisissez une action rapide.</p>
  <div class="actions">
    <a class="btn btn-primary" href="<?= site_url('/profil') ?>">Mon profil</a>
    <a class="btn btn-green" href="<?= site_url('/code') ?>">Entrer un code</a>
    <a class="btn btn-light" href="<?= site_url('/test') ?>">Faire un achat</a>
  </div>
</div>
<?php $content = ob_get_clean(); echo view('template/base', ['title' => 'Accueil', 'content' => $content]); ?>
