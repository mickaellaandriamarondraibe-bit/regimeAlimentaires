<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= esc($title ?? 'NutriFit Admin') ?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
  <style>
    :root{--p:#ff5a1f;--p2:#ff7b2f;--pr:#3b1749;--bg:#f6f0f7;--b:rgba(59,23,73,.12)}
    *{box-sizing:border-box} body{margin:0;font-family:Inter,system-ui,sans-serif;background:var(--bg);color:#3f3b3f}
    .container{max-width:1180px;margin:0 auto;padding:0 20px}
    .nav{position:sticky;top:0;background:#fff;border-bottom:1px solid var(--b);z-index:100}
    .navin{min-height:74px;display:flex;align-items:center;justify-content:space-between;gap:12px}
    .menu{display:flex;gap:10px;flex-wrap:wrap}.menu a{font-weight:800;color:var(--pr);text-decoration:none}
    .main{padding:26px 0 50px}.card{background:#fff;border:1px solid var(--b);border-radius:18px;padding:20px}
    .btn{border:0;border-radius:999px;padding:10px 16px;font-weight:800;cursor:pointer;text-decoration:none;display:inline-block}
    .btn-primary{color:#fff;background:linear-gradient(135deg,var(--p),var(--p2))}
    .btn-light{background:#fff;border:1px solid var(--b);color:var(--pr)}
    .btn-green{color:#fff;background:#16c784}.actions{display:flex;gap:10px;flex-wrap:wrap}
    table{width:100%;border-collapse:collapse}th,td{padding:10px;border-bottom:1px solid var(--b);text-align:left}
    input,select,textarea{width:100%;padding:10px;border:1px solid var(--b);border-radius:10px}
    .row{display:grid;grid-template-columns:1fr 1fr;gap:10px}.row-1{display:grid;grid-template-columns:1fr;gap:10px}
  </style>
</head>
<body>
  <nav class="nav"><div class="container navin">
    <strong style="color:#3b1749">NutriFit Admin</strong>
    <div class="menu">
      <a href="<?= site_url('dashboard') ?>">Dashboard</a>
      <a href="<?= site_url('ingredient') ?>">Ingrédients</a>
      <a href="<?= site_url('regime/list') ?>">Régimes</a>
      <a href="<?= site_url('regime/create') ?>">Créer régime</a>
      <a href="<?= site_url('admin/transactions') ?>">Transactions</a>
      <a href="<?= site_url('parametres') ?>">Paramètres</a>
      <a href="<?= site_url('acceuil') ?>">Espace client</a>
      <a href="<?= site_url('logout') ?>">Déconnexion</a>
    </div>
  </div></nav>
  <main class="main"><div class="container"><?= $content ?? '' ?></div></main>
</body>
</html>
