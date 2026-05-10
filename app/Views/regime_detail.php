<?php ob_start(); ?>
<div class="card">
  <h1><?= esc($regime['name']) ?></h1>
  <p class="muted"><?= esc($regime['description']) ?></p>
  <p><strong>Variation:</strong> <?= esc($regime['variation_poids_semaine']) ?> kg/semaine</p>
  <h2>Compositions</h2>
  <table><thead><tr><th>Ingrédient</th><th>%</th></tr></thead><tbody><?php foreach (($regime['compositions'] ?? []) as $c): ?><tr><td><?= esc($c['ingredient_name']) ?></td><td><?= esc($c['pourcentage']) ?></td></tr><?php endforeach; ?></tbody></table>
  <h2 style="margin-top:16px;">Prix</h2>
  <table><thead><tr><th>Semaine</th><th>Prix</th></tr></thead><tbody><?php foreach (($regime['prix'] ?? []) as $p): ?><tr><td><?= esc($p['duree_semaine']) ?></td><td><?= esc($p['prix']) ?> Ar</td></tr><?php endforeach; ?></tbody></table>
  <div class="actions"><a class="btn btn-light" href="<?= site_url('/regime/list') ?>">Retour</a></div>
</div>
<?php $content = ob_get_clean(); echo view('template/base', ['title' => 'Détail régime', 'content' => $content]); ?>
