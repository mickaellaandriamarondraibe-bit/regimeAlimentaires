<?php ob_start(); ?>
<div class="card" style="max-width:560px;">
  <h1>Valider un code</h1>
  <?php if (session()->getFlashdata('error')): ?><div class="alert alert-error"><?= esc(session()->getFlashdata('error')) ?></div><?php endif; ?>
  <?php if (session()->getFlashdata('success')): ?><div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div><?php endif; ?>
  <form action="<?= site_url('/envoyerCode') ?>" method="post" class="row-1">
    <?= csrf_field() ?>
    <div><label for="code">Code</label><input type="text" name="code" id="code" required></div>
    <div class="actions"><button class="btn btn-green" type="submit">Envoyer</button><a class="btn btn-light" href="<?= site_url('/acceuil') ?>">Retour</a></div>
  </form>
</div>
<?php $content = ob_get_clean(); echo view('template/base', ['title' => 'Code', 'content' => $content]); ?>
