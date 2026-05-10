<?php ob_start(); ?>
<div class="card">
  <h1>Liste des régimes</h1>
  <div class="actions"><a class="btn btn-primary" href="<?= site_url('/regime/create') ?>">Créer un régime</a></div>
  <table><thead><tr><th>Nom</th><th>Action</th></tr></thead><tbody>
  <?php foreach ($regimes as $regime): ?>
    <tr><td><?= esc($regime['name']) ?></td><td><a class="btn btn-light" href="<?= site_url('/regime/detail/' . $regime['id']) ?>">Détail</a></td></tr>
  <?php endforeach; ?>
  </tbody></table>
</div>
<?php $content = ob_get_clean(); echo view('template/base', ['title' => 'Régimes', 'content' => $content]); ?>
