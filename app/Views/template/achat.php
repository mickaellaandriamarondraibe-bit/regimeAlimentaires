<?php ob_start(); ?>
<div class="card" style="max-width:560px;">
  <h1>Achat</h1>
  <?php if (session()->getFlashdata('error')): ?><div class="alert alert-error"><?= esc(session()->getFlashdata('error')) ?></div><?php endif; ?>
  <?php if (session()->getFlashdata('success')): ?><div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div><?php endif; ?>
  <form action="<?= site_url('/achat') ?>" method="post" class="row-1">
    <?= csrf_field() ?>
    <div><label for="prix">Prix</label><input type="number" name="prix" id="prix" min="1" step="0.01" required></div>
    <div class="actions"><button class="btn btn-primary" type="submit">Acheter</button></div>
  </form>
</div>
<?php $content = ob_get_clean(); echo view('template/base', ['title' => 'Achat', 'content' => $content]); ?>
