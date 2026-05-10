<?php ob_start(); ?>
<div class="card" style="max-width:640px;">
  <h1>Inscription - Étape 1</h1>
  <?php if (session()->getFlashdata('error')): ?><div class="alert alert-error"><?= esc(session()->getFlashdata('error')) ?></div><?php endif; ?>
  <form action="<?= site_url('/step2') ?>" method="post" class="row-1">
    <?= csrf_field() ?>
    <div><label>Email</label><input type="email" name="email" value="<?= esc((string) session('email')) ?>" required></div>
    <div><label>Nom d'utilisateur</label><input type="text" name="name" value="<?= esc((string) session('name')) ?>" required></div>
    <div><label>Mot de passe</label><input type="password" name="pwd" required></div>
    <div class="actions"><button class="btn btn-primary" type="submit">Suivant</button><a class="btn btn-light" href="<?= site_url('/login') ?>">Retour</a></div>
  </form>
</div>
<?php $content = ob_get_clean(); echo view('template/base', ['title' => 'Inscription', 'content' => $content]); ?>
