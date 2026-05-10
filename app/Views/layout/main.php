<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'NutriFit') ?></title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link rel="stylesheet" href="<?= base_url('assets/css/nutrifit.css') ?>">
</head>

<body>

    <?= $this->include('layout/header') ?>

    <main>
        <?= $this->include('layout/alerts') ?>
        <?= $this->renderSection('content') ?>
    </main>

    <?= $this->include('layout/footer') ?>

    <script>
        window.NUTRIFIT_OBJECTIFS = <?= json_encode($objectifs ?? [], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>;
        window.NUTRIFIT_TX_BY_TYPE = <?= json_encode($tx_by_type ?? [], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>;
        window.NUTRIFIT_USERS_BY_ROLE = <?= json_encode($users_by_role ?? [], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>;
    </script>

    <script src="/assets/js/plugin/chart.js/chart.min.js"></script>
    <script src="<?= base_url('assets/js/nutrifit.js') ?>"></script>
</body>

</html>