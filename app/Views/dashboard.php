<?php ob_start(); ?>
<div class="card">
  <h1>Dashboard Admin</h1>
  <p class="muted">Accès rapide aux sections principales.</p>
  <div class="actions">
    <a class="btn btn-primary" href="<?= site_url('/ingredient') ?>">Ingrédients</a>
    <a class="btn btn-green" href="<?= site_url('/regime/create') ?>">Créer un régime</a>
    <a class="btn btn-light" href="<?= site_url('/regime/list') ?>">Voir régimes</a>
    <a class="btn btn-light" href="<?= site_url('/sport') ?>">Sports</a>
  </div>
</div>
<?php $content = ob_get_clean(); echo view('template/base', ['title' => 'Dashboard', 'content' => $content]); ?>
