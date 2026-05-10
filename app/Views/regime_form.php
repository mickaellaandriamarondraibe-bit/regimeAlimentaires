<?php $errors = session()->getFlashdata('errors') ?? []; ob_start(); ?>
<div class="card">
  <h1>Créer un régime</h1>
  <form action="<?= site_url('/regime/create') ?>" method="post" class="row-1">
    <?= csrf_field() ?>
    <div><label>Nom</label><input type="text" name="regime_name" value="<?= esc((string) old('regime_name')) ?>" required></div>
    <div><label>Variation du poids / semaine</label><input type="number" step="any" name="variation_poids_semaine" value="<?= esc((string) old('variation_poids_semaine')) ?>" required></div>
    <div><label>Description</label><textarea name="description"><?= esc((string) old('description')) ?></textarea></div>
    <h2>Compositions (%)</h2>
    <div class="row">
      <?php foreach ($ingredients as $item): ?>
      <div><label><?= esc($item['name']) ?></label><input type="number" step="any" name="pourcentage_<?= esc($item['name']) ?>" value="<?= esc((string) old('pourcentage_' . $item['name'], '0')) ?>"></div>
      <?php endforeach; ?>
    </div>
    <h2>Prix</h2>
    <div id="prix-zone" class="row-1"><div class="row"><div><label>Semaine</label><input type="number" name="semaine[]" required></div><div><label>Prix</label><input type="number" step="any" name="prix[]" required></div></div></div>
    <div class="actions"><button class="btn btn-light" type="button" onclick="addRow()">Ajouter semaine</button><button class="btn btn-primary" type="submit">Enregistrer</button></div>
  </form>
</div>
<script>function addRow(){const z=document.getElementById('prix-zone');const d=document.createElement('div');d.className='row';d.innerHTML='<div><label>Semaine</label><input type="number" name="semaine[]" required></div><div><label>Prix</label><input type="number" step="any" name="prix[]" required></div>';z.appendChild(d);}</script>
<?php $content = ob_get_clean(); echo view('template/base', ['title' => 'Créer régime', 'content' => $content]); ?>
