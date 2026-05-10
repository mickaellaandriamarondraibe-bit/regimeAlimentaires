<?php ob_start(); ?>
<div class="card">
  <h1>Ingrédients</h1>
  <form action="<?= site_url('/ingredient/create') ?>" method="post" class="row" style="margin-bottom:16px;">
    <?= csrf_field() ?>
    <div><label>Nom ingrédient</label><input type="text" name="name" required></div>
    <div class="actions" style="align-items:end;"><button class="btn btn-primary" type="submit">Ajouter</button></div>
  </form>
  <table><thead><tr><th>Nom</th></tr></thead><tbody><?php foreach ($ingredients as $item): ?><tr><td><?= esc($item['name']) ?></td></tr><?php endforeach; ?></tbody></table>
</div>
<?php $content = ob_get_clean(); echo view('template/base', ['title' => 'Ingrédients', 'content' => $content]); ?>
