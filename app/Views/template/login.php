<?php ob_start(); ?>
<div class="card" style="max-width:460px;">
  <h1>Connexion</h1>
  <p class="muted">Connectez-vous pour continuer.</p>
  <?php if (session()->getFlashdata('error')): ?><div class="alert alert-error"><?= esc(session()->getFlashdata('error')) ?></div><?php endif; ?>
  <?php if (session()->getFlashdata('success')): ?><div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div><?php endif; ?>
  <form method="post" action="<?= site_url('/validationLogin') ?>" class="row-1">
    <?= csrf_field() ?>
    <div><label for="email">Email</label><input id="email" type="email" name="email" required></div>
    <div><label for="pwd">Mot de passe</label><input id="pwd" type="password" name="pwd" required></div>
    <div class="actions"><button class="btn btn-primary" type="submit">Se connecter</button><a class="btn btn-light" href="<?= site_url('/inscription') ?>">Créer un compte</a></div>
  </form>
</div>
<?php $content = ob_get_clean(); echo view('template/base', ['title' => 'Connexion', 'content' => $content]); ?>
